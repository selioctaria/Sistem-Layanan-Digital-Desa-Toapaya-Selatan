<?php
require 'koneksi.php';
$fullname = $_POST["nama_lengkap"];
$no_kk = $_POST["nomor_kartu_keluarga"];
$nik = $_POST["nik_ktp"];
$no_telp = $_POST["nomor_telepon"];
$email = $_POST["email"];
$password = $_POST["password"];

$query = "INSERT INTO tbl_users (nama_lengkap, nomor_kartu_keluarga, nik_ktp, nomor_telepon, email, password)
VALUES ('$fullname','$no_kk','$nik','$no_telp','$email','$password')";

if (mysqli_query($conn, $query_sql)) {
    header("Location: index.html");
} else {
    echo "Pendaftaran Gagal : " .mysqli_eror($conn);
}
