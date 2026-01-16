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
            $this->pdo = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->pdo;
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }
    }
}
