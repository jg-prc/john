<?php
header('Content-Type: application/json');
include 'config.php';

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['report_id']) && isset($input['status'])) {
    $report_id = $input['report_id'];
    $status = $input['status'];

    $stmt = $conn->prepare("UPDATE incident_report SET status = ? WHERE report_id = ?");
    $stmt->bind_param("si", $status, $report_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Status updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update status.']);
    }
}
?>
