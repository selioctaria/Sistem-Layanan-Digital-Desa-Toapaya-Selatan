<?php
include('database.php');

$email = $_POST['email'];

// Cek apakah email terdaftar
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Generate reset token
    $token = bin2hex(random_bytes(16));
    $sql = "UPDATE users SET reset_token = '$token' WHERE email = '$email'";
    if (mysqli_query($conn, $sql)) {
        // Kirim email dengan link reset
        $reset_link = "http://localhost/reset_password.php?token=$token";
        mail($email, "Reset Password", "Klik link berikut untuk reset password: $reset_link");

        echo "<script>alert('Link reset password telah dikirim ke email Anda.'); window.location.href = 'index.html';</script>";
    }
} else {
    echo "<script>alert('Email tidak ditemukan.'); window.location.href = 'index.html';</script>";
}
?>
