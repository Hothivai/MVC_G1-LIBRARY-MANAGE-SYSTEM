<?php
require_once './app/core/Controller.php';
require_once './app/core/Auth.php';

class AuthController extends Controller
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $userModel = $this->model('User');
            $user = $userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                Auth::login($user);
                header('Location: /home/index');
                exit;
            }

            $error = "Wrong email or password";
        }

        $this->view('auth/login', [
            'error' => $error ?? null
        ]);
    }

    public function logout()
    {
        Auth::logout();
        header('Location: /auth/login');
        exit;
    }
}
?>
<!-- Xử lý đăng nhập, check email và password -->