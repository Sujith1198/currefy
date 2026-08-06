<?php

namespace App\Controllers;

use CodeIgniter\Controller;

/** Data Storage Controller */
class DataStorage extends Controller
{
    /** Conversion factors to bytes */
    private array $units = [
        'bit'  => ['factor' => 0.125,         'name' => 'Bit',       'symbol' => 'bit'],
        'b'    => ['factor' => 1,             'name' => 'Byte',      'symbol' => 'B'],
        'kb'   => ['factor' => 1024,          'name' => 'Kilobyte',  'symbol' => 'KB'],
        'mb'   => ['factor' => 1048576,       'name' => 'Megabyte',  'symbol' => 'MB'],
        'gb'   => ['factor' => 1073741824,    'name' => 'Gigabyte',  'symbol' => 'GB'],
        'tb'   => ['factor' => 1.09951e12,    'name' => 'Terabyte',  'symbol' => 'TB'],
        'pb'   => ['factor' => 1.12590e15,    'name' => 'Petabyte',  'symbol' => 'PB'],
        'kib'  => ['factor' => 1024,          'name' => 'Kibibyte',  'symbol' => 'KiB'],
        'mib'  => ['factor' => 1048576,       'name' => 'Mebibyte',  'symbol' => 'MiB'],
        'gib'  => ['factor' => 1073741824,    'name' => 'Gibibyte',  'symbol' => 'GiB'],
        'tib'  => ['factor' => 1.09951e12,    'name' => 'Tebibyte',  'symbol' => 'TiB'],
    ];

    public function index(): string
    {
        $data = [
            'title'       => 'Data Storage Converter - MB, GB, TB | Currefy',
            'description' => 'Free online data storage converter. Convert between bits, bytes, kilobytes, megabytes, gigabytes, terabytes and more.',
            'units'       => $this->units,
            'lastUpdated' => null,
        ];

        return view('layouts/main', ['content' => view('data_storage', $data), ...$data]);
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
        $inBytes = $amount * $this->units[$from]['factor'];
        $result  = $inBytes / $this->units[$to]['factor'];

        return $this->response->setJSON([
            'success' => true, 'result' => $result,
            'from' => $this->units[$from], 'to' => $this->units[$to], 'amount' => $amount,
        ]);
    }
}
