<?php
#memulakan fungsi session
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muat Naik</title>
</head>

<body>
    <!-- Tajuk laman -->
    <h1>Muat Naik Data Ahli (*.txt)</h1>
    <!-- Borang untuk memuat naik fail  -->
    <form action='' method='post' enctype='multipart/form-data'>
        <h2>Sila Pilih Fail txt yang ingin diupload</h2>
        <h2>Sila mengikut format ini</h2>
        <h2>(nombor KP murid)|(masa hadir)|(ada hadir)</h2>
        <input type='file' name='file' required>
        <input type='submit' name='submit' value='Muat Naik'>
    </form>
    <a href='main.php'>Kembali</a>
    <!-- bahagian memproses data yang dimuat naik -->
    <?php
    if (isset($_POST['submit'])) {
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
        try {
            #memanggil fail connection dan attendance_report_model.inc.php
            include 'dbh.inc.php';
            include 'attendance_report_model.inc.php';
            if ($_FILES['file']['size'] > 0 and $fileType == "txt") {
                $file = fopen($fileTmpName, "r");
                while (!feof($file)) {
                    $line = fgets($file);
                    $data = explode("|", $line);
                    $id = $data[0];
                    $attendanceTime = $data[1];
                    $attendance = $data[2];
                    $attendanceDate = substr($attendanceTime, 0, 10);
                    $result = get_kehadiran_with_date($conn, $id, $attendanceDate);
                    foreach ($result as $row) {
                        echo $row;
                    }
                    if ($result) {
                        edit_kehadiran_by_id_and_date($conn, $id, $attendanceDate, $attendance);
                    } else {
                        insert_kehadiran_of_added($conn, $id, $attendanceTime, $attendance);
                    }
                }
                fclose($file);
                echo ("<script>alert('import fail data selesai');window.location.href='main.php';</script>");
            } else {
                echo "<script>alert('Fail tidak berjaya dimuat naik. Sila muat naik fail txt sahaja')</script>";
            }
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }
    ?>
</body>

</html>

<style>
    body {
        background-color: #1E2B35;
        color: #07afd9;
    }

    a {
        color: rgb(0, 110, 255);

        &:hover {
            color: rgb(0, 160, 255);
        }

        &:focus {
            outline: none;
        }
    }
</style>