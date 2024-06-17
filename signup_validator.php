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

            $result = get_student($conn, $student_name, $class);
            if (is_username_wrong($result)) callBack(false, "name or class not found");

            $name = get_name_by_id($conn, $student_name);
            $_SESSION['name'] = $name['nama_murid'];
            $_SESSION['class'] = $class;
            $_SESSION['id'] = $student_name;
            callBack(true, "login sucess");
        } elseif ($role == "Teacher") {
            $teacher_name = htmlspecialchars($_POST["teacher_name"]);
            $password = htmlspecialchars($_POST["password"]);

            if (is_input_empty($teacher_name, $password)) callBack(false, "empty id or password");

            $result = get_user($conn, $teacher_name);
            if (is_username_wrong($result)) callBack(false, "id not found");

            if (!is_username_wrong($result) && is_password_wrong($password, $result['password_guru'])) callBack(false, "wrong password");

            $_SESSION['username'] = $result['nama_guru'];
            $_SESSION['password'] = $password;
            callBack(true, "login sucess");
        }
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
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
