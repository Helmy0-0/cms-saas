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

    public function register()
    {
        if (session()->get('is_logged_in')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/register');
    }

    public function attemptRegister()
    {
        $rules = [
            'name' => 'required|alpha_numeric_space|min_length[3]|is_unique[users.name]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => $this->request->getPost('password')
        ];

        if ($this->auth->register($data)){
            return redirect()->to('/login')->with('success', 'Registration Success!');
        }
        return redirect()->back()->withInput()->with('error', 'Registration Failed');
    }
}
