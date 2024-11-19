<?php
	session_start();
	include_once "config.php";

	$currentYear = date('Y');
	$autoIncrementValue = ($currentYear * 1000) + 1;

	$auto_increment_query = "ALTER TABLE barangay_officials AUTO_INCREMENT = $autoIncrementValue";

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
	$role = "1";

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // Check if email exists
    $sql = $conn->prepare("SELECT * FROM barangay_officials WHERE EmailAddress = ?");
    $sql->bind_param('s', $email);
    $sql->execute();
    $result = $sql->get_result();
    
    if ($result->num_rows > 0) {
        echo "This email already exists!";
        exit();
    } else {
        // Handle image upload securely
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $img_name = $_FILES['image']['name'];
            $img_size = $_FILES['image']['size'];
            $tmp_name = $_FILES['image']['tmp_name'];
            $img_ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));

            $allowed_extensions = ['jpeg', 'jpg', 'png'];
            if (in_array($img_ext, $allowed_extensions)) {
                // Validate MIME type
                $img_mime = mime_content_type($tmp_name);
                if (in_array($img_mime, ['image/jpeg', 'image/jpg', 'image/png'])) {
                    $new_img_name = uniqid("IMG-", true) . '.' . $img_ext;
                    $img_upload_path = 'profile/' . $new_img_name;

                    if (move_uploaded_file($tmp_name, $img_upload_path)) {
                        $image = $new_img_name;
                    } else {
                        echo "Failed to upload image.";
                        exit();
                    }
                } else {
                    echo "Invalid MIME type.";
                    exit();
                }
            } else {
                echo "Invalid file type. Only JPEG, JPG, and PNG are allowed.";
                exit();
            }
        }

        // Encrypt the password
        $encrypt_pass = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and execute the insertion query using prepared statements
        $insert_query = $conn->prepare("INSERT INTO barangay_officials 
            (UserTypeID, PositionID, BarangayID, FirstName, MiddleName, LastName, ExtensionName, ContactNumber, Birthdate, Status, Sex, Zone, EmailAddress, Password, ImageURL)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $insert_query->bind_param('iiissssssssssss', $role, $position, $barangay, $f_name, $m_name, $l_name, $e_name, $contact, $bdate, $status, $sex, $zone, $email, $encrypt_pass, $image);

        if ($insert_query->execute()) {
            echo "success";
        } else {
            echo "Failed to insert data. Please try again.";
        }
    }

    $sql->close();
} else {
    echo "Not a valid email!";
}

$conn->close();
?>
