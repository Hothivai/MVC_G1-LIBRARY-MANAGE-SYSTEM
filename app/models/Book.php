<?php
namespace App\Models;

class Book extends Model {
    protected $table = 'books';
    protected $primaryKey = 'book_id';
    
    public function getAvailableCopies($bookId) {
        $sql = "SELECT COUNT(*) as count FROM book_copies 
                WHERE book_id = ? AND status = 'available'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$bookId]);
        return $stmt->fetch()['count'];
    }
    
    public function getTotalCopies($bookId) {
        $sql = "SELECT COUNT(*) as count FROM book_copies WHERE book_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$bookId]);
        return $stmt->fetch()['count'];
    }
    
    public function search($keyword, $categoryId = null) {
        $sql = "SELECT b.*, c.category_name FROM books b 
                JOIN categories c ON b.category_id = c.category_id 
                WHERE (b.title LIKE ? OR b.author LIKE ? OR b.isbn LIKE ?)";
        
        $params = ["%$keyword%", "%$keyword%", "%$keyword%"];
        
        if ($categoryId) {
            $sql .= " AND b.category_id = ?";
            $params[] = $categoryId;
        }
        
        $sql .= " ORDER BY b.title";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    public function getFeaturedBooks($limit = 4) {
        $sql = "SELECT b.*, c.category_name, 
                (SELECT COUNT(*) FROM book_copies bc WHERE bc.book_id = b.book_id AND bc.status = 'available') as available_copies
                FROM books b 
                JOIN categories c ON b.category_id = c.category_id 
                ORDER BY b.book_id DESC LIMIT ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
    
    public function getLatestBooks($limit = 8) {
        $sql = "SELECT b.*, c.category_name, 
                (SELECT COUNT(*) FROM book_copies bc WHERE bc.book_id = b.book_id AND bc.status = 'available') as available_copies
                FROM books b 
                JOIN categories c ON b.category_id = c.category_id 
                ORDER BY b.created_at DESC LIMIT ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
}