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

function is_username_wrong(bool | array $result)
{
    if (!$result) {
        return true;
    }
    return false;
}

function is_password_wrong(string $pwd, string $db_pwd)
{
    if (!($pwd == $db_pwd)) {
        return true;
    }
    return false;
}
