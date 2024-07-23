<?php
try {
    require_once 'dbh.inc.php';
    require_once 'kod.php';
    $code = get_code($conn);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kehadiran | Ambil kod</title>
    <link rel="stylesheet" href="public/style/login.css">
</head>

<body>
    <div class="center loginbox">

        <?php echo ("<h1>Kod ialah $code</h1>"); ?>
        <form action="back.php" method="post">
            <input type='submit' id='date-submit' value='Kembali'>
        </form>
    </div>
</body>

</html>