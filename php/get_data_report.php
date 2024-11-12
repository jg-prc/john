<?php
	include_once "config.php";

	header('Content-Type: application/json');

	if (isset($_GET['report_id'])) {
		$report_id = $conn->real_escape_string($_GET['report_id']);

		$sql = "SELECT ir.report_id, ir.status, ir.incident_type, ir.barangay, ir.zone, ir.street, ir.ref_id, ir.user_id, ir.update_at, u.last_name, u.first_name, u.position, img.file_path
			FROM incident_report AS ir
			LEFT JOIN image AS img
			ON ir.ref_id = img.ref_id
			LEFT JOIN user AS u
			ON ir.user_id = u.user_id
			WHERE report_id = '$report_id'";
		$result = $conn->query($sql);

		if ($result && $result->num_rows > 0) {
			$rows = $result->fetch_all(MYSQLI_ASSOC);
			echo json_encode($rows);
		} else {
			echo json_encode(['error' => 'No data found']);
		}
	} else {
		echo json_encode(['error' => 'No report_id provided']);
	}
?>