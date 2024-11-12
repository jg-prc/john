<?php
	include 'config.php';

	if (isset($_GET['user_id'])) {
		$user_id = $conn->real_escape_string($_GET['user_id']);

		// Update the status of the account to 'deactivated'
		$sql = "UPDATE user SET status = 'active', created_at = CURRENT_TIMESTAMP WHERE user_id = $user_id";
		$result = $conn->prepare($sql);

		if ($result->execute()) {
			echo json_encode(['success' => true]);
		} else {
			echo json_encode(['success' => false]);
		}
	}
?>
