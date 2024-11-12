<?php
// Extract the date from the URL if present, otherwise use the current date
$selectedDate = isset($_GET['date']) ? $_GET['date'] : date("Y-m-d");
$currentDate = date("Y-m-d"); // Current date
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            display: flex;
            align-items: center;
            padding: 0 10px;
            justify-content: center;
            min-height: 100vh;
            background: #9B59B6;
        }
        .wrapper {
            width: 450px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }
        .wrapper header {
            display: flex;
            align-items: center;
            padding: 25px 30px 10px;
            justify-content: space-between;
        }
        header .icons {
            display: flex;
        }
        header .icons span {
            height: 38px;
            width: 38px;
            margin: 0 1px;
            cursor: pointer;
            color: #878787;
            text-align: center;
            line-height: 38px;
            font-size: 1.9rem;
            user-select: none;
            border-radius: 50%;
        }
        .icons span:last-child {
            margin-right: -10px;
        }
        header .icons span:hover {
            background: #f2f2f2;
        }
        header .current-date {
            font-size: 1.45rem;
            font-weight: 500;
        }
        .calendar {
            padding: 20px;
        }
        .calendar ul {
            display: flex;
            flex-wrap: wrap;
            list-style: none;
            text-align: center;
        }
        .calendar .days {
            margin-bottom: 20px;
        }
        .calendar li {
            color: #333;
            width: calc(100% / 7);
            font-size: 1.07rem;
        }
        .calendar .weeks li {
            font-weight: 500;
            cursor: default;
        }
        .calendar .days li {
            z-index: 1;
            cursor: pointer;
            position: relative;
            margin-top: 30px;
        }
        .days li.inactive {
            color: #aaa;
        }
        .days li.active {
            color: #fff;
        }
        .days li::before {
            position: absolute;
            content: "";
            left: 50%;
            top: 50%;
            height: 40px;
            width: 40px;
            z-index: -1;
            border-radius: 50%;
            transform: translate(-50%, -50%);
        }
        .days li.active::before {
            background: #9B59B6;
        }
        .days li.selected::before {
            background: #3498DB;
        }
        .days li:not(.active):hover:not(.selected)::before {
            background: #f2f2f2;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <header>
        <p class="current-date"></p> <!-- Will be updated by JS -->
        <div class="icons">
            <span id="prev" class="fa fa-chevron-left"></span>
            <span id="next" class="fa fa-chevron-right"></span>
        </div>
    </header>
    <div class="calendar">
        <ul class="weeks">
            <li>Sun</li>
            <li>Mon</li>
            <li>Tue</li>
            <li>Wed</li>
            <li>Thu</li>
            <li>Fri</li>
            <li>Sat</li>
        </ul>
        <ul class="days"></ul>
    </div>
    <!-- Set input date to the selected date or current date by default -->
    <input type="date" id="selectedDate" value="<?php echo $selectedDate; ?>" onchange="updateUrlWithDate()">
</div>
<script>
    // Extract the PHP-selected date and pass it to JavaScript
    const selectedDateFromPHP = "<?php echo $selectedDate; ?>";
    const currentDateFromPHP = "<?php echo $currentDate; ?>"; // Current date from PHP

    const daysTag = document.querySelector(".days"),
        currentDateElement = document.querySelector(".current-date"),
        prevNextIcon = document.querySelectorAll(".icons span"),
        selectedDateInput = document.querySelector("#selectedDate");

    let date = new Date(),
        currYear = date.getFullYear(),
        currMonth = date.getMonth();

    // Use selected date from URL or fallback to the current date
    if (selectedDateFromPHP) {
        const [year, month, day] = selectedDateFromPHP.split("-");
        date = new Date(year, month - 1, day); // Adjust month as it's 0-based
        currYear = date.getFullYear();
        currMonth = date.getMonth();
    }

    const months = ["January", "February", "March", "April", "May", "June", "July",
        "August", "September", "October", "November", "December"];

    const renderCalendar = () => {
        let firstDayofMonth = new Date(currYear, currMonth, 1).getDay(),
            lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate(),
            lastDayofMonth = new Date(currYear, currMonth, lastDateofMonth).getDay(),
            lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate();

        let liTag = "";

        for (let i = firstDayofMonth; i > 0; i--) {
            liTag += `<li class="inactive" data-day="${lastDateofLastMonth - i + 1}" 
                        data-month="${currMonth === 0 ? 12 : currMonth}" 
                        data-year="${currMonth === 0 ? currYear - 1 : currYear}">
                        ${lastDateofLastMonth - i + 1}
                      </li>`;
        }

        for (let i = 1; i <= lastDateofMonth; i++) {
            // Check if it's the current date or the selected date
            let isToday = i === new Date(currentDateFromPHP).getDate() && currMonth === new Date(currentDateFromPHP).getMonth() && currYear === new Date(currentDateFromPHP).getFullYear() ? "active" : "";
            let isSelected = selectedDateFromPHP && i === parseInt(selectedDateFromPHP.split("-")[2]) && currMonth + 1 === parseInt(selectedDateFromPHP.split("-")[1]) && currYear === parseInt(selectedDateFromPHP.split("-")[0]) ? "selected" : "";

            liTag += `<li class="${isToday} ${isSelected}" data-day="${i}" data-month="${currMonth + 1}" data-year="${currYear}">${i}</li>`;
        }

        for (let i = lastDayofMonth; i < 6; i++) {
            liTag += `<li class="inactive" data-day="${i - lastDayofMonth + 1}" 
                        data-month="${currMonth + 2 > 12 ? 1 : currMonth + 2}" 
                        data-year="${currMonth + 2 > 12 ? currYear + 1 : currYear}">
                        ${i - lastDayofMonth + 1}
                      </li>`;
        }

        // Set the current date in the header
        currentDateElement.innerText = `${months[currMonth]} ${currYear}`;
        daysTag.innerHTML = liTag;

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
                updateUrlWithDate(); // Call to update the URL with the selected date
            });
        });
    };

    renderCalendar();

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

    function updateUrlWithDate() {
        const selectedDate = selectedDateInput.value;
        if (selectedDate) {
            const url = new URL(window.location.href);
            url.searchParams.set('date', selectedDate);
            window.location.href = url;
        }
    }

</script>
</body>
</html>
