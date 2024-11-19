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
		<link rel="icon" href="php/image/logo.png" type="image/png">
		<title>SAN JOSE INCIDENT RECORD  MANAGEMENT AND MAPPING SYSTEM</title>
		<style>
			body::-webkit-scrollbar {
				display: none;
			}
			.container {
				height: 100vh;
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
			.sub-container {
				display: flex;
				justify-content: center;
				padding-top: 30px;
			}
			.details {
				width: 1000px;
				height: 560px;
				padding: 10px;
				box-shadow: 0 0 40px rgba(0, 0, 0, 0.12);
				border-radius: 20px;
				background-color: #ffffff;
			}
			.image-container {
				width: 150px;
				position: relative;
				left: 8%;
				top: 60px;

			}
			.image img{
				width: 150px;
				height: 150px;
				object-fit: cover;
				border-radius: 50%;
				cursor: pointer;
			}
			#file-path{
				display: none;
			}
			.image label{
				position: relative;
				top: -25px;
				left: 55px;
				color: #fff;
				background-color: #1b74e4;
				width: 40px;
				height: 40px;
				display: flex;
				align-items: center;
				justify-content: center;
				border-radius: 50%;
				font-size: 20px;
				cursor: pointer;
			}
			input[type=text],
			input[type=date],
			input[type=tel],
			#barangay,
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
			select#sex,
			select#zone {
				width: 200px;
			}
			input[type="date"]::-webkit-calendar-picker-indicator {
				position: relative;
				right: 5%;
			}
			.input-container {
				display: flex;
				position: relative;
				bottom: 155px;
				width: 650px;
				justify-content: space-between;
				left: 30%;
			}
			.input-container#row3,
			.input-container#row4 {
				width: 904px;
				left: 4%;
			}
			.sub-input-container {
				display: flex;
				width: 552px;
				justify-content: space-between;
			}
			.input-box {
				width: 300px;
				height: 110px;
			}

			.input-box#Sex-box,
			.input-box#Zone-box {
				width: 200px;
			}
			.message,
			.input-container label {
				padding-left: 10px;
			}
			i.fa-exclamation-circle {
				position: relative;
				bottom: 60%;
				left: 90%;
			}
			#Barangay-box i.fa-exclamation-circle,
			#Bdate-box i.fa-exclamation-circle,
			#Sex-box i.fa-exclamation-circle,
			#Zone-box i.fa-exclamation-circle {
				left: 78%;
			}
			#Position-box i.fa-exclamation-circle {
				left: 85%;
			}
			.message,
			i.fas.fa-exclamation-circle {
				visibility: hidden;
				color: #e74c3c;
			}
			.input-box.error .message,
			.input-box.error i.fa-exclamation-circle {
				visibility: visible;
			}
			.input-box.error input[type=tel],
			.input-box.error input[type=date],
			.input-box.error input[type=text],
			.input-box.error select,
			.input-box.error #barangay {
				border-color: #e74c3c;
			}
			.details .btn {
				display: flex;
				justify-content: center;
				position: relative;
				bottom: 160px;
			}
			button {
				background-color: #6A8BB4;
				color: #fff;
				padding: 10px 30px;
				border-radius: 20px;
				font-weight: bold;
				box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
				display: flex;
				align-items: center;
				gap: 8px;
				border: none;
				transition: background-color 0.3s, transform 0.2s;
			}
			button:hover {
				background-color: #5a7aa2;
				transform: translateY(-2px);
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
				}
				.title i{
					padding-top: 10px;
				}
				.sub-container {
					padding-top: 0;
				}
				.details {
					width: 100%;
					height: 1200px;
					padding: 0;
					padding-top: 30px;
					background-color: unset;
					border-radius: 0;
				}
				.image-container {
					position: unset;
					width: unset;
					display: flex;
					justify-content: center;
				}
				input[type=text],
				input[type=date],
				input[type=tel],
				#barangay,
				select {
					width: 100%;
				}
				.input-container {
					flex-direction: column;
					position: unset;
					width: unset;
					align-items: center;
				}
				.input-box {
					width: 288px;
				}
				.input-container#row3,
				.input-container#row4 {
					width: unset;
				}
				.sub-input-container {
					width: 288px;
				}
				.input-box#Bdate-box,
				.input-box#Position-box {
					width: 175px;
				}
				.input-box#Sex-box,
				.input-box#Zone-box {
					width: 100px;
				}
				select#sex,
				select#zone {
					width: 100%;
				}
				#Bdate-box i.fa-exclamation-circle {
					left: 74%;
				}
				#Sex-box i.fa-exclamation-circle {
					left: 63%;
					bottom: 81%;
				}
				#Barangay-box i.fa-exclamation-circle {
					left: 90%;
				}
				#Zone-box i.fa-exclamation-circle {
					left: 66%;
					bottom: 81%;
				}
				#Position-box i.fa-exclamation-circle {
					left: 77%;
				}
				.details .btn {
					bottom: -26px;
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
				<li>
					<a href="user-report.php">
						<i class="fas fa-archive"></i>
						<span class="link_name">History</span>
					</a>
					<ul class="sub-menu blank">
						<li><a class="link_name">History</a></li>
					</ul>
				</li>
				<li class="active">
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
				<i class="fa-regular fa-circle-user"></i>
				<i>Personal Information</i>
			</div>
			<div class="sub-container">
			<?php
				include_once "php/config.php";

					$unique_id = $_SESSION['unique_id'];

					$stmt = $conn->prepare("SELECT
									o.FirstName, o.MiddleName, o.LastName,
									o.ExtensionName, o.ContactNumber, o.Birthdate,
									o.Sex, o.Zone, o.EmailAddress, o.ImageURL,
									p.PositionName, b.BarangayName
								FROM
									barangay_officials as o
								LEFT JOIN
									position AS p ON o.PositionID = p.PositionID
								LEFT JOIN
									barangay as b on o.BarangayID = b.BarangayID
								WHERE OfficialsID = ?");

					$stmt->bind_param("s", $unique_id);
					$stmt->execute();
					$result = $stmt->get_result();

					if ($result->num_rows > 0) {
						$row = $result->fetch_assoc(); // Fetch the row data
			?>

				<form class="details" id="details" autocomplete="off" action="" method="post">
					<div class="image-container">
						<div class="image">
							<img src="php/profile/<?php echo htmlspecialchars($row['ImageURL']); ?>">
							<label for="file-path">
								<span class="material-symbols-rounded">photo_camera</span>
							</label>
							<input type="file" name="image" accept="image/*" id="file-path" class="user-file">
						</div>
					</div>
					<div class="input-container" id="row1">

						<div class="input-box" id="Fname-box">

							<label for="firstname">First Name</label>

							<input type="text" name="firstname" id="firstname" placeholder="First Name" value="<?php echo htmlspecialchars($row['FirstName']); ?>">
							<div class="message">Error message</div>
							<i class="fas fa-exclamation-circle"></i>
						</div>

						<div class="input-box" id="Lname-box">

							<label for="lastname">Last Name</label>

							<input type="text" name="lastname" id="lastname" placeholder="Last Name" value="<?php echo htmlspecialchars($row['LastName']); ?>">
							<div class="message">Error message</div>
							<i class="fas fa-exclamation-circle"></i>
						</div>
					</div>
					<div class="input-container" id="row2">

						<div class="input-box" id="Mname-box">

							<label for="middlename">Middle Name</label>

							<input type="text" name="middlename" id="middlename" placeholder="Middle Name" value="<?php echo htmlspecialchars($row['MiddleName']); ?>">
							<div class="message">Error message</div>
							<i class="fas fa-exclamation-circle"></i>
						</div>

						<div class="input-box" id="Ename-box">

							<label for="extensionname">Extension Name</label>

							<input type="text" name="extensionname" id="extensionname" placeholder="Extension Name" value="<?php echo htmlspecialchars($row['ExtensionName']); ?>">
						</div>
					</div>
					<div class="input-container" id="row3">
						<div class="sub-input-container">
							<div class="input-box" id="Bdate-box">

								<label for="bdate">Brithdate</label>

								<input type="date" name="bdate" id="bdate" value="<?php echo htmlspecialchars($row['Birthdate']); ?>">
								<div class="message">Error message</div>
								<i class="fas fa-exclamation-circle"></i>
							</div>

							<div class="input-box" id="Sex-box">

								<label for="sex">Sex</label>

								<select id="sex" name="sex">
									<option value="" disabled selected>Sex</option>
									<option value="male" <?php echo ($row['Sex'] == 'male') ? 'selected' : ''; ?>>Male</option>
									<option value="female" <?php echo ($row['Sex'] == 'female') ? 'selected' : ''; ?>>Female</option>
								</select>
								<div class="message">Error message</div>
								<i class="fas fa-exclamation-circle"></i>
							</div>
						</div>
						<div class="input-box" id="Contact-box">

							<label for="contact">Contact No.</label>

							<input type="tel" name="contact" id="contact" maxlength="11" placeholder="Contact No." oninput="this.value = this.value.replace(/[^0-9]/g, '');" value="<?php echo $row['ContactNumber'];?>">
							<div class="message">Error message</div>
							<i class="fas fa-exclamation-circle"></i>
						</div>
					</div>

					<div class="input-container" id="row4">

						<div class="input-box" id="Barangay-box">
							<label for="barangay">Barangay</label>
							<select id="barangay" name="barangay">
								<option value="" disabled <?php echo empty($row['BarangayName']) ? 'selected' : ''; ?>>Barangay</option>
								<?php
									$barangays = [
										"Adiangao", "Bagacay", "Bahay", "Boclod", "Calalahan", "Calawit", 
										"Camagong", "Catalotoan", "Danlog", "Del Carmen (Poblacion)", 
										"Dolo", "Kinalansan", "Mampirao", "Manzana", "Minoro", "Palale", 
										"Ponglon", "Pugay", "Sabang", "Salogon", "San Antonio (Poblacion)", 
										"San Juan (Poblacion)", "San Vicente (Poblacion)", "Santa Cruz (Poblacion)", 
										"Soledad (Poblacion)", "Tagas", "Tambangan", "Telegrafo", "Tominawog"
									];

									foreach ($barangays as $index => $barangay) {
										$value = $index + 1; // Convert to 1-based index
										$selected = ($row['BarangayName'] === $barangay) ? 'selected' : '';
										echo "<option value=\"$value\" $selected>" . htmlspecialchars($barangay) . "</option>";
									}
								?>
							</select>
							<div class="message">Error message</div>
							<i class="fas fa-exclamation-circle"></i>
						</div>


						<div class="sub-input-container">
							<div class="input-box" id="Zone-box">

								<label for="zone">Zone</label>

								<select id="zone" name="zone">
									<option value="" disabled selected>Zone</option>
									<option value="1" <?php echo ($row['Zone'] == '1') ? 'selected' : ''; ?>>1</option>
									<option value="2" <?php echo ($row['Zone'] == '2') ? 'selected' : ''; ?>>2</option>
									<option value="3" <?php echo ($row['Zone'] == '3') ? 'selected' : ''; ?>>3</option>
									<option value="4" <?php echo ($row['Zone'] == '4') ? 'selected' : ''; ?>>4</option>
									<option value="5" <?php echo ($row['Zone'] == '5') ? 'selected' : ''; ?>>5</option>
									<option value="6" <?php echo ($row['Zone'] == '6') ? 'selected' : ''; ?>>6</option>
									<option value="7" <?php echo ($row['Zone'] == '7') ? 'selected' : ''; ?>>7</option>
								</select>
								<div class="message">Error message</div>
								<i class="fas fa-exclamation-circle"></i>
							</div>

							<div class="input-box" id="Position-box">

								<label for="position">Position</label>

								<select id="position" name="position">
									<option value="" disabled selected>Position</option>
									<option value="1" <?php echo ($row['PositionName'] == 'Brgy. Captain') ? 'selected' : ''; ?>>Brgy. Captain</option>
									<option value="2" <?php echo ($row['PositionName'] == 'Brgy. Kagawad') ? 'selected' : ''; ?>>Brgy. Kagawad</option>
								</select>
								<div class="message">Error message</div>
								<i class="fas fa-exclamation-circle"></i>
							</div>
						</div>
					</div>
					<div class="btn">
						<button type="submit">Update</button>
					</div>
				</form>

			<?php
					} else {
						echo "No data found.";
					}
			?>

			</div>
		</div>
	</body>
	<script src="js/sidebar.js"></script>
	<script src="js/image.js"></script>
	<script src="js/user-profile.js"></script>
	<script src="js/logout.js"></script>
	<script>

	</script>
</html>