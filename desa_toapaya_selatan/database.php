<?php
$servername = "localhost";  // Ubah jika menggunakan host lain
$username = "root";  // Username database (misalnya root jika di localhost)
$password = "";  // Password database Anda (biarkan kosong jika tidak ada password)
$dbname = "login_system";  // Nama database Anda

// Koneksi ke database
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Cek koneksi
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
