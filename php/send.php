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
// Enable error reporting during debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Use prepared statements for secure queries
try {
    // Insert into `incident_report`
    $sql_incident = "INSERT INTO incident_report (BarangayID, OfficialsID, IncidentTypeID, ResponseStatus, Zone, Street)
                     VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_incident = $conn->prepare($sql_incident);
    $stmt_incident->bind_param("ssssss", $barangay, $unique_id, $incident_type, $status, $zone, $street);

    if ($stmt_incident->execute()) {

        $incident_id = $stmt_incident->insert_id;

        // Insert into `folder_report`
        $sql_folder = "INSERT INTO folder_report (FolderID, FolderName) VALUES (?, ?)";
        $stmt_folder = $conn->prepare($sql_folder);
        $stmt_folder->bind_param("is", $incident_id, $targetDir);

        if ($stmt_folder->execute()) {
            // Insert images
            $sql_image = "INSERT INTO images (ImagesID, ImagesName) VALUES (?, ?)";
            $stmt_image = $conn->prepare($sql_image);

            foreach ($imagePaths as $imagePath) {
                $stmt_image->bind_param("is", $incident_id, $imagePath);
                if (!$stmt_image->execute()) {
                    echo "Failed to insert image: " . $stmt_image->error;
                    exit;
                }
            }

            echo "success";
        } else {
            echo "Failed to insert folder name: " . $stmt_folder->error;
            exit;
        }
    } else {
        echo "Failed to insert incident report: " . $stmt_incident->error;
        exit;
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit;
}

	} else {
		echo "Image cannot be empty.";
	}
?>
