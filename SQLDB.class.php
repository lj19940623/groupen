<?php
session_start();
//Encapsulation of SQL
class groupenDB{
    public $server;
    public $username;
    public $password;
    public $dbname;

    private $database;
    private static $link;

    public static function getInstance(){
        if(!isset(self::$link)){
            self::$link = new self("/config.php");
        }
        return self::$link;
    }

    // Construct the database
    public function __construct($configPath){
        // Set by config
        $config = include_once(dirname(__FILE__).$configPath);
        $this->server = $config['DB_SERVER'];
        $this->username = $config['DB_USERNAME'];
        $this->password = $config['DB_PASSWORD'];
        $this->dbname = $config['DB_DATABASE'];

        // Start connection
        $this->connect();
    }

    // function for connecting to database
    public function connect(){
        $this->database = mysqli_connect($this->server, $this->username, $this->password, $this->dbname) or die("Connection failed: " . mysqli_connect_error());
    }

    //===================================================================
    // Account part

    // function for checking user login.
    public function login($userAccount, $userPassword){
        $myusername = mysqli_real_escape_string($this->database, $userAccount);
        $mypassword = mysqli_real_escape_string($this->database, $userPassword);
        $sql = "SELECT uid FROM user WHERE uid = '$myusername' AND psw = '$mypassword'";
        $result = mysqli_query($this->database,$sql);
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);
        if($count == 1) {
            $_SESSION['login_user'] = $userAccount;
        }
    }

    // function for registration
    // will return result info string
    public function register($userAccount, $userPassword, $userEmail){
        $myUsername = mysqli_real_escape_string($this->database, $userAccount);
        $myPassword = mysqli_real_escape_string($this->database, $userPassword);
        $myEmail = mysqli_real_escape_string($this->database, $userEmail);

        // check registered
        $sql = "SELECT uid FROM user WHERE uid = '$myUsername'";
        $result = mysqli_query($this->database,$sql);
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);
        if($count > 0 ) {
            return "Username is registered.";
        }
        // insert with checking valid
        $sql = "INSERT INTO user (uid, psw, email) VALUES ('" .$myUsername. "', '" .$myPassword. "', '" .$myEmail. "')";
        if(mysqli_query($this->database, $sql)){
            $_SESSION['login_user'] = $userAccount;
            return "Sign up successful";
        }
        return "Unknown error, please let admin known";
    }

    //===================================================================
    // Product part

    // // function for searching products by search bar
    // public function search($productName){
    //     $myName = mysqli_real_escape_string($this->database, $productName);
    //     $sql = "SELECT name FROM product WHERE name LIKE '$myName%'";
    //     $result = mysqli_query($this->database,$sql);
    //     return $result;
    // }
    public function searchByPid($pid){
        $sql = "SELECT * FROM product WHERE pid=".$pid."";
        $result = mysqli_query($this->database,$sql);
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        return $row;
    }
    public function getProductGroupingSizeByPid($pid){
        $sql = "SELECT grouping_size FROM product WHERE pid=".$pid."";
        $result = mysqli_query($this->database,$sql);
        return mysqli_fetch_array($result)[0];
    }
    public function validateProductByPid($pid){
        $sql = "SELECT end_time FROM product WHERE pid=".$pid."";
        $result = mysqli_query($this->database,$sql);
        // TODO: validate if it is not end
        // mysqli_fetch_array($result)[0]
        return true;
    }

    // function for listing Products
    // public function listing($searchType, $param, $order){
    public function getProductList($numPerDiv, $offset){
        $sql = "SELECT * FROM product ORDER BY pid ASC LIMIT " . $numPerDiv . " OFFSET " . $offset;
        $result = mysqli_query($this->database,$sql);
        return $result;
    }

    public function countProduct(){
      $sql = "SELECT COUNT(pid) FROM product";
      $result = mysqli_query($this->database, $sql);
      return mysqli_fetch_array($result)[0];
    }
    public function getProductListByUid($u_uid){
        $sql = "SELECT * FROM product WHERE user_uid = '".$u_uid."'";
        $result = mysqli_query($this->database,$sql);
        return $result;
    }
    // $result = $link -> listProduct($_POST["name"],$_POST["price"],$_POST["description"],$_POST["tag"],$_POST["category"],$_FILES['photo']["name"], $_POST["start_time"], $_POST["end_time"], $_POST["grouping_size"]);

    public function listProduct($name,$price,$description,$tag,$category,$photo,$start_time,$end_time,$grouping_size,$first_discount,$discount){
        $sql = "INSERT INTO product(`user_uid`, `name`, `price`, `description`, `tag`, `category`, `photo_url`, `start_time`, `end_time`, `grouping_size`, `first_discount`, `discount`) ";
        $sql .= "VALUES ('".$_SESSION["login_user"]."','".$name."','".$price."','".$description."','".$tag."','".$category."','".$photo."','".$start_time."','".$end_time."','".$grouping_size."','".$first_discount."','".$discount."')";
        $result = mysqli_query($this->database,$sql);
        return $result;
    }

    //===================================================================
    // Group part

    // function for listing Products
    // public function listing($searchType, $param, $order){
    public function listGroup($numPerDiv, $offset, $p_pid=-1){
        $sql = "SELECT * FROM groups ";
        if($p_pid!=-1) $sql .= " WHERE product_pid = '" . $p_pid . "'";
        $sql .= "ORDER BY gid ASC LIMIT " . $numPerDiv . " OFFSET " . $offset;
        $result = mysqli_query($this->database,$sql);
        return $result;
    }
    // count group for product, -1 for all
    public function countGroup($p_pid = -1){
        $sql = "SELECT COUNT(gid) FROM groups ";
        if($p_pid!=-1) $sql .= "WHERE product_pid = '" . $p_pid . "'";
        $result = mysqli_query($this->database, $sql);
        return mysqli_fetch_array($result)[0];
    }

    public function makeNewGroup($u_uid,$p_pid) {
        $sql = "INSERT INTO groups (starter_uid, product_pid) VALUES ('" .$u_uid. "', " .$p_pid. ")";
        $result = mysqli_query($this->database, $sql);
    }

    public function getGroupCurrentSizeByGid($g_gid) {
        $sql = "SELECT COUNT(user_uid) FROM groupmember WHERE groups_gid = ".$g_gid;
        $result = mysqli_query($this->database, $sql);
        return 1 + mysqli_fetch_array($result)[0];
    }
    public function getRestSpaceInGroup($g_gid){
        $sql = "SELECT product_pid FROM groups WHERE gid = ".$g_gid;
        $result = mysqli_query($this->database, $sql);
        $groupRow = mysqli_fetch_assoc($result);
        $sql = "SELECT grouping_size FROM product WHERE pid = ".$groupRow["product_pid"];
        $result = mysqli_query($this->database, $sql);
        $productRow = mysqli_fetch_assoc($result);
        return ($productRow["grouping_size"]-$this->getGroupCurrentSizeByGid($g_gid));
    }
    public function joinGroup($u_uid, $g_gid){
        // if just 1 seat available, then let all member and this user have new order and delete group, also the group owner
        // else just insert
        if($this->getRestSpaceInGroup($g_gid)==1){

            $sql = "SELECT * FROM groups WHERE gid = ".$g_gid;
            $result = mysqli_query($this->database, $sql);
            $groupRow = mysqli_fetch_assoc($result);
            $p_pid = $groupRow["product_pid"];
            $starter_uid = $groupRow["starter_uid"];
            $sql = "SELECT * FROM product WHERE pid = ".$p_pid;
            $result = mysqli_query($this->database, $sql);
            $productRow = mysqli_fetch_assoc($result);
            $first_discount = $productRow["first_discount"];
            $discount = $productRow["discount"];
            // order for 1st guy
            $sql = "INSERT INTO orders (user_uid,product_pid,discount) VALUES ('".$starter_uid."','".$p_pid."','".$first_discount."')";
            $result = mysqli_query($this->database, $sql);
            // order for member also delete
            $sql = "INSERT INTO orders (user_uid,product_pid,discount) VALUES ('".$u_uid."','".$p_pid."','".$discount."')";
            $result = mysqli_query($this->database, $sql);
            $sql = "SELECT * FROM groupmember WHERE groups_gid = ".$g_gid;
            $result = mysqli_query($this->database, $sql);
            while($groupmemberRow = mysqli_fetch_assoc($result)){
                $sql = "INSERT INTO orders (user_uid,product_pid,discount) VALUES ('".$groupmemberRow["user_uid"]."','".$p_pid."','".$discount."')";
                $result = mysqli_query($this->database, $sql);
                $sql = "DELETE FROM groupmember WHERE user_uid = '" . $groupmemberRow["user_uid"] . "' AND groups_gid = '".$g_gid."'";
                $result = mysqli_query($this->database, $sql);
            }
            //delete starter in group
            $sql = "DELETE FROM groups WHERE gid = '".$g_gid."'";
            return $result = mysqli_query($this->database, $sql);
        }else{
            $sql = "INSERT INTO groupmember (groups_gid, user_uid) VALUES ('" .$g_gid. "', '" .$u_uid. "')";
            return $result = mysqli_query($this->database, $sql);
        }
    }
    public function checkIfIsGroupStarter($u_uid, $g_gid){
      $sql = "SELECT COUNT(starter_uid) FROM groups WHERE gid = '".$g_gid."' AND starter_uid = '". $u_uid ."'";
      $result = mysqli_query($this->database, $sql);
      return (mysqli_fetch_array($result)[0]==1);
    }
    public function checkIfIsGroupMember($u_uid, $g_gid){
      $sql = "SELECT COUNT(groups_gid) FROM groupmember WHERE groups_gid = '".$g_gid."' AND user_uid = '" .$u_uid. "'";
      $result = mysqli_query($this->database, $sql);
      return (mysqli_fetch_array($result)[0]==1);
    }
    public function getGroupListStartBy($numPerDiv, $offset, $u_uid){
        $sql = "SELECT * FROM groups WHERE starter_uid = '" . $u_uid . "'";
        $sql .= "ORDER BY gid ASC LIMIT " . $numPerDiv . " OFFSET " . $offset;
        $result = mysqli_query($this->database,$sql);
        return $result;
    }
    public function countGroupStartBy($u_uid){
        $sql = "SELECT COUNT(gid) FROM groups ";
        $sql .= "WHERE starter_uid = '" . $u_uid . "'";
        $result = mysqli_query($this->database, $sql);
        return mysqli_fetch_array($result)[0];
    }
    public function getGroupListJoinedBy($numPerDiv, $offset, $u_uid){
        $sql = "SELECT * FROM groupmember WHERE user_uid = '" . $u_uid . "'";
        $sql .= "ORDER BY groups_gid ASC LIMIT " . $numPerDiv . " OFFSET " . $offset;
        $result = mysqli_query($this->database,$sql);
        return $result;
    }
    public function countGroupJoinedBy($u_uid){
        $sql = "SELECT COUNT(groups_gid) FROM groupmember ";
        $sql .= "WHERE user_uid = '" . $u_uid . "'";
        $result = mysqli_query($this->database, $sql);
        return mysqli_fetch_array($result)[0];
    }
    public function quitGroupAsStarter($u_uid, $g_gid){
        // fetch one member from groupmember
        // if have delete it and update it as starter in group
        // else delete directly in group
        $sql = "SELECT * FROM groupmember WHERE groups_gid = ' ".$g_gid."'";
        $result = mysqli_query($this->database, $sql);
        if($row=mysqli_fetch_assoc($result)){
            $newStarer_uid = $row["user_uid"];
            $this->quitGroupAsMember($newStarer_uid, $g_gid);
            $sql = "UPDATE groups SET starter_uid ='".$newStarer_uid."' WHERE gid = '".$g_gid."'";
            $result = mysqli_query($this->database, $sql);
        }else{
            $sql = "DELETE FROM groups WHERE gid = '".$g_gid."'";
            $result = mysqli_query($this->database, $sql);
        }
    }
    public function quitGroupAsMember($u_uid, $g_gid){
        $sql = "DELETE FROM groupmember WHERE user_uid = '" . $u_uid . "' AND groups_gid = '".$g_gid."'";
        $result = mysqli_query($this->database, $sql);
    }
    //===================================================================
    // Orders part

    public function countUserOrder($u_uid){
        $sql = "SELECT COUNT(oid) FROM orders WHERE user_uid = '".$u_uid."'";
        $result = mysqli_query($this->database, $sql);
        return mysqli_fetch_array($result)[0];
    }
    public function getOrderListByUid($numPerDiv, $offset, $u_uid){
        $sql = "SELECT * FROM orders WHERE user_uid = '" . $u_uid . "'";
        $sql .= "ORDER BY oid ASC LIMIT " . $numPerDiv . " OFFSET " . $offset;
        $result = mysqli_query($this->database,$sql);
        return $result;
    }


    //===================================================================
    // Circle part

    // create circle
    public function createCircle($name, $tag){
      $sql = "INSERT INTO circle (name, tag) VALUES ('" .$name. "', '" .$tag. "')";
      if(mysqli_query($this->database, $sql)){
        return true;
      }else{
        return false;
      }
    }

    // listing Circles
    public function listingCircles($numPerDiv, $offset){
      $sql = "SELECT * FROM circle ORDER BY cid ASC LIMIT " . $numPerDiv . " OFFSET " . $offset;
      $result = mysqli_query($this->database,$sql);
      return $result;
    }

    // count circles
    public function countCircles(){
      $sql = "SELECT COUNT(cid) FROM circle";
      $result = mysqli_query($this->database, $sql);
      return mysqli_fetch_array($result)[0];
    }













    //===================================================================
    // friend
    public function sendRequestTo($u_uid){
        $sql = "INSERT INTO friend_request(user_uid,request_uid) VALUES ('".$u_uid."','".$_SESSION["login_user"]."')";
        $result = mysqli_query($this->database,$sql);
        return $result;
    }
    public function acceptRequest($u_uid){
        $this->refuseRequset($u_uid);
        $sql = "INSERT INTO friend_with(user_uid,friend_uid) VALUES ('".$_SESSION["login_user"]."','".$u_uid."')";
        $result = mysqli_query($this->database,$sql);
        $sql = "INSERT INTO friend_with(user_uid,friend_uid) VALUES ('".$u_uid."','".$_SESSION["login_user"]."')";
        $result = mysqli_query($this->database,$sql);
        return $result;
    }
    public function refuseRequset($request_uid){
        $sql = "DELETE FROM friend_request WHERE user_uid = '".$_SESSION["login_user"]."' AND request_uid = '".$request_uid."'";
        $result = mysqli_query($this->database,$sql);
        return $result;
    }
    public function getRequsetList(){
        $sql = "SELECT * FROM friend_request WHERE user_uid = '".$_SESSION["login_user"]."'";
        $result = mysqli_query($this->database,$sql);
        return $result;
    }
    public function getFriendList(){
        $sql = "SELECT * FROM friend_with WHERE user_uid = '".$_SESSION["login_user"]."'";
        $result = mysqli_query($this->database,$sql);
        return $result;
    }
    public function deleteFriend($friend_uid){
        $sql = "DELETE FROM friend_with WHERE user_uid = '".$_SESSION["login_user"]."' AND friend_uid = '".$friend_uid."'";
        $result = mysqli_query($this->database,$sql);
        $sql = "DELETE FROM friend_with WHERE user_uid = '".$friend_uid."' AND friend_uid = '".$_SESSION["login_user"]."'";
        $result = mysqli_query($this->database,$sql);
        return $result;
    }
    //===================================================================
    // message
    
    //===================================================================
    //IOS part
    public function IOSLogin($userAccount, $userPassword){
      $myusername = mysqli_real_escape_string($this->database, $userAccount);
      $mypassword = mysqli_real_escape_string($this->database, $userPassword);
      $sql = "SELECT uid FROM user WHERE uid = '$myusername' AND psw = '$mypassword'";
      $result = mysqli_query($this->database,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $count = mysqli_num_rows($result);
      return $count;
    }

}
?>
