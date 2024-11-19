const searchInput = document.querySelector('.search-box input');

searchInput.addEventListener('keypress', function(event) {
	if (event.key === 'Enter') {
		const searchQuery = searchInput.value.trim();
		const barangayValue = document.getElementById('barangay').value;
		const positionValue = document.getElementById('position').value;

		window.location.href = `?search=${encodeURIComponent(searchQuery)}&barangay=${encodeURIComponent(barangayValue)}&position=${encodeURIComponent(positionValue)}`;
	}
});

function toggleFilterMenu() {
	const menu = document.getElementById('filtermenu');
	if (menu.style.display === 'block') {
		menu.style.display = 'none';
	} else {
		menu.style.display = 'block';
	}
}

function applyFilters() {
	const barangay = document.getElementById('barangay').value;
	const position = document.getElementById('position').value;
    
	const urlParams = new URLSearchParams(window.location.search);

	if (barangay) {
		urlParams.set('barangay', barangay);
	} else {
		urlParams.delete('barangay');
	}
    
	if (position) {
		urlParams.set('position', position);
	} else {
		urlParams.delete('position');
	}
    
	window.location.search = urlParams.toString();
}

function resetFilter(filterName) {
	document.getElementById(filterName).value = '';
}

function resetAllFilters() {
	document.getElementById('barangay').value = '';
	document.getElementById('position').value = '';
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
	let currentSortOrder = urlParams.get('sort_by');
	const sortIcon = document.getElementById('sort-icon');
    
	if (currentSortOrder === 'CreatedAt-asc') {
		sortIcon.classList.remove('fa-arrow-up-short-wide');
		sortIcon.classList.add('fa-arrow-down-short-wide');
	} else {
		sortIcon.classList.remove('fa-arrow-down-short-wide');
		sortIcon.classList.add('fa-arrow-up-short-wide');
	}

	const barangay = urlParams.get('barangay');
	if (barangay) {
		document.getElementById('barangay').value = barangay;
	}

	const position = urlParams.get('position');
	if (position) {
		document.getElementById('position').value = position;
	}
};
