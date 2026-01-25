<?php
namespace App\Controllers;
use App\Models\User;
use App\Core\Auth;

class AuthController extends Controller
{
    // khi vào /
    public function redirectToLogin()
    {
        header('Location: /auth/login');
        exit;
    }
    
    // hiển thị form login
    public function login()
    {
        $this->view('auth/login');
    }

    // xử lý submit login
    public function loginPost()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        $user = new User();
        $user = $user->findByEmail($email);  // Add this line

        if (!$user || !password_verify($password, $user['password'])) {
            $this->view('auth/login', [
                'error' => 'Invalid email or password'
            ]);
            return;
        }

        Auth::login($user);

        // redirect theo role
        if ($user['role'] === 'admin') {
            header('Location: /admin/dashboard/index');
        } else {
            header('Location: /home/index');
        }
        exit;
    }

    public function logout() {
        Auth::logout();
        header('Location: /');
        header('Location: /auth/login');
        exit;
    }

}

?>
