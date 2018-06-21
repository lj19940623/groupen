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
        $sql = "SELECT uid FROM user WHERE uid = '$myusername' and psw = '$mypassword'";
        $result = mysqli_query($this->database,$sql);
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);
        if($count == 1) {
            $_SESSION['login_user'] = $userAccount;
        }
    }

    // function for registration
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
        }

        return "Unknown error";
    }

    //===================================================================
    // Product part

    // function for searching products by search bar
    public function search($productName){
        $myName = mysqli_real_escape_string($this->database, $productName);
        $sql = "SELECT name FROM product WHERE name LIKE '$myName%'";
        $result = mysqli_query($this->database,$sql);
        return $result;
    }

    // function for listing Products
    // public function listing($searchType, $param, $order){
    public function listSome($numPerDiv, $offset){
// SELECT * FROM Orders LIMIT 10 OFFSET 15
        $sql = "SELECT * FROM product ORDER BY pid ASC LIMIT " . $numPerDiv . " OFFSET " . $offset;
        $result = mysqli_query($this->database,$sql);
        // $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        // $count = mysqli_num_rows($result);
        return $result;
    }

    //===================================================================
    // Orders part



    //===================================================================
    // Group part


}
?>
