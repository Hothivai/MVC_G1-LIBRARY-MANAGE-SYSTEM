<?php

require_once __DIR__ . '/../core/Auth.php';

class AuthController extends Controller
{
    // Redirect to login
    public function redirectToLogin()
    {
        header('Location: /auth/login');
        exit;
    }
    
    // Display login form
    public function login()
    {
        $this->view('auth/login');
    }

    // Handle login submission
    public function loginPost()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $userModel = $this->model('User');
        $user = $userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            $this->view('auth/login', [
                'error' => 'Invalid email or password'
            ]);
            return;
        }

        Auth::login($user);

        // Redirect based on role
        if ($user['role'] === 'admin') {
            header('Location: /admin/dashboard/index');
        } else {
            header('Location: /home/index');
        }
        exit;
    }

    // Display register form
    public function register()
    {
        $this->view('auth/register');
    }

    // Handle register submission
    public function postRegister()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (session_status() == PHP_SESSION_NONE) session_start();

            $data = [
                'fullname' => trim($_POST['fullname']),
                'phone' => trim($_POST['phone']),
                'email' => trim($_POST['email']),
                'password' => $_POST['password'],
                'confirm_password' => $_POST['confirm_password']
            ];

            $errors = [];

            // Check 10-digit phone
            if (!preg_match('/^[0-9]{10}$/', $data['phone'])) {
                $errors[] = "Invalid phone number. Please enter exactly 10 digits.";
            }

            // Check password (8+ chars, letters, numbers, special chars)
            $passwordPattern = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/';
            if (!preg_match($passwordPattern, $data['password'])) {
                $errors[] = "Password must be at least 8 characters long, including letters, numbers and special characters.";
            }

            if ($data['password'] !== $data['confirm_password']) {
                $errors[] = "Confirm password does not match.";
            }

            // If errors, redirect back
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old_data'] = $data;
                header("Location: /auth/register");
                exit;
            }

            $userModel = $this->model('User');
            
            if ($userModel->findByEmail($data['email'])) {
                $_SESSION['errors'] = ["This email already exists in the system. Please use a different email."];
                $_SESSION['old_data'] = $data;
                header("Location: /auth/register");
                exit;
            }

            if ($userModel->register($data)) {
                header("Location: /auth/login?success=1");
                exit;
            }
        }
    }

    public function logout()
    {
        Auth::logout();
        header('Location: /auth/login');
        exit;
    }
}
