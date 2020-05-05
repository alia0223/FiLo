<?php
//start session
session_start();
/*if the logout button is clicked destroy the session and take the user to the index page.
 * Destroying session prevents user from going back to restricted access page without authorization
*/
if(isset($_POST['logoutbtn'])){
  session_destroy();
  header('location:/index.php');
}
/*if admin clicks logout and closes the tab then goes back to the website, 
 * they should be taken to the index page, not to a page that requries authorization to access
*/
if($_SESSION['user_email']==true) {

}
else {
  header('location:/index.php');
}
//take admin to page that they clicked the button for
if(isset($_POST['databasebtn'])) {
  header('location:/CS2410/Coursework/php/adminhome.php');
}
elseif(isset($_POST['logoutbtn'])) {
  header('location:/index.php');
}
elseif(isset($_POST['submititembtn'])) {
  header('location:/CS2410/Coursework/php/requests.php');
}
//mysql database connection is established
$conn = mysqli_connect('localhost','u-alia74','gNsbwReathEvN7X','u_alia74_db');
if(!$conn){
  $error = "Error connecting to database...";
}
//allows admin to edit category of an item that a user has reported as lost
if(isset($_POST['cat-sub'])) {
  $itemid = $_COOKIE["id"];
  $category = mysqli_real_escape_string($conn,$_POST['category']);
  $sql = "UPDATE  lostitems SET Category='$category' WHERE item_id='$itemid'";
  mysqli_query($conn,$sql);
}
//allows admin to edit description of an item that a user has reported as lost
if(isset($_POST['desc-sub'])) {
  $itemid = $_COOKIE["id"];
  $description = mysqli_real_escape_string($conn,$_POST['desc']);
  $sql = "UPDATE  lostitems SET Description='$description' WHERE item_id='$itemid'";
  mysqli_query($conn,$sql);
}
//allows admin to edit location of an item that a user has reported as lost
if(isset($_POST['loc-sub'])) {
  $itemid = $_COOKIE["id"];
  $location = mysqli_real_escape_string($conn,$_POST['loc']);
  $sql = "UPDATE  lostitems SET Place_Found='$location' WHERE item_id='$itemid'";
  mysqli_query($conn,$sql);
}
//allows admin to edit found time of an item that a user has reported as lost
if(isset($_POST['time-sub'])) {
  $itemid = $_COOKIE["id"];
  $time = mysqli_real_escape_string($conn,$_POST['time']);
  $sql = "UPDATE  lostitems SET Time_Found='$time' WHERE item_id='$itemid'";
  mysqli_query($conn,$sql);
}
//allows admin to edit colour of an item that a user has reported as lost
if(isset($_POST['col-sub'])) {
  $itemid = $_COOKIE["id"];
  $colour = mysqli_real_escape_string($conn,$_POST['col']);
  $sql = "UPDATE  lostitems SET Colour='$colour' WHERE item_id='$itemid'";
  mysqli_query($conn,$sql);
}
//allows admin to edit details of the finder an item that a user has reported as lost
if(isset($_POST['finder-sub'])) {
  $itemid = $_COOKIE["id"];
  $finder = mysqli_real_escape_string($conn,$_POST['finder']);
  $sql = "UPDATE  lostitems SET Finder='$finder' WHERE item_id='$itemid'";
  mysqli_query($conn,$sql);
}
//close the database connection
$conn->close();
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
  <script src="/CS2410/Coursework/js/sorttable.js"></script>
  <title>FiLo | Lost & Found</title>
</head>
<header>
<!---------------------------------NAV BUTTONS-------------------------------->
    <div class="navbar navbar-header" style="height:50px;">
      <form action="adminhome.php" method="POST">
        <ul>
          <li><input href="/CS2410/Coursework/php/adminhome.php" type="submit" name="databasebtn" value="Database" class="btn" /></li>
          <li><input href="/CS2410/Coursework/php/login.php" type="submit" name="logoutbtn" value="Logout" class="btn" /></li>
          <li><input href="/CS2410/Coursework/php/requests.php" type="submit" name="submititembtn"  value="Requests" class="btn" /></li>
        </ul>
      </form>
      </div>
