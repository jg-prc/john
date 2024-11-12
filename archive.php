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



			.tools {
				position: relative;
				left: 15%;
				top: 30px;
				width: 1100px;
				display: flex;
				align-items: center;
				justify-content: space-between;
			}
			.search-box {
				display: flex;
				align-items: center;
				width: 400px;
				border-radius: 20px;
				box-shadow: 0 0 40px rgba(0, 0, 0, 0.12);
				background-color: #ffffff;
			}
			.search-box input {
				width: 100%;
				padding: 10px 10px 10px 30px;
				border: none;
				outline: none;
				background: transparent;
				font-size: 16px;
			}
			i.fa-magnifying-glass {
				position: relative;
				left: 4%;
				font-size: 16px;
			}



			.dropdown-container {
				width: 300px;
			}
			.dropdown-button {
				display: flex;
				justify-content: flex-end;
				gap: 10px;
			}
			.dropdown-button button {
				background-color: #6A8BB4;
				color: #fff;
				padding: 10px 20px;
				border-radius: 20px;
				font-weight: bold;
				box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
				display: flex;
				align-items: center;
				gap: 8px;
				border: none;
				transition: background-color 0.3s, transform 0.2s;
			}
			.dropdown-button button:hover {
				background-color: #5a7aa2;
				transform: translateY(-2px);
			}
			.dropdown-button button label,
			.dropdown-button button i {
				cursor: pointer;
			}

			.filter-container {
				width: 300px;
				border: 1px solid #D0D4D9;
				border-radius: 8px;
				display: none;
				margin-top: 10px;
				position: absolute;
				z-index: 1;
				background-color: #F9FBFD; /* Light background */
				box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
			}

			.filter-container span {
				font-size: 16px;
				font-weight: 600;
				padding: 15px 10px;
				display: block;
				border-bottom: 1px solid #D0D4D9;
				background-color: #E8F0FE;
				border-top-left-radius: 8px;
				border-top-right-radius: 8px;
			}

			.filter-group {
				border-bottom: 1px solid #E0E4EA;
				padding: 10px;
			}

			.filter-title {
				font-size: 16px;
				display: flex;
				justify-content: space-between;
				align-items: center;
				padding-bottom: 10px;
			}

			select {
				width: 100%;
				height: 35px;
				padding-left: 10px;
				margin-bottom: 15px;
				border: 1px solid #D0D4D9;
				border-radius: 5px;
				background-color: #FFF;
				font-size: 16px;
				color: #333;
				cursor: pointer;
			}

			.filter-title a {
				color: #527092;
				text-decoration: none;
				font-weight: bold;
				font-size: 14px;
			}

			.filter-title a:hover {
				color: #3A5E8C;
			}

			.actions {
				padding: 10px;
				display: flex;
				justify-content: space-between;
			}

			button.reset-btn, button.apply-btn {
				padding: 8px 16px;
				border-radius: 20px;
				border: none;
				font-weight: bold;
				color: #FFF;
				cursor: pointer;
				transition: background-color 0.3s;
				background-color: #6A8BB4;
			}

			button.reset-btn:hover,
			button.apply-btn:hover {
				background-color: #5a7aa2;
			}







			.swal-wide {
				width: 1000px;
			}

			.swal-body {
				height: 600px;
			}
			i.fa-xmark {
				position: relative;
				left: 50%;
				cursor: pointer;
				font-size: 25px;
			}
			.swal-content .image {
				width: 200px;
				position: relative;
				left: 7%;
				top: 45px;

			}
			.swal-content  .image img{
				width: 200px;
				height: 200px;
				object-fit: cover;
				border-radius: 50%;
			}
			.input-container {
				display: flex;
				position: relative;
				bottom: 155px;
				width: 540px;
				justify-content: space-between;
				left: 35%;
			}
			.input-container#row3,
			.input-container#row4,
			.input-container#row5 {
				width: 830px;
				left: 40px;
			}
			.swal-content input[type=text] {
				width: 250px;
				height: 40px;
				padding-left: 15px;
				border: solid 2px;
				border-radius: 10px;
				margin: 5px 0 10px 0;
				background: rgba(255, 255, 255, 0.2);
				font-size: 16px;
			}
			.input-box {
				width: 250px;
				height: 110px;
			}
			label {
				padding-left: 10px;
				position: relative;
			}

			.input-box label[for="firstname"],
			.input-box label[for="lastname"] {
				right: 29%;
			}
			.input-box label[for="middlename"] {
				right: 24%;
			}
			.input-box label[for="extensionname"] {
				right: 19%;
			}
			.input-box label[for="bdate"] {
				right: 32%;
			}
			.input-box label[for="sex"] {
				right: 42%;
			}
			.input-box label[for="contact"] {
				right: 33%;
			}
			.input-box label[for="barangay"] {
				right: 30%;
			}
			.input-box label[for="zone"] {
				right: 39%;
			}
			.input-box label[for="position"] {
				right: 34%;
			}
			.input-box label[for="email"] {
				right: 38%;
			}
			.btn {
				margin-top: 32px;
				width: 200px;
			}
			.deactivate-btn {
				background-color: #008000;
				color: #FFFFFF;
				padding: 10px 20px;
				border: none;
				border-radius: 5px;
			}



			.card_grid {
				background-color: #f2f5f7;
				padding-bottom: 150px;
			}
			.card-grid {
				position: relative;
				left: 16%;
				top: 60px;
				display: grid;
				grid-template-columns: repeat(3, 1fr);
				gap: 30px;
				width: 0;
			}
			.card {
				display: flex;
				align-items: center;
				justify-content: start;
				width: 340px;
				border-radius: 20px;
				padding: 15px;
				box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
				background-color: #ffffff;
				transition: transform 0.3s, box-shadow 0.3s;
				cursor: pointer;
			}

			.card:hover {
				transform: translateY(-5px);
				box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
				background-color: #ededed;
			}

			.card .image img {
				width: 100px;
				height: 100px;
				object-fit: cover;
				border-radius: 50%;
			}

			.card .details {
				display: flex;
				flex-direction: column;
				align-items: center;
				padding-left: 15px;
				width: 200px;
			}

			.card .details span {
				font-size: 16px;
				font-weight: 500;
				color: #333;
				margin-bottom: 5px;
			}

			.details a {
				color: #6a0dad;
				font-size: 14px;
				text-decoration: underline;
				margin-top: 10px;
				transition: color 0.2s;
			}

			.details a:hover {
				color: #a34dbf;
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
						<li><a href="create.php">Create account</a></li>
						<li><a href="accounts.php">List of users</a></li>
						<li><a class="active" href="archive.php">Archived account</a></li>
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
				<i class="fas fa-archive"></i>
				<i><strong>Archived Accounts</strong></i>
			</div>
			<?php
				include_once "tools.php";
			?>
			<div class="card_grid">
				<div class="card-grid">
					<?php
						include_once "php/config.php";

						$sql = "SELECT * FROM user WHERE status = 'deactivated'";

						if (!empty($search)) {
							$sql .= " AND (first_name LIKE '%" . $conn->real_escape_string($search) . "%' 
								OR last_name LIKE '%" . $conn->real_escape_string($search) . "%')";
							}
						if (!empty($barangay)) {
							$sql .= " AND barangay = '" . $conn->real_escape_string($barangay) . "'";
						}
						if (!empty($position)) {
							$sql .= " AND position = '" . $conn->real_escape_string($position) . "'";
						}

						$order_by = 'ORDER BY `created_at` DESC';
						if ($sort_by == 'created_at-asc') {
							$order_by = 'ORDER BY `created_at` ASC';
						}

						$sql .= " $order_by";

						$result = $conn->query($sql);

						if (!$result) {
							die("invalid query: " . $connection->error);
						} else {
							while ($row = $result->fetch_assoc()) {
								echo "
									<div class='card' onclick=\"showForm(" . $row['user_id'] . ")\">
										<div class='image'>
											<img src='php/image/" . $row['image'] . "' alt='User Image'>
										</div>
										<div class='details'>
											<span>" . $row['first_name'] . " " . $row['last_name'] . "</span>
											<span>" . $row['position'] . "</span>
											<a href='#'>view details</a>
										</div>
									</div>
								";
							}
						}
					?>
				</div>
			</div>
		</div>
	</body>
	<script src="js/sidebar.js"></script>
	<script src="js/tools.js"></script>
	<script src="js/popup1.js"></script>
	<script src="js/logout.js"></script>
	<script>
	</script>
	</body>
</html>
