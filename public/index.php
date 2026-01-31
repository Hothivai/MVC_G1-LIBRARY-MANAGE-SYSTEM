<?php
// ============================
// 1. DEBUG + SESSION
// ============================
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ============================
// 2. SESSION
// ============================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ============================
// 3. LOAD CORE & CONFIG
// ============================
require_once '../config/config.php';

require_once '../app/core/Database.php';
require_once '../app/core/Controller.php';
require_once '../app/core/Model.php';
require_once '../app/core/Auth.php';
require_once '../app/core/Middleware.php';

// ============================
// 4. LOAD MODELS
// ============================
require_once '../app/models/Book.php';
require_once '../app/models/Category.php';
require_once '../app/models/Notification.php';
require_once '../app/models/Transaction.php';
require_once '../app/models/User.php';
require_once '../app/models/BorrowRequest.php';

// ============================
// 5. LOAD CONTROLLERS
// ============================
require_once '../app/controllers/HomeController.php';
require_once '../app/controllers/AuthController.php';
require_once '../app/controllers/BookController.php';
require_once '../app/controllers/CategoryController.php';
require_once '../app/controllers/DashboardController.php';
require_once '../app/controllers/NotificationController.php';
require_once '../app/controllers/TransactionController.php';
require_once '../app/controllers/UserController.php';
require_once '../app/controllers/BorrowRequestController.php';
// ============================
// 6. LẤY ACTION
// ============================
$action = $_GET['action'] ?? 'home_index';

// ============================
// 7. SWITCH – CASE ACTION
// ============================
switch ($action) {

    // ---------- HOME ----------
    case 'home_index':
        (new HomeController())->index();
        break;

    case 'home_about':
        (new HomeController())->about();
        break;

    // ---------- AUTH ----------
    case 'auth_register':
        (new AuthController())->register();
        break;

    case 'auth_register_post':
        (new AuthController())->postRegister();
        break;

    case 'auth_login':
        (new AuthController())->login();
        break;

    case 'auth_login_post':
        (new AuthController())->loginPost();
        break;

    case 'auth_logout':
        (new AuthController())->logout();
        break;

    // ---------- USER BOOKS ----------
    case 'user_books_index':
        (new BookController())->userIndex();
        break;

    case 'user_books_show':
        $id = $_GET['id'] ?? 0;
        (new BookController())->userShow($id);
        break;

    case 'user_books_search':
        (new BookController())->userSearch();
        break;

    // ---------- USER BORROW ----------
    case 'user_borrow_index':
        (new UserController())->borrowIndex();
        break;

    case 'user_books_borrow_request':
        $controller = new BookController();
        $controller->userBorrowRequest((int)$_GET['id']);
        break;

    case 'user_borrow_request_store':
        (new BorrowRequestController())->store();
        break;

    // ---------- USER NOTIFICATIONS ----------
    case 'user_notifications_index':
        (new NotificationController())->userIndex();
        break;

    // ---------- USER PROFILE ----------
    case 'user_profile_index':
        (new UserController())->profile();
        break;

    case 'user_profile_edit':
        (new UserController())->editProfile();
        break;

    case 'user_profile_update':
        (new UserController())->updateProfile();
        break;

    case 'user_change_password':
        (new UserController())->changePassword();
        break;

    // ---------- ADMIN DASHBOARD ----------
    case 'admin_dashboard_index':
        Middleware::requireAdmin();
        (new DashboardController())->index();
        break;

    // ---------- ADMIN BOOKS ----------
    case 'admin_books_index':
        Middleware::requireAdmin();
        (new BookController())->adminIndex();
        break;

    case 'admin_books_create':
        Middleware::requireAdmin();
        (new BookController())->adminCreate();
        break;

    case 'admin_books_edit':
        Middleware::requireAdmin();
        $id = $_GET['id'] ?? 0;
        (new BookController())->adminEdit($id);
        break;

    case 'admin_books_show':
        Middleware::requireAdmin();
        $id = $_GET['id'] ?? 0;
        (new BookController())->adminShow($id);
        break;

    // ---------- ADMIN CATEGORIES ----------
    case 'admin_categories_index':
        Middleware::requireAdmin();
        (new CategoryController())->index();
        break;

    case 'admin_categories_create':
        Middleware::requireAdmin();
        (new CategoryController())->create();
        break;

    case 'admin_categories_edit':
        Middleware::requireAdmin();
        $id = $_GET['id'] ?? 0;
        (new CategoryController())->edit($id);
        break;

    // ---------- ADMIN TRANSACTIONS ----------
    case 'admin_transactions_index':
        Middleware::requireAdmin();
        (new TransactionController())->index();
        break;

    case 'admin_transactions_approve':
        Middleware::requireAdmin();
        $id = $_GET['id'] ?? 0;
        (new TransactionController())->processReturn();
        break;

    case 'admin_transactions_return':
        Middleware::requireAdmin();
        $id = $_GET['id'] ?? 0;
        (new TransactionController())->return($id);
        break;

    // ---------- ADMIN NOTIFICATIONS ----------
    case 'admin_notifications_index':
        Middleware::requireAdmin();
        (new NotificationController())->adminIndex();
        break;

    case 'admin_notifications_create':
        Middleware::requireAdmin();
        (new NotificationController())->adminCreate();
        break;

    // ---------- ADMIN USERS ----------
    case 'admin_users_index':
        Middleware::requireAdmin();
        (new UserController())->adminIndex();
        break;

    case 'admin_users_show':
        Middleware::requireAdmin();
        $id = $_GET['id'] ?? 0;
        (new UserController())->adminShow($id);
        break;

    case 'admin_users_edit':
        Middleware::requireAdmin();
        $id = $_GET['id'] ?? 0;
        (new UserController())->adminEdit($id);
        break;

    // ---------- ADMIN BORROW REQUESTS ----------
    case 'admin_requests':
        Middleware::requireAdmin();
        (new BorrowRequestController())->index();
        break;

    case 'admin_requests_approve':
        Middleware::requireAdmin();
        (new BorrowRequestController())->approve();
        break;

    case 'admin_requests_reject':
        Middleware::requireAdmin();
        (new BorrowRequestController())->reject();
        break;

    // ---------- DEFAULT ----------
    default:
        http_response_code(404);
        echo "404 - Action not found: $action";
        break;
}
