<?php
// ================= SESSION =================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ================= PATHS =================
define('APPROOT', dirname(__DIR__));
define('APP_PATH', APPROOT . '/app');
define('URLROOT', 'http://localhost:3000/public'); 
define('SITENAME', 'Library Management System');

// ================= DATABASE =================
define('DB_HOST', 'localhost');
define('DB_NAME', 'library_db');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');
