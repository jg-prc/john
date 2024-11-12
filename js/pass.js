const changepassForm = document.getElementById("change-pass");
changepassForm.addEventListener("submit", (e) => {
	e.preventDefault();
	let formIsValid = true;

	formIsValid = validateInput(current_pass, "Current password cannot be blank") && formIsValid;
	formIsValid = validateInput(new_pass, "New password cannot be blank") && formIsValid;
	formIsValid = validateInput(confirm_pass, "Confirm password cannot be blank") && formIsValid;

	if (!checkPasswordRequirements(new_pass.value)) {
		setErrorFor(new_pass, "Password requirements didn't meet");
		formIsValid = false;
	}

	if (new_pass.value.trim() !== confirm_pass.value.trim()) {
		setErrorFor(confirm_pass, "Passwords do not match");
		formIsValid = false;
	}

	if (formIsValid) {
		Swal.fire({
			title: "Do you want to save the changes?",
			icon: 'info',
			showCancelButton: true,
			confirmButtonText: "Save",
			cancelButtonText: "Cancel",
			customClass: {
				confirmButton: 'confirm-button',
				cancelButton: 'cancel-button'
			}
		}).then(async (result) => {
			if (result.isConfirmed) {
				try {
					const formData = new FormData(changepassForm);
					const response = await fetch("php/pass.php", {
						method: "POST",
						body: formData,
					});
					const data = await response.text();
					if (data === "success") {
						Swal.fire("Successfully Updated", "", "success").then(() => {
							location.href = "privacy.php";
						});
					} else {
						const parsedData = JSON.parse(data);
						Swal.fire("Error", parsedData.message || data, "error");
					}
				} catch (error) {
					Swal.fire("Error", "Something went wrong!", "error");
				}
			} else if (result.isDismissed) {
				Swal.fire("Changes are not saved", "", "info");
			}
		});
	}
});

// Password validation criteria check
function checkPasswordRequirements(password) {
	const lengthValid = password.length >= 8 && password.length <= 20;
	const uppercaseValid = /[A-Z]/.test(password);
	const lowercaseValid = /[a-z]/.test(password);
	const numberValid = /\d/.test(password);
	const specialCharValid = /^[^`;\:',"\/\\]*$/.test(password);
	const noSpacesValid = !/\s/.test(password);

	// Update the validation icons
	updateIcon('length', lengthValid);
	updateIcon('uppercase', uppercaseValid);
	updateIcon('lowercase', lowercaseValid);
	updateIcon('number', numberValid);
	updateIcon('special-char', specialCharValid);
	updateIcon('no-spaces', noSpacesValid);

	// Return if all requirements are met
	return lengthValid && uppercaseValid && lowercaseValid && numberValid && specialCharValid && noSpacesValid;
}

// Update icon color and class based on validation
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

function validateInput(input, errorMessage) {
	const value = input.value.trim();
	if (value === "") {
		setErrorFor(input, errorMessage);
		return false;
	} else {
		setSuccessFor(input);
		return true;
	}
}

document.getElementById('new_pass').addEventListener('input', () => {
	const newPassInput = document.getElementById('new_pass');
	const isValid = checkPasswordRequirements(newPassInput.value);
});