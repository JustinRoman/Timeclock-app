<?php
	session_start();
	$conn = new PDO('mysql:host=localhost;dbname=gmloginsystem',"root","");

	$currentPassword = $_POST['prevpass'];
	$newPass = $_POST['nupass'];
	$confirmPass = $_POST['renupass'];

	if(empty($currentPassword)||empty($newPass)||empty($confirmPass)){
		echo "<script>alert ('Empty Fields!') </script>";
		die();
	}else if($newPass!=$confirmPass){
		echo $newPass . " " . $renupass;
		echo "<script>alert ('Passwords does not match!') </script> ";
		die();
	}else{
		$password_hashed = password_hash($newPass, PASSWORD_BCRYPT);

		$check_password = $conn->prepare("SELECT password FROM users WHERE password = ? AND username = BINARY ?");
		$check_password->execute([$currentPassword, $_SESSION['username']]);

		$verify = $conn->prepare("SELECT password as pw FROM users WHERE username = ?");
        $verify->execute([$_SESSION['username']]);
        $verify = $verify->fetch(PDO::FETCH_ASSOC)['pw'];

        $validity = password_verify($currentPassword, $verify);

        echo 'Validity: ' . $validity;

        $change_pass = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");

        $password_hashed =  password_hash($newPass, PASSWORD_BCRYPT);
        $change_pass->execute([$password_hashed, $_SESSION['username']]);
        echo "Success!";

		header('location: index.php');
	}

?>
