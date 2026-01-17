<?php
namespace App\Models;

class Book extends Model {
    protected $table = 'books';
    protected $primaryKey = 'book_id';

    // 1. Lấy danh sách sách (có tìm kiếm + lọc danh mục + đếm số lượng có sẵn)
    public function search($keyword, $categoryId = null) {
        $sql = "SELECT b.*, c.category_name, 
                (SELECT COUNT(*) FROM book_copies bc WHERE bc.book_id = b.book_id AND bc.status = 'available') as available_copies
                FROM books b 
                LEFT JOIN categories c ON b.category_id = c.category_id 
                WHERE (b.title LIKE ? OR b.author LIKE ? OR b.isbn LIKE ?)";
        
        $params = ["%$keyword%", "%$keyword%", "%$keyword%"];
        
        if ($categoryId) {
            $sql .= " AND b.category_id = ?";
            $params[] = $categoryId;
        }
        
        $sql .= " ORDER BY b.book_id DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    // 2. Lấy chi tiết 1 cuốn sách (kèm tên danh mục)
    public function findWithCategory($id) {
        $sql = "SELECT b.*, c.category_name 
                FROM books b 
                LEFT JOIN categories c ON b.category_id = c.category_id 
                WHERE b.book_id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    // 3. Lấy sách mới nhất (cho trang Home)
    public function getLatestBooks($limit = 8) {
        $sql = "SELECT b.*, c.category_name, 
                (SELECT COUNT(*) FROM book_copies bc WHERE bc.book_id = b.book_id AND bc.status = 'available') as available_copies
                FROM books b 
                LEFT JOIN categories c ON b.category_id = c.category_id 
                ORDER BY b.created_at DESC LIMIT ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
    
    // 4. Lấy sách nổi bật (Ở đây lấy ngẫu nhiên cho phong phú)
    public function getFeaturedBooks($limit = 4) {
        $sql = "SELECT b.*, c.category_name, 
                (SELECT COUNT(*) FROM book_copies bc WHERE bc.book_id = b.book_id AND bc.status = 'available') as available_copies
                FROM books b 
                LEFT JOIN categories c ON b.category_id = c.category_id 
                ORDER BY RAND() LIMIT ?"; // Lấy ngẫu nhiên
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    // 5. Đếm số lượng cụ thể (Hỗ trợ trang Show)
    public function getAvailableCopies($bookId) {
        $sql = "SELECT COUNT(*) as count FROM book_copies WHERE book_id = ? AND status = 'available'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$bookId]);
        $res = $stmt->fetch();
        return $res['count'] ?? 0;
    }

    public function getTotalCopies($bookId) {
        $sql = "SELECT COUNT(*) as count FROM book_copies WHERE book_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$bookId]);
        $res = $stmt->fetch();
        return $res['count'] ?? 0;
    }
}