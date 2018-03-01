<?php
	session_start();

	if(!empty($_SESSION['username'])) {
		header('location:index.php');
	}

	require('connection.php');
	include('web_api.php');
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title> Welcome to Greymouse Login System</title>
		<link href="css/metro.css" rel="stylesheet">
		<link href="css/metro-icons.css" rel="stylesheet">
		<link href="css/custom.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet">
		<link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<div class="background-image"></div>
		<div class="content">
				<center style="margin-top: 10%;">
					<div>	
						<span class="title">Welcome to Greymouse</span>
					</div>
				</center>
				<div class="login_form"> 
					<div class="form_content">
						<form method="post">
							<div>
								<label id="name">Username</label> 
								<div class="input-control text">
								    <input id="input" type="text" name ="username" required>
								</div>
							</div>
							<div>
								<label id="name">Password&nbsp;</label> 
								<div class="input-control text">
								    <input id="input" type="password" name="password" required>
								</div>
							</div>
								<center>
									<button class="button login" id="name" name="submit">Login</button>
								</center>
						</form>
					</div>
				</div>
			<?php if(isset($message)): ?>
				<div class="invalid">
					<span class="invalid_text"> <?php echo '<center>'.$message.'</center>'; ?> </span>
				</div>
			<?php endif ?>
			
			<center style="margin-top: 20px;">
				<div class="footer">
					<span id="footer_content">&copy; Greymouse Investment</span> <br />
					<span id="footer_content">All rights reserved</span>
				</div>
			</center>
		</div>
		<script src="js/jquery.js"></script>
    	<script src="js/metro.js"></script>
	</body>
</html>