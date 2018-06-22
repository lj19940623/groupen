<!--
current group page
-->
<?php
require 'SQLDB.class.php';
$groupDiv = 0;
$numPerDiv = 5;
if($_SERVER["REQUEST_METHOD"] == "GET") {
    if(isset($_GET["groupDiv"])){
        $groupDiv = $_GET["groupDiv"]-1;
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
    $numOfGroup = $link -> countGroup(isset($_GET["pid"])?$_GET["pid"]:-1);
    echo "<br> Groupen has ". $numOfGroup . " groups ".((!isset($_GET["pid"])||$_GET["pid"]==-1)?"in total":("for product with pid ".$_GET["pid"]))." <br><br>";
    while($r = mysqli_fetch_assoc($groupList)) {
        echo "Group id:" . $r["gid"] . "  Product id:" . $r["product_pid"] . "  Started by:" . $r["starter_uid"]. " ";
        $groupenSize = $link->getProductGroupingSizeByPid($r["product_pid"]);
        echo "Required groupen size:".$groupenSize . " Await:" .($groupenSize-$link->getGroupCurrentSizeByGid($r["gid"]));
        echo "<a href=\"account.php?joinGroupWithGid=".$r["gid"]."\">Join!</a> <br>";
    }
    ?>
    <br>
    <form action="group.php" method="get">
        <input type="hidden" name="pid" value="<?php echo isset($_GET['pid']) ? $_GET['pid'] : '-1' ?>">
        <input type="number" name="groupDiv" value = <?php echo isset($_GET["groupDiv"])?$_GET["groupDiv"]+1:2 ?> min="1" max="<?php echo (($numOfGroup-1)/$numPerDiv+1) ?>">
        <input type="submit" value="Go">
    </form>

</body>


</html>
