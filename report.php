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
		<link rel="icon" href="php/image/logo.png" type="image/png">
		<title>SAN JOSE INCIDENT RECORD  MANAGEMENT AND MAPPING SYSTEM</title>
		<style>
			body::-webkit-scrollbar {
				display: none;
			}
			.container {
				background-color: #f2f5f7;
				height: 100vh;
			}
			.container .title {
				font-size: 32px;
				padding-top: 10px;
				padding-bottom: 10px;
				padding-left: 80px;
				background-color: #88B3DA;
				color: #fff;
				display: flex;
				align-items: center;
				gap: 10px;
			}
			.title img {
				width: 75px;
			}

			.tools {
				position: relative;
				left: 15%;
				top: 30px;
				width: 1100px;
				display: flex;
				align-items: center;
				justify-content: space-between;
			}
			.search-box {
				display: flex;
				align-items: center;
				width: 400px;
				border-radius: 20px;
				box-shadow: 0 0 40px rgba(0, 0, 0, 0.12);
				background-color: #ffffff;
			}
			.search-box input {
				width: 100%;
				padding: 10px 10px 10px 30px;
				border: none;
				outline: none;
				background: transparent;
				font-size: 16px;
			}
			i.fa-magnifying-glass {
				position: relative;
				left: 4%;
				font-size: 16px;
			}



			.dropdown-container {
				width: 300px;
			}
			.dropdown-button {
				display: flex;
				justify-content: flex-end;
				gap: 10px;
			}
			.dropdown-button button {
				background-color: #6A8BB4;
				color: #fff;
				padding: 10px 20px;
				border-radius: 20px;
				font-weight: bold;
				box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
				display: flex;
				align-items: center;
				gap: 8px;
				border: none;
				transition: background-color 0.3s, transform 0.2s;
			}
			.dropdown-button button:hover {
				background-color: #5a7aa2;
				transform: translateY(-2px);
			}
			.dropdown-button button label,
			.dropdown-button button i {
				cursor: pointer;
			}
			.filter-container {
				width: 300px;
				border: 1px solid #D0D4D9;
				border-radius: 8px;
				display: none;
				margin-top: 10px;
				position: absolute;
				z-index: 1;
				background-color: #F9FBFD; /* Light background */
				box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
			}

			.filter-container span {
				font-size: 16px;
				font-weight: 600;
				padding: 15px 10px;
				display: block;
				border-bottom: 1px solid #D0D4D9;
				background-color: #E8F0FE;
				border-top-left-radius: 8px;
				border-top-right-radius: 8px;
			}

			.filter-group {
				border-bottom: 1px solid #E0E4EA;
				padding: 10px;
			}

			.filter-title {
				font-size: 16px;
				display: flex;
				justify-content: space-between;
				align-items: center;
				padding-bottom: 10px;
			}

			select {
				width: 100%;
				height: 35px;
				padding-left: 10px;
				margin-bottom: 15px;
				border: 1px solid #D0D4D9;
				border-radius: 5px;
				background-color: #FFF;
				font-size: 16px;
				color: #333;
				cursor: pointer;
			}

			.filter-title a {
				color: #527092;
				text-decoration: none;
				font-weight: bold;
				font-size: 14px;
			}

			.filter-title a:hover {
				color: #3A5E8C;
			}

			.actions {
				padding: 10px;
				display: flex;
				justify-content: space-between;
			}

			button.reset-btn, button.apply-btn {
				padding: 8px 16px;
				border-radius: 20px;
				border: none;
				font-weight: bold;
				color: #FFF;
				cursor: pointer;
				transition: background-color 0.3s;
				background-color: #6A8BB4;
			}

			button.reset-btn:hover,
			button.apply-btn:hover {
				background-color: #5a7aa2;
			}
			.card_container {
				padding-bottom: 50px;
				padding-left: 130px;
				padding-top: 40px;
				background-color: #f2f5f7;
			}
			.card-container {
				margin-bottom: 70px;
			}
			.card-container .date {
				position: relative;
				left: 9%;
				top: 55px;
				font-size: 20px;
			}
			.card-grid {
				position: relative;
				left: 8%;
				top: 70px;
				display: grid;
				grid-template-columns: repeat(3, 1fr);
				gap: 30px;
				width: 0;
			}
			.card {
				display: flex;
				align-items: center;
				justify-content: space-around;
				width: 340px;
				border-radius: 20px;
				padding: 15px;
				text-decoration: none;
				color: #000000;
				box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
				background-color: #ffffff;
				transition: transform 0.3s, box-shadow 0.3s;
				cursor: pointer;
			}

			.card:hover {
				transform: translateY(-5px);
				box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
				background-color: #ededed;
			}
			.card .details {
				display: flex;
				flex-direction: column;
				align-items: center;
				width: 200px;
				gap: 8px;
			}
			.image i {
				font-size: 36px;
			}
			span.type {
				font-size: 20px;
			}





			.swal-body {
				margin-top: 20px;
			}
			.sub-body {
				display: flex;
				justify-content: space-around;
			}
			i.fa-xmark {
				position: relative;
				left: 50%;
				cursor: pointer;
				font-size: 25px;
			}
			.swal-wide {
				width: 1300px;
				height: 1200px;
			}

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
			</div>

			<?php
				include_once "tools-report.php";
			?>
			<div class="card_container">
				<?php 
					include_once "php/config.php";

					$dateQuery = "SELECT DISTINCT ir.IncidentReportID, it.IncidentTypeName, b.BarangayName,
							ir.ResponseStatus, ir.Zone, ir.Street, ir.CreatedAt, ir.CreatedTime, ir.UpdatedAt
							FROM incident_report AS ir
							LEFT JOIN incident_type AS it ON ir.IncidentTypeID = it.IncidentTypeID
							LEFT JOIN barangay AS b ON ir.BarangayID = b.BarangayID WHERE 1 = 1";

					if (!empty($search)) {
						$search = str_ireplace(['Zone', ','], '', $search);
						$searchTerms = explode(' ', trim($search));
					} else {
						$searchTerms = [];
					}

					foreach ($searchTerms as $term) {
						$term = $conn->real_escape_string($term);
						$dateQuery .= " AND (IncidentTypeName LIKE '%$term%' 
							OR Zone LIKE '%$term%' 
							OR BarangayName LIKE '%$term%')";
					}

					if (!empty($incident_type)) {
						$dateQuery .= " AND IncidentTypeName = '" . $conn->real_escape_string($incident_type) . "'";
					}
					if (!empty($barangay)) {
						$dateQuery .= " AND BarangayName = '" . $conn->real_escape_string($barangay) . "'";
					}
					$order_by = 'ORDER BY `CreatedAt` DESC';
					if ($sort_by == 'CreatedAt-asc') {
						$order_by = 'ORDER BY `CreatedAt` ASC';
					}
					$dateQuery .= " $order_by";

					$dateResult = $conn->query($dateQuery);

					if ($dateResult->num_rows > 0) {
						$eventDates = [];
						while ($row = $dateResult->fetch_assoc()) {
							$eventDates[] = date("F j, Y", strtotime($row['CreatedAt']));
						}
					} else {
						echo "<p>No data matches your search criteria.</p>";
						$eventDates = [];
					}

					foreach ($eventDates as $eventDate) {
						$sql = "SELECT ir.IncidentReportID, it.IncidentTypeName, b.BarangayName,
							ir.ResponseStatus, ir.Zone, ir.Street, ir.CreatedAt, ir.CreatedTime, ir.UpdatedAt
							FROM incident_report AS ir
							LEFT JOIN incident_type AS it ON ir.IncidentTypeID = it.IncidentTypeID
							LEFT JOIN barangay AS b ON ir.BarangayID = b.BarangayID WHERE CreatedAt = '" . $conn->real_escape_string(date("Y-m-d", strtotime($eventDate))) . "'";

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

						if ($reportResult->num_rows == 0) {
							echo "<p>No incidents found for " . $eventDate . ".</p>";
							continue;
						}

						echo "<div class='card-container'>";
						echo "<span class='date'>" . $eventDate . "</span>";
						echo "<div class='card-grid'>";

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
				?>
			</div>
		</div>
	</body>
	<script src="js/sidebar.js"></script>
	<script src="js/logout.js"></script>
	<script src="js/tools-report.js"></script>
	<script>

	</script>
</html>
