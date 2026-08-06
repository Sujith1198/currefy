<?php

namespace App\Controllers;

use CodeIgniter\Controller;

/** Area Controller */
class Area extends Controller
{
    /** Conversion factors to square meters */
    private array $units = [
        'm2'    => ['factor' => 1,           'name' => 'Square Meter',    'symbol' => 'm²'],
        'km2'   => ['factor' => 1e6,         'name' => 'Square Kilometer','symbol' => 'km²'],
        'cm2'   => ['factor' => 0.0001,      'name' => 'Square Centimeter','symbol' => 'cm²'],
        'mm2'   => ['factor' => 0.000001,    'name' => 'Square Millimeter','symbol' => 'mm²'],
        'ha'    => ['factor' => 10000,       'name' => 'Hectare',         'symbol' => 'ha'],
        'acre'  => ['factor' => 4046.8564,   'name' => 'Acre',            'symbol' => 'ac'],
        'mi2'   => ['factor' => 2589988.1,   'name' => 'Square Mile',     'symbol' => 'mi²'],
        'yd2'   => ['factor' => 0.83612736,  'name' => 'Square Yard',     'symbol' => 'yd²'],
        'ft2'   => ['factor' => 0.09290304,  'name' => 'Square Foot',     'symbol' => 'ft²'],
        'in2'   => ['factor' => 0.00064516,  'name' => 'Square Inch',     'symbol' => 'in²'],
    ];

    public function index(): string
    {
        $data = [
            'title'       => 'Area Converter - m², acres, hectares | Currefy',
            'description' => 'Free online area converter. Convert between square meters, acres, hectares, square feet, square kilometers and more.',
            'units'       => $this->units,
            'lastUpdated' => null,
        ];

        return view('layouts/main', ['content' => view('area', $data), ...$data]);
    }

    public function convert(): \CodeIgniter\HTTP\ResponseInterface
    {
        $rules = [
            'amount' => 'required|numeric|greater_than_equal_to[0]',
            'from'   => 'required|in_list[' . implode(',', array_keys($this->units)) . ']',
            'to'     => 'required|in_list[' . implode(',', array_keys($this->units)) . ']',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON(['success' => false, 'error' => 'Invalid input.'])->setStatusCode(400);
        }

        $amount  = (float) $this->request->getPost('amount');
        $from    = $this->request->getPost('from');
        $to      = $this->request->getPost('to');
        $inM2    = $amount * $this->units[$from]['factor'];
        $result  = $inM2 / $this->units[$to]['factor'];

        return $this->response->setJSON([
            'success' => true, 'result' => $result,
            'from' => $this->units[$from], 'to' => $this->units[$to], 'amount' => $amount,
        ]);
    }
}
