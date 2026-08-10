<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class SellerCalculator extends Controller
{
    public function index(): string
    {
        $data = [
            'title'       => 'Online Seller Calculator | Currefy',
            'description' => 'Calculate online selling costs, profit, margin, and break-even price in seconds.',
        ];

        return view('layouts/main', ['content' => view('seller_calculator'), ...$data]);
    }
}
