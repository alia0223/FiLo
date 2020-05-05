<?php
//start session
session_start();
//establish mysql connection
$conn = mysqli_connect('localhost','u-alia74','gNsbwReathEvN7X','u_alia74_db');
if(!$conn){
  $error = "Error connecting to database...";
}
//deal with forgot password request. Send email containing reset link if correct email is enter i.e. account exists
if(isset($_POST['submit'])) {
  $email = mysqli_real_escape_string($conn,$_POST['email']);
  $query = "SELECT * FROM userdetails WHERE Email='$email'";
  $run = mysqli_query($conn,$query);
  if(mysqli_num_rows($run)>0) {
	$to = $email;
    $token = uniqid(md5(time()));
    $query = "INSERT INTO password_reset(ID,Email,Token) VALUES (NULL,'$email','$token')";
    if(mysqli_query($conn,$query)){
      try {
        $subject = 'Password Reset';
        $message_body = '<b>Please click the link below to reset your password: <br /><br /></b>
       https://alia74.cs2410-web01pvm.aston.ac.uk/CS2410/Coursework/php/resetpass.php?Token='.$token.'
        <br /><br /><br />
        <i>If this is not your account or you did not request this change please ignore this email.</i>';
      	$headers = "MIME-Version: 1.0". "\r\n";
      	$headers .="Content-type:text/html;charset=UTF-8"."\r\n";
		mail($to,$subject,$message_body,$headers);
        echo "<a href=\"/CS2410/Coursework/php/login.php\" class=\"alert alert-success text-center\" style=\"width:100%; margin:0 auto; position:absolute; bottom:0px; z-index:1;\">Email Sent. Click to Login!</a></div>";
      } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }
    }
  }
  else {
      echo "<div class=\"alert alert-danger text-center\" style=\"margin:0 auto; position:absolute; bottom:0px; width:100%;\">Account with this email does not exist!</div>";
  }
}
//close sql connection
$conn->close();
//navigation buttons to each page that is accessible from current page
if(isset($_POST['homebtn'])) {
  header('location:/index.php');
}
elseif(isset($_POST['lgnbtn'])){
  header('location:/CS2410/Coursework/php/login.php');
}
elseif(isset($_POST['rgstbtn'])){
  header('location:/CS2410/Coursework/php/register.php');
}
elseif(isset($_POST['vlibtn'])){
  header('location:/CS2410/Coursework/php/publichome.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/CS2410/Coursework/css/forgotpass.css"/>
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
        <li><input href="/CS2410/Coursework/php/register.php" type="submit" name="lgnbtn" value="Login" class="btn" /></li>
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
      <form class="text-center" action="/CS2410/Coursework/php/forgotpass.php" method="POST">
        <!-- Email Form -->
        <div class="form-group">
          <label id="email-label">Please Enter Your Email Below</label>
          <input type="email" name="email" id="email" class="form-control" placeholder="E-mail" required/>
        </div>
        <!-- Send Email Button -->
        <div class="form-group">
          <button class="send-email" type="submit" name="submit" value="Send">Send Code To Mail</button>
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
