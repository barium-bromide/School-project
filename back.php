<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    unset($_SESSION['task']);
    header("Location: pickbox.php");
    die();
}
