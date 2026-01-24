<?php
namespace App\Models;
use PDO;

<<<<<<< HEAD
class User extends Model {

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

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Lấy user theo email
=======
class User extends Model
{
    // AUTH / ACCOUNT
    // Tìm user theo email (login, register)
>>>>>>> feature/LMS-8
    public function findByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tìm user theo ID (dùng chung)
    public function findById($userId)
    {
        $sql = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // PROFILE
    // Lấy thông tin cá nhân
    public function getUserProfile($userId)
    {
        return $this->findById($userId);
    }

    // Cập nhật thông tin cá nhân
    public function updateProfile($userId, $data)
    {
        $sql = "UPDATE users 
                SET full_name = ?,
                    phone     = ?,
                    address   = ?
                WHERE user_id = ?";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $data['full_name'],
            $data['phone'],
            $data['address'],
            $userId
        ]);
    }

    // PASSWORD
    // Kiểm tra mật khẩu hiện tại
    public function checkCurrentPassword($userId, $currentPassword)
    {
        $sql = "SELECT password FROM users WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user && password_verify($currentPassword, $user['password']);
    }

    // Cập nhật mật khẩu mới
    public function updatePassword($userId, $newPassword)
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $sql = "UPDATE users SET password = ? WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([$hashedPassword, $userId]);
    }

    // BORROW STATISTICS
    // Thống kê số liệu mượn/trả
    public function getBorrowStatistics($userId)
    {
        $stats = [];

        // Đang mượn (borrowed + overdue)
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) 
             FROM transactions 
             WHERE user_id = ? 
               AND status IN ('borrowed', 'overdue')"
        );
        $stmt->execute([$userId]);
        $stats['currently_borrowed'] = (int) $stmt->fetchColumn();

        // Đã trả
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) 
             FROM transactions 
             WHERE user_id = ? 
               AND status = 'returned'"
        );
        $stmt->execute([$userId]);
        $stats['returned_books'] = (int) $stmt->fetchColumn();

        // Trả đúng hạn
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) 
             FROM transactions 
             WHERE user_id = ? 
               AND status = 'returned' 
               AND days_overdue = 0"
        );
        $stmt->execute([$userId]);
        $onTime = (int) $stmt->fetchColumn();

        $stats['on_time_percentage'] =
            ($stats['returned_books'] > 0)
            ? round(($onTime / $stats['returned_books']) * 100)
            : 100;

        return $stats;
    }

    // Danh sách sách đang mượn (hiển thị bảng)
    public function getActiveTransactions($userId)
    {
        $sql = "SELECT 
                    b.title,
                    t.borrow_date,
                    t.due_date,
                    t.status,
                    t.transaction_id
                FROM transactions t
                JOIN book_copies bc ON t.copy_id = bc.copy_id
                JOIN books b ON bc.book_id = b.book_id
                WHERE t.user_id = ?
                  AND t.status IN ('borrowed', 'overdue')
                ORDER BY t.due_date ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected string $table = 'users';
    protected string $primaryKey = 'user_id';
    
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
