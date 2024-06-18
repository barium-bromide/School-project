<?php

declare(strict_types=1);

function get_class(object $pdo, string $class)
{
    $query = "SELECT COUNT(*) FROM kelas WHERE nama_kelas = :class";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':class' => $class]);
    $count = $stmt->fetchColumn();
    return $count;
}

function set_student(object $pdo, string $name, string $class)
{
    $query = "INSERT INTO murid (nama_murid, id_kelas) VALUES (:name, (SELECT id_kelas FROM kelas WHERE nama_kelas = :class))";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':class', $class);
    $stmt->execute();
}

function set_teacher(object $pdo, string $name, string $password)
{
    $query = "INSERT INTO guru (nama_guru, password_guru, id_kelas) VALUES (:name, :password, 1)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
}
