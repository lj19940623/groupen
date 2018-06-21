<!--
current product page
-->
<?php
require 'SQLDB.class.php';

$productDiv = 1;
$numPerDiv = 5;
if($_SERVER["REQUEST_METHOD"] == "GET") {
    if(isset($_GET["productDiv"])){
        $productDiv = $_GET["productDiv"]-1;
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
    echo "offset = " . ($numPerDiv * $productDiv);
    $productList = $link -> listSome($numPerDiv,($numPerDiv*$productDiv));
    $rows = mysqli_fetch_array($productList,MYSQLI_ASSOC);
    $count = $link->countProduct();
    echo "<br> we have ". $count. " products for groupen now <br>";
    echo count($rows)."<br>";
    echo implode(" | ", $rows)."<br>";
    foreach ($rows as $row) {
        // echo $r["pid"] . "  " . $r["name"] . "  " . $r["description"] . "  " . $r["price"] . "  " . $r["pid"] . "<br>";
    }
    ?>
    <br>
    <form action="product.php" method="get">
          <input type="number" name="productDiv" min="1" max="99">
          <input type="submit" value="Go">
    </form>

</body>


</html>
