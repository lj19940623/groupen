<?php
  require '..\SQLDB.class.php';

$rows = array();
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $numPerDiv = $_POST['numPerDiv'];
  $groupDiv = $_POST['groupDiv'];
  $link = groupenDB::getInstance();
  $groupList = $link -> listGroup($numPerDiv,($numPerDiv*$groupDiv),(isset($_POST["pid"])?$_POST["pid"]:-1));
  while($row = mysqli_fetch_assoc($groupList)) {
    $rows[] = $row;
  }
}
echo json_encode($rows);
?>
