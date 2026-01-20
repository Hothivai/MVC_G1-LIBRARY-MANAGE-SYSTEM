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
    }

    public static function logout()
    {
        self::startSession();
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
}
