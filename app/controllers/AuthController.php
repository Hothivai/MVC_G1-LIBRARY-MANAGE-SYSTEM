<?php

class AuthController extends Controller
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle login logic
        }
        return $this->view('auth/login');
    }

//   public function register()
//     {
//     if ($_SERVER['REQUEST_METHOD'] === 'POST') {

//         $phone = $_POST['phone'];
//         $password = $_POST['password'];
//         $confirm = $_POST['confirm_password'];

//         // Phone: phải đủ 10 số
//         if (strlen($phone) != 10) {
//             echo "Phone must be 10 digits";
//             return;
//         }

//         // Password: ít nhất 8 ký tự
//         if (strlen($password) < 8) {
//             echo "Password must be at least 8 characters";
//             return;
//         }

//         // Password phải có chữ
//         if (!preg_match('/[A-Za-z]/', $password)) {
//             echo "Password must contain letters";
//             return;
//         }

//         // Password phải có số
//         if (!preg_match('/[0-9]/', $password)) {
//             echo "Password must contain numbers";
//             return;
//         }

//         // Confirm password
//         if ($password !== $confirm) {
//             echo "Confirm password does not match";
//             return;
//         }

//         echo "Register successfully!";
//     }

//     return $this->view('auth/register');
// }
// }