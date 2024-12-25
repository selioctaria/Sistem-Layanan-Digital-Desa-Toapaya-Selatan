<?php
session_start();
require_once('config.php'); // Koneksi ke database

// Cek apakah pengguna sudah login
if (!isset($_SESSION['email'])) {
  header("Location: index.html");
  exit();
}

// Ambil data pengguna dari database
$email = $_SESSION['email'];
$query = "SELECT * FROM profile_admin WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$user = null;
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "<script>alert('Data tidak ditemukan'); window.location='dashboard.php';</script>";
    exit();
}

// Proses update profil
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil dan sanitasi input
    $nama = htmlspecialchars($_POST['name']);
    $phone = htmlspecialchars($_POST['phone']);
    $id_number = htmlspecialchars($_POST['id_number']);
    $status = htmlspecialchars($_POST['status']);
    $gender = htmlspecialchars($_POST['gender']);
    $address = htmlspecialchars($_POST['address']);
    
    // Default foto lama jika tidak ada upload baru
    $foto = $user['foto'];

    // Proses upload foto jika ada file yang diunggah
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/"; // Direktori penyimpanan
        $file_name = time() . "_" . basename($_FILES["profile_photo"]["name"]);
        $target_file = $target_dir . $file_name;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ["jpg", "jpeg", "png", "gif"];

        // Validasi tipe file
        if (in_array($file_type, $allowed_types)) {
            // Validasi ukuran file
            if ($_FILES['profile_photo']['size'] > 2000000) { // 2MB limit
                echo "<script>alert('File terlalu besar. Maksimum 2MB');</script>";
            } else {
                if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file)) {
                    $foto = $target_file; // Path file yang diunggah
                } else {
                    echo "<script>alert('Gagal mengupload foto');</script>";
                }
            }
        } else {
            echo "<script>alert('Hanya file JPG, JPEG, PNG, dan GIF yang diizinkan');</script>";
        }
    }

    // Proses hapus foto jika tombol hapus ditekan
    if (isset($_POST['remove_photo']) && $_POST['remove_photo'] == 'remove') {
        // Hapus foto dari server jika ada foto yang dihapus
        if ($foto !== NULL && !empty($user['foto'])) {
            unlink($user['foto']); // Hapus file dari server
        }
        $foto = NULL; // Set foto ke NULL
    }

    // Validasi input kosong
    if (empty($nama) || empty($phone) || empty($id_number) || empty($status) || empty($gender) || empty($address)) {
        echo "<script>alert('Semua field harus diisi');</script>";
    } else {
        // Update query dengan prepared statement
        $update_query = "UPDATE profile_admin SET 
                            nama = ?, 
                            phone = ?, 
                            id_petugas = ?, 
                            status = ?, 
                            gender = ?, 
                            alamat = ?, 
                            foto = ? 
                         WHERE email = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("ssssssss", $nama, $phone, $id_number, $status, $gender, $address, $foto, $email);

        // Eksekusi query update
        if ($update_stmt->execute()) {
            echo "<script>alert('Profil berhasil diperbarui'); window.location='profile.php';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat memperbarui profil');</script>";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Admin - Desa Toapaya Selatan</title>
    <link rel="stylesheet" href="dashboard.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="icon" href="logo.png" type="image/jpeg">
    <style>
      /* Main content styling */
      .main-content {
      margin-left: 10px;
      padding: 30px;
      background-color: white;
      min-height: 100vh;
      box-sizing: border-box;
      transition: margin-left 0.3s ease;
      }

      .profile-container {
      background-color: #dce1eb;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      width: 80%;
      max-width: 600px;
      margin: 10px auto 20px 2px;
      }

      .profile-container h1 {
      font-size: 28px;
      color: #333;
      text-align: center;
      margin-bottom: 20px;
      }

      .form-group {
      display: block;
      margin-bottom: 20px;
      }

      .form-group label {
    font-weight: bold;
    font-size: 14px;
    display: block;
    margin-bottom: 8px;
    color: #555;
}

      .form-group input, .form-group select, .form-group textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
      color: #333;
      }

      .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
      border-color: #006bb3;
      }

      .form-group select {
      cursor: pointer;
      }

      .form-group textarea {
      height: 100px;
      }

      .file-preview-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 10px;
      margin-bottom: 0px;
      }

      .preview-container {
      width: 200px;
      height: 200px;
      margin-right: 290px;
      justify-content: center;
      align-items: center;
      border: 1px solid #ddd;
      background-color: #f0f0f0;
      border-radius: none;
      overflow: hidden;
      }

      #preview {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 0;
      }

      .upload-buttons button {
      background-color: #006bb3;
      color: white;
      border: none;
      padding: 10px 16px;
      border-radius: 10px;
      cursor: pointer;
      transition: background-color 0.3s;
      margin-top: 10px;
      margin-right: 10px;
      }

      .upload-buttons button:hover {
      background-color: #003f7d;
      }

      .upload-buttons button[type="submit"] {
      color: white;
      border: none;
      padding: 10px 16px;
      border-radius: 10px;
      cursor: pointer;
      transition: background-color 0.3s;
      margin-top: 10px;
      margin-right: 270px;
      background-color: #d72f2f;
      }

      .upload-buttons button[type="submit"]:hover {
      background-color:rgb(127, 36, 26);
      }

      .form-actions {
      display: flex;
      justify-content: left;
      gap: 10px;
      }

      .form-actions button {
      background-color: #28a745;
      color: white;
      padding: 10px 20px;
      border-radius: 5px;
      border: none;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s;
      }

      .form-actions button:hover {
      background-color: #218838;
      }
    </style>
