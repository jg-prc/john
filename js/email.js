const changeemailform = document.getElementById("change-email");

changeemailform.addEventListener("submit", (e) => {
	e.preventDefault();
	let formIsValid = true;

	formIsValid = validateInput(current_email, "Email cannot be blank") && formIsValid;
	formIsValid = validateInput(new_email, "New Email cannot be blank") && formIsValid;

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
					const formData = new FormData(changeemailform);

					const response = await fetch("php/email.php", {
						method: "POST",
						body: formData,
					});

					const data = await response.text();
                    
					if (data === "success") {
						Swal.fire(
							"Successfully Updated",
							"",
							"success"
						).then(() => {
							// Redirect to archive.php after closing the success message
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
