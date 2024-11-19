<?php
	include 'config.php';

	if (isset($_GET['OfficialsID'])) {
		$user_id = $conn->real_escape_string($_GET['OfficialsID']);

		// Update the status of the account to 'deactivated'
		$sql = "UPDATE barangay_officials SET Status = 'deactivated', CreatedAt = CURRENT_TIMESTAMP WHERE OfficialsID = $user_id";
		$result = $conn->prepare($sql);

		if ($result->execute()) {
			echo json_encode(['success' => true]);
		} else {
			echo json_encode(['success' => false]);
		}
	}
?>
