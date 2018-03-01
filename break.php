 <?php
 	session_start();

	if(!isset($_SESSION['username'])) {
		header('location:login.php');
	}

    require('connection.php');
    require('web_api.php');

    try {
        $temp_break_id = $conn->prepare("SELECT id FROM breaks WHERE employee_id = ? ORDER BY id DESC LIMIT 1");
        $temp_break_id->execute([$_SESSION['employee_id']]);
        $temp_break_id = $temp_break_id->fetch(PDO::FETCH_ASSOC)['id'];

        $_SESSION['temp_break_id'] = $temp_break_id;

        $update_emp_status = $conn->prepare("UPDATE timestamps SET status = 'ON BREAK' WHERE id = ? AND employee_id = ?");
        $update_emp_status->execute([$_SESSION['temp_id'], $_SESSION['employee_id']]);

        echo 'ID: ' . $temp_break_id; 

        
    } catch(PDOException $e) {
        echo $e->getMessage();
    }

 ?>
 <!DOCTYPE html>
  <html>
    <head>
    	<title>Break Time!</title>
    	<link href="css/metro.css" rel="stylesheet">
    	<link href="css/icons/material-icons.css" rel="stylesheet">
		<link href="css/metro-icons.css" rel="stylesheet">
		<link href="css/materialize.min.css" rel="stylesheet">
		<link href="css/custom.css" rel="stylesheet">
		<link href='http://fonts.googleapis.com/css?family=Cookie' rel='stylesheet' type='text/css'>
        <link href='https://cdnjs.cloudflare.com/ajax/libs/easy-countdown/2.2.0/jquery.countdown.min.js' rel='stylesheet' type='text/css'>
    </head>
    <body style="position: fixed; color: #FFFFFF; text-shadow: 4px 4px 0px rgba(0,0,0,0.1); background-image: url(https://source.unsplash.com/random/1600x900?black,landscape);">
    	<div class="container">
    		<p style="font-size: 50px; text-align: center; " class="flow-text"> See you later, <?php  echo $_SESSION['name'] .'! <br />Have a nice break. :)' ?> </p>
        <center><div id="basicUsage" style="font-size: 200px; text-align: center; " class="flow-text">00:00:00</div></center>
            <form method="post" >
                <button type="submit" name="break_out" class="flow-text" position="center" style="margin-left: 25vw; margin-right: auto; margin-top: 20px; border-radius: 25px; border: 2px solid #FFFFFF; padding: 20px; width: 300px;height: 70px;background-color: transparent;">I'm ready to work! :)</button>
            </form>
        </div>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/easytimer.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript" src="js/metro.js"></script>
    <script type="text/javascript">
        var timer = new Timer();
        timer.start();
        timer.addEventListener('secondsUpdated', function (e) {
            $('#basicUsage').html(timer.getTimeValues().toString());
        });
    </script>
    </body>
  </html>