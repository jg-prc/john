<?php
session_start();

// Log errors to a custom log file
ini_set("log_errors", 1);
ini_set("error_log", __DIR__ . "/error_log.log");

header('Content-Type: application/json'); // Set proper response headers

$hostname = "localhost";
$username = "new";
$password = "Root_root01";
$dbname = "u412427249_capstone";

$conn = mysqli_connect($hostname, $username, $password, $dbname);

if (!$conn) {
    error_log("Database connection error: " . mysqli_connect_error());
    echo json_encode(["status" => "error", "message" => "Database connection failed."]);
    exit; // Stop further execution
}

$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

$sql_query = "
    SELECT OfficialsID AS id, EmailAddress, Password, Status, '1' AS UserTypeID FROM barangay_officials WHERE EmailAddress = '{$email}'
    UNION ALL
    SELECT ChiefID AS id, EmailAddress, Password, Status, '2' AS UserTypeID FROM mdrrmo_chief WHERE EmailAddress = '{$email}'
";

$sql = mysqli_query($conn, $sql_query);

if (!$sql) {
    error_log("MySQL Error: " . mysqli_error($conn) . " | Query: " . $sql_query);
    echo json_encode(["status" => "error", "message" => "An error occurred while processing your request. Please try again later."]);
    mysqli_close($conn);
    exit; // Stop further execution
}

if (mysqli_num_rows($sql) > 0) {
    $row = mysqli_fetch_assoc($sql);

    if ($row['Status'] === 'active') {
        if (password_verify($password, $row['Password'])) {
            $_SESSION['unique_id'] = $row['id'];
            $_SESSION['role'] = $row['UserTypeID'];

            echo json_encode(["status" => "success", "role" => $row['UserTypeID']]);
        } else {
            echo json_encode(["status" => "error", "message" => "Incorrect Password!"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Your account has been deactivated."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "This email doesn't exist!"]);
}

mysqli_close($conn);
exit; // Ensure the script stops after sending the response
