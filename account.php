<!--
current product page
-->
<?php
require 'SQLDB.class.php';
if(!isset($_SESSION["login_user"])) header("Location: login.php");

$link = groupenDB::getInstance();
if(isset($_GET["makeGroupWithPid"])){
    if($link->validateProductByPid($_GET["makeGroupWithPid"])){
        $link->makeNewGroup($_SESSION["login_user"],$_GET["makeGroupWithPid"]);
    }else{
        header("Location: productNotAvailable.php");
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
    <!-- Index advertisement -->
    <!-- <div style="width:100%;height:300px">
        <img src="Resources/IndexAd/ad1.jpg" alt="ad1" width="100%" height="100%" class="center">
    </div> -->
    <a id='myorder'>
    </a>
    <p>
        1 <br><br><br><br><br>
        1 <br><br><br><br><br>
        1 <br><br><br><br><br><br>
        1 <br><br><br><br><br><br>
        1 <br><br><br><br><br><br><br><br>
        1 <br><br><br><br><br><br><br><br></p>
        <a id='mygroup'>
        </a>
        <p>

            222 <br>
            1222 <br>
            221 <br>
            22    1 <br>
            22    1 <br>
            222  <br></p>
            <!-- Other things -->
            <?php
            // echo $_SESSION['login_user'];
            ?>

        </body>


        </html>
