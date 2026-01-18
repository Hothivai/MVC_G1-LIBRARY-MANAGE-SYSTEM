<?php
// ================= SESSION =================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ================= PATH =================
define('APPROOT', dirname(__DIR__)); // trỏ tới thư mục gốc project
define('APP_PATH', APPROOT . '/app');

// ================= URL =================
define('URLROOT', 'http://localhost/MVC_G1-LIBRARY-MANAGE-SYSTEM/public');

// ================= APP INFO =================
define('SITENAME', 'Library Management System');