</header>
<body>
<!---------------------------------Pop-up Modal That Displays More Details of A Lost Item-------------------------------->
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
<!---------------------------------6 Pop-up Modals That Allows Admin to Edit Each Detail of A Lost Item-------------------------------->
    <div class="container">
      <div class="modal" id="cat-modal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h2 class="modal-title">Category</h2>
            </div>
            <div class="modal-body">
              <form action="adminhome.php" method="POST">
                <select id="category" name="category">
                  <option value="Jewellery">Jewellery</option>
                  <option value="Pet">Pet</option>
                  <option value="Phone">Phone</option>
                </select>
                <input type="submit" name="cat-sub"/>
              </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="modal" id="desc-modal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h2 class="modal-title">Description</h2>
              </div>
              <div class="modal-body">
                <form action="adminhome.php" method="POST">
                  <input type="text" name="desc" placeholder="Description of the lost item" required/>
                  <input type="submit" name="desc-sub"/>
                </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="container">
          <div class="modal" id="loc-modal">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h2 class="modal-title">Place Found</h2>
                </div>
                <div class="modal-body">
                  <form action="adminhome.php" method="POST">
                    <input type="text" name="loc" placeholder="Description of the location of the item found" required/>
                    <input type="submit" name="loc-sub"/>
                  </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="modal" id="time-modal">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h2 class="modal-title">Time Found</h2>
                  </div>
                  <div class="modal-body">
                    <form action="adminhome.php" method="POST">
                      <input type="date" name="time" required/>
                      <input type="submit" name="time-sub"/>
                    </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="container">
              <div class="modal" id="colour-modal">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h2 class="modal-title">Colour</h2>
                    </div>
                    <div class="modal-body">
                      <form action="adminhome.php" method="POST">
                        <input type="text" name="col" placeholder="Colour of the lost item" required/>
                        <input type="submit" name="col-sub"/>
                      </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="container">
                <div class="modal" id="finder-modal">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h2 class="modal-title">Finder</h2>
                      </div>
                      <div class="modal-body">
                        <form action="adminhome.php" method="POST">
                          <input type="text" name="finder" placeholder="Your full name and contact details" />
                          <input type="submit" name="finder-sub"/>
                        </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
<!---------------------------------Table Of Lost Items-------------------------------->
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
        $sql = "SELECT item_id,Category,Description,Place_Found,Time_Found,Colour,Photo,Finder from lostitems";
        $result = $conn->query($sql);
        if($result-> num_rows>0){
          while($row = $result-> fetch_assoc()) {
            echo
            "<tr>
            <td class=\"hide\">".$row["item_id"]."</td>
            <td>".$row["Category"]." <br /> <button data-toggle=\"modal\" data-target=\"#cat-modal\" class=\"btn btn-info\">Edit</button></td>
            <td>".$row["Description"]."<br /> <button data-toggle=\"modal\" data-target=\"#desc-modal\" class=\"btn btn-info\">Edit</button></td>
            <td>".$row["Place_Found"]."<br /> <button data-toggle=\"modal\" data-target=\"#loc-modal\" class=\"btn btn-info\">Edit</button></td>
            <td>".$row["Time_Found"]."<br /> <button data-toggle=\"modal\" data-target=\"#time-modal\" class=\"btn btn-info\">Edit</button></td>"."
            <td class=\"hide\">".$row["Colour"]."<br /> <button data-toggle=\"modal\" data-target=\"#colour-modal\" class=\"btn btn-info\">Edit</button></td>"."
            <td class=\"hide\">";
            if($row['Photo']!='') {
              echo "<img src='"."/CS2410/Coursework/images/".$row["Photo"]."' width=\"100\"; height=\"100\";/>"."</td>";
            }
            echo "<td class=\"hide\">".$row["Finder"]."<br /> <button data-toggle=\"modal\" data-target=\"#finder-modal\" class=\"btn btn-info\">Edit</button></td>".
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
          echo "</table><div class=\"container\"><p class=\"noreq text-center\">No Lost Items!</p></div>";
        }
        $conn->close();
        ?>
      </main>
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
              "<tr><td>" + cells[5].innerHTML + "</td><td>" + cells[6].innerHTML + "</td><td>" + cells[7].innerHTML + "</td></tr>";
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
