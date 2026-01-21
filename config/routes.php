<?php
// Đảm bảo đã nạp file Router class
require_once __DIR__ . '/../app/core/Router.php';

// Khởi tạo đối tượng Router
$router = new Router();

// config/routes.php// Tìm trong controllers/user/
$router->get('/profile/edit', 'user/ProfileController', 'edit');
$router->post('/profile/change-password', 'user/ProfileController', 'changePassword'); // LMS-33

return $router; 