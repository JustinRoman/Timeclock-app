<?php
	require('connection.php');
	try {
		$statement=$conn->prepare("SELECT u.name, TIME_FORMAT(t.time_in, '%h:%i %p') as time_in, TIME_FORMAT(t.time_out, '%h:%i %p') as time_out, u.dept, t.status FROM users u JOIN timestamps t ON u.id = t.employee_id WHERE t.time_in >= CURDATE() ORDER BY time_in");
		$statement->execute();

		$results = $statement->fetchAll(PDO::FETCH_ASSOC);
	
		$json_v = json_encode($results);
		echo $json_v;
	}catch(PDOException $e){
		echo "error: " . $e->getMessage();
	}
?>