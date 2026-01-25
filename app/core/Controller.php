<?php

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../core/Database.php';

class Controller
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /* ================= VIEW ================= */
    protected function view($viewPath, $data = [])
    {
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
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('login');
        }
    }

    protected function requireAdmin()
    {
        $this->requireAuth();
        if (($_SESSION['user']['role'] ?? '') !== 'admin') {
            $this->redirect('home');
        }
    }
}
