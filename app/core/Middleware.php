<?php
namespace App\Core;

abstract class Middleware {
    abstract public function handle();
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