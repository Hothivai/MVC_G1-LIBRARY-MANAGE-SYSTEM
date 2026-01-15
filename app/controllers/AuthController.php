<?php
require_once __DIR__ . '/../core/Controller.php';
?>
<?php

class AuthController extends Controller
{
    // 1. Hàm hiển thị trang đăng ký (GET /register)
    public function register()
    {

        // Sử dụng hàm view từ class Controller cha của bạn
        return $this->view('auth/register');
    }


    // 2. Hàm xử lý logic khi nhấn nút đăng ký (POST /register)
    public function handleRegister()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: /MVC_G1-LIBRARY-MANAGEMENT/public/register');
        exit;
    }

    // 1. Lấy dữ liệu từ form
    $fullName = trim($_POST['fullname'] ?? '');
    $phone    = trim($_POST['phone'] ?? null);
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    // 2. Validate cơ bản
    if ($fullName === '' || $email === '' || $password === '') {
        die('Missing required fields');
    }

    if ($password !== $confirm) {
        die('Passwords do not match');
    }

    // 3. 👉 TỰ SINH USERNAME TỪ EMAIL (QUY LUẬT NHÓM)
    $username = explode('@', $email)[0];

    // 4. Chuẩn bị data cho Model
    $data = [
        'username'  => $username,
        'email'     => $email,
        'password'  => $password,
        'full_name' => $fullName,
        'phone'     => $phone,
        'address'   => null
    ];

    // 5. Gọi Model
    require_once '../app/models/User.php';
    $userModel = new User();

    $result = $userModel->register($data);

    if (!$result) {
        die('Register failed (email or username exists)');
    }

    // 6. Redirect
    header('Location: /MVC_G1-LIBRARY-MANAGEMENT/public/login');
    exit;
}

}