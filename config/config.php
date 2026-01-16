<?php
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
// Thông số Database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'library_db'); // Hãy đảm bảo tên DB này khớp với DB bạn tạo trong phpMyAdmin

// Đường dẫn gốc dự án
define('URLROOT', '/MVC_G1-LIBRARY-MANAGE-SYSTEM');
?>