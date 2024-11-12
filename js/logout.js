document.getElementById('logoutButton').addEventListener('click', function(event) {
    event.preventDefault();

    Swal.fire({
        title: "Do you want to Logout?",
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        customClass: {
            confirmButton: 'confirm-button',
            cancelButton: 'deny-button'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "php/logout.php";
        }
    });
});
