<?php
// Define base path - MUST BE AT THE TOP
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
define('PUBLIC_PATH', __DIR__);

// Load configuration FIRST
require_once BASE_PATH . '/config/config.php';  // Load config BEFORE session_start()
require_once BASE_PATH . '/config/database.php';

// Autoload classes
spl_autoload_register(function($className) {
    $file = APP_PATH . '/' . str_replace('\\', '/', $className) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Include core files
require_once APP_PATH . '/core/Router.php';
require_once APP_PATH . '/core/Controller.php';
require_once APP_PATH . '/core/Model.php';
require_once APP_PATH . '/core/Database.php';
require_once APP_PATH . '/core/Auth.php';
require_once APP_PATH . '/core/Middleware.php';

// Initialize router
$router = new Router();

// Load routes
require_once BASE_PATH . '/config/routes.php';

// Dispatch request
$router->dispatch();