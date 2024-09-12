<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $role = htmlspecialchars($_POST["role"]);

    if (empty($role)) callBack(false, "sila pilih jawatan");

    try {
        require_once 'dbh.inc.php';
        require_once 'login_model.inc.php';
        require_once 'login_contr.inc.php';
        $_SESSION['role'] = $role;
        if ($role == "Student") {
            $KP = htmlspecialchars($_POST["student_id"]);
            $class = htmlspecialchars($_POST["student_class"]);

            if (is_input_empty_student($KP, $class)) callBack(false, "sila masukkan id dan kelas");
            if (strlen($KP) > 12) callBack(false, "Kad pengenalan mesti mempunyai 12 dan ke bawah digit sahaja");
            $result = get_student($conn, $KP, $class);
            if (is_username_wrong($result)) callBack(false, "id dan kelas tak ada di database");

            $name = get_name_by_id($conn, $KP);
            $_SESSION['name'] = $name['nama_murid'];
            $_SESSION['class'] = $class;
            $_SESSION['kp'] = $KP;
            callBack(true, "login sucess");
        } elseif ($role == "Teacher") {
            $KP_guru = htmlspecialchars($_POST["teacher_id"]);
            $password = htmlspecialchars($_POST["password"]);

            if (is_input_empty($KP_guru, $password)) callBack(false, "sila masukkan id dan kata laluan");
            if (strlen($KP_guru) > 12) callBack(false, "Kad pengenalan mesti mempunyai 12 dan ke bawah digit sahaja");

            $result = get_user($conn, $KP_guru);
            if (is_username_wrong($result)) callBack(false, "id tak ada di database");

            if (!is_username_wrong($result) && is_password_wrong($password, $result['password_guru'])) callBack(false, "kata laluan salah");

            $_SESSION['username'] = $result['nama_guru'];
            $_SESSION['password'] = $password;
            callBack(true, "login berjaya");
        }
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
    callBack(false, "syarat habis");
} else {
    callBack(false, "jangan guna get request, sila guna post request");
}

function callBack($sucess, $message)
{
    $respond = array();
    $respond['success'] = $sucess;
    if (!$sucess) $respond['message'] = $message;

    echo json_encode($respond);
    die();
}
