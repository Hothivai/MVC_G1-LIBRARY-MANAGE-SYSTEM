<?php
namespace App\Controllers;

use App\Controllers\Controller;

class BookController extends Controller
{
    public function index()
    {
        $bookModel = $this->model('Book');

        // Nhận category từ checkbox
        $categories = $_GET['cat'] ?? [];

        // Lấy sách theo category
        $latestBooks = $bookModel->getLatestBooks($categories);

        // Load view user
        require_once '../app/views/user/books/index.php';
    }
}
