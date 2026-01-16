<?php
class Book extends Model
{
    protected $table = 'books';

    public function countAll()
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM books");
        return $stmt->fetchColumn();
    }
}
?>