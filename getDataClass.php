<?php
    include 'dbh.inc.php';
    $query = "SELECT DISTINCT nama_kelas FROM kelas";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($result);
?>