<?php
session_start();

// Load config
require_once '../config/config.php';

// Core MVC
require_once '../app/core/Router.php';
require_once '../app/core/Database.php';
require_once '../app/core/Controller.php';
require_once '../app/core/Model.php';
require_once '../app/core/Auth.php';
require_once '../app/core/Middleware.php';

// Load routes (KHỞI TẠO $router Ở ĐÂY)
require_once '../config/routes.php';

// Dispatch request
$router->dispatch();
