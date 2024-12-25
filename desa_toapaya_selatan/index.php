<?php
// Panggil file koneksi database
include 'koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: index.php");
    exit;
}

// Query untuk mengambil nama pengguna dari database berdasarkan email di sesi
$queryNama = "SELECT nama FROM profile_user WHERE email = ?";
$stmt = $conn->prepare($queryNama);
$stmt->bind_param("s", $_SESSION['email']);
$stmt->execute();
$resultNama = $stmt->get_result();

// Ambil nama pengguna
if ($resultNama && $resultNama->num_rows > 0) {
    $rowNama = $resultNama->fetch_assoc();
    $namaPengguna = $rowNama['nama'];
} else {
    $namaPengguna = "Pengguna"; // Jika nama tidak ditemukan
}

// Ambil data jenis kelamin dari tabel rekap_jenis_kelamin
$queryJenisKelamin = "SELECT tahun, pria, wanita FROM rekap_jenis_kelamin";
$resultJenisKelamin = $conn->query($queryJenisKelamin);

$jenisKelaminData = [
    'tahun' => [],
    'pria' => [],
    'wanita' => []
];

if ($resultJenisKelamin) {
    while ($row = $resultJenisKelamin->fetch_assoc()) {
        $jenisKelaminData['tahun'][] = $row['tahun'];
        $jenisKelaminData['pria'][] = $row['pria'];
        $jenisKelaminData['wanita'][] = $row['wanita'];
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
  <!-- Tambahkan logo di title -->
  <link rel="icon" href="logo.png" type="image/jpeg">
    <style>
        .welcome-message {
            background-color: #f0f9ff;
            border-left: 5px solid #4c8bf5;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        .welcome-message h2 {
            color: #333;
            margin: 0;
            font-size: 28px;
        }
        .welcome-message p {
            color: #555;
            margin: 5px 0 0;
            font-size: 18px;
        }
        .chart-container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }

    .chart {
    padding: 2rem;
    border-radius: 1rem;
    background: var(--color-info-light);
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    width: 100%;
    max-width: 90rem;
    overflow: visible; /* Pastikan grafik tidak dipotong */
    }
        .chart-container h2 {
            color: #333;
        }
        a.logout-button {
            display: inline-block;
            margin-top: 10px;
            color: #fff;
            background-color: #d9534f;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 5px;
        }
        a.logout-button:hover {
            background-color: #c9302c;
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
        <a href="user-dashboard.php" class="active">
            <span class="material-icons-sharp">home</span>
            <h3>Dashboard</h3>
        </a>
        <a href="user-pengajuan-surat.php">
            <span class="material-icons-sharp">create_new_folder</span>
            <h3>Pengajuan Surat</h3>
        </a>
        <a href="user-pengaduan.php">
            <span class="material-icons-sharp">contact_emergency</span>
            <h3>Pengaduan</h3>
        </a>
        <a href="user-riwayat.php">
            <span class="material-icons-sharp">history</span>
            <h3>Riwayat</h3>
          </a>
        <a href="user-tentangdesa.php">
            <span class="material-icons-sharp">location_city</span>
            <h3>Tentang Desa</h3>
        </a>
        <a href="user-profil.php">
            <span class="material-icons-sharp">person</span>
            <h3>Profile</h3>
        </a>
        <a href="index.php" id="logout">
            <span class="material-icons-sharp">logout</span>
            <h3>Keluar</h3>
        </a>
      </div>
    </aside>

    <!-- Main Dashboard -->
    <main class="main-container">
        <div class="content-header">
          <h1>Dashboard</h1>
        </div>

        <!-- Ucapan Selamat Datang -->
        <div class="welcome-message">
            <h2>Selamat Datang, <?php echo htmlspecialchars($namaPengguna); ?>!</h2>
            <p>Selamat datang di sistem layanan digital Desa Toapaya Selatan.</p>
        </div>

        <div class="chart-container">
            <div class="chart">
                <h2>Rekaptulasi Jenis Kelamin</h2>
                <canvas id="barchart" width="300" height="300"></canvas>
            </div>
        </div> 

        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0/dist/chart.min.js"></script>
        <script>
            // Data untuk Chart Jenis Kelamin
            const jenisKelaminData = {
                labels: <?php echo json_encode($jenisKelaminData['tahun']); ?>,
                datasets: [{
                    label: 'Pria',
                    data: <?php echo json_encode($jenisKelaminData['pria']); ?>,
                    backgroundColor: '#4c8bf5',
                    borderColor: '#4c8bf5',
                    borderWidth: 1
                },
                {
                    label: 'Wanita',
                    data: <?php echo json_encode($jenisKelaminData['wanita']); ?>,
                    backgroundColor: 'rgba(255, 99, 132, 0.8)',
                    borderColor: 'rgba(255, 99, 132, 0.8)',
                    borderWidth: 1
                }]
            };

            // Chart.js untuk Bar Chart
            const ctxBar = document.getElementById('barchart').getContext('2d');
            const barChart = new Chart(ctxBar, {
                type: 'bar',
                data: jenisKelaminData,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            enabled: true
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    </main>    
  </div>

  <!-- Footer Section -->
  <footer class="footer-container">
      <h3>Layanan Masyarakat Desa Toapaya Selatan</h3>
      <p>Copyright © 2024 | <a href="#">Layanan Masyarakat.TOPSELA</a></p>
      <p>All rights reserved.</p>
  </footer>

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

</body>
</html>
