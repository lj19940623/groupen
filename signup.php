<html>
<head>
    <title>Register page</title>
    <style><?php include 'Resources/CSS/login.css' ?></style>
</head>
<body>
  <div align="center">
    <form action="signup.php" method="post" style="width:40%">
      <div class="imgContainer">
        <a href="index.php"><img src="Resources/logo.png"></a>
      </div>
      <div class="container">
        <label style="float:left">Username: </label> <input type = "text" name = "username" required />
        <label style="float:left">Password: </label> <input type = "password" name = "password" required />
        <label style="float:left">Email: </label> <input type = "email" name = "email" required />


          <?php
          require 'SQLDB.class.php';

          if($_SERVER["REQUEST_METHOD"] == "POST") {
              $postUsername = $_POST['username'];
              $postPassword = $_POST['password'];
              $postEmail = $_POST['email'];
              $link = groupenDB::getInstance();
              $result = $link -> register($postUsername, $postPassword, $postEmail);
              echo $result;
          }
          if(isset($_SESSION["login_user"])){
              header("Location: index.php");
          }
          ?>

        <input type = "submit" value="Sign up" />
      </div>
    </form>
  </div>
</body>

</html>
