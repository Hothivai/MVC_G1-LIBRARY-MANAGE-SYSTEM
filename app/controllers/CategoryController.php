<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Category.php';

class CategoryController extends Controller
{
    // action: admin_categories_index
    public function index()
    {
        $this->requireAdmin();

        $categoryModel = new Category();
        $categories = $categoryModel->all();

        $this->view('admin/categories/index', [
            'categories' => $categories
        ]);
    }

    // action: admin_categories_create
    public function create()
    {
        $this->requireAdmin();
        $this->view('admin/categories/create');
    }

    // action: admin_categories_edit&id=1
    public function edit($id)
    {
        $this->requireAdmin();

        $categoryModel = new Category();
        $category = $categoryModel->find($id);

        $this->view('admin/categories/edit', [
            'category' => $category
        ]);
    }
}
