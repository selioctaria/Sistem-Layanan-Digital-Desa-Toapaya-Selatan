<?php
require 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM pengaduan WHERE id = $id";
    $result = $conn->query($sql);
    $data = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];
    $sql = "UPDATE pengaduan SET status = '$status' WHERE id = $id";

    if ($conn->query($sql)) {
        header("Location: pengaduan.php");
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
    <title>Edit Status Pengaduan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center">Edit Status Pengaduan</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="pending" <?= $data['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="proses" <?= $data['status'] == 'proses' ? 'selected' : '' ?>>Proses</option>
                    <option value="selesai" <?= $data['status'] == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="pengaduan.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
