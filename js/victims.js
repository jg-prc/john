const form1 = document.querySelector(".sub-container1 form");
const form2 = document.querySelector(".sub-container2 form");

form2.addEventListener("submit", (e) => {
	e.preventDefault();
	let formIsValid = true;
    
	const reportId = document.querySelector(".sub-container2")?.dataset.reportId;
    
	const inputs = {
		names: document.querySelectorAll("input[name='name[]']"),
		addresses: document.querySelectorAll("textarea[name='address[]']"),
		ages: document.querySelectorAll("input[name='age[]']"),
		sexes: document.querySelectorAll("select[name='sex[]']"),
		classifications: document.querySelectorAll("textarea[name='classification[]']"),
		update_names: document.querySelectorAll("input[name='update_name[]']"),
		update_addresses: document.querySelectorAll("textarea[name='update_address[]']"),
		update_ages: document.querySelectorAll("input[name='update_age[]']"),
		update_sexes: document.querySelectorAll("select[name='update_sex[]']"),
		update_classifications: document.querySelectorAll("textarea[name='update_classification[]']")
	};

	const messages = {
		names: "Name cannot be blank",
		addresses: "Address cannot be blank",
		ages: "Age cannot be blank",
		sexes: "Sex cannot be blank",
		classifications: "Classification cannot be blank"
	};

	for (const [key, elements] of Object.entries(inputs)) {
		elements.forEach(element => {
			formIsValid = validateInput(element, messages[key.replace('update_', '')]) && formIsValid;
		});
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
					const formData = new FormData(form1);

					new FormData(form2).forEach((value, key) => {
						formData.append(key, value);
					});

					const response = await fetch("php/victims.php", {
						method: "POST",
						body: formData,
					});

					if (response.ok) {
						const data = await response.text();
						if (data === "success") {
							Swal.fire("Saved!", "", "success").then(() => {
								location.href = "report_file.php?report_id=" + reportId;
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
	const value = input?.value.trim();
	if (value === "") {
		setErrorFor(input, errorMessage);
		return false;
	} else {
		setSuccessFor(input);
		return true;
	}
}

function setErrorFor(input, message) {
	const inputBox = input?.parentElement;
	const error = inputBox?.querySelector(".message");
	inputBox?.classList.add("error");
	if (error) {
		error.innerText = message;
	}
}

function setSuccessFor(input) {
	const inputBox = input?.parentElement;
	inputBox?.classList.remove("error");
	inputBox?.classList.add("success");
}
