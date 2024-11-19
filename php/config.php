<?php
  $hostname = "hostingersite.com";
  $username = "new";
  $password = "Root_root01";
  $dbname = "u412427249_capstone";

  $conn = mysqli_connect($hostname, $username, $password, $dbname);
  if(!$conn){
    echo "Database connection error: ".mysqli_connect_error();
  }
?>
