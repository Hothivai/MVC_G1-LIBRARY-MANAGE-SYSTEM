<?php
require_once __DIR__ . '/../core/Controller.php';

class AuthController extends Controller
{
    // action: auth_register
    public function register()
    {
        $this->view('auth/register');
    }

    // action: auth_register_post
    public function postRegister()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old_data'] = $data;
                $this->redirect('auth_register');
            }

            $userModel = $this->model('User');
            
            if ($userModel->findByEmail($data['email'])) {
                $_SESSION['errors'] = ["This email already exists in the system. Please use a different email."];
                $_SESSION['old_data'] = $data;
                $this->redirect('auth_register');
            }

            if ($userModel->register($data)) {
                $this->redirect('auth_login');
            }
        }
    }

    // action: auth_login
    public function login()
    {
        $this->view('auth/login', ['error' => null]);
    }

    // action: auth_login_post
    public function loginPost()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $userModel = $this->model('User');
        $user = $userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            $this->view('auth/login', ['error' => 'Email hoặc mật khẩu không đúng']);
            return;
        }

        Auth::login($user);

        // redirect theo role
        if (Auth::isAdmin()) {
            $this->redirect('admin_dashboard_index');
        } else {
            $this->redirect('home_index');
        }
    }

    // action: auth_logout
    public function logout()
    {
        Auth::logout();
        $this->redirect('home_index');
    }
}