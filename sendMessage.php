<!--
current product page
-->
<?php
require 'SQLDB.class.php';
if(!isset($_SESSION["login_user"])) header("Location: login.php");

$link = groupenDB::getInstance();
if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["to"])&&isset($_POST["message"])){
        $link->sendMessageTo($_POST["to"],$_POST["message"]);
    }
}
if($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!isset($_GET["to"])) header("Location: message.php");
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

<p>
Your message with <?php echo $_GET["to"] ?>:<br><br>

<div style="width: 600px; height: 500px; overflow-y: auto;">
<?php
$msgs = $link->getLastestMsgFromTo($_GET["to"]);
while ($msg = mysqli_fetch_assoc($msgs)) {
    echo "@". $msg["msg_time"]. ", ";
    if($msg["sender_uid"]==$_SESSION["login_user"]) echo "You: ";
    else echo $msg["sender_uid"].": ";
    echo $msg["context"]."<br>";
}
 ?>
</div>
</p>

<p>
<form action="sendMessage.php?to=<?php echo $_GET["to"] ?>" method="post">
<input type="hidden" name="to" value="<?php echo $_GET["to"] ?>" >
<input type="text" autofocus placeholder="Your message here" name="message" value="" required>
<input type="submit" value="send biu~">
</form>
</p>
    <!-- Index advertisement -->
    <div style="width:100%;height:300px">
        <img src="Resources/IndexAd/ad1.jpg" width="100%" height="100%" class="center">
    </div> <br>

</body>


</html>
