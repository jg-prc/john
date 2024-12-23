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
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.0.7/dist/css/splide.min.css">
		<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.0.7/dist/js/splide.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<link rel="stylesheet" href="css/sidebar.css">
		<link rel="stylesheet" href="css/report.css">
		<link rel="icon" href="php/image/logo.png" type="image/png">
		<title>SAN JOSE INCIDENT RECORD  MANAGEMENT AND MAPPING SYSTEM</title>
		<style>

		</style>
	</head>
	<body>
		<div class="sidebar close">
			<div class="open-btn">
				<span class="openbtn">&#9776;</span>
			</div>
			<ul class="nav-links">
				<li>
					<a href="dashboard.php">
						<i class="fas fa-gauge"></i>
						<span class="link_name">Dashboard</span>
					</a>
					<ul class="sub-menu blank">
						<li><a class="link_name">Dashboard</a></li>
					</ul>
				</li>
				<li>
					<div class="iocn-link">
						<a href="#">
							<i class="fa fa-user-gear"></i>
							<span class="link_name">Account Management</span>
						</a>
						<i class="fas fa-chevron-down arrow"></i>
					</div>
					<ul class="sub-menu">
						<li><a class="link_name">Account Management</a></li>
						<li><a href="create.php">Create account</a></li>
						<li><a href="accounts.php">List of users</a></li>
						<li><a href="archive.php">Archived account</a></li>
					</ul>
				</li>
				<li class="active">
					<a href="report.php">
						<i class="fas fa-folder-open"></i>
						<span class="link_name">Report Management</span>
					</a>
					<ul class="sub-menu blank">
						<li><a class="link_name">Report Management</a></li>
					</ul>
				</li>
				<li>
					<a href="privacy.php">
						<i class="fas fa-shield-alt"></i>
						<span class="link_name">Privacy and Security</span>
					</a>
					<ul class="sub-menu blank">
						<li><a class="link_name">Privacy and Security</a></li>
					</ul>
				</li>
				<li>
					<div class="profile-details">
						<div class="profile-content">
							<img src="php/image/logo.png" alt="profileImg">
						</div>
						<div class="name-job">
							<div class="profile_name">Admin</div>
							<div class="job">Administrator</div>
						</div>
						<a href="#" id="logoutButton">
							<i class='fa fa-sign-out'></i>
						</a>
					</div>
				</li>
			</ul>
		</div>
		<div class="container">
			<div class="title">
				<img src="php/image/logo.png" alt="profileImg">
				<i class="fas fa-folder-open"></i>
				<i><strong>Reported Incidents</strong></i>
				<a id="generateLink" href="generate.php" target="_blank">Summarize</a>
			</div>

			<?php
				include_once "tools-report.php";
			?>
			<div class="card_container">
				<?php 
					include_once "php/config.php";

					$dataFound = false;

					$dateQuery = "SELECT DISTINCT CreatedAt FROM incident_report";

					$order_by = 'ORDER BY `CreatedAt` DESC';
					if ($sort_by == 'CreatedAt-asc') {
						$order_by = 'ORDER BY `CreatedAt` ASC';
					}

					$dateQuery .= " $order_by";

					$dateResult = $conn->query($dateQuery);

					if (!$dateResult) {
						die("Error fetching dates: " . $conn->error);
					}

					$eventDates = [];
					if ($dateResult->num_rows > 0) {
						while ($row = $dateResult->fetch_assoc()) {
							$eventDates[] = date("F j, Y", strtotime($row['CreatedAt']));
						}
					} else {
						echo "<div class='no-data'>No data found.</div>";
						return;
					}

					foreach ($eventDates as $eventDate) {
						$formattedDate = date("Y-m-d", strtotime($eventDate));
						$sql = "SELECT ir.IncidentReportID, ir.Zone, ir.Street, ir.CreatedAt, it.IncidentTypeName, b.BarangayName
							FROM incident_report AS ir
							LEFT JOIN incident_type AS it ON ir.IncidentTypeID = it.IncidentTypeID
							LEFT JOIN barangay AS b ON ir.BarangayID = b.BarangayID
							WHERE ir.CreatedAt = '$formattedDate' 
							AND (ResponseStatus = 'pending' OR ResponseStatus = 'resolved')";


						if (!empty($search)) {
							$search = str_ireplace(['Zone', ','], '', $search);
							$searchTerms = explode(' ', trim($search));
						} else {
							$searchTerms = [];
						}

						foreach ($searchTerms as $term) {
							$term = $conn->real_escape_string($term);
							$sql .= " AND (IncidentTypeName LIKE '%$term%' 
								OR Zone LIKE '%$term%' 
								OR BarangayName LIKE '%$term%')";
						}

						if (!empty($incident_type)) {
							$sql .= " AND IncidentTypeName = '" . $conn->real_escape_string($incident_type) . "'";
						}
						if (!empty($barangay)) {
							$sql .= " AND BarangayName = '" . $conn->real_escape_string($barangay) . "'";
						}

						$sql .= " ORDER BY CreatedTime DESC;";

						$reportResult = $conn->query($sql);

						if (!$reportResult) {
							die("Error fetching reports: " . $conn->error);
						}

						if ($reportResult->num_rows > 0) {
							$dataFound = true;

							echo "
								<div class='card-container'>
								<ul>
									<input type='checkbox' name='dates[]' value='$formattedDate'>
									<span class='date'>" . htmlspecialchars($eventDate) . "</span>
								</ul>
								<div class='card-grid'>
							";

							while ($row = $reportResult->fetch_assoc()) {
								$icon = '';
								switch ($row['IncidentTypeName']) {
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
								echo "
									<a class='card' href='report_file.php?report_id=" . $row['IncidentReportID'] . "'>
										<div class='image'>
											" . $icon . "
										</div>
										<div class='details'>
											<span class='type'>" . $row['IncidentTypeName'] . "</span>
											<span>Zone " . $row['Zone'] . " , " . $row['BarangayName'] . "</span>
										</div>
									</a>
								";
							}
							echo "</div></div>";
						}
					}
					if (!$dataFound) {
						echo "
							<div class='card-container'>
								<div class='card-grid'>
									<div class='card-nothing'>
										<span>No Data found</span>
									</div>
								</div>
							</div>
						";
					}
				?>
			</div>
		</div>
	</body>
	<script src="js/sidebar.js"></script>
	<script src="js/logout.js"></script>
	<script src="js/tools-report.js"></script>
	<script>
		const checkboxes = document.querySelectorAll("input[type='checkbox']");
		const generateLink = document.getElementById("generateLink");

		checkboxes.forEach((checkbox) => {
			checkbox.addEventListener("change", () => {
				const selectedDates = Array.from(checkboxes)
					.filter((checkbox) => checkbox.checked)
					.map((checkbox) => checkbox.value);

				const url = new URL(generateLink.href);
				url.searchParams.set('dates', selectedDates.join(','));
				generateLink.href = url.toString();

				updateButtonVisibility();
			});
		});

		const radios = document.querySelectorAll('input[type="radio"]');
		let lastCheckedRadio = null;

		function updateButtonVisibility() {
			const selectedRadio = document.querySelector('input[type="radio"]:checked');
			if (selectedRadio || Array.from(checkboxes).some((checkbox) => checkbox.checked)) {
				generateLink.style.display = 'inline-block';
			} else {
				generateLink.style.display = 'none';
			}
		}

		radios.forEach(radio => {
			radio.addEventListener('click', () => {
				if (radio === lastCheckedRadio) {
					radio.checked = false;
					lastCheckedRadio = null;
				} else {
					lastCheckedRadio = radio;
				}
				updateButtonVisibility();
			});
		});
		updateButtonVisibility();
	</script>
</html>
