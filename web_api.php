<?php

	require('connection.php');

	try {
		if(isset($_POST['submit'])) {
			$username = $_POST['username'];
			$password = $_POST['password'];

			$verify = $conn->prepare("SELECT password AS pw FROM users WHERE username = ?");
			$verify->execute([$username]);
			$verify = $verify->fetch(PDO::FETCH_ASSOC)['pw'];

			$validity = password_verify($password, $verify);

			if(empty($username) || empty($password)) {
				echo '
					<script>
						alert(\'Fields are empty!\');
					</script>
				';
				die();
			} else {
				if($validity == 1) {
					$cookie_name= "user";
				    setcookie($cookie_name, $username, time()+86400 * 30);

					header('location:index.php');
				} else {
					$message = "Ooops.. Invalid username/password.";
				}
			}
		} else if(isset($_POST['break_in'])) {
			try {
				$insert_break = $conn->prepare("INSERT INTO breaks VALUES ('',?, now(), null, null)");
				$insert_break->execute([$_SESSION['employee_id']]);

				header('location: break.php');
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
		} else if(isset($_POST['break_out'])) {
			    try {
			        session_start();

			        $time_out = $conn->prepare("UPDATE breaks SET break_end = now(), note = ? WHERE id = ? AND employee_id = ?");
			        $time_out->execute([$_POST['note'], $_SESSION['temp_break_id'], $_SESSION['employee_id']]);

			        header('location: index.php');
			    } catch(PDOException $e) {
			        echo $e->getMessage();
			    }
		}
	} catch(PDOException $e) {
		echo $e->getMEssage();
	}
?>
