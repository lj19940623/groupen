<?php
//Encapsulation of SQL
class groupenDB{
  public $server;
  public $username;
  public $password;
  public $dbname;

  private $database;

  //
  public function __construct(){
    // Set by config
    $config = include_once(dirname(__FILE__)."/config.php");
    $this->server = $config['DB_SERVER'];
    $this->username = $config['DB_USERNAME'];
    $this->password = $config['DB_PASSWORD'];
    $this->dbname = $config['DB_DATABASE'];

    // Start connection
    $this->connect();
  }

  public function connect(){
    $this->database = mysqli_connect($this->server, $this->username, $this->password, $this->dbname) or die("Connection failed: " . mysqli_connect_error());
  }

  public function test(){
    return $this->server;
  }

  public function


}


?>
