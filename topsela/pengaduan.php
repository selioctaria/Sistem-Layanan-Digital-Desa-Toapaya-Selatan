<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $no_telepon = $_POST['no_telepon'];
    $judul_pengaduan = $_POST['judul_pengaduan'];
    $isi_pengaduan = $_POST['isi_pengaduan'];
    $status = "Pending"; // Status default untuk pengaduan yang baru dikirim

    // Query untuk menyimpan data ke database
    $query = "INSERT INTO pengaduan (user_id, nama, alamat, email, no_telepon, judul_pengaduan, isi_pengaduan, status, created_at) 
              VALUES ('3', '$nama', '$alamat', '$email', '$no_telepon', '$judul_pengaduan', '$isi_pengaduan', '$status', NOW())";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Pengaduan berhasil dikirim. Terima kasih!');</script>";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
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
  <!-- Logo di title -->
  <link rel="icon" href="logo.png" type="image/jpeg">

  <style>
        /* Gaya Umum */
        h4 {
            text-align: center;
            color: #333;
            font-size: 20px;
        }

        /* Kontainer Form */
        form {
            background-color: #fff;
            width: 90%;
            max-width: 1300px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Input Style */
        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 10px;
            margin: 8px 0 15px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }

        /* Tombol Submit */
        input[type="submit"] {
            background-color: #006bb3;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color:rgb(17, 56, 83);
        }

        /* Placeholder Style */
        input::placeholder,
        textarea::placeholder {
            color: #aaa;
            font-size: 13px;
        }

        /* Gaya Tambahan untuk Label */
        label {
            font-weight: bold;
            color: #555;
        }
    </style>
</head>
<body>
<div class="container">
    <aside>
      <div class="top">
        <div class="logo">
          <img src="logo.jpg" alt="Logo">
          <h2 class="text-muted">Desa Toa<span class="danger">paya Selatan</span></h2>
        </div>
        <div class="close" id="close-btn"></div>
      </div>

      <div class="sidebar">
        <a href="dashboard.php">
          <span class="material-icons-sharp">home</span>
          <h3>Dashboard</h3>
        </a>
        <a href="Pengajuan-surat.php">
          <span class="material-icons-sharp">create_new_folder</span>
          <h3>Pengajuan Surat</h3>
        </a>
        <a href="pengaduan.php" class="active">
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

    <main class="main-container">
    <h4>Formulir Pengaduan</h4>
    <form method="post" action="">
        Nama: <input type="text" name="nama" required><br><br>
        Alamat: <input type="text" name="alamat" required><br><br>
        Email: <input type="email" name="email" required><br><br>
        No Telepon: <input type="text" name="no_telepon" required><br><br>
        Judul Pengaduan: <input type="text" name="judul_pengaduan" required><br><br>
        Isi Pengaduan:<br>
        <textarea name="isi_pengaduan" rows="5" cols="30" required></textarea><br><br>
        <input type="submit" value="Kirim Pengaduan">
    </form>
</main>

<script>
    // Event untuk Logout
    const logout = document.getElementById("logout");
    logout.addEventListener("click", (e) => {
      e.preventDefault();
      const confirmLogout = confirm("Apakah Anda yakin ingin logout?");
      if (confirmLogout) {
        window.location.href = "index.html"; // Ganti dengan URL halaman login
      }
    });
  </script>
  
</body>
</html>
