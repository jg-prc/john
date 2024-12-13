function createNewTable() {

	const headerContent = document.createElement('div');
	headerContent.classList.add('header-content');
	headerContent.innerHTML = `
		<div class='logo'>
			<img src='php/image/logo1.png' alt='Logo 1'>
		</div>
		<div class='details'>
			<span>Republic of the Philippines</span>
			<span>Province of Camarines Sur</span>
			<span>Municipality of San Jose</span>
		</div>
		<div class='logo'>
			<img src='php/image/logo.png' alt='Logo 2'>
		</div>
	`;

	const title = document.createElement('h3');
	title.textContent = 'MUNICIPAL DISASTER RISK REDUCTION AND MANAGEMENT OFFICE - SAN JOSE';

	const newTableContainer = document.createElement('div');
	newTableContainer.classList.add('data');

	const TableContainer = document.createElement('div');
	TableContainer.classList.add('table');

	const newTable = document.createElement('table');
	const newTableHead = document.createElement('thead');
	const newTableBody = document.createElement('tbody');

	newTableHead.innerHTML = `
		<tr>
			<th class='municipality'>CITY/ MUNICIPALITY</th>
			<th class='barangay'>BARANGAY</th>
			<th class='type'>TYPE OF INCIDENT</th>
			<th class='date'>DATE OF OCCURRENCE [mm/dd/yyyy]</th>
			<th class='time'>TIME OF OCCURRENCE [24:00]</th>
			<th class='description'>DESCRIPTION</th>
			<th class='action'>ACTIONS TAKEN</th>
			<th class='remarks'>REMARKS</th>
			<th class='status'>STATUS (for flooded areas)</th>
		</tr>
	`;

	const newFooter = document.createElement('footer');
	newFooter.innerHTML = ` <span>All Rights Reserved © 2024 Municipal Disaster Risk Reduction and Management Office-San Jose</span>`;

	newTable.appendChild(newTableHead);
	newTable.appendChild(newTableBody);

	newTableContainer.appendChild(headerContent);
	newTableContainer.appendChild(title);

	TableContainer.appendChild(newTable);

	newTableContainer.appendChild(TableContainer);
	newTableContainer.appendChild(newFooter);

	const makepdfContainer = document.querySelector('#makepdf');
	makepdfContainer.appendChild(newTableContainer);

	return newTableBody;
}

function moveRowsBetweenTables() {

	const tables = document.querySelectorAll('.table table');

	const maxHeight = 500;

	for (let i = 0; i < tables.length; i++) {
		const currentTable = tables[i];
		const currentTableBody = currentTable.querySelector('tbody');

		if (currentTable.offsetHeight > maxHeight) {
			const rows = currentTableBody.querySelectorAll('tr');

			if (rows.length > 0) {
				const lastRow = rows[rows.length - 1];

				let nextTableBody;
				if (i + 1 < tables.length) {
					const nextTable = tables[i + 1];
					nextTableBody = nextTable.querySelector('tbody');
				} else {
					nextTableBody = createNewTable();
				}

				nextTableBody.insertBefore(lastRow, nextTableBody.firstChild);
			}
		}
	}
}

function observeTableChanges() {
	const tableBodies = document.querySelectorAll('.table table tbody');

	tableBodies.forEach((tableBody) => {
		const observer = new MutationObserver(() => {
			moveRowsBetweenTables();
		});

		observer.observe(tableBody, { childList: true, subtree: true });
	});
}

document.addEventListener('DOMContentLoaded', () => {
	observeTableChanges();
	moveRowsBetweenTables();
});
