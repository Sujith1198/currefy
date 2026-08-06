<?php

namespace App\Controllers;

use App\Models\CurrencyModel;
use CodeIgniter\Controller;

/**
 * Home Controller - Landing page with all converter links
 */
class Home extends Controller
{
    public function index(): string
    {
        $currencyModel = new CurrencyModel();
        $data = [
            'title'       => 'Currefy - Currency & Unit Converter',
            'description' => 'Free online currency converter with live exchange rates updated daily. Also convert weight, temperature, length, area, speed, data storage, and more.',
            'lastUpdated' => $currencyModel->getLastUpdated(),
        ];

        return view('layouts/main', ['content' => view('home', $data), ...$data]);
    }
}
