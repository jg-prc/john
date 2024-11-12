<?php
	include_once "config.php";

	header('Content-Type: application/json');

	if (isset($_GET['user_id'])) {
		$user_id = $conn->real_escape_string($_GET['user_id']);

		$sql = "SELECT * FROM user WHERE user_id = '$user_id' AND status = 'deactivated'";
		$result = $conn->query($sql);

		if ($result) {
			$row = $result->fetch_assoc();
			echo json_encode($row);
		} else {
			echo json_encode(['error' => 'No data found']);
		}
	} else {
		echo json_encode(['error' => 'No user_id provided']);
	}
?>
