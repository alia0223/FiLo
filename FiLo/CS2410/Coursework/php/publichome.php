<?php
//start session
session_start();
//navigation button to take you to each page accessible from current page
if(isset($_POST['homebtn'])){
  header('location:/index.php');
}
elseif(isset($_POST['rgstbtn'])){
  header('location:/CS2410/Coursework/php/register.php');
}
elseif(isset($_POST['loginbtn'])){
  header('location:/CS2410/Coursework/php/login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/CS2410/Coursework/css/publichome.css"/>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="/CS2410/Coursework/js/sorttable.js"></script>
  <title>FiLo | Lost & Found</title>
</head>
<header>
  <!---           NAV BUTTONS           --->
    <div class="navbar navbar-header" style="height:50px;">
      <form action="publichome.php" method="POST">
        <ul>
          <li><input href="/index.php" type="submit" name="homebtn" value="Home" class="btn" /></li>
          <li><input href="/CS2410/Coursework/php/register.php" type="submit" name="rgstbtn" value="Register" class="btn" /></li>
          <li><input href="/CS2410/Coursework/php/login.php" type="submit" name="loginbtn"  value="Login" class="btn" /></li>
        </ul>
      </form>
      </div>
</header>
<body>
  <div class="container">
    <div class="modal" id="my-modal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title">Lost Item Details</h2>
          </div>
          <div class="modal-body">
            <table class="modal-table" id="modal-table">

            </table>

            </div>
          </div>
        </div>
      </div>
    </div>
    <main>
      <h1 class="sorthint text-center" style="margin-top:70px;">Feel free to click the table headers to sort the items as you see fit!</h1>
      <table class="main-table sortable" id="main-table">
        <tr>
          <th class="text-center">Category</th>
          <th class="text-center">Description</th>
          <th class="text-center">Place Found</th>
          <th class="text-center">Time Found</th>
          <th class="text-center hide">Colour</th>
          <th class="text-center hide">Photo</th>
          <th class="text-center hide">Finder</th>
          <th></th>
        </tr>
        <?php
        $conn = mysqli_connect('localhost','u-alia74','gNsbwReathEvN7X','u_alia74_db');
        if(!$conn){
          $error = "Error connecting to database...";
        }
        $sql = "SELECT Category,Description,Place_Found,Time_Found,Colour,Photo,Finder from lostitems";
        $result = $conn->query($sql);
        if($result-> num_rows>0){
          while($row = $result-> fetch_assoc()) {
            echo
            "<tr>
            <td>".$row["Category"]."</td><td>".$row["Description"]."</td><td>".$row["Place_Found"]."</td><td>".$row["Time_Found"]."</td>"."<td class=\"hide\">".$row["Colour"]."</td>"."<td class=\"hide\">";
            if($row['Photo']!='') {
              echo "<img src='"."/CS2410/Coursework/images/".$row["Photo"]."' width=\"100\"; height=\"100\";/>"."</td>";
            }
            echo "<td class=\"hide\">".$row["Finder"]."</td>".
            "<td>
            <a href=\"#\" data-toggle=\"modal\" data-target=\"#my-modal\" class=\"btn btn-primary\">
            Details
            </a>
            </td>
            </tr>";
          }
          echo "</table>";
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
              newTable += "<th class=\"text-center modal-det\">Colour</th>" +
              "<th class=\"text-center modal-det\">Photo</th>" +
              "<th class=\"text-center modal-det\">Finder</th>" +
              "<tr><td >" + cells[4].innerHTML + "</td><td>" + cells[5].innerHTML + "</td><td>" + cells[6].innerHTML + "</td></tr>";
            document.getElementById("modal-table").innerHTML = newTable;
          });
        });
        $('.hide').hide();

      </script>
      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
      <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
      <!-- Bootstrap JS -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
    </html>
