<?php

require_once __DIR__ . '/Database.php';

class Controller
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function view($view, $data = [])
    {
        extract($data);
        require_once __DIR__ . "/../views/$view.php";
    }

    public function model($model)
    {
        require_once __DIR__ . "/../models/$model.php";
        return new $model($this->db);
    }

    protected function redirect($url)
    {
        header("Location: $url");
        exit();
    }

    protected function json($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
}
