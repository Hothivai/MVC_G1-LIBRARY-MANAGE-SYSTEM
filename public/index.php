<?php
/*
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
require_once __DIR__ . '/../config/routes.php';

// Load CORE classes
require_once '../app/core/Database.php';
require_once '../app/core/Controller.php';
require_once '../app/core/Model.php';
require_once __DIR__ . '/../app/core/Auth.php';

// load routes
require_once __DIR__ . '/../config/routes.php';
require_once '../app/core/Router.php';


// Load Middleware (optional)
if (file_exists('../app/core/Middleware.php')) {
    require_once '../app/core/Middleware.php';
}
if (file_exists('../app/core/AdminMiddleware.php')) {
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
// Dispatch router
try {
    $router->dispatch();
} catch (Exception $e) {
    error_log("Router Error: " . $e->getMessage());
    echo "<h1>Router Error</h1>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
*/

use App\Controllers\HomeController;
use App\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| DEBUG
|--------------------------------------------------------------------------
*/
error_reporting(E_ALL);
ini_set('display_errors', 1);

/*
|--------------------------------------------------------------------------
| SESSION
|--------------------------------------------------------------------------
*/
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*
|--------------------------------------------------------------------------
| CONFIG
|--------------------------------------------------------------------------
*/
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

/*
|--------------------------------------------------------------------------
| CORE
|--------------------------------------------------------------------------
*/
require_once __DIR__ . '/../app/core/Database.php';
require_once __DIR__ . '/../app/core/Controller.php';
require_once __DIR__ . '/../app/core/Model.php';
require_once __DIR__ . '/../app/core/Auth.php';

/*
|--------------------------------------------------------------------------
| CONTROLLERS
|--------------------------------------------------------------------------
*/
require_once __DIR__ . '/../app/controllers/HomeController.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';

/*
|--------------------------------------------------------------------------
| INIT CONTROLLERS
|--------------------------------------------------------------------------
*/
$homeController = new HomeController();


/*
|--------------------------------------------------------------------------
| GET ACTION
|-------------------------------------------------------------------------
*/
$action = $_GET['action'] ?? 'home';

/*
|--------------------------------------------------------------------------
| ROUTING
|--------------------------------------------------------------------------
*/
switch ($action) {

    /* ================= AUTH ================= */

    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $message = $authController->loginPost();
        }
        require_once __DIR__ . '/../app/views/auth/login.php';
        break;

    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $message = $authController->postRegister();
        }
        require_once __DIR__ . '/../app/views/auth/register.php';
        break;

    case 'logout':
        $authController->logout();
        break;

    /* ================= HOME ================= */

    case 'home':
        $homeController->index();
        break;

    case 'about':
        require_once __DIR__ . '/../app/views/home/about.php';
        break;

    /* ================= BOOKS ================= */

    case 'books':
        require_once __DIR__ . '/../app/views/user/books/index.php';
        break;

    /* ================= USER ================= */

    case 'profile':
        require_once __DIR__ . '/../app/views/user/profile/index.php';
        break;

    case 'notifications':
        require_once __DIR__ . '/../app/views/notifications/index.php';
        break;

    /* ================= 404 ================= */

    default:
        http_response_code(404);
        echo "<h1>404 - Page Not Found</h1>";
        break;
}
