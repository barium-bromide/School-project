<?php
session_start();

function variable_empty_checker($variable) {
    if (empty($variable)) {
        header("Location: studentpick.php");
        die();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["edit"])) {
        $edit = htmlspecialchars($_POST["edit"]);
        if ($edit != "yes" && $edit != "no") {
            header("Location: edit.php");
            die();
        }
        try {
            require_once 'dbh.inc.php';
            require_once 'attendance_report_model.inc.php';
            $dataToSql = $_SESSION['data-to-edit'];
            if (empty($dataToSql)) {
                header("Location: studentpick.php");
                die();
            }
            $data = explode("#", $dataToSql);
            $name = $data[0];
            $date = $data[1];
            if ($edit == "yes") {
                $edit = 1;
            } else {
                $edit = 0;
            }
            edit_kehadiran_by_name_and_date($conn, $name, $date, $edit);
            // header("Location: subject.php");
            // die();
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
        
    } else {
        if (!isset($_POST["report"])) {
            if ($_SESSION['role'] == "Teacher") {
                $record = htmlspecialchars($_POST["record"]);
                variable_empty_checker($record);
                $_SESSION['task'] = $record;
            } elseif ($_SESSION['role'] == "Student") {
                $submit = htmlspecialchars($_POST["submit"]);
                variable_empty_checker($submit);
                $_SESSION['task'] = $submit;
            }
        } else {
            $report = htmlspecialchars($_POST["report"]);
            $_SESSION['task'] = $report;
        }
    }
} else {
    if (!isset($_SESSION['attendance-date']) || !isset($_SESSION['attendance-class'])) {
        header("Location: studentpick.php");
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
    <title>Attendance Form | Science</title>
    <link rel="stylesheet" href="public/style/subject.css">
    <script src="public/js/subject.js" defer></script>
</head>
<body>
    <?php
        if ($_SESSION['role'] == "Teacher") {
            echo("<h2>Cikgu ".$_SESSION['username']);
            echo("<form action='fetch-student-attendance.php' method='post'>");
            echo("<label for='attendance-class'>Select your class: </label>");
            echo("<select class='dropdown' id='attendance-class' name='attendance-class'>");
            include 'dbh.inc.php';
            $query = "SELECT DISTINCT nama_kelas FROM kelas";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {         
                foreach ($result as $classname) echo "<option>$classname</option>";
            }
            echo("</select>");
            echo("<br>");
            echo("<label for='date'>Date:</label>");
            echo("<input type='date' id='date' name='attendance-date'>");
            echo("<br>");
            echo("<input type='submit' id='date-submit' value='Confirm'>");
            echo("</form>");
            echo("<table>");
            echo("<caption>Students' Attendance</caption>");
            echo("<tr>");
            echo("<th>Name</th>");
            echo("<th>Time</th>");
            echo("<th>Date</th>");
            echo("<th>Attendance</th>");
            echo("<th>Edit</th>");
            echo("</tr>");
            try {
                require_once 'dbh.inc.php';
                require_once 'attendance_report_model.inc.php';
                $attendanceClass = isset($_SESSION['attendance-class']) ? $_SESSION['attendance-class'] : "";
                $attendanceDate = isset($_SESSION['attendance-date']) ? $_SESSION['attendance-date'] : "";
                $result = get_kehadiran_by_class($conn, $attendanceClass, $attendanceDate);
                if ($result) {
                    foreach ($result as $row) {
                        $dt = new DateTime($row['masa_hadir']);
                        $masa = $dt ->format("H:i:s");
                        $tarikh = $dt ->format("d/m/Y");
                        $tarikhSQL = $dt ->format("Y-m-d");
                        echo("<td>".$row['nama_murid']."</td>");
                        echo("<td data-cell='time'>".$masa."</td>");
                        echo("<td data-cell='date'>".$tarikh."</td>");
                        if ($row['ada_hadir'] == 1) {
                            echo("<td data-cell='attendance'><div><span class='yes'>✔</span><span class='neutral'>X</span></div></td>");
                        } else {
                            echo("<td data-cell='attendance'><div><span class='neutral'>✔</span><span class='no'>X</span></div></td>");
                        }
                        echo("<td data-cell='edit'><form action='edit.php' method='post'><input type='hidden' name='data-to-edit' value=".$row['nama_murid']."#".$tarikhSQL."><input type='submit' value='Edit' class='fake-link'></form></td>");
                }
            }
            } catch (PDOException $e) {
                die("Query failed: " . $e->getMessage());
            }
            echo("</table>");
            echo("<div class='link-wrapper'>");
            echo("<p>Add</p>");
            echo("<a href='url'>More</a>");
            echo("</div>");
        } elseif ( $_SESSION['role'] == "Student"){
            echo("<h2> Murid ".$_SESSION['name']."</h2>");
            echo("<h2>Class: ".$_SESSION['class']."</h2>");
            if ($_SESSION['task'] == "Submit Attendance") {
                echo("<h2>Key in the code teacher gave here</h2>");
                echo("<h2>*This code will record your attendance</h2>");
                echo("<div class='code'>");
                echo("<form action='kod.php' method='post'>");
                echo("<input type='text' maxlength='15' name='code' placeholder='Enter code' required>");
                echo("<input type='submit' id='submitbtn' value='Submit'>");
                echo("</form>");
                echo("</div>");
            } elseif ($_SESSION['task'] == "Attendance Report") {
                echo("<table>");
                echo("<caption>Your Attendance</caption>");
                echo("<tr>");
                echo("<th>Time</th>");
                echo("<th>Date</th>");
                echo("<th>Attendance</th>");
                echo("</tr>");
                echo("<tr>");
                try {
                    require_once 'dbh.inc.php';
                    require_once 'attendance_report_model.inc.php';
                    $result = get_kehadiran($conn, $_SESSION['name']);
                    if ($result) {
                        foreach ($result as $row) {
                            $dt = new DateTime($row['masa_hadir']);
                            $masa = $dt ->format("H:i:s");
                            $tarikh = $dt ->format("d/m/Y");
                            echo("<td data-cell='time'>".$masa."</td>");
                            echo("<td data-cell='date'>".$tarikh."</td>");
                            if ($row['ada_hadir'] == 1) {
                                echo("<td data-cell='attendance'><div><span class='yes'>✔</span><span class='neutral'>X</span></div></td>");
                            } else {
                                echo("<td data-cell='attendance'><div><span class='neutral'>✔</span><span class='no'>X</span></div></td>");
                            }
                        }
                    }
                } catch (PDOException $e) {
                    die("Query failed: " . $e->getMessage());
                }
                echo("</tr>");
                echo("</table>");
            }
        }
    ?>
    <form action="back.php" method="post">
        <input type='submit' id='date-submit' value='Go back'>
    </form>
    <!-- <div class="dropdown">
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
    </div> -->
    <!-- <form action="">
        <label for="date">Date:</label>
        <input type="date" id="date" name="date">
        <input type="submit" id="date-submit" value="Confirm">
    </form> -->
    <!-- <h2>Your Attendance Rate</h2>
        <div class="bar">
            <p>90%</p>
            <span class="percentage-bar"></span>
        </div> -->
        <!-- table | class | time | date | attendance | (Edit) -->
        <!-- <div class="table-container">
            <table>
                <caption>
                    Your Attendance
                </caption>
                <tr> -->
                    <!-- <th>Name</th> -->
                    <!-- <th>Time</th>
                    <th>Date</th>
                    <th>Attendance</th> -->
                    <!-- <th>Attendance Rate</th> -->
                    <!-- <th>Edit</th> -->
                <!-- </tr>
                <tr> -->
                    <!-- <td>John</td> -->
                    <!-- <td data-cell="time">23:59:59</td>
                    <td data-cell="date">24/12/2023</td>
                    <td data-cell="attendance"><div><span class="yes">✔</span><span class="no">X</span></div></td> -->
                    <!-- <td data-cell="attendance rate">80%</td>
                    <td data-cell="edit"><a href="url">Edit</a></td> -->
                <!-- </tr>
                <tr> -->
                    <!-- <td>Baba</td> -->
                    <!-- <td data-cell="time">23:59:59</td>
                    <td data-cell="date">25/12/2023</td>
                    <td data-cell="attendance"><div><span class="yes">✔</span><span class="no">X</span></div></td> -->
                    <!-- <td data-cell="attendance rate">100%</td>
                    <td data-cell="edit"><a href="url">Edit</a></td> -->
                <!-- </tr>
            </table>
    </div> -->
    <!-- <div class="link-wrapper">
        <p>Add</p>
        <a href="url">More</a>
    </div> -->
    <!-- <input type="submit" id="save" value="Save"> -->
</body>
</html>