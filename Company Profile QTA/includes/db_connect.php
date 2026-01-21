<?php
$servername = "localhost";
$username = "root"; 
$password = "user"; // Di Laragon, biarkan kosong kecuali Anda pernah mengubahnya
$database = "bimbelqta"; // Sesuai dengan screenshot phpMyAdmin Anda

// Membuat koneksi dengan error reporting yang lebih baik
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($servername, $username, $password, $database);
    $conn->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>