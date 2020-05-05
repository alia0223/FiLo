<?php
//session starts
session_start();
//navigation buttons to pages that are accessible from current page
if(isset($_POST['homebtn'])) {
  header('location:/index.php');
}
elseif(isset($_POST['rgstbtn'])){
  header('location:/CS2410/Coursework/php/register.php');
}
elseif(isset($_POST['vlibtn'])){
  header('location:/CS2410/Coursework/php/publichome.php');
}
//establish mysql connection
$conn = mysqli_connect('localhost','u-alia74','gNsbwReathEvN7X','u_alia74_db');
if(!$conn){
  $error = "Error connecting to database...";
}
//check if email exists and if it does check if the password matches then take it to user account or admin account depending on the email
if(isset($_POST['submit'])){
  $email = mysqli_real_escape_string($conn,$_POST['email']);
  $pass = mysqli_real_escape_string($conn,$_POST['pwd']);
  $_SESSION['user_email'] = $email;

  $sql = " SELECT * FROM userdetails WHERE Email = '$email'";
  $result = mysqli_query($conn,$sql);

  $rows = mysqli_fetch_array($result);
  if($rows){
    if((password_verify($pass,$rows['Password'])) && $rows['Email'] == 'asfand.y.ali99@gmail.com'){
      header('location:/CS2410/Coursework/php/adminhome.php');
    }
    elseif((password_verify($pass,$rows['Password'])) && $rows['Email'] != 'asfand.y.ali99@gmail.com'){
      header('location:/CS2410/Coursework/php/userhome.php');
    }
    else {
      echo "<div class=\"alert alert-danger text-center\" style=\"margin:0 auto; position:absolute; bottom:0px; width:100%;\">Invalid Password!</div>";
    }
  }
  else {
    echo "<div class=\"alert alert-danger text-center\" style=\"margin:0 auto; position:absolute; bottom:0px; width:100%;\">Account Does Not Exist!</div>";
  }

}
//close sql connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/CS2410/Coursework/css/login.css"/>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  <title>FiLo | Lost & Found</title>
</head>
<header>
  <!---           NAV BUTTONS           --->
  <div class="navbar navbar-header" style="height:50px;">
    <form action="login.php" method="POST">
      <ul>
        <li><input href="/index.php" type="submit" name="homebtn" value="Home" class="btn" /></li>
        <li><input href="/CS2410/Coursework/php/register.php" type="submit" name="rgstbtn" value="Register" class="btn" /></li>
        <li><input href="/CS2410/Coursework/php/publichome.php" type="submit" name="vlibtn"  value="View Lost Items" class="btn" /></li>
      </ul>
    </form>
  </div>
</header>
<body>
  <!---             LOGIN FORM             --->
  <main>
    <div class="circle">
      <form id="login-form" action="login.php" method="POST">
        <div class="form-group">
          <label id="email-label">Email</label>
          <input type="email" name="email" placeholder="Email" class="form-control" id="form_email" required/>
        </div>
        <div class="form-group">
          <label id="pass-label">Password</label>
          <input type="password" name="pwd" placeholder="Password" class="form-control" id="form_pass" required/>
        </div>
        <div class="form-group" style="text-align:center;">
          <a href="/CS2410/Coursework/php/forgotpass.php">Forgot Password?</a>
        </div>
        <div class="form-group">
          <input type="submit" name="submit" value="Login"/>
        </div>
      </form>
    </div>
  </main>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>
