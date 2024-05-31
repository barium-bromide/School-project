<?php

declare(strict_types=1);

function get_user(object $pdo, string $username)
{
    $query = "SELECT * FROM guru WHERE nama_guru = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
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
