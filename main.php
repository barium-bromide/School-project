<?php
try {
    require_once 'dbh.inc.php';
    require_once 'kod.php';
    get_code($conn);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

function variable_empty_checker($location, ...$variable)
{
    foreach ($variable as $var) {
        if (empty($var)) {
            header("Location: " . $location);
            die();
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        require_once 'dbh.inc.php';
        require_once 'attendance_report_model.inc.php';
        if (isset($_POST["edit"])) {
            $edit = strtolower(htmlspecialchars($_POST["edit"]));
            if ($edit != "ya" && $edit != "tidak") {
                header("Location: edit.php");
                die();
            }
            $dataToSql = $_SESSION['data-to-edit'];
            variable_empty_checker("pickbox.php", $dataToSql);
            $data = explode("#", $dataToSql);
            $id = $data[0];
            $date = $data[1];
            $edit = $edit == "ya";
            edit_kehadiran_by_id_and_date($conn, $id, $date, $edit);
        } elseif (isset($_POST["more-name"]) && isset($_POST["more-attendance"]) && isset($_POST["more-attendance-time"]) && isset($_POST["more-class"])) {
            $moreName = htmlspecialchars($_POST["more-name"]);
            $moreAttendance = strtolower(htmlspecialchars($_POST["more-attendance"]));
            $moreAttendanceTime = htmlspecialchars($_POST["more-attendance-time"]);
            $moreClass = strtoupper(htmlspecialchars($_POST["more-class"]));
            variable_empty_checker("more.php", $moreName, $moreAttendance, $moreAttendanceTime, $moreClass);
            if ($moreAttendance != "ya" && $moreAttendance != "tidak") {
                header("Location: more.php");
                die();
            }
            $result = get_student($conn, $moreName, $moreClass);
            if ($result) {
                $moreDate = date("Y-m-d", strtotime($moreAttendanceTime));
                $result2 = get_kehadiran_by_class_and_id($conn, $moreClass, $moreName, $moreDate);
                if (!$result2) {
                    $moreAttendance = $moreAttendance == "ya";
                    insert_kehadiran_of_added($conn, $moreName, $moreAttendanceTime, $moreAttendance);
                } else {
                    header("Location: more.php");
                    die();
                }
            } else {
                header("Location: more.php");
                die();
            }
        } else {
            if (!isset($_POST["report"])) {
                if ($_SESSION['role'] == "Teacher") {
                    $record = htmlspecialchars($_POST["record"]);
                    variable_empty_checker("pickbox.php", $record);
                    $_SESSION['task'] = $record;
                } elseif ($_SESSION['role'] == "Student") {
                    $submit = htmlspecialchars($_POST["submit"]);
                    variable_empty_checker("pickbox.php", $submit);
                    $_SESSION['task'] = $submit;
                }
            } else {
                $report = htmlspecialchars($_POST["report"]);
                $_SESSION['task'] = $report;
            }
        }
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
} else {
    if (!isset($_SESSION['attendance-date']) || !isset($_SESSION['attendance-class'])) {
        header("Location: pickbox.php");
        die();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kehadiran | Utama</title>
    <link rel="stylesheet" href="public/style/subject.css">
    <script src="public/js/subject.js" defer></script>
    <script src="public/js/main.js"></script>
</head>

<body>
    <?php
    if ($_SESSION['role'] == "Teacher") {
        include 'teacher.php';
    } elseif ($_SESSION['role'] == "Student") {
        include 'student.php';
    }
    ?>
    <form action="back.php" method="post">
        <input type='submit' id='date-submit' value='Kembali'>
    </form>
</body>

</html>