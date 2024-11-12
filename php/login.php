<?php
	session_start();
	include_once "config.php";

	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);

	$sql = mysqli_query($conn, "
		SELECT user_id AS id, email, password, status, 'user' AS role FROM user WHERE email = '{$email}'
		UNION ALL
		SELECT admin_id AS id, email, password, status, 'admin' AS role FROM admin WHERE email = '{$email}'
	");

	// Check if the query returned any results
	if (mysqli_num_rows($sql) > 0) {
		$row = mysqli_fetch_assoc($sql);

		// Check if the account is active
		if ($row['status'] === 'active') {
			// Verify the password using the hashed password stored in the database
			if (password_verify($password, $row['password'])) {
				// Store the user ID and role in session variables
				$_SESSION['unique_id'] = $row['id'];  // Keep using 'unique_id' in session
				$_SESSION['role'] = $row['role'];

				echo json_encode(["status" => "success", "role" => $row['role']]);
			} else {
				echo json_encode(["status" => "error", "message" => "Incorrect Password!"]);
			}
		} else {
			echo json_encode(["status" => "error", "message" => "Your account has been deactivated."]);
		}
	} else {
		echo json_encode(["status" => "error", "message" => "This email doesn't exist!"]);
	}
?>
