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
									<span class="barangay"><strong></strong> ${data[0].barangay}, zone ${data[0].zone}</span>
									${data[0].street ? `<span class="street"><strong></strong> ${data[0].street}</span>` : ''}
									<span class="report_by"><strong></strong> ${data[0].position} ${data[0].first_name} ${data[0].last_name}</span>
									${data[0].update_at !== '0000-00-00 00:00:00' ? `<span class="update"><strong></strong> ${data[0].update_at}</span>` : ''}
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
