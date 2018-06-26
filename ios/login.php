<?php
  require '..\SQLDB.class.php';

$response = array();
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $postUsername = $_POST['username'];
    $postPassword = $_POST['password'];
    $link = groupenDB::getInstance();
    $response["accountInfo"] = $link -> IOSLogin($postUsername, $postPassword);
}
echo json_encode($response);
?>
