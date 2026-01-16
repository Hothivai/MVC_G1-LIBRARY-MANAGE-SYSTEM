<?php
require_once './app/core/Controller.php';
require_once './app/core/Middleware.php';

class DashboardController extends Controller
{
    public function index()
    {
        Middleware::checkAdmin();

        $bookModel = $this->model('Book');
        $userModel = $this->model('User');
        $transactionModel = $this->model('Transaction');

        $data = [
            'totalBooks' => $bookModel->countAll(),
            'borrowedBooks' => $transactionModel->countBorrowed(),
            'members' => $userModel->countUsers(),
            'overdue' => $transactionModel->countOverdue(),
            'recentTransactions' => $transactionModel->getRecent(),
            'overdueList' => $transactionModel->getOverdueList(),
            'active' => 'dashboard'
        ];

        $this->view('admin/dashboard/index', $data);
    }
}
