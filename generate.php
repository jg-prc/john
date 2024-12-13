<?php
	session_start();
	if (!isset($_SESSION['unique_id']) || $_SESSION['role'] !== '2') {
		header("Location: index.php");
		exit();
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
		<link rel="stylesheet" href="css/generate.css">
		<link rel="icon" href="php/image/logo.png" type="image/png">
		<title>SAN JOSE INCIDENT RECORD MANAGEMENT AND MAPPING SYSTEM</title>
	</head>
	<body>
		<div class="container">
			<div class="header-container">
				<div class="logo-content">
					<img src="php/image/logo.png" alt="Profile Image">
				</div>
				<div>
					<h2>SAN JOSE INCIDENT RECORD MANAGEMENT AND MAPPING SYSTEM</h2>
					<i>San Jose, Camarines Sur</i>
				</div>
				<button id="button">Generate PDF</button>
			</div>
			<div class="body-container">
				<div class='content'>
					<div class='card' id='makepdf'>
					<?php
						include_once "php/config.php";
						$dates = isset($_GET['dates']) ? $_GET['dates'] : '';
						$dateArray = explode(',', $dates);

						$validDates = array_filter($dateArray, function($date) {
							return preg_match('/^\d{4}-\d{2}-\d{2}$/', $date);
						});

						if (!empty($validDates)) {

							$placeholders = implode(',', array_fill(0, count($validDates), '?'));

							$sql = "SELECT ir.IncidentReportID, b.BarangayName, it.IncidentTypeName,
									ir.CreatedAt, ir.CreatedTime, ir.Status, ir.ResponseStatus
									FROM incident_report AS ir
									LEFT JOIN incident_type AS it ON ir.IncidentTypeID = it.IncidentTypeID
									LEFT JOIN barangay AS b ON ir.BarangayID = b.BarangayID
									WHERE ir.CreatedAt IN ($placeholders) AND (ResponseStatus = 'pending' OR ResponseStatus = 'resolved')";

							if ($stmt = mysqli_prepare($conn, $sql)) {

								$types = str_repeat('s', count($validDates));
								mysqli_stmt_bind_param($stmt, $types, ...$validDates);

								mysqli_stmt_execute($stmt);

								$result = mysqli_stmt_get_result($stmt);

								if (mysqli_num_rows($result) > 0) {
									$rowCount = 0;

									while ($row = mysqli_fetch_assoc($result)) {

										$originalTime = $row['CreatedTime'];
										$formattedTime = date('H:i', strtotime($originalTime));

										$originalDate = $row['CreatedAt'];
										$formattedDate = date('m/d/Y', strtotime($originalDate));

										if ($rowCount % 6 === 0) {
											if ($rowCount > 0) {
												echo "</tbody></table></div>
												<footer>
													<span>All Rights Reserved © 2024 Municipal Disaster Risk Reduction and Management Office-San Jose</span>
												</footer></div>";
											}
											echo "<div clas='data'><div class='header-content'>
												<div class='logo'>
													<img src='php/image/logo1.png' alt='Logo 1'>
												</div>
												<div class='details'>
													<span>Republic of the Philippines</span>
													<span>Province of Camarines Sur</span>
													<span>Municipality of San Jose</span>
												</div>
												<div class='logo'>
													<img src='php/image/logo.png' alt='Logo 2'>
												</div>
											</div>";
											echo "<h3>MUNICIPAL DISASTER RISK REDUCTION AND MANAGEMENT OFFICE - SAN JOSE</h3>";
											echo "<div class='table'><table>
												<thead>
													<tr>
														<th class='municipality'>CITY/ MUNICIPALITY</th>
														<th class='barangay'>BARANGAY</th>
														<th class='type'>TYPE OF INCIDENT</th>
														<th class='date'>DATE OF OCCURRENCE [mm/dd/yyyy]</th>
														<th class='time'>TIME OF OCCURRENCE [24:00]</th>
														<th class='description'>DESCRIPTION</th>
														<th class='action'>ACTIONS TAKEN</th>
														<th class='remarks'>REMARKS</th>
														<th class='status'>STATUS (for flooded areas)</th>
													</tr>
												</thead>
											<tbody>";
										}
										echo "<tr>";
											echo "<td class='municipality'>San Jose</td>";
											echo "<td class='barangay' contenteditable='true'>" . htmlspecialchars($row['BarangayName']) . "</td>";
											echo "<td class='type' contenteditable='true'>" . htmlspecialchars($row['IncidentTypeName']) . "</td>";
											echo "<td class='date' contenteditable='true'>$formattedDate</td>";
											echo "<td class='time' contenteditable='true'>$formattedTime</td>";
											echo "<td class='description' contenteditable='true'></td>";
											echo "<td class='action' contenteditable='true'></td>";
											echo "<td class='remarks' contenteditable='true'></td>";
											echo "<td class='status' contenteditable='true'>" . htmlspecialchars($row['Status']) . "</td>";
										echo "</tr>";
										$rowCount++;
									}
							echo "</tbody></table></div>
								<footer>
									<span>All Rights Reserved © 2024 Municipal Disaster Risk Reduction and Management Office-San Jose</span>
								</footer></div>";
								} else {
									echo "<p>No data available.</p>";
								}
							} else {
								echo "<p>Error with SQL query.</p>";
							}
						} else {
							echo "<p>Invalid or no dates provided.</p>";
						}
					?>
				</div>
			</div>
		</div>
	</body>
	<script src="js/pdf.js"></script>
	<script src="js/create&move.js"></script>
	<script>
	</script>
</html>
