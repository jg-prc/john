<?php
  $hostname = "127.0.0.1";
  $username = "u412427249_new";
  $password = "Capstoneroot01";
  $dbname = "u412427249_capstone";

  $conn = mysqli_connect($hostname, $username, $password, $dbname);
  if(!$conn){
    echo "Database connection error: ".mysqli_connect_error();
  }
?>