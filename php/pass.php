<?php
	session_start();
	include_once "config.php";

	$current_pass = mysqli_real_escape_string($conn, $_POST['current_pass']);
	$new_pass = mysqli_real_escape_string($conn, $_POST['new_pass']);

	$unique_id = $_SESSION['unique_id'];

	$sql = "SELECT password FROM mdrrmo_chief WHERE ChiefID = '$unique_id'";
	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$hashed_password = $row['password'];

		// Verify if the provided current password matches the hashed password
		if (password_verify($current_pass, $hashed_password)) {

			// Hash the new password before updating it
			$new_hashed_pass = password_hash($new_pass, PASSWORD_DEFAULT);

			// Update the password in the database
			$update_sql = "UPDATE mdrrmo_chief SET Password = '$new_hashed_pass' WHERE ChiefID = '$unique_id'";
			if (mysqli_query($conn, $update_sql)) {
				echo "success";
			} else {
				echo json_encode(["status" => "error", "message" => "Failed to update password"]);
			}
		} else {
			echo json_encode(["status" => "error", "message" => "Incorrect Password"]);
		}
	} else {
		echo json_encode(["status" => "error", "message" => "User not found"]);
	}
?>
