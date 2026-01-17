<?php
namespace App\Controllers;

use App\Models\Book;
use App\Models\Category;

class HomeController extends Controller {
    
    public function index() {
        // 1. Khởi tạo Model
        $bookModel = new Book();
        $categoryModel = new Category();
        
        // 2. Lấy dữ liệu
        // Featured: Lấy 4 sách mới nhất theo ID
        $featuredBooks = $bookModel->getFeaturedBooks(4);
        
        // Latest: Lấy 8 sách mới nhất theo ngày tạo
        // (Đảm bảo DB bảng books có cột created_at, nếu không sẽ lỗi)
        $latestBooks = $bookModel->getLatestBooks(8);
        
        // Category: Lấy tất cả danh mục (Hàm all() phải có trong Model cha)
        $categories = $categoryModel->all();
        
        // 3. Chuẩn bị dữ liệu gửi sang View
        $data = [
            'featuredBooks' => $featuredBooks,
            'latestBooks'   => $latestBooks,
            'categories'    => $categories
        ];
        
        // 4. Gọi View
        $this->view('home/index', $data);
    }
    
    public function about() {
        $this->view('home/about');
    }
}