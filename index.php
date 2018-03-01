 <?php
 	session_set_cookie_params(0);
    session_start();

    require('connection.php');
    require('chart_connection.php');
    require('web_api.php');
   	// include('accuweather_webservice.php');

    if(isset($_COOKIE['user'])) {
    	$id = $conn->prepare("SELECT id, username, email, name, dept, user_type FROM users WHERE username = ?");
		$id->execute([$_COOKIE['user']]);
		$row = $id->fetch(PDO::FETCH_ASSOC);

		$first_name = explode(' ', $row['name']);

		$_SESSION['employee_id'] = $row['id'];
		$_SESSION['username'] = $row['username'];
		$_SESSION['name'] = $first_name[0];
		$_SESSION['dept'] = $row['dept'];
		$_SESSION['user_type'] = $row['user_type'];
		$_SESSION['full_name'] = $row['name'];
		$_SESSION['user_email'] = $row['email'];
		$_SESSION['admin_type'] = $row['user_type'];

		$get_timestamp = $conn->prepare("INSERT INTO timestamps VALUES('', ?, ?, ?, now(), null, null)");
		$get_timestamp->execute([$row['id'], $row['name'], $row['dept']]);
    }
    
    if(!isset($_SESSION['username'])) {
        header('location:login.php');
    }

    try {
        $temp_id = $conn->prepare("SELECT id FROM timestamps WHERE employee_id = ? ORDER BY id DESC LIMIT 1");
        $temp_id->execute([$_SESSION['employee_id']]);
        $temp_id = $temp_id->fetch(PDO::FETCH_ASSOC)['id'];

        $_SESSION['temp_id'] = $temp_id;

        $update_emp_status = $conn->prepare("UPDATE timestamps SET status = 'ON SHIFT' WHERE id = ? AND employee_id = ?");
        $update_emp_status->execute([$temp_id, $_SESSION['employee_id']]);

        // $head_text =  $headline . ' in Legazpi city with a low of ' . $minimum_temp .'&#176;C and a high of '. $maximum_temp .'&#176;C'. '<br/>';
        // $icon =  '<img length="120px" width="95px" src="https://developer.accuweather.com/sites/default/files/'.$icon_day.'-s.png">';

        // $date = getDate();
        // $parsed_date =  $date['weekday'] .' '. $date['mday'].', '. $date['month'] . ' ' . $date['year'];

        $saying = $conn->prepare("SELECT name, quote FROM `quotes1` ORDER BY RAND() LIMIT 1");
        $saying->execute();

        $row = $saying->fetch(PDO::FETCH_ASSOC);
        $name = $row['name'];
        $quote = $row['quote'];

        $employees = $conn->prepare("SELECT u.id, u.name, t.status, TIME_FORMAT(t.time_in, '%h:%i %p') as time_in, TIME_FORMAT(t.time_out, '%h:%i %p') as time_out, u.dept FROM users u JOIN timestamps t ON u.id = t.employee_id WHERE t.time_in >= CURDATE() ORDER BY time_in");
        $employees->execute();

        $result = $db->query("SELECT dept as dept, COUNT(name) as count FROM timestamps  WHERE time_in >= CURDATE() GROUP BY dept");


    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Welcome, <?php echo $_SESSION['name'] .'! :)'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css" />
    <!-- Materialize CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
	<link href="css/icons/material-icons.css" rel="stylesheet"/>
	<!-- Metro CSS -->
	<link href="css/metro-icons.css" rel="stylesheet"/>
	<link href="css/metro.css" rel="stylesheet"/>
	<!-- Google -->
	<link rel="stylesheet" href="css/icons/icons.css"/>
	<link href='http://fonts.googleapis.com/css?family=Cookie' rel='stylesheet' type='text/css'/>
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="css/custom.css"/>
    <script type="text/javascript">
    	var auto_refresh = setInterval(
    		function(){
    			$('#quotes').load(document.URL + ' #quotes');
    			
    		},30000);
    </script>
</head>
<body>
	<!-- <div class="spinner_wrapper bg-darkGray">
		<div data-role="preloader" data-type="square" data-style="color" id="loader"></div>
    </div> -->
    <div class="container-fluid">
        <div class="row">
        	<!-- WEATHER -->
            <div class="topblock image-block col-lg-6 col-md-6 col-sm-6 col-xs-12" style="background: url(https://source.unsplash.com/random?weather,dark) no-repeat center top;background-size:cover;">
       			<div class="weather-slider">
	        		<?php
	        			echo $icon;
	        			echo '<span class="flow-text weather-style">' . $minimum_temp . '&#176;C</span>';
	        		?>
	        	</div>
	        	<div style="margin-left: 35px;">
	        		<span class="flow-text weather-style"><?php echo $parsed_date; ?></span>
	        	</div>
	        	<div style="margin-top: 10px; margin-left: 30px;">
		        	<div class="flow-text weather-style-w-font" id="clock"></div>
	        		<span class="flow-text weather-style"><?php echo $icon_day_phrase;?></span>
	        	<?php 
		        	// echo '<span class="flow-text weather-style"> Hi, '.$_SESSION['name']. '! How are you? <br/>
	        		// <br/>' . $head_text . '</span>'; 
        		?>
	        	</div>
            </div>
            <!-- QUOTE -->
            <div class="topblock image-block col-lg-6 col-md-6 col-sm-6 col-xs-12" style="background: url(https://source.unsplash.com/random?space) no-repeat center top;background-size:cover;overflow-y: auto;">
               <p id="quotes" class="quote-style"><?php echo $quote . '<br /> -'.$name;?></p>
            </div>
            <!-- TABLE -->
            <!-- datatables.net -->
            <div id="test" class="botblock image-block col-lg-6 col-md-6 col-sm-6 col-xs-12" style="background-color: #3e3a4b;color:white;overflow-y: auto;">
         		<table id="table" class="display">
			        <thead>
						<tr>
							<th>NAME</th>
							<th>IN</th>
							<th>OUT</th>
							<th>TEAM</th>
							<th>STATUS</th>
						</tr>
			        </thead>
			   <!--      <tbody>
			        	<?php
			        		while($row = $employees->fetch(PDO::FETCH_ASSOC)) {
			        			echo '
			        				<tr>
			        					<td>'.$row['name'].'</td>
			        					<td>'.$row['time_in'].'</td>
			        					<td>'.$row['time_out'].'</td>
			        					<td>'.$row['dept'].'</td>
			        					<td>'.$row['status'].'</td>
			        				</tr>
			        			';
			        		}
			        	?>
			        </tbody> -->
			      </table>
            </div>
            <!-- DONUT -->
            <div class="botblock image-block col-lg-4 col-md-4 col-sm-4 col-xs-12" style="background-color:#2d293a ;">
            	<div id="donut_chart" class="custom-donut"></div>
            </div>
            <!-- SMOLS -->
            <!-- Memo -->
            <a href="bulletin.php">
            	<div class="smolblock image-block col-lg-2 col-md-2 col-sm-2 col-xs-6" data-toggle="tooltip" title="Office Announcements" style="background: url(images/49886-palace-of-westminster-in-london-3840x2160-world-wallpaper.jpg);">
				    <div class="tile-content">
				    	<br/>
				    	<span class="icon"><img src="images/notebook.svg"/>
				    		
				    	</span>
				    </div>
				</div>
            </a>
            <!-- timesheet -->
            <a href="my_calendar.php">
	            <div class="smolblock image-block col-lg-2 col-md-2 col-sm-2 col-xs-6" data-toggle="tooltip" title="My Attendance" style="background: url(images/49886-palace-of-westminster-in-london-3840x2160-world-wallpaper.jpg);">
				    <div class="tile-content">
				    	<br/>
				    	<span class="icon"><img src="images/icon.svg"/></span>
				    </div>
	            </div>
            </a>
        </div>
    </div>
	<div class="fixed-action-btn">
	    <button class="btn-floating pulse waves-light btn-large bg-crimson z-depth-5">
	      <span class="mif-menu mif-2x"></span>
	    </button>
	    <ul>
	    	<li>
	    		<!-- Logout -->
			    <button onclick="metroDialog.open('#dialog')" class="btn-floating pulse waves-light btn-large bg-black z-depth-5">
			      <span class="mif-switch mif-2x"></span>
			    </button>
		    </li>
		    <li>
		    	<!-- Change Pass -->
			    <button class="btn-floating pulse waves-light btn-large bg-orange" data-toggle="modal" data-target="#exampleModal">
			      <i class="material-icons">settings</i>
			    </button>
		    </li>
		    <!-- Admin -->
		    <li>
		    	<a href="../timeclock-dashboard/index.php" data-toggle="tooltip" title="Admin">
			    	<button class="btn-floating pulse waves-light btn-large">
			    		<i class="material-icons">person_pin</i>
			    	</button>
		    	</a>
		    </li>
		    <li>
		    	<!-- on login note -->
			    <button class="btn-floating pulse waves-light btn-large bg-violet" data-toggle="modal" data-target="#onLoadModal">
			      <i class="material-icons">add_circle</i>
			    </button>
		    </li>
		    <li>
		    	<!-- break -->
                <form method="post">
                    <li>
                        <button name="break_in" class="btn-floating pulse waves-light btn-large bg-green z-depth-5">
                           <i class="material-icons">free_breakfast</i>
                        </button>
                    </li>
                </form>
		    </li>
	    </ul>
	</div>
	<!-- Modal Structure Change Pass -->
	<div class="modal modal-sm" id="exampleModal" style="height:55vh;background-color: white;color:grey;border-radius: 10px;">
		<div class="modal-header">
			<h3 >Change Password</h3>
		</div>
		<div class="modal-body">
	        <form method="post" action="changepass.php">
	          <div class="form-group">
	            <label for="message-text" class="col-form-label">Current Password: </label>
	            <input type="password" class="form-control" name="prevpass" placeholder="Password">
	          </div>
	          <div class="form-group">
	            <label for="message-text" class="col-form-label">New Password: </label>
	            <input type="password" class="form-control" name="nupass" placeholder="New password">
	          </div>
	          <div class="form-group">
	            <label for="message-text" class="col-form-label">Re-type password: </label>
	            <input type="password" class="form-control" name="renupass" placeholder="Re-type password">
	          </div>
		        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" style="width:150px;">Close</button> &nbsp;
	        	<button type="submit" class="btn btn-primary btn-sm" name="submit" style="width:150px;">OK</button>
	        </form>
    	</div>
	</div>

	<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.1.0/js.cookie.js"></script>
	<script type="text/javascript" src="libs/jquery.slimscroll.min.js"></script>
	<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="js/fnReloadAjax.js"></script>
	<!-- cookie script -->
	<script type="text/javascript" src="js/jquery.cookie.js"></script>
	<!-- Materialize JS -->
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
	<!-- Donut chart JS -->
    <script type="text/javascript" src="js/chart_controller.js"></script>
    <!-- Metro UI JS -->
    <script type="text/javascript" src="js/metro.js"></script>
    <!-- Custom JS -->
    <script type="text/javascript" src="js/custom.js"></script>
    <!-- Bootstrap JS -->
    <script type="text/javascript" src="js/popper.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <!-- Google charts JS -->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  	<script type="text/javascript">
    	google.charts.load('current', {'packages':['corechart']});
		google.charts.setOnLoadCallback(drawChart);
			function drawChart() {

			    var data = google.visualization.arrayToDataTable([
			      ['Team', 'Count'],
				      <?php
				      		require('chart_connection.php');
				            if($result->num_rows > 0) {
					          while($row = $result->fetch_assoc()){
					            echo "['".$row['dept']."', ".$row['count']."],";
					          }
					      	}
				      ?>
			    ]);
			    var chart = new google.visualization.PieChart(document.getElementById('donut_chart'));

			    chart.draw(data, { backgroundColor: { fill:'transparent' },
			        pieHole: 0.56,
			        pieSliceText: 'none',
					titleTextStyle: {
					    color: '#FFFFFF'
					},

					legend: {position: 'bottom',textStyle: {color: '#FFFFFF'}}});
			}
    </script>
	<script type="text/javascript">
		$(document).ready(function(e) {
			var tab = $('#table').DataTable({
				paging: false,
				info: false,
				bFilter: false
			});		
			    	setInterval(function(){
			    		$.get('getData.php', 
			    			function(response){
				    			var json = $.parseJSON(response);
				    			// console.log(json);
				    			tab.clear();
				    			for(var x=0;x<json.length;x++) {
				    				tab.row.add([json[x].name,json[x].time_in,json[x].time_out,json[x].dept,json[x].status]);
				    			}
				    			tab.draw();
			    		});
			    	}, 1000);
		});
    </script>
</body>
    <div data-role="dialog" id="dialog" class="padding20 dialog bg-crimson confirm" data-close-button="true" data-windows-style="true">
    	<form method="post" action="logout.php">
    		<textarea style="resize: none; color: white;" placeholder="What is it all about?" name="note_on_logout"></textarea>
    	    <h2 class="weather-style">Please don't leave me, <?php echo $_SESSION['name'].'! :('?></h2>
    	    <h6 class="weather-style">&nbsp;Are you really sure you want to logout?</h6>
    	    <div class="confirm_buttons" style="margin-left: 70%;">
    		    <button type="submit" id="input" class="button">Logout</button>
    	    </div>
        </form>
	</div>
</html>