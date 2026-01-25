<?php
require_once __DIR__ . '/Auth.php';

class Middleware
{
    // Bắt buộc đăng nhập
    public static function requireLogin()
    {
        if (!Auth::check()) {
            header('Location: index.php?action=auth_login');
            exit;
        }
    }

    // Chỉ admin
    public static function requireAdmin()
    {
        self::requireLogin();

        if (!Auth::isAdmin()) {
            header('Location: index.php?action=home_index');
            exit;
        }
    }

    // Chỉ user thường
    public static function requireUser()
    {
        self::requireLogin();

        if (!Auth::isUser()) {
            header('Location: index.php?action=home_index');
            exit;
        }
    }
}