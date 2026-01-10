<?php
/**
 * Book Model
 * Handles all database operations for books
 * This is an example of a Model in MVC pattern
 */

class Book
{
  private $db;

  public function __construct()
  {
    // Get database connection from Database singleton
    $this->db = Database::getInstance()->getConnection();
  }

  /**
   * Get all books from database
   * @return array - Array of books
   */
  public function getAllBooks()
  {
    try {
      $query = "SELECT * FROM books ORDER BY title ASC";

      $stmt = $this->db->prepare($query);
      $stmt->execute();
      return $stmt->fetchAll();
    } catch (PDOException $e) {
      error_log("Error in getAllBooks: " . $e->getMessage());
      return [];
    }
  }

  /**
   * Get single book by ID
   * @param int $id - Book ID
   * @return array|false - Book data or false if not found
   */
  public function getBookById($id)
  {
    try {
      $query = "SELECT * FROM books WHERE id = :id";

      $stmt = $this->db->prepare($query);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
      return $stmt->fetch();
    } catch (PDOException $e) {
      error_log("Error in getBookById: " . $e->getMessage());
      return false;
    }
  }

  /**
   * Create a new book (INSERT)
   * @param array $data - Book data
   * @return int|false - Returns inserted ID or false on failure
   */
  public function createBook($data)
  {
    try {
      // Prepare SQL query with placeholders to prevent SQL injection
      $query = "INSERT INTO books (title, author, isbn, publisher, publication_year, category, description)
                      VALUES (:title, :author, :isbn, :publisher, :publication_year, :category, :description)";

      $stmt = $this->db->prepare($query);

      // Bind parameters
      $stmt->bindParam(':title', $data['title']);
      $stmt->bindParam(':author', $data['author']);
      $stmt->bindParam(':isbn', $data['isbn']);
      $stmt->bindParam(':publisher', $data['publisher']);
      $stmt->bindParam(':publication_year', $data['publication_year']);
      $stmt->bindParam(':category', $data['category']);
      $stmt->bindParam(':description', $data['description']);

      // Execute query
      if ($stmt->execute()) {
        // Return the ID of the newly created book
        return $this->db->lastInsertId();
      }
      return false;
    } catch (PDOException $e) {
      error_log("Error in createBook: " . $e->getMessage());
      return false;
    }
  }

  /**
   * Update an existing book (UPDATE)
   * @param int $id - Book ID
   * @param array $data - Updated book data
   * @return bool - True on success, false on failure
   */
  public function updateBook($id, $data)
  {
    try {
      $query = "UPDATE books
                      SET title = :title,
                          author = :author,
                          isbn = :isbn,
                          publisher = :publisher,
                          publication_year = :publication_year,
                          category = :category,
                          description = :description
                      WHERE id = :id";

      $stmt = $this->db->prepare($query);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->bindParam(':title', $data['title']);
      $stmt->bindParam(':author', $data['author']);
      $stmt->bindParam(':isbn', $data['isbn']);
      $stmt->bindParam(':publisher', $data['publisher']);
      $stmt->bindParam(':publication_year', $data['publication_year']);
      $stmt->bindParam(':category', $data['category']);
      $stmt->bindParam(':description', $data['description']);

      return $stmt->execute();
    } catch (PDOException $e) {
      error_log("Error in updateBook: " . $e->getMessage());
      return false;
    }
  }

  /**
   * Delete a book (DELETE)
   * @param int $id - Book ID
   * @return bool - True on success, false on failure
   */
  public function deleteBook($id)
  {
    try {
      $query = "DELETE FROM books WHERE id = :id";
      $stmt = $this->db->prepare($query);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      return $stmt->execute();
    } catch (PDOException $e) {
      error_log("Error in deleteBook: " . $e->getMessage());
      return false;
    }
  }
}