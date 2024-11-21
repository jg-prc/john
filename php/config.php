<?php
  $hostname = "127.0.0.1";
  $username = "newest";
  $password = "Capstoneroot01";
  $dbname = "capstone1";

  $conn = mysqli_connect($hostname, $username, $password, $dbname);
  if(!$conn){
    echo "Database connection error: ".mysqli_connect_error();
  }
?>