<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $role = htmlspecialchars($_POST["role"]);

    if (empty($role)) {
        callBack(false, "empty role");
    }

    $_SESSION['role'] = $role;
    if ($role == "Student") {
        $name = htmlspecialchars($_POST["student_name"]);
        $class = htmlspecialchars($_POST["student_class"]);
        if (empty($name) || empty($class)) {
            callBack(false, "empty name or class");
        }
        $_SESSION['name'] = $name;
        $_SESSION['class'] = $class;
        callBack(true, "login sucess");
    } elseif ($role == "Teacher") {
        $username = htmlspecialchars($_POST["username"]);
        $password = htmlspecialchars($_POST["password"]);
        if (empty($username) || empty($password)) {
            callBack(false, "empty username or password");
        }
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        callBack(true, "login sucess");
    }
    callBack(false, "end of condition");
} else {
    callBack(false, "not allowed?(not post)");
}

function callBack($sucess, $message)
{
    $respond = array();
    $respond['success'] = $sucess;
    if (!$sucess) {
        $respond['message'] = $message;
    }
    echo json_encode($respond);
    die();
}
