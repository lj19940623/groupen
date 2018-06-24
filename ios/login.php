<?php
  require '..\SQLDB.class.php';

  $response = array();
  if($_SERVER["REQUEST_METHOD"] == "POST") {
      $postUsername = $_POST['username'];
      $postPassword = $_POST['password'];
      $link = groupenDB::getInstance();
      $count = $link -> IOSLogin($postUsername, $postPassword);
      if($count!=1){
          $response['message'] = false;
      }else{
          $response['message'] = "true";
      }
  }


  echo json_encode($response);
 ?>
