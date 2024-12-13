<?php
include_once "config.php";

header('Content-Type: application/json');

if (isset($_GET['IncidentReportID'])) {
    $IncidentReportID = $conn->real_escape_string($_GET['IncidentReportID']);

    if (!is_numeric($IncidentReportID)) {
        echo json_encode(['error' => 'Invalid IncidentReportID']);
        exit;
    }

    $sql = "SELECT 
                ir.IncidentReportID, ir.ResponseStatus, ir.Zone, ir.Street, ir.UpdatedAt,
                it.IncidentTypeName, b.BarangayName, ir.OfficialsID, o.FirstName, o.LastName, 
                p.PositionName, f.FolderName, img.ImagesName
            FROM 
                incident_report AS ir
            LEFT JOIN 
                incident_type AS it ON ir.IncidentTypeID = it.IncidentTypeID
            LEFT JOIN 
                barangay_officials AS o ON ir.OfficialsID = o.OfficialsID
            LEFT JOIN 
                position AS p ON o.PositionID = p.PositionID
            LEFT JOIN 
                barangay AS b ON ir.BarangayID = b.BarangayID
            LEFT JOIN 
                folder_report AS f ON ir.IncidentReportID = f.FolderID
            LEFT JOIN 
                images AS img ON f.ImageID = img.ImagesID
            WHERE 
                ir.IncidentReportID = '$IncidentReportID'";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($rows);
    } else {
        echo json_encode(['error' => 'No data found']);
    }
} else {
    echo json_encode(['error' => 'No IncidentReportID provided']);
}
?>
