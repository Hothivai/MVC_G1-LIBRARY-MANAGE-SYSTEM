<?php
namespace App\Controllers\User;

use App\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;

class BookController extends Controller {
    
    public function index() {
        $this->requireAuth();
        
        $bookModel = new Book();
        $categoryModel = new Category();
        
        $data = [
            'books' => $bookModel->all(),
            'categories' => $categoryModel->all()
        ];
        
        $this->view('user/books/index', $data);
    }
    
    public function show($id) {
        $this->requireAuth();
        
        $bookModel = new Book();
        $book = $bookModel->find($id);
        
        if (!$book) {
            $this->redirect('/books');
        }
        
        $availableCopies = $bookModel->getAvailableCopies($id);
        $totalCopies = $bookModel->getTotalCopies($id);
        
        $data = [
            'book' => $book,
            'availableCopies' => $availableCopies,
            'totalCopies' => $totalCopies
        ];
        
        $this->view('user/books/show', $data);
    }
    
    public function search() {
        $this->requireAuth();
        
        $keyword = $_GET['q'] ?? '';
        $categoryId = $_GET['category'] ?? null;
        
        $bookModel = new Book();
        $categoryModel = new Category();
        
        $data = [
            'keyword' => $keyword,
            'books' => $bookModel->search($keyword, $categoryId),
            'categories' => $categoryModel->all(),
            'selectedCategory' => $categoryId
        ];
        
        $this->view('user/books/search', $data);
    }
}