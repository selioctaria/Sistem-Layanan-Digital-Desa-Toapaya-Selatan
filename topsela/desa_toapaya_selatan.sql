-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2024 at 09:04 PM
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
-- Table structure for table `informasi_desa`
--

CREATE TABLE `informasi_desa` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `konten` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `informasi_desa`
--

INSERT INTO `informasi_desa` (`id`, `judul`, `konten`) VALUES
(1, 'Sejarah Desa Toapaya Selatan', 'Desa ini resmi berdiri sebagai bagian dari pemekaran Desa Toapaya pada awal 2000-an, seiring dengan pertumbuhan penduduk dan kebutuhan administrasi yang semakin kompleks. Pemekaran ini dilakukan untuk memberikan pelayanan yang lebih baik kepada masyarakat serta mempercepat pembangunan di daerah tersebut. Sebelum menjadi desa yang mandiri, wilayah ini dikenal sebagai area agraris dengan aktivitas utama masyarakatnya berfokus pada pertanian, perkebunan, dan peternakan kecil. Selain itu, Desa Toapaya Selatan juga memiliki potensi budaya yang dipengaruhi oleh tradisi lokal Melayu yang kuat, menjadikannya desa yang kaya akan nilai kearifan lokal. Hingga saat ini, Desa Toapaya Selatan terus berkembang melalui pembangunan infrastruktur dan digitalisasi layanan administrasi desa, untuk mendukung kesejahteraan dan kemajuan masyarakatnya.'),
(2, 'Visi & Misi', 'Visi Desa Toapaya Selatan adalah mewujudkan desa yang maju, mandiri, dan sejahtera dengan mengoptimalkan pemberdayaan masyarakat berbasis potensi lokal. Untuk mencapai visi tersebut, Desa Toapaya Selatan memiliki misi yang meliputi peningkatan pelayanan publik yang cepat, transparan, dan akuntabel melalui digitalisasi, pengembangan sektor pertanian, perikanan, dan usaha kecil untuk mendorong pertumbuhan ekonomi, serta pelestarian budaya lokal dan penguatan nilai gotong royong di masyarakat. Selain itu, desa juga berkomitmen untuk meningkatkan kualitas pendidikan dan kesehatan masyarakat serta mengelola sumber daya alam secara berkelanjutan demi kesejahteraan warga.');

-- --------------------------------------------------------

--
-- Table structure for table `kontak_informasi`
--

