<?php
  require '..\SQLDB.class.php';
  $rows = array();
  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $link = groupenDB::getInstance();
    if(isset($_POST["search"])){
      $productList = $link -> IOSgetProductListBySearch($_POST["search"]);
      $products = array();
      while($row = mysqli_fetch_assoc($productList)) {
        array_push($products, $row);
      }
      $rows["data"] = $products;
    }else{
      $productList = $link -> IOSGetProductList();
      $products = array();
      while($row = mysqli_fetch_assoc($productList)) {
        $path = '../Resources/ProductImage/'.$row["photo_url"];
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/'.$type.';base64,'.base64_encode($data);
        $row["photo"] = $base64;
        array_push($products, $row);
      }
      $rows["data"] = $products;
    }
}
echo json_encode($rows);
 ?>
