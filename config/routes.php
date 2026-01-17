<?php
// Public Routes
$router->add('GET', '/', 'HomeController', 'index');
$router->add('GET', '/about', 'HomeController', 'about');

// Authentication Routes - Only for guests
$router->add('GET', '/login', 'AuthController', 'login', 'GuestMiddleware');
$router->add('POST', '/login', 'AuthController', 'login', 'GuestMiddleware');
$router->add('GET', '/register', 'AuthController', 'register', 'GuestMiddleware');
$router->add('POST', '/register', 'AuthController', 'register', 'GuestMiddleware');
$router->add('GET', '/logout', 'AuthController', 'logout');

// User Routes - Require authentication
$router->add('GET', '/books', 'User\\BookController', 'index', 'AuthMiddleware');
$router->add('GET', '/books/{id}', 'User\\BookController', 'show', 'AuthMiddleware');
$router->add('GET', '/books/search', 'User\\BookController', 'search', 'AuthMiddleware');

$router->add('GET', '/user/profile', 'User\\ProfileController', 'index', 'AuthMiddleware');
$router->add('GET', '/user/notifications', 'User\\NotificationController', 'index', 'AuthMiddleware');

$router->add('GET', '/user/borrow', 'User\\BorrowController', 'index', 'AuthMiddleware');
$router->add('POST', '/user/borrow/{bookId}', 'User\\BorrowController', 'request', 'AuthMiddleware');

// Admin Routes - Require admin role
$router->add('GET', '/admin/dashboard', 'Admin\\DashboardController', 'index', 'AdminMiddleware');

$router->add('GET', '/admin/books', 'Admin\\BookController', 'index', 'AdminMiddleware');
$router->add('GET', '/admin/books/create', 'Admin\\BookController', 'create', 'AdminMiddleware');
$router->add('POST', '/admin/books', 'Admin\\BookController', 'store', 'AdminMiddleware');
$router->add('GET', '/admin/books/{id}/edit', 'Admin\\BookController', 'edit', 'AdminMiddleware');
$router->add('POST', '/admin/books/{id}', 'Admin\\BookController', 'update', 'AdminMiddleware');
$router->add('POST', '/admin/books/{id}/delete', 'Admin\\BookController', 'delete', 'AdminMiddleware');

$router->add('GET', '/admin/users', 'Admin\\UserController', 'index', 'AdminMiddleware');
$router->add('GET', '/admin/users/{id}', 'Admin\\UserController', 'show', 'AdminMiddleware');
$router->add('POST', '/admin/users/{id}/suspend', 'Admin\\UserController', 'suspend', 'AdminMiddleware');
$router->add('POST', '/admin/users/{id}/activate', 'Admin\\UserController', 'activate', 'AdminMiddleware');

$router->add('GET', '/admin/transactions', 'Admin\\TransactionController', 'index', 'AdminMiddleware');
$router->add('POST', '/admin/transactions/{id}/approve', 'Admin\\TransactionController', 'approve', 'AdminMiddleware');
$router->add('POST', '/admin/transactions/{id}/return', 'Admin\\TransactionController', 'return', 'AdminMiddleware');

$router->add('GET', '/admin/notifications', 'Admin\\NotificationController', 'index', 'AdminMiddleware');
$router->add('POST', '/admin/notifications', 'Admin\\NotificationController', 'send', 'AdminMiddleware');