<?php
$conn = mysqli_connect("mysql.hostinger.com", "new", "Root_root01", "u412427249_capstone");
if (!$conn) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
} else {
    echo "Connected successfully!";
}
?>
