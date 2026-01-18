<?php
namespace App\Controllers;

use App\Models\Book;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $bookModel = new Book();
        $categoryModel = new Category();

        $data = [
            'featuredBooks' => $bookModel->getFeaturedBooks(4),
            'latestBooks' => $bookModel->getLatestBooks(8),
            'categories' => $categoryModel->all()
        ];

        // Debug
        // error_log('Featured Books: ' . count($data['featuredBooks']));
        // error_log('Categories: ' . count($data['categories']));

        $this->view('home/index', $data);
    }
    
}
