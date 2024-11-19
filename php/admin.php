<?php
	session_start();
	include_once "config.php";

	$currentYear = date('Y');
	$autoIncrementValue = ($currentYear * 100) + 1;

	$auto_increment_query = "ALTER TABLE mdrrmo_chief AUTO_INCREMENT = $autoIncrementValue";

	$conn->query($auto_increment_query);

	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);

	$status = "active";
	$role = "2";

	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$sql = mysqli_query($conn, "SELECT * FROM mdrrmo_chief WHERE EmailAddress = '{$email}'");
		if (mysqli_num_rows($sql) > 0) {
			echo "This email already exists!";
			exit();
		} else {
			$encrypt_pass = password_hash($password, PASSWORD_DEFAULT);

			$insert_query = mysqli_query($conn, "INSERT INTO mdrrmo_chief (UserTypeID, EmailAddress, Password, Status)
			VALUES ('{$role}', '{$email}', '{$encrypt_pass}', '{$status}')");

			if ($insert_query) {
				echo "success";
			} else {
				echo "Failed to insert data. Please try again.";
			}
		}
	} else {
		echo "Not a valid email!";
	}
?>
