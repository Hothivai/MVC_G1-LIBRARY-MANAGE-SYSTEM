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
    session_start();


    $user_id = $_SESSION['user_id'];
    $user = $this->userModel->findById($user_id);

    return $this->view('user/profile/index', [
        'user' => $user
    ]);
}


    // ⭐ LMS-32: hiển thị form chỉnh sửa contact


    // ⭐ LMS-32: xử lý update contact
    public function update()
    {
        session_start();

        $user_id   = $_SESSION['user_id'];
        $full_name = $_POST['full_name'];
        $phone     = $_POST['phone'];
        $address   = $_POST['address'];

        $this->userModel->updateContact($user_id, $full_name, $phone, $address);

        header("Location: " . URLROOT . "/public/user/profile");
        exit;
    }
}
