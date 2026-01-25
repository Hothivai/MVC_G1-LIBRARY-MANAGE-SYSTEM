<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/User.php';

class UserController extends Controller
{
    private $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User($this->db);
    }

    // action = profile
    public function profile()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
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

    // action = updateProfile
    public function updateProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=profile');
            exit;
        }

        $userId = $_SESSION['user_id'];

        $data = [
            'full_name' => trim($_POST['full_name'] ?? ''),
            'phone'     => trim($_POST['phone'] ?? ''),
            'address'   => trim($_POST['address'] ?? '')
        ];

        $this->userModel->updateProfile($userId, $data);

        header('Location: index.php?action=profile');
        exit;
    }

    // action = changePassword
    public function changePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=profile');
            exit;
        }

        $userId = $_SESSION['user_id'];

        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword     = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if ($newPassword !== $confirmPassword) {
            $_SESSION['error'] = 'Passwords do not match';
            header('Location: index.php?action=profile');
            exit;
        }

        if (!$this->userModel->checkCurrentPassword($userId, $currentPassword)) {
            $_SESSION['error'] = 'Current password is incorrect';
            header('Location: index.php?action=profile');
            exit;
        }

        $this->userModel->updatePassword($userId, $newPassword);

        $_SESSION['success'] = 'Password updated successfully';
        header('Location: index.php?action=profile');
        exit;
    }
}
