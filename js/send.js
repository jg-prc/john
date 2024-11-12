const form = document.querySelector(".sub-container form");

form.addEventListener("submit", (e) => {
	e.preventDefault();
	let formIsValid = true;

	formIsValid = validateInput(incident_type, "Incident can't be blank") && formIsValid;
	formIsValid = validateInput(barangay, "Barangay can't be blank") && formIsValid;
	formIsValid = validateInput(zone, "Zone can't be blank") && formIsValid;

	if (formIsValid) {
		// Show confirmation prompt
		Swal.fire({
			title: "Do you want to send the report?",
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

					const response = await fetch("php/send.php", {
						method: "POST",
						body: formData,
					});

					if (response.ok) {
						const data = await response.text();
						console.log(data);
						if (data === "success") {
							Swal.fire("Saved!", "", "success").then(() => {
								location.href = "user-dashboard.php";
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