<?php
require_once __DIR__ . '/../models/Book.php';
require_once __DIR__ . '/../models/Transaction.php';
require_once __DIR__ . '/../models/BorrowRequest.php';
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Middleware.php';
use App\Models\BorrowRequest;
use App\Models\Notification;
class BorrowRequestController
{
    public function index()
    {
        Middleware::requireAdmin();

        $model = new BorrowRequest();
        $pendingRequests = $model->getPendingRequests();

        $this->view('admin/request', [
            'pendingRequests' => $pendingRequests
        ]);
    }

    public function approve_request()
    {
        $requestId = $_POST['request_id'] ?? null;
        if (!$requestId) return;

        // static → OK
        $request = BorrowRequest::find($requestId);
        if (!$request) return;

        //  Book là NON-static → phải new
        $bookModel = new Book();
        $copyId = $bookModel->getAvailableCopy($request['book_id']);
        if (!$copyId) return;

        //  Transaction là NON-static → phải new
        $transactionModel = new Transaction();
        $transactionModel->createTransaction(
            $request['user_id'],
            $copyId,
            $request['due_date']
        );

        // static → OK
        BorrowRequest::approve($requestId);

        // non-static → new
        $bookModel->decreaseAvailable($request['book_id']);

        header('Location: index.php?action=admin_requests');
        exit;
    }
    public function approve($transactionId)
{
    // logic duyệt mượn (đã có sẵn)
    $transaction = $this->transactionModel->find($transactionId);
    $this->transactionModel->approve($transactionId);

    // tạo notification
    $noti = new Notification();
    $noti->create([
        'user_id' => $transaction['user_id'],
        'transaction_id' => $transactionId,
        'type' => 'info',
        'title' => 'Yêu cầu mượn sách được duyệt',
        'message' => 'Yêu cầu mượn sách của bạn đã được admin duyệt.Ban hãy đến thư viện để nhận sách.'
    ]);

}
}