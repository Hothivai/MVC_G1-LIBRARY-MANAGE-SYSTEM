<?php
// require_once __DIR__ . '/../models/User.php';
// class ProfileController extends Controller {
//     // app/controllers/user/Profile.php
// // app/controllers/Profile.php
// public function index() {
//     // Giả lập dữ liệu kể cả khi DB chưa có gì
//     $data = [
//         'user' => [
//             'full_name' => 'Test User',
//             'username'  => 'test_user',
//             'email'     => 'test@example.com',
//             'phone'     => '0123456789',
//             'address'   => 'Hanoi, Vietnam',
//             'status'    => 'active',
//             'created_at' => date('Y-m-d H:i:s')
//         ],
//         'stats' => [
//             'currently_borrowed' => 0,
//             'returned_books'     => 0,
//             'on_time_percentage' => 100
//         ],
//         'borrowedBooks' => [] // Mảng rỗng cho phần bảng
//     ];

//     $this->view('user/profile/index', $data);
//     }
// }
// class UserController
// {
//     private $userModel;

//     public function __construct($db)
//     {
//         $this->userModel = new User($db);
//     }

//     // Hiển thị profile
//     public function index()
//     {
//         if (!isset($_SESSION['user_id'])) {
//             header('Location: /auth/login');
//             exit;
//         }

//         $userId = $_SESSION['user_id'];
//         $user = $this->userModel->findById($userId);

//         require_once __DIR__ . '/../views/user/profile/index.php';
//     }

//     // Hiển thị form edit
//     public function edit()
//     {
//         if (!isset($_SESSION['user_id'])) {
//             header('Location: /auth/login');
//             exit;
//         }

//         $userId = $_SESSION['user_id'];
//         $user = $this->userModel->findById($userId);

//         require_once __DIR__ . '/../views/user/profile/edit.php';
//     }

//     // Xử lý submit edit
//     public function update()
//     {
//         if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
//             header('Location: /user/profile/index');
//             exit;
//         }

//         $userId = $_SESSION['user_id'];

//         $data = [
//             'full_name' => $_POST['full_name'] ?? '',
//             'email'     => $_POST['email'] ?? '',
//             'phone'     => $_POST['phone'] ?? '',
//             'address'   => $_POST['address'] ?? ''
//         ];

//         $this->userModel->updateProfile($userId, $data);

//         // edit xong quay về index
//         header('Location: /user/profile/index');
//         exit;
//     }
// }
require_once __DIR__ . '/../models/User.php';

class UserController extends Controller
{
    private $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User($this->db);
    }

    // VIEW PROFILE
    public function profile()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit;
        }

        $userId = $_SESSION['user_id'];

        $data = [
            'user' => $this->userModel->getUserProfile($userId),
            'stats' => $this->userModel->getBorrowStatistics($userId),
            'borrowedBooks' => $this->userModel->getActiveTransactions($userId)
        ];

        $this->view('user/profile/index', $data);
    }

    // UPDATE PROFILE (MODAL)
    public function updateProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /profile');
            exit;
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit;
        }

        $userId = $_SESSION['user_id'];

        $data = [
            'full_name' => trim($_POST['full_name'] ?? ''),
            'phone'     => trim($_POST['phone'] ?? ''),
            'address'   => trim($_POST['address'] ?? '')
        ];

        $this->userModel->updateProfile($userId, $data);

        header('Location: /profile');
        exit;
    }

    // CHANGE PASSWORD (MODAL)
    public function changePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /profile');
            exit;
        }

        $userId = $_SESSION['user_id'];

        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword     = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if ($newPassword !== $confirmPassword) {
            $_SESSION['error'] = 'Passwords do not match';
            header('Location: /profile');
            exit;
        }

        if (!$this->userModel->checkCurrentPassword($userId, $currentPassword)) {
            $_SESSION['error'] = 'Current password is incorrect';
            header('Location: /profile');
            exit;
        }

        $this->userModel->updatePassword($userId, $newPassword);

        $_SESSION['success'] = 'Password updated successfully';
        header('Location: /profile');
        exit;
    }
}
