<?php

class Controller
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function view($view, $data = [])
    {
        extract($data);
        require_once '../app/views/' . $view . '.php';
    }

    public function model($model)
    {
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }
}
