<?php
include 'config.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $myusername = mysqli_real_escape_string($db,$_POST['username']);
    $mypassword = mysqli_real_escape_string($db,$_POST['password']);
    $myemail = mysqli_real_escape_string($db,$_POST['email']);
    $sql = "INSERT INTO identification (username, psw, email) VALUES ('" .$myusername. "', '" .$mypassword. "', '" .$myemail. "')";
    if(mysqli_query($db, $sql)){

    }else{
         $register_error = " Username already used ";
    }
}else{
    $register_error = "No form submitted";
}
 ?>
<html>
   <head>
      <title>Register page</title>
   </head>
   <body>
       <form action = "register.php" method = "post">
                <label>UserName  :</label><input type = "text" name = "username" />
                <label>Password  :</label><input type = "password" name = "password" >
                <label>Email  :</label><input type = "email" name = "email" >
                <input type = "submit" value = " Submit "/>
                <?php
                if(isset($register_error)) echo $register_error;
                else {
                    $_SESSION["login_user"] = $myusername;
                    header("Location: index.php");
                }
                ?>
        </form>
   </body>

</html>
