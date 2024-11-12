		function validatePassword() {
			const password = document.getElementById('new-pass').value;
			const confirmPass = document.getElementById('confirm-pass');
			const confirmpassValue = confirmPass.value.trim();

			let isValid = true;

			function updateIcon(elementId, isValid) {
				const icon = document.getElementById(elementId).querySelector('i');
				if (isValid) {
					icon.className = 'fas fa-circle-check';
					icon.style.color = '#008000';
				} else {
					icon.className = 'fas fa-circle-xmark';
					icon.style.color = '#e74c3c';
				}
			}

			updateIcon('length', password.length >= 8 && password.length <= 20);
			updateIcon('uppercase', /[A-Z]/.test(password));
			updateIcon('lowercase', /[a-z]/.test(password));
			updateIcon('number', /\d/.test(password));
			updateIcon('special-char', /^[^`;\:',"\/\\]*$/.test(password));
			updateIcon('no-spaces', !/\s/.test(password));

			isValid = (password.length >= 8 && password.length <= 20) &&
				/[A-Z]/.test(password) &&
				/[a-z]/.test(password) &&
				/\d/.test(password) &&
				/^[^`;\:',"\/\\]*$/.test(password) &&
				!/\s/.test(password);

			if (password !== confirmpassValue) {
				setErrorFor(confirmPass, "Passwords do not match");
			} else {
				setSuccessFor(confirmPass);
			}
		}

function setErrorFor(input, message) {
	const inputBox = input.parentElement;
	const error = inputBox.querySelector(".message");
	inputBox.classList.add("error");
	error.innerText = message;
}

function setSuccessFor(input) {
	const inputBox = input.parentElement;
	inputBox.classList.remove("error");
	inputBox.classList.add("success");
}
		document.getElementById('new-pass').addEventListener('input', validatePassword);
