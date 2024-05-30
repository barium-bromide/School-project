<?php
session_start();

function insert_kehadiran($pdo,$name) {
        $query = "INSERT INTO kehadiran (id_murid, masa_hadir, ada_hadir) VALUES ((SELECT id_murid FROM murid WHERE nama_murid = :nama), NOW(), 1)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':nama', $name);
        $stmt->execute();
}

function generate_code() {
    $code = "";
    for ($i = 0; $i < 6; $i++) {
        $code .= rand(0, 9);
    }

    return $code;
}

function get_code($pdo) {
        $query = "SELECT * FROM kod";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $last_update = strtotime($result['last_update']);
            $current_time = time();
            $diff = $current_time - $last_update;
            if ($diff > 86400) {
                $code = generate_code();
                $query = "UPDATE kod SET kod = :code, last_update = NOW()";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':code', $code);
                $stmt->execute();
                return $code;
            } else {
                return $result['kod'];
            }
        } else {
            $code = generate_code();
            $query = "INSERT INTO kod (kod) VALUES (:code)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':code', $code);
            $stmt->execute();
            return $code;
        }
}

$code = htmlspecialchars($_POST["code"]);

if (empty($code)) {
    die("empty code");
}
if ($_SESSION['role'] != "Student") {
    die("you are not a student");
}
if (!isset($_SESSION['name']) || !isset($_SESSION['class'])) {
    die("name and class not set");
}
try {
    require_once 'dbh.inc.php';
    if (!($code == get_code($conn))) {
        die("wrong code");
    }
    insert_kehadiran($conn,$_SESSION['name']);
    header("Location: studentpick.php");
    die();
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>