<?php
	$search = isset($_GET['search']) ? $_GET['search'] : '';
	$barangay = isset($_GET['barangay']) ? $_GET['barangay'] : '';
	$position = isset($_GET['position']) ? $_GET['position'] : '';
	$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'CreatedAt-desc';
?>
			<div class="tools">
				<div class="search-box">
					<i class="fas fa-magnifying-glass"></i>
					<input type="text" placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>">
				</div>
				<div class="dropdown-container">
					<div class="dropdown-button">
						<button onclick="toggleSortOrder()">
							<i class="fa fa-arrow-up-short-wide" id="sort-icon"></i>
							<label>Sort</label>
						</button>
						<button onclick="toggleFilterMenu()">
							<i class="fa fa-sliders"></i>
							<label>Filter</label>
						</button>
					</div>
					<div class="filter-container" id="filtermenu">

						<span>Filter</span>

						<div class="filter-group">
							<div class="filter-title">
								<label for="barangay">Barangay</label>
								<a href="#" id="reset-barangay" onclick="resetFilter('barangay')">Reset</a>
							</div>
							<select id="barangay">
								<option value="">All</option>
								<option value="Adiangao">Adiangao</option>
								<option value="Bagacay">Bagacay</option>
								<option value="Bahay">Bahay</option>
								<option value="Boclod">Boclod</option>
								<option value="Calalahan">Calalahan</option>
								<option value="Calawit">Calawit</option>
								<option value="Camagong">Camagong</option>
								<option value="Catalotoan">Catalotoan</option>
								<option value="Danlog">Danlog</option>
								<option value="Del Carmen (Poblacion)">Del Carmen (Poblacion)</option>
								<option value="Dolo">Dolo</option>
								<option value="Kinalansan">Kinalansan</option>
								<option value="Mampirao">Mampirao</option>
								<option value="Manzana">Manzana</option>
								<option value="Minoro">Minoro</option>
								<option value="Palale">Palale</option>
								<option value="Ponglon">Ponglon</option>
								<option value="Pugay">Pugay</option>
								<option value="Sabang">Sabang</option>
								<option value="Salogon">Salogon</option>
								<option value="San Antonio (Poblacion)">San Antonio (Poblacion)</option>
								<option value="San Juan (Poblacion)">San Juan (Poblacion)</option>
								<option value="San Vicente (Poblacion)">San Vicente (Poblacion)</option>
								<option value="Santa Cruz (Poblacion)">Santa Cruz (Poblacion)</option>
								<option value="Soledad (Poblacion)">Soledad (Poblacion)</option>
								<option value="Tagas">Tagas</option>
								<option value="Tambangan">Tambangan</option>
								<option value="Telegrafo">Telegrafo</option>
								<option value="Tominawog">Tominawog</option>
							</select>
						</div>
						<div class="filter-group">
							<div class="filter-title">
								<label for="position">Position</label>
								<a href="#" id="reset-position" onclick="resetFilter('position')">Reset</a>
							</div>
							<select id="position">
								<option value="">All</option>
								<option value="Brgy. Captain">Brgy. Captain</option>
								<option value="Brgy. Kagawad">Brgy. Kagawad</option>
							</select>
						</div>
						<div class="actions">
							<button class="reset-btn" onclick="resetAllFilters()">Reset all</button>
							<button class="apply-btn" onclick="applyFilters()">Apply all</button>
						</div>
					</div>
				</div>
			</div>