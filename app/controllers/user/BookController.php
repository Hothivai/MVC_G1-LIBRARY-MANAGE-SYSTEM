<?php

class User_BookController extends Controller
{
    public function index()
    {
        // Xem danh sách sách
        return $this->view('user/books/index');
    }

    public function show($id)
    {
        // Xem chi tiết sách
        return $this->view('user/books/show');
    }

    public function search()
    {
        // Tìm kiếm sách
        return $this->view('user/books/search');
    }
}
