<?php
  require '..\SQLDB.class.php';

$rows = array();
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $link = groupenDB::getInstance();
  if (isset($_POST["search"])) {
      $circles = $link -> IOSlistingCirclesByName($_POST["search"]);
      $circleRows = array();
      while($row = mysqli_fetch_assoc($circles)) {
        array_push($circleRows, $row);
      }
      $rows["data"] = $circleRows;
  }else if(isset($_POST["cID"]) && isset($_POST["login_user"])){
    $joinResult = $link -> joinCircle($_POST["cID"], $_POST['login_user']);
    $rows["JoinResult"] = $joinResult;
  }else if(isset($_POST["name"]) && isset($_POST["tag"])){
    $postName = $_POST['name'];
    $postTag = $_POST['tag'];
    $result = $link -> createCircle($postName, $postTag);
    $rows["createResult"] = $result;
  }else{
      $circles = $link -> IOSlistingCircles();
      $circleRows = array();
      while($row = mysqli_fetch_assoc($circles)) {
        array_push($circleRows, $row);
      }
      $rows["data"] = $circleRows;
  }
}
echo json_encode($rows);
?>
