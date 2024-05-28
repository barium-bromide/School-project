<?php
session_start();
// session_unset();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Form | Login</title>
    <link rel="stylesheet" href="public/style/login.css">
    <script src="public/js/login.js" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body onload='getData()'>
    <div class="center">
        <div class="loginbox">
            <h1>Key In</h1>
            <div id="teacher-form" class="hide">
                <h2>Username</h2>
                <input id="username" type="text" maxlength="15" placeholder="Enter username" required>
                <h2>Password</h2>
                <input id="password" type="password" maxlength="20" placeholder="Enter password" required>
            </div>
            <div id="student-form">
                <h2>Name</h2>
                <div class="dropdown">
                    <div class="select">
                        <span class="selected" id="name">
                            C
                        </span>
                        <div class="caret"></div>
                    </div>
                    <ul class="menu">
                        <li>A</li>
                        <li>B</li>
                        <li class="active">C</li>
                        <li>D</li>
                        <li>E</li>
                        <li>F</li>
                    </ul>
                </div>
                <h2>Class</h2>
                <div class="dropdown">
                    <div class="select">
                        <span class="selected" name="class" id="class">
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
            </div>
            <h2>You are a</h2>
            <div class="dropdown">
                    <div class="select">
                        <span class="selected" name="role" id="role">
                            Student
                        </span>
                        <div class="caret"></div>
                    </div>
                    <ul class="short menu">
                        <li>Teacher</li>
                        <li class="active">Student</li>
                    </ul>
                </div>
            <input type="submit" id="loginbtn" value="Submit">
        </div>
    </div>
</body>

<script type="text/javascript">
    function getData() {
        //fetcj data from database, all studentname and class
        $.ajax({
            url: 'getData.php',
            type: 'POST',
            success: function(data) {
                var obj = JSON.parse(data);
                var name = obj.name;
                var classs = obj.class;
                var nameList = "";
                var classList = "";
                for (var i = 0; i < name.length; i++) {
                    nameList += "<li>" + name[i] + "</li>";
                }
                for (var i = 0; i < classs.length; i++) {
                    classList += "<li>" + classs[i] + "</li>";
                }
                document.getElementById("student-form").innerHTML = "<h2>Name</h2><div class='dropdown'><div class='select'><span class='selected' id='name'>" + name[0] + "</span><div class='caret'></div></div><ul class='menu'>" + nameList + "</ul></div><h2>Class</h2><div class='dropdown'><div class='select'><span class='selected' name='class' id='class'>" + classs[0] + "</span><div class='caret'></div></div><ul class='menu'>" + classList + "</ul></div>";
            }
        });
    }
</script>