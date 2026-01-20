<?php

class Transaction extends Model
{
    protected $table = 'transactions';

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
}
