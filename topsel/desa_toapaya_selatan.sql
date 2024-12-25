-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2024 at 05:38 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `desa_toapaya_selatan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_profiles`
--

CREATE TABLE `admin_profiles` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nomor_telepon` varchar(20) DEFAULT NULL,
  `nomor_identitas` varchar(50) DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `status` enum('Aktif','Tidak Aktif') DEFAULT 'Aktif',
  `alamat` text DEFAULT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_profiles`
--

INSERT INTO `admin_profiles` (`id`, `id_user`, `nama`, `email`, `nomor_telepon`, `nomor_identitas`, `jenis_kelamin`, `status`, `alamat`, `foto_profil`, `created_at`, `updated_at`) VALUES
(1, 1, 'Alvira Angraini', 'Alviraangraini549@gmail.com', '083183517525', '987654321', 'Perempuan', 'Aktif', 'Jl. Raya No. 123, Tanjung Pinang', 'uploads/alvira.jpg', '2024-12-13 15:15:03', '2024-12-13 15:15:03'),
(2, 2, 'Budi Santoso', 'budi.santoso@gmail.com', '081234567890', '123456789', 'Laki-laki', 'Aktif', 'Jl. Merdeka No. 45, Jakarta', 'uploads/budi.jpg', '2024-12-13 15:15:03', '2024-12-13 15:15:03');

-- --------------------------------------------------------

--
-- Table structure for table `dashboard_recapwarga`
--

