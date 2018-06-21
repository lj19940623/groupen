<html>
<?php
if(!isset($_SESSION['login_user']))  header('Location: index.php');
?>
<head>
    <title>Logging out</title>
    <style><?php include 'Resources/CSS/general.css';?></style>
</head>

<body>
    <p>Logout in progress</p>
    <?php
    session_start();
    if(session_destroy()) header("Location: index.php");
    else header("Location: logout.php");
    ?>
</body>

</html>
