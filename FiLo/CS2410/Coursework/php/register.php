<?php
//start session
session_start();
//navigate to page that belongs to selected button
if(isset($_POST['homebtn'])) {
  header('location:/index.php');
}
elseif(isset($_POST['lgnbtn'])){
  header('location:/CS2410/Coursework/php/login.php');
}
elseif(isset($_POST['vlibtn'])){
  header('location:/CS2410/Coursework/php/publichome.php');
}
//establish sql connection
$conn = mysqli_connect('localhost','u-alia74','gNsbwReathEvN7X','u_alia74_db');
if(!$conn){
  $error = "Error connecting to database...";
}
//add email and hashed password to userdetails table
if(isset($_POST['submit'])){
  $email = mysqli_real_escape_string($conn,$_POST['email']);
  $pass = mysqli_real_escape_string($conn,$_POST['pwd']);
  $confirmpass = mysqli_real_escape_string($conn,$_POST['confirmpwd']);
  $hashed_pass = password_hash($pass,PASSWORD_DEFAULT,['cost'=>11]);

  $conn = mysqli_connect('localhost','u-alia74','gNsbwReathEvN7X','u_alia74_db');
  if(!$conn){
    $error = "Error connecting to database...";
  }

  $sql = "SELECT * FROM userdetails WHERE Email = '$email'";
  $result = mysqli_query($conn, $sql);
  $num = mysqli_num_rows($result);

  if($num == 1) {
    echo "<div class=\"alert alert-danger text-center\" style=\"margin:0 auto; position:absolute; bottom:0px; width:100%;\">Email Taken</div>";
  }
  else {
    $reg = "INSERT INTO userdetails(ID,Email, Password) values (NULL,'$email','$hashed_pass')";
    mysqli_query($conn, $reg);
    echo "<div class=\"alert alert-success text-center\" style=\"margin:0 auto; position:absolute; bottom:0px; width:100%;\"><a href=\"/CS2410/Coursework/php/login.php\">Registration Successful. Login!</a></div>";
  }
}
//end sql connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/CS2410/Coursework/css/register.css"/>
  <script type="text/javascript" language="javascript" src="/CS2410/Coursework/js/jquery.js"></script>
  <script type="text/javascript" language="javascript" src="/CS2410/Coursework/js/register.js"></script>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  <title>FiLo | Lost & Found</title>
</head>
<header>
  <!---           NAV BUTTONS           --->
  <div class="navbar navbar-header" style="height:50px;">
    <form action="register.php" method="POST">
      <ul style="list-style:none;">
        <li><input href="/index.php" type="submit" name="homebtn" value="Home" class="btn" /></li>
        <li><input href="/CS2410/Coursework/php/login.php" type="submit" name="lgnbtn" value="Login" class="btn" /></li>
        <li><input href="/CS2410/Coursework/php/publichome.php" type="submit" name="vlibtn"  value="View Lost Items" class="btn" /></li>
      </ul>
    </form>
  </div>
</header>
<body>
  <!---             REGITSER FORM             --->
  <main>
      <div class="circle-container">
        <form action="register.php" id="registration_form" method="post">
          <div class="form-group">
            <label id="email-label">Email</label>
            <input type="email" name="email" placeholder="Email" class="form-control" id="form_email" required/>
          </div>
          <div class="form-group">
            <label id="pass-label" for="form-pass">Password</label>
            <input type="password" name="pwd" class="form-control" id="form_pass" placeholder="Password" required>
          </div>
          <div class="form-group">
            <label id="confirmpass-label">Confirm Password</label>
            <input type="password" name="confirmpwd" placeholder="Confirm Password" class="form-control" id="form_confirmpass"required/>
          </div>
          <div class="form-group">
            <input type="submit" name="submit"/>
          </div>
        </form>
      </div>
      <span class="error_form alert alert-danger text-center" id="email_error_message" style="margin:0 auto; position:absolute; bottom:0px; width:100%;"></span>       
      <span class="error_form alert alert-danger text-center" id="pass_error_message" style="margin:0 auto; position:absolute; bottom:0px; width:100%;"></span>     
      <span class="error_form alert alert-danger text-center" id="confirmpass_error_message" style="margin:0 auto; position:absolute; bottom:0px; width:100%;"></span>
  </main>
  <script src="https://code.jquery.com/jquery-1.12.4.min.js">
  </script>
  <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js">
  </script>
<script src="/CS2410/Coursework/js/jquery.passwordstrength.js">
  </script>
  <script>
  $('#form_pass').passwordStrength();
</script>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>