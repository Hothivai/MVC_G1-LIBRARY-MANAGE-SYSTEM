<?php
// Application Configuration
define('APP_NAME', 'Thư Viện Số');
define('APP_VERSION', '1.0.0');
define('APP_DEBUG', true);

// Timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Error Reporting - SET BEFORE SESSION START
if (APP_DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Session Configuration - MUST BE BEFORE session_start()
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Set to 1 if using HTTPS

// Now start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Security
define('BCRYPT_COST', 12);

// File Upload
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', ['jpg', 'jpeg', 'png', 'gif']);

// Borrowing Rules
define('MAX_BOOKS_PER_USER', 5);
define('BORROW_DURATION_DAYS', 14);
define('RENEWAL_DAYS', 7);
define('FINE_PER_DAY', 5000); // VND per day

// Application URLs
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . str_replace('/public', '', dirname($_SERVER['PHP_SELF'])));
define('PUBLIC_URL', BASE_URL . '/public');