<?php
	session_start();
	if (!isset($_SESSION['unique_id']) || $_SESSION['role'] !== 'user') {
		header("Location: index.php");
		exit();
	}
	$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'created_at-desc';
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
		<title>Responsive Layout</title>
		<style>
			.container {
				height: 1100px;
				background-color: #f2f5f7;
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
				justify-content: flex-end;
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
			.card_container {
				padding-bottom: 50px;
				padding-left: 130px;
				padding-top: 10px;
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
				font-size: 50px;
			}
			span.type {
				font-size: 20px;
			}



			span.status {
				display: flex;
				justify-content: center;
				padding: 5px 10px;
				font-size: 13px;
				font-weight: bold;
				border-radius: 12px;
				margin-top: 5px;
				text-transform: uppercase;
				width: 120px;
			}
			span.status.ongoing {
				background-color: #ff4500;
				color: white;
			}

			span.status.resolved {
				background-color: #28a745;
				color: white;
			}
			span.status.pending {
				background-color: #ffc107;
				color: #333;
			}
			span.status.duplicated {
				background-color: #5dade2;
				color: white;
			}


			.swal-body {
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
				height: 650px;
			}
			.swal-body .image {
				width: 500px;
			}
			.swal-body .content {
				width: 620px;
				display: flex;
				flex-direction: column;
				gap: 36px;
			}
			.swal-body .head {
				display: flex;
				align-items: center;
				justify-content: space-around;
			}
			.swal-body span.status {
				margin-top: 0;
			}
			.swal-body .sub-content {
				display: flex;
				flex-direction: column;
				align-items: flex-start;
				font-size: 27px;
				gap: 8px;
			}
			.barangay strong::after {
				content: "Barangay:";
			}
			.street strong::after {
				content: "Street/Sitio:";
			}
			.report_by strong::after {
				content: "Reported By:";
			}
			.update strong::after {
				content: "Updated at:";
			}



			.swal-body .sub-btn {
				display: flex;
				gap: 8px;
			}
			.sub-btn span{
				cursor: pointer;
			}


			.image img {
				width: 500px;
				height: 500px;
				border-radius: 20px;
			}
			.splide__track--nav > .splide__list > .splide__slide.is-active {
				border: 2px solid #000;
			}
			.splide__arrow {
				height: 3em;
				width: 3em;
			}
			.splide__arrow svg {
				height: 2.2em;
				width: 2.2em;
			}








			@media screen and (max-width: 575px) {
				.container {
					height: unset;
				}
				.container .title {
					padding-left: 60px;
					padding-top: 3px;
					font-size: 20px;
				}
				.title img {
					width: 50px;
					order: 3;
					margin-left: 131px;
				}
				.title i{
					padding-top: 10px;
				}
				.tools {
					left: unset;
					width:100%;
					padding-right: 10px;
				}
				.card-grid {
					display: flex;
					flex-direction: column;
					left: 0;
					width: 100%;
				}
				.card_container {
					padding-left: 10px;
				}


				.swal-wide {
					width: 100%;
					height: 100%;
				}
				i.fa-xmark {
					position: relative;
					left: 54%;
					cursor: pointer;
					font-size: 25px;
					top: -10px;
				}
				.swal-body {
					display: block;
				}
				.swal-body .image,
				.image img {
					width: 100%;
					height: 100%;
				}
				.swal-body .content {
					width: 100%;
				}
				.swal-body .head {
					flex-direction: column;
				}
				.swal-body .sub-content {
					font-size: 20px;
					display: flex;
					align-items: center;
					gap: 22px;
				}
				.sub-content span {
					display: flex;
					flex-direction: column;
				}
				.barangay strong,
				.report_by strong,
				.street strong,
				.update strong {
					order: 2;
				}

				.report_by strong::after {
					content: "Reported By";
				}
				.street strong::after {
					content: "Street/Sitio";
				}
				.barangay strong::after {
					content: "Barangay";
				}
				.update strong::after {
					content: "Updated at";
				}
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

					$dateQuery = "SELECT DISTINCT event_at FROM incident_report WHERE user_id = $user_id";

					$order_by = 'ORDER BY `event_at` DESC';
					if ($sort_by == 'event_at-asc') {
						$order_by = 'ORDER BY `event_at` ASC';
					}
					$dateQuery .= " $order_by";

					$dateResult = $conn->query($dateQuery);

					if ($dateResult->num_rows > 0) {
						$eventDates = [];
						while ($row = $dateResult->fetch_assoc()) {
							$eventDates[] = date("F j, Y", strtotime($row['event_at']));
						}
					} else {
						$eventDates = [];
					}

					foreach ($eventDates as $eventDate) {

						$sql = "SELECT * FROM incident_report WHERE event_at = '" . $conn->real_escape_string(date("Y-m-d", strtotime($eventDate))) . "' AND user_id = " . $conn->real_escape_string($user_id) . " ORDER BY event_time DESC;";

						$reportResult = $conn->query($sql);

						if (!$reportResult) {
							die("Invalid query: " . $conn->error);
						} else {

							echo "<div class='card-container'>";
							echo "<span class='date'>" . $eventDate . "</span>";
							echo "<div class='card-grid'>";

							while ($row = $reportResult->fetch_assoc()) {

								$icon = '';
								switch ($row['incident_type']) {
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
									<a class='card' onclick=\"showForm(" . $row['report_id'] . ")\">
										<div class='image'>
										" . $icon . "
										</div>
										<div class='details'>
											<span class='type'>" . $row['incident_type'] . "</span>
											<span>Zone " . $row['zone'] . " , " . $row['barangay'] . "</span>
										</div>
									</a>
								";
							}
							echo "</div></div>";
						}
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

	if (!currentSortOrder || currentSortOrder === 'event_at-desc') {
		urlParams.set('sort_by', 'event_at-asc');
		sortIcon.classList.replace('fa-arrow-up-short-wide', 'fa-arrow-down-short-wide');
	} else {
		urlParams.set('sort_by', 'event_at-desc');
		sortIcon.classList.replace('fa-arrow-down-short-wide', 'fa-arrow-up-short-wide');
	}

	window.location.search = urlParams.toString();
}

window.onload = function() {
	const urlParams = new URLSearchParams(window.location.search);
	const sortIcon = document.getElementById('sort-icon');
	let currentSortOrder = urlParams.get('sort_by');

	if (currentSortOrder === 'event_at-asc') {
		sortIcon.classList.replace('fa-arrow-up-short-wide', 'fa-arrow-down-short-wide');
	} else {
		sortIcon.classList.replace('fa-arrow-down-short-wide', 'fa-arrow-up-short-wide');
	}
}
	</script>
</html>







