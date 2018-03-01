 <?php
 	session_start();
 	require('connection.php');
	if(!isset($_SESSION['username'])) {
		header('location:login.php');
	}

	try {
		$memos = $conn->prepare("SELECT id, to_, from_, subject, content, time_added FROM memos");
		$memos->execute();            
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
    <body>
    	<nav style="background-color: indigo;">
    		<div class="nav-wrapper">
    			<i class="large material-icons" style="font-size: 40px;padding-left: 10px;"><a href="index.php">home</a></i>
    		</div>
    	</nav>
    	<div class="container">	
		    <div class="row">
		    	<?php
		    		$x = 0;
		    		while($memo = $memos->fetch(PDO::FETCH_ASSOC)) {
		    			echo '
		    				<div class="card large z-depth-5" style="margin-left: 10%; width: 750px; height: 300px; margin-left: auto; margin-right: auto;">
							    <div class="card-image waves-effect waves-block waves-light">
							      <img class="activator" src="images/poster-square.png" width="100px" height="100px"/>
							    </div>
							    <div class="card-content">
							      <span class="card-title activator grey-text text-darken-4">Memo #'.$memo["id"].' from '.$memo["from_"].' to '.$memo["to_"].'<i class="material-icons right">more_horiz</i></span>
								</div>
							    <div class="card-reveal">
							      <span class="card-title grey-text text-darken-4"><b>Re: </b>'.$memo["subject"].'<i class="material-icons right">close</i></span>
							      <span class="card-title grey-text text-darken-4"><b>Date: </b>'.$memo["time_added"].'</span>
							      <p style="text-align: justify;">'.$memo["content"].'</p>
							    </div>
							  </div>
		    			';
		    		}

		    	?>
	    	</div>
    	</div>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript" src="js/metro.js"></script>
    </body>
  </html>