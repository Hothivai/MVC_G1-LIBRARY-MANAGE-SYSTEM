<?php

require_once __DIR__ . '/../app/core/Router.php';

$router = new Router();

// AUTH
$router->get('/auth/login', 'AuthController', 'login');
$router->post('/auth/login', 'AuthController', 'loginPost');

$router->get('/auth/logout', 'AuthController', 'logout');

// DEFAULT
$router->get('/', 'AuthController', 'login');

// ADMIN
$router->get('/admin/dashboard/index','admin/DashboardController','index');

// HOME (USER)
$router->get('/home/index', 'HomeController', 'index');

// DEFAULT

$router->get('/', 'HomeController', 'index');

// USER PROFILE - LMS-32
$router->get('/user/profile/edit', 'ProfileController', 'edit');
$router->post('/user/profile/update', 'ProfileController', 'update');
