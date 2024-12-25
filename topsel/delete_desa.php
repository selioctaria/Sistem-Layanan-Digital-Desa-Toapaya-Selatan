<?php
include 'config.php';

$id = $_GET['id'];

// Hapus data dari database
$delete_sql = "DELETE FROM informasi_desa WHERE id = $id";
if ($conn->query($delete_sql) === TRUE) {
    echo "Data berhasil dihapus.";
    header("Location: tentang-desa.php"); // Redirect kembali ke halaman utama setelah dihapus
} else {
    echo "Error: " . $conn->error;
}
?>
