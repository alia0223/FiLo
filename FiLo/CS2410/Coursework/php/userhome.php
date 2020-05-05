<?php
//start session
session_start();
//destroy session so restricted area(s) can no longer be accessed without logging in again
if(isset($_POST['logoutbtn'])){
  session_destroy();
  header('location:/index.php');
}
if($_SESSION['user_email']==true) {

}
else {
  header('location:/index.php');
}
//navigation buttons that allow you to access the current 
if(isset($_POST['databasebtn'])) {
  header('location:/CS2410/Coursework/php/userhome.php');
}
elseif(isset($_POST['logoutbtn'])) {
  header('location:/index.php');
}
elseif(isset($_POST['submititembtn'])) {
  header('location:/CS2410/Coursework/php/submititem.php');
}
//establish a sql connection
$conn = mysqli_connect('localhost','u-alia74','gNsbwReathEvN7X','u_alia74_db');
if(!$conn){
  $error = "Error connecting to database...";
}
//user requests item
if(isset($_POST['submitreq'])) {
  $itemid = $_COOKIE["id"];
  $useremail = $_SESSION['user_email'];
  $reason = mysqli_real_escape_string($conn,$_POST['reason']);
  $sql = "INSERT INTO Requests (User,Item_id,Reason) VALUES ('$useremail','$itemid','$reason')";
  mysqli_query($conn,$sql);
  echo "<div class=\"alert alert-success text-center\" style=\"margin:0 auto; position:absolute; bottom:0px; width:100%;\"><a href=\"/CS2410/Coursework/php/login.php\">Request Sent Successfully!</a></div>";
}
//close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/CS2410/Coursework/css/userhome.css"/>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="/CS2410/Coursework/js/sorttable.js"></script>
  <title>FiLo | Lost & Found</title>
</head>
<header>
  <!------------------------------NAV BUTTONS---------------------------------------------------->
    <div class="navbar navbar-header" style="height:50px;">
      <form action="userhome.php" method="POST">
        <ul>
          <li><input href="/CS2410/Coursework/php/userhome.php" type="submit" name="databasebtn" value="Lost Items" class="btn" /></li>
          <li><input href="/index.php" type="submit" name="logoutbtn" value="Logout" class="btn" /></li>
          <li><input href="/CS2410/Coursework/php/subititem.php" type="submit" name="submititembtn"  value="Report Item" class="btn" /></li>
        </ul>
      </form>
      </div>
</header>
<body>
<!--------------------------Table Containing Reported Lost Items---------------------------->
  <div class="container">
    <div class="modal" id="my-modal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title text-center">Lost Item Details</h2>
          </div>
          <div class="modal-body">
            <table class="modal-table" id="modal-table">

            </table>

            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="modal" id="request-modal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h2 class="modal-title">Reason For Request</h2>
            </div>
            <div class="modal-body" id="reason-body">
              <form action="userhome.php" method="POST">
                  <textarea id="reason" name="reason" rows="7" cols="100"> </textarea>
                  <input type="submit" name="submitreq" class="btn btn-primary"/>
              </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    <main>
      <h1 class="sorthint text-center" style="margin-top:80px; width:100%;">Feel free to click the table headers to sort the items as you see fit!</h1>
      <form action="userhome.php" method="POST">
      <table class="main-table sortable" id="main-table">
        <tr>
          <th class="text-center hide">Item ID</th>
          <th class="text-center">Category</th>
          <th class="text-center">Description</th>
          <th class="text-center">Place Found</th>
          <th class="text-center">Time Found</th>
          <th class="text-center hide">Colour</th>
          <th class="text-center hide">Photo</th>
          <th class="text-center hide">Finder</th>
          <th></th>
          <th></th>
        </tr>
        <?php
        $conn = mysqli_connect('localhost','u-alia74','gNsbwReathEvN7X','u_alia74_db');
        if(!$conn){
          $error = "Error connecting to database...";
        }
        $sql = "SELECT item_id,Category,Description,Place_Found,Time_Found,Colour,Photo,Finder FROM lostitems";
        $result = $conn->query($sql);
        if($result-> num_rows>0){
          while($row = $result-> fetch_assoc()) {
            echo
            "<tr>
            <td class=\"hide\">".$row["item_id"]."</td><td>".$row["Category"]."</td><td>".$row["Description"]."</td><td>".$row["Place_Found"]."</td><td>".$row["Time_Found"]."</td>"."<td class=\"hide\">".$row["Colour"]."</td>"."<td class=\"hide\">";
            if($row['Photo']!='') {
              echo "<img src='"."/CS2410/Coursework/images/".$row["Photo"]."' width=\"100\"; height=\"100\";/>"."</td>";
            }
              echo "<td class=\"hide\">".$row["Finder"]."</td>".
            "<td>
              <a href=\"#\" data-toggle=\"modal\" data-target=\"#my-modal\" name=\"details\" class=\"btn btn-primary\">
                Details
              </a>
            </td>
            <td>
              <a href=\"#\" data-toggle=\"modal\" data-target=\"#request-modal\" name=\"request\" value=\"Request\" class=\"btn btn-danger request\">Request</a>
            </td>
            </tr>";
          }
          echo "</table></form>";
        }
        else {
          echo "</table><h1 class=\"noreq text-center\">No Lost Items!</h1>";
        }
        $conn->close();
        ?>
      </main>
<!---Main table has some fields hidden as theya re not required just yet. 
When user clicks details button these fields are viewable 
in a pop-up modal by being appended to that the table in the pop-up modal--->
      <script>
        $(document).ready(function() {
          $('td').click(function(){
            var row_index = $(this).parent().index();
            var newTable = "";
            var rows = document.getElementById("main-table").rows;
              var cells = rows[row_index+1].cells;
              newTable += "<th class=\"text-center modal-det hide\">Item ID</th>" +
              "<th class=\"text-center modal-det\">Colour</th>" +
              "<th class=\"text-center modal-det\">Photo</th>" +
              "<th class=\"text-center modal-det\">Finder</th>" +
              "<tr><td class=\"hide\">" + cells[0].innerHTML + "</td><td>" + cells[5].innerHTML + "</td><td>" + cells[6].innerHTML + "</td><td>" + cells[7].innerHTML + "</td></tr>";
            document.getElementById("modal-table").innerHTML = newTable;
          });
        });
        $('.hide').hide();
      </script>
      <script>
        // Creating a cookie after the document is ready
        // stores the id of the lost item that is in the row which contains the details button that was clicked on for use in php.
        $(document).ready(function () {
          var row_index="";
          var newTable="";
          var rows="";
          var cells="";
          $('td').click(function(){
            row_index = $(this).parent().index();
            newTable = "";
            rows = document.getElementById("main-table").rows;
            cells = rows[row_index+1].cells;
            createCookie("id", cells[0].innerHTML, "10");
          console.log(cells[0].innerHTML);
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
