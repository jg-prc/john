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
		<link rel="icon" href="php/image/logo.png" type="image/png">
		<title>SAN JOSE INCIDENT RECORD  MANAGEMENT AND MAPPING SYSTEM</title>
		<style>
			* {
				box-sizing: border-box;
			}
			body {
				font-family: Arial, sans-serif;
				margin: 0;
				padding: 0;
			}
			.container {
				display: flex;
				flex-wrap: wrap;
				width: 100%;
				height: 100vh;
			}

			.left-container {
				width: 60%;
				background-color: #e0e0e0;
				display: flex;
				justify-content: center;
				align-items: center;
				flex-direction: column;
				text-align: center;
			}
			.left-container h1 {
				font-size: 60px;
				margin-top: 0;
			}
			img {
				width: 370px;
			}





			.right-container {
				width: 40%;
				background-color: #f0f0f0;
				padding: 30px;
			}
			.right-container h1 {
				display: flex;
				justify-content: center;
				font-size: 64px;
				color: blue;
			}
			form {
				padding: 0 37px;
			}
			label {
				font-weight: 400;
				text-transform: uppercase;
				font-size: 16px;
			}
			.input-container {
				display: flex;
				justify-content: center;
				margin-bottom: 20px;
				margin-top: 5px;
				height: 65px;
			}
			input[type=email],
			input[type=password],
			input[type=text] {
				width: 500px;
				height: 40px;
				padding-left: 15px;
				border: 2px solid transparent;
				border-radius: 10px;
				margin-bottom: 10px;
				background: rgba(255, 255, 255, 0.2);
				font-size: 16px;
				box-shadow: 2px 1px 5px rgba(0, 0, 0, 0.1);
			}
			input:focus,
			textarea:focus {
				background: rgba(255, 255, 255, 0.9);
				border: 2px solid #e0e0e0;
				transition: background 0.5s ease;
			}
			:focus {
				outline: none;
			}
			.message,
			i.fas.fa-exclamation-circle {
				visibility: hidden;
				color: #e74c3c;
			}
			.message {
				position: relative;
				left: 10px;
			}
			i.fa-exclamation-circle {
				position: relative;
				left: 95%;
				bottom: 87%;
			}
			.fa-eye-slash,
			.fa-eye {
				position: relative;
				left: 84%;
				bottom: 87%;
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
				justify-content: space-between;
			}
			.btn a {
				align-content: center;
				color: #0000ff;
			}
			button {
				padding: 10px 30px;
				font-size: 18px;
				letter-spacing: 1px;
				color: #0000ff;
				background: transparent;
				cursor: pointer;
				transition: ease-out 0.5s;
				border: 2px solid #0000ff;
				border-radius: 10px;
				box-shadow: inset 0 0 0 0 #0000ff;
			}
			button:hover {
				color: white;
				box-shadow: inset 0 -100px 0 0 #0000ff;
			}
			button:active {
				transform: scale(0.9);
			}



			@media screen and (max-width: 575px) {

				.left-container,
				.right-container {
					width: 100%;
				}
				img {
					width: 275px;
				}
				.left-container h1 {
					font-size: 32px;
				}
				label {
					position: relative;
					left: 10px;
				}
				input[type=email],
				input[type=password],
				input[type=text] {
					width: 300px;
				}
				.message{
					position: relative;
					left: 10px;
				}
				i.fa-exclamation-circle {
					position: relative;
					bottom: 87%;
					left: 92%;
				}
				.fa-eye-slash,
				.fa-eye {
					position: relative;
					bottom: 87%;
					left: 75%;
				}
				button {
					padding: 5px 15px;
				}
				form {
					padding: 0;
				}
				.btn a {
					margin-top: 10px;
				}
			}
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
