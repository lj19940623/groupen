<!--
circle page
-->
<?php
require 'SQLDB.class.php';
$link = groupenDB::getInstance();
if(!$link->checkInCircle($_GET["cid"], $_SESSION['login_user']))header("location: circle.php");
if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["cid"])&&isset($_POST["message"])){
            $link->sendMessageToCircle($_POST["cid"],$_POST["message"]);
    }
}
if($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!isset($_GET["cid"])) header("Location: circle.php");
}
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
        <a href="product.php">Products</a>
        <a href="group.php">Groups</a>
        <a class="active" href="circle.php">Circles</a>
        <form action="circle.php" method="get">
            <input type="text" placeholder="Search circles" name="searchName">
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

    <!-- Index advertisement -->
    <div style="width:100%;height:300px">
        <img src="Resources/IndexAd/ad1.jpg" width="100%" height="100%" class="center">
    </div> <br>

    <div class="productList">
    <p>
    <form action="circleNews.php?cid=<?php echo $_GET["cid"] ?>" method="post">
    <input type="hidden" name="cid" value="<?php echo $_GET["cid"] ?>" >
    <input type="text" name="message" value="" required>
    <input type="submit" value="send biu~">
    </form>
    </p>
    The Latest 20 Circle News:<br>
    <?php

    $msgs = $link->getLastestCircleMsg($_GET["cid"],20);
    while ($msg = mysqli_fetch_assoc($msgs)) {
        echo "@". $msg["msg_time"]. ", ";
        if($msg["sender_uid"]==$_SESSION["login_user"]) echo "You: ";
        else echo $msg["sender_uid"].": ";
        echo $msg["context"]."<br>";
    }
     ?>
     <p>
         <a href="circle.php?quit=<?php echo $_GET["cid"]?>">Quit Circle</a>
     </p>


</body>


</html>
