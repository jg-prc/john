<?php
session_start();
header('Content-Type: application/json');

// Database connection details
$hostname = "mysql.hostinger.com";
$username = "new";
$password = "Root_root01";
$dbname = "u412427249_capstone";

// Establish database connection
$conn = mysqli_connect($hostname, $username, $password, $dbname);
if (!$conn) {
    echo json_encode(["status" => "error", "message" => "Database connection error: " . mysqli_connect_error()]);
    exit;
}

// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if POST data is set
if (!isset($_POST['email']) || !isset($_POST['password'])) {
    echo json_encode(["status" => "error", "message" => "Email or password not provided."]);
    exit;
}

$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Prepare SQL query
$sql = mysqli_query($conn, "
    SELECT user_id AS id, email, password, status, 'user' AS role FROM user WHERE email = '{$email}'
    UNION ALL
    SELECT admin_id AS id, email, password, status, 'admin' AS role FROM admin WHERE email = '{$email}'
");

if (!$sql) {
    echo json_encode(["status" => "error", "message" => "SQL query failed: " . mysqli_error($conn)]);
    exit;
}

// Check if the query returned any results
if (mysqli_num_rows($sql) > 0) {
    $row = mysqli_fetch_assoc($sql);

    // Check if the account is active
    if ($row['status'] === 'active') {
        // Verify the password using the hashed password stored in the database
        if (password_verify($password, $row['password'])) {
            $_SESSION['unique_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];

            echo json_encode(["status" => "success", "role" => $row['role']]);
        } else {
            echo json_encode(["status" => "error", "message" => "Incorrect Password!"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Your account has been deactivated."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "This email doesn't exist!"]);
}

?>
