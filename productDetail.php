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
  <?php include 'Resources/CSS/product.css';?>
  </style>
</head>

<body>
  <!-- top navigation -->
  <div class="topnav">
      <a href="index.php">Groupen</a>
      <a class="active" href="product.php">Products</a>
      <a href="group.php">Groups</a>
      <a href="circle.php">Circles</a>
      <form action="product.php" method="get" style="margin:0">
          <input type="text" placeholder="Search products" name="search">
          <input type="submit" value="Search">
      </form>
      <div class="topnavRight">
          <?php
          if(isset($_SESSION['login_user'])){
              echo "<a href=\"logout.php\">Log out</a>
              <a href=\"account.php\">Welcome back, ".$_SESSION['login_user']."</a>
              <a href=\"message.php\">Message</a>
              <a href=\"account.php#myorder\">My orders</a>
              <a href=\"account.php#mygroup\">My groups</a>
              ";
          }else{
              echo "<a href=\"login.php\">Log in</a>
              <a href=\"signup.php\">Sign up</a>";
          }
          ?>
      </div>
  </div>

  <!-- product detail -->
  <?php
    $productID = $_GET["ProductID"];
    $link = groupenDB::getInstance();
    $product = $link->searchByPid($productID);
    if(isset($_GET["save"])){
        $link->addToSavedList($productID);
    }

    echo "<br><div>";
    echo "&nbsp&nbsp&nbsp&nbsp<a href=\"product.php\">Products</a>>><a href=\"http://localhost/groupen/productDetail.php?ProductID=".$product["pid"]."\">".$product["name"]."</a>";
    echo "</div><br><br><br><br>";
    echo "<div class=\"productDetail\">";
    echo "<div class=\"productDetailDisplay\">";
    // left part - photo
    echo "<div class=\"productDetailLeft\">";
    echo " <img src= \"Resources/ProductImage/".$product["photo_url"]."\">";
    echo "</div>";
    // right part - detail and buttons
    echo "<div class=\"productDetailRight\">";
    echo "<b>Name: </b>".$product["name"]."<br>";
    echo "<b>Post by: </b>".$product["user_uid"]."<br>";
    echo "<b>Price: </b>".$product["price"]."<br>";
    echo "<b>Category: </b>".$product["category"]."<br>";
    echo "<b>1st discout: </b>".$product["first_discount"]*100 ."%<br>";
    echo "<b>member discount: </b>".$product["discount"]*100 ."%<br>";
    echo "<b>Grouping size: </b>".$product["grouping_size"]."<br>";
    echo "<b>Start time: </b>".$product["start_time"]."<br>";
    echo "<b>End time: </b>".$product["end_time"]."<br>";
    echo "<b>tag: </b>".$product["tag"]."<br>";
    echo "<b>Description: </b>".$product["description"]."<br>";
    echo "<a href=\"account.php?makeGroupWithPid=".$product["pid"]."\">Groupen it!</a><br> ";
    echo "or <a href=\"group.php?pid=".$product["pid"]."\">Find Group!</a> <br>";
    echo "or <a href=\"productDetail.php?ProductID=".$product["pid"]."&save=1\">Save</a> <br><br>";
    echo "</div>";

    echo "</div>";
    echo "</div>";
   ?>

</body>

</html>
