<?php
class User extends Model {
    // Lấy thông tin cá nhân (LMS-31)
    public function getUserProfile($userId) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thống kê số liệu (Dựa trên bảng transactions)
    public function getBorrowStatistics($userId) {
        $stats = [];
        // Đang mượn (borrowed hoặc overdue)
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM transactions WHERE user_id = ? AND status IN ('borrowed', 'overdue')");
        $stmt->execute([$userId]);
        $stats['currently_borrowed'] = $stmt->fetchColumn();

        // Đã trả (returned)
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM transactions WHERE user_id = ? AND status = 'returned'");
        $stmt->execute([$userId]);
        $stats['returned_books'] = $stmt->fetchColumn();

        // Tính % đúng hạn (Không có days_overdue)
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM transactions WHERE user_id = ? AND status = 'returned' AND days_overdue = 0");
        $stmt->execute([$userId]);
        $onTime = $stmt->fetchColumn();
        $stats['on_time_percentage'] = ($stats['returned_books'] > 0) ? round(($onTime / $stats['returned_books']) * 100) : 100;

        return $stats;
    }

    // Lấy danh sách sách đang mượn hiển thị lên bảng
    public function getActiveTransactions($userId) {
        $sql = "SELECT b.title, t.borrow_date, t.due_date, t.status, t.transaction_id 
                FROM transactions t 
                JOIN book_copies bc ON t.copy_id = bc.copy_id
                JOIN books b ON bc.book_id = b.book_id 
                WHERE t.user_id = ? AND t.status IN ('borrowed', 'overdue')
                ORDER BY t.due_date ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}