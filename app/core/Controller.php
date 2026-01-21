<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/Database.php';
class Controller
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function view($view, $data = []) {
    if (file_exists('../app/views/' . $view . '.php')) {
        // Lệnh này cực kỳ quan trọng, nó chuyển ['user' => '...'] thành $user
        extract($data); 
        require_once '../app/views/' . $view . '.php';
    } else {
        die("View does not exist");
    }
}
}
