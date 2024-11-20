
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
				padding-top: 70px;
			}
			.send {
				display: flex;
				align-items: center;
				flex-direction: column;
				width: 800px;
				height: auto;
				padding: 40px;
				border-radius: 20px;
				box-shadow: 0 0 40px rgba(0, 0, 0, 0.12);
				background-color: #ffffff;
			}
			.input-container {
				display: flex;
				justify-content: space-between;
				width: 550px;
				margin-bottom: 10px;
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
			select#zone {
				width: 200px;
			}
			.input-box#Images-box {
				width: 550px;
				height: auto;
			}
			.image-wrapper {
				display: flex;
				align-items: center;
				flex-wrap: wrap;
				border: 2px solid black;
				border-radius: 20px;
				padding: 10px;
				min-height: 100px;
				margin: 15px 0 10px 0;
				border-color: #A9A9A9;
			}
			.image-box {
				width: 50px;
				height: 50px;
				border-radius: 10px;
				display: flex;
				justify-content: center;
				align-items: center;
				margin: 10px;
				position: relative;
			}
			.image-box img {
				width: 100%;
				height: 100%;
				object-fit: cover;
				border-radius: 10px;
			}
			.images {
				padding-right: 350px;
			}
			label[for="images"] {
				background-color: #6A8BB4;
				color: #fff;
				padding: 5px 10px;
				border-radius: 20px;
				font-weight: bold;
				font-size: 13px;
				box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
				transition: background-color 0.3s, transform 0.2s;
			}
			label[for="images"]:hover {
				background-color: #5a7aa2;
			}
			.close-btn {
				position: absolute;
				top: -8px;
				right: -8px;
				background-color: red;
				color: white;
				border: none;
				border-radius: 50%;
				width: 20px;
				height: 20px;
				display: flex;
				justify-content: center;
				align-items: center;
				cursor: pointer;
				font-size: 14px;
				line-height: 20px;
			}
			.message,
			i.fas.fa-exclamation-circle {
				visibility: hidden;
				color: #e74c3c;
			}
			i.fa-exclamation-circle {
				position: relative;
				left: 80%;
				bottom: 65px;
			}
			.input-box.error .message,
			.input-box.error i.fa-exclamation-circle {
				visibility: visible;
			}
			.input-box.error input[type=text],
			.input-box.error select,
			.input-box.error #barangay {
				border-color: #e74c3c;
			}

			button {
				background-color: #6A8BB4;
				color: #fff;
				padding: 10px 35px;
				border-radius: 20px;
				font-weight: bold;
				font-size: 16px;
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
					margin-left: 78px;
				}
				.title i{
					padding-top: 10px;
				}
				.sub-container {
					padding-top: 0;
				}
				.send {
					padding-bottom: 50px;
					border-radius: 0;
					background-color: unset;
				}
				.input-container {
					justify-content: center;
					flex-direction: column;
					align-items: center;
					width: 100%;
					margin-bottom: 0;
				}
				.input-box {
					width: 288px;
				}
				.input-box#Type-box,
				.input-box#Zone-box,
				select#incident_type,
				select#zone,
				#street,
				#barangay {
					width: 288px;
				}
				.input-box#Images-box {
					width: 288px;
				}
				label,
				.message {
					padding-left: 10px;
				}
				.images {
					padding-right: 100px;
				}
				.image-wrapper {
					gap: 10px;
				}
				.btn {
					padding-top: 20px;
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







const form = document.querySelector(".sub-container form");

form.addEventListener("submit", (e) => {
	e.preventDefault();
	let formIsValid = true;

	formIsValid = validateInput(incident_type, "Incident can't be blank") && formIsValid;
	formIsValid = validateInput(barangay, "Barangay can't be blank") && formIsValid;
	formIsValid = validateInput(zone, "Zone can't be blank") && formIsValid;

	if (formIsValid) {
		// Show confirmation prompt
		Swal.fire({
			title: "Do you want to send the report?",
			icon: 'info',
			showCancelButton: true,
			confirmButtonText: "Save",
			cancelButtonText: "Cancel",
			customClass: {
				confirmButton: 'confirm-button',
				cancelButton: 'cancel-button'
			}
		}).then(async (result) => {
			if (result.isConfirmed) {
				try {
					const formData = new FormData(form);

					const response = await fetch("php/send.php", {
						method: "POST",
						body: formData,
					});

					if (response.ok) {
						const data = await response.text();
						console.log(data);
						if (data === "success") {
							Swal.fire("Saved!", "", "success").then(() => {
								location.href = "user-dashboard.php";
							});
						} else {
							Swal.fire("Error", data, "error");
						}
					} else {
						throw new Error(`Server responded with status: ${response.status}`);
					}
				} catch (error) {
					Swal.fire("Error", "Something went wrong!", "error");
				}
			} else if (result.isDismissed) {
				Swal.fire("Changes are not saved", "", "info");
			}
		});
	}
});

function validateInput(input, errorMessage) {
	const value = input.value.trim();
	if (value === "") {
		setErrorFor(input, errorMessage);
		return false;
	} else {
		setSuccessFor(input);
		return true;
	}
}

function setErrorFor(input, message) {
	const inputBox = input.parentElement;
	const error = inputBox.querySelector(".message");
	inputBox.classList.add("error");
	error.innerText = message;
}

function setSuccessFor(input) {
	const inputBox = input.parentElement;
	inputBox.classList.remove("error");
	inputBox.classList.add("success");
}
	</script>
</html>