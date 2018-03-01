<?php
	session_start();
	require('connection.php');

	try{
		if(isset($_POST['submit'])){
			$note = $_POST['note'];
		}else{
			$sql = "INSERT INTO breaks (note) values (?)";
			$stmt = $conn->prepare($sql);
			$stmt->execute(array($note));
			}	
		
	}catch(PDOexception $e){
		echo "error: " . $e->getMessage();
	}
	$conn = null;
?>