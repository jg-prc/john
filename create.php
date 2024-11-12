<?php
	session_start();
	if (!isset($_SESSION['unique_id']) || $_SESSION['role'] !== 'admin') {
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
		<title>Responsive Layout</title>
		<style>
			body::-webkit-scrollbar {
				display: none;
			}
			.container {
				height: 1000px;
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
			form {
				position: relative;
				left: 19%;
				top: 40px;
				width: 1000px;
				height: 730px;
				padding: 10px;
				box-shadow: 0 0 40px rgba(0, 0, 0, 0.12);
				border-radius: 20px;
				background-color: #ffffff;
			}
			.image {
				width: 200px;
				position: relative;
				left: 5%;
				top: 60px;

			}
			.image img{
				width: 200px;
				height: 200px;
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
				left: 80px;
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
			input[type=email],
			input[type=password],
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
			:focus {
				outline: none;
			}
			input:focus,
			textarea:focus {
				background: rgba(255, 255, 255, 0.3);
				border: 2px solid #e0e0e0;
				transition: background 0.5s ease;
			}
			input[type=email] {
				width: 427px;
			}
			#Password-box input[type=text] {
				width: 427px;
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
				bottom: 175px;
				width: 650px;
				justify-content: space-between;
				left: 30%;
			}
			.input-container#row3,
			.input-container#row4,
			.input-container#row5 {
				width: 904px;
				left: 4%;
			}
			.input-box {
				width: 300px;
				height: 110px;
			}
			.input-box#Sex-box,
			.input-box#Zone-box {
				width: 200px;
			}
			.input-box#Email-box,
			.input-box#Password-box {
				width: 427px;
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
			#Barangay-box i.fa-exclamation-circle {
				left: 85%;
			}
			#Bdate-box i.fa-exclamation-circle,
			#Sex-box i.fa-exclamation-circle,
			#Zone-box i.fa-exclamation-circle {
				left: 78%;
			}
			#Position-box i.fa-exclamation-circle {
				left: 85%;
			}
			#Password-box i.fa-exclamation-circle {
				left: 83%;
			}
			i.fa-shuffle {
				position: relative;
				bottom: 60%;
				left: 85%;
				cursor: pointer;
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
			.input-box.error input[type=email],
			.input-box.error input[type=password],
			.input-box.error input[type=text],
			.input-box.error select,
			.input-box.error #barangay {
				border-color: #e74c3c;
			}
			.btn {
				display: flex;
				justify-content: center;
				position: relative;
				bottom: 160px;
			}
			button {
				padding: 10px 30px;
				font-size: 18px;
				letter-spacing: 1px;
				color: #FFFFFF;
				background: #4A90E2;
				cursor: pointer;
				transition: ease-out 0.5s;
				border: 2px solid #4A90E2;
				border-radius: 10px;
				box-shadow: inset 0 0 0 0 #4A90E2;
			}

			button:hover {
				color: white;
				box-shadow: inset 0 -100px 0 0 #3A78A6;
				transform: translateY(-2px);
			}

			button:active {
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

						<label for="firstname">First Name</label>

						<input type="text" name="firstname" id="firstname" placeholder="First Name">
						<div class="message">Error message</div>
						<i class="fas fa-exclamation-circle"></i>
					</div>

					<div class="input-box" id="Lname-box">

						<label for="lastname">Last Name</label>

						<input type="text" name="lastname" id="lastname" placeholder="Last Name">
						<div class="message">Error message</div>
						<i class="fas fa-exclamation-circle"></i>
					</div>
				</div>
				<div class="input-container" id="row2">

					<div class="input-box" id="Mname-box">

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

						<label for="bdate">Brithdate</label>

						<input type="date" name="bdate" id="bdate">
						<div class="message">Error message</div>
						<i class="fas fa-exclamation-circle"></i>
					</div>

					<div class="input-box" id="Sex-box">

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

						<label for="contact">Contact No.</label>

						<input type="tel" name="contact" id="contact" maxlength="11" placeholder="Contact No." oninput="this.value = this.value.replace(/[^0-9]/g, '');">
						<div class="message">Error message</div>
						<i class="fas fa-exclamation-circle"></i>
					</div>
				</div>

				<div class="input-container" id="row4">

					<div class="input-box" id="Barangay-box">

						<label for="barangay">Barangay</label>
						<select id="barangay" name="barangay">
							<option value="" disabled selected>Barangay</option>
							<option value="Adiangao">Adiangao</option>
							<option value="Bagacay">Bagacay</option>
							<option value="Bahay">Bahay</option>
							<option value="Boclod">Boclod</option>
							<option value="Calalahan">Calalahan</option>
							<option value="Calawit">Calawit</option>
							<option value="Camagong">Camagong</option>
							<option value="Catalotoan">Catalotoan</option>
							<option value="Danlog">Danlog</option>
							<option value="Del Carmen (Poblacion)">Del Carmen (Poblacion)</option>
							<option value="Dolo">Dolo</option>
							<option value="Kinalansan">Kinalansan</option>
							<option value="Mampirao">Mampirao</option>
							<option value="Manzana">Manzana</option>
							<option value="Minoro">Minoro</option>
							<option value="Palale">Palale</option>
							<option value="Ponglon">Ponglon</option>
							<option value="Pugay">Pugay</option>
							<option value="Sabang">Sabang</option>
							<option value="Salogon">Salogon</option>
							<option value="San Antonio (Poblacion)">San Antonio (Poblacion)</option>
							<option value="San Juan (Poblacion)">San Juan (Poblacion)</option>
							<option value="San Vicente (Poblacion)">San Vicente (Poblacion)</option>
							<option value="Santa Cruz (Poblacion)">Santa Cruz (Poblacion)</option>
							<option value="Soledad (Poblacion)">Soledad (Poblacion)</option>
							<option value="Tagas">Tagas</option>
							<option value="Tambangan">Tambangan</option>
							<option value="Telegrafo">Telegrafo</option>
							<option value="Tominawog">Tominawog</option>
						</select>
						<div class="message">Error message</div>
						<i class="fas fa-exclamation-circle"></i>
					</div>

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

					<div class="input-box" id="Position-box">

						<label for="position">Position</label>

						<select id="position" name="position">
							<option value="" disabled selected>Position</option>
							<option value="Brgy. Captain">Brgy. Captain</option>
							<option value="Brgy. Captain">Brgy. Kagawad</option>
						</select>
						<div class="message">Error message</div>
						<i class="fas fa-exclamation-circle"></i>
					</div>
				</div>

				<div class="input-container" id="row5">

					<div class="input-box" id="Email-box">

						<label for="email">Email</label>

						<input type="email" name="email" id="email" placeholder="Email">
						<div class="message">Error message</div>
						<i class="fas fa-exclamation-circle"></i>
					</div>

					<div class="input-box" id="Password-box">

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