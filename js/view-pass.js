		function togglePasswordVisibility(passwordField, icon) {
			if (passwordField.className === 'active') {
				passwordField.setAttribute('type', 'text');
				icon.className = 'fa fa-eye';
				passwordField.className = '';
			} else {
				passwordField.setAttribute('type', 'password');
				icon.className = 'fa fa-eye-slash';
				passwordField.className = 'active';
			}
		}

		var hidepass1 = document.getElementById('new_pass');
		var hidepass2 = document.getElementById('confirm_pass');

		var icon1 = document.getElementById('icon1');
		var icon2 = document.getElementById('icon2');

		icon1.onclick = function () {
			togglePasswordVisibility(hidepass1, icon1);
		};

		icon2.onclick = function () {
			togglePasswordVisibility(hidepass2, icon2);
		};