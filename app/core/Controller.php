<?php
use App\Core\Database;

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Auth.php';

class Controller
{
    protected $db;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // PDO dùng chung cho toàn hệ thống
        $this->db = Database::getInstance()->getConnection();
    }

    protected function setFlash(string $key, string $message): void
    {
        $_SESSION['flash'][$key] = $message;
    }

    protected function getFlash(string $key): ?string
    {
        if (isset($_SESSION['flash'][$key])) {
            $message = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
            return $message;
        }
        return null;
    }

    /* ================= VIEW ================= */
    protected function view($viewPath, $data = [])
    {
        // Pass flash messages to the view
        if (isset($_SESSION['flash'])) {
            foreach ($_SESSION['flash'] as $key => $message) {
                $data['flash_' . $key] = $message;
            }
            unset($_SESSION['flash']);
        }
        
        extract($data);

        $viewFile = APP_PATH . '/views/' . $viewPath . '.php';

        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            die("View not found: $viewFile");
        }
    }

    /* ================= MODEL ================= */
    protected function model($model)
    {
        $modelFile = APP_PATH . "/models/$model.php";

        if (!file_exists($modelFile)) {
            die("Model not found: $modelFile");
        }

        require_once $modelFile;

        return new $model($this->db);
    }

    /* ================= HELPERS ================= */
    protected function redirect($action)
    {
        header("Location: index.php?action=$action");
        exit;
    }

    protected function json($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /* ================= AUTH ================= */
    protected function requireAuth()
    {
        if (!Auth::check()) {
            $this->redirect('auth_login');
        }
    }

    protected function requireAdmin()
    {
        $this->requireAuth();
        if (!Auth::isAdmin()) {
            $this->redirect('home_index');
        }
    }
}