<?php
	require('connection.php');
	try {
		session_start();

		$update_emp_status = $conn->prepare("UPDATE timestamps SET status = 'SHIFT ENDED' WHERE id = ? AND employee_id = ?");
        $update_emp_status->execute([$_SESSION['temp_id'], $_SESSION['employee_id']]);

		$logout_note = $_POST['note_on_logout'];
		$time_out = $conn->prepare("UPDATE timestamps SET time_out = now() WHERE id = ? AND employee_id = ?");
		$time_out->execute([$_SESSION['temp_id'], $_SESSION['employee_id']]);

		$insert_logout_note = $conn->prepare("INSERT INTO notes VALUES ('', ?, '0', ?, now())");
        $insert_logout_note->execute([$_SESSION['employee_id'], $logout_note]);
		
		unset($_COOKIE['user']);
		setcookie('user', '', time()-3600);
		session_destroy();

		header('location:login.php');
	} catch(PDOException $e) {
		echo $e->getMessage();
	}
?>
