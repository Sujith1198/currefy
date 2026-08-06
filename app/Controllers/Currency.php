<?php

namespace App\Controllers;

use App\Models\CurrencyModel;
use CodeIgniter\Controller;

/**
 * Currency Controller
 *
 * Handles currency conversion with daily auto-updated rates from Frankfurter.app.
 * Security: All inputs validated server-side. Output escaped in views.
 */
class Currency extends Controller
{
    private CurrencyModel $currencyModel;

    public function __construct()
    {
        $this->currencyModel = new CurrencyModel();
    }

    /**
     * Main currency converter page
     */
    public function index(): string
    {
        $ratesData = $this->currencyModel->getRates();
        $names     = $this->currencyModel->getCurrencyNames();

        $data = [
            'title'       => 'Currency Converter - Live Exchange Rates | Currefy',
            'description' => 'Convert currencies with live exchange rates updated daily from the European Central Bank. Free currency converter supporting 30+ currencies.',
            'ratesData'   => $ratesData,
            'names'       => $names,
            'lastUpdated' => $this->currencyModel->getLastUpdated(),
        ];

        return view('layouts/main', ['content' => view('currency', $data), ...$data]);
    }

    /**
     * AJAX: Convert currency amounts
     * POST /currency/convert
     *
     * Security: CSRF protected. Inputs strictly validated.
     */
    public function convert(): \CodeIgniter\HTTP\ResponseInterface
    {
        // Validate input
        $rules = [
            'amount' => 'required|numeric|greater_than[0]|less_than[1000000000]',
            'from'   => 'required|alpha|exact_length[3]',
            'to'     => 'required|alpha|exact_length[3]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'error'   => 'Invalid input parameters.',
            ])->setStatusCode(400);
        }

        $validData = $this->validator->getValidated();
        $amount = (float) $validData['amount'];
        $from   = strtoupper($validData['from']);
        $to     = strtoupper($validData['to']);

        $ratesData = $this->currencyModel->getRates();
        $result    = $this->currencyModel->convert($amount, $from, $to, $ratesData);

        if ($result === null) {
            return $this->response->setJSON([
                'success' => false,
                'error'   => 'Currency not supported.',
            ])->setStatusCode(400);
        }

        return $this->response->setJSON([
            'success' => true,
            'result'  => $result,
            'from'    => $from,
            'to'      => $to,
            'amount'  => $amount,
            'rate'    => round($ratesData['rates'][$to] / $ratesData['rates'][$from], 6),
            'date'    => $ratesData['date'] ?? date('Y-m-d'),
        ]);
    }

    /**
     * AJAX: Get current rates JSON
     * GET /currency/rates
     */
    public function rates(): \CodeIgniter\HTTP\ResponseInterface
    {
        $ratesData = $this->currencyModel->getRates();

        // Remove cached_at from public response
        unset($ratesData['cached_at']);

        return $this->response
            ->setJSON($ratesData)
            ->setHeader('Cache-Control', 'public, max-age=3600');
    }
}
