<?php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../core/Middleware.php';

class Admin_BookController extends Controller
{
    public function index()
    {
        $this->view('admin/books/index');
    }

    public function create()
    {
        $this->view('admin/books/create');
    }

    public function edit($id)
    {
        $this->view('admin/books/edit', ['id' => $id]);
    }

    public function show($id)
    {
        $this->view('admin/books/show', ['id' => $id]);
    }
}
