<?php
namespace App\Models;

use PDO;

class User extends Model {
    protected string $table = 'users';
    protected string $primaryKey = 'user_id';
    
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
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