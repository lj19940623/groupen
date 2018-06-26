<?php
require '..\SQLDB.class.php';

$response = array();
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $postUsername = $_POST['username'];
    $postPassword = $_POST['password'];
    $postEmail = $_POST['email'];
    $link = groupenDB::getInstance();
    $response["accountInfo"] = $link -> IOSRegister($postUsername, $postPassword, $postEmail);
}
echo json_encode($response);
?>
