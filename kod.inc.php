<?php
function generate_code()
{
    $code = "";
    for ($i = 0; $i < 6; $i++) {
        $code .= rand(0, 9);
    }

    return $code;
}

function get_code() {
    try {
        require_once 'dbh.inc.php';
        $query = "SELECT * FROM kod";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $last_update = strtotime($result['last_update']);
            $current_time = time();
            $diff = $current_time - $last_update;
            if ($diff > 86400) {
                $code = generate_code();
                $query = "UPDATE kod SET kod = :code, last_update = NOW()";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':code', $code);
                $stmt->execute();
                return $code;
            } else {
                return $result['kod'];
            }
        } else {
            $code = generate_code();
            $query = "INSERT INTO kod (kod) VALUES (:code)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':code', $code);
            $stmt->execute();
            return $code;
        }
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
}
?>