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
    public static function checkOverdue($userId)
    {
        $db = Database::getInstance();
        $sql = "SELECT 1 FROM transactions
                WHERE user_id = :user_id
                AND status = 'borrowed'
                AND due_date < CURDATE()";
        $stmt = $db->query($sql, ['user_id' => $userId]);

        if ($stmt->rowCount() > 0) {
            header('Location: /user/borrow?error=overdue');
            exit;
        }
    }

}