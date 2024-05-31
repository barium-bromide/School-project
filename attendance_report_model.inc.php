<?php

declare(strict_types=1);

function get_kehadiran(object $pdo, string $name)
{
    $query = "SELECT * FROM kehadiran WHERE id_murid = (SELECT id_murid FROM murid WHERE nama_murid = :name)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function get_kehadiran_by_class(object $pdo, string $class, string $date)
{
    $query = "SELECT murid.nama_murid, kehadiran.masa_hadir, kehadiran.ada_hadir FROM kehadiran JOIN murid ON kehadiran.id_murid = murid.id_murid JOIN kelas ON murid.id_kelas = kelas.id_kelas WHERE kelas.nama_kelas = :class AND DATE(kehadiran.masa_hadir) = :date";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':class', $class);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function get_kehadiran_by_class_and_name(object $pdo, string $class, string $name, string $date)
{
    $query = "SELECT murid.nama_murid, kehadiran.masa_hadir, kehadiran.ada_hadir FROM kehadiran JOIN murid ON kehadiran.id_murid = murid.id_murid JOIN kelas ON murid.id_kelas = kelas.id_kelas WHERE kelas.nama_kelas = :class AND murid.nama_murid = :name AND DATE(kehadiran.masa_hadir) = :date";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':class', $class);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function edit_kehadiran_by_name_and_date(object $pdo, string $name, string $date, int $attendance)
{
    $query = "UPDATE kehadiran SET ada_hadir = :attendance WHERE id_murid = (SELECT id_murid FROM murid WHERE nama_murid = :name) AND DATE(masa_hadir) = :date";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':attendance', $attendance, PDO::PARAM_INT);
    $stmt->execute();
}

function get_student(object $pdo, string $name, string $class)
{
    $query = "SELECT kelas.nama_kelas, murid.nama_murid FROM murid JOIN kelas ON murid.id_kelas = kelas.id_kelas WHERE murid.nama_murid = :name AND kelas.nama_kelas = :class";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':class', $class);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function insert_kehadiran_of_added(object $pdo, string $name, string $date, int $attendance)
{
    $query = "INSERT INTO kehadiran (id_murid, masa_hadir, ada_hadir) VALUES ((SELECT id_murid FROM murid WHERE nama_murid = :name), :date, :attendance)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':attendance', $attendance, PDO::PARAM_INT);
    $stmt->execute();
}
