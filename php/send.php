<?php
	session_start();
	include_once "config.php";

	$incident_type = mysqli_real_escape_string($conn, $_POST['incident_type']);
	$barangay = mysqli_real_escape_string($conn, $_POST['barangay']);
	$zone = mysqli_real_escape_string($conn, $_POST['zone']);
	$street = mysqli_real_escape_string($conn, $_POST['street']);

	$unique_id = $_SESSION['unique_id'];

	$status = "pending";

	$year = date("Y");
	$month = date("m");

	$targetDir = "uploads/$year/$month/";

	if (!is_dir($targetDir)) {
		mkdir($targetDir, 0777, true);
	}

	$totalFiles = count($_FILES['images']['name']);
	$uploadSuccess = true;

	$imagePaths = [];

	for ($i = 0; $i < $totalFiles; $i++) {
		$fileName = basename($_FILES['images']['name'][$i]);
		$img_ext = pathinfo($fileName, PATHINFO_EXTENSION);

		$new_img_name = uniqid("IMG-", true) . '.' . $img_ext;
		$targetFilePath = $targetDir . $new_img_name;

		if (move_uploaded_file($_FILES['images']['tmp_name'][$i], $targetFilePath)) {
			$imagePaths[] = $targetFilePath;
		} else {
			$uploadSuccess = false;
			break;
		}
	}

	if ($uploadSuccess) {

		$sql_incident = "INSERT INTO incident_report (status, incident_type, barangay, zone, street, user_id)
			VALUES ('$status', '$incident_type', '$barangay', '$zone', '$street', '$unique_id')";

		$stmt_incident = $conn->prepare($sql_incident);

if ($stmt_incident->execute()) {

    // Get the last inserted report ID
    $report_id = $conn->insert_id;

    // Update the incident_report table to set the ref_id equal to report_id
    $sql_update_ref = "UPDATE incident_report SET ref_id = '$report_id' WHERE report_id = $report_id";
    $stmt_update_ref = $conn->prepare($sql_update_ref);

    if ($stmt_update_ref->execute()) {
        // Insert the images related to the report
        foreach ($imagePaths as $imgPath) {
            // Save the relative file path
            $relativeFilePath = str_replace($_SERVER['DOCUMENT_ROOT'], '', $imgPath);
            $sql_image = "INSERT INTO image (file_path, ref_id) VALUES ('$relativeFilePath', '$report_id')";
            $stmt_image = $conn->prepare($sql_image);

            if (!$stmt_image->execute()) {
                echo "Failed to insert image.";
                exit;  // Stop further execution if there's a failure in image insertion
            }
        }

        echo "success";
    } else {
        echo "Failed to update ref_id.";
    }

} else {
    echo "Failed to insert incident report.";
}
	} else {
		echo "Image cannot be empty.";
	}
?>
