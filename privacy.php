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
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<link rel="stylesheet" href="css/sidebar.css">
		<link rel="icon" href="php/image/logo.png" type="image/png">
		<title>SAN JOSE INCIDENT RECORD  MANAGEMENT AND MAPPING SYSTEM</title>
		<style>
			body::-webkit-scrollbar {
				display: none;
			}
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
			.sub-container {
				display: flex;
				flex-direction: column;
				align-items: center;
				padding-top: 50px;
				padding-left: 80px;
				gap: 50px;
			}
			.change-email {
				width: 1050px;
				height: 300px;
				padding: 30px;
				box-shadow: 0 0 40px rgba(0, 0, 0, 0.12);
				border-radius: 20px;
			}
			p {
				margin: 5px 0 10px 5px;
			}
			.change-email .input-container {
				display: flex;
				justify-content: space-around;
				gap: 50px;
				margin: 5px 0 20px 0;
				height: 65px;
			}
			input[type=email],
			input[type=password],
			input[type=text] {
				width: 400px;
				height: 40px;
				padding-left: 15px;
				border: solid 2px;
				border-radius: 10px;
				margin-bottom: 10px;
				background: rgba(255, 255, 255, 0.2);
				font-size: 16px;
				border-color: #A9A9A9;
			}
			input:focus,
			textarea:focus {
				background: rgba(255, 255, 255, 0.3);
				border: 2px solid #e0e0e0;
				transition: background 0.5s ease;
			}
			.message,
			label[for="current_email"] {
				position: relative;
				left: 4%;
			}
			label[for="new_email"] {
				position: relative;
				left: 45%;
			}
			i.fas.fa-exclamation-circle {
				position: relative;
				bottom: 100%;
				left: 92%;
			}
			#new_pass-box i.fas.fa-exclamation-circle,
			#confirm_pass-box i.fas.fa-exclamation-circle {
				left: 80%;
			}
			.message,
			i.fa-exclamation-circle {
				visibility: hidden;
				color: #e74c3c;
			}
			.input-box.error .message,
			.input-box.error i.fa-exclamation-circle {
				visibility: visible;
			}
			.input-box.error input[type=email],
			.input-box.error input[type=password],
			.input-box.error input[type=text] {
				border-color: #e74c3c;
			}


			.btn {
				display: flex;
				justify-content: center;
				padding-bottom: 20px;
			}
			button {
				background-color: #6A8BB4;
				color: #fff;
				padding: 10px 30px;
				border-radius: 20px;
				font-weight: bold;
				font-size: 20px;
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

			.change-pass {
				display: flex;
				flex-direction: column;
				width: 1050px;
				height: 520px;
				padding: 30px;
				box-shadow: 0 0 40px rgba(0, 0, 0, 0.12);
				border-radius: 20px;
			}
			.change-pass .input-container {
				display: flex;
				justify-content: space-around;
				gap: 50px;
				margin: 5px 0 20px 0;
				height: 310px;
			}
			.change-pass .input-box {
				margin: 5px 0 15px 0;
				height: 65px;
				width: 400px;
			}
			.fa-eye-slash,
			.fa-eye {
				position: relative;
				left: 90%;
				bottom: 65%;
			}
			#new_pass-box .fa-eye-slash,
			#confirm_pass-box .fa-eye-slash,
			#new_pass-box .fa-eye,
			#confirm_pass-box .fa-eye {
				position: relative;
				left: 85%;
				bottom: 100%;
			}
			.requirements ul {
				list-style-type: none;
				padding: 0;
			}
			.requirements li {
				margin: 10px 0;
				display: flex;
				align-items: center;
				gap: 16px;
			}
			.requirements li i {
				font-size: 20px;
				color: #e74c3c;
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
				<li>
					<a href="report.php">
						<i class="fas fa-folder-open"></i>
						<span class="link_name">Report Management</span>
					</a>
					<ul class="sub-menu blank">
						<li><a class="link_name">Report Management</a></li>
					</ul>
				</li>
				<li class="active">
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
				<i class="fas fa-shield-alt"></i>
				<i>Privacy and Security</i>
			</div>
			<div class="sub-container">
				<form class="change-email" id="change-email" autocomplete="off" action="#" method="POST" enctype="multipart/form-data">
					<h2>Change Email</h2>
					<p>To change your email, please fill in the fields below ensuring the new email meets the requirements.</p>

					<label for="current_email">Current Email</label>

					<label for="new_email">New Email</label>

					<div class="input-container">
						<div class="input-box" id="current-email-box">
							<input type="email" name="current_email" id="current_email">
							<div class="message">Error message</div>
							<i class="fas fa-exclamation-circle"></i>
						</div>

						<div class="input-box" id="new-email-box">
							<input type="email" name="new_email" id="new_email">
							<div class="message">Error message</div>
							<i class="fas fa-exclamation-circle"></i>
						</div>
					</div>
					<div class="btn">
						<button type="submit">Update</button>
					</div>
				</form>

				<form class="change-pass" id="change-pass" autocomplete="off" action="#" method="POST" enctype="multipart/form-data">
					<h2>Change Password</h2>
						<p>To change your password, please fill in the fields below ensuring the new password meets the requirements.</p>
					<div class="input-container">
						<div>
							<label for="current_pass">Current Password</label>

							<div class="input-box" id="current_pass-box">
								<input type="password" id="current_pass" name="current_pass">
								<div class="message">Error message</div>
								<i class="fas fa-exclamation-circle"></i>
							</div>

							<label for="new_pass">New Password</label>

							<div class="input-box" id="new_pass-box">
								<input type="password" id="new_pass" name="new_pass">
								<div class="message">Error message</div>
								<i class="fas fa-exclamation-circle"></i>
								<i id="icon1" class="fa fa-eye-slash"></i>
							</div>

							<label for="confirm_pass">Confirm Password</label>

							<div class="input-box" id="confirm_pass-box">
								<input type="password" id="confirm_pass" name="confirm_pass">
								<div class="message">Error message</div>
								<i class="fas fa-exclamation-circle"></i>
								<i id="icon2" class="fa fa-eye-slash"></i>
							</div>
						</div>
						<div class="requirements">
							<ul>
								<li id="length"><i class="fas fa-circle-xmark"></i> 8-20 characters</li>
								<li id="uppercase"><i class="fas fa-circle-xmark"></i> At least one capital letter (A-Z)</li>
								<li id="lowercase"><i class="fas fa-circle-xmark"></i> At least one lowercase letter (a-z)</li>
								<li id="number"><i class="fas fa-circle-xmark"></i> At least one number (0-9)</li>
								<li id="special-char"><i class="fas fa-circle-xmark"></i> Don't use ` ; : , ' " / \</li>
								<li id="no-spaces"><i class="fas fa-circle-xmark"></i> No spaces</li>
							</ul>
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
	<script src="js/view-pass.js"></script>
	<script src="js/email.js"></script>
	<script src="js/pass.js"></script>
	<script src="js/logout.js"></script>
	<script>

	</script>
</html>