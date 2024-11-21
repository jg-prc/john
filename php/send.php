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
    $sql_incident = "INSERT INTO incident_report (OfficialsID, IncidentTypeID, BarangayID, ResponseStatus, Zone, Street)
        VALUES ('$unique_id', '$incident_type', '$barangay', '$status', '$zone', '$street')";

    // Echo the $sql_incident query
    echo "SQL Incident Query: " . $sql_incident . "<br>";

    if ($conn->query($sql_incident)) {
        $incident_id = $conn->insert_id;

        $folderName = $targetDir;
        $sql_folder = "INSERT INTO folder_report (FolderID, FolderName) VALUES ('$incident_id', '$folderName')";

        // Echo the $sql_folder query
        echo "SQL Folder Query: " . $sql_folder . "<br>";

        if ($conn->query($sql_folder)) {
            foreach ($imagePaths as $imagePath) {
                $sql_image = "INSERT INTO images (ImagesID, ImagesName) VALUES ('$incident_id', '$new_img_name')";

                // Echo the $sql_image query
                echo "SQL Image Query: " . $sql_image . "<br>";

                if (!$conn->query($sql_image)) {
                    echo "Failed to insert image.";
                    exit;
                }
            }
            echo "success";
        } else {
            echo "Failed to insert folder name.";
            exit;
        }
    } else {
        echo "Failed to insert incident report.";
    }
} else {
    echo "Image cannot be empty.";
}

?>
