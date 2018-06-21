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
    // if(isset($_SESSION['login_user'])){
    //   if(session_destroy()) {
    //      // echo "<label>Log out sucessfully!</label><br>";
    //      // echo "<label>Returning to index page now.</label>";
    //      // // just for now
    //      // sleep(3);
    //      header("Location: index.php");
    //   }
    //     header("Location: logout.php");
    // }else{
    //   header("Location: index.php");
    // }
    ?>
</body>

</html>
