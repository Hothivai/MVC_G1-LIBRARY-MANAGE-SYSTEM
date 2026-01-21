<?php

class Admin_UserController extends Controller
{
    public function index()
    {
        // Danh sách người dùng
        return $this->view('admin/users/index');
    }

    public function show($id)
    {
        // Chi tiết người dùng
        return $this->view('admin/users/show');
    }

    public function edit($id)
    {
        // Chỉnh sửa người dùng
        return $this->view('admin/users/edit');
    }
}
