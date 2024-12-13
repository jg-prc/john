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
		<link rel="stylesheet" href="css/create.css">
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
						<li><a class="active" href="create.php">Create account</a></li>
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
			<div class="title">
				<img src="php/image/logo.png" alt="profileImg">
				<i class="fas fa-user-plus"></i>
				<i><strong>Create User Account</strong></i>
			</div>
			<form class="form-create" id="form-create" autocomplete="off" action="#" method="POST" enctype="multipart/form-data">
				<div class="image">
					<img src="php/image/default_image.png">
					<label for="file-path">
						<span class="material-symbols-rounded">photo_camera</span>
					</label>
					<input type="file" name="image" accept="image/*" id="file-path" class="user-file">
				</div>

				<div class="input-container" id="row1">

					<div class="input-box" id="Fname-box">

						<span class="required">*</span>
						<label for="firstname">First Name</label>
						<input type="text" name="firstname" id="firstname" placeholder="First Name">
						<div class="message">Error message</div>
						<i class="fas fa-exclamation-circle"></i>
					</div>

					<div class="input-box" id="Lname-box">

						<span class="required">*</span>
						<label for="lastname">Last Name</label>
						<input type="text" name="lastname" id="lastname" placeholder="Last Name">
						<div class="message">Error message</div>
						<i class="fas fa-exclamation-circle"></i>
					</div>
				</div>
				<div class="input-container" id="row2">

					<div class="input-box" id="Mname-box">

						<span class="required">*</span>
						<label for="middlename">Middle Name</label>
						<input type="text" name="middlename" id="middlename" placeholder="Middle Name">
						<div class="message">Error message</div>
						<i class="fas fa-exclamation-circle"></i>
					</div>

					<div class="input-box" id="Ename-box">

						<label for="extensionname">Extension Name</label>

						<input type="text" name="extensionname" id="extensionname" placeholder="Extension Name">
						<div class="message">Error message</div>
						<i class="fas fa-exclamation-circle"></i>
					</div>
				</div>

				<div class="input-container" id="row3">

					<div class="input-box" id="Bdate-box">

						<span class="required">*</span>
						<label for="bdate">Brithdate</label>
						<input type="date" name="bdate" id="bdate">
						<div class="message">Error message</div>
						<i class="fas fa-exclamation-circle"></i>
					</div>

					<div class="input-box" id="Sex-box">

						<span class="required">*</span>
						<label for="sex">Sex</label>
						<select id="sex" name="sex">
							<option value="" disabled selected>Sex</option>
							<option value="male">Male</option>
							<option value="female">Female</option>
						</select>
						<div class="message">Error message</div>
						<i class="fas fa-exclamation-circle"></i>
					</div>

					<div class="input-box" id="Contact-box">

						<span class="required">*</span>
						<label for="contact">Contact No.</label>
						<input type="tel" name="contact" id="contact" maxlength="11" placeholder="Contact No." oninput="this.value = this.value.replace(/[^0-9]/g, '');">
						<div class="message">Error message</div>
						<i class="fas fa-exclamation-circle"></i>
					</div>
				</div>

				<div class="input-container" id="row4">

					<div class="input-box" id="Barangay-box">

						<span class="required">*</span>
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

					<div class="input-box" id="Zone-box">

						<span class="required">*</span>
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

					<div class="input-box" id="Position-box">

						<span class="required">*</span>
						<label for="position">Position</label>
						<select id="position" name="position">
							<option value="" disabled selected>Position</option>
							<option value="1">Brgy. Captain</option>
							<option value="2">Brgy. Kagawad</option>
						</select>
						<div class="message">Error message</div>
						<i class="fas fa-exclamation-circle"></i>
					</div>
				</div>

				<div class="input-container" id="row5">

					<div class="input-box" id="Email-box">

						<span class="required">*</span>
						<label for="email">Email</label>
						<input type="email" name="email" id="email" placeholder="Email">
						<div class="message">Error message</div>
						<i class="fas fa-exclamation-circle"></i>
					</div>

					<div class="input-box" id="Password-box">

						<span class="required">*</span>
						<label for="password">Password</label>
						<input type="text" name="password" id="password" placeholder="Password">
						<div class="message">Error message</div>
						<i class="fas fa-exclamation-circle"></i>
						<i id="icon" class="fa fa-shuffle" onclick="generatePassword()"></i>
					</div>

				</div>
				<div class="btn">
					<button type="submit">Create</button>
				</div>
			</form>
		</div>
	</body>
	<script src="js/sidebar.js"></script>
	<script src="js/generate-pass.js"></script>
	<script src="js/image.js"></script>
	<script src="js/create.js"></script>
	<script src="js/logout.js"></script>
	<script>
	</script>
</html>