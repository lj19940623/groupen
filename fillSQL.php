<!-- This is just a class that for filling sql with data for testing purpose -->
<?php
class fillSQL{
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

//function for inserting products
public function addProducts($number){
  // read input from directory
  $dir = "Resources/ProductImage/";
  if (is_dir($dir)){
    $files = scandir($dir);
  }
  // inserting each file
  for($i=0; $i<$number; $i++){
    $categories = array('Electronics', 'Home Improvement', 'Clothing & Shoes', 'Sport & Outdoors', 'Video Games', 'Kitchen & Dining');
    $userID = 1;
    $name = "product".$i;
    $price = rand(1,1000);
    $description = "None";
    $tag = "tag".rand(0,6);
    $category = $categories[rand(0,5)];
    $photo_url = "Resources/ProductImage/".$files[rand(2,11)];
    $start_time = date('Y-m-d');
    $end_time = $start_time;

    $myUserID = mysqli_real_escape_string($this->database, $userID);
    $myName = mysqli_real_escape_string($this->database, $name);
    $myPrice = mysqli_real_escape_string($this->database, $price);
    $myDescription = mysqli_real_escape_string($this->database, $description);
    $myTag = mysqli_real_escape_string($this->database, $tag);
    $myCategory = mysqli_real_escape_string($this->database, $category);
    $myPhto_url = mysqli_real_escape_string($this->database, $photo_url);
    $myStart_time = mysqli_real_escape_string($this->database, $start_time);
    $myEnd_time = mysqli_real_escape_string($this->database, $end_time);

    $sql = "INSERT INTO product (
      user_uid,
      name,
      price,
      description,
      tag,
      category,
      photo_url,
      start_time,
      end_time)
    VALUES ('".$userID."',
            '".$myName."',
            '".$myPrice."',
            '".$myDescription."',
            '".$myTag."',
            '".$myCategory."',
            '".$myPhto_url."',
            '".$myStart_time."',
            '".$myEnd_time."')";

  if(!mysqli_query($this->database, $sql)){
    echo "sql error: ".mysqli_error($this->database)."<br>";
    echo "error in inserting: ".$i."<br>";
    die();
  }

    }
    echo $number." data generate succesfully.";
  }
}
 ?>

 <html>
 <head>
   <title>fillSQL(for testing)</title>
 </head>

 <body>
   <div> <form action = "fillSQL.php" method = "post">
       <label>How many number of product:  </label> <input type = "text" name = "number" required /><br>
       <input type = "submit" value = " gernerate "/>
   </div>
   <?php
   if($_SERVER["REQUEST_METHOD"] == "POST") {
       $postNumber = $_POST['number'];
       $link = fillSQL::getInstance();
       $link->addProducts($postNumber);
   }

    ?>

  </body>
  </html>
