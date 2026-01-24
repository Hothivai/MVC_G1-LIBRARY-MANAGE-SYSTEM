<?php

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load configuration
require_once '../config/config.php';

// Load CORE classes
require_once '../app/core/Database.php';
require_once '../app/core/Controller.php';
require_once '../app/core/Model.php';
require_once '../app/core/Auth.php';
require_once '../app/core/Middleware.php';


// --- SIMPLIFIED ROUTING ---

// 1. Determine Controller and Action
$controllerName = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$actionName = isset($_GET['action']) ? $_GET['action'] : 'index';

// 2. Sanitize and Format Names
// Whitelist of allowed characters for security
$controllerName = preg_replace('/[^a-zA-Z0-9_]/', '', $controllerName);
$actionName = preg_replace('/[^a-zA-Z0-9_]/', '', $actionName);

$controllerClass = ucfirst($controllerName) . 'Controller';

// 3. Construct File Path and Fully Qualified Class Name
$controllerFile = '../app/controllers/' . $controllerClass . '.php';
$fullyQualifiedControllerClass = 'App\Controllers\' . $controllerClass;

// 4. Check and Load Controller
if (file_exists($controllerFile)) {
    require_once $controllerFile;

    // 5. Instantiate Controller and Call Action
    if (class_exists($fullyQualifiedControllerClass)) {
        $controller = new $fullyQualifiedControllerClass();

        if (method_exists($controller, $actionName)) {
            // Call the action
            $controller->$actionName();
        } else {
            // Action not found
            echo "Error: Action '{$actionName}' not found in controller '{$fullyQualifiedControllerClass}'.";
        }
    } else {
        // Class not found in file
        echo "Error: Controller class '{$fullyQualifiedControllerClass}' not found in file '{$controllerFile}'.";
    }
} else {
    // Controller file not found
    echo "Error: Controller file not found for '{$controllerName}'. Path: {$controllerFile}";
}
