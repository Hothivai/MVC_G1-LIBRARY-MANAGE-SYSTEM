<?php
namespace App\Models;

class Transaction extends Model {
    protected $table = 'transactions';
    protected $primaryKey = 'transaction_id';
    
    public function getBorrowedBooks($userId) {
        $sql = "SELECT t.*, b.title, b.author, bc.barcode, t.due_date 
                FROM transactions t
                JOIN book_copies bc ON t.copy_id = bc.copy_id
                JOIN books b ON bc.book_id = b.book_id
                WHERE t.user_id = ? AND t.return_date IS NULL
                ORDER BY t.due_date ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
    
    public function getBorrowHistory($userId) {
        $sql = "SELECT t.*, b.title, b.author, bc.barcode
                FROM transactions t
                JOIN book_copies bc ON t.copy_id = bc.copy_id
                JOIN books b ON bc.book_id = b.book_id
                WHERE t.user_id = ?
                ORDER BY t.borrow_date DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
    
    public function getOverdueBooks() {
        $sql = "SELECT t.*, u.username, u.full_name, b.title, bc.barcode, 
                DATEDIFF(CURDATE(), t.due_date) as days_overdue
                FROM transactions t
                JOIN users u ON t.user_id = u.user_id
                JOIN book_copies bc ON t.copy_id = bc.copy_id
                JOIN books b ON bc.book_id = b.book_id
                WHERE t.return_date IS NULL AND t.due_date < CURDATE()";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}