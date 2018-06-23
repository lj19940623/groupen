<!--
current product page
-->
<?php
require 'SQLDB.class.php';
if(!isset($_SESSION["login_user"])) header("Location: login.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
  // $postUsername = $_POST['username'];
  if(!move_uploaded_file($_FILES['photo']["tmp_name"], "Resources/ProductImage/".$_FILES['photo']["name"])) header("Location: failToListProduct.php");
  else{
      $link = groupenDB::getInstance();
      $result = $link -> listProduct($_POST["name"],$_POST["price"],$_POST["description"],$_POST["tag"],$_POST["category"],$_FILES['photo']["name"], $_POST["start_time"], $_POST["end_time"], $_POST["grouping_size"], $_POST["first_discount"],$_POST["discount"]);
      header("Location: account.php#mylist");
  }

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
                <a class=\"active\" href=\"account.php\">Welcome back, ".$_SESSION['login_user']."</a>
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
<!-- INSERT INTO `product`(`pid`, `user_uid`, `name`, `price`, `description`, `tag`, `category`, `photo_url`, `start_time`, `end_time`, `grouping_size`, `first_discount`, `discount`)  -->
<!-- VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9],[value-10],[value-11],[value-12],[value-13]) -->
    <form action="listProduct.php" method="post" enctype="multipart/form-data">
        ProductName *
        <input type="text" name="name" value="ProductName" required> <br>
        Price *
        <input type="number" name="price" value="10.5" step="0.01" required> <br>
        Description *
        <input type="text" name="description" value="Description" required> <br>
        Tag
        <input type="text" name="tag" value="Tag" > <br>
        Category
        <input type="text" name="category" value="Category" > <br>
        Product Image *
        <input type="file" name="photo" id = "photo"  required> <br>
        Start time
        <input type="datetime-local" name="start_time" value="<?php date_default_timezone_set("America/Denver"); echo date("Y-m-d\TH:i", strtotime("now")); ?>" required> <br>
        End time
        <input type="datetime-local" name="end_time" value="<?php date_default_timezone_set("America/Denver"); echo date("Y-m-d\TH:i", strtotime("next Friday")); ?>" required> <br>
        Grouping size
        <input type="number" name="grouping_size" value="3" required> <br>
        First Discount
        <input type="number" name="first_discount" value="0.2" step="0.01" required> <br>
        Member Discount
        <input type="number" name="discout" value="0.1" step="0.01" required> <br>
        <input type="submit" value="Submit"> <br>
    </form>



</body>


</html>
