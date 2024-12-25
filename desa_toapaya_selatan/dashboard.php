<?php
session_start();

// Fungsi untuk menghubungkan ke database
function connectDB() {
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'desa_toapaya_selatan';

    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Koneksi ke database gagal: " . $conn->connect_error);
    }

    return $conn;
}

// Cek apakah pengguna sudah login dan memiliki role admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

$conn = connectDB();

// Ambil data pengaduan warga
$queryPengaduan = "SELECT COUNT(*) AS total_pengaduan FROM pengaduan";
$resultPengaduan = $conn->query($queryPengaduan);

if ($resultPengaduan) {
    $dataPengaduan = $resultPengaduan->fetch_assoc();
} else {
    $dataPengaduan = ['total_pengaduan' => 0]; // Jika query gagal
}

// Ambil data pengajuan surat
$querySurat = "SELECT COUNT(*) AS total_surat FROM pengajuan_surat";
$resultSurat = $conn->query($querySurat);

if ($resultSurat) {
    $dataSurat = $resultSurat->fetch_assoc();
} else {
    $dataSurat = ['total_surat' => 0]; // Jika query gagal
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

// Ambil data pengaduan berdasarkan status
$queryPengaduanStatus = "SELECT status, COUNT(*) AS total_status FROM pengaduan GROUP BY status";
$resultPengaduanStatus = $conn->query($queryPengaduanStatus);

$pengaduanStatusData = [
    'status' => [],
    'total' => []
];

if ($resultPengaduanStatus) {
    while ($row = $resultPengaduanStatus->fetch_assoc()) {
        $pengaduanStatusData['status'][] = $row['status'];
        $pengaduanStatusData['total'][] = $row['total_status'];
    }
}

$conn->close();
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
    /* Container untuk summary box dan card */
    .dashboard-summary {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        margin: 20px 0;
        padding: 0 15px;
        box-sizing: border-box;
    }

    /* Styling untuk summary box */
    .summary-box, .card {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        flex: 1;
    }

    /* Styling judul di dalam summary box */
    .summary-box h3, .card h2 {
        font-size: 24px;
        color: #333;
        margin-bottom: 15px;
        font-weight: bold;
    }

    /* Styling isi text pada summary box */
    .summary-box p, .card p {
        font-size: 18px;
        color: #555;
    }

    /* Warna latar belakang dan garis untuk summary box */
    .summary-box {
        background-color: #f0f9ff;
        border-left: 5px solid #4c8bf5; /* Garis biru */
    }

    .card {
        background-color: #fff4e0;
        border-left: 5px solid #ffa500; /* Garis oranye */
    }

    /* Tombol Edit */
    .edit-button {
      display: inline-block;
      padding: 8px 16px;
      background-color: #28a745; /* Hijau */
      color: #fff;
      border-radius: 5px;
      text-decoration: none;
      transition: background-color 0.3s;
    }

    .edit-button:hover {
      background-color:rgb(25, 108, 43); /* Hijau lebih gelap saat hover */
    }

    /* Responsif: Menata layout saat layar lebih kecil */
    @media (max-width: 768px) {
        .dashboard-summary {
            flex-direction: column;
            align-items: center;
        }
        .summary-box, .card {
            width: 100%;
            margin-bottom: 20px;
        }
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
        <a href="dashboard.php" class="active">
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
        <a href="index.php" id="logout">
            <span class="material-icons-sharp">logout</span>
            <h3>Keluar</h3>
        </a>
      </div>
    </aside>

    <!-- Main Content Section -->
    <main class="main-container">
        <div class="content-header">
          <h1>Dashboard - Admin</h1>
        </div>

        <div class="dashboard-summary">
            <div class="summary-box">
                <h3>Total Pengajuan Surat</h3>
                <p><?php echo $dataSurat['total_surat']; ?> Surat</p>
            </div>
            <div class="card">
                <h2>Total Pengaduan</h2>
                <p><?php echo $dataPengaduan['total_pengaduan']; ?> Pesan</p>
            </div>
        </div>

        <div class="chart-container">
            <div class="chart">
                <h2>Rekaptulasi Jenis Kelamin</h2>
                <canvas id="barchart" width="300" height="300"></canvas>
                <!-- Tombol Edit -->
                <a href="edit_rekap_jenis_kelamin.php" class="edit-button">Edit</a>
            </div>

            <div class="chart">
                <h2>Rekaptulasi Pengaduan Warga Berdasarkan Status</h2>
                <canvas id="piechart" width="300" height="300"></canvas>
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

            // Data untuk Chart Pengaduan Berdasarkan Status
            const pengaduanStatusData = {
                labels: <?php echo json_encode($pengaduanStatusData['status']); ?>,
                datasets: [{
                    data: <?php echo json_encode($pengaduanStatusData['total']); ?>,
                    backgroundColor: ['#ff9f00', '#4caf50', '#f44336'], // Warna berbeda untuk setiap status
                    hoverOffset: 4
                }]
            };


            // Chart.js untuk Pie Chart
            const ctxPie = document.getElementById('piechart').getContext('2d');
            const pieChart = new Chart(ctxPie, {
                type: 'pie',
                data: pengaduanStatusData,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            enabled: true
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
