function showForm(report_id) {
	fetch(`php/get_data_report.php?IncidentReportID=${report_id}`)
		.then(response => response.json())
		.then(data => {
			console.log(data);
			const disableButtons = (currentStatus) => currentStatus === data[0].ResponseStatus;

			if (data.error) {
				console.error(data.error);
				return;
			}

			if (!data || data.length === 0) {
				console.error('No data found for the given report ID.');
				return;
			}

			Swal.fire({
				title: '',
				html: `
					<div class="swal-content">
						<div class="swal-header">
							<i class="fas fa-xmark" onclick="Swal.close()"></i>
						</div>
						<div class="swal-body">
							<div class="image">
								<section id="main-carousel" class="splide">
									<div class="splide__track">
										<ul class="splide__list"></ul>
									</div>
								</section>
							</div>
							<div class="content">
								<div class="head">
									<h1>${data[0].IncidentTypeName}</h1>
									<span class="status ${data[0].ResponseStatus}">${data[0].ResponseStatus}</span>
								</div>
								<div class="sub-content">
									<span class="barangay">${data[0].BarangayName}, Zone ${data[0].Zone}<strong>Barangay</strong></span>
									${data[0].Street ? `<span class="street">${data[0].Street}<strong>Street/Sitio</strong></span>` : ''}
									<span class="report_by" onclick="showReporterDetails(${data[0].OfficialsID})">
										<span>${data[0].PositionName} ${data[0].FirstName} ${data[0].LastName}</span>
										<strong>Reported By</strong>
									</span>
									${data[0].UpdatedAt !== '0000-00-00 00:00:00' ? `<span class="update">${data[0].UpdatedAt}<strong>Last Update</strong></span>` : ''}
								</div>
								<div class="sub-btn">
									<span class="status pending ${disableButtons('pending') ? 'disabled' : ''}" ${!disableButtons('pending') ? `onclick="confirmStatusChange('${report_id}', 'pending')"` : ''}>pending</span>
									<span class="status resolved ${disableButtons('resolved') ? 'disabled' : ''}" ${!disableButtons('resolved') ? `onclick="confirmStatusChange('${report_id}', 'resolved')"` : ''}>resolved</span>
									<span class="status duplicated ${disableButtons('duplicated') ? 'disabled' : ''}" ${!disableButtons('duplicated') ? `onclick="confirmStatusChange('${report_id}', 'duplicated')"` : ''}>duplicated</span>
								</div>
							</div>
						</div>
					</div>
				`,
				showCancelButton: false,
				showConfirmButton: false,
				customClass: {
					popup: 'swal-wide',
				},
				didOpen: () => {
					const mainCarouselList = document.querySelector('#main-carousel .splide__list');
					mainCarouselList.innerHTML = '';

					data.forEach(item => {
						const mainListItem = document.createElement('li');
						mainListItem.classList.add('splide__slide');
						const mainImg = document.createElement('img');
						mainImg.src = `php/${item.FolderName}${item.ImagesName}`;
						mainListItem.appendChild(mainImg);
						mainCarouselList.appendChild(mainListItem);
					});

					// Initialize carousel if there are items
					if (data.length > 0) {
						const main = new Splide('#main-carousel', {
							type: 'slide',
							pagination: false,
							arrows: true,
							rewind: false,
						});
						main.mount();
					}
				}
			});
		})
		.catch(error => console.error('Error:', error));
}


function confirmStatusChange(report_id, status) {
	Swal.fire({
		title: 'Are you sure?',
		text: `Do you want to change the status to ${status}?`,
		icon: 'warning',
		showCancelButton: true,
		confirmButtonText: 'Yes',
		cancelButtonText: 'No',
	}).then((result) => {
		if (result.isConfirmed) {
			fetch('php/update_status.php', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json'
				},
				body: JSON.stringify({ report_id: report_id, status: status })
			})
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					Swal.fire('Updated!', data.message, 'success').then(() => {
						location.reload();
					});
				} else {
					Swal.fire('Error!', data.message, 'error');
				}
			})
			.catch(error => {
				console.error('Error:', error);
				Swal.fire('Error!', 'Could not update status.', 'error');
			});
		}
	});
}


function showReporterDetails(OfficialsID) {
	console.log("showForm called with ID:", OfficialsID);
	fetch(`php/get_data_active.php?OfficialsID=${OfficialsID}`)
		.then(response => response.json())
		.then(data => {

			Swal.fire({
				title: '',
				html: `
					<div class="swal-content">
						<div class="swal-header">
							<i class="fas fa-xmark" onclick="Swal.close()"></i>
						</div>
						<div class="swal-body">
							<div class="image">
								<img src="php/image/${data.ImageURL}">
							</div>
							<div class="input-container" id="row1">
								<div class="input-box" id="Fname-box">
									<label for="firstname">First Name</label>
									<input type="text" value="${data.FirstName}" id="firstname" disabled>
								</div>
								<div class="input-box" id="Lname-box">
									<label for="lastname">Last Name</label>
									<input type="text" value="${data.LastName}" id="lastname" disabled>
								</div>
							</div>
							<div class="input-container" id="row2">
								<div class="input-box" id="Mname-box">
									<label for="middlename">Middle Name</label>
									<input type="text" value="${data.MiddleName}" id="middlename" disabled>
								</div>
								<div class="input-box" id="Ename-box">
									<label for="extensionname">Extension Name</label>
									<input type="text" value="${data.ExtensionName}" id="extensionname" disabled>
								</div>
							</div>
							<div class="input-container" id="row3">
								<div class="input-box" id="Bdate-box">
									<label for="bdate">Birthdate</label>
									<input type="text" value="${data.Birthdate}" id="bdate" disabled>
								</div>
								<div class="input-box" id="Sex-box">
									<label for="sex">Sex</label>
									<input type="text" value="${data.Sex}" id="sex" disabled>
								</div>
								<div class="input-box" id="Contact-box">
									<label for="contact">Contact</label>
									<input type="text" value="${data.ContactNumber}" id="contact" disabled>
								</div>
							</div>
							<div class="input-container" id="row4">
								<div class="input-box" id="Barangay-box">
									<label for="barangay">Barangay</label>
									<input type="text" value="${data.BarangayName}" id="barangay" disabled>
								</div>
								<div class="input-box" id="Zone-box">
									<label for="zone">Zone</label>
									<input type="text" value="${data.Zone}" id="zone" disabled>
								</div>
								<div class="input-box" id="Position-box">
									<label for="position">Position</label>
									<input type="text" value="${data.PositionName}" id="position" disabled>
								</div>
							</div>
							<div class="input-container" id="row5">
								<div class="input-box" id="Email-box">
									<label for="email">Email</label>
									<input type="text" value="${data.EmailAddress}" id="email" disabled>
								</div>
							</div>
						</div>
					</div>
				`,
				showCancelButton: false,
				showConfirmButton: false,
				customClass: {
					popup: 'swal-wide-details',
				}
			});
		})
		.catch(error => console.error('Error:', error));
}