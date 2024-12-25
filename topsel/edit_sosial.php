<?php
include 'config.php';

// Ambil data berdasarkan ID yang diterima melalui URL
$id = $_GET['id'];
$sql = "SELECT * FROM sosial_budaya WHERE id = $id";
$result = $conn->query($sql);

$sosial_budaya = null;
if ($result && $result->num_rows > 0) {
    $sosial_budaya = $result->fetch_assoc();
}

// Proses jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $gambar = $_FILES['gambar']['name'];

    // Jika ada gambar baru
    if ($gambar) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($gambar);
        move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file);
        $sql_update = "UPDATE sosial_budaya SET judul = '$judul', deskripsi = '$deskripsi', gambar = '$target_file' WHERE id = $id";
    } else {
        $sql_update = "UPDATE sosial_budaya SET judul = '$judul', deskripsi = '$deskripsi' WHERE id = $id";
    }

    if ($conn->query($sql_update) === TRUE) {
        echo "Data berhasil diperbarui.";
        header("Location: tentang-desa.php"); // Redirect setelah berhasil update
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Sosial Budaya - Admin</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
  <link rel="stylesheet" href="pengaduan.css">
  <script src="app.js" defer></script>
  <link rel="icon" href="logo.png" type="image/jpeg">
  <style>
    /* Style umum untuk form */
    form {
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      max-width: 1000px;
      margin: 20px auto;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      font-size: 16px;
      color: #333;
      display: block;
      margin-bottom: 8px;
    }

    input[type="text"], textarea {
      width: 100%;
      padding: 12px;
      font-size: 16px;
      border: 1px solid #ddd;
      border-radius: 5px;
      box-sizing: border-box;
      transition: border-color 0.3s;
    }

    input[type="text"]:focus, textarea:focus {
      border-color: #28a745;
      outline: none;
    }

    textarea {
      resize: vertical;
      min-height: 150px;
    }

    .file-input-container {
      margin-bottom: 20px;
    }

    input[type="file"] {
      width: 100%;
      padding: 12px;
      border-radius: 5px;
      border: 1px solid #ddd;
      box-sizing: border-box;
      font-size: 16px;
      transition: border-color 0.3s;
    }

    input[type="file"]:focus {
      border-color: #28a745;
    }

    button.submit {
      background-color: #45a049;
      color: white;
      padding: 12px 20px;
      font-size: 16px;
      border-radius: 5px;
      border: none;
      cursor: pointer;
      transition: background-color 0.3s;
      width: 100%;
    }

    button.submit:hover {
      background-color:rgb(25, 87, 28);
    }

    button.submit:active {
      transform: scale(0.98);
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
      <h1>Edit Sosial & Budaya</h1>
      <?php if ($sosial_budaya): ?>
        <form method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label for="judul">Judul</label>
            <input type="text" id="judul" name="judul" value="<?php echo htmlspecialchars($sosial_budaya['judul']); ?>" required>
          </div>
          <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="10" required><?php echo htmlspecialchars($sosial_budaya['deskripsi']); ?></textarea>
          </div>
          <div class="form-group file-input-container">
            <label for="gambar">Gambar (Opsional)</label>
            <input type="file" id="gambar" name="gambar">
            <?php if ($sosial_budaya['gambar']): ?>
              <p>Gambar saat ini: <a href="<?php echo $sosial_budaya['gambar']; ?>" target="_blank">Lihat Gambar</a></p>
            <?php endif; ?>
          </div>
          <div class="form-group">
            <button type="submit" class="submit">Simpan Perubahan</button>
          </div>
        </form>
      <?php else: ?>
        <p>Data tidak ditemukan.</p>
      <?php endif; ?>
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
