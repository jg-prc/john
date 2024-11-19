const searchInput = document.querySelector('.search-box input');

searchInput.addEventListener('keypress', function(event) {
	if (event.key === 'Enter') {
		const searchQuery = searchInput.value.trim();
		const barangayValue = document.getElementById('barangay').value;
		const incidentTypeValue = document.getElementById('incident_type').value;

		window.location.href = `?search=${encodeURIComponent(searchQuery)}&barangay=${encodeURIComponent(barangayValue)}&incident_type=${encodeURIComponent(incidentTypeValue)}`;
	}
});

function toggleFilterMenu() {
	const menu = document.getElementById('filtermenu');
	menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
}

function applyFilters() {
	const barangay = document.getElementById('barangay').value;
	const incident_type = document.getElementById('incident_type').value;
	const urlParams = new URLSearchParams(window.location.search);

	if (barangay) {
		urlParams.set('barangay', barangay);
	} else {
		urlParams.delete('barangay');
	}

	if (incident_type) {
		urlParams.set('incident_type', incident_type);
	} else {
		urlParams.delete('incident_type');
	}

	window.location.search = urlParams.toString();
}

function resetFilter(filterName) {
	document.getElementById(filterName).value = '';
}

function resetAllFilters() {
	document.getElementById('barangay').value = '';
	document.getElementById('incident_type').value = '';
	applyFilters();
}

function toggleSortOrder() {
	const urlParams = new URLSearchParams(window.location.search);
	const sortIcon = document.getElementById('sort-icon');
	let currentSortOrder = urlParams.get('sort_by');

	if (!currentSortOrder || currentSortOrder === 'CreatedAt-desc') {
		urlParams.set('sort_by', 'CreatedAt-asc');
		sortIcon.classList.replace('fa-arrow-up-short-wide', 'fa-arrow-down-short-wide');
	} else {
		urlParams.set('sort_by', 'CreatedAt-desc');
		sortIcon.classList.replace('fa-arrow-down-short-wide', 'fa-arrow-up-short-wide');
	}

	window.location.search = urlParams.toString();
}

window.onload = function() {
	const urlParams = new URLSearchParams(window.location.search);
	const sortIcon = document.getElementById('sort-icon');
	let currentSortOrder = urlParams.get('sort_by');

	if (currentSortOrder === 'CreatedAt-asc') {
		sortIcon.classList.replace('fa-arrow-up-short-wide', 'fa-arrow-down-short-wide');
	} else {
		sortIcon.classList.replace('fa-arrow-down-short-wide', 'fa-arrow-up-short-wide');
	}

	// Persist dropdown selections
	const barangay = urlParams.get('barangay');
	const incident_type = urlParams.get('incident_type');

	if (barangay) {
		document.getElementById('barangay').value = barangay;
	}
	if (incident_type) {
		document.getElementById('incident_type').value = incident_type;
	}
}