<?php
	session_start();
	if (!isset($_SESSION['unique_id']) || $_SESSION['role'] !== 'admin') {
		header("Location: login.php");
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
		<title>Responsive Layout</title>
		<style>
			body::-webkit-scrollbar {
				display: none;
			}
			.container {
				background-color: #f2f5f7;
			}
			.title {
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

			.sub-title {
				margin-left: 100px;
				border-bottom: 2px solid;
				display: flex;
				width: 90%;
				justify-content: space-between;
				font-size: 32px;
				padding-top: 40px;
				padding-bottom: 10px;
				align-items: flex-end;
			}
			#time {
				font-size: 20px;
				display: flex;
				gap: 10px;
			}

			.sub-container1 {
				display: flex;
				gap: 50px;
				padding: 20px 0 0 200px;
			}
			.image {
				width: 500px;
				margin: 20px;
			}
			.image img {
				width: 500px;
				height: 400px;
				border-radius: 20px;
			}
			.splide__arrow {
				height: 3em;
				width: 3em;
			}
			.splide__arrow svg {
				height: 2.2em;
				width: 2.2em;
			}



			form {
				padding-top: 20px;
				padding-bottom: 20px;
			}
			.input-container {
				display: flex;
				justify-content: space-between;
				width: 550px;
			}
			.input-container#row1 {
				justify-content: flex-end;
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
			input[type=text],
			input[type=date],
			input[type=tel],
			#barangay,
			#street,
			select {
				width: 300px;
				height: 40px;
				padding-left: 15px;
				border: solid 2px;
				border-radius: 10px;
				margin: 5px 0 10px 0;
				background: rgba(255, 255, 255, 0.2);
				font-size: 16px;
				border-color: #A9A9A9;
			}
			.input-box {
				width: 300px;
				height: 110px;
			}
			.input-box#Type-box,
			.input-box#Zone-box,
			select#incident_type,
			.input-box#Event-box,
			select#zone,
			input[type=date],
			.input-box#Age-box,
			input[type=text]#age,
			.input-box#Sex-box,
			select#sex {
				width: 200px;
			}
			input[type="date"]::-webkit-calendar-picker-indicator {
				position: relative;
				right: 5%;
			}
			i.fa-exclamation-circle {
				position: relative;
				bottom: 60%;
				left: 90%;
			}
			.message,
			i.fas.fa-exclamation-circle {
				visibility: hidden;
				color: #e74c3c;
			}
			.input-box.error #barangay,
			.input-box.error #name,
			.input-box.error #address,
			.input-box.error #age,
			.input-box.error #sex,
			.input-box.error #classification {
				border-color: #e74c3c;
			}
			.input-box.error .message,
			.input-box.error i.fa-exclamation-circle {
				visibility: visible;
			}




			.sub-container2 {
				padding: 20px 0 0 230px;
			}
			.form-container {
				display: flex;
				flex-wrap: wrap;
				gap: 50px;
				width: 1070px;
			}
			.form-section {
				height: 620px;
				width: 510px;
				padding: 20px 40px;
				box-shadow: 0 0 40px rgba(0, 0, 0, 0.12);
				border-radius: 20px;
			}
			.victim-number {
				display: flex;
				justify-content: center;
			}
			input[type=text]#name {
				width: 430px;
			}
			.input-box#Name-box {
				width: 430px;
			}
			.input-box#Address-box {
				width: 430px;
				height: 140px;
			}
			.input-box#Classification-box {
				width: 430px;
				height: 190px;
			}
			textarea {
				width: 430px;
				font-size: 16px;
				padding: 7px 15px;
				margin: 5px 0 10px 0;
				border: solid 2px;
				border-radius: 10px;
				resize: none;
				background: rgba(255, 255, 255, 0.2);
				border-color: #A9A9A9;
			}
			#classification {
				height: 120px;
			}
			.input-container#row5 {
				width: 430px;
			}
			#Age-box i.fas.fa-exclamation-circle,
			#Sex-box i.fas.fa-exclamation-circle {
				left: 80%;
			}

			.fa.fa-circle-xmark {
				cursor: pointer;
				position: relative;
				bottom: 5%;
				left: 106%;
				font-size: 25px;
				color: #e74c3c;
			}




			#add {
				display: flex;
				justify-content: center;
				align-items: center;
				flex-direction: column;
				gap: 10px;
				height: 620px;
				width: 510px;
				padding: 20px 40px;
				box-shadow: 0 0 40px rgba(0, 0, 0, 0.12);
				border-radius: 20px;
			}
			.fa.fa-square-plus {
				font-size: 100px;
			}
			#add span {
				font-size: 20px;
			}
			.btn {
				position: relative;
				left: 36%;
				padding-top: 50px;
			}
			.btn button {
				padding: 10px 30px;
				font-size: 18px;
				letter-spacing: 1px;
				color: #725AC1;
				background: transparent;
				cursor: pointer;
				transition: ease-out 0.5s;
				border: 2px solid #725AC1;
				border-radius: 10px;
				box-shadow: inset 0 0 0 0 #725AC1;
			}
			.btn button:hover {
				color: white;
				box-shadow: inset 0 -100px 0 0 #725AC1;
			}
			.btn button:active {
				transform: scale(0.9);
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
		<?php
			include_once "php/config.php";
			$report_id = isset($_GET['report_id']) ? $_GET['report_id'] : '';

			$sql = "SELECT ir.report_id, ir.status, ir.incident_type, ir.barangay, ir.zone, ir.street, ir.user_id,
				 u.last_name, u.first_name, u.position, ir.event_at, ir.event_time,ir.update_at, img.file_path
				FROM incident_report AS ir
				LEFT JOIN image AS img
				ON ir.ref_id = img.ref_id
				LEFT JOIN user AS u
				ON ir.user_id = u.user_id
				WHERE ir.report_id = $report_id";

			$result = $conn->query($sql);

			if ($result && $result->num_rows > 0) {
				$row = $result->fetch_all(MYSQLI_ASSOC);

				$statusClass = '';
				switch ($row[0]['status']) {
					case 'pending':
						$statusClass = 'pending';
						break;
					case 'resolved':
						$statusClass = 'resolved';
						break;
					case 'ongoing':
						$statusClass = 'ongoing';
						break;
				}

				$icon = '';
				switch ($row[0]['incident_type']) {
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
					<i><?php echo $row[0]['incident_type']; ?></i>
				</div>
				<?php
					$eventDateTime = $row[0]['update_at'];

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
								<li class="splide__slide"><img src="php/<?php echo $image['file_path']; ?>" alt=""></li>
							<?php } ?>

						</ul>
						</div>
					</section>
				</div>
				<form class="report" id="report" autocomplete="off" action="" method="post" enctype="multipart/form-data">
					<div class="input-container" id="row1">
						<span class="status <?php echo $statusClass; ?>"><?php echo $row[0]['status']; ?></span>
					</div>
					<div class="input-container" id="row2">
						<div class="input-box" id="Type-box">
							<label for="incident_type">Incident Type</label>
							<select id="incident_type" name="incident_type">
								<option value="" disabled selected>Incident Type</option>
								<option value="Fire Incident" <?php echo ($row[0]['incident_type'] == 'Fire Incident') ? 'selected' : ''; ?>>Fire Incident</option>
								<option value="Vehicular Accident" <?php echo ($row[0]['incident_type'] == 'Vehicular Accident') ? 'selected' : ''; ?>>Vehicular Accident</option>
								<option value="Flood Incident" <?php echo ($row[0]['incident_type'] == 'Flood Incident') ? 'selected' : ''; ?>>Flood Incident</option>
								<option value="Landslide Incident" <?php echo ($row[0]['incident_type'] == 'Landslide Incident') ? 'selected' : ''; ?>>Landslide Incident</option>
							</select>
						</div>

						<div class="input-box" id="Barangay-box">
							<label for="barangay">Barangay</label>
							<select id="barangay" name="barangay">
								<option value="" disabled selected>Barangay</option>
								<option value="Adiangao" <?php echo ($row[0]['barangay'] == 'Adiangao') ? 'selected' : ''; ?>>Adiangao</option>
								<option value="Bagacay" <?php echo ($row[0]['barangay'] == 'Bagacay') ? 'selected' : ''; ?>>Bagacay</option>
								<option value="Bahay" <?php echo ($row[0]['barangay'] == 'Bahay') ? 'selected' : ''; ?>>Bahay</option>
								<option value="Boclod" <?php echo ($row[0]['barangay'] == 'Boclod') ? 'selected' : ''; ?>>Boclod</option>
								<option value="Calalahan" <?php echo ($row[0]['barangay'] == 'Calalahan') ? 'selected' : ''; ?>>Calalahan</option>
								<option value="Calawit" <?php echo ($row[0]['barangay'] == 'Calawit') ? 'selected' : ''; ?>>Calawit</option>
								<option value="Camagong" <?php echo ($row[0]['barangay'] == 'Camagong') ? 'selected' : ''; ?>>Camagong</option>
								<option value="Catalotoan" <?php echo ($row[0]['barangay'] == 'Catalotoan') ? 'selected' : ''; ?>>Catalotoan</option>
								<option value="Danlog" <?php echo ($row[0]['barangay'] == 'Danlog') ? 'selected' : ''; ?>>Danlog</option>
								<option value="Del Carmen (Poblacion)" <?php echo ($row[0]['barangay'] == 'Del Carmen (Poblacion)') ? 'selected' : ''; ?>>Del Carmen (Poblacion)</option>
								<option value="Dolo" <?php echo ($row[0]['barangay'] == 'Dolo') ? 'selected' : ''; ?>>Dolo</option>
								<option value="Kinalansan" <?php echo ($row[0]['barangay'] == 'Kinalansan') ? 'selected' : ''; ?>>Kinalansan</option>
								<option value="Mampirao" <?php echo ($row[0]['barangay'] == 'Mampirao') ? 'selected' : ''; ?>>Mampirao</option>
								<option value="Manzana" <?php echo ($row[0]['barangay'] == 'Manzana') ? 'selected' : ''; ?>>Manzana</option>
								<option value="Minoro" <?php echo ($row[0]['barangay'] == 'Minoro') ? 'selected' : ''; ?>>Minoro</option>
								<option value="Palale" <?php echo ($row[0]['barangay'] == 'Palale') ? 'selected' : ''; ?>>Palale</option>
								<option value="Ponglon" <?php echo ($row[0]['barangay'] == 'Ponglon') ? 'selected' : ''; ?>>Ponglon</option>
								<option value="Pugay" <?php echo ($row[0]['barangay'] == 'Pugay') ? 'selected' : ''; ?>>Pugay</option>
								<option value="Sabang" <?php echo ($row[0]['barangay'] == 'Sabang') ? 'selected' : ''; ?>>Sabang</option>
								<option value="Salogon" <?php echo ($row[0]['barangay'] == 'Salogon') ? 'selected' : ''; ?>>Salogon</option>
								<option value="San Antonio (Poblacion)" <?php echo ($row[0]['barangay'] == 'San Antonio (Poblacion)') ? 'selected' : ''; ?>>San Antonio (Poblacion)</option>
								<option value="San Juan (Poblacion)" <?php echo ($row[0]['barangay'] == 'San Juan (Poblacion)') ? 'selected' : ''; ?>>San Juan (Poblacion)</option>
								<option value="San Vicente (Poblacion)" <?php echo ($row[0]['barangay'] == 'San Vicente (Poblacion)') ? 'selected' : ''; ?>>San Vicente (Poblacion)</option>
								<option value="Santa Cruz (Poblacion)" <?php echo ($row[0]['barangay'] == 'Santa Cruz (Poblacion)') ? 'selected' : ''; ?>>Santa Cruz (Poblacion)</option>
								<option value="Soledad (Poblacion)" <?php echo ($row[0]['barangay'] == 'Soledad (Poblacion)') ? 'selected' : ''; ?>>Soledad (Poblacion)</option>
								<option value="Tagas" <?php echo ($row[0]['barangay'] == 'Tagas') ? 'selected' : ''; ?>>Tagas</option>
								<option value="Tambangan" <?php echo ($row[0]['barangay'] == 'Tambangan') ? 'selected' : ''; ?>>Tambangan</option>
								<option value="Telegrafo" <?php echo ($row[0]['barangay'] == 'Telegrafo') ? 'selected' : ''; ?>>Telegrafo</option>
								<option value="Tominawog" <?php echo ($row[0]['barangay'] == 'Tominawog') ? 'selected' : ''; ?>>Tominawog</option>
							</select>
						</div>
					</div>
					<div class="input-container" id="row3">
						<div class="input-box" id="Zone-box">
							<label for="zone">Zone</label>
							<select id="zone" name="zone">
								<option value="" disabled selected>Zone</option>
								<option value="1" <?php echo ($row[0]['zone'] == '1') ? 'selected' : ''; ?>>1</option>
								<option value="2" <?php echo ($row[0]['zone'] == '2') ? 'selected' : ''; ?>>2</option>
								<option value="3" <?php echo ($row[0]['zone'] == '3') ? 'selected' : ''; ?>>3</option>
								<option value="4" <?php echo ($row[0]['zone'] == '4') ? 'selected' : ''; ?>>4</option>
								<option value="5" <?php echo ($row[0]['zone'] == '5') ? 'selected' : ''; ?>>5</option>
								<option value="6" <?php echo ($row[0]['zone'] == '6') ? 'selected' : ''; ?>>6</option>
								<option value="7" <?php echo ($row[0]['zone'] == '7') ? 'selected' : ''; ?>>7</option>
							</select>
						</div>

						<div class="input-box" id="Street-box">
							<label for="street">Street / Sitio</label>
							<input type="text" name="street" id="street" placeholder="Street / Sitio" value="<?php echo htmlspecialchars($row[0]['street']); ?>">
						</div>
					</div>
					<div class="input-container" id="row4">
						<div class="input-box" id="Event-box">
							<label for="event_at">Date</label>
							<input type="date" name="event_at" id="event_at" value="<?php echo htmlspecialchars($row[0]['event_at']); ?>">
						</div>
						<div class="input-box" id="Report-box">
							<label for="report_by">Reported by</label>
							<input type="text" class="report_by" id="report_by" value="<?php echo htmlspecialchars($row[0]['position'] . ' ' . $row[0]['first_name'] . ' ' . $row[0]['last_name']); ?>" disabled>
						</div>
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

						$sql = "SELECT victim_id, name, age, address, sex, classification FROM victim WHERE ref_id = ?";

						$stmt = $conn->prepare($sql);
						$stmt->bind_param("i", $report_id);
						$stmt->execute();
						$result = $stmt->get_result();

						if ($result->num_rows > 0) {
							while ($row = $result->fetch_assoc()) {
								echo "
									<div class='form-section'  id='victim" . htmlspecialchars($row['victim_id']) . "'>
										<input type='hidden' name='victim_id' value='" . htmlspecialchars($row['victim_id']) . "'>

										<i class='fa fa-circle-xmark' onclick='deleteVictim(" . htmlspecialchars($row['victim_id']) . ")'></i>

										<div class='input-box' id='Name-box'>
											<label for='name'>Name</label>
											<input type='text' name='update_name[]' id='name' placeholder='Name' value='" . htmlspecialchars($row['name']) . "'>
											<div class='message'>Error message</div>
											<i class='fas fa-exclamation-circle'></i>
										</div>
										<div class='input-box' id='Address-box'>
											<label for='address'>Address</label>
											<textarea name='update_address[]' id='address' placeholder='Address'>" . htmlspecialchars($row['address']) . "</textarea>
											<div class='message'>Error message</div>
											<i class='fas fa-exclamation-circle'></i>
										</div>
										<div class='input-container' id='row5'>
											<div class='input-box' id='Age-box'>
												<label for='age'>Age</label>
												<input type='text' name='update_age[]' id='age' placeholder='Age' value='" . htmlspecialchars($row['age']) . "'>
												<div class='message'>Error message</div>
												<i class='fas fa-exclamation-circle'></i>
											</div>
											<div class='input-box' id='Sex-box'>
												<label for='sex'>Sex</label>
												<select name='update_sex[]' id='sex'>
													<option value='' disabled selected>Sex</option>
													<option value='male'" . ($row['sex'] == 'male' ? ' selected' : '') . ">Male</option>
													<option value='female'" . ($row['sex'] == 'female' ? ' selected' : '') . ">Female</option>
												</select>
												<div class='message'>Error message</div>
												<i class='fas fa-exclamation-circle'></i>
											</div>
										</div>
										<div class='input-box' id='Classification-box'>
											<label for='classification'>Classification</label>
											<textarea name='update_classification[]' id='classification' placeholder='Classification'>" . htmlspecialchars($row['classification']) . "</textarea>
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
		<div class="input-container" id="row5">
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