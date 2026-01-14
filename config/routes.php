<?php
require_once __DIR__ . '/../app/core/Router.php';

$router = new Router();

// SỬA: Đúng cú pháp
$router->get('/register', 'AuthController', 'register');
$router->post('/register', 'AuthController', 'handleRegister');
$router->get('/login', 'AuthController', 'login');

// Route mặc định
$router->get('/', 'HomeController', 'index');