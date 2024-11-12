const form = document.querySelector(".container form");

form.addEventListener("submit", (e) => {
	e.preventDefault();
	let formIsValid = true;

	// Validate each field and set error messages if needed
	formIsValid = validateInput(firstname, "First Name cannot be blank") && formIsValid;
	formIsValid = validateInput(lastname, "Last Name cannot be blank") && formIsValid;
	formIsValid = validateInput(middlename, "Middle Name cannot be blank") && formIsValid;
	formIsValid = validateInput(bdate, "Birthdate cannot be blank") && formIsValid;
	formIsValid = validateInput(sex, "Sex cannot be blank") && formIsValid;
	formIsValid = validateInput(contact, "Contact No. cannot be blank") && formIsValid;
	formIsValid = validateInput(barangay, "Barangay cannot be blank") && formIsValid;
	formIsValid = validateInput(zone, "Zone cannot be blank") && formIsValid;
	formIsValid = validateInput(position, "Position cannot be blank") && formIsValid;
	formIsValid = validateInput(email, "Email cannot be blank") && formIsValid;
	formIsValid = validateInput(password, "Password cannot be blank") && formIsValid;

	if (formIsValid) {
		// Show confirmation prompt
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
					const formData = new FormData(form);

					const response = await fetch("php/create.php", {
						method: "POST",
						body: formData,
					});

					if (response.ok) {
						const data = await response.text();
						console.log(data);
						if (data === "success") {
							Swal.fire("Saved!", "", "success").then(() => {
								location.href = "accounts.php";
							});
						} else {
							Swal.fire("Error", data, "error");
						}
					} else {
						throw new Error(`Server responded with status: ${response.status}`);
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

// Function to validate input and show error if necessary
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
