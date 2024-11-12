<?php
  $hostname = "localhost";
  $username = "new";
  $password = "";  // Ensure this is correct
  $dbname = "capstone";

  $conn = mysqli_connect($hostname, $username, $password, $dbname);
  if(!$conn){
    echo "Database connection error: ".mysqli_connect_error();
  }
?>
