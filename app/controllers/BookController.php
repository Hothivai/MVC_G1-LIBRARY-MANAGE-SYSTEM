<?php
require_once __DIR__ . '/../core/Controller.php';

class BookController extends Controller
{
    // ---------- USER METHODS ----------

    // action: user_books_index
    public function userIndex()
    {
        $this->requireAuth();

        $bookModel = $this->model('Book');
        $categoryModel = $this->model('Category');

        // Get pagination and filter parameters
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 12;
        $searchQuery = $_GET['search'] ?? '';
        $selectedCategory = isset($_GET['category']) ? (string)$_GET['category'] : '';

        // Get books with search and category filter
        $categoryId = $selectedCategory ? (int)$selectedCategory : null;
        
        if ($searchQuery || $selectedCategory) {
            $allBooks = $bookModel->search($searchQuery, $categoryId);
        } else {
            $allBooks = $bookModel->getAllWithStats($categoryId);
        }

        // Calculate pagination
        $totalBooks = count($allBooks);
        $totalPages = ceil($totalBooks / $perPage);
        $page = min($page, $totalPages ?: 1);
        $offset = ($page - 1) * $perPage;
        $books = array_slice($allBooks, $offset, $perPage);

        // Get categories for filter
        $categories = $categoryModel->all();

        $data = [
            'books'            => $books,
            'categories'       => $categories,
            'searchQuery'      => $searchQuery,
            'selectedCategory' => $selectedCategory,
            'currentPage'      => $page,
            'totalPages'       => $totalPages,
            'totalBooks'       => $totalBooks
        ];

        $this->view('user/books/index', $data);
    }

    // action: user_books_show
    public function userShow(int $id)
    {
        $this->requireAuth();

        $bookModel = $this->model('Book');
        $categoryModel = $this->model('Category');

        $book = $bookModel->find($id);
        if (!$book) {
            $this->redirect('user_books_index');
        }

        $data = [
            'book'       => $book,
            'categories' => $categoryModel->all()
        ];

        $this->view('user/books/show', $data);
    }

// action: user_books_search
public function userSearch()
{
    $this->requireAuth();

    $bookModel     = $this->model('Book');
    $categoryModel = $this->model('Category');

    // ---- GET PARAMS ----
    $keyword = trim($_GET['search'] ?? '');
    $categoryId = isset($_GET['category']) && $_GET['category'] !== ''
        ? (int)$_GET['category']
        : null;

    $page    = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $perPage = 12;

    // ---- SEARCH DATA ----
    $allBooks = $bookModel->search($keyword, $categoryId);

    // ---- PAGINATION ----
    $totalBooks = count($allBooks);
    $totalPages = max(1, ceil($totalBooks / $perPage));
    $page       = min($page, $totalPages);
    $offset     = ($page - 1) * $perPage;

    $books = array_slice($allBooks, $offset, $perPage);

    // ---- CATEGORIES (FILTER) ----
    $categories = $categoryModel->all();

    // ---- VIEW DATA ----
    $this->view('user/books/index', [
        'books'            => $books,
        'categories'       => $categories,
        'searchQuery'      => $keyword,
        'selectedCategory' => $categoryId,
        'currentPage'      => $page,
        'totalPages'       => $totalPages,
        'totalBooks'       => $totalBooks
    ]);
}


    // action: user_books_borrow_request
    public function userBorrowRequest(int $id)
    {
        $this->requireAuth();

        $bookModel = $this->model('Book');
        $book = $bookModel->findWithCategory($id);

        if (!$book) {
            $this->redirect('user_books_index');
        }

        $this->view('user/borrow/request', [
            'book' => $book
        ]);
    }

    // ---------- ADMIN METHODS ----------

    // action: admin_books_index
    public function adminIndex()
    {
        $this->requireAdmin();
        $bookModel = $this->model('Book');
        $books = $bookModel->all();  // Giả định lấy tất cả books
        $this->view('admin/books/index', ['books' => $books]);
    }

    // action: admin_books_create
    public function adminCreate()
    {
        $this->requireAdmin();
        $this->view('admin/books/create');
    }

    // action: admin_books_edit
    public function adminEdit($id)
    {
        $this->requireAdmin();
        $bookModel = $this->model('Book');
        $book = $bookModel->find($id);
        if (!$book) {
            $this->redirect('admin_books_index');
        }
        $this->view('admin/books/edit', ['book' => $book]);
    }

    // action: admin_books_show
    public function adminShow($id)
    {
        $this->requireAdmin();
        $bookModel = $this->model('Book');
        $book = $bookModel->find($id);
        if (!$book) {
            $this->redirect('admin_books_index');
        }
        $this->view('admin/books/show', ['book' => $book]);
    }
    // action: admin_book_store
    public function adminStore()
    {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin_books_index');
        }

        // Xử lý upload ảnh (giả định)
        $coverImage = null;
        if (!empty($_FILES['cover_image']['name'])) {
            $coverImage = 'uploads/' . time() . '_' . $_FILES['cover_image']['name'];
            move_uploaded_file($_FILES['cover_image']['tmp_name'], APP_PATH . '/public/' . $coverImage);
        }

        $data = [
            'title' => $_POST['title'],
            'author' => $_POST['author'],
            'isbn' => $_POST['isbn'],
            'category_id' => $_POST['category_id'],
            'description' => $_POST['description'],
            'quantity' => $_POST['quantity'],
            'cover_image' => $coverImage,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $bookModel = $this->model('Book');
        if ($bookModel->create($data)) {  // Giả định Model có create()
            $this->redirect('admin_books_index');
        } else {
            // Handle error
            $this->redirect('admin_books_create');
        }
    }
}