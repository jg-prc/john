function showForm(report_id) {
	fetch(`php/get_data_report.php?report_id=${report_id}`)
		.then(response => response.json())
		.then(data => {
			console.log(data);
			const disableButtons = (currentStatus) => currentStatus === data[0].status;

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
									<h1>${data[0].incident_type}</h1>
									<span class="status ${data[0].status}">${data[0].status}</span>
								</div>
								<div class="sub-content">
									<span><strong>Barangay:</strong> ${data[0].barangay}, zone ${data[0].zone}</span>
									<span><strong>Street/Sitio:</strong> ${data[0].street}</span>
									<span><strong>Reported By:</strong> ${data[0].position} ${data[0].first_name} ${data[0].last_name}</span>
								</div>
								<div class="sub-btn">
									<span class="status ongoing ${disableButtons('ongoing') ? 'disabled' : ''}" ${!disableButtons('ongoing') ? `onclick="confirmStatusChange('${report_id}', 'ongoing')"` : ''}>ongoing</span>
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
						mainImg.src = `php/${item.file_path}`;
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