</head>
<body>
    <div class="container">
        <aside class="sidebar-container">
            <div class="top">
                <div class="logo">
                    <img src="logo.jpg" alt="Logo">
                    <h2 class="text-muted">Desa Toa<span class="danger">paya Selatan</span></h2>
                </div>
            </div>
            <div class="sidebar">
                <a href="dashboard.php"><span class="material-icons-sharp">home</span><h3>Dashboard</h3></a>
                <a href="pengajuan-surat.php"><span class="material-icons-sharp">create_new_folder</span><h3>Pengajuan Surat</h3></a>
                <a href="pengaduan.php"><span class="material-icons-sharp">contact_emergency</span><h3>Pengaduan</h3></a>
                <a href="tentang-desa.php"><span class="material-icons-sharp">location_city</span><h3>Tentang Desa</h3></a>
                <a href="profile.php" class="active"><span class="material-icons-sharp">person</span><h3>Profile</h3></a>
                <a href="#" id="logout">
            <span class="material-icons-sharp">logout</span>
            <h3>Keluar</h3>
          </a>
              </div>
        </aside>

        <main class="main-container">
            <h1>Profil Admin</h1>
            <div class="profile-container">
                <form method="POST" enctype="multipart/form-data">
                    <!-- Foto Profil -->
                    <div class="form-group">
                      <label for="profile_photo">Foto Profil</label>
                      <div class="file-preview-container">
                        <div class="preview-container">
                          <?php if (!empty($user['foto'])): ?>
                            <p>Foto Saat Ini:</p>
                            <img src="<?= htmlspecialchars($user['foto']); ?>" alt="Foto Profil" style="width: 200px; height: 200px; object-fit: cover;">
                          <?php endif; ?>
                            <img id="preview" src="" alt="Preview Foto" style="display: none;">
                        </div>
                        <input type="file" id="profile_photo" name="profile_photo" accept="image/*" onchange="previewImage(event)"> 
                          <div class="upload-buttons">
                            <button type="button" onclick="document.getElementById('profile_photo').click()">Upload Foto</button>
                            <button type="submit" name="remove_photo" value="remove">Hapus Foto</button>
                          </div>
                        </div>
                    </div>
                          </div>

                    <!-- Fields for Name, Email, etc. -->
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['nama']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" value="<?= htmlspecialchars($user['email']); ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="phone">Nomor Telepon</label>
                        <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($user['phone']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="id_number">Nomor Identitas Petugas</label>
                        <input type="text" id="id_number" name="id_number" value="<?= htmlspecialchars($user['id_petugas']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" required>
                            <option value="Pilih" <?= ($user['status'] == 'Pilih') ? 'selected' : ''; ?>>Pilih</option>
                            <option value="Aktif" <?= ($user['status'] == 'Aktif') ? 'selected' : ''; ?>>Aktif</option>
                            <option value="Non-Aktif" <?= ($user['status'] == 'Non-Aktif') ? 'selected' : ''; ?>>Non-Aktif</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="gender">Jenis Kelamin</label>
                        <select id="gender" name="gender" required>
                            <option value="Pilih" <?= ($user['gender'] == 'Pilih') ? 'selected' : ''; ?>>Pilih</option>
                            <option value="Pria" <?= ($user['gender'] == 'Pria') ? 'selected' : ''; ?>>Laki-Laki</option>
                            <option value="Wanita" <?= ($user['gender'] == 'Wanita') ? 'selected' : ''; ?>>Perempuan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <textarea id="address" name="address" required><?= htmlspecialchars($user['alamat']); ?></textarea>
                    </div>

                    <div class="form-actions">
                        <button type="submit">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        function previewImage(event) {
            if (event.target.files && event.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function () {
                    const preview = document.getElementById('preview');
                    preview.src = reader.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(event.target.files[0]);
            }
        }
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
