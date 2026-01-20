<?php
namespace App\Models;

use PDO;

class User extends Model
{
    protected string $table = 'users';
    protected string $primaryKey = 'user_id';

    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByUsername($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function isSuspended($userId)
    {
        $user = $this->find($userId);
        if (!$user) {
            return false;
        }
        $suspended = isset($user['is_suspended']) && (int)$user['is_suspended'] === 1;
        $until = !empty($user['suspended_until']) && strtotime($user['suspended_until']) > time();
        return $suspended && $until;
    }

    public function register($data)
    {
        $username = explode('@', $data['email'])[0] . rand(100, 999);
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, email, password, full_name, phone, role, status) 
                VALUES (?, ?, ?, ?, ?, 'member', 'active')";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $username,
            $data['email'],
            $hashedPassword,
            $data['fullname'] ?? $data['full_name'] ?? null,
            $data['phone'] ?? null
        ]);
    }
}