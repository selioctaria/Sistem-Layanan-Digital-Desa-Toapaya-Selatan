<?php
include 'config.php'; // Pastikan ada file koneksi ke database


if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus data
    $query = "DELETE FROM pengaduan WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>
            alert('Data berhasil dihapus!');
            window.location.href = 'pengaduan.php'; // Redirect ke halaman admin
        </script>";
    } else {
        echo "<script>
            alert('Gagal menghapus data!');
            window.location.href = 'pengaduan.php'; // Redirect ke halaman admin
        </script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>
        alert('ID tidak ditemukan!');
        window.location.href = 'pengaduan.php'; // Redirect ke halaman admin
    </script>";
}
?>
