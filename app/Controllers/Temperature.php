<?php

namespace App\Controllers;

use CodeIgniter\Controller;

/**
 * Temperature Controller
 */
class Temperature extends Controller
{
    private array $units = [
        'c'  => ['name' => 'Celsius',    'symbol' => '°C'],
        'f'  => ['name' => 'Fahrenheit', 'symbol' => '°F'],
        'k'  => ['name' => 'Kelvin',     'symbol' => 'K'],
        'r'  => ['name' => 'Rankine',    'symbol' => '°R'],
        're' => ['name' => 'Réaumur',    'symbol' => '°Ré'],
    ];

    public function index(): string
    {
        $data = [
            'title'       => 'Temperature Converter - Celsius, Fahrenheit, Kelvin | Currefy',
            'description' => 'Free online temperature converter. Convert between Celsius, Fahrenheit, Kelvin, Rankine and Réaumur.',
            'units'       => $this->units,
            'lastUpdated' => null,
        ];

        return view('layouts/main', ['content' => view('temperature', $data), ...$data]);
    }

    public function convert(): \CodeIgniter\HTTP\ResponseInterface
    {
        $rules = [
            'amount' => 'required|numeric|greater_than[-1000000]|less_than[1000000]',
            'from'   => 'required|in_list[c,f,k,r,re]',
            'to'     => 'required|in_list[c,f,k,r,re]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON(['success' => false, 'error' => 'Invalid input.'])->setStatusCode(400);
        }

        $amount = (float) $this->request->getPost('amount');
        $from   = $this->request->getPost('from');
        $to     = $this->request->getPost('to');

        // Convert to Celsius first, then to target
        $celsius = $this->toCelsius($amount, $from);
        $result  = $this->fromCelsius($celsius, $to);

        return $this->response->setJSON([
            'success' => true,
            'result'  => round($result, 6),
            'from'    => $this->units[$from],
            'to'      => $this->units[$to],
            'amount'  => $amount,
        ]);
    }

    private function toCelsius(float $val, string $unit): float
    {
        return match($unit) {
            'c'  => $val,
            'f'  => ($val - 32) * 5 / 9,
            'k'  => $val - 273.15,
            'r'  => ($val - 491.67) * 5 / 9,
            're' => $val * 5 / 4,
            default => $val,
        };
    }

    private function fromCelsius(float $c, string $unit): float
    {
        return match($unit) {
            'c'  => $c,
            'f'  => $c * 9 / 5 + 32,
            'k'  => $c + 273.15,
            'r'  => ($c + 273.15) * 9 / 5,
            're' => $c * 4 / 5,
            default => $c,
        };
    }
}
