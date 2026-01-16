<?php
	$host = "localhost";
	$user = "root";
	$password = "";
	$database = "library_db";

	try {
		// Create PDO connection
		$db = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $user, $password);
		
		// Set error mode to exception
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		//echo "Connected successfully";
	} catch(PDOException $e) {
		die("Connection failed: " . $e->getMessage());
	}
?>