<?php
	include_once "php/config.php";

	date_default_timezone_set('Asia/Manila');

	$type = isset($_GET['type']) ? $_GET['type'] : '';
	$date = isset($_GET['date']) && !empty($_GET['date']) ? $_GET['date'] : date('Y-m-d');
	$status1 = 'ongoing';
	$status2 = 'resolved';


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

	$sql1 = "SELECT * FROM incident_report WHERE status = ?";
	$params1 = [$status1];

	if (!empty($type)) {
		$sql1 .= " AND incident_type = ?";
		$params1[] = $type;
	}

	if (!empty($date)) {
		$sql1 .= " AND event_at = ?";
		$params1[] = $date;
	}

	$stmt1 = $conn->prepare($sql1);
	$stmt1->bind_param(str_repeat('s', count($params1)), ...$params1);
	$stmt1->execute();
	$result1 = $stmt1->get_result();

	if ($result1->num_rows > 0) {
		while ($row = $result1->fetch_assoc()) {
			switch ($row['incident_type']) {
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

			$barangay = strtolower($row['barangay']);
			if (isset($incident_location[$barangay])) {
				$incident_location[$barangay] = 'blinking';
			}
		}
	}




	$sql2 = "SELECT * FROM incident_report WHERE status = ?";
	$params2 = [$status2];

	if (!empty($type)) {
		$sql2 .= " AND incident_type = ?";
		$params2[] = $type;
	}

	if (!empty($date)) {
		$sql2 .= " AND event_at = ?";
		$params2[] = $date;
	}

	$stmt2 = $conn->prepare($sql2);
	$stmt2->bind_param(str_repeat('s', count($params2)), ...$params2);
	$stmt2->execute();
	$result2 = $stmt2->get_result();

	if ($result2->num_rows > 0) {
		while ($row = $result2->fetch_assoc()) {
			switch ($row['incident_type']) {
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

			$barangay = strtolower($row['barangay']);
			if (isset($incident_location[$barangay]) && $incident_location[$barangay] !== 'blinking') {
				$incident_location[$barangay] = 'not-blinking';
			}
		}
	}

	echo json_encode(['incident_data' => $incident_data, 'incident_location' => $incident_location]);
?>
