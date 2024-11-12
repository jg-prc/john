const daysTag = document.querySelector(".days"),
    currentDate = document.querySelector(".current-date"),
    prevNextIcon = document.querySelectorAll(".icons span"),
    selectedDateInput = document.querySelector("#selectedDate");

let date = new Date(),
    currYear = date.getFullYear(),
    currMonth = date.getMonth();

const months = ["January", "February", "March", "April", "May", "June", "July",
    "August", "September", "October", "November", "December"];

const renderCalendar = () => {
    let firstDayofMonth = new Date(currYear, currMonth, 1).getDay(), // first day of the month
        lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate(), // last date of the month
        lastDayofMonth = new Date(currYear, currMonth, lastDateofMonth).getDay(), // last day of the month
        lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate(); // last date of the previous month

    let liTag = "";

    // Display previous month's last days
    for (let i = firstDayofMonth; i > 0; i--) {
        liTag += `<li class="inactive" data-day="${lastDateofLastMonth - i + 1}" 
                    data-month="${currMonth === 0 ? 12 : currMonth}" 
                    data-year="${currMonth === 0 ? currYear - 1 : currYear}">
                    ${lastDateofLastMonth - i + 1}
                  </li>`;
    }

    // Display current month's days
    for (let i = 1; i <= lastDateofMonth; i++) {
        let isToday = i === date.getDate() && currMonth === new Date().getMonth() && currYear === new Date().getFullYear() ? "active selected" : "";
        liTag += `<li class="${isToday}" data-day="${i}" data-month="${currMonth + 1}" data-year="${currYear}">${i}</li>`;
    }

    // Display next month's first days
    for (let i = lastDayofMonth; i < 6; i++) {
        liTag += `<li class="inactive" data-day="${i - lastDayofMonth + 1}" 
                    data-month="${currMonth + 2 > 12 ? 1 : currMonth + 2}" 
                    data-year="${currMonth + 2 > 12 ? currYear + 1 : currYear}">
                    ${i - lastDayofMonth + 1}
                  </li>`;
    }

    currentDate.innerText = `${months[currMonth]} ${currYear}`;
    daysTag.innerHTML = liTag;

    // Add event listeners to each day
    const days = document.querySelectorAll(".days li");
    days.forEach(day => {
        day.addEventListener("click", () => {
            days.forEach(d => d.classList.remove("selected"));
            day.classList.add("selected");

            const selectedDay = day.getAttribute("data-day"),
                  selectedMonth = day.getAttribute("data-month"),
                  selectedYear = day.getAttribute("data-year");

            const formattedDate = `${selectedYear}-${String(selectedMonth).padStart(2, '0')}-${String(selectedDay).padStart(2, '0')}`;
            selectedDateInput.value = formattedDate;
        });
    });
};

// Set the current date as the default value for the input field
const setDefaultDate = () => {
    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0'); // Months are zero-indexed
    const day = String(today.getDate()).padStart(2, '0');

    const formattedDate = `${year}-${month}-${day}`;
    selectedDateInput.value = formattedDate; // Set the value of the input to today's date
};

renderCalendar();
setDefaultDate(); // Set default date on page load

prevNextIcon.forEach(icon => {
    icon.addEventListener("click", () => {
        currMonth = icon.id === "prev" ? currMonth - 1 : currMonth + 1;

        if (currMonth < 0 || currMonth > 11) {
            date = new Date(currYear, currMonth, new Date().getDate());
            currYear = date.getFullYear();
            currMonth = date.getMonth();
        } else {
            date = new Date();
        }
        renderCalendar();
    });
});