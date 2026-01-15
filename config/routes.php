<?php

$router = new Router();

// Hiển thị form đăng ký
$router->get('/register', 'AuthController', 'register');

// Xử lý submit đăng ký
$router->post('/register', 'AuthController', 'handleRegister');
