<?php
// ============================
// 1. DEBUG + SESSION
// ============================
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ============================
// 2. LOAD CORE & CONFIG
// ============================
require_once '../config/config.php';

require_once '../app/core/Database.php';
require_once '../app/core/Controller.php';
require_once '../app/core/Model.php';
require_once '../app/core/Auth.php';
require_once '../app/core/Middleware.php';

// ============================
// 3. LOAD CONTROLLERS
// ============================
require_once '../app/controllers/HomeController.php';
require_once '../app/controllers/AuthController.php';
require_once '../app/controllers/BookController.php';
require_once '../app/controllers/DashboardController.php';

// ============================
// 4. LẤY ACTION
// ============================
$action = $_GET['action'] ?? 'home';

// ============================
// 5. SWITCH – CASE ACTION
// ============================
switch ($action) {

    // ---------- PUBLIC ----------
    case 'home':
        (new HomeController())->index();
        break;

    case 'about':
        (new HomeController())->about();
        break;

    // ---------- AUTH ----------
    case 'login':
        (new AuthController())->login();
        break;

    case 'login_handle':
        (new AuthController())->handleLogin();
        break;

    case 'logout':
        (new AuthController())->logout();
        break;

    // ---------- USER ----------
    case 'books':
        (new BookController())->index();
        break;

    case 'book_show':
        (new BookController())->show();
        break;

    // ---------- ADMIN ----------
    case 'admin_dashboard':
        Middleware::requireAdmin();
        (new DashboardController())->index();
        break;

    // ---------- DEFAULT ----------
    default:
        http_response_code(404);
        echo "404 - Action not found";
        break;
}
