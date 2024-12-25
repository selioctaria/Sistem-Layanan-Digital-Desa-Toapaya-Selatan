<?php
require 'config.php';

// Tangkap tanggal yang dipilih dari formulir pencarian
$date = isset($_GET['date']) ? $_GET['date'] : '';

// Tentukan jumlah data per halaman
$limit = 8;

// Tangkap halaman yang dipilih (default ke halaman 1 jika tidak ada)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit; // Hitung offset untuk query

// Query untuk menghitung total pengaduan
$sql_count = "SELECT COUNT(*) AS total FROM pengaduan";
if ($date) {
    // Menambahkan kondisi pencarian berdasarkan tanggal pengaduan
    $sql_count .= " WHERE DATE(created_at) = '$date'";
}
$result_count = $conn->query($sql_count);
$total_row = $result_count->fetch_assoc();
$total_data = $total_row['total'];

// Hitung jumlah halaman
$total_pages = ceil($total_data / $limit);

// Query untuk mendapatkan data pengaduan dengan limit dan offset
$sql = "SELECT * FROM pengaduan";
if ($date) {
    $sql .= " WHERE DATE(created_at) = '$date'";
}
$sql .= " ORDER BY created_at DESC LIMIT $limit OFFSET $offset";

// Eksekusi query
$result = $conn->query($sql);
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
    /* Tombol Selengkapnya */
    .btn-info {
      display: block;
      width: 9rem;
      margin-top: 5px;
      padding: 3px 10px;
      background-color: #f1c40f;
      color: black;
      border-radius: 5px;
      text-decoration: none;
      transition: background-color 0.3s;
    }

    .btn-info:hover {
      background-color: #f39c12;
    }

    /* Tombol Edit */
    .btn-warning {
      display: inline-block;
      padding: 8px 16px;
      background-color: #28a745;
      color: #fff;
      font-weight: bold;
      border-radius: 5px;
      text-decoration: none;
      transition: background-color 0.3s;
    }

    .btn-warning:hover {
      background-color: #218838;
    }

    /* Tombol Hapus */
    .btn-danger {
      display: inline-block;
      padding: 8px 16px;
      background-color: #dc3545;
      color: #fff;
      font-weight: bold;
      border-radius: 5px;
      text-decoration: none;
      transition: background-color 0.3s;
    }

    .btn-danger:hover {
      background-color: #c82333;
    }

    
    

    /* Container untuk input tanggal dan tombol search */
    .date-container {
      display: flex;
      align-items: center;
    }

    .date-container input[type="date"] {
      padding: 8px;
      margin-right: 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    .date-container button {
      padding: 8px 16px;
      background-color: #006bb3;
      color: white;
      border: 1px solid #ccc;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .date-container button:hover {
      background-color:rgb(4, 65, 105);
    }

    /* Paginasi */
    .pagination {
      text-align: center;
      margin-top: 20px;
    }

    .pagination .btn {
        padding: 10px 20px;
        margin: 0 5px;
        border: 1px solid #ddd;
        text-decoration: none;
        background-color: #6d6d6d;
        color: white;
        font-size: 14px;
        border-radius: 5px;
    }

    .pagination .btn.active {
        background-color: #007bff;
        color: white;
    }

    .pagination .btn:hover {
        background-color:rgb(10, 53, 99);
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
          <a href="#" id="logout">
            <span class="material-icons-sharp">logout</span>
            <h3>Keluar</h3>
          </a>
        </div>
    </aside>

    <main class="main-container">
        <div class="content-header">
          <h1>Pengaduan - Admin</h1>
        </div>

      <div class="search-bar">
        <form method="GET" action="pengaduan.php">
            <div class="date-container">
                <input type="date" name="date" value="<?= isset($_GET['date']) ? $_GET['date'] : ''; ?>">
                <button type="submit" id="search-btn">Search</button>
            </div>
        </form>
      </div>

      <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Isi Pengaduan</th>
            <th>Status</th>
            <th>Waktu Pengaduan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
    <?php if ($result->num_rows > 0): ?>
        <?php $no = $offset + 1; while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['nama']; ?></td>
                <td><?= $row['alamat']; ?></td>
                <td>
                    <?= substr($row['isi_pengaduan'], 0, 50); ?>...
                    <a href="lihat_pengaduan.php?id=<?= $row['id']; ?>" class="btn btn-info btn-sm">Selengkapnya</a>
                </td>
                <td style="color: 
                <?php 
                    if ($row['status'] == 'Pending') echo '#ff9900'; 
                    elseif ($row['status'] == 'Proses') echo '#006bb3'; 
                    elseif ($row['status'] == 'Selesai') echo '#28a745'; 
                    else echo 'black'; 
                     ?>; font-weight: bold;">
                <?= $row['status']; ?>
            </td>
                <td><?= $row['created_at']; ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="hapus_pengaduan.php?id=<?= $row['id']; ?>" 
                       onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" 
                       class="btn btn-danger btn-sm">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="7" class="text-center">Tidak ada data pengaduan</td>
        </tr>
    <?php endif; ?>
</tbody>
      </table>
    </div>

    <!-- Paginasi -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="pengaduan.php?page=1<?= $date ? '&date=' . $date : ''; ?>" class="btn">First</a>
            <a href="pengaduan.php?page=<?= $page - 1; ?><?= $date ? '&date=' . $date : ''; ?>" class="btn">Previous</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="pengaduan.php?page=<?= $i; ?><?= $date ? '&date=' . $date : ''; ?>" class="btn <?= $i == $page ? 'active' : ''; ?>"><?= $i; ?></a>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <a href="pengaduan.php?page=<?= $page + 1; ?><?= $date ? '&date=' . $date : ''; ?>" class="btn">Next</a>
            <a href="pengaduan.php?page=<?= $total_pages; ?><?= $date ? '&date=' . $date : ''; ?>" class="btn">Last</a>
        <?php endif; ?>
    </div>

    </main>
  </div>

  <script>
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
