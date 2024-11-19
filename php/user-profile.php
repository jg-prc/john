<?php
	session_start();
	include_once "config.php";

	$f_name = mysqli_real_escape_string($conn, $_POST['firstname']);
	$l_name = mysqli_real_escape_string($conn, $_POST['lastname']);
	$m_name = mysqli_real_escape_string($conn, $_POST['middlename']);
	$e_name = mysqli_real_escape_string($conn, $_POST['extensionname']);
	$bdate = mysqli_real_escape_string($conn, $_POST['bdate']);
	$sex = mysqli_real_escape_string($conn, $_POST['sex']);
	$contact = mysqli_real_escape_string($conn, $_POST['contact']);
	$barangay = mysqli_real_escape_string($conn, $_POST['barangay']);
	$zone = mysqli_real_escape_string($conn, $_POST['zone']);
	$position = mysqli_real_escape_string($conn, $_POST['position']);

	$unique_id = $_SESSION['unique_id'];

	$image = "";


	if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
		$img_name = $_FILES['image']['name'];
		$img_size = $_FILES['image']['size'];
		$tmp_name = $_FILES['image']['tmp_name'];
		$error = $_FILES['image']['error'];

		// Get the file extension and validate
		$img_explode = explode('.', $img_name);
		$img_ext = strtolower(end($img_explode));

		$allowed_extensions = ['jpeg', 'jpg', 'png'];
		if (in_array($img_ext, $allowed_extensions)) {
			$new_img_name = uniqid("IMG-", true) . '.' . $img_ext;
			$img_upload_path = 'image/' . $new_img_name;
			move_uploaded_file($tmp_name, $img_upload_path);

			$image = $new_img_name;
		} else {
			echo "Invalid file type. Only JPEG, JPG, and PNG are allowed.";
			exit();
		}
	}
	
	$query = "UPDATE barangay_officials SET 
		FirstName = '$f_name', 
		LastName = '$l_name', 
		MiddleName = '$m_name', 
		ExtensionName = '$e_name', 
		Birthdate = '$bdate', 
		Sex = '$sex', 
		ContactNumber = '$contact', 
		BarangayID = '$barangay', 
		Zone = '$zone', 
		PositionID = '$position'";

		if (!empty($image)) {
			$query .= ", ImageURL = '$image'";
		}

		$query .= " WHERE OfficialsID = $unique_id";

	$result = $conn->prepare($query);

	if ($result->execute()) {
		echo "success";
	} else {
		echo "Failed to update data. Please try again.";
	}
?>