<!--
circle page
-->
<?php
require 'SQLDB.class.php';
?>

<html>
<head>
    <title>Groupen</title>
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
        <a class="active" href="circle.php">Circles</a>
        <input type="text" placeholder="Search circles" name="search">
        <!-- Search button right here -->
        <input type="submit" value="Search">
        <div class="topnavRight">
            <?php
            if(isset($_SESSION['login_user'])){
                echo "<a href=\"logout.php\">Log out</a>
                <a href=\"account.php\">Welcome back, ".$_SESSION['login_user']."</a>
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

    <div class="productList">

      <!-- create group -->
      <form action="circle.php" method="post">
        <label>Circle name: </label> <input type = "text" name = "name" required />
        <label>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsptag: </label> <input type = "text" name = "tag"/>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
        <input type="submit" value="Create circle">
      </form>
      <?php
      // if has form post and not login yet
      if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['login_user'])) {
          $postName = $_POST['name'];
          $postTag = $_POST['tag'];
          $link = groupenDB::getInstance();
          $result = $link -> createCircle($postName, $postTag);
          if($result){
            echo "<script>alert(\"You have created a new circle!\")</script>";
          }else{
            echo "<script>alert(\"Failed to create a new circle\")</script> ";
          }
      }else if($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_SESSION['login_user'])){
        echo "<script>alert(\"Please login first\")</script>";
      }
      ?>
      <!-- listing circles -->
      <div class="icon">
      <?php
        $link = groupenDB::getInstance();
        $circleDiv = 0;
        $numPerDiv = 3;
        if($_SERVER["REQUEST_METHOD"] == "GET") {
            // set pages
            if(isset($_GET["circleDiv"])){
                $circleDiv = $_GET["circleDiv"]-1;
            }

            // Join group
            if(isset($_GET["circleID"]) && isset($_SESSION['login_user'])){
                $joinResult = $link -> joinCircle($_GET["circleID"], $_SESSION['login_user']);
                if($joinResult){
                    echo "<script>alert(\"Join successfully!\")</script>";
                }else{
                    echo "<script>alert(\"Failed to join..\")</script>";
                }
            }else if(isset($_GET["circleID"]) && !isset($_SESSION['login_user'])){
                echo "<script>alert(\"Please login first\")</script>";
            }
        }
        $circles = $link -> listingCircles($numPerDiv, ($numPerDiv*$circleDiv));
        $numOfCircle = $link -> countCircles();
        echo "we have ".$numOfCircle." circles for you to join!";

        //===========================================================
        // Listing circles in a table
        echo "<table style=\"width:100%\">
              <tr>
                <th>Circle name</th>
                <th>Tag</th>
                <th>Action</th>
              </tr>";
        while($row = mysqli_fetch_assoc($circles)){
          $joinLink = "<a href=\"circle.php?circleID={$row["cid"]}\">";

          echo "<tr>
                  <td>".$row["name"]."</td>
                  <td>".$row["tag"]."</td>";
          if($link->checkInCircle($row["cid"], $_SESSION['login_user'])){
            echo "<td style=\"color:green\">Joined</td>
                    </tr>";
          }else{
            echo "<td>".$joinLink."Join!</a></td>
                    </tr>";
          }
        }
        echo "</table>";
      ?>
    </div>







      <!-- switch pages -->
      <br>
      <br>
      <div class="icon">
      <?php
        $page = isset($_GET["circleDiv"])?$_GET["circleDiv"]-1:1;
        $page = ($page>0)?$page:1;
        echo "<a href=\"circle.php?circleDiv={$page}\">Previous page</a>";
      ?>
      </div>
      <div class="icon">
      <form action="circleDiv.php" method="get">
            <input type="number" name="circleDiv" value =  <?php echo isset($_GET["circleDiv"])?$_GET["circleDiv"]+1:floor((($numOfCircle-1)/$numPerDiv+1)) ?>  min="1" max="<?php echo floor((($numOfCircle-1)/$numPerDiv+1)) ?>">
            <input type="submit" value="Go">
      </form>
      </div>
      <div class="icon">
      <?php
        $link = groupenDB::getInstance();
        $numOfCircle = $link -> countCircles();
        $page = isset($_GET["circleDiv"])?$_GET["circleDiv"]+1:2;

        $page = min($page, floor(($numOfCircle-1) / $numPerDiv+1));
        echo "<a href=\"circle.php?circleDiv={$page}\">Next page</a>";
      ?>
  </div>
</body>


</html>
