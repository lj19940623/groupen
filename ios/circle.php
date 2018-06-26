<?php
  require '..\SQLDB.class.php';

$rows = array();
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $numPerDiv = $_POST['numPerDiv'];
  $groupDiv = $_POST['circleDiv'];
  $link = groupenDB::getInstance();
  if (isset($_POST["search"])) {
      $circles = $link -> listingCirclesByName($numPerDiv, ($numPerDiv*$circleDiv),$_POST["search"]);
      while($row = mysqli_fetch_assoc($circles)) {
        $rows[] = $row;
      }
  }else{
      $circles = $link -> listingCircles($numPerDiv, ($numPerDiv*$circleDiv));
      while($row = mysqli_fetch_assoc($circles)) {
        $rows[] = $row;
      }
  }
}
echo json_encode($rows);
?>
