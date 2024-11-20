<?php
	session_start();
	include_once "config.php";

	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);

	// Log errors to a custom log file
	ini_set("log_errors", 1);
	ini_set("error_log", __DIR__ . "/error_log.log");

	$sql_query = "
		SELECT OfficialsID AS id, EmailAddress, Password, Status, '1' AS UserTypeID FROM barangay_officials WHERE EmailAddress = '{$email}'
		UNION ALL
		SELECT ChiefID AS id, EmailAddress, Password, Status, '2' AS UserTypeID FROM mdrrmo_chief WHERE EmailAddress = '{$email}'
	";

	$sql = mysqli_query($conn, $sql_query);

	// Check for query errors
	if (!$sql) {
		error_log("MySQL Error: " . mysqli_error($conn) . " | Query: " . $sql_query);
		echo json_encode(["status" => "error", "message" => "An error occurred while processing your request. Please try again later."]);
		exit; // Stop further execution
	}

	if (mysqli_num_rows($sql) > 0) {
		$row = mysqli_fetch_assoc($sql);

		// Check if the account is active
		if ($row['Status'] === 'active') {
			if (password_verify($password, $row['Password'])) {
				$_SESSION['unique_id'] = $row['id'];
				$_SESSION['role'] = $row['UserTypeID'];

				echo json_encode(["status" => "success", "role" => $row['UserTypeID']]);
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
