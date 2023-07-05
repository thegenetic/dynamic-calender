<?php
require_once dirname(__FILE__) . "/db_conn.php";

$sql = "SELECT * FROM calendar_inputs";
$result = mysqli_query($conn, $sql);

$dates = (array) null;


if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $new_date = date("j-F-Y", strtotime($row['date']));
        array_push($dates, $new_date);
    }
}


?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Calendar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body class="dark">
    <div class="calendar">
        <!-- CALENDAR HEADER START -->
        <div class="calendar-header">
            <span class="month-picker" id="month-picker">
                February
            </span>
            <div class="year-picker">
                <span class="year-change mt-3" id="prev-year">
                    <pre> < </pre>
                </span>
                <span id="year">2023</span>
                <span class="year-change mt-3" id="next-year">
                    <pre> > </pre>
                </span>
            </div>


        </div>

        <!-- CALENDAR BODY START -->
        <div class="calendar-body">
            <div class="calendar-week-day">
                <div>Sun</div>
                <div>Mon</div>
                <div>Tue</div>
                <div>Wed</div>
                <div>Thu</div>
                <div>Fri</div>
                <div>Sat</div>
            </div>
            <div class="calendar-day">

            </div>

            <!-- CALENDAR FOOTER START -->
            <div class="calendar-footer">
                <div class="toggle">
                    <span>Dark Mode</span>
                    <div class="dark-mode-switch">
                        <div class="dark-mode-switch-ident"></div>
                    </div>
                </div>
            </div>

            <div class="month-list"></div>
        </div>

        <!-- <script src="script.js"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script>
            var passedArray =
                <?php echo json_encode($dates); ?>;

            console.log(passedArray);

            //Dark Mode Toggle
            document.querySelector('.dark-mode-switch').onclick = () => {
                document.querySelector('body').classList.toggle('dark');
                document.querySelector('body').classList.toggle('light');
            };




            //Check Year
            isCheckYear = (year) => {
                return (year % 4 === 0 && year % 100 !== 0 && year % 400 !== 0) ||
                    (year % 100 === 0 && year % 400 === 0)
            };

            getFebDays = (year) => {
                return isCheckYear(year) ? 29 : 28
            };

            let calendar = document.querySelector('.calendar');
            const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            let monthPicker = document.querySelector('#month-picker');

            monthPicker.onclick = () => {
                monthList.classList.add('show')
            };


            //Generate Calendar
            generateCalendar = (month, year) => {

                let calendarDay = document.querySelector('.calendar-day');
                calendarDay.innerHTML = '';

                let calendarHeaderYear = document.querySelector('#year');
                let daysOfMonth = [31, getFebDays(year), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
                let currDate = new Date();

                monthPicker.innerHTML = monthNames[month];
                calendarHeaderYear.innerHTML = year;

                let firstDay = new Date(year, month, 1);
                let tmonth = document.getElementById('month-picker').innerHTML;
                let tyear = document.getElementById('year').innerHTML;

                for (let i = 0; i <= daysOfMonth[month] + firstDay.getDay() - 1; i++) {
                    let day = document.createElement('div')


                    if (i >= firstDay.getDay()) {
                        // day.classList.add('calendarDayHover')
                        day.innerHTML = i - firstDay.getDay() + 1
                        // day.innerHTML += `<span>a</span>
                        //                  <span>b</span>
                        //                  <span>d</span>
                        //                  <span>c</span>`
                        day.classList.add('testDate');
                        tdate = day.innerHTML;
                        var date_class = tdate.concat('-', tmonth, '-', tyear);
                        day.classList.add(date_class);
                        if (i - firstDay.getDay() + 1 === currDate.getDate() && year === currDate.getFullYear() && month === currDate.getMonth()) {
                            day.classList.add('currDate');
                        }
                    }

                    calendarDay.appendChild(day)
                };

                // var available_dates = document.getElementsByClassName('')
                passedArray.forEach(i => {
                    let available_dates = document.getElementsByClassName(i)
                    if (available_dates.length > 0) {
                        for (let j = 0; j < available_dates.length; j++) {
                            available_dates[j].classList.add('availableDate');
                        }
                    }
                });
            };

            let monthList = calendar.querySelector('.month-list');

            monthNames.forEach((e, index) => {
                let month = document.createElement('div')
                month.innerHTML = `<div>${e}</div>`
                month.onclick = () => {
                    monthList.classList.remove('show')
                    currMonth.value = index
                    generateCalendar(currMonth.value, currYear.value)
                }
                monthList.appendChild(month)
            });

            document.querySelector('#prev-year').onclick = () => {
                --currYear.value
                generateCalendar(currMonth.value, currYear.value)
            };

            document.querySelector('#next-year').onclick = () => {
                ++currYear.value
                generateCalendar(currMonth.value, currYear.value)
            };

            let currDate = new Date();
            let currMonth = {
                value: currDate.getMonth()
            };
            let currYear = {
                value: currDate.getFullYear()
            };

            generateCalendar(currMonth.value, currYear.value);

        </script>
</body>

</html>
