<?php

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
