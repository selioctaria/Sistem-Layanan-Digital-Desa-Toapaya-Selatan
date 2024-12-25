<?php
// Konfigurasi koneksi database
$host = "localhost";      // Host database
$user = "root";           // Username database
$password = "";           // Password database
$database = "desa_toapaya_selatan";  // Nama database

// Membuat koneksi
$conn = new mysqli($host, $user, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Validasi input
    if (!empty($id) && !empty($status)) {
        // Query untuk update status
        $sql = "UPDATE pengajuan_surat SET status = ? WHERE id = ?";

        // Persiapkan query
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $status, $id); // "si" berarti string, integer

        // Eksekusi query
        if ($stmt->execute()) {
            echo "Status berhasil diperbarui!";
            header("Location: pengajuan-surat.php"); // Redirect ke halaman utama
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        // Tutup statement
        $stmt->close();
    } else {
        echo "ID atau Status tidak boleh kosong.";
    }
}

// Tutup koneksi
$conn->close();
?>
