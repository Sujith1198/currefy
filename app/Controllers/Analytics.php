<?php

namespace App\Controllers;

use App\Models\AnalyticsModel;
use CodeIgniter\Controller;

class Analytics extends Controller
{
    public function track(): \CodeIgniter\HTTP\ResponseInterface
    {
        $payload = [
            'action' => in_array($this->request->getPost('action'), ['start', 'heartbeat', 'end'], true) ? $this->request->getPost('action') : 'heartbeat',
            'visitor_key' => substr(preg_replace('/[^a-zA-Z0-9_-]/', '', (string) $this->request->getPost('visitor_key')), 0, 64),
            'visit_token' => substr(preg_replace('/[^a-zA-Z0-9_-]/', '', (string) $this->request->getPost('visit_token')), 0, 64),
            'page_path' => substr((string) $this->request->getPost('page_path'), 0, 255),
            'page_title' => substr((string) $this->request->getPost('page_title'), 0, 255),
            'duration_seconds' => (int) $this->request->getPost('duration_seconds'),
            'ip_address' => $this->request->getIPAddress(),
            'country_code' => substr((string) ($this->request->getHeaderLine('CF-IPCountry') ?: $this->request->getHeaderLine('X-Country-Code') ?: 'Unknown'), 0, 8),
            'user_agent' => substr((string) $this->request->getUserAgent(), 0, 1000),
        ];

        if ($payload['visitor_key'] === '' || $payload['page_path'] === '') {
            return $this->response->setJSON(['success' => false])->setStatusCode(400);
        }

        try {
            (new AnalyticsModel())->record($payload);
        } catch (\Throwable $exception) {
            log_message('error', 'Analytics tracking failed: ' . $exception->getMessage());
        }

        return $this->response->setJSON(['success' => true]);
    }

    public function index(): string
    {
        $data = (new AnalyticsModel())->dashboard();
        return view('admin/analytics', $data + ['title' => 'Visitor Analytics | Currefy', 'adminEmail' => session('admin_email')]);
    }
}
