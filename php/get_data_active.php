<?php
	include_once "config.php";

	header('Content-Type: application/json');

	if (isset($_GET['OfficialsID'])) {
		$user_id = $conn->real_escape_string($_GET['OfficialsID']);

		$sql = "SELECT bo.OfficialsID, p.PositionName, b.BarangayName, bo.FirstName,
			bo.MiddleName, bo.LastName, bo.ExtensionName, bo.ContactNumber, bo.Birthdate, bo.Status, bo.Sex,
			bo.Zone, bo.EmailAddress, bo.ImageURL, bo.CreatedAt
			FROM `barangay_officials` AS bo
			LEFT JOIN position AS p ON bo.PositionID = p.PositionID
			LEFT JOIN barangay AS b ON bo.BarangayID = b.BarangayID
			WHERE OfficialsID = '$user_id' AND Status = 'active'";
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
