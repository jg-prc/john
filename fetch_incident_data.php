<?php
	include_once "php/config.php";

	date_default_timezone_set('Asia/Manila');

	$type = isset($_GET['type']) ? $_GET['type'] : '';
	$date = isset($_GET['date']) && !empty($_GET['date']) ? $_GET['date'] : date('Y-m-d');
	$status = 'pending';
	$status1 = 'ongoing';
	$status2 = 'resolved';
	$status3 = 'duplicated';

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

	// Function to execute query
	function executeQuery($conn, $status, $type, $date) {
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
		return $stmt->get_result();
	}

	// Query execution for each status
	$result = executeQuery($conn, $status, $type, $date);
	while ($row = $result->fetch_assoc()) {
		switch ($row['IncidentTypeName']) {
			case 'Vehicular Accident': $incident_data['Vehicular'] = 'blink'; break;
			case 'Fire Incident': $incident_data['Fire'] = 'blink'; break;
			case 'Flood Incident': $incident_data['Flood'] = 'blink'; break;
			case 'Landslide Incident': $incident_data['Landslide'] = 'blink'; break;
		}
	}

	$result1 = executeQuery($conn, $status1, $type, $date);
	while ($row = $result1->fetch_assoc()) {
		$barangay = strtolower($row['BarangayName']);
		if (isset($incident_location[$barangay])) {
			$incident_location[$barangay] = 'blinking';
		}
	}

	$result2 = executeQuery($conn, $status2, $type, $date);
	while ($row = $result2->fetch_assoc()) {
		$incident_data = handleStatus($row, $incident_data, 'not-blink');
		$barangay = strtolower($row['BarangayName']);
		if (isset($incident_location[$barangay]) && $incident_location[$barangay] !== 'blinking') {
			$incident_location[$barangay] = 'not-blinking';
		}
	}

	$result3 = executeQuery($conn, $status3, $type, $date);
	while ($row = $result3->fetch_assoc()) {
		$incident_data = handleStatus($row, $incident_data, '');
	}

	// Function to handle status changes
	function handleStatus($row, $incident_data, $status) {
		switch ($row['IncidentTypeName']) {
			case 'Vehicular Accident':
				if (!in_array($incident_data['Vehicular'], ['blink', 'not-blink'])) {
					$incident_data['Vehicular'] = $status;
				}
				break;
			case 'Fire Incident':
				if (!in_array($incident_data['Fire'], ['blink', 'not-blink'])) {
					$incident_data['Fire'] = $status;
				}
				break;
			case 'Flood Incident':
				if (!in_array($incident_data['Flood'], ['blink', 'not-blink'])) {
					$incident_data['Flood'] = $status;
				}
				break;
			case 'Landslide Incident':
				if (!in_array($incident_data['Landslide'], ['blink', 'not-blink'])) {
					$incident_data['Landslide'] = $status;
				}
				break;
		}
		return $incident_data;
	}

	echo json_encode(['incident_data' => $incident_data, 'incident_location' => $incident_location]);
?>
