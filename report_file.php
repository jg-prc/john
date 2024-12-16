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
		<link rel="stylesheet" href="css/report-file.css">
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
<?php
    include_once "php/config.php";

    // Sanitize and validate report_id
    $report_id = isset($_GET['report_id']) ? intval($_GET['report_id']) : 0; // Converts to integer for safety

    // Ensure the connection is established
    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    // Prepare the SQL query
    $sql = "SELECT ir.IncidentReportID, bo.FirstName, bo.LastName, bo.ExtensionName, p.PositionName,
                   it.IncidentTypeName, b.BarangayName, ir.ResponseStatus, ir.Zone, ir.Street, ir.CreatedAt,
                   ir.CreatedTime, ir.Status, ir.UpdatedAt, fr.FolderName, img.ImagesName
            FROM incident_report AS ir
            LEFT JOIN barangay_officials AS bo ON ir.OfficialsID = bo.OfficialsID
            LEFT JOIN position AS p ON bo.PositionID = p.PositionID
            LEFT JOIN incident_type AS it ON ir.IncidentTypeID = it.IncidentTypeID
            LEFT JOIN barangay AS b ON ir.BarangayID = b.BarangayID
            LEFT JOIN folder_report AS fr ON ir.IncidentReportID = fr.FolderID
            LEFT JOIN images AS img ON fr.ImageID = img.ImagesID
            WHERE ir.IncidentReportID = ?";

    // Prepare and bind the statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $report_id); // Bind the report_id as an integer

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Fetch a single result

        // Determine status class
        $statusClass = '';
        switch ($row['ResponseStatus']) {
            case 'sent':
                $statusClass = 'sent';
                break;
            case 'resolved':
                $statusClass = 'resolved';
                break;
            case 'pending':
                $statusClass = 'pending';
                break;
            case 'duplicated':
                $statusClass = 'duplicated';
                break;
        }

        // Determine icon
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

        // Format time
        $createdTime = $row['CreatedTime'];
        $formattedTimeWithoutSec = date('H:i', strtotime($createdTime));

        // Output or further processing...
    } else {
        echo "No record found for the provided report ID.";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
?>

		<div class="container">
			<div class="title">
				<img src="php/image/logo.png" alt="profileImg">
				<i class="fas fa-folder-open"></i>
				<i><strong>Reported Incident</strong></i>
			</div>
			<div class="sub-title">
				<div>
					<?php echo $icon; ?>
					<i><?php echo $row[0]['IncidentTypeName']; ?></i>
				</div>
				<?php
					$eventDateTime = $row[0]['UpdatedAt'];

					if ($eventDateTime !== '0000-00-00 00:00:00') {
						$dateTime = new DateTime($eventDateTime);
						$formattedTime = $dateTime->format('g:i a');
						$eventDate = $dateTime->format('F j, Y');
				?>
				<div id="time">
					<span>Updated:</span>
					<span><?php echo $eventDate; ?></span>
					<span><?php echo $formattedTime; ?></span>
				</div>
				<?php
					}
				?>

			</div>
			<div class="sub-container1">
				<div class="image">
					<section id="main-carousel" class="splide">
						<div class="splide__track">
						<ul class="splide__list">

							<?php foreach ($row as $image) { ?>
								<li class="splide__slide"><img src="php/<?php echo $image['FolderName']; ?><?php echo $image['ImagesName']; ?>" alt=""></li>
							<?php } ?>

						</ul>
						</div>
					</section>
				</div>
				<form class="report" id="report" autocomplete="off" action="" method="post" enctype="multipart/form-data">
					<div class="input-container" id="row1">
						<span class="status <?php echo $statusClass; ?>"><?php echo $row[0]['ResponseStatus']; ?></span>
					</div>
					<div class="input-container" id="row2">
						<div class="input-box" id="Type-box">
							<label for="incident_type">Incident Type</label>
							<select id="incident_type" name="incident_type">
								<option value="" disabled selected>Incident Type</option>
								<option value="1" <?php echo ($row[0]['IncidentTypeName'] == 'Fire Incident') ? 'selected' : ''; ?>>Fire Incident</option>
								<option value="2" <?php echo ($row[0]['IncidentTypeName'] == 'Vehicular Accident') ? 'selected' : ''; ?>>Vehicular Accident</option>
								<option value="3" <?php echo ($row[0]['IncidentTypeName'] == 'Flood Incident') ? 'selected' : ''; ?>>Flood Incident</option>
								<option value="4" <?php echo ($row[0]['IncidentTypeName'] == 'Landslide Incident') ? 'selected' : ''; ?>>Landslide Incident</option>
							</select>
						</div>

						<div class="input-box" id="Barangay-box">
							<label for="barangay">Barangay</label>
							<select id="barangay" name="barangay">
								<option value="" disabled <?php echo empty($row[0]['BarangayName']) ? 'selected' : ''; ?>>Barangay</option>
								<?php
									$barangays = [
										"Adiangao", "Bagacay", "Bahay", "Boclod", "Calalahan", "Calawit", 
										"Camagong", "Catalotoan", "Danlog", "Del Carmen", 
										"Dolo", "Kinalansan", "Mampirao", "Manzana", "Minoro", "Palale", 
										"Ponglon", "Pugay", "Sabang", "Salogon", "San Antonio", 
										"San Juan", "San Vicente", "Santa Cruz", 
										"Soledad", "Tagas", "Tambangan", "Telegrafo", "Tominawog"
									];

									foreach ($barangays as $index => $barangay) {
										$value = $index + 1;
										$selected = ($row[0]['BarangayName'] === $barangay) ? 'selected' : '';
										echo "<option value=\"$value\" $selected>" . htmlspecialchars($barangay) . "</option>";
									}
								?>
							</select>
						</div>
					</div>
					<div class="input-container" id="row3">
						<div class="input-box" id="Zone-box">
							<label for="zone">Zone</label>
							<select id="zone" name="zone">
								<option value="" disabled selected>Zone</option>
								<option value="1" <?php echo ($row[0]['Zone'] == '1') ? 'selected' : ''; ?>>1</option>
								<option value="2" <?php echo ($row[0]['Zone'] == '2') ? 'selected' : ''; ?>>2</option>
								<option value="3" <?php echo ($row[0]['Zone'] == '3') ? 'selected' : ''; ?>>3</option>
								<option value="4" <?php echo ($row[0]['Zone'] == '4') ? 'selected' : ''; ?>>4</option>
								<option value="5" <?php echo ($row[0]['Zone'] == '5') ? 'selected' : ''; ?>>5</option>
								<option value="6" <?php echo ($row[0]['Zone'] == '6') ? 'selected' : ''; ?>>6</option>
								<option value="7" <?php echo ($row[0]['Zone'] == '7') ? 'selected' : ''; ?>>7</option>
							</select>
						</div>

						<div class="input-box" id="Street-box">
							<label for="street">Street / Sitio</label>
							<input type="text" name="street" id="street" placeholder="Street / Sitio" value="<?php echo htmlspecialchars($row[0]['Street']); ?>">
						</div>
					</div>
					<div class="input-container" id="row4">
						<div class="input-box" id="Event-box">
							<label for="event_at">Date</label>
							<input type="date" name="event_at" id="event_at" value="<?php echo htmlspecialchars($row[0]['CreatedAt']); ?>">
						</div>
						<div class="input-box" id="Report-box">
							<label for="report_by">Reported by</label>
							<input type="text" class="report_by" id="report_by" value="<?php echo htmlspecialchars($row[0]['FirstName'] . ' ' . $row[0]['LastName'] . ' ' . $row[0]['ExtensionName']); ?>" disabled>
						</div>
					</div>
					<div class="input-container" id="row5">
						<div class="input-box" id="Time-box">
							<label for="time_at">Time</label>
							<input type="time" name="time_at" id="time_at" value="<?php echo htmlspecialchars($formattedTimeWithoutSec); ?>">
						</div>
						<?php
							$status = $row[0]['IncidentTypeName'];

							if ($status === 'Flood Incident') {
						?>
						<div class="input-box" id="Status-box">
							<label for="status">Status</label>
							<select id="status" name="status">
								<option value="" disabled selected>Status</option>
								<option value="flooded" <?php echo ($row[0]['Status'] == 'flooded') ? 'selected' : ''; ?>>flooded</option>
								<option value="subsided" <?php echo ($row[0]['Status'] == 'subsided') ? 'selected' : ''; ?>>subsided</option>
								<option value="receding" <?php echo ($row[0]['Status'] == 'receding') ? 'selected' : ''; ?>>receding</option>
							</select>
						</div>
						<?php
							}
						?>
					</div>
				</form>
			</div>
		<?php
			}
		?>
			<div class="sub-container2" data-report-id="<?php echo $report_id; ?>">
				<form class="victim" id="victim" autocomplete="off" action="" method="post" enctype="multipart/form-data">
					<input type="hidden" name="report_id" id="report_id" value="<?php echo $report_id;?>">
					<div class="form-container" id="form-container">
					<?php
						include_once "php/config.php";
						$report_id = isset($_GET['report_id']) ? $_GET['report_id'] : '';

						$sql = "SELECT * FROM victims WHERE victimID = ?";

						$stmt = $conn->prepare($sql);
						$stmt->bind_param("i", $report_id);
						$stmt->execute();
						$result = $stmt->get_result();

						if ($result->num_rows > 0) {
							while ($row = $result->fetch_assoc()) {
								echo "
									<div class='form-section'  id='victim" . htmlspecialchars($row['victimID']) . "'>
										<input type='hidden' name='victim_id' value='" . htmlspecialchars($row['victimID']) . "'>

										<i class='fa fa-circle-xmark' onclick='deleteVictim(" . htmlspecialchars($row['victimID']) . ")'></i>

										<div class='input-box' id='Name-box'>
											<label for='name'>Name</label>
											<input type='text' name='update_name[]' id='name' placeholder='Name' value='" . htmlspecialchars($row['VictimName']) . "'>
											<div class='message'>Error message</div>
											<i class='fas fa-exclamation-circle'></i>
										</div>
										<div class='input-box' id='Address-box'>
											<label for='address'>Address</label>
											<textarea name='update_address[]' id='address' placeholder='Address'>" . htmlspecialchars($row['Address']) . "</textarea>
											<div class='message'>Error message</div>
											<i class='fas fa-exclamation-circle'></i>
										</div>
										<div class='input-container' id='age_sex'>
											<div class='input-box' id='Age-box'>
												<label for='age'>Age</label>
												<input type='text' name='update_age[]' id='age' placeholder='Age' value='" . htmlspecialchars($row['Age']) . "'>
												<div class='message'>Error message</div>
												<i class='fas fa-exclamation-circle'></i>
											</div>
											<div class='input-box' id='Sex-box'>
												<label for='sex'>Sex</label>
												<select name='update_sex[]' id='sex'>
													<option value='' disabled selected>Sex</option>
													<option value='male'" . ($row['Sex'] == 'male' ? ' selected' : '') . ">Male</option>
													<option value='female'" . ($row['Sex'] == 'female' ? ' selected' : '') . ">Female</option>
												</select>
												<div class='message'>Error message</div>
												<i class='fas fa-exclamation-circle'></i>
											</div>
										</div>
										<div class='input-box' id='Classification-box'>
											<label for='classification'>Classification</label>
											<textarea name='update_classification[]' id='classification' placeholder='Classification'>" . htmlspecialchars($row['Classification']) . "</textarea>
											<div class='message'>Error message</div>
											<i class='fas fa-exclamation-circle'></i>
										</div>
									</div>
								";
							}
						}
					?>
						<div class="" id="add">
							<i class="fa fa-square-plus"></i>
							<span>Add Victim form</span>
						</div>
					</div>
					<div class="btn">
						<button type="submit">Update</button>
					</div>
				</form>
			</div>
		</div>
	</body>
	<script src="js/sidebar.js"></script>
	<script src="js/victims.js"></script>
	<script src="js/logout.js"></script>
	<script>
