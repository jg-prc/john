<?php
	session_start();
	include_once "config.php";

	if (isset($_GET['user_id'])) {
		$user_id = $conn->real_escape_string($_GET['user_id']);
		$incident_type = mysqli_real_escape_string($conn, $_POST['incident_type']);
		$barangay = mysqli_real_escape_string($conn, $_POST['barangay']);
		$zone = mysqli_real_escape_string($conn, $_POST['zone']);
		$street = mysqli_real_escape_string($conn, $_POST['street']);
    
		$year = date("Y");
		$month = date("m");

		$uploadDir = "uploads/$year/$month/";

		// Create upload directory if it doesn't exist
		if (!is_dir($uploadDir)) {
			mkdir($uploadDir, 0777, true);
		}

		// Loop through each uploaded file
		foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
			$image_id = substr(md5(uniqid(rand(), true)), 0, 10); // Generate a new image_id per file
			$fileName = basename($_FILES['images']['name'][$key]);
			$fileTmp = $_FILES['images']['tmp_name'][$key];
			$filePath = $uploadDir . uniqid() . "-" . $fileName;

			// Move uploaded file to the desired directory
			if (move_uploaded_file($fileTmp, $filePath)) {
				
				// Insert into image table
				$sql_image = "INSERT INTO image (image_id, file_path) VALUES ('$image_id', '$filePath')";
				$result1 = $conn->prepare($sql_image);

				if ($result1->execute()) {
					
					$sql = "INSERT INTO incident_report (incident_type, barangay, zone, street, image_id, user_id) 
						VALUES ('$incident_type', '$barangay', '$zone', '$street', '$image_id', '$user_id')";
					$result2 = $conn->prepare($sql);

					if ($result2->execute()) {
						echo json_encode(['success' => false, 'error' => 'Failed to insert incident report']);
					} else {
						echo json_encode(['success' => false, 'error' => 'Failed to insert image']);
					}
				} else {
					echo json_encode(['success' => false, 'error' => 'Failed to upload file']);
				}
			} else {
				echo json_encode(['success' => false, 'error' => 'No files uploaded']);
			}
		}
	} else {
		echo json_encode(['success' => false, 'error' => 'Invalid user']);
	}
?>
