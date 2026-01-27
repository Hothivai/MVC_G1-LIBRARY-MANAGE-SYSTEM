<?php
require_once __DIR__ . '/../core/Model.php';
class BorrowRequest extends Model {


    public function create($userId, $bookId, $dueDate, $notes) {
                $sql = "
            INSERT INTO borrow_requests
            (user_id, book_id, borrow_date, due_date, notes, status)
            VALUES (?, ?, NOW(), ?, ?, 'pending')
        ";


        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$userId, $bookId, $dueDate, $notes]);
    }


    public function getPendingRequests()
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
                u.name  AS member_name,
                u.email AS member_email,
                b.title AS book_title
            FROM borrow_requests br
            JOIN users u ON br.user_id = u.user_id
            JOIN books b ON br.book_id = b.book_id
            WHERE br.status = 'pending'
            ORDER BY br.request_date DESC
        ";


        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function finds($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM borrow_requests WHERE request_id = ?");
        $stmt->execute([$id]);


        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function approve($id)
    {
        $stmt = $this->db->prepare("
            UPDATE borrow_requests
            SET status='approved'
            WHERE request_id=?
        ");
        return $stmt->execute([$id]);
    }


    public function reject($id) {
        $stmt = $this->db->prepare("
            UPDATE borrow_requests
            SET status='rejected'
            WHERE request_id=?
        ");
        return $stmt->execute([$id]);
    }
}