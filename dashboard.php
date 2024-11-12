<?php
	session_start();
	if (!isset($_SESSION['unique_id']) || $_SESSION['role'] !== 'admin') {
		header("Location: login.php");
		exit();
	}

	date_default_timezone_set('Asia/Manila');

	$type = isset($_GET['type']) ? $_GET['type'] : '';
	$selectedDate = isset($_GET['date']) ? $_GET['date'] : date("Y-m-d");
	$currentDate = date("Y-m-d");

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
		<link rel="stylesheet" href="css/sidebar.css">

		<link rel="icon" href="php/image/logo.png" type="image/png">
		<title>Responsive Layout</title>
		<style>
			.container {
				margin-left: 70px;
				height: 100vh;
			}
			.header-container {
				width: 100%;
				height: 100px;
				display:flex;
				align-items: center;
				gap: 20px;
				position: fixed;
				z-index: 1;
				background-color: #88B3DA;
				color: #ffffff;
			}
			.logo-content {
				padding-left: 20px;
			}
			.logo-content img {
				width: 100px;
			}
			.button-container {
				display: flex;
				position: fixed;
				top: 100px;
				z-index: 1;
			}
			.button-container button {
				padding: 20px;
				width: 295px;
				border: none;
				background-color: #497EA9;
				transition: background-color 0.3s ease;
			}
			.button-container button:hover {
				background-color: #21618c;
			}
			.button-container button.highlighted {
				background-color: #21618c;
				transition: background-color 0.3s ease;
			}

			.button-container button a {
				display: flex;
				flex-direction: column;	
				text-decoration: none;
				color: #ffffff;
			}
			.button-container button i {
				font-size: 30px;
			}
			.button-container button p {
				font-size: 16px;
			}
			a .blink {
				animation: blink-animation 1s steps(5, start) infinite;
			}
			@keyframes blink-animation {
				50% {
					color: #ff6347;
				}
			}
			.blinking {
				animation: blink 1s steps(5, start) infinite;
			}
			@keyframes blink {
				50% {
					fill: #ff4500;
				}
			}
			.not-blink {
				color: #ff4500;
			}
			.not-blinking {
				fill: #ff4500;
			}





			svg#map {
				margin-left: 20px;
				position: relative;
				top: 220px;
			}
			.calendar-container {
				width: 550px;
				background: #fff;
				border-radius: 10px;
				box-shadow: 0 15px 40px rgba(0,0,0,0.12);
				position: relative;
				left: 57%;
				bottom: 292px;
				z-index: 0;
			}
			.calendar-container header {
				display: flex;
				align-items: center;
				padding: 25px 30px 15px;
				justify-content: space-between;
			}
			.calendar-container header .icons {
				display: flex;
			}
			.calendar-container header .icons span {
				height: 38px;
				width: 38px;
				margin: 0 1px;
				cursor: pointer;
				color: #878787;
				text-align: center;
				line-height: 38px;
				font-size: 1.9rem;
				user-select: none;
				border-radius: 50%;
			}
			.calendar-container .icons span:last-child {
				margin-right: -10px;
			}
			.calendar-container header .icons span:hover {
				background: #f2f2f2;
			}
			.calendar-container header .current-date {
				font-size: 1.45rem;
				font-weight: 500;
			}
			.calendar {
				padding: 0 20px 20px 20px;
			}
			.calendar ul {
				display: flex;
				flex-wrap: wrap;
				list-style: none;
				text-align: center;
			}
			.calendar li {
				color: #333;
				width: calc(100% / 7);
				font-size: 1.07rem;
			}
			.calendar .weeks li {
				font-weight: 500;
				cursor: default;
			}
			.calendar .days li {
				z-index: 1;
				cursor: pointer;
				position: relative;
				margin-top: 20px;
			}
			.days li.inactive {
				color: #aaa;
			}
			.days li.active {
				color: #fff;
			}
			.days li::before {
				position: absolute;
				content: "";
				left: 50%;
				top: 50%;
				height: 40px;
				width: 40px;
				z-index: -1;
				border-radius: 50%;
				transform: translate(-50%, -50%);
			}
			.days li.active::before {
				background: #9B59B6;
			}
			.days li.selected::before {
				background: #3498DB;
			}
			.days li:not(.active):hover:not(.selected)::before {
				background: #f2f2f2;
			}
			input#selectedDate {
				display: none;
			}



			#text-slider.splide {
				position: relative;
				left: 57%;
				bottom: 300px;
				width: 550px;
			}
			#text-slider .splide__slide {
				display: flex;
				align-items: center;
				justify-content: space-evenly;
				border: 1px solid #e0e0e0;
				background-color: #fff;
				padding: 15px;
				box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
				border-radius: 8px;
				width: 500px;
				min-height: 120px;
			}
			#text-slider .splide__slide i {
				font-size: 36px;
				color: #ff4500;
			}
			#text-slider .content {
				display: flex;
				flex-direction: column;
				justify-content: center;
			}
			span.type {
				font-size: 18px;
				font-weight: bold;
				color: #333;
			}
			span.time {
				font-size: 14px;
				color: #666;
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
			.sub-btn span.status.ongoing:hover {
				background-color: #cc3700;
				transform: translateY(-2px);
			}
			.sub-btn span.status.duplicated:hover {
				background-color: #41729f;
				transform: translateY(-2px);
			}
			.sub-btn span.status.resolved:hover {
				background-color: #1f7a32;
				transform: translateY(-2px);
			}
			span.status.ongoing.disabled,
			span.status.ongoing.disabled:hover,
			span.status.resolved.disabled,
			span.status.resolved.disabled:hover,
			span.status.duplicated.disabled,
			span.status.duplicated.disabled:hover {
				background-color: #C0C0C0;
				transform: translateY(0);

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
			.swal-body .sub-btn {
				display: flex;
				gap: 8px;
				padding-top: 100px;
				justify-content: space-evenly;
			}
			.sub-btn span{
				cursor: pointer;
				padding: 14px;
				font-size: 16px;
				width: 140px;
			}



			.image img {
				width: 500px;
				height: 500px;
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

		</style>
	</head>
	<body>
		<div class="sidebar close">
			<div class="open-btn">
				<span class="openbtn">&#9776;</span>
			</div>
			<ul class="nav-links">
				<li class="active">
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
			<div class="header-container">
				<div class="logo-content">
					<img src="php/image/logo.png" alt="profileImg">
				</div>
				<div class="details">
					<h2>SAN JOSE INCIDENT RECORD  MANAGEMENT AND MAPPING SYSTEM</h2>
					<i>San Jose, Camarines Sur</i>
				</div>
			</div>
			<div class="button-container">
				<button class="incident-type-btn <?php echo $type === '' ? 'highlighted' : ''; ?>">
					<a href="?type=<?php echo isset($selectedDate) ? '&date=' . $selectedDate : ''; ?>">
						<i class="fas fa-triangle-exclamation"></i>
						<p>Over All Incident</p>
					</a>
				</button>
				<button class="incident-type-btn <?php echo $type === 'Vehicular Accident' ? 'highlighted' : ''; ?>">
					<a href="?type=Vehicular%20Accident<?php echo isset($selectedDate) ? '&date=' . $selectedDate : ''; ?>">
						<i class="fas fa-car-crash" id="vehicular"></i>
						<p>Vehicular Accident</p>
					</a>
				</button>
				<button class="incident-type-btn <?php echo $type === 'Fire Incident' ? 'highlighted' : ''; ?>">
					<a href="?type=Fire%20Incident<?php echo isset($selectedDate) ? '&date=' . $selectedDate : ''; ?>">
						<i class="fas fa-fire" id="fire"></i>
						<p>Fire Incident</p>
					</a>
				</button>
				<button class="incident-type-btn <?php echo $type === 'Flood Incident' ? 'highlighted' : ''; ?>">
					<a href="?type=Flood%20Incident<?php echo isset($selectedDate) ? '&date=' . $selectedDate : ''; ?>">
						<i class="fas fa-house-flood-water" id="flood"></i>
						<p>Flood Incident</p>
					</a>
				</button>
				<button class="incident-type-btn <?php echo $type === 'Landslide Incident' ? 'highlighted' : ''; ?>">
					<a href="?type=Landslide%20Incident<?php echo isset($selectedDate) ? '&date=' . $selectedDate : ''; ?>">
						<i class="fas fa-hill-rockslide" id="landslide"></i>
						<p>Landslide Incident</p>
					</a>
				</button>
			</div>
			<?php
				include_once "map.php";
			?>
			<div id="text-slider" class="splide">
				<div class="splide__track">
					<ul class="splide__list">

						<?php
							include_once "php/config.php";

							
							$date = isset($_GET['date']) ? $_GET['date'] : '';

							$dateQuery = "SELECT * FROM incident_report WHERE 1 = 1";

							if (!empty($type)) {
								$dateQuery .= " AND incident_type = '" . $conn->real_escape_string($type) . "'";
							}

							if (!empty($selectedDate)) {
								$dateQuery .= " AND event_at = '" . $conn->real_escape_string($selectedDate) . "'";
							}

							$dateQuery .= " ORDER BY event_time DESC";

							$result = $conn->query($dateQuery);

							if ($result->num_rows > 0) {
								while ($row = $result->fetch_assoc()) {
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
									$statusClass = '';
									switch ($row['status']) {
										case 'pending':
											$statusClass = 'pending';
											break;
										case 'resolved':
											$statusClass = 'resolved';
											break;
										case 'ongoing':
											$statusClass = 'ongoing';
											break;
										case 'duplicated':
											$statusClass = 'duplicated';
											break;
									}

									$eventDateTime = new DateTime($row['event_time']);
									$formattedTime = $eventDateTime->format('g:i a');

						?>
						<li class="splide__slide" onclick=showForm(<?php echo $row['report_id']; ?>)>
							<?php echo $icon; ?>
							<div class="content">
								<span class="type"><?php echo $row['incident_type']; ?></span>
								<span>Zone <?php echo $row['zone'] . ", " . $row['barangay']; ?></span>
								<span class="status <?php echo $statusClass; ?>"><?php echo $row['status']; ?></span>
							</div>
							<span class="time"><?php echo $formattedTime; ?></span>
						</li>
						<?php
								}
							} else {
								echo "<li class='splide__slide'> </li>";
							}
						?>
					</ul>
				</div>
			</div>
			<div class="calendar-container">
				<header>
					<p class="current-date"></p>
					<div class="icons">
						<span id="prev" class="fa fa-chevron-left"></span>
						<span id="next" class="fa fa-chevron-right"></span>
					</div>
				</header>
				<div class="calendar">
					<ul class="weeks">
						<li>Sun</li>
						<li>Mon</li>
						<li>Tue</li>
						<li>Wed</li>
						<li>Thu</li>
						<li>Fri</li>
						<li>Sat</li>
					</ul>
					<ul class="days"></ul>
				</div>
			</div>
				<input type="date" id="selectedDate" value="<?php echo $selectedDate; ?>" onchange="updateUrlWithDate()">
		</div>
	</body>
	<script src="js/sidebar.js"></script>
	<script src="js/dashboard.js"></script>
	<script src="js/logout.js"></script>
	<script>
		document.addEventListener('DOMContentLoaded', function () {
			new Splide('#text-slider', {
				pagination: false,
				arrows: true,
			}).mount();
		});

		const selectedDateFromPHP = "<?php echo $selectedDate; ?>";
		const currentDateFromPHP = "<?php echo $currentDate; ?>";

		const daysTag = document.querySelector(".days"),
			currentDateElement = document.querySelector(".current-date"),
			prevNextIcon = document.querySelectorAll(".icons span"),
			selectedDateInput = document.querySelector("#selectedDate");

		let date = new Date(),
			currYear = date.getFullYear(),
			currMonth = date.getMonth();

		if (selectedDateFromPHP) {
			const [year, month, day] = selectedDateFromPHP.split("-");
			date = new Date(year, month - 1, day);
			currYear = date.getFullYear();
			currMonth = date.getMonth();
		}

		const months = ["January", "February", "March", "April", "May", "June", "July",
			"August", "September", "October", "November", "December"];

		const renderCalendar = () => {
			let firstDayofMonth = new Date(currYear, currMonth, 1).getDay(),
				lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate(),
				lastDayofMonth = new Date(currYear, currMonth, lastDateofMonth).getDay(),
				lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate();

			let liTag = "";

			for (let i = firstDayofMonth; i > 0; i--) {
				liTag += `<li class="inactive" data-day="${lastDateofLastMonth - i + 1}" 
					data-month="${currMonth === 0 ? 12 : currMonth}" 
					data-year="${currMonth === 0 ? currYear - 1 : currYear}">
					${lastDateofLastMonth - i + 1}
				</li>`;
			}

			for (let i = 1; i <= lastDateofMonth; i++) {

				let isToday = i === new Date(currentDateFromPHP).getDate() && currMonth === new Date(currentDateFromPHP).getMonth() && currYear === new Date(currentDateFromPHP).getFullYear() ? "active" : "";
				let isSelected = selectedDateFromPHP && i === parseInt(selectedDateFromPHP.split("-")[2]) && currMonth + 1 === parseInt(selectedDateFromPHP.split("-")[1]) && currYear === parseInt(selectedDateFromPHP.split("-")[0]) ? "selected" : "";

				liTag += `<li class="${isToday} ${isSelected}" data-day="${i}" data-month="${currMonth + 1}" data-year="${currYear}">${i}</li>`;
			}

			for (let i = lastDayofMonth; i < 6; i++) {
				liTag += `<li class="inactive" data-day="${i - lastDayofMonth + 1}" 
					data-month="${currMonth + 2 > 12 ? 1 : currMonth + 2}" 
					data-year="${currMonth + 2 > 12 ? currYear + 1 : currYear}">
					${i - lastDayofMonth + 1}
				</li>`;
			}

			currentDateElement.innerText = `${months[currMonth]} ${currYear}`;
			daysTag.innerHTML = liTag;

			const days = document.querySelectorAll(".days li");
			days.forEach(day => {
				day.addEventListener("click", () => {
					days.forEach(d => d.classList.remove("selected"));
					day.classList.add("selected");

					const selectedDay = day.getAttribute("data-day"),
						selectedMonth = day.getAttribute("data-month"),
						selectedYear = day.getAttribute("data-year");

					const formattedDate = `${selectedYear}-${String(selectedMonth).padStart(2, '0')}-${String(selectedDay).padStart(2, '0')}`;
					selectedDateInput.value = formattedDate;
					updateUrlWithDate();
				});
			});
		};

		renderCalendar();

		prevNextIcon.forEach(icon => {
			icon.addEventListener("click", () => {
				currMonth = icon.id === "prev" ? currMonth - 1 : currMonth + 1;

				if (currMonth < 0 || currMonth > 11) {
					date = new Date(currYear, currMonth, new Date().getDate());
					currYear = date.getFullYear();
					currMonth = date.getMonth();
				} else {
					date = new Date();
				}
				renderCalendar();
			});
		});

		function updateUrlWithDate() {
			const selectedDate = selectedDateInput.value;
			if (selectedDate) {
				const url = new URL(window.location.href);
				url.searchParams.set('date', selectedDate);

				window.location.href = url;
			}
		}

		function fetchIncidentData(incidentType, selectedDate) {

			var xhr = new XMLHttpRequest();
			xhr.open('GET', 'fetch_incident_data.php?type=' + encodeURIComponent(incidentType) + '&date=' + encodeURIComponent(selectedDate), true);
			xhr.onload = function() {
				if (xhr.status == 200) {
					var response = JSON.parse(xhr.responseText);
					var incidentData = response.incident_data;
					var incidentLocation = response.incident_location;

					document.getElementById('vehicular').className = 'fas fa-car-crash ' + (incidentData.Vehicular || '');
					document.getElementById('fire').className = 'fas fa-fire ' + (incidentData.Fire || '');
					document.getElementById('flood').className = 'fas fa-house-flood-water ' + (incidentData.Flood || '');
					document.getElementById('landslide').className = 'fas fa-hill-rockslide ' + (incidentData.Landslide || '');

					for (var barangay in incidentLocation) {
						if (incidentLocation.hasOwnProperty(barangay)) {
							var element = document.getElementById(barangay.toLowerCase());
							if (element) {
								if (incidentLocation[barangay] === 'blinking') {
									element.classList.add('blinking');
								} else {
									element.classList.remove('blinking');
								}
								if (incidentLocation[barangay] === 'not-blinking') {
									element.classList.add('not-blinking');
								} else {
									element.classList.remove('not-blinking');
								}
							}
						}
					}
				} else {
					console.error('Error fetching data: ', xhr.statusText);
				}
			};
			xhr.send();
		}

		function getIncidentTypeFromURL() {
			const params = new URLSearchParams(window.location.search);
			return params.get('type') || '';
		}

		function getSelectedDateFromURL() {
			const params = new URLSearchParams(window.location.search);
			return params.get('date') || '';
		}

		window.onload = function() {
			const incidentType = getIncidentTypeFromURL();
			const selectedDate = getSelectedDateFromURL();

			setInterval(() => {
				if (incidentType || selectedDate) {
					fetchIncidentData(incidentType, selectedDate);
				} else {
					fetchIncidentData('', '');
				}
			}, 500);
		};
	</script>
</html>