<?php
namespace App\Controllers;

use App\Models\User;

class AuthController extends Controller {
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $userModel = new User();
            $user = $userModel->findByEmail($email);
            
            if ($user && password_verify($password, $user['password'])) {
                if ($user['status'] === 'inactive') {
                    $error = "Tài khoản đã bị vô hiệu hóa";
                    $this->view('auth/login', ['error' => $error]);
                    return;
                }
                
                if ($userModel->isSuspended($user['user_id'])) {
                    $error = "Tài khoản đang bị tạm khóa. Lý do: " . $user['suspension_reason'];
                    $this->view('auth/login', ['error' => $error]);
                    return;
                }
                
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['user_name'] = $user['full_name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['user_phone'] = $user['phone'];
                
                if ($user['role'] === 'admin') {
                    $this->redirect('/admin/dashboard');
                } else {
                    $this->redirect('/');
                }
            } else {
                $error = "Email hoặc mật khẩu không đúng";
                $this->view('auth/login', ['error' => $error]);
            }
        } else {
            $this->view('auth/login');
        }
    }
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'full_name' => $_POST['full_name'],
                'phone' => $_POST['phone'],
                'address' => $_POST['address'],
                'role' => 'member',
                'status' => 'active'
            ];
            
            $userModel = new User();
            
            // Check if username exists
            if ($userModel->findByUsername($data['username'])) {
                $error = "Tên đăng nhập đã tồn tại";
                $this->view('auth/register', ['error' => $error]);
                return;
            }
            
            // Check if email exists
            if ($userModel->findByEmail($data['email'])) {
                $error = "Email đã được sử dụng";
                $this->view('auth/register', ['error' => $error]);
                return;
            }
            
            $userId = $userModel->create($data);
            
            if ($userId) {
                $_SESSION['user_id'] = $userId;
                $_SESSION['user_name'] = $data['full_name'];
                $_SESSION['user_email'] = $data['email'];
                $_SESSION['user_role'] = 'member';
                $_SESSION['user_phone'] = $data['phone'];
                
                $this->redirect('/');
            }
        } else {
            $this->view('auth/register');
        }
    }
    
    public function logout() {
        session_destroy();
        $this->redirect('/login');
    }
}