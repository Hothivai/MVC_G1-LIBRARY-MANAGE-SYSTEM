<?php
require_once __DIR__ . '/../core/Model.php';

class BorrowRequest extends Model
{
    protected string $table = 'borrow_requests';
    protected string $primaryKey = 'request_id';

    public function create($userId, $bookId, $quantity, $note)
    {
        $sql = "
            INSERT INTO borrow_requests
            (user_id, book_id, quantity, note)
            VALUES (?, ?, ?, ?)
        ";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $userId,
            $bookId,
            $quantity,
            $note
        ]);
    }

    /**
     * Lấy danh sách yêu cầu để hiển thị ở trang Quản lý của Admin
     * Hiển thị cả yêu cầu đang chờ và yêu cầu đã xử lý gần đây
     */
    public function getAdminRequests()
    {
        $sql = "
            SELECT
                br.request_id,
                br.user_id,
                br.book_id,
                br.quantity,
                br.request_date,
                br.status,
                br.note,
                u.full_name,
                u.email,
                b.title AS book_title
            FROM borrow_requests br
            JOIN users u ON br.user_id = u.user_id
            JOIN books b ON br.book_id = b.book_id
            ORDER BY 
                -- Đưa 'pending' lên trước, sau đó mới đến các trạng thái khác
                CASE WHEN br.status = 'pending' THEN 1 ELSE 2 END ASC,
                br.request_date DESC
            LIMIT 50
        ";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {
        $sql = "
            SELECT br.*, u.full_name, u.email, b.title AS book_title 
            FROM borrow_requests br
            JOIN users u ON br.user_id = u.user_id
            JOIN books b ON br.book_id = b.book_id
            WHERE br.request_id = ?
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getByUserId($userId)
    {
        $sql = "
            SELECT br.*, b.title AS book_title 
            FROM borrow_requests br
            JOIN books b ON br.book_id = b.book_id
            WHERE br.user_id = ?
            ORDER BY br.request_date DESC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function approve($id)
    {
        $stmt = $this->db->prepare("
            UPDATE borrow_requests
            SET status = 'approved'
            WHERE request_id = ?
        ");
        return $stmt->execute([$id]);
    }

    public function reject($id)
    {
        $stmt = $this->db->prepare("
            UPDATE borrow_requests
            SET status = 'rejected'
            WHERE request_id = ?
        ");
        return $stmt->execute([$id]);
    }
}
