<?php
include_once "php/config.php";

date_default_timezone_set('Asia/Manila');

$type = isset($_GET['type']) ? $_GET['type'] : '';
$date = isset($_GET['date']) && !empty($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$status = 'pending';

$sql = "SELECT ir.IncidentReportID, ir.ResponseStatus, ir.CreatedAt, ir.CreatedTime, it.IncidentTypeName, b.BarangayName
        FROM incident_report AS ir
        LEFT JOIN incident_type AS it ON ir.IncidentTypeID = it.IncidentTypeID
        LEFT JOIN barangay AS b ON ir.BarangayID = b.BarangayID
        WHERE ir.ResponseStatus = ?";

$params = [$status];

if (!empty($type)) {
    $sql .= " AND it.IncidentTypeName = ?";
    $params[] = $type;
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
                <td>{$row['ResponseStatus']}</td>
                <td>{$row['IncidentTypeName']}</td>
                <td>{$row['BarangayName']}</td>
                <td>{$row['CreatedAt']}</td>
              <td>{$row['CreatedTime']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No records found.";
}

$stmt->close();
$conn->close();
?>
