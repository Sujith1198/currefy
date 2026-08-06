<?php

namespace App\Controllers;

use CodeIgniter\Controller;

/**
 * Length Controller
 */
class Length extends Controller
{
    /** Conversion factors to meters */
    private array $units = [
        'm'   => ['factor' => 1,            'name' => 'Meter',           'symbol' => 'm'],
        'km'  => ['factor' => 1000,          'name' => 'Kilometer',       'symbol' => 'km'],
        'cm'  => ['factor' => 0.01,          'name' => 'Centimeter',      'symbol' => 'cm'],
        'mm'  => ['factor' => 0.001,         'name' => 'Millimeter',      'symbol' => 'mm'],
        'um'  => ['factor' => 0.000001,      'name' => 'Micrometer',      'symbol' => 'μm'],
        'nm'  => ['factor' => 0.000000001,   'name' => 'Nanometer',       'symbol' => 'nm'],
        'mi'  => ['factor' => 1609.344,      'name' => 'Mile',            'symbol' => 'mi'],
        'yd'  => ['factor' => 0.9144,        'name' => 'Yard',            'symbol' => 'yd'],
        'ft'  => ['factor' => 0.3048,        'name' => 'Foot',            'symbol' => 'ft'],
        'in'  => ['factor' => 0.0254,        'name' => 'Inch',            'symbol' => 'in'],
        'nmi' => ['factor' => 1852,          'name' => 'Nautical Mile',   'symbol' => 'nmi'],
        'ly'  => ['factor' => 9.461e15,      'name' => 'Light Year',      'symbol' => 'ly'],
        'au'  => ['factor' => 1.496e11,      'name' => 'Astronomical Unit','symbol' => 'AU'],
    ];

    public function index(): string
    {
        $data = [
            'title'       => 'Length Converter - m, km, ft, miles | Currefy',
            'description' => 'Free online length converter. Convert between meters, kilometers, feet, miles, inches, yards, nautical miles and more.',
            'units'       => $this->units,
            'lastUpdated' => null,
        ];

        return view('layouts/main', ['content' => view('length', $data), ...$data]);
    }

    public function convert(): \CodeIgniter\HTTP\ResponseInterface
    {
        $rules = [
            'amount' => 'required|numeric|greater_than_equal_to[0]|less_than[1e20]',
            'from'   => 'required|in_list[' . implode(',', array_keys($this->units)) . ']',
            'to'     => 'required|in_list[' . implode(',', array_keys($this->units)) . ']',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON(['success' => false, 'error' => 'Invalid input.'])->setStatusCode(400);
        }

        $amount = (float) $this->request->getPost('amount');
        $from   = $this->request->getPost('from');
        $to     = $this->request->getPost('to');

        $inMeters = $amount * $this->units[$from]['factor'];
        $result   = $inMeters / $this->units[$to]['factor'];

        return $this->response->setJSON([
            'success' => true,
            'result'  => $result,
            'from'    => $this->units[$from],
            'to'      => $this->units[$to],
            'amount'  => $amount,
        ]);
    }
}