CREATE TABLE `kontak_informasi` (
  `id` int(11) NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `konten` text NOT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kontak_informasi`
--

INSERT INTO `kontak_informasi` (`id`, `jenis`, `konten`, `gambar`) VALUES
(1, 'Instagram', 'Akun Instagram resmi Desa Toapaya Selatan adalah <b>@desatoapayaselatan.</b>', 'img/10.jpg'),
(2, 'Facebook', 'Akun Facebook resmi Desa Toapaya Selatan adalah <b>Desa Toapaya Selatan.</b>', 'img/11.jpg');

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
  `status` enum('Pending','Proses','Selesai') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengaduan`
--

INSERT INTO `pengaduan` (`id`, `user_id`, `nama`, `alamat`, `email`, `no_telepon`, `judul_pengaduan`, `isi_pengaduan`, `status`, `created_at`) VALUES
(1, 3, 'Seli Octaria Simatupang', 'Desa Toapaya Selatan', 'seli@gmail.com', '081373338257', 'Pelayanan Administrasi Lambat dan Tidak Ramah', 'Pada hari Selasa, saya datang ke kantor desa untuk mengurus surat keterangan domisili. Namun, pelayanan sangat lambat dan petugas yang melayani saya tidak ramah. Bahkan, saya harus menunggu hampir 2 jam hanya untuk mendapatkan tanda tangan. Mohon perbaikan dalam pelayanan kepada warga agar lebih cepat dan sopan.', 'Proses', '2024-12-15 15:56:15'),
(2, 3, 'Seli Octaria Simatupang', 'Desa Toapaya Selatan', 'seli@gmail.com', '081373338257', 'Sampah Menumpuk', 'Sampah di depan Balai Desa sudah menumpuk dan menimbulkan bau tidak sedap. Kondisi ini sangat mengganggu warga yang beraktivitas di sekitar lokasi. Mohon pihak desa segera mengangkut sampah tersebut dan memastikan kebersihan area sekitar.', 'Selesai', '2024-12-01 16:01:14'),
(3, 3, 'Seli Octaria Simatupang', 'Desa Toapaya Selatan', 'seli@gmail.com', '081373338257', 'Kondisi Jalan Rusak Parah di Jalan Raya Utama', 'Jalan utama di Desa Toapaya Selatan sudah rusak parah, dengan banyak lubang besar yang membahayakan pengendara. Kerusakan ini sering kali menyebabkan kendaraan tergelincir, terutama saat hujan. Kami memohon perhatian serius dari pemerintah desa untuk segera memperbaiki jalan tersebut.', 'Proses', '2024-12-10 16:01:14'),
(4, 3, 'Seli Octaria Simatupang', 'Desa Toapaya Selatan', 'seli@gmail.com', '081373338257', 'Pengaduan tentang pelayanan', 'Saya ingin melaporkan pelayanan yang kurang memadai di kantor desa.', 'Pending', '2024-12-15 14:01:37'),
(5, 3, 'Seli Octaria Simatupang', 'Desa Toapaya Selatan', 'seli@gmail.com', '081373338257', 'Pengaduan tentang kebersihan lingkungan', 'Saya ingin melaporkan masyarakat yang membuangg limbah sembarangan.', 'Selesai', '2024-12-15 14:05:16'),
(6, 3, 'Seli Octaria Simatupang', 'Desa Toapaya Selatan', 'seli@gmail.com', '081373338257', 'Lampu Jalan Mati', 'Sudah lebih dari dua minggu lampu jalan di sepanjang Dusun III tidak menyala. Hal ini menyebabkan jalanan menjadi gelap gulita di malam hari, sehingga warga merasa tidak aman, terutama para pejalan kaki dan pengendara sepeda motor. Mohon pihak desa segera melakukan perbaikan untuk menghindari potensi kecelakaan atau tindak kejahatan.', 'Proses', '2024-12-15 15:56:15'),
(7, 3, 'Seli Octaria Simatupang', 'Desa Toapaya Selatan', 'seli@gmail.com', '081373338257', 'Layanan Petugas Kantor Desa', 'Pelayanan oleh petugas di kantor desa sangat lambat dan kurang ramah', 'Proses', '2024-12-14 03:20:05'),
(8, 3, 'Seli Octaria Simatupang', 'Desa Toapaya Selatan', 'seli@gmail.com', '081373338257', 'Fasilitas Posyandu Tidak Memadai', 'Fasilitas di Posyandu Desa sangat minim, seperti kurangnya kursi untuk ibu-ibu yang membawa anak, alat kesehatan yang tidak lengkap, dan tidak adanya ruang tunggu yang layak. Hal ini membuat kegiatan posyandu menjadi tidak nyaman dan kurang efektif. Mohon pihak desa memperhatikan dan memperbaiki fasilitas tersebut.', 'Proses', '2024-12-08 16:04:58'),
(9, 3, 'Seli Octaria Simatupang', 'Desa Toapaya Selatan', 'seli@gmail.com', '081373338257', 'Antrian di Kantor Desa Terlalu Lama', 'Antrian untuk pengurusan dokumen di Kantor Desa terlalu panjang dan lambat. Banyak warga yang harus menunggu hingga lebih dari 3 jam hanya untuk mendapatkan layanan. Mohon diperbaiki sistem antrean agar lebih efisien, misalnya dengan sistem nomor antrian yang lebih terorganisir.', 'Selesai', '2024-12-05 16:08:56'),
(10, 3, 'Seli Octaria Simatupang', 'Desa Toapaya Selatan', 'seli@gmail.com', '081373338257', ' Kebisingan dari Aktivitas Proyek di Malam Hari', 'Proyek konstruksi yang sedang berlangsung di dekat pemukiman Dusun IV sering beroperasi hingga larut malam. Suara mesin dan aktivitas pekerja sangat mengganggu warga yang ingin beristirahat. Mohon pihak desa memberikan teguran kepada kontraktor agar menghentikan pekerjaan pada malam hari.', 'Proses', '2024-12-12 16:04:58'),
(11, 3, 'Seli Octaria Simatupang', 'Desa Toapaya Selatan', 'seli@gmail.com', '081373338257', 'Jembatan Rusak', 'Saya ingin mengadukan kondisi jembatan yang rusak di Desa Toapaya Selatan. Jembatan tersebut terletak di jalan utama yang menghubungkan desa dengan pusat kecamatan. Sudah beberapa minggu ini, jembatan tersebut mengalami kerusakan yang cukup parah, terutama pada bagian lantai jembatan yang mulai retak dan beberapa potongan besi penyangga yang terlepas.\r\n\r\nAkibatnya, jalur tersebut menjadi sangat berbahaya untuk dilewati, terutama oleh kendaraan roda dua dan pejalan kaki. Kondisi ini sudah mengganggu aktivitas masyarakat, seperti transportasi harian, mengantarkan anak ke sekolah, dan distribusi barang dari dan ke desa.\r\n\r\nSaya berharap agar pihak terkait segera melakukan perbaikan agar jembatan ini dapat digunakan kembali dengan aman dan lancar. Terima kasih atas perhatian dan tindak lanjutnya.', 'Selesai', '2024-12-14 03:28:22'),
(21, 3, 'Sidiq', 'Toapaya', 'sidiq@gmail.com', '081373338257', 'xxxxxxxxx', 'bsxahsx uqwsxbqsucxbsuxhy', 'Proses', '2024-12-16 23:47:21'),
(23, 3, 'BUDIONO SIREGAR', 'LAUD', 'budiono@gmail.com', '000000000', 'xxxxxxxxxxxxxxxxx', 'xxxxxxxxxxxxxxxxxxxxx', 'Pending', '2024-12-17 18:26:08');

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_surat`
--

CREATE TABLE `pengajuan_surat` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nama` varchar(30) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `kk` varchar(20) NOT NULL,
  `kelahiran` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `pekerjaan` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `jenis_surat` varchar(50) NOT NULL,
  `keperluan_surat` enum('Pilih','Pribadi','Pekerjaan','Pendidikan','Lainnya') DEFAULT 'Pilih',
  `tanggal_masuk` date NOT NULL,
  `waktu_pengajuan` time NOT NULL,
  `status` enum('Pending','Diproses','Selesai') DEFAULT 'Pending',
  `aksi` varchar(50) DEFAULT 'Lihat',
  `file_unggahan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengajuan_surat`
--

INSERT INTO `pengajuan_surat` (`id`, `user_id`, `nama`, `nik`, `kk`, `kelahiran`, `email`, `telepon`, `pekerjaan`, `alamat`, `jenis_surat`, `keperluan_surat`, `tanggal_masuk`, `waktu_pengajuan`, `status`, `aksi`, `file_unggahan`) VALUES
(2, 3, 'Seli Octaria Simatupang', '', '', '', '', '', '', '', 'Kartu Keluarga', 'Pilih', '2024-12-02', '09:00:00', 'Selesai', 'Lihat', ''),
(3, 3, 'Seli Octaria Simatupang', '', '', '', '', '', '', '', 'Surat Pengantar', 'Pilih', '2024-12-03', '10:00:00', 'Selesai', 'Lihat', ''),
(4, 3, 'Seli Octaria Simatupang', '', '', '', '', '', '', '', 'KTP', 'Pilih', '2024-12-14', '07:12:21', 'Pending', 'Lihat', ''),
(5, 3, 'Seli Octaria Simatupang', '', '', '', '', '', '', '', 'Kartu Keluarga', 'Pilih', '2024-12-14', '09:56:18', 'Diproses', 'Lihat', ''),
(6, 3, 'Seli Octaria Simatupang', '', '', '', '', '', '', '', 'Surat Pengantar', 'Pilih', '2024-12-14', '15:56:18', 'Pending', 'Lihat', ''),
(7, 3, 'Seli Octaria Simatupang', '', '', '', '', '', '', '', 'Kartu Keluarga', 'Pilih', '2024-12-01', '00:00:00', 'Selesai', 'Lihat', NULL),
(8, 3, 'Seli Octaria Simatupang', '', '', '', '', '', '', '', 'Surat Pengantar', 'Pilih', '2024-12-02', '00:00:00', 'Selesai', 'Lihat', NULL),
(9, 3, 'Seli Octaria Simatupang', '', '', '', '', '', '', '', 'Kartu Keluarga', 'Pilih', '2024-12-03', '00:00:00', 'Diproses', 'Lihat', NULL),
(10, 3, 'Seli Octaria Simatupang', '', '', '', '', '', '', '', 'KTP', 'Pilih', '2024-12-04', '00:00:00', 'Diproses', 'Lihat', NULL),
(11, 3, 'Seli Octaria Simatupang', '', '', '', '', '', '', '', 'Kartu Keluarga', 'Pilih', '2024-12-06', '00:00:00', 'Selesai', 'Lihat', NULL),
(12, 3, 'Seli Octaria Simatupang', '', '', '', '', '', '', '', 'KTP', 'Pilih', '2024-12-07', '00:00:00', 'Pending', 'Lihat', NULL),
(21, NULL, 'Alvira', '123456789', '123456789', '2002-01-01', 'alvira@gmail.com', '000000000', 'xxxxxxxxxxxxxxxxxxx', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxx', 'KTP', 'Pribadi', '2024-12-17', '04:03:59', 'Pending', 'Pengajuan Surat', ''),
(22, NULL, 'SELI', '8687457', '8685', '2024-12-19', 'selioctarias@gmail.com', '081373338257', 'bcdfjdhcf ', 'cvdksx', 'KTP', 'Pribadi', '2024-12-17', '19:40:12', 'Pending', 'Pengajuan Surat', 'uploads/background.png'),
(23, NULL, 'SELI', '8687457', '8685', '2024-12-19', 'selioctarias@gmail.com', '081373338257', 'bcdfjdhcf ', 'cvdksx', 'KTP', 'Pribadi', '2024-12-17', '19:42:56', 'Pending', 'Pengajuan Surat', 'uploads/background.png');

-- --------------------------------------------------------

--
-- Table structure for table `profile_admin`
--

CREATE TABLE `profile_admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `id_petugas` varchar(50) NOT NULL,
  `status` enum('Pilih','Aktif','Non-Aktif') DEFAULT 'Pilih',
  `gender` enum('Pilih','Pria','Wanita') DEFAULT 'Pilih',
  `alamat` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profile_admin`
--

INSERT INTO `profile_admin` (`id`, `nama`, `email`, `password`, `phone`, `id_petugas`, `status`, `gender`, `alamat`, `foto`) VALUES
(1, 'Seli Octaria Simatupang', 'selioctaria@gmail.com', 'admin20', '081373338257', '12345678', 'Non-Aktif', 'Wanita', 'DESA TOAPAYA SELATAN', 'uploads/1734406826_seli.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `profile_user`
--

CREATE TABLE `profile_user` (
  `id` int(11) NOT NULL,
  `role` varchar(4) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `status` enum('Pilih','Menikah','Belum Menikah') DEFAULT 'Pilih',
  `gender` enum('Pilih','Pria','Wanita') DEFAULT 'Pilih',
  `alamat` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `pekerjaan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profile_user`
--

INSERT INTO `profile_user` (`id`, `role`, `nama`, `email`, `password`, `phone`, `status`, `gender`, `alamat`, `foto`, `pekerjaan`) VALUES
(1, 'user', 'Seli Octaria Simatupang', 'seli@gmail.com', 'user20', '081373338257', 'Belum Menikah', 'Wanita', 'Desa Toapaya Selatan', 'uploads/1734459842_seli.jpg', 'Mahasiswa'),
(2, 'user', '', 'sidiq@gmail.com', 'user10', '', 'Pilih', 'Pilih', '', NULL, ''),
(3, 'user', '', 'damma@gmail.com', 'user30', '', 'Pilih', 'Pilih', '', NULL, ''),
(4, 'user', '', 'alvira@gmail.com', '', '', 'Pilih', 'Pilih', '', NULL, ''),
(5, 'user', '', 'raveliana@gmail.com', '', '', 'Pilih', 'Pilih', '', NULL, ''),
(6, 'user', '', 'irwan@gmail.com', '', '', 'Pilih', 'Pilih', '', NULL, '');

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
(1, 2018, 2100, 1900),
(2, 2019, 2116, 1900),
(3, 2020, 2248, 1957),
(4, 2021, 2348, 2057),
(5, 2022, 2448, 2157),
(6, 2023, 2548, 2257),
(7, 2024, 2568, 2377);

-- --------------------------------------------------------

--
-- Table structure for table `sosial_budaya`
--

CREATE TABLE `sosial_budaya` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sosial_budaya`
--

INSERT INTO `sosial_budaya` (`id`, `judul`, `deskripsi`, `gambar`) VALUES
(1, 'Temu Karya Desa', 'Tujuan Temu Karya Desa adalah untuk membahas, merumuskan, dan menetapkan program-program pembangunan yang melibatkan masyarakat secara langsung. Kegiatan ini bertujuan memperkuat partisipasi masyarakat, menggali potensi lokal, serta menciptakan solusi bersama untuk meningkatkan kesejahteraan dan kemajuan desa.', 'img/8.jpg'),
(2, 'Musrenbang Desa', 'Musyawarah Perencanaan Desa (Musrenbangdes) bertujuan untuk menampung aspirasi masyarakat, menyusun perencanaan pembangunan yang sesuai kebutuhan, serta menetapkan prioritas program yang akan dilaksanakan. Kegiatan ini juga bertujuan mendorong partisipasi masyarakat, meningkatkan transparansi, dan menyelaraskan rencana desa dengan kebijakan pemerintah daerah.\r\n            ', 'img/7.jpg'),
(3, 'Monitoring & Evaluasi', 'Kegiatan BLT-DD (Bantuan Langsung Tunai Dana Desa) adalah program yang bertujuan untuk memberikan bantuan langsung kepada masyarakat desa yang terdampak situasi ekonomi sulit, seperti bencana atau pandemi. Program ini bertujuan untuk meringankan beban hidup keluarga miskin dengan memberikan bantuan tunai, sehingga mereka dapat memenuhi kebutuhan dasar seperti pangan, kesehatan, dan pendidikan.', 'img/6.jpg'),
(4, 'BLT - DD', 'Kegiatan BLT-DD (Bantuan Langsung Tunai Dana Desa) adalah program yang bertujuan untuk memberikan bantuan langsung kepada masyarakat desa yang terdampak situasi ekonomi sulit, seperti bencana atau pandemi. Program ini bertujuan untuk meringankan beban hidup keluarga miskin dengan memberikan bantuan tunai, sehingga mereka dapat memenuhi kebutuhan dasar seperti pangan, kesehatan, dan pendidikan. ', 'img/2.jpg'),
(5, 'Penyuluhan Kegiatan', 'Tujuan dari kegiatan penyuluhan adalah untuk memberikan informasi, edukasi, dan pemahaman kepada masyarakat mengenai berbagai aspek penting dalam kehidupan, seperti kesehatan, pertanian, pendidikan, lingkungan, dan peraturan desa. Penyuluhan bertujuan untuk meningkatkan kesadaran dan  keterampilan masyarakat, agar mereka dapat membuat keputusan yang lebih  baik dalam kehidupan sehari-hari, serta mengimplementasikan pengetahuan yang diperoleh untuk meningkatkan kualitas hidup.', 'img/9.jpg'),
(6, 'Pelatihan Pengawasan', 'Tujuan pelatihan pengawasan adalah untuk meningkatkan kemampuan dan kompetensi peserta dalam melaksanakan fungsi pengawasan secara efektif dan efisien. Pelatihan ini bertujuan agar peserta memahami teknik-teknik pengawasan, mampu mengidentifikasi dan menganalisis permasalahan, serta memastikan bahwa setiap kegiatan atau program berjalan sesuai dengan peraturan yang berlaku.', 'img/1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`) VALUES
(1, 'sidiq@gmail.com', 'user10'),
(2, 'seli@gmail.com', 'user20'),
(3, 'damma@gmail.com', 'user30'),
(4, 'alvira@gmail.com', 'alvira40'),
(5, 'raveliana@gmail.com', 'user50'),
(6, 'irwan@gmail.com', 'user60');

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
(2, 'Raveliana', 'Rave@example.com', '$2y$10$OdT7ketAP5HlYEjcNg7/Pe1ZlDLfiWtMdbH2aJcQnZmWGATkX7Ify', 'admin', '2024-12-13 15:14:00'),
(3, 'Seli Octaria Simatupang', 'seli@gmail.com', '$2y$10$/Q2W4yhbzxZ6Y46bYefHGOPyQCd8cLHrCfNqB8RR3AxqN8auxHa6a', 'user', '2024-12-14 03:17:17'),
(4, 'Seli Octaria', 'selioctaria@gmail.com', '$2y$10$Z0iskhdnrQXAIhtd8A8HKu0kF1Nraym3hPpjNcBJ4xR0wHAsJOB4m', 'admin', '2024-12-17 04:36:03');

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
-- Indexes for table `informasi_desa`
--
ALTER TABLE `informasi_desa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kontak_informasi`
--
ALTER TABLE `kontak_informasi`
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
-- Indexes for table `profile_admin`
--
ALTER TABLE `profile_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `profile_user`
--
ALTER TABLE `profile_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `rekap_jenis_kelamin`
--
ALTER TABLE `rekap_jenis_kelamin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tahun` (`tahun`);

--
-- Indexes for table `sosial_budaya`
--
ALTER TABLE `sosial_budaya`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

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
-- AUTO_INCREMENT for table `informasi_desa`
--
ALTER TABLE `informasi_desa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kontak_informasi`
--
ALTER TABLE `kontak_informasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pengaduan`
--
ALTER TABLE `pengaduan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `pengajuan_surat`
--
ALTER TABLE `pengajuan_surat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `profile_admin`
--
ALTER TABLE `profile_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `profile_user`
--
ALTER TABLE `profile_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rekap_jenis_kelamin`
--
ALTER TABLE `rekap_jenis_kelamin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sosial_budaya`
--
ALTER TABLE `sosial_budaya`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
