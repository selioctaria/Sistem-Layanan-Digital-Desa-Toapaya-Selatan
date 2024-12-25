<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "desa_toapaya_selatan";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}
?>
