<?php

declare(strict_types=1);

function get_user(object $pdo, string $id_guru)
{
    $query = "SELECT * FROM guru WHERE nokp_guru = :id_guru";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_guru', $id_guru);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function get_student(object $pdo, string $id, string $class)
{
    $query = "SELECT * FROM murid WHERE nokp_murid = :id AND id_kelas = (SELECT id_kelas FROM kelas WHERE nama_kelas = :class)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':class', $class);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function get_name_by_id(object $pdo, string $id)
{
    $query = "SELECT nama_murid FROM murid WHERE nokp_murid = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}
