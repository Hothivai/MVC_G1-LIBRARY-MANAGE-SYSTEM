<?php
require_once __DIR__ . '/../core/Controller.php';
?>
<?php

class AuthController extends Controller
{
    // 1. Hàm hiển thị trang đăng ký (GET /register)
    public function register()
    {
        echo "REGISTER OK"; die;
        // Sử dụng hàm view từ class Controller cha của bạn
        return $this->view('auth/register');
    }


    // 2. Hàm xử lý logic khi nhấn nút đăng ký (POST /register)
    public function handleRegister()
    {
        // Lấy dữ liệu từ FORM
        $phone = $_POST['phone'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        // --- BẮT ĐẦU KIỂM TRA (LMS-20) ---

        // Kiểm tra Phone: phải đúng 10 số
        if (strlen($phone) !== 10 || !is_numeric($phone)) {
            die("Lỗi: Số điện thoại phải có đúng 10 chữ số.");
        }

        // Kiểm tra Password: ít nhất 8 ký tự
        if (strlen($password) < 8) {
            die("Lỗi: Mật khẩu phải có ít nhất 8 ký tự.");
        }

        // Password phải có CHỮ
        if (!preg_match('/[A-Za-z]/', $password)) {
            die("Lỗi: Mật khẩu phải chứa ít nhất một chữ cái.");
        }

        // Password phải có SỐ
        if (!preg_match('/[0-9]/', $password)) {
            die("Lỗi: Mật khẩu phải chứa ít nhất một chữ số.");
        }

        // Password phải có KÝ TỰ ĐẶC BIỆT (Yêu cầu thêm của bạn)
        if (!preg_match('/[@$!%*#?&]/', $password)) {
            die("Lỗi: Mật khẩu phải chứa ít nhất một ký tự đặc biệt (@$!%*#?&).");
        }

        // Xác nhận mật khẩu
        if ($password !== $confirm) {
            die("Lỗi: Xác nhận mật khẩu không khớp.");
        }

        // --- NẾU MỌI THỨ OK ---
        echo "Chúc mừng! Dữ liệu hợp lệ. Hệ thống sẽ lưu vào database (LMS-18).";
        
        // Bước tiếp theo ở đây sẽ là gọi Model User để lưu dữ liệu
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Logic đăng nhập sau này
        }
        return $this->view('auth/login');
    }
}