<?php
// app/models/Book.php

class Book extends Model {
    protected $table = 'books';
    
    public function getAllWithCategory() {
        $sql = "SELECT b.*, c.category_name 
                FROM books b 
                LEFT JOIN categories c ON b.category_id = c.category_id 
                ORDER BY b.created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getBookDetails($bookId) {
        $sql = "SELECT 
                    b.*, 
                    c.category_name,
                    COUNT(bc.copy_id) as total_copies,
                    SUM(CASE WHEN bc.status = 'available' THEN 1 ELSE 0 END) as available_copies,
                    SUM(CASE WHEN bc.status = 'borrowed' THEN 1 ELSE 0 END) as borrowed_copies
                FROM books b
                LEFT JOIN categories c ON b.category_id = c.category_id
                LEFT JOIN book_copies bc ON b.book_id = bc.book_id
                WHERE b.book_id = ?
                GROUP BY b.book_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$bookId]);
        return $stmt->fetch();
    }
    
    public function search($keyword, $categoryId = null) {
        $sql = "SELECT b.*, c.category_name,
                COUNT(bc.copy_id) as total_copies,
                SUM(CASE WHEN bc.status = 'available' THEN 1 ELSE 0 END) as available_copies
                FROM books b
                LEFT JOIN categories c ON b.category_id = c.category_id
                LEFT JOIN book_copies bc ON b.book_id = bc.book_id
                WHERE (b.title LIKE ? OR b.author LIKE ? OR b.isbn LIKE ?)";
        
        $params = ["%$keyword%", "%$keyword%", "%$keyword%"];
        
        if ($categoryId) {
            $sql .= " AND b.category_id = ?";
            $params[] = $categoryId;
        }
        
        $sql .= " GROUP BY b.book_id ORDER BY b.title";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    public function getByCategory($categoryId, $limit = null) {
        $sql = "SELECT b.*, c.category_name,
                SUM(CASE WHEN bc.status = 'available' THEN 1 ELSE 0 END) as available_copies
                FROM books b
                LEFT JOIN categories c ON b.category_id = c.category_id
                LEFT JOIN book_copies bc ON b.book_id = bc.book_id
                WHERE b.category_id = ?
                GROUP BY b.book_id
                ORDER BY b.created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT $limit";
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll();
    }
    
    public function getFeaturedBooks($limit = 8) {
        $sql = "SELECT b.*, c.category_name,
                COUNT(t.transaction_id) as borrow_count,
                SUM(CASE WHEN bc.status = 'available' THEN 1 ELSE 0 END) as available_copies
                FROM books b
                LEFT JOIN categories c ON b.category_id = c.category_id
                LEFT JOIN book_copies bc ON b.book_id = bc.book_id
                LEFT JOIN transactions t ON bc.copy_id = t.copy_id
                GROUP BY b.book_id
                ORDER BY borrow_count DESC
                LIMIT ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    public function getLatestBooks($limit = 8) {
        $sql = "SELECT b.*, c.category_name,
                SUM(CASE WHEN bc.status = 'available' THEN 1 ELSE 0 END) as available_copies
                FROM books b
                LEFT JOIN categories c ON b.category_id = c.category_id
                LEFT JOIN book_copies bc ON b.book_id = bc.book_id
                GROUP BY b.book_id
                ORDER BY b.created_at DESC
                LIMIT ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    public function canDelete($bookId) {
        $sql = "SELECT COUNT(*) as count 
                FROM book_copies bc
                JOIN transactions t ON bc.copy_id = t.copy_id
                WHERE bc.book_id = ? AND t.status = 'borrowed'";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$bookId]);
        $result = $stmt->fetch();
        
        return $result['count'] == 0;
    }
    
    public function getStats() {
        $sql = "SELECT 
                    COUNT(DISTINCT b.book_id) as total_books,
                    COUNT(bc.copy_id) as total_copies,
                    SUM(CASE WHEN bc.status = 'available' THEN 1 ELSE 0 END) as available_copies,
                    SUM(CASE WHEN bc.status = 'borrowed' THEN 1 ELSE 0 END) as borrowed_copies
                FROM books b
                LEFT JOIN book_copies bc ON b.book_id = bc.book_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }
}
