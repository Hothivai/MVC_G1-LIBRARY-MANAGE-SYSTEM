<?php
// Start session first

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use App\Core\Router;

$router = new Router();

// ==================== PUBLIC ROUTES ====================
// Home

$router->add('GET', 'register', 'AuthController', 'register');
$router->add('POST', 'register', 'AuthController', 'handleRegister');
// Start session first
$router->add('GET', '', 'HomeController', 'index');
$router->add('GET', 'index.php', 'HomeController', 'index');
$router->add('GET', 'home', 'HomeController', 'index');
$router->add('GET', 'about', 'AboutController', 'index');

// Auth
$router->add('GET', 'login', 'AuthController', 'showLogin');
$router->add('POST', 'login', 'AuthController', 'login');
$router->add('GET', 'register', 'AuthController', 'showRegister');
$router->add('POST', 'register', 'AuthController', 'register');
$router->add('GET', 'logout', 'AuthController', 'logout');

// ==================== USER ROUTES ====================
// Books
$router->add('GET', 'user/books', 'User\BookController', 'index');
$router->add('GET', 'user/books/show/{id}', 'User\BookController', 'show');
$router->add('GET', 'user/books/search', 'User\BookController', 'search');

// Profile
$router->add('GET', 'user/profile', 'User\ProfileController', 'index');
$router->add('GET', 'user/profile/edit', 'User\ProfileController', 'edit');
$router->add('POST', 'user/profile/update', 'User\ProfileController', 'update');

// Borrow
$router->add('GET', 'user/borrow', 'User\BorrowController', 'index');
$router->add('GET', 'user/borrow/request/{id}', 'User\BorrowController', 'request');
$router->add('POST', 'user/borrow/store', 'User\BorrowController', 'store');

// Notifications
$router->add('GET', 'user/notifications', 'User\NotificationController', 'index');

// ==================== ADMIN ROUTES ====================
// Dashboard
$router->add('GET', 'admin/dashboard', 'Admin\DashboardController', 'index', 'AdminMiddleware');

// Books Management
$router->add('GET', 'admin/books', 'Admin\BookController', 'index', 'AdminMiddleware');
$router->add('GET', 'admin/books/create', 'Admin\BookController', 'create', 'AdminMiddleware');
$router->add('POST', 'admin/books/store', 'Admin\BookController', 'store', 'AdminMiddleware');
$router->add('GET', 'admin/books/edit/{id}', 'Admin\BookController', 'edit', 'AdminMiddleware');
$router->add('POST', 'admin/books/update/{id}', 'Admin\BookController', 'update', 'AdminMiddleware');
$router->add('POST', 'admin/books/delete/{id}', 'Admin\BookController', 'delete', 'AdminMiddleware');

// Categories Management
$router->add('GET', 'admin/categories', 'Admin\CategoryController', 'index', 'AdminMiddleware');
$router->add('GET', 'admin/categories/create', 'Admin\CategoryController', 'create', 'AdminMiddleware');
$router->add('POST', 'admin/categories/store', 'Admin\CategoryController', 'store', 'AdminMiddleware');

// Users Management
$router->add('GET', 'admin/users', 'Admin\UserController', 'index', 'AdminMiddleware');
$router->add('GET', 'admin/users/show/{id}', 'Admin\UserController', 'show', 'AdminMiddleware');

// Transactions Management
$router->add('GET', 'admin/transactions', 'Admin\TransactionController', 'index', 'AdminMiddleware');
$router->add('POST', 'admin/transactions/approve/{id}', 'Admin\TransactionController', 'approve', 'AdminMiddleware');
$router->add('POST', 'admin/transactions/return/{id}', 'Admin\TransactionController', 'returnBook', 'AdminMiddleware');
$router->add('POST', 'admin/transactions/return/{id}', 'Admin\TransactionController', 'returnBook', 'AdminMiddleware');
