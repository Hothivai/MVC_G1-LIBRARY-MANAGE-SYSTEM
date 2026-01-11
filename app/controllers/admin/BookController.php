<?php

class Admin_BookController extends Controller
{
    public function index()
    {
        // Danh sách sách
        return $this->view('admin/books/index');
    }

    public function create()
    {
        // Thêm sách mới
        return $this->view('admin/books/create');
    }

    public function edit($id)
    {
        // Sửa thông tin sách
        return $this->view('admin/books/edit');
    }

    public function show($id)
    {
        // Chi tiết sách
        return $this->view('admin/books/show');
    }
}
