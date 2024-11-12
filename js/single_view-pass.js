		function togglePasswordVisibility(passwordField, icon) {
			if (passwordField.type === 'password') {
				passwordField.setAttribute('type', 'text');
				icon.className = 'fa fa-eye';
			} else {
				passwordField.setAttribute('type', 'password');
				icon.className = 'fa fa-eye-slash';
			}
		}

		var hidepass = document.getElementById('password');
		var icon = document.getElementById('icon');

		icon.onclick = function () {
			togglePasswordVisibility(hidepass, icon);
		};