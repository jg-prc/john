<?php

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

		<link rel="stylesheet" href="css/guest.css">

		<link rel="icon" href="php/image/logo.png" type="image/png">
		<title>SAN JOSE INCIDENT RECORD  MANAGEMENT AND MAPPING SYSTEM</title>
	</head>
	<body>
		<div class="container">
			<div class="header-container">
				<div class="logo-content">
					<img src="php/image/logo.png" alt="profileImg">
				</div>
				<a href="index.php">login</a>
				<div class="details">
					<h2>SAN JOSE INCIDENT RECORD  MANAGEMENT AND MAPPING SYSTEM</h2>
					<i>San Jose, Camarines Sur</i>
				</div>
			</div>
			<div class="button-container">
				<button class="incident-type-btn <?php echo $type === '' ? 'highlighted' : ''; ?>" id="over_all">
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
			<div class="date">
				<input type="date" id="selectedDate" value="<?php echo $selectedDate; ?>" onchange="updateUrlWithDate()">
			</div>
			<?php
				include_once "map.php";
			?>

			<div id="text-slider" class="splide">
				<div class="splide__track">
					<ul class="splide__list">

					<?php 
						include_once "php/config.php";

						$dateQuery = "
							SELECT 
								ir.IncidentReportID, 
								ir.ResponseStatus, 
								ir.Zone, 
								ir.Street, 
								ir.CreatedAt, 
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
								1 = 1";

						if (!empty($type)) {
							$dateQuery .= " AND it.IncidentTypeName = '{$type}'";
						}

						if (!empty($selectedDate)) {
							$dateQuery .= " AND ir.CreatedAt = '{$selectedDate}'";
						}

						$dateQuery .= " AND (ir.ResponseStatus = 'ongoing' OR ir.ResponseStatus = 'resolved')";
						$dateQuery .= " ORDER BY ir.CreatedTime DESC";

						$result = $conn->query($dateQuery);

						if ($result && $result->num_rows > 0) {
							while ($row = $result->fetch_assoc()) {
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
								$statusClass = '';
								switch ($row['ResponseStatus']) {
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

								$eventDateTime = new DateTime($row['CreatedTime']);
								$formattedTime = $eventDateTime->format('g:i a');
					?>
					<li class="splide__slide">
						<?php echo $icon; ?>
						<div class="content">
							<span class="type"><?php echo htmlspecialchars($row['IncidentTypeName']); ?></span>
							<span>Zone <?php echo htmlspecialchars($row['Zone'] . ", " . $row['BarangayName']); ?></span>
							<span class="status <?php echo htmlspecialchars($statusClass); ?>"><?php echo htmlspecialchars($row['ResponseStatus']); ?></span>
						</div>
						<span class="time"><?php echo $formattedTime; ?></span>
					</li>
					<?php
							}
						} else {
							echo "<li class='splide__slide'>No incidents found.</li>";
						}
					?>
					</ul>
				</div>
			</div>
			<div class="notif-container">
				<div class="notif-list">
				<?php
					include_once "php/config.php";
					$dateQuery = "
						SELECT 
							ir.IncidentReportID, 
							ir.ResponseStatus, 
							ir.Zone, 
							ir.Street, 
							ir.CreatedAt, 
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
							1 = 1";

					if (!empty($type)) {
						$dateQuery .= " AND it.IncidentTypeName = '{$type}'";
					}

					if (!empty($selectedDate)) {
						$dateQuery .= " AND ir.CreatedAt = '{$selectedDate}'";
					}

					$dateQuery .= " AND (ir.ResponseStatus = 'ongoing' OR ir.ResponseStatus = 'resolved')";
					$dateQuery .= " ORDER BY ir.CreatedTime DESC";

					$result = $conn->query($dateQuery);

					if ($result && $result->num_rows > 0) {
						while ($row = $result->fetch_assoc()) {
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
							$statusClass = '';
							switch ($row['ResponseStatus']) {
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
							$eventDateTime = new DateTime($row['CreatedTime']);
							$formattedTime = $eventDateTime->format('g:i a');
				?>
				<li class="notif">
					<?php echo $icon; ?>
					<div class="content">
						<span class="type"><?php echo htmlspecialchars($row['IncidentTypeName']); ?></span>
						<span>Zone <?php echo htmlspecialchars($row['Zone'] . ", " . $row['BarangayName']); ?></span>
						<span class="status <?php echo htmlspecialchars($statusClass); ?>"><?php echo htmlspecialchars($row['ResponseStatus']); ?></span>
					</div>
					<span class="time"><?php echo htmlspecialchars($formattedTime); ?></span>
				</li>
				<?php
						}
					} else {
						echo "<li class='notif'>No incidents found.</li>";
					}
				?>
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
		</div>

	</body>
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
			xhr.open('GET', 'fetch_incident_data1.php?type=' + encodeURIComponent(incidentType) + '&date=' + encodeURIComponent(selectedDate), true);
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