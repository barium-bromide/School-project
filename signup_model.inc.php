<?php

declare(strict_types=1);

function get_kelas(object $pdo, string $class)
{
    $query = "SELECT COUNT(*) FROM kelas WHERE nama_kelas = :class";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':class' => $class]);
    $count = $stmt->fetchColumn();
    return $count;
}

function set_student(object $pdo, string $name, string $class, string $KP)
{
    $query = "INSERT INTO murid (nokp_murid, nama_murid, id_kelas) VALUES (:kp, :name, (SELECT id_kelas FROM kelas WHERE nama_kelas = :class))";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':kp', $KP);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':class', $class);
    $stmt->execute();
}

function set_teacher(object $pdo, string $name, string $password, string $KP)
{
    $query = "INSERT INTO guru (nokp_guru, nama_guru, password_guru, id_kelas) VALUES (:kp, :name, :password, 3)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':kp', $KP);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
}

function get_id_by_name(object $pdo, string $name)
{
    $query = "SELECT id_murid FROM murid WHERE nama_murid = :name";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}
