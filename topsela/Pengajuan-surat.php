<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "desa_toapaya_selatan"; // Ganti dengan nama database Anda

$conn = mysqli_connect($host, $user, $pass, $db);

// Periksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Tangkap data dari formulir
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitasi input dari pengguna untuk menghindari SQL Injection
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $nik = mysqli_real_escape_string($conn, $_POST['nik']);
    $kk = mysqli_real_escape_string($conn, $_POST['kk']);
    $kelahiran = mysqli_real_escape_string($conn, $_POST['kelahiran']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
    $pekerjaan = mysqli_real_escape_string($conn, $_POST['pekerjaan']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $jenis_surat = mysqli_real_escape_string($conn, $_POST['jenis_surat']);
    $keperluan_surat = mysqli_real_escape_string($conn, $_POST['keperluan']);
    
    // Tangani 'lainnya' jika ada input jenis_surat
    if ($_POST['jenis_surat'] == 'Lainnya') {
        $jenis_surat = mysqli_real_escape_string($conn, $_POST['lainnya']);
    }
    
    $tanggal_masuk = date('Y-m-d'); // Tanggal pengajuan hari ini
    $waktu_pengajuan = date('Y-m-d H:i:s'); // Waktu pengajuan sekarang
    $aksi = "Pengajuan Surat"; // Misalnya, bisa diubah sesuai kebutuhan

    // Tangani file unggahan
    $file_unggahan = null;
    if (isset($_FILES['file_unggahan']) && $_FILES['file_unggahan']['error'] == 0) {
        $file_unggahan = "uploads/" . $_FILES['file_unggahan']['name'];
        move_uploaded_file($_FILES['file_unggahan']['tmp_name'], $file_unggahan);
    }

    // Validasi ENUM
    $valid_jenis_surat = ['KTP', 'Pindah Domisili', 'Lainnya', 'Nikah', 'SKCK', 'SKTM', 'SKU', 'Waris', 'Beasiswa', 'Kelahiran', 'Kematian'];
    $valid_keperluan = ['Pribadi', 'Pekerjaan', 'Pendidikan', 'Lainnya'];

    if (!in_array($jenis_surat, $valid_jenis_surat) || !in_array($keperluan_surat, $valid_keperluan)) {
        die("Jenis surat atau keperluan tidak valid.");
    }

    // Query untuk menyimpan data ke database
    $query = "INSERT INTO pengajuan_surat (nama, nik, kk, kelahiran, email, telepon, pekerjaan, alamat, jenis_surat, keperluan_surat, tanggal_masuk, waktu_pengajuan, aksi, file_unggahan)
              VALUES ('$nama', '$nik', '$kk', '$kelahiran', '$email', '$telepon', '$pekerjaan', '$alamat', '$jenis_surat', '$keperluan_surat', '$tanggal_masuk', '$waktu_pengajuan', '$aksi', '$file_unggahan')";

    if (mysqli_query($conn, $query)) {
        echo "Data berhasil disimpan!";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }

    // Tutup koneksi
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistem Layanan Digital Desa Toapaya Selatan</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
  <link rel="stylesheet" href="dashboard.css">
  <link rel="icon" href="logo.png" type="image/jpeg">

  <style>
    h4 {
      text-align: center;
      margin-bottom: 20px;
      color: #34495e;
      font-size: 20px;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 5px;
    }

    label {
      font-weight: bold;
      color: #2c3e50;
    }

    input, select {
      padding: 10px;
      border: 1px solid #bdc3c7;
      border-radius: 5px;
      font-size: 14px;
      width: 100%;
    }

    input:focus, select:focus {
      outline: none;
      border-color: #3498db;
      box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
    }

    button {
      background-color: #3498db;
      color: #fff;
      border: none;
      padding: 10px 15px;
      cursor: pointer;
      border-radius: 5px;
      font-size: 16px;
      transition: background-color 0.3s;
    }

    button:hover {
      background-color: #2980b9;
    }

    input#lainnya {
      display: none;
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
      </div>

      <!-- Sidebar content -->
      <div class="sidebar">
        <a href="dashboard.php">
          <span class="material-icons-sharp">home</span>
          <h3>Dashboard</h3>
        </a>
        <a href="Pengajuan-surat.php" class="active">
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

    <main class="main-container">
        <h4>Formulir Pengajuan Surat</h4>
        <form method="POST" enctype="multipart/form-data">
            <label for="nama">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" required><br>

            <label for="nik">Nomor Induk Kependudukan</label>
            <input type="number" id="nik" name="nik" required><br>

            <label for="kk">Nomor Kartu Keluarga</label>
            <input type="number" id="kk" name="kk" required><br>

            <label for="kelahiran">Tanggal Lahir</label>
            <input type="date" id="kelahiran" name="kelahiran" required><br>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required><br>

            <label for="telepon">No. Telepon</label>
            <input type="number" id="telepon" name="telepon" required><br>

            <label for="pekerjaan">Pekerjaan</label>
            <input type="text" id="pekerjaan" name="pekerjaan" required><br>

            <label for="alamat">Alamat</label>
            <input type="text" id="alamat" name="alamat" required><br>

            <!-- Jenis Surat ENUM -->
            <label for="jenis_surat">Jenis Surat:</label>
            <select id="jenis_surat" name="jenis_surat" onchange="toggleInput()">
              <option value="KTP">------ Pilih -----</option>
              <option value="KTP">1. Surat Pengantar Pembuatan KTP</option>
              <option value="KK">2. Surat Pengantar Pembuatan KK</option>
              <option value="Domisili">3. Surat Pengantar Pindah Domisili</option>
              <option value="Nikah">4. Surat Pengantar Nikah (N1, N2, N4)</option>
              <option value="SKCK">5. Surat Pengantar SKCK</option>
              <option value="SKTM">6. Surat Pengantar Surat Keterangan Tidak Mampu</option>
              <option value="SKU">7. Surat Pengantar Keterangan Usaha</option>
              <option value="Waris">8. Surat Pengantar Ahli Waris</option>
              <option value="Beasiswa">9. Surat Pengantar Beasiswa</option>
              <option value="Kelahiran">10. Surat Pengantar Keterangan Kelahiran</option>
              <option value="Kematian">11. Surat Pengantar Keterangan Kematian</option>
              <option value="Lainnya">Lainnya</option>
            </select><br>

            <input type="text" id="lainnya" name="lainnya" style="display:none;" placeholder="Masukkan Jenis Surat Lainnya"><br>

            <!-- Keperluan Surat ENUM -->
            <label for="keperluan">Keperluan Surat:</label>
            <select id="keperluan" name="keperluan">
              <option value="Pribadi">Pribadi</option>
              <option value="Pekerjaan">Pekerjaan</option>
              <option value="Pendidikan">Pendidikan</option>
              <option value="Lainnya">Lainnya</option>
            </select><br>

            <!-- File Unggahan -->
            <label for="file_unggahan">File Unggahan (Opsional)</label>
            <input type="file" id="file_unggahan" name="file_unggahan"><br>

            <button type="submit">Ajukan Surat</button>
        </form>
    </main>
  </div>

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
  
    function toggleInput() {
        var jenis_surat = document.getElementById('jenis_surat').value;
        var lainnyaInput = document.getElementById('lainnya');
        if (jenis_surat === 'Lainnya') {
            lainnyaInput.style.display = 'block';
        } else {
            lainnyaInput.style.display = 'none';
        }
    }
  </script>
</body>
</html>
