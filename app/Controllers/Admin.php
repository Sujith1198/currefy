<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Admin extends Controller
{
    public function login(): string
    {
        return view('admin/login', [
            'title' => 'Admin Login | Currefy',
            'error' => session()->getFlashdata('error'),
        ]);
    }

    public function authenticate(): \CodeIgniter\HTTP\ResponseInterface
    {
        $email = trim((string) $this->request->getPost('email'));
        $password = (string) $this->request->getPost('password');
        $configuredEmail = (string) env('admin.email', '');
        $configuredHash = (string) env('admin.passwordHash', '');

        if ($configuredEmail === '' || $configuredHash === '' || !hash_equals(strtolower($configuredEmail), strtolower($email)) || !password_verify($password, $configuredHash)) {
            return redirect()->back()->withInput()->with('error', 'Invalid administrator credentials.');
        }

        session()->regenerate(true);
        session()->set(['admin_authenticated' => true, 'admin_email' => $configuredEmail]);
        return redirect()->to(base_url('index.php/admin/analytics'));
    }

    public function logout(): \CodeIgniter\HTTP\ResponseInterface
    {
        session()->destroy();
        return redirect()->to(base_url('index.php/admin/login'));
    }
}
