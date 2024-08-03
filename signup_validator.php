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

            if (is_input_empty_student($student_name, $class)) callBack(false, "sila masukkan kelas dan nama");
            if (!is_class_exist($conn, $class)) callBack(false, "kelas tak ada di database");
            create_student($conn, $student_name, $class);
            $_SESSION['name'] = $student_name;
            $_SESSION['class'] = $class;
            $id = get_id_by_name($conn, $student_name);
            $_SESSION['id'] = $id['id_murid'];
            callBack(true, "login berjaya");
        } elseif ($role == "Teacher") {
            $teacher_name = htmlspecialchars($_POST["teacher_name"]);
            $password = htmlspecialchars($_POST["password"]);

            if (is_input_empty($teacher_name, $password)) callBack(false, "sila masukkan kelas dan kata laluan");
            create_teacher($conn, $teacher_name, $password);
            $_SESSION['username'] = $teacher_name;
            $_SESSION['password'] = $password;
            callBack(true, "login berjaya");
        }
    } catch (PDOException $e) {
        callBack(false, "Query failed: " . $e->getMessage());
    }
    callBack(false, "syarat habsi");
} else {
    callBack(false, "jangan mengguna get request, sila mengguna post request");
}

function callBack($sucess, $message)
{
    $respond = array();
    $respond['success'] = $sucess;
    if (!$sucess) $respond['message'] = $message;

    echo json_encode($respond);
    die();
}
