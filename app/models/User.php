<?php
namespace App\Models;

class User extends Model {
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
    
    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }
    
    public function isSuspended($userId) {
        $user = $this->find($userId);
        return $user && $user['is_suspended'] == 1 && 
               (!empty($user['suspended_until']) && strtotime($user['suspended_until']) > time());
    }
}