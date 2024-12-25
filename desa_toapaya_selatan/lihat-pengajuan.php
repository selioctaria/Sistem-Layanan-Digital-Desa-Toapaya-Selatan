<?php
// Include koneksi database
include 'config.php';

// Cek apakah parameter 'id' ada
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mengambil data pengajuan berdasarkan id
    $query = "SELECT * FROM pengajuan_surat WHERE id = ?";
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
        <h3>Detail Isi Pengjuan Surat</h3>
        <table class="table table-bordered">
            <tr>
                <th>Nama</th>
                <td><?= htmlspecialchars($row['nama']); ?></td>
            </tr>
            <tr>
                <th>Nomor Induk Kependudukan</th>
                <td><?= htmlspecialchars($row['nik']); ?></td>
            </tr>
            <tr>
                <th>Nomor Kartu Keluarga</th>
                <td><?= htmlspecialchars($row['kk']); ?></td>
            </tr>
            <tr>
                <th>Tanggal Kelahiran</th>
                <td><?= htmlspecialchars($row['kelahiran']); ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?= htmlspecialchars($row['email']); ?></td>
            </tr>
            <tr>
                <th>No. Telepon</th>
                <td><?= htmlspecialchars($row['telepon']); ?></td>
            </tr>
            <tr>
                <th>Pekerjaan</th>
                <td><?= htmlspecialchars($row['pekerjaan']); ?></td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td><?= htmlspecialchars($row['alamat']); ?></td>
            </tr>
            <tr>
                <th>Jenis Surat</th>
                <td><?= htmlspecialchars($row['jenis_surat']); ?></td>
            </tr>
            <tr>
                <th>Keperluan Surat</th>
                <td><?= htmlspecialchars($row['keperluan_surat']); ?></td>
            </tr>
            <tr>
                <th>Tanggal Pengajuan</th>
                <td><?= htmlspecialchars($row['tanggal_masuk']); ?></td>
            </tr>
            <tr>
                <th>Waktu Pengajuan</th>
                <td><?= htmlspecialchars($row['waktu_pengajuan']); ?></td>
            </tr>
            <tr>
                <th>File Unggahan</th>
                <td><?= htmlspecialchars($row['file_unggahan']); ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td><?= htmlspecialchars($row['status']); ?></td>
            </tr>
        </table>
        <a href="Pengajuan-surat.php" class="btn btn-primary">Kembali ke Dashboard</a>
    </div>
</body>
</html>
