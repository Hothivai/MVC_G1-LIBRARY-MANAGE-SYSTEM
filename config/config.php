<?php
// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define paths
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('PUBLIC_PATH', ROOT_PATH . '/public');

// Base URL
define('BASE_URL', '/');