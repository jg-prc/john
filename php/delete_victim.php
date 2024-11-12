<?php
include_once "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $victim_id = $_POST['victim_id'];
    
    // Prepare SQL statement to delete the victim
    $sql = "DELETE FROM victim WHERE victim_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $victim_id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
}
?>
