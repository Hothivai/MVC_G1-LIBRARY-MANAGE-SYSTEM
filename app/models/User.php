<?php
class User extends Model
{
    protected $table = 'users';

    public function countUsers()
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM users WHERE role = 'user'");
        return $stmt->fetchColumn();
    }
}
?>