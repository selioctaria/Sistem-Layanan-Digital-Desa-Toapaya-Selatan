<?php
include 'config.php';  // Menghubungkan dengan database

// Memeriksa apakah ID kontak tersedia di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus data kontak berdasarkan ID
    $sql = "DELETE FROM kontak_informasi WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    // Eksekusi query
    if ($stmt->execute()) {
        // Jika penghapusan berhasil, arahkan kembali ke halaman sebelumnya
        header("Location: kontak_list.php");  // Ganti dengan halaman yang sesuai
        exit;
    } else {
        // Jika terjadi kesalahan saat menghapus data
        die("Terjadi kesalahan saat menghapus data.");
    }
} else {
    // Jika ID tidak tersedia, tampilkan pesan error
    die("ID kontak tidak tersedia.");
}
?>
