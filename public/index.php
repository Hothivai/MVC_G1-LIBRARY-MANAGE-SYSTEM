<?php

session_start();

// require_once '../config/config.php';
// require_once '../app/core/Database.php';
// require_once '../app/core/Router.php';
// require_once '../app/core/Controller.php';
// require_once '../app/core/Model.php';
// require_once '../app/core/Auth.php';
// require_once '../app/core/Middleware.php';

// // Get request URI
// $request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// $request_method = $_SERVER['REQUEST_METHOD'];

// // Load routes
// require_once '../config/routes.php';

// // Dispatch router
// $router->dispatch();
session_start();

require_once '../config/config.php';
require_once '../app/core/Router.php';

require_once '../app/core/Database.php';
require_once '../app/core/Controller.php';
require_once '../app/core/Model.php';
require_once '../app/core/Auth.php';
require_once '../app/core/Middleware.php';

// Load routes SAU KHI đã có Router
require_once '../config/routes.php';

// Dispatch
$router->dispatch();
