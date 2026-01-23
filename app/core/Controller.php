<?php
namespace App\Controllers;

use App\Core\Database;
use App\Core\Auth;

require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Auth.php';

class Controller
{
    protected $db;

    public function __construct()
    {
        // PDO dùng chung cho toàn hệ thống
        $this->db = Database::getInstance()->getConnection();
    }

    // ================= VIEW =================
    protected function view(string $view, array $data = [])
    {
        $viewFile = __DIR__ . '/../views/' . $view . '.php';

        if (!file_exists($viewFile)) {
            die("View not found: $view");
        }

        extract($data);
        require $viewFile;
    }

    // ================= MODEL =================
    protected function model(string $model)
    {
        $class = "App\\Models\\$model";
        return new $class(); // Model tự lấy DB từ Database singleton
    }

    // ================= REDIRECT =================
    protected function redirect(string $path)
    {
        header("Location: $path");
        exit;
    }

    // ================= AUTH =================
    protected function requireAuth()
    {
        if (!Auth::check()) {
            $this->redirect('/auth/login');
        }
    }

    protected function requireAdmin()
    {
        $this->requireAuth();

        if (!Auth::isAdmin()) {
            $this->redirect('/');
        }
    }
}
