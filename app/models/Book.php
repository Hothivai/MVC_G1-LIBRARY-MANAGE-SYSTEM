<?php

class Book extends Model
{
    protected $table = 'books';
    protected string $primaryKey = 'book_id';

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

    /**
     * Get latest books for homepage
     */
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
}
