<!--
current product page
-->
<?php
require 'SQLDB.class.php';
if(!isset($_SESSION["login_user"])) header("Location: login.php");

$orderDiv = 0;
$startedGroupDiv = 0;
$joinedGroupDiv = 0;
$numPerDiv0 = 4;
$numPerDiv1 = 3;
$numPerDiv2 = 3;
if($_SERVER["REQUEST_METHOD"] == "GET") {
    if(isset($_GET["startedGroupDiv"])){
        $startedGroupDiv = $_GET["startedGroupDiv"]-1;
    }
    if(isset($_GET["joinedGroupDiv"])){
        $joinedGroupDiv = $_GET["joinedGroupDiv"]-1;
    }
    if(isset($_GET["orderDiv"])){
        $orderDiv = $_GET["orderDiv"]-1;
    }
}

$link = groupenDB::getInstance();

if(isset($_GET["makeGroupWithPid"])){
    if($link->validateProductByPid($_GET["makeGroupWithPid"])){
        $link->makeNewGroup($_SESSION["login_user"],$_GET["makeGroupWithPid"]);
        header("Location: account.php#mygroup");
    }else{
        header("Location: productNotAvailable.php");
    }
}
if(isset($_GET["joinGroupWithGid"])){
    if( $link->getRestSpaceInGroup($_GET["joinGroupWithGid"]) <= 0){
        header("Location: groupAlreadyFull.php");
    }else{
        if($link->checkIfIsGroupStarter($_SESSION["login_user"],$_GET["joinGroupWithGid"])) {
            header("Location: youCanNotJoinYourOwnGroup.php");
        }else if(!$link->joinGroup($_SESSION["login_user"],$_GET["joinGroupWithGid"])){
            header("Location: youCanNotJoinSameGroupAsMemberTwice.php");
        }else{
            header("Location: successfullyJoinPage.php");
            // header("Location: account.php#mygroup");
        }
    }
}
if(isset($_GET["quitGroupWithGid"])){
    if($link->checkIfIsGroupStarter($_SESSION["login_user"],$_GET["quitGroupWithGid"])){
        // header("Location: quitYourOwnGroup.php");
        $link->quitGroupAsStarter($_SESSION["login_user"],$_GET["quitGroupWithGid"]);
        header("Location: account.php#mygroup");
    }else if($link->checkIfIsGroupMember($_SESSION["login_user"],$_GET["quitGroupWithGid"])){
        // header("Location: quitGroupAsMember.php");
        $link->quitGroupAsMember($_SESSION["login_user"],$_GET["quitGroupWithGid"]);
        header("Location: account.php#mygroup");
    }else{
        header("Location: notInGroup.php");
    }
}

?>

