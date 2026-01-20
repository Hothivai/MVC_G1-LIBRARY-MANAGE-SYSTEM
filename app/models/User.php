<?php
class User extends Model {
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

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
    public function updatePassword($userId, $newPassword) {
    // Mã hóa mật khẩu trước khi lưu
    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
    
    $sql = "UPDATE users SET password = :password WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
        ':password' => $hashedPassword,
        ':id' => $userId
    ]);
}
}
