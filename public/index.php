<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load configuration
require_once '../config/database.php';
require_once '../config/config.php';

// Load CORE classes
require_once '../app/core/Database.php';
require_once '../app/core/Controller.php';
require_once '../app/core/Model.php';

// Giả sử Router đơn giản theo URL: domain/controller/method
// → Quy ước URL có dạng: controller/method
require_once '../app/core/Router.php';
require_once '../app/core/Model.php';
require_once '../app/core/Controller.php';


// Load Middleware (optional)
if (file_exists('../app/core/Middleware.php')) {
    require_once '../app/core/Middleware.php';
}
if (file_exists(filename: '../app/core/AdminMiddleware.php')) {
    require_once '../app/core/AdminMiddleware.php';
}

// Load MODELS
require_once '../app/models/Category.php';
require_once '../app/models/Book.php';
require_once '../app/models/User.php';
require_once '../app/models/Transaction.php';

// Load CONTROLLERS - Base first
require_once '../app/controllers/HomeController.php';


// Load User Controllers
if (file_exists('../app/controllers/user/BookController.php')) {
    require_once '../app/controllers/user/BookController.php';
}

// Debug: Log the request
error_log("=== New Request ===");
error_log("REQUEST_URI: " . $_SERVER['REQUEST_URI']);

// Get request URI
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base_path = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));

if ($base_path !== '/') {
    $request_uri = str_replace($base_path, '', $request_uri);
}

$_GET['url'] = trim($request_uri, '/');

error_log("Processed URL: '" . $_GET['url'] . "'");

$request_method = $_SERVER['REQUEST_METHOD'];

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
