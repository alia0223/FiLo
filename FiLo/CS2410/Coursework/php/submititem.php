<?php
//start session
session_start();
//destroy session if you log out
if(isset($_POST['logoutbtn'])){
  session_destroy();
  header('location:/index.php');
}
//if there is an email in the current session do nothing 
//otherwise take user to index page as they are not logged in so cannot access restricted areas
if($_SESSION['user_email']==true) {

}
else {
  header('location:/index.php');
}
//navigate to page that belongs to button clicked
if(isset($_POST['databasebtn'])) {
  header('location:/CS2410/Coursework/php/userhome.php');
}
elseif(isset($_POST['logoutbtn'])) {
  header('location:/index.php');
}
elseif(isset($_POST['submititembtn'])) {
  header('location:/CS2410/Coursework/php/submititem.php');
}
//establish sql connection
$conn = mysqli_connect('localhost','u-alia74','gNsbwReathEvN7X','u_alia74_db');
if(!$conn){
  $error = "Error connecting to database...";
}
//user reporting a lost item
if(isset($_POST['submit'])) {
  $category = mysqli_real_escape_string($conn,$_POST['category']);
  $description = mysqli_real_escape_string($conn,$_POST['desc']);
  $location = mysqli_real_escape_string($conn,$_POST['loc']);
  $time = mysqli_real_escape_string($conn,$_POST['time']);
  $colour = mysqli_real_escape_string($conn,$_POST['col']);
  $image = mysqli_real_escape_string($conn,$_FILES['photo']['name']);
  $finder = mysqli_real_escape_string($conn,$_POST['finder']);
  $target_dir = "/home/u-alia74/public_html/CS2410/Coursework/images/";
  $target_file = $target_dir.basename($_FILES['photo']['name']);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  // Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "<div class=\"imgerror alert alert-danger text-center\" style=\"width:100%; margin:0 auto; position:absolute; bottom:0px;\">Sorry, only JPG, JPEG, PNG & GIF files are allowed.</div>";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {

} else {
    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO lostitems (Category,Description,Place_Found,Time_Found,Colour,Photo,Finder) VALUES ('$category','$description','$location','$time','$colour','$image','$finder')";
        mysqli_query($conn,$sql);
    	echo "<div class=\"alert alert-success text-center\" style=\"margin:0 auto; position:absolute; bottom:0px; width:100%;\">Lost Item Submitted!</div>";
    } elseif(($uploadOk != 0) && !(move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file))) {
          echo "<div class=\"alert alert-danger text-center\" style=\"margin:0 auto; position:absolute; bottom:0px; width:100%;\">Sorry, there was an error uploading your file. Only images allowed!</div>";
    }
}
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/CS2410/Coursework/css/submititem.css"/>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <title>FiLo | Lost & Found</title>
</head>
<header>
  <!---           NAV BUTTONS           --->
    <div class="navbar navbar-header" style="height:50px;">
      <form action="submititem.php" method="POST" style="height:50px;">
        <ul>
          <li><input href="/CS2410/Coursework/php/userhome.php" type="submit" name="databasebtn" value="Lost Items" class="btn" /></li>
          <li><input href="/index.php" type="submit" name="logoutbtn" value="Logout" class="btn" /></li>
          <li><input href="/CS2410/Coursework/php/submititem.php" type="submit" name="submititembtn"  value="Report Item" class="btn" /></li>
        </ul>
      </form>
      </div>
</header>
<body>
    <main>
      <form id="submit-item" action="submititem.php" method="post" enctype="multipart/form-data">
      	<label for="category" style="display:block; text-align: center;">Choose a Category: </label>
        <select id="category" name="category" style="display:block; margin:0 auto;">
 	       <option value="Jewellery">Jewellery</option>
           <option value="Pet">Pet</option>
           <option value="Phone">Phone</option>
        </select>
        <label for="desc" style="display:block; text-align: center;">Description: </label>
        <input type="textarea" name="desc" placeholder="Description of the lost item" style="display:block; margin:0 auto;" required/>
        <label for="loc" style="display:block; text-align: center;"> Location Found: </label>
        <input type="textarea" name="loc" placeholder="Description of the location of the item found" required style="display:block; margin:0 auto;"/>
        <label for="time" style="display:block; text-align: center;">Date Found: </label>
        <input type="date" name="time" style="display:block; margin:0 auto; text-align: center;" required/>
        <label for="col" style="display:block; text-align: center;"> Colour: </label>
        <input type="textarea" name="col" placeholder="Colour of the lost item" required style="display:block; margin:0 auto;"/>
        <label for="photo" style="display:block; text-align: center;">Photo of Lost Item: &nbsp</label>
        <input type="file" name="photo" accept="image/*" style="display:block; margin:0 auto; margin-right:172px;" required/>
        <label for="finder" style="display:block; text-align: center;"> Name and contact details: </label>
        <input type="textarea" name="finder" placeholder="Your full name and contact details" style="display:block; margin:0 auto;"/>
        <input type="submit" name="submit" class="btn" required style="display:block; margin:0 auto; margin-top: 10px; margin-bottom: 10px;"/>
      </form>
    </main>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
