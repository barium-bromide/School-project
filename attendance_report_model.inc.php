<?php

declare(strict_types=1);

function get_kehadiran(object $pdo, string $name) {
    $query = "SELECT * FROM kehadiran WHERE id_murid = (SELECT id_murid FROM murid WHERE nama_murid = :name)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function get_kehadiran_by_class(object $pdo, string $class, string $date) {
    //get kehadiran of all students in a class base on date but not time
    $query = "SELECT murid.nama_murid, kehadiran.masa_hadir, kehadiran.ada_hadir FROM kehadiran JOIN murid ON kehadiran.id_murid = murid.id_murid JOIN kelas ON murid.id_kelas = kelas.id_kelas WHERE kelas.nama_kelas = :class AND DATE(kehadiran.masa_hadir) = :date";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':class', $class);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}