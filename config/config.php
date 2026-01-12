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
?>