<?php
class ProfileController extends Controller {
    // app/controllers/user/Profile.php
// app/controllers/Profile.php
public function index() {
    // Giả lập dữ liệu kể cả khi DB chưa có gì
    $data = [
        'user' => [
            'full_name' => 'Test User',
            'username'  => 'test_user',
            'email'     => 'test@example.com',
            'phone'     => '0123456789',
            'address'   => 'Hanoi, Vietnam',
            'status'    => 'active',
            'created_at' => date('Y-m-d H:i:s')
        ],
        'stats' => [
            'currently_borrowed' => 0,
            'returned_books'     => 0,
            'on_time_percentage' => 100
        ],
        'borrowedBooks' => [] // Mảng rỗng cho phần bảng
    ];

    $this->view('user/profile/index', $data);
}
}