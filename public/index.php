<?php
// 1. Cấu hình & Session
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Load Config & Core Classes
require_once '../config/config.php';
require_once '../app/core/Database.php';
require_once '../app/core/Controller.php';
require_once '../app/core/Model.php';
require_once '../app/core/Auth.php';
require_once '../app/core/Middleware.php';

// 3. Lấy Controller và Action từ URL
// Mặc định là 'home' và 'index'
$controllerInput = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$actionInput = isset($_GET['action']) ? $_GET['action'] : 'index';

// 4. Chuẩn hóa tên (Ví dụ: 'auth' -> 'AuthController')
$controllerName = ucfirst($controllerInput) . 'Controller';
$actionName = $actionInput;

// 5. Tìm file Controller (Quét cả thư mục gốc, admin và user)
$pathsToCheck = [
    '../app/controllers/' . $controllerName . '.php',
    '../app/controllers/admin/' . $controllerName . '.php',
    '../app/controllers/user/' . $controllerName . '.php'
];

$controllerPath = null;
foreach ($pathsToCheck as $path) {
    if (file_exists($path)) {
        $controllerPath = $path;
        require_once $path;
        break;
    }
}

// 6. Khởi tạo và chạy
if ($controllerPath) {
    // Xử lý Namespace/Class Name
    // Code cũ của bạn có class tên là Admin_BookController, User_BookController
    // Để code gọn, ta sẽ kiểm tra class tồn tại.
    
    $className = $controllerName; // Mặc định: BookController

    // Logic fallback để hỗ trợ cách đặt tên class cũ của bạn
    if (!class_exists($className)) {
        if (class_exists('Admin_' . $controllerName)) {
            $className = 'Admin_' . $controllerName;
        } elseif (class_exists('User_' . $controllerName)) {
            $className = 'User_' . $controllerName;
        } elseif (class_exists("App\\Controllers\\" . $controllerName)) {
            $className = "App\\Controllers\\" . $controllerName;
        }
    }

    if (class_exists($className)) {
        $controller = new $className();
        
        if (method_exists($controller, $actionName)) {
            $controller->$actionName();
        } else {
            // Action không tồn tại -> Về trang chủ
            header("Location: index.php?controller=home&action=index");
        }
    } else {
        die("Lỗi: Class '$className' không tìm thấy trong file.");
    }
} else {
    die("Lỗi: Không tìm thấy file cho controller '$controllerInput'.");
}
?>