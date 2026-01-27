<?php
namespace App\Models;
use App\Core\Database;
use PDO;

class BorrowRequest {

    public static function create($userId, $bookId, $dueDate, $notes) {
        $db = Database::getInstance()->getConnection(); // ✅ sửa chỗ này

        $stmt = $db->prepare("
            INSERT INTO borrow_requests 
            (user_id, book_id, borrow_date, due_date, notes, status)
            VALUES (?, ?, NOW(), ?, ?, 'pending')
        ");
        return $stmt->execute([$userId, $bookId, $dueDate, $notes]);
    }

    public static function getPending() {
        $db = Database::getInstance()->getConnection(); // ✅ sửa

        $stmt = $db->query("
            SELECT 
                br.id AS request_id,
                br.book_id,
                br.user_id,
                br.borrow_date,
                br.due_date,
                u.name AS member_name,
                u.email AS member_email,
                b.title AS book_title,
                b.author,
                b.available_copies
            FROM borrow_requests br
            JOIN users u ON br.user_id = u.id
            JOIN books b ON br.book_id = b.id
            WHERE br.status = 'pending'
            ORDER BY br.borrow_date DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id) {
        $db = Database::getInstance()->getConnection(); // ✅ sửa

        $stmt = $db->prepare("SELECT * FROM borrow_requests WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function approve($id) {
        $db = Database::getInstance()->getConnection(); // ✅ sửa

        $stmt = $db->prepare("
            UPDATE borrow_requests 
            SET status='approved' 
            WHERE id=?
        ");
        return $stmt->execute([$id]);
    }

    public static function reject($id) {
        $db = Database::getInstance()->getConnection(); // ✅ sửa

        $stmt = $db->prepare("
            UPDATE borrow_requests 
            SET status='rejected' 
            WHERE id=?
        ");
        return $stmt->execute([$id]);
    }
}
