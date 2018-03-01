<?php
	try {
		// $host
		// $username
		// $password
		// $db_name
		$db = new mysqli("localhost", "root", "", "gmloginsystem");
		//echo 'Connection established!';	
	} catch(PDOException $e) {
		$e->getMessage();
	}
?>