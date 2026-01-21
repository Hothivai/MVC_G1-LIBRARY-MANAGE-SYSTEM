<?php

class User_NotificationController extends Controller
{
    public function index()
    {
        // Danh sách thông báo
        return $this->view('user/notifications/index');
    }
}
