<?php
  require '..\SQLDB.class.php';
  $rows = array();
  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $numPerDiv = $_POST['numberPerDiv'];
    $productDiv = $_POST['productDiv'];
    $link = groupenDB::getInstance();
    if(isset($_POST["search"])){
      $productList = $link -> getProductListBySearch($numPerDiv,($numPerDiv*$productDiv),$_POST["search"]);
      $i = 0;
      while($row = mysqli_fetch_assoc($productList)) {
        $rows[$i] = $row;
        $i+1;
      }
    }else{
      $productList = $link -> IOSGetProductList($numPerDiv,($numPerDiv*$productDiv));
      $i = 0;
      while($row = mysqli_fetch_assoc($productList)) {
        $rows[$i] = $row;
        $i+1;
      }
    }
}
echo json_encode($rows);
 ?>
