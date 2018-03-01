<?php
  session_start();

  if(!empty($_SESSION['username'])) {
    header('location:index.php');
  }

  require('connection.php');
  include('web_api.php');
?>

<!doctype html>
<html lang="en">
  <head>
    <title> Welcome to Greymouse Login System</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/custom.css">
  </head>
  <body class="background-image">
    <center>
      <span style=" font: 400 100px/1.5 'Pacifico', Helvetica, sans-serif;
  color: #FFFFFF;
  text-shadow: 4px 4px 0px rgba(0,0,0,0.1);
  font-size: 350%;">Welcome to Greymouse</span>
    </center>
    <div class="container-fluid">
      <div class="login_form">
        <div class="container-fluid">
          <form method="POST">
            <div class="form-group">
              <label id="name">Username</label>
              <input class="form-control col-sm-12" id="input" type="text" name="username" required>
            </div>
            <div class="form-group">
              <label id="name">Password</label>
              <input class="form-control col-sm-12" id="input" type="password" name="password" required>
            </div>
            <center><button class="login" id="name" name="submit">Login</button></center>
          </form>
        </div>
      </div>
      <?php if(isset($message)): ?>
        <div class="invalid">
          <span class="invalid_text"> <?php echo '<center>'.$message.'</center>'; ?> </span>
        </div>
      <?php endif ?>
      <center style="margin-top: 1vh;">
        <div class="input">
          <span id="footer_content">&copy; Greymouse Investment</span> <br />
          <span id="footer_content">All rights reserved</span>
        </div>
      </center>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>