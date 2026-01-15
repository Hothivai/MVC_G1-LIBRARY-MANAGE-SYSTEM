<?php

class User extends Model
{
    public function register(array $data): bool
    {
        $sql = "INSERT INTO users 
            (username, email, password, full_name, phone)
            VALUES (:username, :email, :password, :full_name, :phone)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':username' => $data['username'],
            ':email' => $data['email'],
            ':password' => $data['password'],
            ':full_name' => $data['full_name'],
            ':phone' => $data['phone']
        ]);
    }
}
