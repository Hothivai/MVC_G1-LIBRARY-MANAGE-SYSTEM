<?php

class User
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Lấy user theo email
    public function findByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Đếm số lượng user
    public function countUsers()
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM users WHERE role = 'user'");
        return $stmt->fetchColumn();
    }
}
?>