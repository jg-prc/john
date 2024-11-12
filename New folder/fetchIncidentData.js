document.getElementById('selectedDate').addEventListener('change', function() {
    var selectedDate = this.value;
    var incidentType = getIncidentTypeFromURL(); // Get the incident type from the URL
    fetchIncidentData(incidentType, selectedDate); // Pass both incidentType and selectedDate
});

function fetchIncidentData(incidentType, selectedDate) { 
	console.log("Incident Type: ", incidentType);
	console.log("Selected Date: ", selectedDate);

	var xhr = new XMLHttpRequest();
	var url = 'fetch_incident_data.php?type=' + encodeURIComponent(incidentType);
	if (selectedDate) {
		url += '&date=' + encodeURIComponent(selectedDate); // Add selectedDate to the request
	}
	
	xhr.open('GET', url, true);
	xhr.onload = function() {
		if (xhr.status == 200) {
			var response = JSON.parse(xhr.responseText);
			var incidentData = response.incident_data;
			var incidentLocation = response.incident_location;

			document.getElementById('vehicular').className = 'fas fa-car-crash ' + (incidentData.Vehicular || '');
			document.getElementById('fire').className = 'fas fa-fire ' + (incidentData.Fire || '');
			document.getElementById('flood').className = 'fas fa-house-flood-water ' + (incidentData.Flood || '');
			document.getElementById('landslide').className = 'fas fa-hill-rockslide ' + (incidentData.Landslide || '');

			for (var barangay in incidentLocation) {
				if (incidentLocation.hasOwnProperty(barangay)) {
					var element = document.getElementById(barangay.toLowerCase());
					if (element) {
						if (incidentLocation[barangay]) {
							element.classList.add('blinking');
						} else {
							element.classList.remove('blinking');
						}
					}
				}
			}
		} else {
			console.error('Error fetching data: ', xhr.statusText);
		}
	};
	xhr.send();
}

function getIncidentTypeFromURL() {
	const params = new URLSearchParams(window.location.search);
	return params.get('type') || '';
}

window.onload = function() {
	const incidentType = getIncidentTypeFromURL();
	const selectedDate = document.getElementById('selectedDate').value; // Get the selected date on page load

	if (incidentType || selectedDate) {
		fetchIncidentData(incidentType, selectedDate);
	} else {
		console.warn("Incident type or date is blank. No data will be fetched.");
		fetchIncidentData('', '');
	}

	// Set interval to fetch data every 500 milliseconds
	setInterval(() => {
		fetchIncidentData(incidentType, selectedDate);
	}, 500);
};
