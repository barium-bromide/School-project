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

<body>
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
                <input id="name" type="text" maxlength="15" placeholder="Enter name" required>
                <h2>Class</h2>
                <div class="dropdown" id="class-dropdown">
                    <?php
                    include 'dbh.inc.php';
                    $query = "SELECT DISTINCT nama_kelas FROM kelas";
                    $stmt = $conn->prepare($query);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($result) {
                        echo "<div class='select'><span class='selected' name='class' id='class'></span><div class='caret'></div></div><ul class='menu'>";
                        foreach ($result as $classname) echo "<li>$classname</li>";
                        echo "</ul>";
                    } else {
                        echo "<div class='select'><span class='selected' name='class' id='class'>None</span><div class='caret'></div></div><ul class='menu'></ul>";
                    }

                    ?>
                    <!-- <div class="select">
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
                    </ul> -->
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

</html>