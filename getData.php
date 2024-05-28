<?php
    include 'dbh.inc.php';
    $query = "SELECT DISTINCT nama_kelas FROM kelas";
    $result = $conn->execute_query($query);
    $kelasArray = array();

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $kelasArray[] = $row['nama_kelas'];
        }
    }

    echo json_encode($kelasArray);
?>