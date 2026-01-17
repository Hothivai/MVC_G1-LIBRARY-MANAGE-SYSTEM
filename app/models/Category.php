<?php
namespace App\Models;

class Category extends Model {
    protected $table = 'categories';
    protected $primaryKey = 'category_id';
    
    public function getBookCount($categoryId) {
        $sql = "SELECT COUNT(*) as count FROM books WHERE category_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$categoryId]);
        return $stmt->fetch()['count'];
    }
}