<?php
namespace App\Controllers;

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Auth.php';

use App\Core\Auth;

class AuthController extends Controller {
    
    public function register() {
        $this->view('auth/register');
    }

    public function postRegister() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (session_status() == PHP_SESSION_NONE) session_start();

            $data = [
                'fullname' => trim($_POST['fullname'] ?? ''),
                'phone' => trim($_POST['phone'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'password' => $_POST['password'] ?? '',
                'confirm_password' => $_POST['confirm_password'] ?? ''
            ];

            $errors = [];

            // Kiểm tra 10 số điện thoại
            if (!preg_match('/^[0-9]{10}$/', $data['phone'])) {
                $errors[] = "Invalid phone number. Please enter exactly 10 digits.";
            }

            // Kiểm tra mật khẩu (8 ký tự, chữ, số, ký tự đặc biệt)
            $passwordPattern = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/';
            if (!preg_match($passwordPattern, $data['password'])) {
                $errors[] = "Password must be at least 8 characters long, including letters, numbers and special characters.";
            }

            if ($data['password'] !== $data['confirm_password']) {
                $errors[] = "Confirm password does not match.";
            }

            // Nếu có lỗi thì dừng lại
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old_data'] = $data;
                header("Location: /register");
                exit();
            }

            $userModel = $this->model('User');
            
            if ($userModel->findByEmail($data['email'])) {
                $_SESSION['errors'] = ["This email already exists in the system. Please use a different email."];
                $_SESSION['old_data'] = $data;
                header("Location: /register");
                exit();
            }

            if ($userModel->register($data)) {
                header("Location: /login?success=1");
                exit();
            }
        }
    }

    public function login() {
        $this->view('auth/login', [
            'error' => null
        ]);
    }

    public function loginPost() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $userModel = $this->model('User');
        $user = $userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            Auth::login($user);

            if ($user['role'] === 'admin') {
                header('Location: /admin/dashboard');
            } else {
                header('Location: /');
            }
            exit;
        }

        $this->view('auth/login', [
            'error' => 'Wrong email or password'
        ]);
    }

    public function logout() {
        Auth::logout();
        header('Location: /');
        exit;
    }
}
?>
