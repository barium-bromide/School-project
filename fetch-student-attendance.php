<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $attendanceClass = htmlspecialchars($_POST["attendance-class"]);
    $attendanceDate = htmlspecialchars($_POST["attendance-date"]);
    $attendanceKP = htmlspecialchars($_POST["attendance-kp"]);
    $_SESSION['attendance-class'] = $attendanceClass;
    $_SESSION['attendance-date'] = $attendanceDate;
    $_SESSION['attendance-kp'] = $attendanceKP;
    header("Location: main.php");
    die();
} else {
    header("Location: pickbox.php");
    die();
}
