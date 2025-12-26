<?php

namespace App\Controllers;

use App\Services\AuthService;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    protected AuthService $auth;

    public function __construct()
    {
        $this->auth = new AuthService();
    }
    public function login()
    {
        return view('auth/login');
    }

    public function attempt()
    {
        $data = $this->request->getPost(['email', 'password']);

        if ($this->auth->attemptLogin($data['email'], $data['password'])) {
            return redirect()->to('/dashboard');
        }

        return redirect()->back()->with('error', 'Login Failed');
    }

    public function logout()
    {
        $this->auth->logout();
        return redirect()->to('/login');
    }
}
