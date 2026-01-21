<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Auth.php';

class AuthController extends Controller
{
    // GET /auth/login
    public function login()
    {
        $this->view('auth/login', [
            'error' => null
        ]);
    }

    // POST /auth/login
    public function loginPost()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        

        if ($user && password_verify($password, $user['password'])) {
            Auth::login($user);

            if ($user['role'] === 'admin') {
                header('Location: ' . URLROOT . '/public/admin/dashboard/index');
            } else {
                header('Location: ' . URLROOT . '/public/home/index');
            }
            exit;
        }

        // Sai thì quay lại login
        $this->view('auth/login', [
            'error' => 'Wrong email or password'
        ]);
    }

    public function logout()
    {
        Auth::logout();
        header('Location: ' . URLROOT . '/public/home/index');
        exit;
    }
}
