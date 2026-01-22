<?php   
class User
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function countUsers()
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM users WHERE role = 'user'");
        return $stmt->fetchColumn();
    }

    // ⭐ LMS-32
// ⭐ LMS-32
public function findById($id)
{
    $sql = "SELECT id, full_name, email, phone, address FROM users WHERE id = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function updateContact($id, $full_name, $phone, $address)
{
    $sql = "UPDATE users 
            SET full_name = ?, phone = ?, address = ?
            WHERE id = ?";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([$full_name, $phone, $address, $id]);
}}