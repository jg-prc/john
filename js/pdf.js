let button = document.getElementById("button");
let makepdf = document.getElementById("makepdf");

button.addEventListener("click", function () {
	try {
		let options = {
			margin: 0.1,
			image: { type: 'jpeg', quality: 0.98 },
			html2canvas: { 
				scale: 2
			},
			jsPDF: { unit: 'in', format: [8.5, 13], orientation: 'landscape' }
		};

		html2pdf()
			.set(options)
			.from(makepdf)
			.toPdf()
			.get('pdf')
			.then(function (pdf) {
				window.open(pdf.output('bloburl'), '_blank');
			})
			.catch(function (error) {
				console.error("Error generating PDF:", error);
				alert("An error occurred while generating the PDF. Please try again.");
			});
	} catch (error) {
		console.error("Unexpected error:", error);
		alert("An unexpected error occurred. Please refresh the page and try again.");
	}
});