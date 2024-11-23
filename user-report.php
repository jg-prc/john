<?php
	session_start();
	if (!isset($_SESSION['unique_id']) || $_SESSION['role'] !== '1') {
		header("Location: index.php");
		exit();
	}
	$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'CreatedAt-desc';
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.css">
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
		<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
		<link rel="stylesheet" href="css/sidebar-user.css">
		<link rel="stylesheet" href="css/user-report.css">
		<link rel="icon" href="php/image/logo.png" type="image/png">
		<title>SAN JOSE INCIDENT RECORD  MANAGEMENT AND MAPPING SYSTEM</title>
	</head>
	<body>
		<div class="sidebar close">
			<div class="open-btn">
				<span class="openbtn">&#9776;</span>
			</div>
			<ul class="nav-links">
				<li>
					<div class="iocn-link">
						<a href="user-dashboard.php">
							<i class="fas fa-gauge"></i>
							<span class="link_name">Dashboard</span>
						</a>
					</div>
					<ul class="sub-menu blank">
						<li><a class="link_name">Dashboard</a></li>
					</ul>
				</li>
				<li>
					<a href="user-send.php">
						<i class="fas fa-paper-plane"></i>
						<span class="link_name">Send Report</span>
					</a>
					<ul class="sub-menu blank">
						<li><a class="link_name">Send Report</a></li>
					</ul>
				</li>
				<li class="active">
					<a href="user-report.php">
						<i class="fas fa-archive"></i>
						<span class="link_name">History</span>
					</a>
					<ul class="sub-menu blank">
						<li><a class="link_name">History</a></li>
					</ul>
				</li>
				<li>
					<a href="user-profile.php">
						<i class="fas fa-circle-user"></i>
						<span class="link_name">Profile</span>
					</a>
					<ul class="sub-menu blank">
						<li><a class="link_name">Profile</a></li>
					</ul>
				</li>
				<li>
					<a href="user-privacy.php">
						<i class="fas fa-shield-alt"></i>
						<span class="link_name">Privacy and Security</span>
					</a>
					<ul class="sub-menu blank">
						<li><a class="link_name">Privacy and Security</a></li>
					</ul>
				</li>
				<li class="logout">
					<a href="#" id="logoutButton">
						<i class="fas fa-sign-out"></i>
						<span class="link_name">Log-out</span>
					</a>
					<ul class="sub-menu blank">
						<li><a class="link_name">Log-out</a></li>
					</ul>
				</li>
			</ul>
		</div>
		<div class="container">
			<div class="title">
				<img src="php/image/logo.png" alt="profileImg">
				<i class="fas fa-archive"></i>
				<i>History</i>
			</div>
			<div class="tools">
				<div class="dropdown-button">
					<button onclick="toggleSortOrder()">
						<i class="fa fa-arrow-up-short-wide" id="sort-icon"></i>
						<label>Sort</label>
					</button>
				</div>
			</div>
			<div class="card_container">
				<?php 
					include_once "php/config.php";
					$user_id = $_SESSION['unique_id'];

					$dateQuery = "
						SELECT DISTINCT CreatedAt 
						FROM incident_report 
						WHERE OfficialsID = $user_id
					";

					$order_by = "ORDER BY `CreatedAt` DESC";
					if ($sort_by === 'CreatedAt-asc') {
						$order_by = "ORDER BY `CreatedAt` ASC";
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
						$formattedDate = $conn->real_escape_string(date("Y-m-d", strtotime($eventDate)));
						$sql = "
							SELECT 
								ir.IncidentReportID, 
								ir.Zone, 
								ir.Street,
								ir.CreatedTime,
								it.IncidentTypeName, 
								b.BarangayName
							FROM 
								incident_report AS ir
							LEFT JOIN 
								incident_type AS it ON ir.IncidentTypeID = it.IncidentTypeID
							LEFT JOIN 
								barangay AS b ON ir.BarangayID = b.BarangayID
							WHERE 
								ir.CreatedAt = '$formattedDate' 
								AND ir.OfficialsID = $user_id
							ORDER BY 
								ir.CreatedTime DESC
						";

						$reportResult = $conn->query($sql);

						if (!$reportResult) {
							die("Error fetching reports: " . $conn->error);
						}

						echo "<div class='card-container'>";
						echo "<span class='date'>" . htmlspecialchars($eventDate) . "</span>";
						echo "<div class='card-grid'>";

						if ($reportResult->num_rows > 0) {
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
									<a class='card' onclick=\"showForm(" . (int)$row['IncidentReportID'] . ")\">
										<div class='image'>
											$icon
										</div>
										<div class='details'>
											<span class='type'>" . htmlspecialchars($row['IncidentTypeName']) . "</span>
											<span>Zone " . htmlspecialchars($row['Zone']) . " , " . htmlspecialchars($row['BarangayName']) . "</span>
										</div>
									</a>
								";
							}
						} else {
							echo "<div class='no-data'>No reports available for " . htmlspecialchars($eventDate) . ".</div>";
						}
						echo "</div></div>";
					}
				?>
			</div>
		</div>
	</body>
	<script src="js/sidebar.js"></script>
	<script src="js/logout.js"></script>
	<script src="js/dashboard-user.js"></script>
	<script>
		function toggleSortOrder() {
			const urlParams = new URLSearchParams(window.location.search);
			const sortIcon = document.getElementById('sort-icon');
			let currentSortOrder = urlParams.get('sort_by');

			if (!currentSortOrder || currentSortOrder === 'CreatedAt-desc') {
				urlParams.set('sort_by', 'CreatedAt-asc');
				sortIcon.classList.replace('fa-arrow-up-short-wide', 'fa-arrow-down-short-wide');
			} else {
				urlParams.set('sort_by', 'CreatedAt-desc');
				sortIcon.classList.replace('fa-arrow-down-short-wide', 'fa-arrow-up-short-wide');
			}

			window.location.search = urlParams.toString();
		}

		window.onload = function() {
			const urlParams = new URLSearchParams(window.location.search);
			const sortIcon = document.getElementById('sort-icon');
			let currentSortOrder = urlParams.get('sort_by');

			if (currentSortOrder === 'CreatedAt-asc') {
				sortIcon.classList.replace('fa-arrow-up-short-wide', 'fa-arrow-down-short-wide');
			} else {
				sortIcon.classList.replace('fa-arrow-down-short-wide', 'fa-arrow-up-short-wide');
			}
		}
	</script>
</html>







