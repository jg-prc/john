<?php
include_once "config.php";

$stmt = $conn->prepare("SELECT * FROM incident_report ORDER BY event_at DESC");
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $icon = '';
        switch ($row['incident_type']) {
            case 'Vehicular Accident':
                $icon = '<i class="fas fa-car-crash"></i>';
                break;
            case 'Fire Incident':
                $icon = '<i class="fas fa-fire"></i>';
                break;
            case 'Flood Incident':
                $icon = '<i class="fas fa-house-flood-water"></i>';
                break;
            case 'Landslide Incident':
                $icon = '<i class="fas fa-hill-rockslide"></i>';
                break;
        }

        $statusClass = '';
        switch ($row['status']) {
            case 'pending':
                $statusClass = 'pending';
                break;
            case 'resolved':
                $statusClass = 'resolved';
                break;
            case 'ongoing':
                $statusClass = 'ongoing';
                break;
        }

        $eventDateTime = new DateTime($row['event_at']);
        $formattedTime = $eventDateTime->format('g:i a');

        echo "
        <li class='splide__slide'>
            $icon
            <div class='content'>
                <span class='type'>{$row['incident_type']}</span>
                <span>Zone {$row['zone']}, {$row['barangay']}</span>
                <span class='status {$statusClass}'>{$row['status']}</span>
            </div>
            <span class='time'>{$formattedTime}</span>
        </li>
        ";
    }
} else {
    echo "<li>No data found.</li>";
}
?>
