<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Form | Edit</title>
    <link rel="stylesheet" href="public/style/login.css">
    <script src="public/js/login.js" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <div class="center">
        <form action="subject.php" method="post" class="loginbox">
            <h1>Edit</h1>
            <?php
            if (isset($_POST['data-to-edit'])) {
                $dataToEdit = htmlspecialchars($_POST['data-to-edit']);
                $_SESSION['data-to-edit'] = $dataToEdit;
            }
            if (empty($_SESSION['data-to-edit'])) {
                header("Location: studentpick.php");
                die();
            }
            ?>
            <div id="teacher-form">
                <h2>Attendance</h2>
                <?php
                 echo "<input name='data-to-sql' type='hidden' value=".$_SESSION['data-to-edit'].">"
                ?>
                <input id="username" name="edit" type="text" maxlength="3" placeholder="Key in yes or no" required>
            </div>
            <input type="submit" id="loginbtn" value="Save">
        </form>
    </div>
</body>