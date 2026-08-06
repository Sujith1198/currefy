<?php

namespace App\Controllers;

use CodeIgniter\Controller;

/** Speed Controller */
class Speed extends Controller
{
    /** Conversion factors to m/s */
    private array $units = [
        'ms'    => ['factor' => 1,          'name' => 'Meters/Second',   'symbol' => 'm/s'],
        'kmh'   => ['factor' => 0.2777778,  'name' => 'Kilometers/Hour', 'symbol' => 'km/h'],
        'mph'   => ['factor' => 0.44704,    'name' => 'Miles/Hour',      'symbol' => 'mph'],
        'knot'  => ['factor' => 0.5144444,  'name' => 'Knot',            'symbol' => 'kn'],
        'fps'   => ['factor' => 0.3048,     'name' => 'Feet/Second',     'symbol' => 'ft/s'],
        'mach'  => ['factor' => 340.29,     'name' => 'Mach',            'symbol' => 'Ma'],
        'c'     => ['factor' => 299792458,  'name' => 'Speed of Light',  'symbol' => 'c'],
    ];

    public function index(): string
    {
        $data = [
            'title'       => 'Speed Converter - km/h, mph, knots, m/s | Currefy',
            'description' => 'Free online speed converter. Convert between km/h, mph, m/s, knots, Mach and more.',
            'units'       => $this->units,
            'lastUpdated' => null,
        ];

        return view('layouts/main', ['content' => view('speed', $data), ...$data]);
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

        $amount = (float) $this->request->getPost('amount');
        $from   = $this->request->getPost('from');
        $to     = $this->request->getPost('to');
        $inMs   = $amount * $this->units[$from]['factor'];
        $result = $inMs / $this->units[$to]['factor'];

        return $this->response->setJSON([
            'success' => true, 'result' => $result,
            'from' => $this->units[$from], 'to' => $this->units[$to], 'amount' => $amount,
        ]);
    }
}
