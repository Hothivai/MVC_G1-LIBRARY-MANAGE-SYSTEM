<?php
    namespace App\Controllers;  // ← Namespace đúng cho base Controller
    require_once __DIR__ . '/../../config/config.php';
    require_once __DIR__ . '/../core/Database.php';
    use App\Core\Database;
    class Controller {
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    // protected function view($viewPath, $data = [])
    // {
    //     extract($data);
    //     $viewFile = APPROOT . '/views/' . $viewPath . '.php';
        
    //     if (file_exists($viewFile)) {
    //         require_once $viewFile;
    //     } else {
    //         die("View file not found: $viewPath (looking for: $viewFile)");
    //     }
    // }

    protected function view($viewPath, $data = [])
{
    extract($data);

    $viewFile = APP_PATH . '/views/' . $viewPath . '.php';

    if (file_exists($viewFile)) {
        require_once $viewFile;
    } else {
        die("View file not found: $viewPath (looking for: $viewFile)");
    }
}
    // public function model($model)
    // {
    //     require_once __DIR__ . "/../models/$model.php";
    //     return new $model($this->db);
    // }
    public function model($model)
    {
        $modelClass = "App\\Models\\$model";

        $modelFile = __DIR__ . "/../models/$model.php";
        if (file_exists($modelFile)) {
            require_once $modelFile;
        } else {
            die("Model file not found: $modelFile");
        }

        return new $modelClass($this->db);
    }

    
    protected function redirect($url) {
        header("Location: $url");
        exit();
    }
    
    protected function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
    
    protected function requireAuth() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
    }
    
    protected function requireAdmin() {
        $this->requireAuth();
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            $this->redirect('/');
        }
    }
}