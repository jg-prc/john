function showForm(user_id) {
	Swal.fire({
		title: '',
		html: `
			<div class="swal-content">
				<div class="swal-header">
					<div class="title">
						<i>Send Report</i>
					</div>
					<i class="fas fa-xmark" onclick="Swal.close()"></i>
				</div>
				<div class="swal-body">
					<form class="send">
						<div class="swal-sub-container">
							<div class="input-box" id="Type-box">
								<label for="incident_type">Incident Type</label>
								<select id="incident_type" name="incident_type">
									<option value="" disabled selected>Zone</option>
									<option value="1">Fire Incident</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
								</select>
								<div class="message">Error message</div>
								<i class="fas fa-exclamation-circle"></i>
							</div>
							<div class="input-box" id="Barangay-box">
								<label for="barangay">Barangay</label>
								<input list="choice" id="barangay" name="barangay" placeholder="Barangay">
								<datalist id="choice">
									<option value="Adiangao">
									<option value="Bagacay">
									<option value="Bahay">
									<option value="Boclod">
									<option value="Calalahan">
									<option value="Calawit">
									<option value="Camagong">
									<option value="Catalotoan">
									<option value="Danlog">
									<option value="Del Carmen">
									<option value="Dolo">
									<option value="Kinalansan">
									<option value="Mampirao">
									<option value="Manzana">
									<option value="Minoro">
									<option value="Palale">
									<option value="Ponglon">
									<option value="Pugay">
									<option value="Sabang">
									<option value="Salogon">
									<option value="San Antonio">
									<option value="San Juan">
									<option value="San Vicente">
									<option value="Santa Cruz">
									<option value="Soledad">
									<option value="Tagas">
									<option value="Tambangan">
									<option value="Telegrafo">
									<option value="Tominawog">
								</datalist>
								<div class="message">Error message</div>
								<i class="fas fa-exclamation-circle"></i>
							</div>
						</div>
						<div class="swal-sub-container">
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
						<div class="input-box" id="Images-box">
							<label for="imageInput">Images</label>
							<div class="image-wrapper">
								<div class="image-box add-image" id="addImage">
									<i class="fa fa-plus"></i>
									<input type="file" id="imageInput" accept="image/*" multiple style="display:none;">
								</div>
							</div>
							<div class="message">Error message</div>
							<i class="fas fa-exclamation-circle"></i>
						</div>
						<div class="btn">
							<button class="send-btn" onclick="confirmSend(event, ${user_id})">Send</button>
						</div>
					</form>
				</div>
			</div>
		`,
		showCancelButton: false,
		showConfirmButton: false,
		customClass: {
			popup: 'swal-wide',
		}
	});

	document.getElementById('addImage').addEventListener('click', function() {
		document.getElementById('imageInput').click();
	});

	document.getElementById('imageInput').addEventListener('change', function(event) {
		const files = event.target.files;
		const imageWrapper = document.querySelector('.image-wrapper');
    
		for (let i = 0; i < files.length; i++) {
			const file = files[i];
        
			const newImageBox = document.createElement('div');
			newImageBox.classList.add('image-box');
        
			const img = document.createElement('img');
			img.src = URL.createObjectURL(file);
        
			const closeButton = document.createElement('a');
			closeButton.innerHTML = '&times;';
			closeButton.classList.add('close-btn');
			closeButton.addEventListener('click', function() {
				newImageBox.remove();
			});
        
			newImageBox.appendChild(img);
			newImageBox.appendChild(closeButton);
			imageWrapper.appendChild(newImageBox);
		}
		event.target.value = '';
	});
}

function confirmSend(event, user_id) {
	event.preventDefault();

	let formIsValid = true;
		formIsValid = validateInput(incident_type, "incident type cannot be blank") && formIsValid;
		formIsValid = validateInput(barangay, "barangay cannot be blank") && formIsValid;
		formIsValid = validateInput(zone, "zone cannot be blank") && formIsValid;
		formIsValid = validateInput(imageInput, "imageInput cannot be blank") && formIsValid;

	if (formIsValid) {
		Swal.fire({
			title: 'Are you sure?',
			text: "",
			icon: 'info',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Yes, send it',
			cancelButtonText: 'Cancel'
		}).then((result) => {
			if (result.isConfirmed) {
				fetch(`php/send.php?user_id=${user_id}`, {
					method: 'POST',
				})
				.then(response => response.text())
				.then(result => {
					// Show a success message after deactivation
					Swal.fire(
						'Successfully!',
						'Your report has been sent.',
						'success'
					).then(() => {
						// Redirect to archive.php after closing the success message
						location.href = "user-profile.php";
					});
				})
				.catch(error => {
					console.error('Error:', error);
					Swal.fire(
						'Error!',
						'There was an error.',
						'error'
					);
				});
			}
		})
	}
}
// Function to validate input and show error if necessary
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