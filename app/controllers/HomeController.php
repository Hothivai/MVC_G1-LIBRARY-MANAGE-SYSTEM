<?php
namespace App\Controllers;

use App\Models\Book;
use App\Models\Category;

class HomeController extends Controller
{
    // public function index()
    // {
    //     $user = $_SESSION['user'] ?? null;

    //     $this->view('home/index', [
    //         'user' => $user
    //     ]);
    //     $bookModel = new Book();
    //     $categoryModel = new Category();

    //     $data = [
    //         'featuredBooks' => $bookModel->getFeaturedBooks(4),
    //         'latestBooks' => $bookModel->getLatestBooks(8),
    //         'categories' => $categoryModel->all()
    //     ];

    //     // Debug
    //     // error_log('Featured Books: ' . count($data['featuredBooks']));
    //     // error_log('Categories: ' . count($data['categories']));

    //     $this->view('home/index', $data);
    // }
    public function index()
    {
    $user = $_SESSION['user'] ?? null;

    // Khởi tạo model (chuẩn MVC)
    $bookModel = $this->model('Book');
    $categoryModel = $this->model('Category');

    // Chuẩn bị dữ liệu
    $data = [
        'user' => $user,
        'featuredBooks' => $bookModel->getFeaturedBooks(4),
        'latestBooks' => $bookModel->getLatestBooks(8),
        'categories' => $categoryModel->all()
    ];

    // Render view DUY NHẤT 1 LẦN
    $this->view('home/index', $data);
}
}
?>