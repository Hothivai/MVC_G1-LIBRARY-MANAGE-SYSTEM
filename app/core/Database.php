<?php

class Database
{
    private $host;
    private $db_name;
    private $user;
    private $pass;
    private $pdo;

    public function __construct()
    {
    $this->host = "localhost";
	$this->user = "root";
	$this->pass = "";
	$this->db_name = "library_db";
    }

    public function connect()
    {
        // PDO Connection
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch(PDOException $e) {
            die("Lỗi kết nối: " . $e->getMessage());
        }
        return $this->conn;
    }
}