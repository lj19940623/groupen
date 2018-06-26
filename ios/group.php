<?php
  require '..\SQLDB.class.php';

$rows = array();
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $link = groupenDB::getInstance();
  if (isset($_POST["search"])) {
      $groups = $link -> IOSlistingGroupsByName($_POST["search"]);
      $groupRows = array();
      while($row = mysqli_fetch_assoc($groups)) {
        array_push($groupRows, $row);
      }
      $rows["data"] = $groupRows;
  }else if(isset($_POST["uid"]) && isset($_POST["gid"])){
    $joinResult = $link -> joinGroup($_POST["uid"], $_POST['gid']);
    $rows["JoinResult"] = $joinResult;
  }else if(isset($_POST["uid"]) && isset($_POST["pid"])){
    $uid = $_POST['uid'];
    $pid = $_POST['pid'];
    $result = $link -> makeNewGroup($uid, $pid);
    $rows["newGroup"] = $result;
  }else{
      $groups = $link -> IOSlistGroup();
      $groupRows = array();
      while($row = mysqli_fetch_assoc($groups)) {
        array_push($groupRows, $row);
      }
      $rows["data"] = $groupRows;
  }
}
echo json_encode($rows);
?>
