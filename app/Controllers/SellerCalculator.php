<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\CurrencyModel;

class SellerCalculator extends Controller
{
    public function index(): string
    {
        $currencyModel = new CurrencyModel();
        $data = [
            'title'       => 'Online Seller Calculator | Currefy',
            'description' => 'Calculate online selling costs, profit, margin, and break-even price in seconds.',
            'currencyNames' => $currencyModel->getCurrencyNames(),
        ];

        return view('layouts/main', ['content' => view('seller_calculator', $data), ...$data]);
    }
}
