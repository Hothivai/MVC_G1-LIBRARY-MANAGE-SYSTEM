<?php
namespace App\Controllers;  // ← Namespace đúng cho base Controller

abstract class Controller {
    protected function view($viewPath, $data = []) {
        extract($data);
        $viewFile = APP_PATH . '/views/' . $viewPath . '.php';
        
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("View file not found: $viewPath (looking for: $viewFile)");
        }
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