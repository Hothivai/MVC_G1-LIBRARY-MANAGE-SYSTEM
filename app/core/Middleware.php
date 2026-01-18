<?php
// require_once './app/core/Auth.php';
namespace App\Core;
class Middleware
{
    public static function requireLogin()
    {
        if (!Auth::check()) {
            header('Location: /auth/login');
            exit;
        }
    }

    public static function requireAdmin()
    {
        self::requireLogin();

        if (Auth::user()['role'] !== 'admin') {
            echo "Access denied";
            exit;
        }
    }
    public static function requireUser()
    {
        self::requireLogin();

        if (Auth::user()['role'] !== 'user') {
            echo "Access denied";
            exit;
        }
    }
}

class AdminMiddleware extends Middleware {
    public function handle() {
        // Check if user is authenticated
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
        
        // Check if user is admin
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: /');
            exit();
        }
        
        return true;
    }
}

class AuthMiddleware extends Middleware {
    public function handle() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
        return true;
    }
}

class GuestMiddleware extends Middleware {
    public function handle() {
        if (isset($_SESSION['user_id'])) {
            if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
                header('Location: /admin/dashboard');
            } else {
                header('Location: /');
            }
            exit();
        }
        return true;
    }
}
