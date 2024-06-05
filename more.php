<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Form | Edit</title>
    <link rel="stylesheet" href="public/style/login.css">
    <script src="public/js/login.js" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <div class="center">
        <form action="subject.php" method="post" class="loginbox">
            <h1>Add more</h1>
            <div id="teacher-form">
                <h2>Student's id</h2>
                <input id="username" name="more-name" type="text" maxlength="15" placeholder="Key in the student's name" required>
                <h2>Student's class</h2>
                <input id="username" name="more-class" type="text" maxlength="15" placeholder="Key in the student's name" required>
                <h2>Student's attendance time</h2>
                <input type='datetime-local' id='date' name='more-attendance-time'>
                <h2>Student's attendance</h2>
                <input id="username" name="more-attendance" type="text" maxlength="3" placeholder="Key in yes or no" required>
            </div>
            <input type="submit" id="loginbtn" value="Save">
        </form>
    </div>
</body>