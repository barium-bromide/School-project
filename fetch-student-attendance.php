<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $attendanceClass = htmlspecialchars($_POST["attendance-class"]);
    $attendanceDate = htmlspecialchars($_POST["attendance-date"]);
    $_SESSION['attendance-class'] = $attendanceClass;
    $_SESSION['attendance-date'] = $attendanceDate;
    header("Location: subject.php");
    die();
} else {
    header("Location: studentpick.php");
    die();
}
