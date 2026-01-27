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
            'pendingRequests' => $borrowRequestModel->getPendingRequests(),
            'active'          => 'borrow_requests'
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


        // load models
        $borrowRequestModel = $this->model('BorrowRequest');
        $bookModel          = $this->model('Book');
        $transactionModel   = $this->model('Transaction');


        // lấy request
        $request = $borrowRequestModel->find($requestId);
        if (!$request) {
            header('Location: index.php?action=admin_requests');
            exit;
        }


        // lấy copy sách còn trống
        $copyId = $bookModel->getAvailableCopy($request['book_id']);
        if (!$copyId) {
            header('Location: index.php?action=admin_requests');
            exit;
        }


        // tạo transaction
        $transactionModel->createTransaction(
            $request['user_id'],
            $copyId,
            $request['due_date']
        );


        // cập nhật trạng thái request
        $borrowRequestModel->approve($requestId);


        // giảm số sách còn lại
        $bookModel->decreaseAvailable($request['book_id']);


        header('Location: index.php?action=admin_requests');
        exit;
    }


    // (optional) action: admin_requests_reject
    public function reject()
    {
        $this->requireAdmin();


        $requestId = $_POST['request_id'] ?? null;
        if ($requestId) {
            $borrowRequestModel = $this->model('BorrowRequest');
            $borrowRequestModel->reject($requestId);
        }


        header('Location: index.php?action=admin_requests');
        exit;
    }
}