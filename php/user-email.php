<?php
	session_start();
	include_once "config.php";

	$current_email = mysqli_real_escape_string($conn, $_POST['current_email']);
	$new_email = mysqli_real_escape_string($conn, $_POST['new_email']);
	$unique_id = $_SESSION['unique_id'];

	if (filter_var($current_email, FILTER_VALIDATE_EMAIL) && filter_var($new_email, FILTER_VALIDATE_EMAIL)) {

		$sql = "SELECT EmailAddress FROM barangay_officials WHERE OfficialsID = '$unique_id'";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$stored_email = $row['EmailAddress'];

			if ($stored_email === $current_email) {

				$sql2 = "SELECT EmailAddress FROM barangay_officials WHERE EmailAddress = '$new_email'";
				$result2 = $conn->query($sql2);

				if ($result2->num_rows > 0) {
					echo json_encode(["status" => "error", "message" => "New email is already taken."]);
				} else {

					$sql1 = "UPDATE barangay_officials SET EmailAddress = ? WHERE OfficialsID = ?";
					$stmt = $conn->prepare($sql1);
					$stmt->bind_param("ss", $new_email, $unique_id);

					if ($stmt->execute()) {
						echo "success";
					} else {
						echo json_encode(['status' => 'error', 'message' => 'Failed to update email.']);
					}
				}
			} else {
				echo json_encode(["status" => "error", "message" => "Current email is incorrect!"]);
			}
		} else {
			echo json_encode(["status" => "error", "message" => "This user doesn't exist!"]);
		}
	} else {
		echo json_encode(["status" => "error", "message" => "Not a valid email!"]);
	}
?>
