<?php
session_start();

// Fungsi untuk menghubungkan ke database
function connectDB() {
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'desa_toapaya_selatan';

    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Koneksi ke database gagal: " . $conn->connect_error);
    }

    return $conn;
}

// Cek apakah pengguna sudah login
if (!isset($_SESSION['email'])) {
    // Jika tidak login, arahkan ke halaman login
    header("Location: index.html");
    exit();
}

$conn = connectDB();

// Proses submit form untuk menyimpan data baru
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tahun = $_POST['tahun'];
    $pria = $_POST['pria'];
    $wanita = $_POST['wanita'];

    // Query untuk memperbarui data
    $query = "UPDATE rekap_jenis_kelamin SET pria = ?, wanita = ? WHERE tahun = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('iis', $pria, $wanita, $tahun);

    if ($stmt->execute()) {
        $message = "Data berhasil diperbarui!";
    } else {
        $message = "Gagal memperbarui data!";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistem Layanan Digital Desa Toapaya Selatan</title>
  <!-- Google Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
  <link rel="stylesheet" href="dashboard.css">
  <!-- Tambahkan logo di title -->
  <link rel="icon" href="logo.png" type="image/jpeg">

  <style>
    .form-container {
        max-width: 1040px; /* Lebar maksimum lebih besar */
        width: 100%; /* Gunakan 90% lebar layar untuk memanfaatkan ruang lebih banyak */
        margin: 10px auto 100px 300px; /* Margin kiri lebih kecil agar form mendekati kanan */
        padding: 40px 60px; /* Padding lebih proporsional */
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .form-container h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .form-container label {
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
    }

    .form-container input {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    .form-container button {
        width: 100%; /* Tombol memenuhi lebar form */
        padding: 10px;
        background-color: #4c8bf5;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
    }

    .form-container button:hover {
        background-color: #3b76d2;
    }

    .message {
        text-align: center;
        margin-top: 20px;
        font-weight: bold;
        color: green;
    }

    /* Media query untuk perangkat kecil */
    @media (max-width: 768px) {
        .form-container {
            max-width: 100%; /* Gunakan seluruh lebar di layar kecil */
            margin: 20px; /* Margin yang lebih kecil */
            padding: 20px;
        }

        .form-container button {
            font-size: 14px; /* Ukuran font tombol lebih kecil */
        }
    }
</style>

</head>
<body>
<div class="container">
    <!------- Sidebar Section -------> 
    <aside class="sidebar-container">
      <div class="top">
        <div class="logo">
          <img src="logo.jpg" alt="Logo">
          <h2 class="text-muted">Desa Toa<span class="danger">paya Selatan</span></h2>
        </div>
        <div class="close" id="close-btn"></div>
      </div>

      <div class="sidebar">
        <a href="dashboard.php" class="active">
            <span class="material-icons-sharp">home</span>
            <h3>Dashboard</h3>
        </a>
        <a href="Pengajuan-surat.php">
            <span class="material-icons-sharp">create_new_folder</span>
            <h3>Pengajuan Surat</h3>
        </a>
        <a href="pengaduan.php">
            <span class="material-icons-sharp">contact_emergency</span>
            <h3>Pengaduan</h3>
        </a>
        <a href="tentang-desa.php">
            <span class="material-icons-sharp">location_city</span>
            <h3>Tentang Desa</h3>
        </a>
        <a href="profile.php">
            <span class="material-icons-sharp">person</span>
            <h3>Profile</h3>
        </a>
        <a href="index.html" id="logout">
            <span class="material-icons-sharp">logout</span>
            <h3>Keluar</h3>
        </a>
      </div>
    </aside>
    </div>

    <div class="form-container">
        <h2>Edit Rekapitulasi Jenis Kelamin</h2>

        <?php if (isset($message)) { echo "<p class='message'>$message</p>"; } ?>

        <!-- Formulir untuk mengedit data jenis kelamin -->
        <form action="edit_rekap_jenis_kelamin.php" method="POST">
            <label for="tahun">Tahun:</label>
            <input type="text" id="tahun" name="tahun" required>

            <label for="pria">Jumlah Pria:</label>
            <input type="number" id="pria" name="pria" required>

            <label for="wanita">Jumlah Wanita:</label>
            <input type="number" id="wanita" name="wanita" required>

            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
