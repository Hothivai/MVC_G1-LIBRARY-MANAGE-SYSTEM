<?php
require_once './app/core/Model.php';
class User extends Model
{
    protected $table = 'users';

    // Lấy user theo email
    public function findByEmail($email)
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = ?";
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
