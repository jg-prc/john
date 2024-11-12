const form = document.querySelector(".right-container form");

form.addEventListener("submit", async (e) => {
	e.preventDefault();
	let formIsValid = true;

	// Validate each field and set error messages if needed
	formIsValid = validateInput(email, "Email cannot be blank") && formIsValid;
	formIsValid = validateInput(password, "Password cannot be blank") && formIsValid;

	if (formIsValid) {
		try {
			const formData = new FormData(form);

			const response = await fetch("php/login.php", {
				method: "POST",
				body: formData,
			});

const responseText = await response.text(); // Get raw response text
console.log("Raw response:", responseText);

let data;
try {
    data = JSON.parse(responseText); // Parse JSON response
} catch (error) {
    console.error("Error parsing JSON:", error, responseText);
    Swal.fire("Error", "Invalid server response.", "error");
    return;
}


			// Now handle the JSON response
			if (data.status === "success") {
				Swal.fire("Success", "Login successful", "success").then(() => {
					// Redirect based on the role
					if (data.role === "admin") {
						window.location.href = "dashboard.php";
					} else {
						window.location.href = "user-dashboard.php";
					}
				});
			} else {
				Swal.fire("Error", data.message, "error");
			}
		} catch (error) {
			console.error("Error during fetch operation:", error);
			Swal.fire("Error", "Something went wrong!", "error");
		}
	}
});

// Validation functions
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
