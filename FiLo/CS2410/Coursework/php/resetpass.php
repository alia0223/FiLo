<?php
//session starts
session_start();
$error = "";
//establish sql connection
$conn = mysqli_connect('localhost','u-alia74','gNsbwReathEvN7X','u_alia74_db');
if(!$conn){
  $error = "Error connecting to database...";
}
//match token stored in databse to current user token to check if they have the authorization to reset password for account in question
if(isset($_GET['Token'])) {
    $token = mysqli_real_escape_string($conn,$_GET['Token']);
    $query = "SELECT * FROM password_reset WHERE Token='$token'";
    $run = mysqli_query($conn,$query);
    if(mysqli_num_rows($run)>0){
      $row = mysqli_fetch_array($run);
      $token = $row['Token'];
      $email = $row['Email'];
    }
}
//if token is invalid take user to login page not reset password page
else {
  header('location:/CS2410/Coursework/php/login.php');
}
//if token is valid then submit new hashed password.
if(isset($_POST['submit'])) {
  $email = mysqli_real_escape_string($conn,$_POST['email']);
  $password = mysqli_real_escape_string($conn,$_POST['reset-pwd']);
  $confirmpassword = mysqli_real_escape_string($conn,$_POST['reset-confirmpwd']);
  $hashed_password = password_hash($password,PASSWORD_DEFAULT,['cost => 11']);
  //update the password belonging to the email of the user that requested the change
  $query = "UPDATE userdetails SET Password='$hashed_password' WHERE Email='$email'";
  mysqli_query($conn,$query);
  //remove reset request from reset table so reset password link is no longer usable
  $query = "DELETE FROM password_reset WHERE Email='$email'";
  mysqli_query($conn,$query);
  echo "<a href=\"/CS2410/Coursework/php/login.php\" class=\"alert alert-success text-center\" style=\"width:100%; margin:0 auto; position:absolute; bottom:0px; z-index:1;\">Password Reset! Login</a>";
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/CS2410/Coursework/css/resetpass.css"/>
  <script type="text/javascript" language="javascript" src="/CS2410/Coursework/js/jquery.js"></script>
  <script type="text/javascript" language="javascript" src="/CS2410/Coursework/js/resetpass.js"></script>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  <title>FiLo | Lost & Found</title>
</head>
<body>
  <main>
    <div class="circle-container">
            <form id="registration_form" action="/CS2410/Coursework/php/resetpass.php" method="POST">
              <div class="form-group">
                <input type="text" name="email" class="form-control hide" placeholder="Password" value="<?php echo $email; ?>" required/>
              </div>
              <div class="form-group">
                <label id="reset-pass-label" for="form_pass">New Password</label>
                <input type="password" name="reset-pwd" class="form-control" id="form_pass" placeholder="Password" required>
              </div>
              <div class="form-group">
                <label id="reset-confirmpass-label">Confirm Password</label>
                <input type="password" name="reset-confirmpwd" placeholder="Confirm Password" class="form-control" id="form_confirmpass"required/>
              </div>
              <input type="submit" name="submit" value="Reset" />
          </form>
    </div>
  	<span class="error_form alert alert-danger text-center" id="pass_error_message" style="position:absolute; bottom:0px; width:100%; margin:0px;" ></span>
    <span class="error_form alert alert-danger text-center" id="confirmpass_error_message" style="position:absolute; bottom:0px; width:100%;margin:0px;" ></span>
  </main>
  <script src="https://code.jquery.com/jquery-1.12.4.min.js">
  </script>
  <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js">
  </script>
  <script src="/CS2410/Coursework/js/jquery.resetpasswordstrength.js">
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
