		function generatePassword() {
			const length = 6;
			const charset = "0123456789";
			let password = "";
			for (let i = 0, n = charset.length; i < length; ++i) {
				password += charset.charAt(Math.floor(Math.random() * n));
			}
			document.getElementById("password").value = password;
		}