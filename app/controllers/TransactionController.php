<?php
require_once __DIR__ . '/../core/Controller.php';

class TransactionController extends Controller
{
    // action: admin_transactions_index
    public function index()
    {
        $this->requireAdmin();

        $transactionModel = $this->model('Transaction');

        $data = [
            'transactions' => $transactionModel->getRecent(),
            'active'       => 'transactions'
        ];

        $this->view('admin/transactions/index', $data);
    }

    // action: admin_transactions_approve
    public function processReturn()
    {
        $this->requireAdmin();

        // Lấy ID từ POST (khớp với form ở View)
        $transactionId = $_POST['transaction_id'] ?? null;

        if ($transactionId) {
            $transactionModel = $this->model('Transaction');
            $notificationModel = $this->model('Notification');

            // 1. Cập nhật trạng thái 'returned' và 'return_date'
            if ($transactionModel->markAsReturned($transactionId)) {

                // 2. Lấy thông tin để gửi thông báo cho User
                $transaction = $transactionModel->findById($transactionId);
            }
        }

        // Quay lại trang danh sách giao dịch
        header('Location: index.php?action=admin_transactions_index');
        exit;
    }

    // action: admin_transactions_return
    public function return($id)
    {
        $this->requireAdmin();

        if (!$id) {
            header('Location: index.php?action=admin_transactions_index');
            exit;
        }

        $transactionModel = $this->model('Transaction');

        $transaction = $transactionModel->findById($id);
        if (!$transaction) {
            header('Location: index.php?action=admin_transactions_index');
            exit;
        }

        $data = [
            'transaction' => $transaction,
            'active'      => 'transactions'
        ];

        $this->view('admin/transactions/index', $data);
    }
}
