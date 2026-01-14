<?php
class User {
    private $db;
    public function __construct($db_connection) {
        $this->db = $db_connection;
    }

    // 1. Hàm kiểm tra Email đã tồn tại chưa (Rất quan trọng)
    public function checkEmailExists($email) {
        $sql = "SELECT user_id FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch() ? true : false;
    }

    // 2. Hàm đăng ký
    public function register($data) {
        $role = 'member';

        $sql = "INSERT INTO users (full_name, email, address, password, phone, role, status) 
                VALUES (:fullname, :email, :address, :password, :phone, :role, 'active')";
        
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':fullname'  => $data['fullname'],
            ':email'     => $data['email'],
            ':address'   => $data['address'],
            ':password'  => password_hash($data['password'], PASSWORD_BCRYPT),
            ':phone'     => $data['phone'],
            ':role'      => $role
        ]);
    }
}