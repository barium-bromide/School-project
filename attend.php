<?php
function variable_empty_checker($variable) {
    if (empty($variable)) {
        header("Location: studentpick.php");
        die();
    }
}

session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $report = htmlspecialchars($_POST["report"]);

    if (empty($report)) {
        if ($_SESSION['role'] == "Teacher") {
            $record = htmlspecialchars($_POST["record"]);
            variable_empty_checker($record);
            $_SESSION['task'] = $record;
        } elseif ($_SESSION['role'] == "Student") {
            $submit = htmlspecialchars($_POST["submit"]);
            variable_empty_checker($submit);
            $_SESSION['task'] = $submit;
        } else {
            header("Location: studentpick.php");
            die();
        }
    } else {
        $_SESSION['task'] = $report;
    }
    header("Location: attend.php");
    die();
} else {
    // header("Location: studentpick.php");
    die("no post");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Form | My Attendance</title>
    <link rel="stylesheet" href="public/style/attend.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
</head>
<body>
    <h1>My Attendance</h1>
    <?php
        if ($_SESSION['role'] == "Teacher") {
            echo("<h2>Welcome Cikgu ".$_SESSION['username']);
        } elseif ( $_SESSION['role'] == "Student"){
            echo("<h2>Welcome ".$_SESSION['name']." from ".$_SESSION['class']."</h2>");
        }
        echo($_SESSION['task'])
    ?>
    <div>
        <div class="container">
            <div class="radio-tile-group">

                <div class="input-container">
                    <i class="fa-solid fa-plus-minus"></i>
                    <input type="submit" value="Add math" class='radio-tile'>
                </div>
            </div>
        </div>
    </div>
</body>