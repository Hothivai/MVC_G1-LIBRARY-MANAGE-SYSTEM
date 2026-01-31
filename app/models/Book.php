<?php
require_once __DIR__ . '/../core/Model.php';

class Book extends Model
{
    protected string $table = 'books';
    protected string $primaryKey = 'book_id';

    // Get books with category and availability stats (for book index page)
    public function getAllWithStats(?int $categoryId = null): array
    {
        $sql = "
            SELECT 
                b.*,
                c.category_name,
                COUNT(bc.copy_id) AS total_copies,
                SUM(bc.status = 'available') AS available_copies
            FROM books b
            JOIN categories c ON b.category_id = c.category_id
            LEFT JOIN book_copies bc ON b.book_id = bc.book_id
        ";

        $params = [];

        if ($categoryId) {
            $sql .= " WHERE b.category_id = ?";
            $params[] = $categoryId;
        }

        $sql .= " GROUP BY b.book_id ORDER BY b.created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get featured books for homepage
     */
    public function getFeaturedBooks(int $limit): array
    {
        $sql = "
            SELECT 
                b.*,
                c.category_name,
                COUNT(bc.copy_id) AS total_copies,
                SUM(bc.status = 'available') AS available_copies
            FROM books b
            JOIN categories c ON b.category_id = c.category_id
            LEFT JOIN book_copies bc ON b.book_id = bc.book_id
            GROUP BY b.book_id
            ORDER BY RAND()
            LIMIT :limit
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get latest books for homepage
    public function getLatestBooks(int $limit): array
    {
        $sql = "
            SELECT 
                b.*,
                c.category_name,
                COUNT(bc.copy_id) AS total_copies,
                SUM(bc.status = 'available') AS available_copies
            FROM books b
            JOIN categories c ON b.category_id = c.category_id
            LEFT JOIN book_copies bc ON b.book_id = bc.book_id
            GROUP BY b.book_id
            ORDER BY b.created_at DESC
            LIMIT :limit
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Search books by keyword and/or category
    public function search(string $keyword = '', ?int $categoryId = null): array
    {
        $sql = "
        SELECT 
            b.*,
            c.category_name,
            COUNT(bc.copy_id) AS total_copies,
            COALESCE(
                SUM(CASE WHEN bc.status = 'available' THEN 1 ELSE 0 END),
                0
            ) AS available_copies
        FROM books b
        LEFT JOIN categories c ON b.category_id = c.category_id
        LEFT JOIN book_copies bc ON b.book_id = bc.book_id
    ";

        $conditions = [];
        $params     = [];

        if ($keyword !== '') {
            $conditions[] = "(b.title LIKE :kw OR b.author LIKE :kw OR b.isbn LIKE :kw)";
            $params[':kw'] = '%' . $keyword . '%';
        }

        if ($categoryId !== null) {
            $conditions[] = "b.category_id = :cat";
            $params[':cat'] = $categoryId;
        }

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }

        $sql .= " GROUP BY b.book_id ORDER BY b.created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Find book with category information
    public function findWithCategory(int $id): ?array
    {
        $sql = "
            SELECT 
                b.*,
                c.category_name,
                COUNT(bc.copy_id) AS total_copies,
                SUM(bc.status = 'available') AS available_copies
            FROM books b
            JOIN categories c ON b.category_id = c.category_id
            LEFT JOIN book_copies bc ON b.book_id = bc.book_id
            WHERE b.book_id = ?
            GROUP BY b.book_id
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $book = $stmt->fetch(PDO::FETCH_ASSOC);

        return $book ?: null;
    }

    // Override find method to include category
    public function find($id)
    {
        return $this->findWithCategory($id);
    }

    // Count total books
    public function countAll(): int
    {
        $sql = "SELECT COUNT(*) AS total FROM {$this->table}";
        $stmt = $this->db->query($sql);
        return (int) $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // Lấy 1 bản copy còn available của sách
    public function getAvailableCopy(int $bookId): ?int
    {
        $stmt = $this->db->prepare("
        SELECT copy_id 
        FROM book_copies
        WHERE book_id = ? AND status = 'available'
        LIMIT 1
    ");
        $stmt->execute([$bookId]);
        $copy = $stmt->fetch(PDO::FETCH_ASSOC);

        return $copy ? $copy['copy_id'] : null;
    }

    /**
     * Create a new book
     */
    public function create(array $data): bool
    {
        $fields = [];
        $placeholders = [];
        $values = [];

        foreach ($data as $key => $value) {
            if ($value !== null) {
                $fields[] = $key;
                $placeholders[] = '?';
                $values[] = $value;
            }
        }

        $sql = "INSERT INTO {$this->table} (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $placeholders) . ")";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($values);
    }

    /**
     * Update an existing book
     */
    public function update(int $id, array $data): bool
    {
        $fields = [];
        $values = [];

        foreach ($data as $key => $value) {
            if ($key !== $this->primaryKey && $value !== null) {
                $fields[] = "$key = ?";
                $values[] = $value;
            }
        }

        if (empty($fields)) {
            return false;
        }

        $values[] = $id;
        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE {$this->primaryKey} = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($values);
    }

    /**
     * Delete a book by ID
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
}
