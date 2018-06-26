<?php
  require '..\SQLDB.class.php';

$rows = array();
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $link = groupenDB::getInstance();
  if (isset($_POST["search"])) {
      $circles = $link -> IOSlistingCirclesByName($_POST["search"]);
      while($row = mysqli_fetch_assoc($circles)) {
        $rows[] = $row;
      }
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
