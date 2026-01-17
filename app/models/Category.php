<?php
namespace App\Models;

class Category extends Model {
    protected $table = 'categories';
    protected $primaryKey = 'category_id';
    
    // Hàm mới: Lấy danh sách danh mục + đếm số lượng sách có trong mỗi danh mục
    // Dùng cho trang chủ (Home)
    public function getAllWithStats() {
        $sql = "SELECT c.*, COUNT(b.book_id) as total_books 
                FROM categories c 
                LEFT JOIN books b ON c.category_id = b.category_id 
                GROUP BY c.category_id, c.category_name";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Hàm cũ: Đếm sách của 1 danh mục cụ thể (giữ lại để dùng cho trang khác)
    public function getBookCount($categoryId) {
        $sql = "SELECT COUNT(*) as count FROM books WHERE category_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$categoryId]);
        $result = $stmt->fetch();
        return $result ? $result['count'] : 0;
    }
}