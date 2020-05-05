<?php
session_start();
if(isset($_POST['logoutbtn'])){
  session_destroy();
  header('location:/index.php');
}
if($_SESSION['user_email']==true) {

}
else {
  header('location:/index.php');
}
//navigate to pages accessible from current page
if(isset($_POST['homebtn'])) {
  header('location:/CS2410/Coursework/php/adminhome.php');
}
elseif(isset($_POST['logoutbtn'])) {
  header('location:/index.php');
}
elseif(isset($_POST['vlibtn'])) {
  header('location:/CS2410/Coursework/php/requests.php');
}
//estblish sql connection
$conn = mysqli_connect('localhost','u-alia74','gNsbwReathEvN7X','u_alia74_db');
if(!$conn){
  $error = "Error connecting to database...";
}
//if admin clicks approve button, remove lost item from requests table and from lostitems table and notify user by email
if(isset($_POST['approve'])) {
  $id = $_COOKIE['id'];
  $useremail = $_COOKIE['email'];
  $sql = "DELETE FROM Requests WHERE Item_id=$id";
  $sql2 = "DELETE FROM lostitems WHERE item_id=$id";
  mysqli_query($conn,$sql);
  mysqli_query($conn,$sql2);
  header('location: /CS2410/Coursework/php/requests.php');

  $sql3 = "SELECT * FROM userdetails WHERE email = '$useremail'";
  $result = mysqli_query($conn, $sql3);
  $num = mysqli_num_rows($result);
  $rows = mysqli_fetch_array($result);
  $conn->close();
  if($num == 1) {
    try {
	  $to = $useremail;
      $subject = 'Lost item request Approved';
      $message_body = '<b>Your item has been approved! This item will be delivered to you shortly. <br /><br /></b>
      <br /><br /><br />';
      $headers = "MIME-Version: 1.0". "\r\n";
      $headers .="Content-type:text/html;charset=UTF-8"."\r\n";
	  mail($to,$subject,$message_body,$headers);
    } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
  }
}
//if admin clicks reject button, remove lost item from requests table notify user by email
if(isset($_POST['reject'])) {
  $id = $_COOKIE['id'];
  $reason = $_COOKIE['reason'];
  $useremail = $_COOKIE['email'];
  $sql = "DELETE FROM Requests WHERE Item_id=$id AND Reason='$reason' AND User='$useremail'";
  mysqli_query($conn,$sql);
  header('location: /CS2410/Coursework/php/requests.php');
  $sql2 = " SELECT * FROM userdetails WHERE email = '$useremail'";
  $result = mysqli_query($conn, $sql2);
  $num = mysqli_num_rows($result);
  $rows = mysqli_fetch_array($result);
  $conn->close();
  if($num == 1) {
    try {
      $to = $useremail;
      $subject = 'Lost item request Rejected';
      $message_body = '<b>Unfortunately, your item request has been rejected. <br /><br /></b>
      <br /><br /><br />';
      $headers = "MIME-Version: 1.0". "\r\n";
      $headers .="Content-type:text/html;charset=UTF-8"."\r\n";
	  mail($to,$subject,$message_body,$headers);
    } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/CS2410/Coursework/css/adminhome.css"/>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script scr="/CS2410/Coursework/js/sorttable.js"></script>
  <title>FiLo | Lost & Found</title>
</head>
<header>
  <!---           NAV BUTTONS           --->
  <div class="navbar navbar-header" style="height:50px;">
    <form action="requests.php" method="POST">
      <ul>
        <li><input href="/CS2410/Coursework/php/adminhome.php" type="submit" name="homebtn" value="Lost Items" class="btn" /></li>
        <li><input href="/index.php" type="submit" name="logoutbtn" value="Logout" class="btn" /></li>
        <li><input href="/CS2410/Coursework/php/requests.php" type="submit" name="vlibtn"  value="Requests" class="btn" /></li>
      </ul>
    </form>
  </div>
</header>
<body>
  <main>
    <form action="requests.php" method="POST" style="margin-top:50px;">
    <table class="main-table sortable" id="main-table" style="height:50px;">
      <tr>
        <th class="text-center">Item ID</th>
        <th class="text-center">Reason For Request</th>
        <th class="text-center">User Email</th>
        <th></th>
        <th></th>
      </tr>
      <?php
    //establish sql connection
      $conn = mysqli_connect('localhost','u-alia74','gNsbwReathEvN7X','u_alia74_db');
      if(!$conn){
        $error = "Error connecting to database...";
      }
      $sql = "SELECT Item_id,Reason,User from Requests";
      $result = $conn->query($sql);
      if($result->num_rows>0){
        while($row = $result-> fetch_assoc()) {
          echo
          "<tr>
          <td>".$row["Item_id"]."</td><td>".$row["Reason"]."</td><td>".$row["User"].
          "<td>
            <input type=\"submit\" value=\"Yes\" name=\"approve\" class=\"btn btn-success\" />
          </td>
          <td>
            <input type=\"submit\" value=\"No\" name=\"reject\" class=\"btn btn-danger \" />
          </td>
          </tr>";
        }
        echo "</table></form>";
      }
      else {
        echo "</table><p class=\"noreq text-center\">No Requests!</p>";
      }
      //close sql connection
      $conn->close();
      ?>
  </main>
  <script>

    // Creating a cookie after the document is ready
    // store id reason and email in cookie so these are accessible in php code above. 
    // Allows for email to be sent to correct user about correct item in lost items table.
    $(document).ready(function () {
      var row_index="";
      var newTable="";
      var rows="";
      var cells="";
      $('td').click(function(){
        row_index = $(this).parent().index();
        newTable = "";
        rows = document.getElementById("main-table").rows;
        cells = rows[row_index].cells;
        createCookie("id", cells[0].innerHTML, "10");
        createCookie("reason", cells[1].innerHTML, "10");
        createCookie("email", cells[2].innerHTML, "10");
      	console.log(cells[1]);
      });
    });
    // Function to create the cookie
    function createCookie(name, value, days) {
      var expires;
      if (days) {
          var date = new Date();
          date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
          expires = "; expires=" + date.toGMTString();
      }
      else {
          expires = "";
      }
      document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
    }
  </script>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
