<?php

require_once __DIR__ . '/../models/User.php';

class UserController
{
    private $userModel;

    public function __construct($db)
    {
        $this->userModel = new User($db);
    }

    // Hiển thị profile
    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $user = $this->userModel->findById($userId);

        require_once __DIR__ . '/../views/user/profile/index.php';
    }

    // Hiển thị form edit
    public function edit()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $user = $this->userModel->findById($userId);

        require_once __DIR__ . '/../views/user/profile/edit.php';
    }

    // Xử lý submit edit
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /user/profile/index');
            exit;
        }

        $userId = $_SESSION['user_id'];

        $data = [
            'full_name' => $_POST['full_name'] ?? '',
            'email'     => $_POST['email'] ?? '',
            'phone'     => $_POST['phone'] ?? '',
            'address'   => $_POST['address'] ?? ''
        ];

        $this->userModel->updateProfile($userId, $data);

        // edit xong quay về index
        header('Location: /user/profile/index');
        exit;
    }
}
