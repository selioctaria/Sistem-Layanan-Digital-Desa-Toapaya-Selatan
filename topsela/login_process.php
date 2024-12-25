<?php
include 'database.php';  // Pastikan file koneksi database sudah dimasukkan

// Ambil data dari form login
$email = $_POST['email'];
$password = $_POST['password'];

// Query untuk memeriksa apakah email dan password cocok
$sql = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
$result = mysqli_query($conn, $sql);

// Cek apakah ada user yang ditemukan
if (mysqli_num_rows($result) > 0) {
    // Login berhasil
    session_start();  // Mulai sesi
    $_SESSION['email'] = $email;  // Simpan email pengguna dalam session
    header("Location:dashboard.php");  // Arahkan ke halaman dashboard
    exit();
} else {
    // Login gagal
    echo "<script>alert('Login gagal! Email atau password salah.'); window.location.href = 'index.html';</script>";
}
?>
