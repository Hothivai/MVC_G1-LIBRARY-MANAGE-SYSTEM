<?php
require_once __DIR__ . '/../core/Controller.php';

class HomeController extends Controller
{
    // action: home_index
    public function index()
    {
        $user = $_SESSION['user'] ?? null;

        // load model qua core Controller
        $bookModel = $this->model('Book');
        $categoryModel = $this->model('Category');

        // chuẩn bị dữ liệu
        $data = [
            'user' => $user,
            'featuredBooks' => $bookModel->getFeaturedBooks(4),
            'latestBooks' => $bookModel->getLatestBooks(8),
            'categories' => $categoryModel->all()
        ];

        // render view 1 lần duy nhất
        $this->view('home/index', $data);
    }

    // action: home_about
    public function about()
    {
        $this->view('home/about');
    }
}