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

// Load routes
require_once '../config/routes.php';

// Dispatch router
try {
    $router->dispatch();
} catch (Exception $e) {
    error_log("Router Error: " . $e->getMessage());
    echo "<h1>Router Error</h1>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
