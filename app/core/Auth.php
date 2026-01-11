<?php

class Auth
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function login($email, $password)
    {
        // Login logic
    }

    public function logout()
    {
        // Logout logic
    }

    public function isAuthenticated()
    {
        return isset($_SESSION['user_id']);
    }

    public function getCurrentUser()
    {
        // Get current user
    }
}
