<?php
require_once './app/core/Model.php';
class User extends Model
{
    protected $table = 'users';

    public function findByEmail($email)
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
<!-- Lấy user theo email -->