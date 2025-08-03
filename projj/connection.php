<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'root';  

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Σφάλμα σύνδεσης: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");
?>