<!--
current product page
-->
<?php
require 'SQLDB.class.php';

$productDiv = 0;
$numPerDiv = 5;
if($_SERVER["REQUEST_METHOD"] == "GET") {
    if(isset($_GET["productDiv"])){
        $productDiv = $_GET["productDiv"]-1;
    }
}
if(isset($_GET["makeNewGroup"])){
  if(!isset($_SESSION["login_user"])){
       header('Location: login.php');
       return;
  }else{
      $_GET["makeNewGroup"];
  }
}

$link = groupenDB::getInstance();
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
        <a href="index.php">Groupen</a>
        <a class="active" href="product.php">Products</a>
        <a href="group.php">Groups</a>
        <a href="circle.php">Circles</a>
        <div class="topnavRight">
            <?php
            if(isset($_SESSION['login_user'])){
                echo "<a href=\"logout.php\">Log out</a>
                <a >Welcome back, ".$_SESSION['login_user']."</a>
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

    <!-- Index advertisement -->
    <div style="width:100%;height:300px">
        <img src="Resources/IndexAd/ad1.jpg" width="100%" height="100%" class="center">
    </div> <br>

    <!-- Other things -->
    <?php
    // echo "offset = " . ($numPerDiv * $productDiv);
    $productList = $link -> listSome($numPerDiv,($numPerDiv*$productDiv));
    $numOfProduct = $link -> countProduct();
    echo "<br> we have ". $numOfProduct . " products for groupen now <br><br>";
    while($r = mysqli_fetch_assoc($productList)) {
        echo " <img src='" . $r["photo_url"] . "' width='30%' height='30%' > <br>";
        echo "pid:" . $r["pid"] . "  Name:" . $r["name"] . "  Brief:" . $r["description"] . "  Price:" . $r["price"] ."$<br>";
        echo "1st discount: " . $r["first_discount"]*100 . "% ~~";
        echo "<a href=\"product.php?makeNewGroup=".$r["pid"]."\">Groupen it!</a> ";
        echo " member discount: " . $r["discount"]*100 . "% ~~";
        echo "<a href=\"group.php?pid=".$r["pid"]."\">Find Group!</a> <br><br>";
    }
    ?>
    <br>
    <form action="product.php" method="get">
          <input type="number" name="productDiv" min="1" max="<?php echo (($numOfProduct-1)/$numPerDiv+1) ?>">
          <input type="submit" value="Go">
    </form>

</body>


</html>
