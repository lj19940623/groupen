<!--
current product page
-->
<?php
require 'SQLDB.class.php';

$productDiv = 0;
$numPerDiv = 3;
if($_SERVER["REQUEST_METHOD"] == "GET") {
    if(isset($_GET["productDiv"])){
        $productDiv = $_GET["productDiv"]-1;
    }
}

$link = groupenDB::getInstance();
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
        <a class="active" href="product.php">Products</a>
        <a href="group.php">Groups</a>
        <a href="circle.php">Circles</a>
        <form action="product.php" method="get" style="margin:0">
            <input type="text" placeholder="Search products" name="search">
            <input type="submit" value="Search">
        </form>
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

    <!-- Other things -->
    <div class="productList">
      <!-- <form method="GET" action="product.php">
        Sort by:<select name="sortBY">
          <option value="">Default</option>
          <option value="phl">Price hight to low</option>
          <option value="plw">Price low to high</option>
        </select>
        <input type="submit" vaule="Sort">
      </form> -->

      <br>

    <?php
    // echo "offset = " . ($numPerDiv * $productDiv);
    // if(isset($_GET["search"]) && isset($_GET["sortBY"])){
    //     $productList = $link -> getProductListBySearchSort($numPerDiv,($numPerDiv*$productDiv),$_GET["search"],$_GET["sortBY"]);
    //     $numOfProduct = $link -> countProductBySearch($_GET["search"]);
    //     echo "<br> Search Result: ". $numOfProduct . " products for groupen now <br><br>";
    // }else
    if(isset($_GET["search"])){
        $productList = $link -> getProductListBySearch($numPerDiv,($numPerDiv*$productDiv),$_GET["search"]);
        $numOfProduct = $link -> countProductBySearch($_GET["search"]);
        echo "<br> Search Result: ". $numOfProduct . " products for groupen now <br><br>";
    // }else if(isset($_GET["sortBY"])){
    //     $productList = $link -> sortProductByPrice($_GET["sortBY"]);
    //     $numOfProduct = $link -> countProductBySearch($_GET["search"]);
    //     echo "<br> Sort Result: ". $numOfProduct . " products for groupen now <br><br>";
    }else {
        $productList = $link -> getProductList($numPerDiv,($numPerDiv*$productDiv));
        $numOfProduct = $link -> countProduct();
        echo "<br> Groupen has ". $numOfProduct . " products now <br><br>";
    }


    // $numOfProduct = $link -> countProduct();
    // echo "<br> we have ". $numOfProduct . " products for groupen now <br><br>";

    while($row = mysqli_fetch_assoc($productList)) {
        $detailLink = "<a href=\"productDetail.php?ProductID={$row["pid"]}\">";
        echo "<div class=\"icon\">";
        echo $detailLink." <img src= \"Resources/ProductImage/".$row["photo_url"]."\"></a><br>" ;
        echo $detailLink.$row["name"]."</a><br>$".$row["price"]."<br>";
        echo "1st discount: ".$row["first_discount"]*100 ."%<br>";
        echo "Join to get ".$row["discount"]*100 ."% off<br>";
        echo "</div>";
    }
    ?>

    <br>
    <br>
    <div class="icon">
    <?php
      $page = isset($_GET["productDiv"])?$_GET["productDiv"]-1:1;
      $page = ($page>0)?$page:1;
      echo "<a href=\"product.php?productDiv={$page}\">Previous page</a>";
    ?>
    </div>
    <div class="icon">
    <form action="product.php" method="get">
          <input type="number" name="productDiv" value =  <?php echo isset($_GET["productDiv"])?$_GET["productDiv"]+1:(floor((($numOfProduct-1)/$numPerDiv+1))) ?>  min="1" max="<?php echo floor((($numOfProduct-1)/$numPerDiv+1)) ?>">
          <input type="submit" value="Go">
    </form>
    </div>
    <div class="icon">
    <?php
      $page = isset($_GET["productDiv"])?$_GET["productDiv"]+1:2;
      $page = min($page, floor(($numOfProduct-1)/$numPerDiv+1));
      echo "<a href=\"product.php?productDiv={$page}\">Next page</a>";
    ?>
  </div>
    </div>



</body>


</html>
