<?php
require_once __DIR__ . '/../core/Controller.php';

class TransactionController extends Controller
{
    // action: admin_transactions_index
    public function index()
    {
        $this->requireAdmin();
        $this->view('admin/transactions/index');
    }

    // action: admin_transactions_pending (nếu cần, thêm vào index.php nếu thiếu)
    public function pending()
    {
        $this->requireAdmin();
        $this->view('admin/transactions/pending');
    }

    // action: admin_transactions_approve
    public function approve($id)
    {
        $this->requireAdmin();
        $this->view('admin/transactions/approve', ['id' => $id]);
    }

    // action: admin_transactions_return
    public function return($id)
    {
        $this->requireAdmin();
        $this->view('admin/transactions/return', ['id' => $id]);
    }
}
