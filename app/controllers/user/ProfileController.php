<?php
class ProfileController extends Controller {
    public function index() {
    // Tạm thời comment đoạn kiểm tra này để làm task 31/33
    /*
    if(!isset($_SESSION['user_id'])) {
         header('Location: /login');
         exit();
    }
    */
    
    // Giả lập dữ liệu để View không bị lỗi
    $userId = 1; 
    $userModel = $this->model('User'); // Sử dụng hàm model() từ Controller base

    $data['user'] = $userModel->getUserProfile($userId);
    $data['stats'] = $userModel->getBorrowStatistics($userId);

    $this->view('user/profile/index', $data); //
}
}