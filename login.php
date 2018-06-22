<head>
    <title>Log in</title>
    <style><?php include 'Resources/CSS/general.css';?></style>
    <style><?php include 'Resources/CSS/login.css';?></style>
</head>

<body>
  <div align="center">
    <form action="login.php" method="post" style="width:40%">
      <div class="imgContainer">
        <a href="index.php"><img src="Resources/logo.png"></a>
      </div>
      <div class="container">
        <label style="float:left">Username: </label> <input type = "text" name = "username" required />
        <label style="float:left">Password: </label> <input type = "password" name = "password" required />

        <?php
        require 'SQLDB.class.php';
        // if has form post and not login yet
        if($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_SESSION['login_user'])) {
            $postUsername = $_POST['username'];
            $postPassword = $_POST['password'];
            $link = groupenDB::getInstance();
            $count = $link -> login($postUsername, $postPassword);
            if($count!=1){
                echo "<label> Wrong username or password. Please try again. </label>";
            }
        }

        if(isset($_SESSION['login_user']))  header('Location: index.php');
        ?>

        <input type = "submit" value="Log in"/>
      </div>
      <div class="container">
        <span style="float:left"><a href="signup.php">Sign up?</a></span>
        <span style="float:right">Forget <a href="#">Password?</a></span>
      </div>
    </form>
  </div>

</body>
</html>
