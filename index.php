<!--
initial page for website
website has login/logout part at top, some stuff below that
-->
<?php
require 'SQLDB.class.php';
// if has form post and not login yet
if($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_SESSION['login_user'])) {
  $postUsername = $_POST['username'];
  $postPassword = $_POST['password'];
  $link = groupenDB::getInstance();
  $count = $link -> login($postUsername, $postPassword);
}
?>

<html>
<head>
  <title>Groupen</title>
  <style>
  <?php include 'Resources/CSS/topnav.css'; ?>
  <?php include 'Resources/CSS/topnavRight.css';?>
  </style>
</head>
<body>
  <div class="topnav">
  <a class="active" href="index.php">Groupen</a>
  <a href="listProduct.php">Products</a>
  <a href="order.php">My orders</a>
  <a href="group.php">My group</a>
  <a href="logout.php">logout</a>
  <!-- 这一段写的感觉不是蛮好的其实 要改改 -->
  <div class="topnavRight">
    <?php
      if(isset($_SESSION['login_user'])){
        echo "<a href=\"#\">Welcome back, ".$_SESSION['login_user']."</a>";
      }else{
        echo "<a href=\"login.php\">Log in</a>
              <a href=\"signup.php\">Sign up</a>";
      }
      ?>
  </div>
  </div>
  <?php
  if(isset($_SESSION['login_user'])) {
    echo "<div> Nice, you loged in: ". $_SESSION['login_user'] . ". ";
  } else {
    echo '<div> <form action = "index.php" method = "post">
    <label>UserName:  </label> <input type = "text" name = "username" required />
    <label>Password:  </label> <input type = "password" name = "password" required />
    <input type = "submit" value = " Submit "/>';
    echo '<label> Invalid username or password.</label>';
    echo '<a href = "register.php">Register</a>';
    echo '</form> </div>';
  }
  ?>
</body>
<body>

</body>

</html>
