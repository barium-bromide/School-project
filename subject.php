<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Form | Science</title>
    <link rel="stylesheet" href="public/style/subject.css">
    <script src="public/js/subject.js" defer></script>
</head>
<body>
    <h1>Student Lee Le Le</h1>
    <!-- <h2>Key in the code teacher gave here</h2>
    <h2>*This code will record your attendance</h2>
    <div class="code">
        <input type="text" maxlength="15" name="name" placeholder="Enter code" required>
        <input type="submit" id="submitbtn" value="Submit">
    </div> -->
    <h2>Select your class</h2>
    <div class="dropdown">
        <div class="select">
            <span class="selected">
                4ST4
            </span>
            <div class="caret"></div>
        </div>
        <ul class="menu">
            <li>4ST1</li>
            <li>4ST2</li>
            <li>4ST3</li>
            <li class="active">4ST4</li>
            <li>4ST5</li>
            <li>4ST6</li>
            <li>4ST7</li>
        </ul>
    </div>
    <!-- <form action="">
        <label for="date">Date:</label>
        <input type="date" id="date" name="date">
        <input type="submit" id="date-submit" value="Confirm">
    </form> -->
    <h2>Your Attendance Rate</h2>
        <div class="bar">
            <p>90%</p>
            <span class="percentage-bar"></span>
        </div>
        <!-- table | class | time | date | attendance | (Edit) -->
        <div class="table-container">
            <table>
                <caption>
                    Your Attendance
                </caption>
                <tr>
                    <!-- <th>Name</th> -->
                    <th>Time</th>
                    <th>Date</th>
                    <th>Attendance</th>
                    <!-- <th>Attendance Rate</th> -->
                    <!-- <th>Edit</th> -->
                </tr>
                <tr>
                    <!-- <td>John</td> -->
                    <td data-cell="time">23:59:59</td>
                    <td data-cell="date">24/12/2023</td>
                    <td data-cell="attendance"><div><span class="yes">✔</span><span class="no">X</span></div></td>
                    <!-- <td data-cell="attendance rate">80%</td>
                    <td data-cell="edit"><a href="url">Edit</a></td> -->
                </tr>
                <tr>
                    <!-- <td>Baba</td> -->
                    <td data-cell="time">23:59:59</td>
                    <td data-cell="date">25/12/2023</td>
                    <td data-cell="attendance"><div><span class="yes">✔</span><span class="no">X</span></div></td>
                    <!-- <td data-cell="attendance rate">100%</td>
                    <td data-cell="edit"><a href="url">Edit</a></td> -->
                </tr>
            </table>
    </div>
    <!-- <div class="link-wrapper">
        <p>Add</p>
        <a href="url">More</a>
    </div> -->
    <!-- <input type="submit" id="save" value="Save"> -->
</body>