<!--
current product page
-->
<?php
require 'SQLDB.class.php';
if(!isset($_SESSION["login_user"])) header("Location: login.php");

$link = groupenDB::getInstance();
// if($_SERVER["REQUEST_METHOD"] == "POST") {
//
// }
if($_SERVER["REQUEST_METHOD"] == "GET") {
    if(isset($_GET["requesTo"])) {
        $link->sendRequestTo($_GET["requesTo"]);
    }
    if(isset($_GET["accept"])) {
        $link->acceptRequest($_GET["accept"]);
    }
    if(isset($_GET["refuse"])) {
        $link->refuseRequset($_GET["refuse"]);
    }
    if(isset($_GET["delete"])) {
        $link->deleteFriend($_GET["delete"]);
    }
}
?>

<html>
<head>
    <title>List product page</title>
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
        <div class="topnavRight">
            <?php
            if(isset($_SESSION['login_user'])){
                echo "<a href=\"logout.php\">Log out</a>
                <a href=\"account.php\">Welcome back, ".$_SESSION['login_user']."</a>
                <a class=\"active\" href=\"message.php\">Message</a>
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


<p>
Your friend list:<br>
<?php
$friendList = $link->getFriendList();
while ($row =  mysqli_fetch_assoc($friendList)) {
echo "User " . $row["friend_uid"] . " ";
echo "<a href=\"sendMessage.php?to=".$row["friend_uid"]."\">Send message</a> ";
echo "<a href=\"message.php?delete=".$row["friend_uid"]."\">Delete</a> <br>";
}
echo "------------------------";
?>
</p>

<p>
Your got friend request from:<br>
<?php
$requestList = $link->getRequsetList();
while ($row =  mysqli_fetch_assoc($requestList)) {
    echo "User " . $row["request_uid"] . " want to be your friend";
    echo "<a href=\"message.php?accept=".$row["request_uid"]."\">Accept</a> ";
    echo "<a href=\"message.php?refuse=".$row["request_uid"]."\">Refuse</a> <br>";
}
echo "------------------------";
 ?>
</p>
<p>
<form action="message.php" method="get">
Send friend request to:
<input type="text" name="requesTo" value="" required>
<input type="submit" value="biubiubiu">
</form>
</p>

</body>


</html>
