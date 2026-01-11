<?php

class Middleware
{
    public static function checkAuth()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
    }

    public static function checkAdmin()
    {
        self::checkAuth();
        if ($_SESSION['role'] !== 'admin') {
            header('Location: /');
            exit();
        }
    }

    public static function checkUser()
    {
        self::checkAuth();
        if ($_SESSION['role'] !== 'user') {
            header('Location: /');
            exit();
        }
    }
}
