<?php
require 'SQLDB.class.php';
// if has form post and not login yet
if($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_SESSION['login_user'])) {
    $postUsername = $_POST['username'];
    $postPassword = $_POST['password'];
    $link = groupenDB::getInstance();
    $count = $link -> login($postUsername, $postPassword);
    if($count!=1){
        echo "<label> Wrong username or password. Please try again. </label>";
    }
}

if(isset($_SESSION['login_user']))  header('Location: index.php');
?>

<head>
    <title>Log in</title>
    <style><?php include 'Resources/CSS/general.css';?></style>
    <style type="text/css">
      form {
        margin: auto;
        width: 10em;
        height: auto;
      }
      </style>
</head>

<body style="background-color:#333;">
    <div style="width:500px; margin:200px auto 0 auto;">
      <form action = "login.php" method = "post" style="color:white">
        Username: <input type = "text" name = "username" required /><br>
        Password: <input type = "text" name = "password" required /><br>
        <input type = "submit" value = " Log in "/>
      </form>
    </div>

</body>
</html>
