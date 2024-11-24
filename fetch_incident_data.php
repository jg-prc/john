<?php
	include_once "php/config.php";

	date_default_timezone_set('Asia/Manila');

	$type = isset($_GET['type']) ? $_GET['type'] : '';
	$date = isset($_GET['date']) && !empty($_GET['date']) ? $_GET['date'] : date('Y-m-d');
	$status = 'pending';
	$status1 = 'ongoing';
	$status2 = 'resolved';
	$status3 = 'duplicated';

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

	$sql1 = "SELECT ir.IncidentReportID, ir.ResponseStatus, it.IncidentTypeName, b.BarangayName
		FROM incident_report AS ir
		LEFT JOIN incident_type AS it ON ir.IncidentTypeID = it.IncidentTypeID
		LEFT JOIN barangay AS b ON ir.BarangayID = b.BarangayID
		WHERE ir.ResponseStatus = ?";

	$params1 = [$status1];

	if (!empty($type)) {
		$sql1 .= " AND it.IncidentTypeName = ?";
		$params1[] = $type;
	}

	if (!empty($date)) {
		$sql1 .= " AND ir.CreatedAt = ?";
		$params1[] = $date;
	}

	$stmt1 = $conn->prepare($sql1);
	$stmt1->bind_param(str_repeat('s', count($params1)), ...$params1);
	$stmt1->execute();
	$result1 = $stmt1->get_result();

	if ($result1->num_rows > 0) {
		while ($row = $result1->fetch_assoc()) {
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

			$barangay = strtolower($row['BarangayName']);
			if (isset($incident_location[$barangay])) {
				$incident_location[$barangay] = 'blinking';
			}
		}
	}




	$sql2 = "SELECT ir.IncidentReportID, ir.ResponseStatus, it.IncidentTypeName, b.BarangayName
		FROM incident_report AS ir
		LEFT JOIN incident_type AS it ON ir.IncidentTypeID = it.IncidentTypeID
		LEFT JOIN barangay AS b ON ir.BarangayID = b.BarangayID
		WHERE ir.ResponseStatus = ?";
	$params2 = [$status2];

	if (!empty($type)) {
		$sql2 .= " AND it.IncidentTypeName = ?";
		$params2[] = $type;
	}

	if (!empty($date)) {
		$sql2 .= " AND ir.CreatedAt = ?";
		$params2[] = $date;
	}

	$stmt2 = $conn->prepare($sql2);
	$stmt2->bind_param(str_repeat('s', count($params2)), ...$params2);
	$stmt2->execute();
	$result2 = $stmt2->get_result();

	if ($result2->num_rows > 0) {
		while ($row = $result2->fetch_assoc()) {
			switch ($row['IncidentTypeName']) {
				case 'Vehicular Accident':
					if ($incident_data['Vehicular'] !== 'blink') {
						$incident_data['Vehicular'] = 'not-blink';
					}
					break;
				case 'Fire Incident':
					if ($incident_data['Fire'] !== 'blink') {
						$incident_data['Fire'] = 'not-blink';
					}
					break;
				case 'Flood Incident':
					if ($incident_data['Flood'] !== 'blink') {
						$incident_data['Flood'] = 'not-blink';
					}
					break;
				case 'Landslide Incident':
					if ($incident_data['Landslide'] !== 'blink') {
						$incident_data['Landslide'] = 'not-blink';
					}
					break;
			}

			$barangay = strtolower($row['BarangayName']);
			if (isset($incident_location[$barangay]) && $incident_location[$barangay] !== 'blinking') {
				$incident_location[$barangay] = 'not-blinking';
			}
		}
	}






	$sql3 = "SELECT ir.IncidentReportID, ir.ResponseStatus, it.IncidentTypeName, b.BarangayName
		FROM incident_report AS ir
		LEFT JOIN incident_type AS it ON ir.IncidentTypeID = it.IncidentTypeID
		LEFT JOIN barangay AS b ON ir.BarangayID = b.BarangayID
		WHERE ir.ResponseStatus = ?";
	$params3 = [$status3];

	if (!empty($type)) {
		$sql3 .= " AND it.IncidentTypeName = ?";
		$params3[] = $type;
	}

	if (!empty($date)) {
		$sql3 .= " AND ir.CreatedAt = ?";
		$params3[] = $date;
	}

	$stmt3 = $conn->prepare($sql3);
	$stmt3->bind_param(str_repeat('s', count($params3)), ...$params3);
	$stmt3->execute();
	$result3 = $stmt3->get_result();

	if ($result3->num_rows > 0) {
		while ($row = $result3->fetch_assoc()) {
			switch ($row['IncidentTypeName']) {
				case 'Vehicular Accident':

					if ($incident_data['Vehicular'] !== 'blink' && $incident_data['Vehicular'] !== 'not-blink') {
						$incident_data['Vehicular'] = '';
					}
					break;
				case 'Fire Incident':
					if ($incident_data['Fire'] !== 'blink' && $incident_data['Fire'] !== 'not-blink') {
						$incident_data['Fire'] = '';
					}
					break;
				case 'Flood Incident':
					if ($incident_data['Flood'] !== 'blink' && $incident_data['Flood'] !== 'not-blink') {
						$incident_data['Flood'] = '';
					}
					break;
				case 'Landslide Incident':
					if ($incident_data['Landslide'] !== 'blink' && $incident_data['Landslide'] !== 'not-blink') {
						$incident_data['Landslide'] = '';
					}
					break;
			}
		}
	}
	echo json_encode(['incident_data' => $incident_data, 'incident_location' => $incident_location]);
?>