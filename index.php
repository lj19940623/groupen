<!--
initial page for website
website has login/logout part at top, some stuff below that
-->
<?php
require 'SQLDB.class.php';
?>

<html>
<head>
  <title>Groupen</title>
  <style>
  <?php include 'Resources/CSS/topnav.css'; ?>
  <?php include 'Resources/CSS/topnavRight.css';?>
  <?php include 'Resources/CSS/general.css';?>
  </style>
</head>
<body>

  <!-- Top navigation bar -->
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

<!-- Index advertisement -->
<div style="width:100%;height:300px">
  <img src="Resources/IndexAd/ad1.jpg" width="100%" height="100%" class="center">
</div>

<!-- Other things -->
<?php
echo $_SESSION['login_user'];
?>

</body>


</html>
