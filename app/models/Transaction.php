<?php
require_once __DIR__ . '/../core/Model.php';
class Transaction extends Model
{
    protected string $table = 'transactions';
    protected string $primaryKey = 'transaction_id';

    // DASHBOARD STATS

    // Đếm sách đang mượn
    public function countBorrowed()
    {
        $sql = "
            SELECT COUNT(*) AS total
            FROM transactions
            WHERE status = 'borrowed'
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // Đếm sách quá hạn
    public function countOverdue()
    {
        $sql = "
            SELECT COUNT(*) AS total
            FROM transactions
            WHERE status = 'overdue'
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // Giao dịch gần đây (Dashboard)
    public function getRecent()
    {
        $sql = "
            SELECT
                t.transaction_id,
                u.full_name AS member_name,
                b.title AS book_title,
                t.borrow_date,
                t.due_date,
                t.status
            FROM transactions t
            JOIN users u ON t.user_id = u.user_id
            JOIN book_copies bc ON t.copy_id = bc.copy_id
            JOIN books b ON bc.book_id = b.book_id
            ORDER BY t.borrow_date DESC
            LIMIT 5
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ADMIN

    // Danh sách sách quá hạn
    public function getOverdueList()
    {
        $sql = "
            SELECT
                t.transaction_id,
                u.full_name AS member_name,
                b.title AS book_title,
                t.due_date,
                DATEDIFF(CURDATE(), t.due_date) AS days_overdue
            FROM transactions t
            JOIN users u ON t.user_id = u.user_id
            JOIN book_copies bc ON t.copy_id = bc.copy_id
            JOIN books b ON bc.book_id = b.book_id
            WHERE t.status = 'overdue'
            ORDER BY days_overdue DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tạo transaction khi admin duyệt mượn sách
    public function createTransaction(int $userId, int $copyId, string $dueDate): bool
    {
        $sql = "
        INSERT INTO transactions 
        (user_id, copy_id, borrow_date, due_date, status) 
        VALUES (?, ?, CURDATE(), ?, 'borrowed')
    ";

        $stmt = $this->db->prepare($sql);
        if ($stmt->execute([$userId, $copyId, $dueDate])) {
            // Trả về ID vừa tạo để Controller dùng gửi thông báo
            return $this->db->lastInsertId();
        }
        return false;
    }

    // USER

    // Sách đang mượn
    public function getBorrowedBooks($userId)
    {
        $sql = "
            SELECT
                t.*,
                b.title,
                b.author,
                bc.barcode,
                t.due_date
            FROM transactions t
            JOIN book_copies bc ON t.copy_id = bc.copy_id
            JOIN books b ON bc.book_id = b.book_id
            WHERE t.user_id = ?
              AND t.return_date IS NULL
            ORDER BY t.due_date ASC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lịch sử mượn sách
    public function getBorrowHistory($userId)
    {
        $sql = "
            SELECT
                t.*,
                b.title,
                b.author,
                bc.barcode
            FROM transactions t
            JOIN book_copies bc ON t.copy_id = bc.copy_id
            JOIN books b ON bc.book_id = b.book_id
            WHERE t.user_id = ?
            ORDER BY t.borrow_date DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Danh sách quá hạn (admin chi tiết)
    public function getOverdueBooks()
    {
        $sql = "
            SELECT
                t.*,
                u.username,
                u.full_name,
                b.title,
                bc.barcode,
                DATEDIFF(CURDATE(), t.due_date) AS days_overdue
            FROM transactions t
            JOIN users u ON t.user_id = u.user_id
            JOIN book_copies bc ON t.copy_id = bc.copy_id
            JOIN books b ON bc.book_id = b.book_id
            WHERE t.return_date IS NULL
              AND t.due_date < CURDATE()
        ";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * Tìm chi tiết giao dịch kèm thông tin người dùng và sách
     * Dùng cho trang chi tiết hoặc gửi thông báo
     */
    public function findById($id)
    {
        $sql = "
            SELECT 
                t.*, 
                u.full_name, 
                u.email, 
                u.user_id,
                b.title AS book_title, 
                bc.barcode
            FROM transactions t
            JOIN users u ON t.user_id = u.user_id
            JOIN book_copies bc ON t.copy_id = bc.copy_id
            JOIN books b ON bc.book_id = b.book_id
            WHERE t.transaction_id = ?
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Đánh dấu sách đã trả
     * Cập nhật ngày trả và trạng thái giao dịch
     */
    public function markAsReturned($id)
    {
        $sql = "
            UPDATE transactions 
            SET 
                return_date = NOW(), 
                status = 'returned' 
            WHERE transaction_id = ?
        ";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function getHistoryByBook($bookId)
{
    $sql = "
        SELECT 
            t.*,
            u.full_name as member_name,
            u.user_id as member_code
        FROM transactions t
        JOIN users u ON t.user_id = u.user_id
        JOIN book_copies bc ON t.copy_id = bc.copy_id
        WHERE bc.book_id = ?
        ORDER BY t.borrow_date DESC
        LIMIT 10
    ";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$bookId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}



