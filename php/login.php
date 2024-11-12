<?php
session_start();
header('Content-Type: application/json');
include_once "config.php";

$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

$sql = mysqli_query($conn, "
	SELECT user_id AS id, email, password, status, 'user' AS role FROM user WHERE email = '{$email}'
	UNION ALL
	SELECT admin_id AS id, email, password, status, 'admin' AS role FROM admin WHERE email = '{$email}'
");

// Check if the query executed and returned results
if ($sql && mysqli_num_rows($sql) > 0) {
	$row = mysqli_fetch_assoc($sql);

	// Check if the account is active
	if ($row['status'] === 'active') {
		// Verify the password
		if (password_verify($password, $row['password'])) {
			$_SESSION['unique_id'] = $row['id'];
			$_SESSION['role'] = $row['role'];
			echo json_encode(["status" => "success", "role" => $row['role"]]);
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
