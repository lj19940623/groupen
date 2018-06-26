<?php
  require '..\SQLDB.class.php';

$rows = array();
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $numPerDiv = $_POST['numPerDiv'];
  $groupDiv = $_POST['groupDiv'];
  $link = groupenDB::getInstance();
  $groupList = $link -> listGroup($numPerDiv,($numPerDiv*$groupDiv),(isset($_POST["pid"])?$_POST["pid"]:-1));
  $i = 0;
  while($row = mysqli_fetch_assoc($groupList)) {
    $rows[$i] = $row;
    $i+1;
  }
}
echo json_encode($rows);
?>
