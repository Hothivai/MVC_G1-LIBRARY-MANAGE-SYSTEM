<?php
namespace App\Controllers;

use App\Models\Book;
use App\Models\Category;

class HomeController extends Controller {
    
    public function index() {
        $bookModel = new Book();
        $categoryModel = new Category();
        
        $data = [
            'featuredBooks' => $bookModel->getFeaturedBooks(4),
            'latestBooks' => $bookModel->getLatestBooks(8),
            'categories' => $categoryModel->all()
        ];
        
        $this->view('home/index', $data);
    }
    
    public function about() {
        $this->view('home/about');
    }
}