document.addEventListener('DOMContentLoaded', function () {
	var main = new Splide('#main-carousel', {
		type: 'slide',
		pagination: false,
		arrows: true,
		rewind: false,
	}).mount();
});


document.getElementById('add').addEventListener('click', function() {
	let formSection = document.createElement('div');
	formSection.classList.add('form-section');

	let removeBtn = document.createElement('i');
	removeBtn.className = 'fa fa-circle-xmark';
	formSection.appendChild(removeBtn);

	let formContent = `
		<div class="input-box" id="Name-box">
			<label for="name">Name</label>
			<input type="text" name="name[]" id="name" placeholder="Name">
			<div class="message">Error message</div>
			<i class="fas fa-exclamation-circle"></i>
		</div>
		<div class="input-box" id="Address-box">
			<label for="address">Address</label>
			<textarea name="address[]" id="address" placeholder="Address"></textarea>
			<div class="message">Error message</div>
			<i class="fas fa-exclamation-circle"></i>
		</div>
		<div class="input-container" id="age_sex">
			<div class="input-box" id="Age-box">
				<label for="age">Age</label>
				<input type="text" name="age[]" id="age" placeholder="Age">
				<div class="message">Error message</div>
				<i class="fas fa-exclamation-circle"></i>
			</div>
			<div class="input-box" id="Sex-box">
				<label for="sex">Sex</label>
				<select name="sex[]" id="sex">
					<option value="" disabled selected>Sex</option>
					<option value="male">Male</option>
					<option value="female">Female</option>
				</select>
				<div class="message">Error message</div>
				<i class="fas fa-exclamation-circle"></i>
			</div>
		</div>
		<div class="input-box" id="Classification-box">
			<label for="classification">Classification</label>
			<textarea name="classification[]" id="classification" placeholder="Classification"></textarea>
			<div class="message">Error message</div>
			<i class="fas fa-exclamation-circle"></i>
		</div>
	`;

	formSection.insertAdjacentHTML('beforeend', formContent);

	removeBtn.addEventListener('click', function() {
		formSection.remove();
	});

	document.getElementById('form-container').insertBefore(formSection, document.getElementById('add'));
});







function deleteVictim(victimId) {
	Swal.fire({
		title: 'Are you sure?',
		text: "This will permanently delete the victim's information.",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, delete it!'
	}).then((result) => {
		if (result.isConfirmed) {
			fetch('php/delete_victim.php', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				},
				body: `victim_id=${victimId}`
			})
			.then(response => response.text())
			.then(data => {
				if (data.trim() === 'success') {
					const victimSection = document.getElementById(`victim${victimId}`);
					if (victimSection) {
						victimSection.remove();
						Swal.fire(
							'Deleted!',
							"The victim's information has been removed.",
							'success'
						);
					}
				} else {
					Swal.fire(
						'Error!',
						"There was an issue deleting the victim's information.",
						'error'
					);
				}
			})
		}
	});
}
	</script>
</html>