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

<head>
    <title>Log in</title>
    <style><?php include 'Resources/CSS/general.css';?></style>
</head>

<body>
    <div style="width:100%"> <form action = "login.php" method = "post">
        <label>UserName:  </label> <input type = "text" name = "username" required /><br>
        <label>Password:  </label> <input type = "password" name = "password" required /><br><br>
        <input type = "submit" value = " Log in "/>
    </div>

</body>
</html>
