<?php

class Auth
{
    protected static function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function login($user)
    {
        self::startSession();
        $_SESSION['user'] = $user;
        $_SESSION['user_id'] = $user['id']; // thêm để đồng bộ
    }

    public static function logout()
    {
        self::startSession();
        session_unset();
        session_destroy();
    }

    public static function user()
    {
        self::startSession();
        return $_SESSION['user'] ?? null;
    }

    public static function check()
    {
        self::startSession();
        return isset($_SESSION['user']);
    }

    public static function isAdmin()
    {
        self::startSession();
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
    }
}
