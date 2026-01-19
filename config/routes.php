<?php
$router = new Router();
// ROOT → redirect sang login
$router->get('/', 'AuthController', 'redirectToLogin');

// AUTH
$router->get('/auth/login', 'AuthController', 'login');
$router->post('/auth/login', 'AuthController', 'loginPost');
$router->get('/auth/logout', 'AuthController', 'logout');

// USER
$router->get('/home/index', 'HomeController', 'index');

// ADMIN
$router->get('/admin/dashboard/index', 'admin/DashboardController', 'index');
