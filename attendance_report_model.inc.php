<?php

declare(strict_types=1);

function get_kehadiran(object $pdo, int $id)
{
    $query = "SELECT * FROM kehadiran WHERE id_murid = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function get_kehadiran_by_class_and_date(object $pdo, string $class, string $date)
{
    $query = "SELECT murid.nama_murid, murid.id_murid, kehadiran.masa_hadir, kehadiran.ada_hadir FROM kehadiran JOIN murid ON kehadiran.id_murid = murid.id_murid JOIN kelas ON murid.id_kelas = kelas.id_kelas WHERE kelas.nama_kelas = :class AND DATE(kehadiran.masa_hadir) = :date";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':class', $class);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function get_kehadiran_by_class(object $pdo, string $class)
{
    $query = "SELECT murid.nama_murid, murid.id_murid, kehadiran.masa_hadir, kehadiran.ada_hadir FROM kehadiran JOIN murid ON kehadiran.id_murid = murid.id_murid JOIN kelas ON murid.id_kelas = kelas.id_kelas WHERE kelas.nama_kelas = :class";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':class', $class);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function get_kehadiran_by_class_and_id(object $pdo, string $class, int $id, string $date)
{
    $query = "SELECT murid.id_murid, kehadiran.masa_hadir, kehadiran.ada_hadir FROM kehadiran JOIN murid ON kehadiran.id_murid = murid.id_murid JOIN kelas ON murid.id_kelas = kelas.id_kelas WHERE kelas.nama_kelas = :class AND murid.id_murid = :id AND DATE(kehadiran.masa_hadir) = :date";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':class', $class);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function edit_kehadiran_by_id_and_date(object $pdo, int $id, string $date, int $attendance)
{
    $query = "UPDATE kehadiran SET ada_hadir = :attendance WHERE id_murid = :id AND DATE(masa_hadir) = :date";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':attendance', $attendance, PDO::PARAM_INT);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
}

function get_student(object $pdo, int $id, string $class)
{
    $query = "SELECT kelas.nama_kelas, murid.id_murid FROM murid JOIN kelas ON murid.id_kelas = kelas.id_kelas WHERE murid.id_murid = :id AND kelas.nama_kelas = :class";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':class', $class);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function insert_kehadiran_of_added(object $pdo, int $id, string $date, int $attendance)
{
    $query = "INSERT INTO kehadiran (id_murid, masa_hadir, ada_hadir) VALUES (:id, :date, :attendance)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':attendance', $attendance, PDO::PARAM_INT);
    $stmt->execute();
}
