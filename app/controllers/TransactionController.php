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
