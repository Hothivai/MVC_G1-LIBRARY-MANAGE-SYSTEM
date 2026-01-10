<?php
/**
 * Book Controller
 * Handles all book-related operations
 * This is an example of a Controller in MVC pattern
 */

require_once '../app/core/Controller.php';

class BookController extends Controller
{

  /**
   * Display all books (default action)
   * URL: /book or /book/index
   */
  public function index()
  {
    // Step 1: Load the model
    $bookModel = $this->model('Book');

    // Step 2: Get data from model
    $books = $bookModel->getAllBooks();

    // Step 3: Prepare data for view
    $data = [
      'title' => 'All Books',
      'books' => $books
    ];

    // Step 4: Load the view with data
    $this->view('books/index', $data);
  }

  /**
   * Display single book details
   * URL: /book/show/1 (where 1 is the book ID)
   * @param int $id - Book ID from URL
   */
  public function show($id)
  {
    $bookModel = $this->model('Book');
    $book = $bookModel->getBookById($id);

    if (!$book) {
      $_SESSION['error'] = 'Book not found.';
      $this->redirect('/book');
      return;
    }

    $data = [
      'title' => $book['title'],
      'book' => $book
    ];

    $this->view('books/show', $data);
  }

  /**
   * Display create book form
   * URL: /book/create
   */
  public function create()
  {
    $data = ['title' => 'Add New Book'];
    $this->view('books/create', $data);
  }

  /**
   * Process form submission to create new book
   * URL: /book/store (POST request)
   */
  public function store()
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      $this->redirect('/book/create');
      return;
    }

    // Validate input
    $errors = [];

    if (empty($_POST['title'])) {
      $errors[] = 'Title is required.';
    }
    if (empty($_POST['author'])) {
      $errors[] = 'Author is required.';
    }
    if (empty($_POST['isbn'])) {
      $errors[] = 'ISBN is required.';
    }

    if (!empty($errors)) {
      $_SESSION['errors'] = $errors;
      $_SESSION['old'] = $_POST;
      $this->redirect('/book/create');
      return;
    }

    // Prepare data
    $data = [
      'title' => trim($_POST['title']),
      'author' => trim($_POST['author']),
      'isbn' => trim($_POST['isbn']),
      'publisher' => trim($_POST['publisher'] ?? ''),
      'publication_year' => $_POST['publication_year'] ?? null,
      'category' => trim($_POST['category'] ?? ''),
      'description' => trim($_POST['description'] ?? '')
    ];

    $bookModel = $this->model('Book');
    $bookId = $bookModel->createBook($data);

    if ($bookId) {
      $_SESSION['success'] = 'Book added successfully!';
      $this->redirect('/book/show/' . $bookId);
    } else {
      $_SESSION['error'] = 'Failed to add book. Please try again.';
      $_SESSION['old'] = $_POST;
      $this->redirect('/book/create');
    }
  }

  /**
   * Display edit book form
   * URL: /book/edit/1
   * @param int $id - Book ID
   */
  public function edit($id)
  {
    $bookModel = $this->model('Book');
    $book = $bookModel->getBookById($id);

    if (!$book) {
      $_SESSION['error'] = 'Book not found.';
      $this->redirect('/book');
      return;
    }

    $data = [
      'title' => 'Edit Book',
      'book' => $book
    ];

    $this->view('books/edit', $data);
  }

  /**
   * Process form submission to update book
   * URL: /book/update/1 (POST request)
   * @param int $id - Book ID
   */
  public function update($id)
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      $this->redirect('/book/edit/' . $id);
      return;
    }

    // Validate input
    $errors = [];

    if (empty($_POST['title'])) {
      $errors[] = 'Title is required.';
    }
    if (empty($_POST['author'])) {
      $errors[] = 'Author is required.';
    }
    if (empty($_POST['isbn'])) {
      $errors[] = 'ISBN is required.';
    }

    if (!empty($errors)) {
      $_SESSION['errors'] = $errors;
      $_SESSION['old'] = $_POST;
      $this->redirect('/book/edit/' . $id);
      return;
    }

    // Prepare data
    $data = [
      'title' => trim($_POST['title']),
      'author' => trim($_POST['author']),
      'isbn' => trim($_POST['isbn']),
      'publisher' => trim($_POST['publisher'] ?? ''),
      'publication_year' => $_POST['publication_year'] ?? null,
      'category' => trim($_POST['category'] ?? ''),
      'description' => trim($_POST['description'] ?? '')
    ];

    $bookModel = $this->model('Book');

    if ($bookModel->updateBook($id, $data)) {
      $_SESSION['success'] = 'Book updated successfully!';
      $this->redirect('/book/show/' . $id);
    } else {
      $_SESSION['error'] = 'Failed to update book. Please try again.';
      $_SESSION['old'] = $_POST;
      $this->redirect('/book/edit/' . $id);
    }
  }

  /**
   * Delete a book
   * URL: /book/delete/1
   * @param int $id - Book ID
   */
  public function delete($id)
  {
    $bookModel = $this->model('Book');

    if ($bookModel->deleteBook($id)) {
      $_SESSION['success'] = 'Book deleted successfully!';
    } else {
      $_SESSION['error'] = 'Failed to delete book.';
    }

    $this->redirect('/book');
  }
}
