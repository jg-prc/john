<?php
	include_once "php/config.php";
	date_default_timezone_set('Asia/Manila');

	$type = isset($_GET['type']) ? $_GET['type'] : '';
	$date = isset($_GET['date']) && !empty($_GET['date']) ? $_GET['date'] : date('Y-m-d');

	$statuses = ['pending', 'resolved'];
	$incident_data = [
		'Vehicular' => '',
		'Fire' => '',
		'Flood' => '',
		'Landslide' => ''
	];
	$incident_location = [
		'adiangao' => '', 'bagacay' => '', 'bahay' => '', 'boclod' => '', 'calalahan' => '',
		'calawit' => '', 'camagong' => '', 'catalotoan' => '', 'danlog' => '', 'del carmen' => '',
		'dolo' => '', 'kinalansan' => '', 'mampirao' => '', 'manzana' => '', 'minoro' => '',
		'palale' => '', 'ponglon' => '', 'pugay' => '', 'sabang' => '', 'salogon' => '',
		'san antonio' => '', 'san juan' => '', 'san vicente' => '', 'santa cruz' => '', 
		'soledad' => '', 'tagas' => '', 'tambangan' => '', 'telegrafo' => '', 'tominawog' => ''
	];

	function fetch_incidents($conn, $status, $type, $date, &$incident_data, &$incident_location, $blinkType) {
		$sql = "SELECT ir.IncidentReportID, ir.ResponseStatus, it.IncidentTypeName, b.BarangayName
				FROM incident_report AS ir
				LEFT JOIN incident_type AS it ON ir.IncidentTypeID = it.IncidentTypeID
				LEFT JOIN barangay AS b ON ir.BarangayID = b.BarangayID
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

		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$incidentName = match ($row['IncidentTypeName']) {
					'Vehicular Accident' => 'Vehicular',
					'Fire Incident' => 'Fire',
					'Flood Incident' => 'Flood',
					'Landslide Incident' => 'Landslide',
					default => null
				};
				if ($incidentName) {
					$incident_data[$incidentName] = $blinkType;
				}

				$barangay = strtolower($row['BarangayName']);
				if (isset($incident_location[$barangay])) {
					$incident_location[$barangay] = $blinkType === 'blink' ? 'blinking' : 'not-blinking';
				}
			}
		}
		$stmt->close();
	}

	// Fetch incidents for each status with appropriate blink settings
	fetch_incidents($conn, $statuses[0], $type, $date, $incident_data, $incident_location, 'blink');       // Ongoing
	fetch_incidents($conn, $statuses[1], $type, $date, $incident_data, $incident_location, 'not-blink');   // Resolved

	echo json_encode(['incident_data' => $incident_data, 'incident_location' => $incident_location]);
?>