<html>
<head>
    <title>Product</title>
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
        <a href="product.php">Products</a>
        <a href="group.php">Groups</a>
        <a href="circle.php">Circles</a>
        <input type="text" placeholder="Search products" name="search">
        <input type="submit" value="Search">
        <div class="topnavRight">
            <?php
            if(isset($_SESSION['login_user'])){
                echo "<a href=\"logout.php\">Log out</a>
                <a  class=\"active\">Welcome back, ".$_SESSION['login_user']."</a>
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
        <img src="Resources/IndexAd/ad1.jpg" alt="ad1" width="100%" height="100%" class="center">
    </div>
    <div class="productList">
    <a id='myorder'>
    </a>
    <p>
        <?php
        echo "<br>Your orders: ";
        $orderSize = $link->countUserOrder($_SESSION["login_user"]);
        echo "total " . $orderSize ."<br>";
        $orderList = $link -> getOrderListByUid($numPerDiv0, ($numPerDiv0*$orderDiv), $_SESSION["login_user"]);
        while ($r = mysqli_fetch_assoc($orderList)) {
            echo "Order id:" . $r["oid"] . "  Product id:" . $r["product_pid"] . "  Your discount: " . ($r["discount"]*100). "% off Status: ".$r["status"];
            echo "<br>";
        }
        ?>
        <form action="account.php" method="get">
            <input type="number" name="orderDiv" value = <?php echo isset($_GET["orderDiv"])?$_GET["orderDiv"]+1:2 ?> min="1" max="<?php echo (($orderSize-1)/$numPerDiv0+1) ?>">
            <input type="hidden" name="startedGroupDiv" value = <?php echo isset($_GET['startedGroupDiv']) ? $_GET['startedGroupDiv'] : '1' ?> >
            <input type="hidden" name="joinedGroupDiv" value = <?php echo isset($_GET['joinedGroupDiv']) ? $_GET['joinedGroupDiv'] : '1' ?> >
            <input type="submit" value="Go">
        </form>
    </p>

    <a id='mygroup'>
    </a>
    <p>

        <?php
        echo "<br>You have started following groups: ";
        $startedGroupListSize = $link->countGroupStartBy($_SESSION["login_user"]);
        echo "total " . $startedGroupListSize ."<br>";
        $startedGroupList = $link -> getGroupListStartBy($numPerDiv1, ($numPerDiv1*$startedGroupDiv), $_SESSION["login_user"]);
        while ($r = mysqli_fetch_assoc($startedGroupList)) {
            echo "Group id:" . $r["gid"] . "  Product id:" . $r["product_pid"] . "  Started by:" . $r["starter_uid"]. " ";
            $groupenSize = $link->getProductGroupingSizeByPid($r["product_pid"]);
            echo "Required groupen size ".$groupenSize . " await " .($groupenSize-$link->getGroupCurrentSizeByGid($r["gid"]));
            echo "<a href=\"account.php?quitGroupWithGid=".$r["gid"] ."\">QuitYourSuperDiscount</a><br> ";
            echo "<br>";
        }
        ?>
        <form action="account.php" method="get">
            <input type="hidden" name="orderDiv" value = <?php echo isset($_GET["orderDiv"])?$_GET["orderDiv"]:'1' ?>  >
            <input type="number" name="startedGroupDiv" value = <?php echo isset($_GET["startedGroupDiv"])?$_GET["startedGroupDiv"]+1:2 ?> min="1" max="<?php echo (($startedGroupListSize-1)/$numPerDiv1+1) ?>">
            <input type="hidden" name="joinedGroupDiv" value = <?php echo isset($_GET['joinedGroupDiv']) ? $_GET['joinedGroupDiv'] : '1' ?> >
            <input type="submit" value="Go">
        </form>
        <?php
        echo "<br>You have joined following groups: ";
        $joinedGroupListSize = $link->countGroupJoinedBy($_SESSION["login_user"]);
        echo "total " . $joinedGroupListSize ."<br>";
        $joinedGroupList = $link -> getGroupListJoinedBy($numPerDiv2, ($numPerDiv2*$joinedGroupDiv), $_SESSION["login_user"]);
        while ($r = mysqli_fetch_assoc($joinedGroupList)) {
            echo "Group id:" . $r["groups_gid"];
            echo "<a href=\"account.php?quitGroupWithGid=".$r["groups_gid"] ."\">QuitGroup</a><br> ";
            echo "<br>";
        }
        ?>
        <form action="account.php" method="get">
            <input type="hidden" name="orderDiv" value = <?php echo isset($_GET["orderDiv"])?$_GET["orderDiv"]:1 ?> >
            <input type="hidden" name="startedGroupDiv" value="<?php echo isset($_GET['startedGroupDiv']) ? $_GET['startedGroupDiv'] : '1' ?>">
            <input type="number" name="joinedGroupDiv" value = <?php echo isset($_GET["joinedGroupDiv"])?$_GET["joinedGroupDiv"]+1:2 ?> min="1" max="<?php echo (($joinedGroupListSize-1)/$numPerDiv2+1) ?>">
            <input type="submit" value="Go">
        </form>
    </p>

    <a id='myorder'>
    </a>
    <p>
        <?php
        echo "<br>You have list following products: <br>";
        $productList = $link -> getProductListByUid($_SESSION["login_user"]);
        while ($r = mysqli_fetch_assoc($productList)) {
            echo "Product id:" . $r["pid"] . "  Product name:" . $r["name"] . "  ";
            echo "<a href=\"productDetail.php?ProductID={$r["pid"]}\"> detail <a>";

            // echo "<a href=\"account.php?quitGroupWithGid=".$r["gid"] ."\">QuitYourSuperDiscount</a><br> ";
            echo "<br>";
        }
        ?>
    </p>
    <p> <a href="listProduct.php"> List Product as seller Click here.</a> </p>
  </div>
    <!-- Index advertisement -->
    <div style="width:100%;height:300px">
        <img src="Resources/IndexAd/ad2.jpg" alt="ad2" width="100%" height="100%" class="center">
    </div>
</body>


</html>
