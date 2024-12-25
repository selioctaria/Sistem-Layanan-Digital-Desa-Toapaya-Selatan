<?php
session_start();
include 'koneksi.php'; // Menyertakan koneksi database

// Pastikan error ditampilkan untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Query untuk mencari user berdasarkan email
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $koneksi->prepare($query); // Pastikan $koneksi sudah diinisialisasi
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Mengambil data user
        $user = $result->fetch_assoc();
        
        // Verifikasi password dengan password yang di-hash
        if (password_verify($password, $user['password'])) {
            // Sukses login, buat session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            // Redirect berdasarkan role
            if ($user['role'] == 'admin') {
                header("Location: dashboard.php");
                exit;
            } else {
                header("Location: user-dashboard.php");
                exit;
            }
        } else {
            // Password salah
            $_SESSION['error'] = "Password salah!";
            header("Location: index.html"); // Halaman login
            exit;
        }
    } else {
        // Email tidak ditemukan
        $_SESSION['error'] = "Email tidak terdaftar!";
        header("Location: index.html"); // Halaman login
        exit;
    }
} else {
    // Jika akses langsung ke file
    header("Location: index.html"); 
    exit;
}
?>
