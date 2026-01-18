<?php
echo "INDEX OK";
exit;
require_once '../config/config.php';
require_once '../app/core/Database.php';
require_once '../app/core/Controller.php';
require_once '../app/core/Model.php';
require_once __DIR__ . '/../app/core/Auth.php';

// load routes
require_once __DIR__ . '/../config/routes.php';

// Giả sử Router đơn giản theo URL: domain/controller/method
// → Quy ước URL có dạng: controller/method

$url = isset($_GET['url'])
    ? explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL))
    : ['auth', 'register'];
// Nếu URL tồn tại:
//    - Xóa dấu / dư ở cuối
//    - Làm sạch URL
//    - Tách chuỗi thành mảng ['controller', 'method']
// Nếu không có URL → mặc định vào auth/register

$controllerName = ucfirst($url[0]) . 'Controller';
// → Lấy phần controller trong URL
// → Viết hoa chữ cái đầu và gắn 'Controller'
// → Ví dụ: auth → AuthController

if (file_exists('../app/controllers/' . $controllerName . '.php')) {
// → Kiểm tra file controller có tồn tại không

    require_once '../app/controllers/' . $controllerName . '.php';
    // → Nạp file controller vào chương trình

    $controller = new $controllerName;
    // → Khởi tạo object controller

    $method = isset($url[1]) ? $url[1] : 'register';
    // → Lấy method từ URL
    // → Nếu không có → mặc định gọi register()

    // Nếu là POST register thì gọi postRegister
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method == 'register') {
        $method = 'postRegister';
    }
    // → Phân biệt GET và POST
    // → GET  /register  → register()
    // → POST /register  → postRegister()

    if (method_exists($controller, $method)) {
    // → Kiểm tra method có tồn tại trong controller không

        $controller->$method();
        // → Gọi method tương ứng trong controller
    }
}


// chạy router
$router->dispatch();
