<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kehadiran | Tambah lagi</title>
    <link rel="stylesheet" href="public/style/login.css">
    <script src="public/js/login.js" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <div class="center">
        <form action="main.php" method="post" class="loginbox">
            <h1>Tambah lagi</h1>
            <div id="teacher-form">
                <h2>ID Murid</h2>
                <input id="username" name="more-name" type="text" maxlength="15" placeholder="Masukkan nama murid" required>
                <h2>Kelas Murid</h2>
                <input id="username" name="more-class" type="text" maxlength="15" placeholder="Masukkan kelas murid" required>
                <h2>Masa kehadiran murid</h2>
                <input type='datetime-local' id='date' name='more-attendance-time'>
                <h2>Kehadiran murid</h2>
                <input id="username" name="more-attendance" type="text" maxlength="5" placeholder="Hantar ya atau tidak" required>
            </div>
            <input type="submit" id="loginbtn" value="Hantar">
        </form>
        <a href='main.php'>Kembali</a>
    </div>
</body>