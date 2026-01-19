<?php
// bật lỗi để debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

// start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// CORE
require_once __DIR__ . '/../app/core/Router.php';
require_once __DIR__ . '/../app/core/Controller.php';
require_once __DIR__ . '/../app/core/Model.php';
require_once __DIR__ . '/../app/core/Database.php';
require_once __DIR__ . '/../app/core/Auth.php';
require_once __DIR__ . '/../app/core/Middleware.php';

// ROUTES
require_once __DIR__ . '/../config/routes.php';

// RUN ROUTER
$router->dispatch();
