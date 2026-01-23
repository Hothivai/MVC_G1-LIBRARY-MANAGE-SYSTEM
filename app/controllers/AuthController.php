<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Models\User;

class AuthController extends Controller
{
    /* ================= REGISTER ================= */

    // GET /register
    public function register()
    {
        $this->view('auth/register');
    }

    // POST /register
    public function handleRegister()
    {
        $data = [
            'fullname' => trim($_POST['fullname'] ?? ''),
            'phone'    => trim($_POST['phone'] ?? ''),
            'email'    => trim($_POST['email'] ?? ''),
            'password' => $_POST['password'] ?? '',
            'confirm_password' => $_POST['confirm_password'] ?? ''
        ];

        $errors = [];

        // Phone: 10 digits
        if (!preg_match('/^[0-9]{10}$/', $data['phone'])) {
            $errors[] = "Phone number must be exactly 10 digits.";
        }

        // Password rule
        if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&]).{8,}$/', $data['password'])) {
            $errors[] = "Password must be at least 8 characters, include letters, numbers and special characters.";
        }

        if ($data['password'] !== $data['confirm_password']) {
            $errors[] = "Confirm password does not match.";
        }

        if (!empty($errors)) {
            $_SESSION['errors']   = $errors;
            $_SESSION['old_data'] = $data;
            header('Location: /register');
            exit;
        }

        $userModel = new User();

        if ($userModel->findByEmail($data['email'])) {
            $_SESSION['errors']   = ['Email already exists.'];
            $_SESSION['old_data'] = $data;
            header('Location: /register');
            exit;
        }

        $userModel->register($data);
        header('Location: /login');
        exit;
    }

    /* ================= LOGIN ================= */

    // GET /login
    public function login()
    {
        $this->view('auth/login', ['error' => null]);
    }

    // POST /login
    public function handleLogin()
    {
        $email    = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            $this->view('auth/login', [
                'error' => 'Invalid email or password'
            ]);
            return;
        }

        Auth::login($user);

        // Redirect theo role
        if ($user['role'] === 'admin') {
            header('Location: /admin/dashboard');
        } else {
            header('Location: /');
        }
        exit;
    }

    /* ================= LOGOUT ================= */

    // GET /logout
    public function logout()
    {
        Auth::logout();
        header('Location: /');
        exit;
    }
}
