<?php
include 'config.php';

// Ambil data dari database
$sql = "SELECT * FROM informasi_desa";
$result = $conn->query($sql);

$informasi = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $informasi[] = $row; // Simpan semua data ke array
    }
}

// Query untuk data sosial budaya
$sql_sosial_budaya = "SELECT * FROM sosial_budaya";
$result_sosial_budaya = $conn->query($sql_sosial_budaya);

$sosial_budaya = [];
if ($result_sosial_budaya && $result_sosial_budaya->num_rows > 0) {
    while ($row = $result_sosial_budaya->fetch_assoc()) {
        $sosial_budaya[] = $row; // Simpan data ke array
    }
}

// Query untuk data kontak & informasi
$sql_kontak = "SELECT * FROM kontak_informasi";
$result_kontak = $conn->query($sql_kontak);

$kontak_informasi = [];
if ($result_kontak && $result_kontak->num_rows > 0) {
    while ($row = $result_kontak->fetch_assoc()) {
        $kontak_informasi[] = $row; // Simpan data ke array
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistem Layanan Digital Desa Toapaya Selatan</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
  <link rel="stylesheet" href="tentang-desa.css">
  <script src="app.js" defer></script>
  <link rel="icon" href="logo.png" type="image/jpeg">
  <style>
    /* Style umum untuk tombol */
    button {
      border: none;
      background-color: white;
      padding: 0px 0px;
      font-size: 14px;
      cursor: pointer;
      transition: all 0.3s ease;
      text-align: center;
      margin-left: 10px; /* Menambahkan jarak antar tombol */
    }
    button a {
      color: white;
      text-decoration: none;
    }
    /* Style untuk container tombol */
    .button-container {
      display: flex;
      justify-content: flex-end; /* Menempatkan tombol di sebelah kanan */
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
        <a href="pengaduan.php">
          <span class="material-icons-sharp">contact_emergency</span>
          <h3>Pengaduan</h3>
        </a>
        <a href="tentang-desa.php" class="active">
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

    <main class="content">
      <h1>Tentang Desa - Admin</h1>
      <?php foreach ($informasi as $info): ?>
        <div class="container-placeholder">
          <div class="content-placeholder">
            <h2><?php echo $info['judul']; ?></h2>
            <p><?php echo nl2br($info['konten']); ?></p>
            <!-- Tombol Edit dan Hapus di kanan -->
            <div class="button-container">
              <button class="edit">
                <a href="edit_desa.php?id=<?php echo $info['id']; ?>">Edit</a>
              </button>
              <button class="delete">
                <a href="delete_desa.php?id=<?php echo $info['id']; ?>" onclick="return confirm('Yakin ingin menghapus data ini?');">Hapus</a>
              </button>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

      <h3>Sosial & Budaya</h3>
      <div class="container-placeholder" id="sosial-budaya">
        <?php foreach ($sosial_budaya as $item): ?>
          <div class="content-placeholder">
            <img src="<?php echo $item['gambar']; ?>" alt="Gambar">
            <h2><?php echo $item['judul']; ?></h2>
            <p><?php echo nl2br($item['deskripsi']); ?></p>
            <!-- Tombol Edit dan Hapus di kanan -->
            <div class="button-container">
              <button class="edit">
                <a href="edit_sosial.php?id=<?php echo $item['id']; ?>">Edit</a>
              </button>
              <button class="delete">
                <a href="delete_sosial.php?id=<?php echo $item['id']; ?>" onclick="return confirm('Yakin ingin menghapus data ini?');">Hapus</a>
              </button>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <h3>Kontak & Informasi</h3>
      <div class="container-placeholder" id="kontak">
        <?php foreach ($kontak_informasi as $kontak): ?>
          <div class="content-placeholder">
            <?php if (!empty($kontak['gambar'])): ?>
              <img src="<?php echo $kontak['gambar']; ?>" alt="Gambar <?php echo $kontak['jenis']; ?>">
            <?php endif; ?>
            <h2><?php echo $kontak['jenis']; ?></h2>
            <p><?php echo nl2br($kontak['konten']); ?></p>
            <!-- Tombol Edit dan Hapus di kanan -->
            <div class="button-container">
              <button class="edit">
                <a href="edit_kontak.php?id=<?php echo $kontak['id']; ?>">Edit</a>
              </button>
              <button class="delete">
                <a href="delete_kontak.php?id=<?php echo $kontak['id']; ?>" onclick="return confirm('Yakin ingin menghapus data ini?');">Hapus</a>
              </button>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </main>

    <script>
      // Event untuk Logout
      const logout = document.getElementById("logout");
      logout.addEventListener("click", (e) => {
        e.preventDefault();
        const confirmLogout = confirm("Apakah Anda yakin ingin logout?");
        if (confirmLogout) {
          window.location.href = "index.php"; // Ganti dengan URL halaman login
        }
      });
    </script>
  </div>
</body>
</html>
