<?php

class AuthController extends Controller
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle login logic
        }
        return $this->view('auth/login');
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle registration logic
        }
        return $this->view('auth/register');
    }

    public function logout()
    {
        // Handle logout logic
    }
}
