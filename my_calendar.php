 <?php
 	session_start();

	if(!isset($_SESSION['username'])) {
		header('location:login.php');
	}

	require('chart_connection.php');
	require('connection.php');

	function char_at($str, $pos) {
  		return $str{$pos};
	}

 ?>
 <!DOCTYPE html>
  <html>
    <head>
    	<title>Welcome, <?php echo $_SESSION['name'] .'! :)'; ?></title>
    	<link href="css/metro.css" rel="stylesheet">
    	<link href="css/icons/material-icons.css" rel="stylesheet">
		<link href="css/metro-icons.css" rel="stylesheet">
		<link href="css/materialize.min.css" rel="stylesheet">
		<link href="css/custom.css" rel="stylesheet">
		<link href="https://cdn.alloyui.com/3.0.1/aui-css/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
    	<nav style="background-color: indigo;">
    		<div class="nav-wrapper">
    			<i class="large material-icons" style="font-size: 40px;padding-left: 10px;"><a href="index.php">home</a></i>
    		</div>
    	</nav>
	    <div class="wrapper">
	    	<div id="myScheduler"> </div>
	    </div>

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript" src="js/metro.js"></script>
    <script src="https://cdn.alloyui.com/3.0.1/aui/aui-min.js"></script>
    <script type="text/javascript">
	    YUI().use(
		  'aui-scheduler',
		  function(Y) {
		    var events = [
			<?php
		      	$result = $db->query("SELECT name, DATE_FORMAT(time_in, '%Y') as y, DATE_FORMAT(time_in, '%m') as m, DATE_FORMAT(time_in, '%d') as d, TIME_FORMAT(time_in, '%h') as h, TIME_FORMAT(time_in, '%i') as mi, TIME_FORMAT(time_in, '%s') as s, DATE_FORMAT(time_out, '%Y') as oy, DATE_FORMAT(time_out, '%m') as omi, DATE_FORMAT(time_out, '%d') as od, TIME_FORMAT(time_out, '%h') as oh, TIME_FORMAT(time_out, '%i') as om, TIME_FORMAT(time_out, '%s') as os FROM timestamps WHERE employee_id = " . $_SESSION['employee_id'] ." AND time_out < CURDATE()");
	      			if($result->num_rows > 0) {
						while($row = $result->fetch_assoc()) {
							echo "{
								content: 'Login time',
								startDate: new Date(".$row['y'].", ".(char_at($row['m'], 0) == '0' ? char_at($row['m'], 1) - 1 : $row['m'] - 1).", ".(char_at($row['d'], 0) == '0' ? char_at($row['d'], 1) : $row['d']).", ".(char_at($row['h'], 0) == '0' ? char_at($row['h'], 1) : $row['h']).", ".(char_at($row['s'], 0) == '0' ? char_at($row['s'], 1) : $row['s'])."),
								endDate: new Date(".$row['oy'].", ".(char_at($row['m'], 0) == '0' ? char_at($row['m'], 1) - 1 : $row['m'] - 1).", ".(char_at($row['od'], 0) == '0' ? char_at($row['od'], 1) : $row['od']).", ".(char_at($row['oh'], 0) == '0' ? char_at($row['oh'], 1) : $row['oh']).", ".(char_at($row['os'], 0) == '0' ? char_at($row['os'], 1) : $row['os']).")
							},\n"; 
						}
					}
				?>
		    ];

		    var dayView = new Y.SchedulerDayView();
		    var weekView = new Y.SchedulerWeekView();
		    var monthView = new Y.SchedulerMonthView();

		    new Y.Scheduler({
		        activeView: monthView,
		        boundingBox: '#myScheduler',
		        items: events,
		        render: true,
		        views: [dayView, weekView, monthView]
		      }
		    );
		  }
		);
    </script>
    </body>
  </html>