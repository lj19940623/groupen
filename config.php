<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'groupen');
$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
session_start();

return array(
  'DB_SERVER' => 'localhost',
  'DB_USERNAME' => 'root',
  'DB_PASSWORD' => '',
  'DB_DATABASE' => 'groupen');

class Test{

  public $name;

  public function test(){
    return "AAA";
  }
}
 ?>
