<!--
    initial page for website
    website has login/logout part at top, some stuff below that
-->
<?php
include 'config.php';
// if has form post and not login yet
if($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_SESSION['login_user'])) {
    $myusername = mysqli_real_escape_string($db,$_POST['username']);
    $mypassword = mysqli_real_escape_string($db,$_POST['password']);

    $sql = "SELECT uid FROM user WHERE uid = '$myusername' and psw = '$mypassword'";
    $result = mysqli_query($db,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);
    // If result matched $myusername and $mypassword, table row must be 1 row
    if($count == 1) {
        $_SESSION['login_user'] = $myusername;
    }else {
        $login_error = " Invalid username and password pair. ";
    }
}
// session view count
if(isset($_SESSION['views'])) $_SESSION['views']=$_SESSION['views']+1;
else $_SESSION['views']=1;
?>


<html>
   <head>
      <title>Welcome </title>
   </head>
   <body>
       <?php
       if(isset($_SESSION['login_user'])) {
           echo "<div> Nice, you loged in: ". $_SESSION['login_user'] . ". ";
           echo '  <a href = "logout.php">Sign Out</a>';
           echo '  <a href = " listProduct.php">List product</a>';
           echo '  <a href = " order.php">Orders</a>';
           echo '  <a href = " group.php">Groups</a>';
           echo '  <a href = " circle.php">Circles</a> </div>';
       } else {
           echo '<div> <form action = "index.php" method = "post">
                    <label>UserName:  </label> <input type = "text" name = "username" required />
                    <label>Password:  </label> <input type = "password" name = "password" required />
                    <input type = "submit" value = " Submit "/>';
            if(isset($login_error)) echo $login_error;
            echo '<a href = "register.php">Register</a>';
            echo '</form> </div>';
       }
        ?>
   </body>
   <body>
      <br>
      This is body part <br>
      List product and some info here <br>
      View count: <?php echo $_SESSION['views']; ?> <br>
   </body>

</html>

<?php
// View Counter
if(isset($_SESSION['views']))
{
    $_SESSION['views']=$_SESSION['views']+1;
} else {
    $_SESSION['views']=1;
}
?>
