<?php

namespace App\Controllers;

use CodeIgniter\Controller;

/**
 * Weight Controller
 * Converts between weight/mass units.
 * Security: Inputs validated server-side. No database, no file IO with user input.
 */
class Weight extends Controller
{
    /** Weight units and their conversion factor to kilograms (kg) */
    private array $units = [
        'kg'        => ['factor' => 1,              'name' => 'Kilogram',        'symbol' => 'kg'],
        'g'         => ['factor' => 0.001,           'name' => 'Gram',            'symbol' => 'g'],
        'mg'        => ['factor' => 0.000001,        'name' => 'Milligram',       'symbol' => 'mg'],
        'lb'        => ['factor' => 0.45359237,      'name' => 'Pound',           'symbol' => 'lb'],
        'oz'        => ['factor' => 0.028349523125,  'name' => 'Ounce',           'symbol' => 'oz'],
        'stone'     => ['factor' => 6.35029318,      'name' => 'Stone',           'symbol' => 'st'],
        't'         => ['factor' => 1000,            'name' => 'Metric Ton',      'symbol' => 't'],
        'ton_us'    => ['factor' => 907.18474,       'name' => 'US Short Ton',    'symbol' => 'ton'],
        'ton_uk'    => ['factor' => 1016.0469088,    'name' => 'UK Long Ton',     'symbol' => 'lt'],
        'mcg'       => ['factor' => 0.000000001,     'name' => 'Microgram',       'symbol' => 'μg'],
        'ct'        => ['factor' => 0.0002,          'name' => 'Carat',           'symbol' => 'ct'],
        'grain'     => ['factor' => 0.00006479891,   'name' => 'Grain',           'symbol' => 'gr'],
    ];

    public function index(): string
    {
        $data = [
            'title'       => 'Weight Converter - kg, lbs, oz, grams | Currefy',
            'description' => 'Free online weight converter. Convert between kilograms, pounds, ounces, grams, stone, metric tons and more.',
            'units'       => $this->units,
            'lastUpdated' => null,
        ];

        return view('layouts/main', ['content' => view('weight', $data), ...$data]);
    }

    /**
     * AJAX: Convert weight
     * POST /weight/convert
     * Security: CSRF protected. Numeric input validated. Unit validated against whitelist.
     */
    public function convert(): \CodeIgniter\HTTP\ResponseInterface
    {
        $rules = [
            'amount' => 'required|numeric|greater_than_equal_to[0]|less_than[1000000000000]',
            'from'   => 'required|in_list[' . implode(',', array_keys($this->units)) . ']',
            'to'     => 'required|in_list[' . implode(',', array_keys($this->units)) . ']',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'error'   => 'Invalid input.',
            ])->setStatusCode(400);
        }

        $amount = (float) $this->request->getPost('amount');
        $from   = $this->request->getPost('from');
        $to     = $this->request->getPost('to');

        // Convert to kg, then to target unit
        $inKg   = $amount * $this->units[$from]['factor'];
        $result = $inKg / $this->units[$to]['factor'];

        return $this->response->setJSON([
            'success' => true,
            'result'  => $result,
            'from'    => $this->units[$from],
            'to'      => $this->units[$to],
            'amount'  => $amount,
        ]);
    }
}
