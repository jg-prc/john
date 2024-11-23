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
		<link rel="stylesheet" href="css/privacy.css">
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