<?php
  $hostname = "localhost";
  $username = "new";
  $password = "";  // Ensure this is correct
  $dbname = "u412427249_capstone";

  $conn = mysqli_connect($hostname, $username, $password, $dbname);
  if(!$conn){
    echo "Database connection error: ".mysqli_connect_error();
  }
?>
