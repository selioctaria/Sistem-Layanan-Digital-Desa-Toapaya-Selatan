<?php
include 'config.php';

// Cek apakah ada ID yang dikirimkan melalui URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mengambil data berdasarkan ID
    $sql = "SELECT * FROM informasi_desa WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika data ditemukan, ambil data dari database
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
    } else {
        // Jika data tidak ditemukan, arahkan ke halaman sebelumnya
        header('Location: tentang-desa.php');
        exit();
    }
}

// Proses form saat disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $konten = $_POST['konten'];

    // Query untuk update data
    $sql_update = "UPDATE informasi_desa SET judul = ?, konten = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssi", $judul, $konten, $id);

    if ($stmt_update->execute()) {
        // Jika berhasil, arahkan kembali ke halaman tentang-desa.php
        header('Location: tentang-desa.php');
        exit();
    } else {
        $error_message = "Gagal memperbarui data. Coba lagi.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Informasi Desa</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
  <link rel="stylesheet" href="pengaduan.css">
  <script src="app.js" defer></script>
  <link rel="icon" href="logo.png" type="image/jpeg">

  <style>
  /* Pengaturan Umum Form */
  form {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    max-width: 1000px;
    margin: 0 auto;
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
    border-color: #007bff;
    outline: none;
  }

  textarea {
    resize: vertical;
    min-height: 200px;
  }

  button.submit {
    background-color: #007bff;
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
    background-color: #0056b3;
  }

  /* Styling untuk form saat di-submit */
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

    <main class="content">
      <h1>Edit Informasi Desa</h1>

      <!-- Jika ada error saat update, tampilkan pesan error -->
      <?php if (isset($error_message)): ?>
        <div class="error-message"><?php echo $error_message; ?></div>
      <?php endif; ?>

      <!-- Form untuk edit data -->
      <form method="POST">
        <div class="form-group">
          <label for="judul">Judul</label>
          <input type="text" id="judul" name="judul" value="<?php echo htmlspecialchars($data['judul']); ?>" required>
        </div>
        <div class="form-group">
          <label for="konten">Isi Konten</label>
          <textarea id="konten" name="konten" rows="10" required><?php echo htmlspecialchars($data['konten']); ?></textarea>
        </div>
        <div class="form-group">
          <button type="submit" class="submit">Simpan</button>
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
