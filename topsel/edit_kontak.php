<?php
include 'config.php';

// Cek apakah ID kontak tersedia di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mengambil data kontak berdasarkan ID
    $sql = "SELECT * FROM kontak_informasi WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $kontak = $result->fetch_assoc();
    } else {
        // Jika data tidak ditemukan
        die("Data kontak tidak ditemukan.");
    }
} else {
    // Jika ID tidak tersedia, redirect ke halaman lain
    die("ID kontak tidak tersedia.");
}

// Proses pembaruan data kontak
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jenis = $_POST['jenis'];
    $konten = $_POST['konten'];
    $gambar = $_FILES['gambar']['name'];

    // Menangani file gambar jika ada
    if ($gambar) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($gambar);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validasi tipe gambar
        if (in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file);
        } else {
            $error_message = "Hanya file gambar dengan ekstensi jpg, png, jpeg, atau gif yang diizinkan.";
        }
    } else {
        // Jika tidak ada gambar yang di-upload, gunakan gambar lama
        $target_file = $kontak['gambar'];
    }

    // Query untuk memperbarui data kontak
    $update_sql = "UPDATE kontak_informasi SET jenis = ?, konten = ?, gambar = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sssi", $jenis, $konten, $target_file, $id);

    if ($update_stmt->execute()) {
        // Jika pembaruan berhasil, redirect ke halaman sebelumnya
        header("Location: tentang-desa.php?id=$id");
        exit;
    } else {
        $error_message = "Terjadi kesalahan saat memperbarui data.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Kontak & Informasi</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
  <link rel="stylesheet" href="pengaduan.css">
  <script src="app.js" defer></script>
  <link rel="icon" href="logo.png" type="image/jpeg">
<style>
  /* Styling the form */
form {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    max-width: 1000px;
    margin: 20px auto;
}

/* Form group styling */
.form-group {
    margin-bottom: 20px;
}

/* Label styling */
label {
    font-size: 16px;
    color: #333;
    margin-bottom: 5px;
    display: block;
}

/* Input and textarea styling */
input[type="text"],
textarea,
input[type="file"] {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 14px;
    color: #333;
    margin-top: 5px;
}

/* Textarea additional styling */
textarea {
    resize: vertical;
}

/* Button styling */
button.submit-btn {
    padding: 12px 20px;
    background-color: #4CAF50;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

/* Button hover effect */
button.submit-btn:hover {
    background-color: rgb(25, 87, 28);
}

/* Styling for the current image preview */
img {
    max-width: 100%;
    height: auto;
    margin-top: 10px;
    border-radius: 5px;
}

/* Optional error message styling */
.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 5px;
    font-size: 16px;
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
      <h1>Edit Kontak & Informasi</h1>

      <!-- Menampilkan pesan error jika ada -->
      <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
      <?php endif; ?>

      <!-- Formulir Edit Kontak -->
      <form action="edit_kontak.php?id=<?php echo $kontak['id']; ?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label for="jenis">Jenis Kontak</label>
          <input type="text" id="jenis" name="jenis" value="<?php echo $kontak['jenis']; ?>" required>
        </div>
        <div class="form-group">
          <label for="konten">Konten</label>
          <textarea id="konten" name="konten" rows="4" required><?php echo $kontak['konten']; ?></textarea>
        </div>
        <div class="form-group">
          <label for="gambar">Gambar (opsional)</label>
          <input type="file" id="gambar" name="gambar">
          <?php if (!empty($kontak['gambar'])): ?>
            <p>Gambar Saat Ini: <img src="<?php echo $kontak['gambar']; ?>" alt="Gambar" width="100"></p>
          <?php endif; ?>
        </div>
        <div class="form-group">
          <button type="submit" class="submit-btn">Simpan Perubahan</button>
        </div>
      </form>
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
