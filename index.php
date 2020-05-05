<?php
if(isset($_POST['login'])){
  header('location:/CS2410/Coursework/php/login.php');
}
elseif(isset($_POST['rgst'])){
  header('location:/CS2410/Coursework/php/register.php');
}
elseif(isset($_POST['vli'])){
  header('location:/CS2410/Coursework/php/publichome.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/CS2410/Coursework/css/index.css" />
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  <title>FiLo | Lost & Found</title>
</head>
<body>
  <main>
      <form action="index.php" method="POST">
        <input type="submit" name="login" value="Login"/>
        <input type="submit" name="rgst" value="Register"/>
        <input type="submit" name="vli" value="View Lost Items"/>
      </form>
      <h1 class="welcome">FiLo</h1>
      <h2 class="join-up-message">Whether You Have Lost an Item or Found One <br />FiLo is Your Best Friend!</h2>
  </main>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
