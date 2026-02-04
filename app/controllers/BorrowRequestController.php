<?php
require_once __DIR__ . '/../core/Controller.php';


class BorrowRequestController extends Controller
{
    // action: admin_requests
    public function index()
    {
        $this->requireAdmin();
        // load model
        $borrowRequestModel = $this->model('BorrowRequest');
        // lấy dữ liệu
        $data = [
            'pendingRequests' => $borrowRequestModel->getAdminRequests(),
            'active'          => 'requests'
        ];
        // gọi view
        $this->view('admin/requests', $data);
    }
    // action: admin_requests_approve
    public function approve()
    {
        $this->requireAdmin();
        $requestId = $_POST['request_id'] ?? null;
        if (!$requestId) {
            header('Location: index.php?action=admin_requests');
            exit;
        }
        $borrowRequestModel = $this->model('BorrowRequest');
        $bookModel          = $this->model('Book');
        $transactionModel   = $this->model('Transaction');
        $notificationModel  = $this->model('Notification');
        $request = $borrowRequestModel->findById($requestId);
        if (!$request) {
            header('Location: index.php?action=admin_requests');
            exit;
        }
        $copyId = $bookModel->getAvailableCopy($request['book_id']);
        if (!$copyId) {
            header('Location: index.php?action=admin_requests');
            exit;
        }
        // tính ngày trả sách (14 ngày kể từ ngày mượn)
        $dueDate = date('Y-m-d', strtotime('+14 days'));
        // tạo transaction
        $transactionId = $transactionModel->createTransaction(
            $request['user_id'],
            $copyId,
            $dueDate
        );
        if ($transactionId) {
            // cập nhật request
            $borrowRequestModel->approve($requestId);

            // gửi thông báo đến user
            $notificationModel->create([
                'user_id' => $request['user_id'],
                'transaction_id' => $transactionId,
                'type' => 'approved',
                'title' => 'Yêu cầu mượn sách đã được chấp nhận',
                'message' => 'Yêu cầu mượn sách của bạn đã được chấp nhận, hãy tới thư viện để lấy sách'
            ]);
        }
        header('Location: index.php?action=admin_requests');
        exit;
    }

    // action: admin_requests_reject
    public function reject()
    {
        $this->requireAdmin();

        $requestId = $_POST['request_id'] ?? null;
        if ($requestId) {
            $borrowRequestModel = $this->model('BorrowRequest');
            $notificationModel  = $this->model('Notification');

            $request = $borrowRequestModel->findById($requestId);
            if ($request) {
                $borrowRequestModel->reject($requestId);
            }
        }

        header('Location: index.php?action=admin_requests');
        exit;
    }

    // action: user_borrow_request_store
    public function store()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=auth_login');
            exit;
        }
        $userId   = $_SESSION['user_id'];
        $bookId   = $_POST['book_id'] ?? null;
        $quantity = $_POST['quantity'] ?? 1;
        $note     = $_POST['notes'] ?? '';

        if (!$bookId) {
            header('Location: index.php?action=home_index');
            exit;
        }
        $borrowRequestModel = $this->model('BorrowRequest');
        $borrowRequestModel->create(
            $userId,
            $bookId,
            $quantity,
            $note
        );
        header('Location: index.php?action=home_index');
        exit;
    }
}
