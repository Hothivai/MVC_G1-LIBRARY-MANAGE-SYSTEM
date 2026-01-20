<?php

class HomeController extends Controller
{
    public function index()
    {
        $user = $_SESSION['user'] ?? null;
        $bookModel = $this->model('Book');
        $categoryModel = $this->model('Category');

        $data = [
            'user' => $user,
            'featuredBooks' => $bookModel->getFeaturedBooks(4),
            'latestBooks' => $bookModel->getLatestBooks(8),
            'categories' => $categoryModel->all()
        ];

        $this->view('home/index', $data);
    }
}