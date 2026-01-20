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
	$host = "localhost";
	$user = "root";
	$password = "";
	$database = "library_db";

	try {
		// Create PDO connection
		$conn = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $user, $password);
		
		// Set error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		//echo "Connected successfully";
	} catch(PDOException $e) {
		die("Connection failed: " . $e->getMessage());
	}

// Đường dẫn gốc dự án
define('URLROOT', '/MVC_G1-LIBRARY-MANAGE-SYSTEM');
?>
