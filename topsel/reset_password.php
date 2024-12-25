<?php
include('database.php');

$token = $_GET['token'];

$sql = "SELECT * FROM users WHERE reset_token = '$token'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo "<script>alert('Token tidak valid.'); window.location.href = 'index.html';</script>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['new_password'];
    $sql = "UPDATE users SET password = '$new_password', reset_token = NULL WHERE reset_token = '$token'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Password berhasil direset.'); window.location.href = 'index.html';</script>";
    } else {
        echo "<script>alert('Gagal mereset password.');</script>";
    }
}
?>

<form method="POST">
    <label>Password Baru:</label>
    <input type="password" name="new_password" required />
    <button type="submit">Reset Password</button>
</form>
