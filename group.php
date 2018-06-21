<!--
current group page
-->
<?php
require 'SQLDB.class.php';
$groupDiv = 0;
$numPerDiv = 5;
if($_SERVER["REQUEST_METHOD"] == "GET") {
    if(isset($_GET["groupDiv"])){
        $productDiv = $_GET["groupDiv"]-1;
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
        <a href="product.php">Products</a>
        <a class="active" href="group.php">Groups</a>
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
    <?php
    // echo "offset = " . ($numPerDiv * $productDiv);
    $groupList = $link -> listGroup($numPerDiv,($numPerDiv*$groupDiv),(isset($_GET["pid"])?$_GET["pid"]:-1));
    $numOfGroup = $link -> countGroup();
    echo "<br> we have ". $numOfGroup . " Groups for groupen in total <br><br>";
    while($r = mysqli_fetch_assoc($groupList)) {
        echo "Group id:" . $r["gid"] . "  Product id:" . $r["product_pid"] . "  Started By:" . $r["starter_uid"];
        echo "Product groupen size";
        echo "  Price:" . "$<br>";
        // echo "1st discount: " . $r["first_discount"]*100 . "% ~~";
        // echo "<a href=\"product.php?makeNewGroup=".$r["pid"]."\">Groupen it!</a> ";
        // echo " member discount: " . $r["discount"]*100 . "% ~~";
        // echo "<a href=\"group.php?pid=".$r["pid"]."\">Find Group!</a> <br><br>";
    }
    ?>
    <br>
    <form action="product.php" method="get">
          <input type="number" name="productDiv" min="1" max="<?php echo (($numOfGroup-1)/$numPerDiv+1) ?>">
          <input type="submit" value="Go">
    </form>

</body>


</html>
