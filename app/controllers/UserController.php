<?php
require_once __DIR__ . '/../core/Controller.php';

class UserController extends Controller
{
    // ---------- USER PROFILE METHODS ----------

    // action: user_profile_index
    public function profile()
    {
        $this->requireAuth();
        $userId = $_SESSION['user_id'];
        $userModel = $this->model('User');

        $data = [
            'user' => $userModel->getUserProfile($userId),
            'stats' => $userModel->getBorrowStatistics($userId),
            'borrowedBooks' => $userModel->getActiveTransactions($userId)
        ];

        $this->view('user/profile/index', $data);
    }

    // action: user_profile_edit
    public function editProfile()
    {
        $this->requireAuth();
        $userId = $_SESSION['user_id'];
        $userModel = $this->model('User');
        $user = $userModel->getUserProfile($userId);
        $this->view('user/profile/edit', ['user' => $user]);
    }

    // action: user_profile_update
    public function updateProfile()
    {
        $this->requireAuth();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('user_profile_index');
        }

        $userId = $_SESSION['user_id'];
        $userModel = $this->model('User');

        $data = [
            'full_name' => trim($_POST['full_name'] ?? ''),
            'phone'     => trim($_POST['phone'] ?? ''),
            'address'   => trim($_POST['address'] ?? '')
        ];

        $userModel->updateProfile($userId, $data);
        $this->redirect('user_profile_index');
    }

    // action: user_change_password
    public function changePassword()
    {
        $this->requireAuth();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('user_profile_index');
        }

        $userId = $_SESSION['user_id'];
        $userModel = $this->model('User');

        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword     = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if ($newPassword !== $confirmPassword) {
            $_SESSION['error'] = 'Passwords do not match';
            $this->redirect('user_profile_index');
        }

        if (!$userModel->checkCurrentPassword($userId, $currentPassword)) {
            $_SESSION['error'] = 'Current password is incorrect';
            $this->redirect('user_profile_index');
        }

        $userModel->updatePassword($userId, $newPassword);
        $_SESSION['success'] = 'Password updated successfully';
        $this->redirect('user_profile_index');
    }

    // ---------- USER BORROW METHODS ----------

    // action: user_borrow_index
    public function borrowIndex()
    {
        $this->requireAuth();
        $userId = $_SESSION['user_id'];
        $userModel = $this->model('User');
        $borrowedBooks = $userModel->getActiveTransactions($userId);
        $this->view('user/borrow/index', ['borrowedBooks' => $borrowedBooks]);
    }

    // action: user_borrow_request
    public function borrowRequest()
    {
        $this->requireAuth();
        // Giả định logic request borrow, thêm vào Transaction model nếu cần
        $this->view('user/borrow/request');
    }

    // ---------- USER NOTIFICATIONS ----------

    // action: user_notifications_index
    public function notificationsIndex()
    {
        $this->requireAuth();
        $notificationModel = $this->model('Notification');
        $notifications = $notificationModel->getByUser($_SESSION['user_id']);  // Giả định method
        $this->view('user/notifications/index', ['notifications' => $notifications]);
    }

    // ---------- ADMIN USER METHODS ----------

    // action: admin_users_index
    public function adminIndex()
    {
        $this->requireAdmin();
        $userModel = $this->model('User');
        
        // Lấy search term và status filter từ GET parameters
        $search = trim($_GET['search'] ?? '');
        $status = trim($_GET['status'] ?? '');
        
        // Nếu có search hoặc filter thì dùng searchMembers, không thì dùng getAllMembers
        if (!empty($search) || !empty($status)) {
            $users = $userModel->searchMembers($search, $status);
        } else {
            $users = $userModel->getAllMembers();
        }
        
        $this->view('admin/users/index', [
            'users' => $users,
            'active' => 'users',
            'search' => $search,
            'status_filter' => $status
        ]);
    }

    // action: admin_users_show
    public function adminShow($id)
    {
        $this->requireAdmin();
        $userModel = $this->model('User');
        $user = $userModel->find($id);
        if (!$user || $userModel->isAdmin($id)) {
            // Chặn xem admin users
            $_SESSION['error'] = 'Cannot view admin accounts';
            $this->redirect('admin_users_index');
        }
        $this->view('admin/users/show', ['user' => $user]);
    }

    // action: admin_users_edit
    public function adminEdit($id)
    {
        $this->requireAdmin();
        $userModel = $this->model('User');
        $user = $userModel->find($id);
        if (!$user || $userModel->isAdmin($id)) {
            // Chặn sửa admin users
            $_SESSION['error'] = 'Cannot edit admin accounts';
            $this->redirect('admin_users_index');
        }
        $this->view('admin/users/edit', [
            'user' => $user,
            'active' => 'users'
        ]);
    }

        public function adminCreate()
        {
         $this->requireAdmin();

            $this->view('admin/users/create', [
              'active' => 'users'
         ]);
        }

    
        // action: admin_users_store
public function adminStore()
{
    $this->requireAdmin();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $this->redirect('admin_users_index');
    }

    $userModel = $this->model('User');

    $data = [
        'username'  => trim($_POST['username'] ?? ''),
        'email'     => trim($_POST['email'] ?? ''),
        'password'  => password_hash($_POST['password'], PASSWORD_DEFAULT),
        'full_name' => trim($_POST['full_name'] ?? ''),
        'phone'     => trim($_POST['phone'] ?? ''),
        'address'   => trim($_POST['address'] ?? ''),
        'role'      => 'member',  // Chỉ cho phép tạo member, không cho tạo admin
        'status'    => $_POST['status'] ?? 'active'
    ];

    // (optional) validate nhanh
    if ($data['username'] === '' || $data['email'] === '') {
        $_SESSION['error'] = 'Username & Email are required';
        $this->redirect('admin_users_create');
    }

    $userModel->create($data);
    $_SESSION['success'] = 'Member created successfully';

    $this->redirect('admin_users_index');
    }

    // action: admin_users_update
    public function adminUpdate($id)
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin_users_index');
        }

        $userModel = $this->model('User');
        
        // Chặn update admin users
        if ($userModel->isAdmin($id)) {
            $_SESSION['error'] = 'Cannot update admin accounts';
            $this->redirect('admin_users_index');
        }

        $user = $userModel->find($id);
        if (!$user) {
            $_SESSION['error'] = 'User not found';
            $this->redirect('admin_users_index');
        }

        $data = [
            'full_name' => trim($_POST['full_name'] ?? ''),
            'email'     => trim($_POST['email'] ?? ''),
            'phone'     => trim($_POST['phone'] ?? ''),
            'address'   => trim($_POST['address'] ?? ''),
            'status'    => $_POST['status'] ?? 'active'
        ];

        // Validate
        if ($data['full_name'] === '' || $data['email'] === '') {
            $_SESSION['error'] = 'Full name & Email are required';
            header("Location: index.php?action=admin_users_edit&id=$id");
            exit;
        }

        $userModel->updateMember($id, $data);
        $_SESSION['success'] = 'Member updated successfully';

        $this->redirect('admin_users_index');
    }
}