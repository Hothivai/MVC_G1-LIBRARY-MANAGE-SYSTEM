<?php
class User extends Model {
    // Lấy thông tin hiển thị (LMS-31)
    public function getUserProfile($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        return $this->db->query($sql, [':id' => $id])->fetch();
    }

    // Lấy thống kê cho 3 ô Dashboard
    public function getBorrowStatistics($id) {
        $sql = "SELECT 
            (SELECT COUNT(*) FROM transactions WHERE user_id = :id AND status = 'borrowing') as currently_borrowed,
            (SELECT COUNT(*) FROM transactions WHERE user_id = :id AND status = 'returned') as returned_books,
            (SELECT COUNT(*) FROM transactions WHERE user_id = :id AND status = 'on_time') as on_time_books";
        return $this->db->query($sql, [':id' => $id])->fetch();
    }
}