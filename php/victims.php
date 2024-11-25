<?php
	session_start();
	include_once "config.php";

	$report_id = mysqli_real_escape_string($conn, $_POST['report_id']);
	$incident_type = mysqli_real_escape_string($conn, $_POST['incident_type']);
	$barangay = mysqli_real_escape_string($conn, $_POST['barangay']);
	$zone = mysqli_real_escape_string($conn, $_POST['zone']);
	$street = mysqli_real_escape_string($conn, $_POST['street']);
	$event_at = mysqli_real_escape_string($conn, $_POST['event_at']);

	$sql = "UPDATE incident_report 
		SET IncidentTypeID = '$incident_type',
			BarangayID = '$barangay',
			Zone = '$zone',
			Street = '$street',
			CreatedAt = '$event_at',
			UpdatedAt = CURRENT_TIMESTAMP
		WHERE IncidentReportID = '$report_id'";

	$result = mysqli_query($conn, $sql);

	if ($result) {
	}

	$all_update_success = true;
	$all_insert_success = true;

	if (isset($_POST['victim_id']) && !empty($_POST['victim_id'])) {
		$victim_id = mysqli_real_escape_string($conn, $_POST['victim_id']);
		$update_names = $_POST['update_name'];
		$update_addresses = $_POST['update_address'];
		$update_ages = $_POST['update_age'];
		$update_sexes = $_POST['update_sex'];
		$update_classifications = $_POST['update_classification'];

		for ($i = 0; $i < count($update_names); $i++) {
			$update_name = mysqli_real_escape_string($conn, $update_names[$i]);
			$update_address = mysqli_real_escape_string($conn, $update_addresses[$i]);
			$update_age = mysqli_real_escape_string($conn, $update_ages[$i]);
			$update_sex = mysqli_real_escape_string($conn, $update_sexes[$i]);
			$update_classification = mysqli_real_escape_string($conn, $update_classifications[$i]);

			$update_query = "UPDATE victims 
				SET VictimName = '$update_name', 
					Address = '$update_address', 
					Age = '$update_age', 
					Sex = '$update_sex', 
					Classification = '$update_classification' 
				WHERE victimID = '$victim_id'";

			$result = mysqli_query($conn, $update_query);

			if (!$result) {
				$all_update_success = false;
				break;
			}
		}
	}

	$names = $_POST['name'] ?? [];
	$addresses = $_POST['address'] ?? [];
	$ages = $_POST['age'] ?? [];
	$sexes = $_POST['sex'] ?? [];
	$classifications = $_POST['classification'] ?? [];

	if (!empty($names) && !empty($addresses) && !empty($ages) && !empty($sexes) && !empty($classifications)) {
		for ($i = 0; $i < count($names); $i++) {
			$name = mysqli_real_escape_string($conn, $names[$i]);
			$address = mysqli_real_escape_string($conn, $addresses[$i]);
			$age = mysqli_real_escape_string($conn, $ages[$i]);
			$sex = mysqli_real_escape_string($conn, $sexes[$i]);
			$classification = mysqli_real_escape_string($conn, $classifications[$i]);

			$insert_query = "INSERT INTO victims (victimID , VictimName, Address, Age, Sex, Classification) 
				VALUES ('$report_id', '$name', '$address', '$age', '$sex', '$classification')";

			$result = mysqli_query($conn, $insert_query);

			if (!$result) {
				$all_insert_success = false;
				break;
			}
		}
	}

	if ($all_update_success && $all_insert_success) {
		echo "success";
	} else {
		if (!$all_update_success) {
			echo "Failed to update data. Error: " . mysqli_error($conn) . ". ";
		}
		if (!$all_insert_success) {
			echo "Failed to insert data. Error: " . mysqli_error($conn) . ". ";
		}
	}
?>
