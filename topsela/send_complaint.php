<?php
session_start();
include('database.php');

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $complaint_text = $_POST['complaint_text'];

    // Simpan pengaduan ke database
    $sql = "INSERT INTO complaints (email, complaint_text) VALUES ('$email', '$complaint_text')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Pengaduan berhasil dikirim!'); window.location.href = 'index.html';</script>";
    } else {
        echo "<script>alert('Gagal mengirim pengaduan!'); window.location.href = 'index.html';</script>";
    }
} else {
    echo "<script>alert('Anda harus login terlebih dahulu.'); window.location.href = 'index.html';</script>";
}
?>
