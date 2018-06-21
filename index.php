<!--
initial page for website
website has login/logout part at top, some stuff below that
-->
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
    </style>
</head>
<body>

    <!-- Top navigation bar -->
    <div class="topnav">
        <a class="active" href="index.php">Groupen</a>
        <a href="product.php">Products</a>
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
    <div style="width:100%;height:300px">
        <img src="Resources/IndexAd/ad2.jpg" width="100%" height="100%" class="center">
    </div> <br>
    <div style="width:100%;height:300px">
        <img src="Resources/IndexAd/ad3.jpg" width="100%" height="100%" class="center">
    </div> <br>
    <div style="width:100%;height:300px">
        <img src="Resources/IndexAd/ad4.jpg" width="100%" height="100%" class="center">
    </div> <br>
    <div style="width:100%;height:300px">
        <img src="Resources/IndexAd/ad5.jpg" width="100%" height="100%" class="center">
    </div> <br>

    <!-- Other things -->


</body>


</html>
