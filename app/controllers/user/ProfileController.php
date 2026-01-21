<?php

require_once '../app/models/User.php';
require_once '../app/core/Database.php';

class ProfileController extends Controller
{
    private $userModel;

    public function __construct()
    {
        $database = new Database();
        $db = $database->getConnection();

        // ✅ TRUYỀN $db VÀO MODEL
        $this->userModel = new User($db);
    }

    // Trang profile
    public function index()
    {
        return $this->view('user/profile/index');
    }

    // ⭐ LMS-32: hiển thị form chỉnh sửa contact
    public function edit()
    {
        session_start();

        $user_id = $_SESSION['user_id'];

        // ✅ ĐÚNG TÊN HÀM
        $user = $this->userModel->findById($user_id);

        return $this->view('user/profile/edit', [
            'user' => $user
        ]);
    }

    // ⭐ LMS-32: xử lý update contact
    public function update()
    {
        session_start();

        $user_id   = $_SESSION['user_id'];
        $full_name = $_POST['full_name'];
        $phone     = $_POST['phone'];

        $this->userModel->updateContact($user_id, $full_name, $phone);

        header("Location: " . URLROOT . "/public/user/profile");
        exit;
    }
}
