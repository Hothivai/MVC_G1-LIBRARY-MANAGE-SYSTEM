<?php
namespace App\Models;

use PDO;

class Category extends Model
{
    protected string $table = 'categories';
    protected string $primaryKey = 'category_id';

    public function all(): array
    {
        $stmt = $this->db->query("SELECT * FROM categories ORDER BY category_name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
