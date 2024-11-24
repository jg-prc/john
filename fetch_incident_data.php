<?php
include_once "php/config.php";

date_default_timezone_set('Asia/Manila');

$type = isset($_GET['type']) ? $_GET['type'] : '';
$date = isset($_GET['date']) && !empty($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$status = 'pending';

$sql = "SELECT ir.IncidentReportID, ir.ResponseStatus
        FROM incident_report AS ir
        WHERE ir.ResponseStatus = ?";

$params = [$status];

if (!empty($type)) {
    $sql .= " AND it.IncidentTypeName = ?";
    $params[] = $type;
}
if (!empty($date)) {
    $sql .= " AND ir.CreatedAt = ?";
    $params[] = $date;
}

$stmt = $conn->prepare($sql);
$stmt->bind_param(str_repeat('s', count($params)), ...$params);
$stmt->execute();
$result = $stmt->get_result();

// Display the data
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>IncidentReportID</th>
                <th>ResponseStatus</th>
                <th>IncidentTypeName</th>
                <th>BarangayName</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['IncidentReportID']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No records found.";
}

$stmt->close();
$conn->close();
?>
