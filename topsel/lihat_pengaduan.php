<?php
// Include koneksi database
include 'config.php';

// Cek apakah parameter 'id' ada
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mengambil data pengaduan berdasarkan id
    $query = "SELECT * FROM pengaduan WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika data ditemukan
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Data tidak ditemukan!";
        exit;
    }
} else {
    echo "ID tidak valid!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Layanan Digital Desa Toapaya Selatan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Tambahkan logo di title -->
  <link rel="icon" href="logo.png" type="image/jpeg">
</head>
<body>
    <div class="container mt-5">
        <h3>Detail Isi Pengaduan</h3>
        <table class="table table-bordered">
            <tr>
                <th>Nama</th>
                <td><?= htmlspecialchars($row['nama']); ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?= htmlspecialchars($row['email']); ?></td>
            </tr>
            <tr>
                <th>No. Telepon</th>
                <td><?= htmlspecialchars($row['no_telepon']); ?></td>
            </tr>
            <tr>
                <th>Judul Pengaduan</th>
                <td><?= htmlspecialchars($row['judul_pengaduan']); ?></td>
            </tr>
            <tr>
                <th>Isi Pengaduan</th>
                <td><?= htmlspecialchars($row['isi_pengaduan']); ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td><?= htmlspecialchars($row['status']); ?></td>
            </tr>
            <tr>
                <th>Tanggal Dibuat</th>
                <td><?= htmlspecialchars($row['created_at']); ?></td>
            </tr>
        </table>
        <a href="pengaduan.php" class="btn btn-primary">Kembali ke Dashboard</a>
    </div>
</body>
</html>
