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
?>

<head>
  <title>Log in</title>
</head>

<body>
  <?php
  if(isset($_SESSION['login_user'])) {
    sleep(5);
    echo "<label>You have log in, returning to the index.</label>";
    //header("Location: index.php");
  } else {
    echo '<div> <form action = "login.php" method = "post">
    <label>UserName:  </label> <input type = "text" name = "username" required /><br>
    <label>Password:  </label> <input type = "password" name = "password" required /><br>
    <input type = "submit" value = " Log in "/>';
  }
  ?>

</body>
</html>
