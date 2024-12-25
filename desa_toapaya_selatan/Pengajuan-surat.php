<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['email'])) {
    // Jika tidak login, arahkan ke halaman login
    header("Location: index.html");
    exit();
}

include 'config.php';

// Cek apakah ada input pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Tentukan jumlah data per halaman
$limit = 8;

// Tangkap halaman yang dipilih (default ke halaman 1 jika tidak ada)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit; // Hitung offset untuk query

// Query untuk menghitung total data pengajuan surat
$sql_count = "SELECT COUNT(*) AS total FROM pengajuan_surat";
if ($search) {
    // Jika ada keyword pencarian, tambahkan kondisi WHERE untuk pencarian
    $sql_count .= " WHERE nama LIKE '%" . $conn->real_escape_string($search) . "%' 
                    OR jenis_surat LIKE '%" . $conn->real_escape_string($search) . "%'";
}

$result_count = $conn->query($sql_count);
$total_row = $result_count->fetch_assoc();
$total_data = $total_row['total'];

// Hitung jumlah halaman
$total_pages = ceil($total_data / $limit);

// Query untuk mengambil data dari database berdasarkan pencarian dan paginasi
$sql = "SELECT * FROM pengajuan_surat";
if ($search) {
    $sql .= " WHERE nama LIKE '%" . $conn->real_escape_string($search) . "%' 
              OR jenis_surat LIKE '%" . $conn->real_escape_string($search) . "%'";
}
$sql .= " LIMIT $limit OFFSET $offset";

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
  <link rel="icon" href="logo.png" type="image/jpeg">

  <style>
    /* Style untuk tombol dropdown */
    select {
        padding: 8px;
        font-size: 14px;
        border: 2px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
        color: #333;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    select:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    /* Style untuk tombol update */
    button[type="submit"] {
        padding: 8px 15px;
        font-size: 14px;
        font-weight: bold;
        color: #fff;
        background-color: #28a745;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    button[type="submit"]:hover {
        background-color: #218838;
        transform: scale(1.05);
    }

    button[type="submit"]:active {
        background-color: #1e7e34;
        transform: scale(0.95);
    }

    .status-pending {
        color: orange;
        font-weight: bold;
    }

    .status-diproses {
        color: blue;
        font-weight: bold;
    }

    .status-selesai {
        color: green;
        font-weight: bold;
    }

    .pagination {
        margin-top: 20px;
        text-align: center;
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
        background-color: rgb(10, 53, 99);
    }
  </style>
</head>

<body>
  <div class="container">
    <!-- Sidebar Section -->
    <aside class="sidebar-container">
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

    <!-- Main Content Section -->
    <main class="main-container">
      <div class="content-header">
        <h1>Pengajuan Surat - Admin</h1>
      </div>

      <div class="search-bar-container">
        <div class="search-bar">
          <form method="GET" action="pengajuan-surat.php">
            <input type="text" name="search" id="search-bar" placeholder="Cari Surat" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <button type="submit" id="search-btn">Search</button>
          </form>
        </div>
      </div>

      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Jenis Surat</th>
              <th>Tanggal Masuk</th>
              <th>Waktu Pengajuan</th>
              <th>Status</th>
              <th>Aksi</th>
              <th>Proses</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($result->num_rows > 0) {
                $no = $offset + 1; // Mulai nomor urut dari offset + 1
                while ($row = $result->fetch_assoc()) {
                    // Tentukan kelas warna berdasarkan status
                    $statusClass = "";
                    if ($row['status'] == 'Pending') {
                        $statusClass = 'status-pending';
                    } elseif ($row['status'] == 'Diproses') {
                        $statusClass = 'status-diproses';
                    } elseif ($row['status'] == 'Selesai') {
                        $statusClass = 'status-selesai';
                    }
                    echo "<tr>
                            <td>" . $no++ . "</td>
<td>" . htmlspecialchars($row['nama']) . "</td>
<td>" . htmlspecialchars($row['jenis_surat']) . "</td>
<td>" . htmlspecialchars($row['tanggal_masuk']) . "</td>
<td>" . htmlspecialchars($row['waktu_pengajuan']) . "</td>
<td class='$statusClass'>" . htmlspecialchars($row['status']) . "</td>
<td>
    <a href='lihat-pengajuan.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-info btn-sm'>Lihat Detail</a>
</td>
<td>
    <form action='process.php' method='POST'>
        <input type='hidden' name='id' value='" . htmlspecialchars($row['id']) . "'>
        <select name='status'>
            <option value='Pilih'>Pilih</option>
            <option value='Pending' " . ($row['status'] == 'Pending' ? 'selected' : '') . ">Pending</option>
            <option value='Diproses' " . ($row['status'] == 'Diproses' ? 'selected' : '') . ">Diproses</option>
            <option value='Selesai' " . ($row['status'] == 'Selesai' ? 'selected' : '') . ">Selesai</option>
        </select>
        <button type='submit'>Update</button>
    </form>
</td>

                  
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='8'>Tidak ada data pengajuan</td></tr>";
            }

            $conn->close();
            ?>
          </tbody>
        </table>
      </div>

      <!-- Paginasi -->
      <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="pengajuan-surat.php?page=1<?= $search ? '&search=' . urlencode($search) : ''; ?>" class="btn">First</a>
            <a href="pengajuan-surat.php?page=<?= $page - 1; ?><?= $search ? '&search=' . urlencode($search) : ''; ?>" class="btn">Previous</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="pengajuan-surat.php?page=<?= $i; ?><?= $search ? '&search=' . urlencode($search) : ''; ?>" class="btn <?= $i == $page ? 'active' : ''; ?>"><?= $i; ?></a>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <a href="pengajuan-surat.php?page=<?= $page + 1; ?><?= $search ? '&search=' . urlencode($search) : ''; ?>" class="btn">Next</a>
            <a href="pengajuan-surat.php?page=<?= $total_pages; ?><?= $search ? '&search=' . urlencode($search) : ''; ?>" class="btn">Last</a>
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
