<?php

class AuthController extends Controller
{
    // Hiển thị form login
    public function login()
    {
        $this->view('auth/login');
    }

    // Xử lý submit login
    public function login_handle()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            $this->view('auth/login', [
                'error' => 'Email hoặc mật khẩu không đúng'
            ]);
            return;
        }

        Auth::login($user);

        // Redirect theo role → ACTION
        if ($user['role'] === 'admin') {
            header('Location: /?action=admin_dashboard');
        } else {
            header('Location: /?action=home');
        }
        exit;
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        header('Location: /?action=login');
        exit;
    }
}
