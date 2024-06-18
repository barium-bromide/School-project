<?php

declare(strict_types=1);

function is_input_empty(string $username, string $pwd)
{
    if (empty($username) || empty($pwd)) {
        return true;
    } else {
        return false;
    }
}

function is_input_empty_student(string $name, string $class)
{
    if (empty($name) || empty($class)) {
        return true;
    } else {
        return false;
    }
}

function is_class_exist(object $pdo, string $class)
{
    $result = get_class($pdo, $class);
    if ($result == 0) {
        return false;
    } else {
        return true;
    }
}

function create_student(object $pdo, string $name, string $class)
{
    set_student($pdo, $name, $class);
}

function create_teacher(object $pdo, string $name, string $password)
{
    set_teacher($pdo, $name, $password);
}
