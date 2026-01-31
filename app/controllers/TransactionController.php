<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Notification.php';
require_once __DIR__ . '/../models/Transaction.php';
class TransactionController extends Controller
{
    // action: admin_transactions_index
     protected $transactionModel;

    public function __construct()
    {
        $this->transactionModel = new Transaction();
    }
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
    public function checkDueDate()
{   
    $userId = Auth::getUserId();
    $transactionModel = new Transaction();
    $transactions = $transactionModel->getBorrowedBooks($userId);
    $noti = new Notification();
    $today = date('Y-m-d');

    foreach ($transactions as $t) {
        $due = date('Y-m-d', strtotime($t['due_date']));
        $diff = (strtotime($due) - strtotime($today)) / 86400;

        // sắp trễ hạn (1 ngày)
        if ($diff == 1 && !$noti->exists($t['user_id'], $t['transaction_id'], 'reminder')) {
            $noti->create([
                'user_id' => $t['user_id'],
                'transaction_id' => $t['transaction_id'],
                'type' => 'reminder',
                'title' => 'Sắp đến hạn trả sách',
                'message' => 'Sách bạn mượn sẽ đến hạn trả vào ngày mai.'
            ]);
        }

        // quá hạn
        if ($diff < 0 && !$noti->exists($t['user_id'], $t['transaction_id'], 'overdue')) {
            $noti->create([
                'user_id' => $t['user_id'],
                'transaction_id' => $t['transaction_id'],
                'type' => 'overdue',
                'title' => 'Quá hạn trả sách',
                'message' => 'Bạn đã quá hạn trả sách. Vui lòng trả sớm.'
            ]);
        }
    }
}
}
