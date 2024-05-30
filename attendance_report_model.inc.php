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

function get_kehadiran_by_class(object $pdo, string $class) {
    $query = "SELECT murid.nama_murid, kehadiran.ada_hadir, kehadiran.masa_hadir FROM murid JOIN kelas ON murid.id_kelas = kelas.id_kelas JOIN kehadiran ON murid.id_murid = kehadiran.id_murid WHERE kelas.nama_kelas = :class";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':class', $class);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}