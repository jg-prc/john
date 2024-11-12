function showForm(user_id) {

	fetch(`php/get_data1.php?user_id=${user_id}`)
		.then(response => response.json())
		.then(data => {

			// Show the SweetAlert2 popup with user data
			Swal.fire({
				title: '',
				html: `
					<div class="swal-content">
						<div class="swal-header">
							<i class="fas fa-xmark" onclick="Swal.close()"></i>
						</div>
						<div class="swal-body">
							<div class="image">
								<img src="php/image/${data.image}">
							</div>
							<div class="input-container" id="row1">
								<div class="input-box" id="Fname-box">
									<label for="firstname">First Name</label>
									<input type="text" value="${data.first_name}" id="firstname" disabled>
								</div>
								<div class="input-box" id="Lname-box">
									<label for="lastname">Last Name</label>
									<input type="text" value="${data.last_name}" id="lastname" disabled>
								</div>
							</div>
							<div class="input-container" id="row2">
								<div class="input-box" id="Mname-box">
									<label for="middlename">Middle Name</label>
									<input type="text" value="${data.middle_name}" id="middlename" disabled>
								</div>
								<div class="input-box" id="Ename-box">
									<label for="extensionname">Extension Name</label>
									<input type="text" value="${data.extension_name}" id="extensionname" disabled>
								</div>
							</div>
							<div class="input-container" id="row3">
								<div class="input-box" id="Bdate-box">
									<label for="bdate">Birthdate</label>
									<input type="text" value="${data.birthdate}" id="bdate" disabled>
								</div>
								<div class="input-box" id="Sex-box">
									<label for="sex">Sex</label>
									<input type="text" value="${data.sex}" id="sex" disabled>
								</div>
								<div class="input-box" id="Contact-box">
									<label for="contact">Contact</label>
									<input type="text" value="${data.contact_no}" id="contact" disabled>
								</div>
							</div>
							<div class="input-container" id="row4">
								<div class="input-box" id="Barangay-box">
									<label for="barangay">Barangay</label>
									<input type="text" value="${data.barangay}" id="barangay" disabled>
								</div>
								<div class="input-box" id="Zone-box">
									<label for="zone">Zone</label>
									<input type="text" value="${data.zone}" id="zone" disabled>
								</div>
								<div class="input-box" id="Position-box">
									<label for="position">Position</label>
									<input type="text" value="${data.position}" id="position" disabled>
								</div>
							</div>
							<div class="input-container" id="row5">
								<div class="input-box" id="Email-box">
									<label for="email">Email</label>
									<input type="text" value="${data.email}" id="email" disabled>
								</div>
								<div class="btn">
									<button class="deactivate-btn" onclick="confirmReactivation(${user_id})">Reactivate</button>
								</div>
							</div>
						</div>
					</div>
				`,
				showCancelButton: false,
				showConfirmButton: false,
				customClass: {
					popup: 'swal-wide',
				}
			});
		})
		.catch(error => console.error('Error:', error));
}

function confirmReactivation(user_id) {
	Swal.fire({
		title: 'Are you sure?',
		text: "Do you really want to reactivate this account?",
		icon: 'info',
		showCancelButton: true,
		confirmButtonColor: '#008000',
		cancelButtonColor: '#3085d6',
		confirmButtonText: 'Yes, reactivate it!',
		cancelButtonText: 'Cancel'
	}).then((result) => {
		if (result.isConfirmed) {
			fetch(`php/reactivate.php?user_id=${user_id}`, {
				method: 'POST',
			})
			.then(response => response.text())
			.then(result => {
				// Show a success message after reactivation
				Swal.fire(
					'Reactivated!',
					'The account has been reactivated.',
					'success'
				).then(() => {
					// Redirect to archive.php after closing the success message
					location.href = "accounts.php";
				});
			})
			.catch(error => {
				console.error('Error:', error);
				Swal.fire(
					'Error!',
					'There was an error reactivating the account.',
					'error'
				);
			});
		}
	});
}

