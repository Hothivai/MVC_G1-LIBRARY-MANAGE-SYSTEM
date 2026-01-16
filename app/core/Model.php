<?php
class Model {
    protected $db;

    public function __construct() {
        $database = new Database();
        // Dòng số 8: Phải khớp với tên hàm ở file Database.php
        $this->db = $database->getConnection(); 
    }
}