CREATE TABLE `dashboard_recapwarga` (
  `id` int(11) NOT NULL,
  `month` enum('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember') NOT NULL,
  `year` int(11) NOT NULL,
  `male_count` int(11) DEFAULT 0,
  `female_count` int(11) DEFAULT 0,
  `total_complaints` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dashboard_recapwarga`
--

INSERT INTO `dashboard_recapwarga` (`id`, `month`, `year`, `male_count`, `female_count`, `total_complaints`) VALUES
(1, 'Januari', 2024, 10, 12, 5),
(2, 'Februari', 2024, 8, 15, 7);

-- --------------------------------------------------------

--
-- Table structure for table `pengaduan`
--

CREATE TABLE `pengaduan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_telepon` varchar(15) DEFAULT NULL,
  `judul_pengaduan` varchar(150) DEFAULT NULL,
  `isi_pengaduan` text NOT NULL,
  `status` enum('pending','proses','selesai') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengaduan`
--

INSERT INTO `pengaduan` (`id`, `user_id`, `nama`, `alamat`, `email`, `no_telepon`, `judul_pengaduan`, `isi_pengaduan`, `status`, `created_at`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, 'Pengaduan ini anonim. Mohon segera ditindaklanjuti.', 'pending', '2024-12-13 13:52:29'),
(4, 1, 'John Doe', 'Jl. Merdeka No. 10', 'johndoe@example.com', '08123456789', 'Pengaduan tentang pelayanan', 'Saya ingin melaporkan pelayanan yang kurang memadai di kantor desa.', 'pending', '2024-12-13 14:01:37'),
(5, 1, 'Alvira Angraini', 'Jl. Tanjung pinang No. 12', 'Alviraangraini549@gmail.com', '083183517525', 'Pengaduan tentang kebersihan lingkungan', 'Saya ingin melaporkan masyarakat yang membuangg limbah sembarangan.', 'pending', '2024-12-13 14:05:16'),
(7, 3, 'Seli Octaria Simatupang', 'Desa Toapaya Selatan', 'seli@gmail.com', '081373338257', 'Layanan Petugas Kantor Desa', 'Pelayanan oleh petugas di kantor desa sangat lambat dan kurang ramah', 'proses', '2024-12-14 03:20:05'),
(8, 3, 'Seli Octaria Simatupang', 'Desa Toapaya Selatan', 'seli@gmail.com', '081373338257', 'Air Mati', 'Air Mati', 'selesai', '2024-12-14 03:28:22'),
(9, 1, 'JHON', 'XILKSCHNXKSIU', 'jhon@gmail.com', '09392364923956', 'hjxsx,', 'wxfgvnhvjx nvfwifvxsv', 'pending', '0000-00-00 00:00:00'),
(11, 3, 'Seli Octaria Simatupang', 'Desa Toapaya Selatan', 'seli@gmail.com', '081373338257', 'Jembatan Rusak', 'Jembatan Rusak', 'selesai', '2024-12-14 03:28:22');

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_surat`
--

CREATE TABLE `pengajuan_surat` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `jenis_surat` varchar(50) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `waktu_pengajuan` time NOT NULL,
  `status` enum('Pending','Diproses','Selesai') DEFAULT 'Pending',
  `aksi` varchar(50) DEFAULT 'Lihat',
  `file_unggahan` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengajuan_surat`
--

INSERT INTO `pengajuan_surat` (`id`, `user_id`, `nama`, `jenis_surat`, `tanggal_masuk`, `waktu_pengajuan`, `status`, `aksi`, `file_unggahan`) VALUES
(1, 1, 'Jhon Doe', 'KTP', '2024-12-01', '08:30:00', 'Pending', 'Lihat', ''),
(2, 1, 'Jhon Doe', 'Kartu Keluarga', '2024-12-02', '09:00:00', 'Pending', 'Lihat', ''),
(3, 1, 'Jhon Doe', 'Surat Pengantar', '2024-12-03', '10:00:00', 'Diproses', 'Lihat', ''),
(4, 3, 'Seli Octaria Simatupang', 'KTP', '2024-12-14', '07:12:21', 'Pending', 'Lihat', ''),
(5, 3, 'Seli Octaria Simatupang', 'Kartu Keluarga', '2024-12-14', '09:56:18', 'Diproses', 'Lihat', '');

-- --------------------------------------------------------

--
-- Table structure for table `rekap_jenis_kelamin`
--

CREATE TABLE `rekap_jenis_kelamin` (
  `id` int(11) NOT NULL,
  `tahun` int(4) NOT NULL,
  `pria` int(4) NOT NULL,
  `wanita` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rekap_jenis_kelamin`
--

INSERT INTO `rekap_jenis_kelamin` (`id`, `tahun`, `pria`, `wanita`) VALUES
(1, 2018, 20, 15),
(2, 2019, 25, 20),
(3, 2020, 30, 25),
(4, 2021, 40, 35),
(5, 2022, 50, 45),
(6, 2023, 55, 50),
(7, 2024, 60, 55);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'John Doe', 'johndoe@example.com', 'password123', 'user', '2024-12-13 14:00:20'),
(2, 'Raveliana', 'Rave@example.com', 'Rave123', 'admin', '2024-12-13 15:14:00'),
(3, 'Seli Octaria Simatupang', 'seli@gmail.com', 'user20', 'user', '2024-12-14 03:17:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_profiles`
--
ALTER TABLE `admin_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nomor_identitas` (`nomor_identitas`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `dashboard_recapwarga`
--
ALTER TABLE `dashboard_recapwarga`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pengajuan_surat`
--
ALTER TABLE `pengajuan_surat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `rekap_jenis_kelamin`
--
ALTER TABLE `rekap_jenis_kelamin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tahun` (`tahun`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_profiles`
--
ALTER TABLE `admin_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dashboard_recapwarga`
--
ALTER TABLE `dashboard_recapwarga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pengaduan`
--
ALTER TABLE `pengaduan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pengajuan_surat`
--
ALTER TABLE `pengajuan_surat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `rekap_jenis_kelamin`
--
ALTER TABLE `rekap_jenis_kelamin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_profiles`
--
ALTER TABLE `admin_profiles`
  ADD CONSTRAINT `admin_profiles_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD CONSTRAINT `pengaduan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pengajuan_surat`
--
ALTER TABLE `pengajuan_surat`
  ADD CONSTRAINT `pengajuan_surat_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
