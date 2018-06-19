<html>

<head>
  <title>Logging out</title>
</head>

<body>
  
  <?php
    session_start();
    if(isset($_SESSION['login_user'])){
      if(session_destroy()) {
         echo "<label>Log out sucessfully!</label><br>";
         echo "<label>Returning to index page now.</label>";
         // just for now
         sleep(3);
         header("Location: index.php");
      }
    }else{
      echo "<label> You have not log in yet</label>";
    }
  ?>
</body>

</html>
