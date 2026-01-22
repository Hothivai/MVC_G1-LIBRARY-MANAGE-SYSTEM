<?php
session_start();
// ... các dòng error reporting ...

// Nạp các core class trước để Controller có thể kế thừa
require_once __DIR__ . '/../app/core/Database.php';
require_once __DIR__ . '/../app/core/Controller.php';
require_once __DIR__ . '/../app/core/Model.php';

// Nạp file routes và PHẢI gán vào biến $router
$router = require_once __DIR__ . '/../config/routes.php';

$router->dispatch();
