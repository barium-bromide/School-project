<?php
try {
    require_once 'dbh.inc.php'; //memanggil fail connection
    require_once 'attendance_report_model.inc.php'; // memanggil fail attendance_report_model.inc.php
    //papar paparan Laporan
    echo ("<h2>Cikgu " . $_SESSION['username']);
    echo ("<form action='fetch-student-attendance.php' method='post'>
    <label for='attendance-class'>Pilih kelas anda: </label>
    <select class='dropdown' id='attendance-class' name='attendance-class'>");
    $query = "SELECT nama_kelas FROM kelas";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($result) foreach ($result as $classname)
        echo "<option>" . $classname["nama_kelas"] . "</option>";
    echo ("
    </select><br><label for='attendance-kp'>Kad pengenalan murid: </label>
    <input name='attendance-kp' type='text' maxlength='15' placeholder='Masukkan nombor KP murid'>
    <br><label for='date'>Tarikh: </label>
    <input type='date' id='date' name='attendance-date'><br>
    <input type='submit' id='date-submit' value='Cari'></form>
    <table id='table'>
    <label>Ubah saiz tulisan: </label>
    <input type='button' value='Reset' onclick='changeFontSize(0)'>
    <input type='button' value='+' onclick='changeFontSize(0.25)'>
    <input type='button' value='-' onclick='changeFontSize(-0.25)'>
    <button onclick='window.print()'>Cetak</button>
    <caption>Kehadiran murid</caption>
    <tr><th>KP</th><th>Nama</th><th>Masa</th><th>Tarikh</th><th>Kehadiran</th>");
    if ($_SESSION['task'] == "Rekod kehadiran") echo ("<th>Edit</th>");
    echo ("</tr>");

    $attendanceClass = isset($_SESSION['attendance-class']) ? $_SESSION['attendance-class'] : "";
    $attendanceDate = isset($_SESSION['attendance-date']) ? $_SESSION['attendance-date'] : "";
    $attendanceKP = isset($_SESSION['attendance-kp']) ? $_SESSION['attendance-kp'] : "";
    if ($attendanceDate == "") {
        $result = get_kehadiran_by_class($conn, $attendanceClass);
    } else {
        $result = get_kehadiran_by_class_and_date($conn, $attendanceClass, $attendanceDate);
    }
    $count = 0;
    $total = 0;
    if ($result) {
        foreach ($result as $row) {
            $total++;
            echo ("<tr>");
            $dt = new DateTime($row['masa_hadir']);
            $masa = $dt->format("H:i:s");
            $tarikh = $dt->format("d/m/Y");
            $tarikhSQL = $dt->format("Y-m-d");
            echo ("<td>" . $row['nokp_murid'] . "</td>");
            echo ("<td>" . $row['nama_murid'] . "</td>");
            echo ("<td data-cell='time'>" . $masa . "</td>");
            echo ("<td data-cell='date'>" . $tarikh . "</td>");
            if ($row['ada_hadir'] == 1) {
                $count++;
                echo ("<td data-cell='attendance'><div><span class='yes'>✔</span></div></td>");
            } else {
                echo ("<td data-cell='attendance'><div><span class='no'>X</span></div></td>");
            }
            if ($_SESSION['task'] == "Rekod kehadiran") echo ("<td data-cell='edit'><form action='edit.php' method='post'><input type='hidden' name='data-to-edit' value=" . $row['nokp_murid'] . "#" . $tarikhSQL . "><input type='submit' value='Edit' class='fake-link'></form></td></tr>");
        }
    }
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
echo ("</table>");
if ($_SESSION['task'] != "Rekod kehadiran") {
    echo "<h2>" . $count . " / " . $total . " kehadiran </h2>";
    if ($total != 0) {
        $percentage = $count / $total * 100;
        $percentage_length = strlen($percentage);
        echo "<div class='bar' data-label='$percentage%' style='--percentage: $percentage; --percentage-length: $percentage_length;'><span class='percentage-bar' style='--percentage: $percentage;'></span></div>";
    } else {
        echo "<h2> Tiada kehadiran </h2>";
    };
}
if ($_SESSION['task'] == "Rekod kehadiran") echo ("<div class='link-wrapper'><p>Tambah</p><a href='more.php'>Lagi</a></div><a href='upload.php'>Muat Naik Data Ahli</a></div>");
