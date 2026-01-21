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
    // Lấy user theo ID (hiển thị profile)
    public function findById($id)
    {
        $sql = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($userId, $data)
    {
        $sql = "UPDATE users 
                SET full_name = ?,
                    email = ?,
                    phone = ?,
                    address = ?
                WHERE user_id = ?";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $data['full_name'],
            $data['email'],
            $data['phone'],
            $data['address'],
            $userId
        ]);
    }
}
