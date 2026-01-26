<?php
require_once __DIR__ . '/../core/Controller.php';

class DashboardController extends Controller
{
    // action: admin_dashboard_index
    public function index()
    {
        // kiểm tra quyền admin (giữ hoặc xóa nếu đã có trong index.php)
        $this->requireAdmin();

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
