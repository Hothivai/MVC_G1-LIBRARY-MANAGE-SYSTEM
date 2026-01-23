<?php
namespace App\Controllers\Admin;
use App\Controllers\Controller;
use App\Core\Middleware;
class DashboardController extends Controller
{
    public function index()
    {
        Middleware::requireAdmin();

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
