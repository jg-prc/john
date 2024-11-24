<?php
	include_once "php/config.php";

	date_default_timezone_set('Asia/Manila');

	$type = isset($_GET['type']) ? $_GET['type'] : '';
	$date = isset($_GET['date']) && !empty($_GET['date']) ? $_GET['date'] : date('Y-m-d');
	$status = 'pending';
	$status1 = 'ongoing';
	$status2 = 'resolved';
	$status3 = 'duplicated';

	$sql = "SELECT ir.IncidentReportID, ir.ResponseStatus, ir.CreatedAt, it.IncidentTypeName, b.BarangayName
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

	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			switch ($row['IncidentTypeName']) {
				case 'Vehicular Accident':
					$incident_data['Vehicular'] = 'blink';
					break;
				case 'Fire Incident':
					$incident_data['Fire'] = 'blink';
					break;
				case 'Flood Incident':
					$incident_data['Flood'] = 'blink';
					break;
				case 'Landslide Incident':
					$incident_data['Landslide'] = 'blink';
					break;
			}
		}
	}
	echo json_encode(['incident_data' => $incident_data, 'incident_location' => $incident_location]);

?>
