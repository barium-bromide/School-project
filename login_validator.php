<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $role = htmlspecialchars($_POST["role"]);

    if (empty($role)) {
        callBack(false, "empty role");
    }

    $_SESSION['role'] = $role;
    if ($role == "Student") {
        $id = htmlspecialchars($_POST["student_id"]);
        $class = htmlspecialchars($_POST["student_class"]);
        try {
            require_once 'dbh.inc.php';
            require_once 'login_model.inc.php';
            require_once 'login_contr.inc.php';

            if (is_input_empty_student($id, $class)) {
                callBack(false, "empty name or class");
            }

            $result = get_student($conn, $id, $class);
            if (is_username_wrong($result)) {
                callBack(false, "name or class not found");
            }

            $_SESSION['name'] = $id;
            $_SESSION['class'] = $class;
            callBack(true, "login sucess");
        } catch (PDOException $e) {
            callBack(false, "Query failed: " . $e->getMessage());
        }
    } elseif ($role == "Teacher") {
        $username = htmlspecialchars($_POST["username"]);
        $password = htmlspecialchars($_POST["password"]);
        try {
            require_once 'dbh.inc.php';
            require_once 'login_model.inc.php';
            require_once 'login_contr.inc.php';

            if (is_input_empty($username, $password)) {
                callBack(false, "empty username or password");
            }

            $result = get_user($conn, $username);
            if (is_username_wrong($result)) {
                callBack(false, "username not found");
            }
            if (!is_username_wrong($result) && is_password_wrong($password, $result['password_guru'])) {
                callBack(false, "wrong password");
            }

            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            callBack(true, "login sucess");
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
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
