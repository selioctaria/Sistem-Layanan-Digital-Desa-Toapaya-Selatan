<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$db = "desa_toapaya_selatan";

$conn = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil data dari formulir
$nama = $_POST['nama'];
$nik = $_POST['nik'];
$kk = $_POST['kk'];
$kelahiran = $_POST['kelahiran'];
$jenis_surat = $_POST['jenis_surat'];
$email = $_POST['email'];
$telepon = $_POST['telepon'];
$alamat = $_POST['alamat'];
$tanggal_masuk = date("Y-m-d");
$waktu_pengajuan = date("H:i:s");
$status = "Pending";

// Query untuk menyimpan data ke database
$sql = "INSERT INTO pengajuan_surat (nama, nik, kk, kelahiran, email, telepon, alamat, jenis_surat, tanggal_masuk, waktu_pengajuan, status)
        VALUES ('$nama', '$nik', '$kk', '$kelahiran', '$email', '$telepon', '$alamat', '$jenis_surat', '$tanggal_masuk', '$waktu_pengajuan', '$status')";

// Eksekusi query
if (mysqli_query($conn, $sql)) {
    echo "<h3>Pengajuan Surat Anda Berhasil Disimpan!</h3>";
    echo "<a href='form_pengajuan.html'>Ajukan Surat Lagi</a>";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Tutup koneksi
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengajuan Surat</title>
</head>
<body>
    <h2>Form Pengajuan Surat</h2>
    <form action="simpan_pengajuan.php" method="POST">
        <label for="nama">Nama Lengkap:</label><br>
        <input type="text" name="nama" required><br><br>

        <label for="nik">NIK:</label><br>
        <input type="text" name="nik" required><br><br>

        <label for="kk">Nomor KK:</label><br>
        <input type="text" name="kk" required><br><br>

        <label for="kelahiran">Tanggal Lahir:</label><br>
        <input type="date" name="kelahiran" required><br><br>

        <label for="jenis_surat">Jenis Surat:</label><br>
        <select name="jenis_surat" required>
            <option value="Kartu Keluarga">Kartu Keluarga</option>
            <option value="KTP">KTP</option>
            <option value="Surat Pengantar">Surat Pengantar</option>
        </select><br><br>

        <label for="email">Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label for="telepon">No. Telepon:</label><br>
        <input type="text" name="telepon" required><br><br>

        <label for="alamat">Alamat:</label><br>
        <textarea name="alamat" rows="4" required></textarea><br><br>

        <button type="submit">Ajukan Surat</button>
    </form>
</body>
</html>
