<?php
require 'SQLDB.class.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
  $postUsername = $_POST['username'];
  $postPassword = $_POST['password'];
  $postEmail = $_POST['email'];
  $link = groupenDB::getInstance();
  $result = $link -> register($postUsername, $postPassword, $postEmail);

  if(isset($_SESSION["login_user"])){
    header("Location: index.php");
  }else{
    echo "<label>.$result</label>";
  }
}
?>

<html>
   <head>
      <title>Register page</title>
   </head>
   <body>
       <form action = "register.php" method = "post">
                <label>UserName  :</label><input type = "text" name = "username" />
                <label>Password  :</label><input type = "password" name = "password" >
                <label>Email  :</label><input type = "email" name = "email" >
                <input type = "submit" value = " Submit "/>
        </form>
   </body>

</html>
