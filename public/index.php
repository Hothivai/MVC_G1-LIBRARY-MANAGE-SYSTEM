<?php
// ============================
// 1. DEBUG
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
// 3. CONFIG
// ============================
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

// ============================
// 4. CORE
// ============================
require_once __DIR__ . '/../app/core/Database.php';
require_once __DIR__ . '/../app/core/Controller.php';
require_once __DIR__ . '/../app/core/Model.php';
require_once __DIR__ . '/../app/core/Auth.php';
require_once __DIR__ . '/../app/core/Router.php';
require_once __DIR__ . '/../app/core/Middleware.php';

// ============================
// 5. MODELS
// ============================
require_once __DIR__ . '/../app/models/Category.php';
require_once __DIR__ . '/../app/models/Book.php';
require_once __DIR__ . '/../app/models/User.php';
require_once __DIR__ . '/../app/models/Transaction.php';

// ============================
// 6. CONTROLLERS
// ============================
require_once __DIR__ . '/../app/controllers/HomeController.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';

// User
require_once __DIR__ . '/../app/controllers/BookController.php';

// Admin
require_once __DIR__ . '/../app/controllers/DashboardController.php';

// ============================
// 7. ROUTES
// ============================
$router = require_once __DIR__ . '/../config/routes.php';

// ============================
// 8. DISPATCH
// ============================
$router->dispatch();
