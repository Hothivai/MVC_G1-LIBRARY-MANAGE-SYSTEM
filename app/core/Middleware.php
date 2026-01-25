<?php

class Middleware
{
    protected static function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Bắt buộc đăng nhập
    public static function requireLogin()
    {
        self::startSession();

        if (!isset($_SESSION['user'])) {
            header('Location: /?action=login');
            exit;
        }
    }

    // Chỉ admin
    public static function requireAdmin()
    {
        self::requireLogin();

        if ($_SESSION['user']['role'] !== 'admin') {
            echo "Access denied";
            exit;
        }
    }

    // Chỉ user thường
    public static function requireUser()
    {
        self::requireLogin();

        if ($_SESSION['user']['role'] !== 'user') {
            echo "Access denied";
            exit;
        }
    }
}
