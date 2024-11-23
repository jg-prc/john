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
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<link rel="stylesheet" href="css/sidebar.css">
		<link rel="stylesheet" href="css/archive.css">
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
					<a href="dashboard.php">
						<i class="fas fa-gauge"></i>
						<span class="link_name">Dashboard</span>
					</a>
					<ul class="sub-menu blank">
						<li><a class="link_name">Dashboard</a></li>
					</ul>
				</li>
				<li class="active">
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
						<li><a class="active" href="archive.php">Archived account</a></li>
					</ul>
				</li>
				<li>
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
				<i class="fas fa-archive"></i>
				<i><strong>Archived Accounts</strong></i>
			</div>
			<?php
				include_once "tools.php";
			?>
			<div class="card_grid">
				<div class="card-grid">
					<?php
						include_once "php/config.php";
					
						$sql = "SELECT ob.OfficialsID, ob.FirstName, ob.MiddleName, ob.LastName, ob.ExtensionName,
							ob.Status, ob.ImageURL, ob.CreatedAt, p.PositionName, b.BarangayName
							FROM `barangay_officials` AS ob
							LEFT JOIN position as p ON ob.PositionID = p.PositionID
							LEFT JOIN barangay as b ON ob.BarangayID = b.BarangayID
							WHERE Status = 'deactivated'";

						if (!empty($search)) {
							$sql .= " AND (FirstName LIKE '%" . $conn->real_escape_string($search) . "%'
								OR MiddleName LIKE '%" . $conn->real_escape_string($search) . "%'
								OR LastName LIKE '%" . $conn->real_escape_string($search) . "%'
								OR ExtensionName LIKE '%" . $conn->real_escape_string($search) . "%')";
							}
						if (!empty($barangay)) {
						$sql .= " AND BarangayName = '" . $conn->real_escape_string($barangay) . "'";
						}
						if (!empty($position)) {
						$sql .= " AND PositionName = '" . $conn->real_escape_string($position) . "'";
						}

						$order_by = 'ORDER BY `CreatedAt` DESC';
						if ($sort_by == 'CreatedAt-asc') {
							$order_by = 'ORDER BY `CreatedAt` ASC';
						}

						$sql .= " $order_by";

						$result = $conn->query($sql);

						if (!$result) {
							die("invalid query: " . $connection->error);
						}
						if ($result->num_rows > 0) {
							while ($row = $result->fetch_assoc()) {
								echo "
									<div class='card' onclick=\"showForm(" . $row['OfficialsID'] . ")\">
										<div class='image'>
											<img src='php/image/" . $row['ImageURL'] . "' alt='User Image'>
										</div>
										<div class='details'>
											<span>" . $row['FirstName'] . " " . $row['LastName'] . " " . $row['ExtensionName'] . "</span>
											<span>" . $row['PositionName'] . "</span>
											<a href='#'>view details</a>
										</div>
									</div>
								";
							}
						} else {
							echo "
								<div class='card-nothing'>
									<span>No Data found</span>
								</div>
							";
						}
					?>
				</div>
			</div>
		</div>
	</body>
	<script src="js/sidebar.js"></script>
	<script src="js/tools.js"></script>
	<script src="js/archive.js"></script>
	<script src="js/logout.js"></script>
	<script>
	</script>
	</body>
</html>
