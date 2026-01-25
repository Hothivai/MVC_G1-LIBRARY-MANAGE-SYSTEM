<?php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../core/Middleware.php';

class DashboardController extends Controller
{
    // action: index
    public function index()
    {
        // kiểm tra quyền admin
        Middleware::requireAdmin();

        // load model
        $bookModel = $this->model('Book');
        $userModel = $this->model('User');
        $transactionModel = $this->model('Transaction');

        // chuẩn bị dữ liệu cho view
        $data = [
            'totalBooks'        => $bookModel->countAll(),
            'borrowedBooks'     => $transactionModel->countBorrowed(),
            'members'           => $userModel->countUsers(),
            'overdue'           => $transactionModel->countOverdue(),
            'recentTransactions'=> $transactionModel->getRecent(),
            'overdueList'       => $transactionModel->getOverdueList(),
            'active'            => 'dashboard'
        ];

        // gọi view
        $this->view('admin/dashboard/index', $data);
    }
}
