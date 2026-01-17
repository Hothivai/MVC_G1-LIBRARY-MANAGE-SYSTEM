<?php
// public/index.php

// Define base path
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
define('PUBLIC_PATH', __DIR__);

// Load configuration
require_once BASE_PATH . '/config/config.php';
require_once BASE_PATH . '/config/database.php';

// Autoload classes (SỬA LẠI PHẦN NÀY)
spl_autoload_register(function($className) {
    // Chuyển namespace prefix "App\" thành đường dẫn thực tế
    // Ví dụ: App\Controllers\HomeController => app/controllers/HomeController.php
    $prefix = 'App\\';
    $base_dir = APP_PATH . '/';

    // Kiểm tra xem class có sử dụng prefix 'App\' không
    $len = strlen($prefix);
    if (strncmp($prefix, $className, $len) !== 0) {
        // Nếu không có namespace App, thử load trực tiếp từ thư mục app (dành cho các class cũ chưa chuẩn hóa)
        $file = APP_PATH . '/' . str_replace('\\', '/', $className) . '.php';
        if (file_exists($file)) {
            require_once $file;
        }
        return;
    }

    // Lấy phần tên class sau prefix
    $relative_class = substr($className, $len);

    // Tạo đường dẫn file
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // Fix lỗi viết hoa/thường (Linux case-sensitive): 
    // Chuẩn hóa folder Controllers, Models thành chữ thường nếu thư mục thực tế là chữ thường
    // Tuy nhiên, tốt nhất là sửa tên thư mục cho khớp Namespace.
    
    if (file_exists($file)) {
        require_once $file;
    }
});

// Include core files (Thứ tự quan trọng)
require_once APP_PATH . '/core/Database.php'; // Load Database trước
require_once APP_PATH . '/core/Model.php';
require_once APP_PATH . '/core/Controller.php';
require_once APP_PATH . '/core/Router.php';
require_once APP_PATH . '/core/Auth.php';
require_once APP_PATH . '/core/Middleware.php';

// Initialize router
$router = new Router();

// Load routes
require_once BASE_PATH . '/config/routes.php';

// Dispatch request
$router->dispatch();