<?php

class Auth
{
    protected static function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // ================= LOGIN / LOGOUT =================

    public static function login(array $user): void
    {
        self::startSession();

        // Lưu toàn bộ user
        $_SESSION['user'] = $user;

        // Lưu nhanh các field hay dùng
        $_SESSION['user_id']   = $user['user_id'] ?? null;
        $_SESSION['user_role'] = $user['role'] ?? 'user';
    }

    public static function logout(): void
    {
        self::startSession();
        session_unset();
        session_destroy();
    }

    // ================= AUTH CHECK =================

    public static function user(): ?array
    {
        self::startSession();
        return $_SESSION['user'] ?? null;
    }

    public static function check(): bool
    {
        self::startSession();
        return isset($_SESSION['user']);
    }

    // ================= ROLE CHECK =================

    public static function isAdmin(): bool
    {
        self::startSession();
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }

    public static function isUser(): bool
    {
        self::startSession();
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'user';
    }

    // ================= UTILITY =================

    public static function getUserId(): ?int
    {
        self::startSession();
        return $_SESSION['user_id'] ?? null;
    }
}