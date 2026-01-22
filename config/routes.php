<?php
require_once __DIR__ . '/../app/core/Router.php';

$router = new Router();

// AUTH
$router->get('/auth/login', 'AuthController', 'login');
$router->post('/auth/login', 'AuthController', 'handleLogin');
$router->get('/auth/logout', 'AuthController', 'logout');

// HOME
$router->get('/', 'HomeController', 'index');
$router->get('/home/index', 'HomeController', 'index');

// USER PROFILE (MODAL BASED)
$router->get('/profile', 'UserController', 'profile');                 // View profile
$router->post('/profile/update', 'UserController', 'updateProfile');   // Edit info
$router->post('/profile/change-password', 'UserController', 'changePassword'); // LMS-33

// ADMIN
$router->get('/admin/dashboard/index', 'admin/DashboardController', 'index');

// DEFAULT FALLBACK
return $router;
