<?php
// app/controllers/admin/CategoryController.php

class CategoryController extends Controller {
    
    private $categoryModel;
    
    public function __construct() {
        $this->categoryModel = $this->model('Category');
    }
    
    protected function redirect($url) {
        header('Location: ' . BASE_URL . $url);
        exit();
    }
    
    public function index() {
        $categories = $this->categoryModel->getAllWithBookCount();
        
        $data = ['categories' => $categories];
        
        $this->view('admin/categories/index', $data);
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'category_name' => trim($_POST['category_name'] ?? ''),
                'description' => trim($_POST['description'] ?? '')
            ];
            
            if (empty($data['category_name'])) {
                $_SESSION['error'] = 'Tên danh mục không được để trống';
                $this->redirect('admin/category/create');
            }
            
            if ($this->categoryModel->create($data)) {
                $_SESSION['success'] = 'Thêm danh mục mới thành công!';
                $this->redirect('admin/category');
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra. Vui lòng thử lại.';
            }
        }
        
        $this->view('admin/categories/create');
    }
    
    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'category_name' => trim($_POST['category_name'] ?? ''),
                'description' => trim($_POST['description'] ?? '')
            ];
            
            if (empty($data['category_name'])) {
                $_SESSION['error'] = 'Tên danh mục không được để trống';
                $this->redirect('admin/category/edit/' . $id);
            }
            
            if ($this->categoryModel->update($id, $data)) {
                $_SESSION['success'] = 'Cập nhật danh mục thành công!';
                $this->redirect('admin/category');
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra. Vui lòng thử lại.';
            }
        }
        
        $category = $this->categoryModel->find($id);
        
        if (!$category) {
            $_SESSION['error'] = 'Không tìm thấy danh mục';
            $this->redirect('admin/category');
        }
        
        $data = ['category' => $category];
        
        $this->view('admin/categories/edit', $data);
    }
    
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = 'Phương thức không được phép';
            $this->redirect('admin/category');
        }
        
        if (!$this->categoryModel->canDelete($id)) {
            $_SESSION['error'] = 'Không thể xóa danh mục đang có sách';
            $this->redirect('admin/category');
        }
        
        if ($this->categoryModel->delete($id)) {
            $_SESSION['success'] = 'Xóa danh mục thành công!';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra. Vui lòng thử lại.';
        }
        
        $this->redirect('admin/category');
    }
}