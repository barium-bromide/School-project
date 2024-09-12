<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = htmlspecialchars($_POST["role"]);
    $KP = htmlspecialchars($_POST["KP"]);

    if (empty($role)) callBack(false, "empty role");
    if (empty($KP)) callBack(false, "sila masukkan kad pengenalan");
    if (strlen($KP) > 12) callBack(false, "kad pengenalan mesti mempunyai 12 dan ke bawah digit sahaja");

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
            create_student($conn, $student_name, $class, $KP);
            $_SESSION['name'] = $student_name;
            $_SESSION['class'] = $class;
            $_SESSION['kp'] = $KP;
            callBack(true, "login berjaya");
        } elseif ($role == "Teacher") {
            $teacher_name = htmlspecialchars($_POST["teacher_name"]);
            $password = htmlspecialchars($_POST["password"]);

            if (is_input_empty($teacher_name, $password)) callBack(false, "sila masukkan kelas dan kata laluan");
            create_teacher($conn, $teacher_name, $password, $KP);
            $_SESSION['username'] = $teacher_name;
            $_SESSION['password'] = $password;
            callBack(true, "login berjaya");
        }
    } catch (PDOException $e) {
        callBack(false, "Query failed: " . $e->getMessage());
    }
    callBack(false, "syarat habis");
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
