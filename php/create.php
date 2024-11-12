<?php
	session_start();
	include_once "config.php";

	$currentYear = date('Y');
	$autoIncrementValue = ($currentYear * 1000) + 1;

	$auto_increment_query = "ALTER TABLE user AUTO_INCREMENT = $autoIncrementValue";

	$conn->query($auto_increment_query);

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
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);

	$image = "default_image.png"; // Default image if no file is uploaded
	$status = "active";
	$role = "user";

	// Proceed with email validation and the rest of the script if no errors
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$sql = mysqli_query($conn, "SELECT * FROM user WHERE email = '{$email}'");
		if (mysqli_num_rows($sql) > 0) {
			echo "This email already exists!";
			exit();
		} else {
			// Handle image upload
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
			$encrypt_pass = password_hash($password, PASSWORD_DEFAULT);

		
			$insert_query = mysqli_query($conn, "INSERT INTO user (role, first_name, last_name, middle_name, extension_name, birthdate, sex, contact_no, barangay, zone, position, email, password, image, status)
			VALUES ('{$role}', '{$f_name}', '{$l_name}', '{$m_name}', '{$e_name}', '{$bdate}', '{$sex}', '{$contact}', '{$barangay}', '{$zone}', '{$position}', '{$email}', '{$encrypt_pass}', '{$image}', '{$status}')");

			if ($insert_query) {
				echo "success";
			} else {
				echo "Failed to insert data. Please try again.";
			}
		}
	} else {
		echo "Not a valid email!";
	}
?>
