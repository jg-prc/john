<?php
	session_start();

	if (isset($_SESSION['unique_id']) && isset($_SESSION['role']) && $_SESSION['role'] === '2') {
		header("Location: dashboard.php");
		exit();
	}
	if (isset($_SESSION['unique_id']) && isset($_SESSION['role']) && $_SESSION['role'] === '1') {
		header("Location: user-dashboard.php");
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
		<link rel="stylesheet" href="css/index.css">
		<link rel="icon" href="php/image/logo.png" type="image/png">
		<title>SAN JOSE INCIDENT RECORD  MANAGEMENT AND MAPPING SYSTEM</title>
		<style>
		</style>
	</head>
	<body>
		<div class="container">
			<div class="left-container">
				<div class="logo-container">
					<img src="php/image/logo.png" alt="Logo" class="logo">
					<h1>San Jose Incident Record Management and Mapping System</h1>
					<h2>San Jose, Camarines Sur</h2>
				</div>
			</div>
			<div class="right-container">
				<h1>Login</h1>
				<form id="login" action="" method="post" autocomplete="off">

					<label for="email">Email</label>

					<div class="input-container">
						<div class="input-box" id="email-box">
							<input type="email" name="email" id="email">
							<div class="message">Error message</div>
							<i class="fas fa-exclamation-circle"></i>
						</div>
					</div>

					<label for="password">Password</label>

					<div class="input-container">
						<div class="input-box" id="password-box">
							<input type="password" name="password" id="password">
							<div class="message">Error message</div>
							<i class="fas fa-exclamation-circle"></i>
							<i id="icon" class="fa fa-eye-slash"></i>
						</div>
					</div>
					<div class="btn">
						<a href="guest.php">Login as Guest</a>
						<button type="submit">Log in</button>
					</div>
				</form>
			</div>
		</div>
		<script src="js/single_view-pass.js"></script>
		<script src="js/login.js"></script>
		<script>
		</script>
	</body>
</html>
