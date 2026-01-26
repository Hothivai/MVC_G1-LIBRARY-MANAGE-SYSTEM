<?php
require_once '../config/config.php';
require_once '../app/controllers/BookController.php';

$action = $_GET['action'] ?? 'book';

switch ($action) {
    case 'book':
       $controller = new \App\Controllers\BookController();
       $controller->index();

        break;

    default:
        echo 'Action không tồn tại';
}
