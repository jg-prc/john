const changeemailform = document.getElementById("change-email");

changeemailform.addEventListener("submit", (e) => {
	e.preventDefault();
	let formIsValid = true;

	// Validate inputs
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

					// Log the form data keys and values
					for (let [key, value] of formData.entries()) {
						console.log(`FormData - ${key}: ${value}`);
					}

					const response = await fetch("php/user-email.php", {
						method: "POST",
						body: formData,
					});

					const data = await response.text();
					
					// Log the raw response data for debugging
					console.log("Response Data:", data);

					if (data === "success") {
						Swal.fire(
							"Successfully Updated",
							"",
							"success"
						).then(() => {
							// Redirect to archive.php after closing the success message
							location.href = "user-privacy.php";
						});
					} else {
						// Parse and log error details for debugging
						try {
							const parsedData = JSON.parse(data);
							console.log("Parsed Error Data:", parsedData);
							Swal.fire("Error", parsedData.message || data, "error");
						} catch (jsonError) {
							console.error("JSON Parsing Error:", jsonError);
							Swal.fire("Error", data, "error");
						}
					}
				} catch (error) {
					// Log the error for debugging
					console.error("Fetch Error:", error);
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
	console.log(`Validating input for ${input.id}:`, value); // Log validation steps
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
	console.log(`Set error for ${input.id}: ${message}`); // Log error setting
}

function setSuccessFor(input) {
	const inputBox = input.parentElement;
	inputBox.classList.remove("error");
	inputBox.classList.add("success");
	console.log(`Set success for ${input.id}`); // Log success setting
}
