function showForm(report_id) {
    fetch(`php/get_data_report.php?IncidentReportID=${report_id}`)
        .then(response => response.json())
        .then(data => {
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
                                    <span class="report_by">${data[0].PositionName} ${data[0].FirstName} ${data[0].LastName}<strong>Reported By</strong></span>
                                    ${data[0].UpdatedAt !== '0000-00-00 00:00:00' ? `<span class="update">${data[0].UpdatedAt}<strong>Last Update</strong></span>` : ''}
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
                        mainImg.src = `php/${item.ImagesName}`;
                        mainListItem.appendChild(mainImg);
                        mainCarouselList.appendChild(mainListItem);
                    });

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
