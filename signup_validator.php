<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = htmlspecialchars($_POST["role"]);

    if (empty($role)) callBack(false, "empty role");

    try {
        require_once 'dbh.inc.php';
        require_once 'signup_model.inc.php';
        require_once 'signup_contr.inc.php';
        $_SESSION['role'] = $role;
        if ($role == "Student") {
            $student_name = htmlspecialchars($_POST["student_name"]);
            $class = htmlspecialchars($_POST["student_class"]);

            if (is_input_empty_student($student_name, $class)) callBack(false, "empty name or class");
            if (!is_class_exist($conn, $class)) callBack(false, "class not exist");
            create_student($conn, $student_name, $class);
            callBack(true, "login sucess");
        } elseif ($role == "Teacher") {
            $teacher_name = htmlspecialchars($_POST["teacher_name"]);
            $password = htmlspecialchars($_POST["password"]);

            if (is_input_empty($teacher_name, $password)) callBack(false, "empty id or password");
            create_teacher($conn, $teacher_name, $password);
            callBack(true, "login sucess");
        }
    } catch (PDOException $e) {
        callBack(false, "Query failed: " . $e->getMessage());
    }
    callBack(false, "end of condition");
} else {
    callBack(false, "not allowed?(not post)");
}

function callBack($sucess, $message)
{
    $respond = array();
    $respond['success'] = $sucess;
    if (!$sucess) $respond['message'] = $message;

    echo json_encode($respond);
    die();
}
