<?php
  require '..\SQLDB.class.php';
  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $numPerDiv = $_POST['numberPerDiv'];
    $productDiv = $_POST['productDiv'];
    $response = array();
    $productList = $link -> listSomeProduct($numPerDiv,($numPerDiv*$productDiv));
    $numOfProduct = $link -> countProduct();
    $i = 0;
    while($row = mysqli_fetch_assoc($productList)) {
      $response[$i] = $row;
      $i = $i+1;
    }

    }
  }
  echo json_encode($response);
 ?>
