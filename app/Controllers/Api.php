<?php

namespace App\Controllers;

use App\Models\CurrencyModel;
use CodeIgniter\Controller;

/**
 * Api Controller - AJAX endpoints for frontend
 * Security: CSRF protection via CI4. All inputs validated. Rate limit recommended via server config.
 * TODO(security): Add rate limiting (e.g., 60 requests/minute per IP) via middleware or web server rules.
 */
class Api extends Controller
{
    public function rates(): \CodeIgniter\HTTP\ResponseInterface
    {
        $model  = new CurrencyModel();
        $rates  = $model->getRates();
        unset($rates['cached_at']);

        return $this->response
            ->setJSON($rates)
            ->setHeader('Cache-Control', 'public, max-age=3600')
            ->setHeader('X-Content-Type-Options', 'nosniff');
    }

    public function currency(): \CodeIgniter\HTTP\ResponseInterface
    {
        $rules = [
            'amount' => 'required|numeric|greater_than[0]|less_than[1000000000]',
            'from'   => 'required|alpha|exact_length[3]',
            'to'     => 'required|alpha|exact_length[3]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON(['success' => false, 'error' => 'Invalid input.'])->setStatusCode(400);
        }

        $model    = new CurrencyModel();
        $amount   = (float) $this->request->getPost('amount');
        $from     = strtoupper($this->request->getPost('from'));
        $to       = strtoupper($this->request->getPost('to'));
        $rateData = $model->getRates();
        $result   = $model->convert($amount, $from, $to, $rateData);

        if ($result === null) {
            return $this->response->setJSON(['success' => false, 'error' => 'Currency not found.'])->setStatusCode(400);
        }

        return $this->response->setJSON([
            'success' => true,
            'result'  => $result,
            'rate'    => round($rateData['rates'][$to] / $rateData['rates'][$from], 6),
            'date'    => $rateData['date'] ?? date('Y-m-d'),
        ]);
    }

    public function convert(): \CodeIgniter\HTTP\ResponseInterface
    {
        return $this->response->setJSON(['success' => false, 'error' => 'Use specific converter endpoints.'])->setStatusCode(400);
    }
}
