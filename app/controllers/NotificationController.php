<?php

class Admin_NotificationController extends Controller
{
    public function index()
    {
        // Danh sách thông báo đã gửi
        return $this->view('admin/notifications/index');
    }

    public function create()
    {
        // Tạo thông báo mới
        return $this->view('admin/notifications/create');
    }
}
class User_NotificationController extends Controller
{
    public function index()
    {
        // Danh sách thông báo
        return $this->view('user/notifications/index');
    }
}
