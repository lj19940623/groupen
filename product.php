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
if(isset($_GET["makeGroupWithPid"])){
  if(!isset($_SESSION["login_user"])){
       header('Location: login.php');
       return;
  }else{
      $_GET["makeGroupWithPid"];
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
    <?php include 'Resources/CSS/product.css';?>
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

    <!-- Index advertisement -->
    <div style="width:100%;height:300px">
        <img src="Resources/IndexAd/ad1.jpg" width="100%" height="100%" class="center">
    </div> <br>

    <!-- Other things -->
    <div class="productList">
    <?php
    // echo "offset = " . ($numPerDiv * $productDiv);
    $productList = $link -> listSomeProduct($numPerDiv,($numPerDiv*$productDiv));
    $numOfProduct = $link -> countProduct();
    echo "<br> we have ". $numOfProduct . " products for groupen now <br><br>";

    while($row = mysqli_fetch_assoc($productList)) {
        $detailLink = "<a href=\"productDetail.php?ProductID={$row["pid"]}\">";

        echo "<div class=\"icon\">";
        echo $detailLink." <img src= \"Resources/ProductImage/".$row["photo_url"]."\"></a><br>" ;
        // echo "pid:" . $r["pid"] . "  Name:" . $r["name"] . "  Brief:" . $r["description"] ."  Price:" . $r["price"] ."$<br>";
        // echo " Groupen Size:".$link->getProductGroupingSizeByPid($r["pid"]) . " with 1st discount: " . $r["first_discount"]*100 . "%~";
        // echo "<a href=\"account.php?makeGroupWithPid=".$r["pid"]."\">Groupen it!</a> ";
        // echo " member discount: " . $r["discount"]*100 . "%~";
        // echo "<a href=\"group.php?pid=".$r["pid"]."\">Find Group!</a> <br><br>";

        echo $detailLink.$row["name"]."</a><br>$".$row["price"];
        echo "</div>";
    }
    ?>

    <br>
    <form action="product.php" method="get">
          <input type="number" name="productDiv" value =  <?php echo isset($_GET["productDiv"])?$_GET["productDiv"]+1:2 ?>  min="1" max="<?php echo (($numOfProduct-1)/$numPerDiv+1) ?>">
          <input type="submit" value="Go">
    </form>
    </div>



</body>


</html>
