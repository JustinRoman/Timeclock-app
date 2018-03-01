 <?php
 	session_start();

	if(!isset($_SESSION['username'])) {
		header('location:login.php');
	}

	try {
				            
	} catch (PDOException $e) {
		echo $e->getMessage();
	}
 ?>
 <!DOCTYPE html>
  <html>
    <head>
    	<title>Office Bulletin</title>
    	<link href="css/metro.css" rel="stylesheet">
    	<link href="css/icons/material-icons.css" rel="stylesheet">
		<link href="css/metro-icons.css" rel="stylesheet">
		<link href="css/materialize.min.css" rel="stylesheet">
		<link href="css/custom.css" rel="stylesheet">
		<link href='http://fonts.googleapis.com/css?family=Cookie' rel='stylesheet' type='text/css'>
    </head>
    <body style="position: fixed; color: #FFFFFF; text-shadow: 4px 4px 0px rgba(0,0,0,0.1); background-image: url(https://source.unsplash.com/random/1600x900?black,landscape);">
    	<div class="container">
    		<p style="font-size: 50px; text-align: center; " class="flow-text"> See you later, <?php  echo $_SESSION['name'] .'! <br />Have a nice break. :)' ?> </p>
    		<center><div class="countdown" data-minutes="15" data-background-color="ribbed-darkGray" data-role="countdown"></div></center>
    		<script>
			    $(function(){
			        $("#countdown").countdown();
			    });
			</script>
    	</div>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript" src="js/metro.js"></script>
    </body>
  </html>