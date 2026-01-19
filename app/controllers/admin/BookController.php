<?php
// app/controllers/admin/BookController.php

if (!defined('BASE_URL')) {
    define('BASE_URL', '/');
}

class BookController extends Controller {
    
    private $bookModel;
    private $categoryModel;
    private $transactionModel;
    
    protected function redirect($path) {
        header('Location: ' . BASE_URL . $path);
        exit;
    }
    
    protected function requireLogin() {
        if (!isset($_SESSION['user'])) {
            $this->redirect('login');
        }
    }
    
    protected function requireAdmin() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $this->redirect('');
        }
    }
    
    public function __construct() {
        $this->requireLogin();
        $this->requireAdmin();
        
        $this->bookModel = $this->model('Book');
        $this->categoryModel = $this->model('Category');
        $this->transactionModel = $this->model('Transaction');
    }
    
    public function index() {
        $books = $this->bookModel->getAllWithCategory();
        $categories = $this->categoryModel->all();
        
        $data = [
            'books' => $books,
            'categories' => $categories
        ];
        
        $this->view('admin/books/index', $data);
    }
    
    public function show($id) {
        $book = $this->bookModel->getBookDetails($id);
        
        if (!$book) {
            $_SESSION['error'] = 'Không tìm thấy sách';
            $this->redirect('admin/book');
        }
        
        $history = $this->transactionModel->getBookHistory($id);
        
        $data = [
            'book' => $book,
            'history' => $history
        ];
        
        $this->view('admin/books/show', $data);
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'category_id' => $_POST['category_id'] ?? '',
                'isbn' => trim($_POST['isbn'] ?? ''),
                'title' => trim($_POST['title'] ?? ''),
                'author' => trim($_POST['author'] ?? ''),
                'publisher' => trim($_POST['publisher'] ?? ''),
                'published_year' => $_POST['published_year'] ?? '',
                'description' => trim($_POST['description'] ?? '')
            ];
            
            // Upload image
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $uploadDir = '../public/uploads/books/';
                $fileName = time() . '_' . $_FILES['image']['name'];
                $uploadFile = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $data['image_url'] = '/uploads/books/' . $fileName;
                }
            }
            
            if ($this->bookModel->create($data)) {
                $_SESSION['success'] = 'Thêm sách mới thành công!';
                $this->redirect('admin/book');
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra. Vui lòng thử lại.';
            }
        }
        
        $categories = $this->categoryModel->all();
        $data = ['categories' => $categories];
        
        $this->view('admin/books/create', $data);
    }
    
    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'category_id' => $_POST['category_id'] ?? '',
                'isbn' => trim($_POST['isbn'] ?? ''),
                'title' => trim($_POST['title'] ?? ''),
                'author' => trim($_POST['author'] ?? ''),
                'publisher' => trim($_POST['publisher'] ?? ''),
                'published_year' => $_POST['published_year'] ?? '',
                'description' => trim($_POST['description'] ?? '')
            ];
            
            // Upload new image if provided
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $uploadDir = '../public/uploads/books/';
                $fileName = time() . '_' . $_FILES['image']['name'];
                $uploadFile = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $data['image_url'] = '/uploads/books/' . $fileName;
                }
            }
            
            if ($this->bookModel->update($id, $data)) {
                $_SESSION['success'] = 'Cập nhật sách thành công!';
                $this->redirect('admin/book/show/' . $id);
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra. Vui lòng thử lại.';
            }
        }
        
        $book = $this->bookModel->find($id);
        $categories = $this->categoryModel->all();
        
        if (!$book) {
            $_SESSION['error'] = 'Không tìm thấy sách';
            $this->redirect('admin/book');
        }
        
        $data = [
            'book' => $book,
            'categories' => $categories
        ];
        
        $this->view('admin/books/edit', $data);
    }
    
    public function delete($id) {
        if (!$this->bookModel->canDelete($id)) {
            $_SESSION['error'] = 'Không thể xóa sách đang được mượn';
            $this->redirect('admin/book');
        }
        
        if ($this->bookModel->delete($id)) {
            $_SESSION['success'] = 'Xóa sách thành công!';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra. Vui lòng thử lại.';
        }
        
        $this->redirect('admin/book');
    }
}