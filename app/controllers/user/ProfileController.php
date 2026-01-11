<?php

class User_ProfileController extends Controller
{
    public function index()
    {
        // Thông tin cá nhân
        return $this->view('user/profile/index');
    }

    public function edit()
    {
        // Chỉnh sửa thông tin
        return $this->view('user/profile/edit');
    }
}
