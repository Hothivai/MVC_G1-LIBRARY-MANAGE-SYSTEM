<?php

class User_ProfileController extends Controller
{
    private $userModel;

    public function __construct() {
        // Khởi tạo User Model để tương tác với DB
        $this->userModel = $this->model('User');
    }

    public function index()
    {
        // Giả sử lấy ID user từ Session đã lưu khi đăng nhập
        $userId = $_SESSION['user_id'];
        $userData = $this->userModel->getUserById($userId);

        // Truyền dữ liệu user ra view thông tin cá nhân
        return $this->view('user/profile/index', ['user' => $userData]);
    }

    public function edit()
    {
        // Hiển thị form chỉnh sửa thông tin (tên, email, số điện thoại...)
        return $this->view('user/profile/edit');
    }

    // --- PHẦN BỔ SUNG CHO ĐỔI MẬT KHẨU ---

    /**
     * Hiển thị giao diện form đổi mật khẩu
     */
    public function changePassword()
    {
        return $this->view('user/profile/change_password');
    }

    /**
     * Xử lý logic cập nhật mật khẩu mới
     */
    public function updatePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userId = $_SESSION['user_id'];
            $oldPass = $_POST['old_password'] ?? '';
            $newPass = $_POST['new_password'] ?? '';
            $confirmPass = $_POST['confirm_password'] ?? '';

            // 1. Kiểm tra rỗng
            if (empty($oldPass) || empty($newPass) || empty($confirmPass)) {
                $this->setFlash('error', 'Vui lòng nhập đầy đủ các trường.');
                return $this->redirect('/profile/change-password');
            }

            // 2. Lấy thông tin user hiện tại từ Database
            $user = $this->userModel->getUserById($userId);

            // 3. Xác minh mật khẩu cũ
            if (!password_verify($oldPass, $user->password)) {
                $this->setFlash('error', 'Mật khẩu hiện tại không chính xác.');
                return $this->redirect('/profile/change-password');
            }

            // 4. Kiểm tra mật khẩu mới và xác nhận
            if ($newPass !== $confirmPass) {
                $this->setFlash('error', 'Mật khẩu mới và xác nhận không khớp.');
                return $this->redirect('/profile/change-password');
            }

            // 5. Kiểm tra độ dài mật khẩu (Ví dụ tối thiểu 6 ký tự)
            if (strlen($newPass) < 6) {
                $this->setFlash('error', 'Mật khẩu mới phải có ít nhất 6 ký tự.');
                return $this->redirect('/profile/change-password');
            }

            // 6. Cập nhật vào DB thông qua Model
            if ($this->userModel->updatePassword($userId, $newPass)) {
                $this->setFlash('success', 'Đổi mật khẩu thành công!');
                return $this->redirect('/profile');
            } else {
                $this->setFlash('error', 'Có lỗi xảy ra, vui lòng thử lại.');
                return $this->redirect('/profile/change-password');
            }
        }
    }

    /**
     * Hàm hỗ trợ nhanh để hiển thị thông báo (Flash message)
     */
    private function setFlash($key, $message) {
        $_SESSION[$key] = $message;
    }

    private function redirect($url) {
        header("Location: $url");
        exit;
    }
}