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
        try {
            require_once 'dbh.inc.php';
            require_once 'attendance_report_model.inc.php';
            echo ("<h2>Cikgu " . $_SESSION['username']);
            echo ("<form action='fetch-student-attendance.php' method='post'><label for='attendance-class'>Pilih kelas anda: </label><select class='dropdown' id='attendance-class' name='attendance-class'>");
            $query = "SELECT nama_kelas FROM kelas";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($result) foreach ($result as $classname) echo "<option>" . $classname["nama_kelas"] . "</option>";

            echo ("</select><br><label for='date'>Tarikh: </label><input type='date' id='date' name='attendance-date'><br><input type='submit' id='date-submit' value='Cari'></form><table id='table'>
            <label>Ubah saiz tulisan: </label>
            <input type='button' value='Reset' onclick='changeFontSize(0)'>
            <input type='button' value='+' onclick='changeFontSize(0.25)'>
            <input type='button' value='-' onclick='changeFontSize(-0.25)'>
            <button onclick='window.print()'>Cetak</button>
            <caption>Kehadiran murid</caption>
            <tr><th>Id</th><th>Nama</th><th>Masa</th><th>Tarikh</th><th>Kehadiran</th>");
            if ($_SESSION['task'] == "Rekod kehadiran") echo ("<th>Edit</th>");
            echo ("</tr>");

            $attendanceClass = isset($_SESSION['attendance-class']) ? $_SESSION['attendance-class'] : "";
            $attendanceDate = isset($_SESSION['attendance-date']) ? $_SESSION['attendance-date'] : "";
            if ($attendanceDate == "") {
                $result = get_kehadiran_by_class($conn, $attendanceClass);
            } else {
                $result = get_kehadiran_by_class_and_date($conn, $attendanceClass, $attendanceDate);
            }
            if ($result) {
                foreach ($result as $row) {
                    echo ("<tr>");
                    $dt = new DateTime($row['masa_hadir']);
                    $masa = $dt->format("H:i:s");
                    $tarikh = $dt->format("d/m/Y");
                    $tarikhSQL = $dt->format("Y-m-d");
                    echo ("<td>" . $row['id_murid'] . "</td>");
                    echo ("<td>" . $row['nama_murid'] . "</td>");
                    echo ("<td data-cell='time'>" . $masa . "</td>");
                    echo ("<td data-cell='date'>" . $tarikh . "</td>");
                    if ($row['ada_hadir'] == 1) {
                        echo ("<td data-cell='attendance'><div><span class='yes'>✔</span><span class='neutral'>X</span></div></td>");
                    } else {
                        echo ("<td data-cell='attendance'><div><span class='neutral'>✔</span><span class='no'>X</span></div></td>");
                    }
                    if ($_SESSION['task'] == "Rekod kehadiran") echo ("<td data-cell='edit'><form action='edit.php' method='post'><input type='hidden' name='data-to-edit' value=" . $row['id_murid'] . "#" . $tarikhSQL . "><input type='submit' value='Edit' class='fake-link'></form></td></tr>");
                }
            }
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
        echo ("</table><div class='link-wrapper'>");
        if ($_SESSION['task'] == "Rekod kehadiran") {
            echo ("<p>Tambah</p><a href='more.php'>Lagi</a></div><a href='upload.php'>Muat Naik Data Ahli</a>");
        } else {
            echo ("</div>");
        }
    } elseif ($_SESSION['role'] == "Student") {
        echo ("<h2> Murid " . $_SESSION['name'] . "</h2>");
        echo ("<h2>Kelas: " . $_SESSION['class'] . "</h2>");
        if ($_SESSION['task'] == "Hantar kehadiran") {
            echo ("<h2>Masuk kod diberikan oleh guru kepada anda</h2><h2>*Kod ini akan merekodkan kehadiran anda</h2><div class='code'><form action='kod.php' method='post'><input type='text' maxlength='15' name='code' placeholder='Enter code' required><input type='submit' id='submitbtn' value='Submit'></form></div>");
        } elseif ($_SESSION['task'] == "Laporan kehadiran") {
            echo ("<table><caption>Kehadiran anda</caption><tr><th>Masa</th><th>Tarikh</th><th>Kehadiran</th></tr>");
            try {
                require_once 'dbh.inc.php';
                require_once 'attendance_report_model.inc.php';
                $result = get_kehadiran($conn, $_SESSION['id']);
                if ($result) {
                    foreach ($result as $row) {
                        echo ("<tr>");
                        $dt = new DateTime($row['masa_hadir']);
                        $masa = $dt->format("H:i:s");
                        $tarikh = $dt->format("d/m/Y");
                        echo ("<td data-cell='time'>" . $masa . "</td><td data-cell='date'>" . $tarikh . "</td>");
                        if ($row['ada_hadir'] == 1) {
                            echo ("<td data-cell='attendance'><div><span class='yes'>✔</span><span class='neutral'>X</span></div></td>");
                        } else {
                            echo ("<td data-cell='attendance'><div><span class='neutral'>✔</span><span class='no'>X</span></div></td>");
                        }
                        echo ("</tr>");
                    }
                }
            } catch (PDOException $e) {
                die("Query failed: " . $e->getMessage());
            }
            echo ("</table>");
        }
    }
    ?>
    <form action="back.php" method="post">
        <input type='submit' id='date-submit' value='Pulang'>
    </form>
</body>

</html>