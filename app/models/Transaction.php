<?php
class Transaction extends Model
{
    protected $table = 'transactions';

    public function countBorrowed()
    {
        $sql = "SELECT COUNT(*) AS total 
                FROM transactions 
                WHERE status = 'borrowed'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function countOverdue()
    {
        $sql = "SELECT COUNT(*) AS total 
                FROM transactions 
                WHERE status = 'overdue'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getRecent()
    {
        $sql = "
            SELECT 
                t.id,
                u.name AS member_name,
                b.title AS book_title,
                t.borrowed_date,
                t.due_date,
                t.status
            FROM transactions t
            JOIN users u ON t.user_id = u.id
            JOIN books b ON t.book_id = b.id
            ORDER BY t.borrowed_date DESC
            LIMIT 5
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOverdueList()
    {
        $sql = "
            SELECT 
                t.id,
                u.name AS member_name,
                b.title AS book_title,
                t.due_date,
                DATEDIFF(CURDATE(), t.due_date) AS days_overdue
            FROM transactions t
            JOIN users u ON t.user_id = u.id
            JOIN books b ON t.book_id = b.id
            WHERE t.status = 'overdue'
            ORDER BY days_overdue DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>