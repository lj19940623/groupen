<?php
  require '..\SQLDB.class.php';

  $response = array();
  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $productID = $_POST["ProductID"];
    $link = groupenDB::getInstance();
    $product = $link->searchByPid($productID);
    $response['result'] = $product;
  }
  echo json_encode($response);
 ?>
