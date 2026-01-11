<?php

class User_BorrowController extends Controller
{
    public function index()
    {
        // Lịch sử mượn sách
        return $this->view('user/borrow/index');
    }

    public function request()
    {
        // Yêu cầu mượn sách
        return $this->view('user/borrow/request');
    }
}
