<!--
current product page
-->
<?php
require 'SQLDB.class.php';
if(!isset($_SESSION["login_user"])) header("Location: login.php");


$startedGroupDiv = 0;
$joinedGroupDiv = 0;
$numPerDiv1 = 5;
$numPerDiv2 = 3;
if($_SERVER["REQUEST_METHOD"] == "GET") {
    if(isset($_GET["startedGroupDiv"])){
        $startedGroupDiv = $_GET["startedGroupDiv"]-1;
    }
    if(isset($_GET["joinedGroupDiv"])){
        $joinedGroupDiv = $_GET["joinedGroupDiv"]-1;
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
    </style>
</head>
<body>

    <!-- Top navigation bar -->
    <div class="topnav">
        <a href="index.php">Groupen</a>
        <a href="product.php">Products</a>
        <a href="group.php">Groups</a>
        <a href="circle.php">Circles</a>
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
    <a id='myorder'>
    </a>
    <p>
        1 <br>
        1 <br>
        1 <br>
        1 <br>
        1 <br>
        9 <br><?php // TODO:  ?>
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
            <input type="number" name="startedGroupDiv" value = <?php echo isset($_GET["startedGroupDiv"])?$_GET["startedGroupDiv"]+1:2 ?> min="1" max="<?php echo (($startedGroupListSize-1)/$numPerDiv1+1) ?>">
            <input type="hidden" name="joinedGroupDiv" value="<?php echo isset($_GET['joinedGroupDiv']) ? $_GET['joinedGroupDiv'] : '1' ?>">
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
        echo "next to do";
        ?>
        <form action="account.php" method="get">
            <input type="hidden" name="startedGroupDiv" value="<?php echo isset($_GET['startedGroupDiv']) ? $_GET['startedGroupDiv'] : '1' ?>">
            <input type="number" name="joinedGroupDiv" value = <?php echo isset($_GET["joinedGroupDiv"])?$_GET["joinedGroupDiv"]+1:2 ?> min="1" max="<?php echo (($joinedGroupListSize-1)/$numPerDiv2+1) ?>">
            <input type="submit" value="Go">
        </form>
    </p>

    <!-- Index advertisement -->
    <div style="width:100%;height:300px">
        <img src="Resources/IndexAd/ad1.jpg" alt="ad1" width="100%" height="100%" class="center">
    </div>
</body>


</html>
