<?php

class Admin_CategoryController extends Controller
{
    public function index()
    {
        // Danh sách danh mục
        return $this->view('admin/categories/index');
    }

    public function create()
    {
        // Thêm danh mục
        return $this->view('admin/categories/create');
    }

    public function edit($id)
    {
        // Sửa danh mục
        return $this->view('admin/categories/edit');
    }
}
