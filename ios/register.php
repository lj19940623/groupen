<?php
  require '..\SQLDB.class.php';

  $response = array();

  if($_SERVER["REQUEST_METHOD"] == "POST") {
      $postUsername = $_POST['username'];
      $postPassword = $_POST['password'];
      $postEmail = $_POST['email'];
      $link = groupenDB::getInstance();
      $result = $link -> register($postUsername, $postPassword, $postEmail);
      if($result == true){
        $response['message'] = true;
      }else{
        $response['message'] = false;
      }
  }

  }
  echo json_encode($response);
 ?>
