<?php

// Start session first
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use App\Core\Router;
require_once __DIR__ . '/../app/core/Router.php';

$router = new Router();

// ==================== AUTH ROUTES ====================
$router->get('/auth/login', 'AuthController', 'login');
$router->post('/auth/login', 'AuthController', 'loginPost');
$router->get('/auth/logout', 'AuthController', 'logout');
$router->get('/auth/register', 'AuthController', 'register');
$router->post('/auth/register', 'AuthController', 'registerPost');

// Direct auth routes
$router->get('/login', 'AuthController', 'login');
$router->get('/register', 'AuthController', 'register');

// ==================== HOME ROUTES ====================
$router->get('/', 'HomeController', 'index');
$router->get('/home', 'HomeController', 'index');
$router->get('/home/index', 'HomeController', 'index');
$router->get('/home/about', 'HomeController', 'about');

// ==================== USER ROUTES ====================
$router->get('/profile', 'UserController', 'profile');
$router->get('/user/profile', 'UserController', 'profile');
$router->post('/user/updateProfile', 'UserController', 'updateProfile');
$router->post('/user/changePassword', 'UserController', 'changePassword');
$router->get('/user/books', 'BookController', 'index'); // User books listing
$router->get('/user/notifications', 'NotificationController', 'index');

// ==================== ADMIN ROUTES ====================
$router->get('/admin/dashboard', 'DashboardController', 'index');
$router->get('/admin/dashboard/index', 'DashboardController', 'index');

// Admin Books
$router->get('/admin/books', 'BookController', 'index');
$router->get('/admin/books/index', 'BookController', 'index');
$router->get('/admin/books/create', 'BookController', 'create');
$router->post('/admin/books', 'BookController', 'store');
$router->get('/admin/books/edit', 'BookController', 'edit');
$router->post('/admin/books/update', 'BookController', 'update');
$router->get('/admin/books/show', 'BookController', 'show');

// Admin Categories
$router->get('/admin/categories', 'CategoryController', 'index');
$router->get('/admin/categories/index', 'CategoryController', 'index');
$router->get('/admin/categories/create', 'CategoryController', 'create');
$router->post('/admin/categories', 'CategoryController', 'store');
$router->get('/admin/categories/edit', 'CategoryController', 'edit');
$router->post('/admin/categories/update', 'CategoryController', 'update');

// Admin Transactions
$router->get('/admin/transactions', 'TransactionController', 'index');
$router->get('/admin/transactions/index', 'TransactionController', 'index');
$router->get('/admin/transactions/pending', 'TransactionController', 'pending');
$router->get('/admin/transactions/approve', 'TransactionController', 'approve');
$router->post('/admin/transactions/approve', 'TransactionController', 'approvePost');
$router->get('/admin/transactions/return', 'TransactionController', 'return');
$router->post('/admin/transactions/return', 'TransactionController', 'returnPost');

// Admin Notifications
$router->get('/admin/notifications', 'NotificationController', 'index');
$router->get('/admin/notifications/index', 'NotificationController', 'index');
$router->get('/admin/notifications/create', 'NotificationController', 'create');
$router->post('/admin/notifications', 'NotificationController', 'store');

// ==================== DEFAULT FALLBACK ====================
return $router;
