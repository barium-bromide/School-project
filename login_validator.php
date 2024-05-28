<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $role = htmlspecialchars($_POST["role"]);

    if (empty($role)) {
        header("Location: index.php");
        die();
    }

    $_SESSION['role'] = $role;
    if ($role == "Student") {
        $name = htmlspecialchars($_POST["student_name"]);
        $class = htmlspecialchars($_POST["student_class"]);
        if (empty($name) || empty($class)) {
            header("Location: index.php");
            die();
        }
        $_SESSION['name'] = $name;
        $_SESSION['class'] = $class;
        header("Location: studentpick.php");
        die();
    } elseif ($role == "Teacher") {
        $username = htmlspecialchars($_POST["username"]);
        $password = htmlspecialchars($_POST["password"]);
        if (empty($username) || empty($password)) {
            header("Location: index.php");
            die();
        }
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        header("Location: studentpick.php");
        die();
    }
    header("Location: index.php");
} else {
    header("Location: index.php");
}