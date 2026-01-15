<?php

class AuthController extends Controller
{
    // GET /register
    public function register()
    {
        $this->view('auth/register');
    }

    // POST /register
    public function handleRegister()
    {
        require_once '../app/models/User.php';

        $fullName = trim($_POST['fullname'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $phone    = $_POST['phone'] ?? null;
        $password = $_POST['password'] ?? '';
        $confirm  = $_POST['confirm_password'] ?? '';

        if ($password !== $confirm) {
            die('Password not match');
        }

        $username = explode('@', $email)[0];

        $user = new User();
        $user->register([
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'full_name' => $fullName,
            'phone' => $phone
        ]);

        header('Location: /MVC_G1-LIBRARY-MANAGE-SYSTEM/public/login');
        exit;
    }
}
