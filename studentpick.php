<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kehadiran | Pilih kotak</title>
    <link rel="stylesheet" href="public/style/attend.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
</head>

<body>
    <?php
    if ($_SESSION['role'] == "Teacher") {
        echo ("<h1>Selamat sejahtera, Cikgu " . $_SESSION['username'] . "</h1>");
    } else {
        echo ("<h1>Selamat sejahtera, Murid " . $_SESSION['name'] . "</h1>");
    }
    ?>
    <h2>Pilih satu kotak</h2>
    <div>
        <div class="container">
            <form action="subject.php" method="post" class="radio-tile-group">
                <div class="input-container">
                    <input type="submit" value="Laporan kehadiran" name="report" class='radio-tile'>
                </div>

                <div class="input-container">
                    <?php
                    if ($_SESSION['role'] == "Teacher") {
                        echo ("<input type='submit' value='Rekod kehadiran' name='record' class='radio-tile'>");
                    } elseif ($_SESSION['role'] == "Student") {
                        echo ("<input type='submit' value='Hantar kehadiran' name='submit' class='radio-tile'>");
                    }
                    ?>
                </div>
            </form>
            <form action="logout.php" method="post" class="radio-tile-group">
                <div class="input-container">
                    <input type="submit" value="Daftar keluar" name="logout" class='radio-tile'>
                </div>
            </form>
        </div>
    </div>
</body>