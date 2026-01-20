<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/Database.php';
class Controller {
    public function model($model) {
        require_once "../app/models/" . $model . ".php";
        return new $model();
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
    public function view($view, $data = []) {
        require_once "../app/views/" . $view . ".php";
    }
}