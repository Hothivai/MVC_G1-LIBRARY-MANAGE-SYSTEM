<?php

use App\Core\Router;
require_once __DIR__ . '/../app/core/Router.php';

$router = new Router();

/*
|--------------------------------------------------------------------------
| PUBLIC (Guest)
|--------------------------------------------------------------------------
*/

// Home
$router->get('/', 'HomeController', 'index');

// Auth
$router->get('/login', 'AuthController', 'login');
$router->post('/login', 'AuthController', 'handleLogin');

$router->get('/register', 'AuthController', 'register');
$router->post('/register', 'AuthController', 'handleRegister');

$router->get('/logout', 'AuthController', 'logout');


/*
|--------------------------------------------------------------------------
| USER
|--------------------------------------------------------------------------
*/

// Trang chủ user (sau login)
$router->get('/user/home', 'HomeController', 'userHome');

// Books
$router->get('/user/books', 'BookController', 'index');
$router->get('/user/book', 'BookController', 'show');        // ?id=1
$router->get('/user/books/search', 'BookController', 'search');

// Profile
$router->get('/profile', 'UserController', 'profile');
$router->post('/profile/update', 'UserController', 'updateProfile');
$router->post('/profile/change-password', 'UserController', 'changePassword');


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

$router->get('/admin/dashboard', 'DashboardController', 'index');

// Books
$router->get('/admin/books', 'AdminBookController', 'index');
$router->get('/admin/books/create', 'AdminBookController', 'create');
$router->post('/admin/books/store', 'AdminBookController', 'store');
$router->get('/admin/books/edit', 'AdminBookController', 'edit');     // ?id=1
$router->post('/admin/books/update', 'AdminBookController', 'update');
$router->post('/admin/books/delete', 'AdminBookController', 'delete');

// Categories
$router->get('/admin/categories', 'AdminCategoryController', 'index');
$router->post('/admin/categories/store', 'AdminCategoryController', 'store');

// Users
$router->get('/admin/users', 'AdminUserController', 'index');
$router->get('/admin/user', 'AdminUserController', 'show');           // ?id=1

// Transactions
$router->get('/admin/transactions', 'AdminTransactionController', 'index');
$router->post('/admin/transaction/approve', 'AdminTransactionController', 'approve');
$router->post('/admin/transaction/return', 'AdminTransactionController', 'returnBook');

return $router;
