<?php
class Auth
{
    public static function login($user)
    {
        session_start();
        $_SESSION['user'] = $user;
    }

    public static function logout()
    {
        session_start();
        session_destroy();
    }

    public static function user()
    {
        return $_SESSION['user'] ?? null;
    }

    public static function check()
    {
        return isset($_SESSION['user']);
    }
}
?>
<!-- Lưu user vào session -->