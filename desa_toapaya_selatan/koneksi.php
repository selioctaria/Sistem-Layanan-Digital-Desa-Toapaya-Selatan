<?php
// Konfigurasi database
$host = 'localhost';
$dbname = 'desa_toapaya_selatan'; // Nama database
$username = 'root';               // Username database Anda
$password = '';                   // Password database Anda

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
?>
