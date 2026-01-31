<?php

class Admin_TransactionController extends Controller
{
    public function index()
    {
        // Danh sách giao dịch
        return $this->view('admin/transactions/index');
    }

    public function pending()
    {
        // Yêu cầu chờ duyệt
        return $this->view('admin/transactions/pending');
    }

    public function approve($id)
    {
        // Duyệt mượn sách
        return $this->view('admin/transactions/approve');
    }

    public function return($id)
    {
        // Xử lý trả sách
        return $this->view('admin/transactions/return');
    }
}
