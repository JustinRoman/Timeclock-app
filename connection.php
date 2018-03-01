<?php
	try {
		$dsn ='mysql:host=localhost;dbname=gmloginsystem';
		$username = "root";
		$password = "";
		$options = [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'];

		$conn = new PDO($dsn, $username, $password, $options);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
		$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

		//echo 'Connection established!';	
	} catch(PDOException $e) {
		$e->getMessage();
	}
?>