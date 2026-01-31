<?php
require_once __DIR__ . '/../core/Model.php';

class Category extends Model
{
    protected string $table = 'categories';
    protected string $primaryKey = 'category_id';

    public function all(): array
    {
        $stmt = $this->db->query("SELECT * FROM categories ORDER BY category_name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Find category by name (case-insensitive)
     */
    public function findByName(string $name): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE LOWER(category_name) = LOWER(?) LIMIT 1");
        $stmt->execute([trim($name)]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Create new category and return its ID
     */
    public function createCategory(string $name): ?int
    {
        $stmt = $this->db->prepare("INSERT INTO categories (category_name) VALUES (?)");
        if ($stmt->execute([trim($name)])) {
            return (int) $this->db->lastInsertId();
        }
        return null;
    }
}
