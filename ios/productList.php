<?php
  require '..\SQLDB.class.php';
  $rows = array();
  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $numPerDiv = $_POST['numberPerDiv'];
    $productDiv = $_POST['productDiv'];
    $link = groupenDB::getInstance();
    if(isset($_POST["search"])){
      $productList = $link -> getProductListBySearch($numPerDiv,($numPerDiv*$productDiv),$_POST["search"]);
      while($row = mysqli_fetch_assoc($productList)) {
        $rows[] = $row;
      }
    }else{
      $productList = $link -> IOSGetProductList($numPerDiv,($numPerDiv*$productDiv));
      while($row = mysqli_fetch_assoc($productList)) {
        $rows[] = $row;
      }
    }
}
echo json_encode($rows);
 ?>
