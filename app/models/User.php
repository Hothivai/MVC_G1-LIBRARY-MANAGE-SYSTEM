<?php
namespace App\Models;
use PDO;

class User extends Model {

    public function register($data) {
        // Tự tạo username từ email (vì form không có ô username)
        $username = explode('@', $data['email'])[0] . rand(100, 999);
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, email, password, full_name, phone, role, status) 
                VALUES (?, ?, ?, ?, ?, 'member', 'active')";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $username,
            $data['email'],
            $hashedPassword,
            $data['fullname'],
            $data['phone']
        ]);
    }

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

    protected string $table = 'users';
    protected string $primaryKey = 'user_id';
    
    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function isSuspended($userId) {
        $user = $this->find($userId);
        return $user && $user['is_suspended'] == 1 && 
               (!empty($user['suspended_until']) && strtotime($user['suspended_until']) > time());
    }
}
