<?php
require_once '../config/config.php';
require_once '../app/core/Database.php';
require_once '../app/core/Controller.php';
require_once '../app/core/Model.php';

// Giả sử Router đơn giản theo URL: domain/controller/method
$url = isset($_GET['url']) ? explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL)) : ['auth', 'register'];

$controllerName = ucfirst($url[0]) . 'Controller';
if (file_exists('../app/controllers/' . $controllerName . '.php')) {
    require_once '../app/controllers/' . $controllerName . '.php';
    $controller = new $controllerName;
    
    $method = isset($url[1]) ? $url[1] : 'register';
    
    // Nếu là POST register thì gọi postRegister
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method == 'register') {
        $method = 'postRegister';
    }

    if (method_exists($controller, $method)) {
        $controller->$method();
    }
}