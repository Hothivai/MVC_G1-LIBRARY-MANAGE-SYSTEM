<?php
namespace App\Controllers\User;

use App\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;

class BookController extends Controller
{
    public function index()
    {
        $this->requireAuth();

        $bookModel = new Book();
        $categoryModel = new Category();

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

    public function show(int $id)
    {
        $this->requireAuth();

        $bookModel = new Book();
        $categoryModel = new Category();

        $book = $bookModel->find($id);
        if (!$book) {
            $this->redirect('/user/books');
        }

        $data = [
            'book'       => $book,
            'categories' => $categoryModel->all()
        ];

        $this->view('user/books/show', $data);
    }

    public function search()
    {
        $this->requireAuth();

        $keyword    = $_GET['q'] ?? $_GET['search'] ?? '';
        $selectedCategory = isset($_GET['category']) ? (string)$_GET['category'] : '';
        $categoryId = $selectedCategory ? (int)$selectedCategory : null;

        $bookModel = new Book();
        $categoryModel = new Category();

        // Get pagination and filter parameters
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 12;

        // Get books with search
        $allBooks = $bookModel->search($keyword, $categoryId);

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
            'searchQuery'      => $keyword,
            'selectedCategory' => $selectedCategory,
            'currentPage'      => $page,
            'totalPages'       => $totalPages,
            'totalBooks'       => $totalBooks
        ];

        $this->view('user/books/index', $data);
    }
}
