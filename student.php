<?php
echo ("<h2> Murid " . $_SESSION['name'] . "</h2>");
echo ("<h2>Kelas: " . $_SESSION['class'] . "</h2>");
if ($_SESSION['task'] == "Hantar kehadiran") {
    echo ("<h2>Masuk kod diberikan oleh guru kepada anda</h2><h2>*Kod ini akan merekodkan kehadiran anda</h2><div class='code'><form action='kod.php' method='post'><input type='text' maxlength='15' name='code' placeholder='Enter code' required><input type='submit' id='submitbtn' value='Submit'></form></div>");
} elseif ($_SESSION['task'] == "Laporan kehadiran") {
    echo ("<table><caption>Kehadiran anda</caption><tr><th>Masa</th><th>Tarikh</th><th>Kehadiran</th></tr>");
    try {
        require_once 'dbh.inc.php';
        require_once 'attendance_report_model.inc.php';
        $result = get_kehadiran($conn, $_SESSION['kp']);
        $count = 0;
        $total = 0;
        if ($result) {
            foreach ($result as $row) {
                $total++;
                echo ("<tr>");
                $dt = new DateTime($row['masa_hadir']);
                $masa = $dt->format("H:i:s");
                $tarikh = $dt->format("d/m/Y");
                echo ("<td data-cell='time'>" . $masa . "</td><td data-cell='date'>" . $tarikh . "</td>");
                if ($row['ada_hadir'] == 1) {
                    $count++;
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
    echo "<h2>" . $count . " / " . $total . " kehadiran </h2>";
    if ($total != 0) {
        echo "<h2>" . ($count / $total) * 100 . "% kehadiran</h2>";
    } else {
        echo "<h2> Tiada kehadiran </h2>";
    };
}
