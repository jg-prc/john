<?php
	session_start();

	if (!isset($_SESSION['unique_id']) || $_SESSION['role'] !== '1') {
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
		<link rel="stylesheet" href="css/sidebar-user.css">
		<link rel="stylesheet" href="css/user-send.css">
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
				<li class="active">
					<a href="user-send.php">
						<i class="fas fa-paper-plane"></i>
						<span class="link_name">Send Report</span>
					</a>
					<ul class="sub-menu blank">
						<li><a class="link_name">Send Report</a></li>
					</ul>
				</li>
				<li>
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
				<i class="fas fa-paper-plane"></i>
				<i>Send Report</i>
			</div>
			<div class="sub-container">
				<form class="send" id="send" autocomplete="off" action="" method="post" enctype="multipart/form-data">
					<div class="input-container" id="row1">
						<div class="input-box" id="Type-box">
							<label for="incident_type">Incident Type</label>
							<select id="incident_type" name="incident_type">
								<option value="" disabled selected>Incident Type</option>
								<option value="1">Fire Incident</option>
								<option value="2">Vehicular Accident</option>
								<option value="3">Flood Incident</option>
								<option value="4">Landslide Incident</option>
							</select>
							<div class="message">Error message</div>
							<i class="fas fa-exclamation-circle"></i>
						</div>
						<div class="input-box" id="Barangay-box">
							<label for="barangay">Barangay</label>
							<select id="barangay" name="barangay">
								<option value="" disabled selected>Barangay</option>
								<option value="1">Adiangao</option> 
								<option value="2">Bagacay</option>
								<option value="3">Bahay</option>
								<option value="4">Boclod</option>
								<option value="5">Calalahan</option>
								<option value="6">Calawit</option>
								<option value="7">Camagong</option>
								<option value="8">Catalotoan</option>
								<option value="9">Danlog</option>
								<option value="10">Del Carmen (Poblacion)</option>
								<option value="11">Dolo</option>
								<option value="12">Kinalansan</option>
								<option value="13">Mampirao</option>
								<option value="14">Manzana</option>
								<option value="15">Minoro</option>
								<option value="16">Palale</option>
								<option value="17">Ponglon</option>
								<option value="18">Pugay</option>
								<option value="19">Sabang</option>
								<option value="20">Salogon</option>
								<option value="21">San Antonio (Poblacion)</option>
								<option value="22">San Juan (Poblacion)</option>
								<option value="23">San Vicente (Poblacion)</option>
								<option value="24">Santa Cruz (Poblacion)</option>
								<option value="25">Soledad (Poblacion)</option>
								<option value="26">Tagas</option>
								<option value="27">Tambangan</option>
								<option value="28">Telegrafo</option>
								<option value="29">Tominawog</option>

							</select>
							<div class="message">Error message</div>
							<i class="fas fa-exclamation-circle"></i>
						</div>
					</div>
					<div class="input-container" id="row3">
						<div class="input-box" id="Zone-box">
							<label for="zone">Zone</label>
							<select id="zone" name="zone">
								<option value="" disabled selected>Zone</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
							</select>
							<div class="message">Error message</div>
							<i class="fas fa-exclamation-circle"></i>
						</div>
						<div class="input-box" id="Street-box">
							<label for="street">Street / Sitio</label>
							<input type="text" name="street" id="street" placeholder="Street / Sitio">
						</div>
					</div>
					<div class="input-container" id="row2">
						<div class="input-box" id="Images-box">
							<span class="images">Images</span>
							<label for="images">Upload Images</label>
							<input type="file" name="images[]" id="images" multiple accept="image/*" onchange="previewImages()" style="display: none;">

							<div id="preview" class="image-wrapper">
								<div class="image-box">
								</div>
							</div>
						</div>
					</div>
					<div class="btn">
						<button class="send-btn" type="submit">Send</button>
					</div>
				</form>
			</div>
		</div>
	</body>
	<script src="js/sidebar.js"></script>
	<script src="js/send.js"></script>
	<script src="js/logout.js"></script>
	<script>
		let selectedFiles = [];

		function previewImages() {
			const preview = document.getElementById('preview');
			const files = document.getElementById('images').files;
        
			Array.from(files).forEach(file => selectedFiles.push(file));

			updatePreview();
		}

		function updatePreview() {
			const preview = document.getElementById('preview');
			preview.innerHTML = "";

			selectedFiles.forEach((file, index) => {
				const reader = new FileReader();
				reader.onload = function(event) {

					const container = document.createElement('div');
					container.classList.add('image-box');

					const img = document.createElement('img');
					img.src = event.target.result;
					img.classList.add('preview-image');

					const removeBtn = document.createElement('a');
					removeBtn.classList.add('close-btn');
					removeBtn.innerHTML = 'x';
					removeBtn.onclick = function() {
						removeImage(index);
					};

					container.appendChild(img);
					container.appendChild(removeBtn);
					preview.appendChild(container);
				};
				reader.readAsDataURL(file);
			});
		}

		function removeImage(index) {
			selectedFiles.splice(index, 1);
			updateInputFiles();
			updatePreview();
		}

		function updateInputFiles() {
			const input = document.getElementById('images');
			const dataTransfer = new DataTransfer();

			selectedFiles.forEach(file => dataTransfer.items.add(file));

			input.files = dataTransfer.files;
		}
	</script>
</html>