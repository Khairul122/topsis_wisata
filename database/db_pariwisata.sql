-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 09, 2025 at 09:40 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pariwisata`
--

-- --------------------------------------------------------

--
-- Table structure for table `alternatif`
--

CREATE TABLE `alternatif` (
  `id_alternatif` int NOT NULL,
  `nama_wisata` varchar(255) NOT NULL,
  `koordinat` varchar(100) NOT NULL,
  `deskripsi` text,
  `foto` varchar(255) DEFAULT NULL,
  `url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `alternatif`
--

INSERT INTO `alternatif` (`id_alternatif`, `nama_wisata`, `koordinat`, `deskripsi`, `foto`, `url`) VALUES
(1, 'Danau Lau Kawar', '3.1987281849257063, 98.38038606462712', 'Danau vulkanik di kaki Gunung Sinabung dengan pemandangan indah dan udara sejuk.', 'danau lau kawar.jpg', 'https://maps.app.goo.gl/kqHD3Pai4NdJUKmz6'),
(2, 'Gunung Sibayak', '3.239604173791476, 98.50494489062044', 'Gunung berapi aktif yang populer untuk pendakian dengan pemandangan kawah yang spektakuler.', 'gunung sibayak.jpeg', 'https://maps.app.goo.gl/T3c9TX4zGS4dXUSU7'),
(3, 'Air Terjun Sipiso-Piso', '2.916680165952653, 98.51947160811206', 'Salah satu air terjun tertinggi di Indonesia dengan panorama indah menghadap Danau Toba.', 'air terjun sipiso piso.jpg', 'https://maps.app.goo.gl/b6hwjQLfWHi9YBnQ6'),
(4, 'Bukit Gundaling', '3.1934533211743528, 98.50169647186767', 'Bukit dengan panorama kota Berastagi dan pemandangan Gunung Sinabung serta Gunung Sibayak.', 'Bukit Gundaling.JPG', 'https://maps.app.goo.gl/6j6sXYLbKEcBE6yq5'),
(5, 'Air Panas Lau Sidebuk-Debuk', '3.2240343338718325, 98.51406952345782', 'Pemandian air panas alami yang dipercaya memiliki manfaat kesehatan, terletak di kaki Gunung Sibayak.', 'Air Panas Lau Sidebuk-Debuk.jpg', 'https://maps.app.goo.gl/n7Ckx4Ghp18USXbD7');

-- --------------------------------------------------------

--
-- Table structure for table `jawaban_user`
--

CREATE TABLE `jawaban_user` (
  `id_jawaban` int NOT NULL,
  `nama_user` varchar(100) NOT NULL,
  `id_kuesioner` int NOT NULL,
  `jawaban` text NOT NULL,
  `nilai` decimal(5,2) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jawaban_user`
--

INSERT INTO `jawaban_user` (`id_jawaban`, `nama_user`, `id_kuesioner`, `jawaban`, `nilai`, `tanggal`) VALUES
(65, 'Sari', 26, 'Mobil pribadi atau rental', '5.00', '2025-03-09 09:15:30'),
(66, 'Sari', 31, 'Sangat mudah (jalan besar, mulus, bisa dilalui semua kendaraan)', '5.00', '2025-03-09 09:15:30'),
(67, 'Sari', 36, 'Jalan mulus dan lebar, tidak ada kendala', '5.00', '2025-03-09 09:15:30'),
(68, 'Sari', 41, 'Ya, tersedia bus/angkot dengan biaya murah', '5.00', '2025-03-09 09:15:30'),
(69, 'Sari', 46, 'Ya, tersedia shuttle gratis dari pengelola wisata', '5.00', '2025-03-09 09:15:30'),
(70, 'Sari', 76, 'Sangat Murah (< Rp 10.000)', '5.00', '2025-03-09 09:15:30'),
(71, 'Sari', 81, 'Ya, semua kategori harga tersedia', '5.00', '2025-03-09 09:15:30'),
(72, 'Sari', 86, 'Ya, diperbolehkan tanpa batasan', '5.00', '2025-03-09 09:15:30'),
(73, 'Sari', 91, 'Banyak restoran dengan makanan berkualitas dan beragam', '5.00', '2025-03-09 09:15:30'),
(74, 'Sari', 96, 'Sangat baik (standar kesehatan tinggi, pengawasan ketat)', '5.00', '2025-03-09 09:15:30'),
(75, 'Sari', 101, 'Sangat murah (< Rp 100.000/malam)', '5.00', '2025-03-09 09:15:30'),
(76, 'Sari', 106, 'Ya, tersedia untuk semua anggaran', '5.00', '2025-03-09 09:15:30'),
(77, 'Sari', 111, 'Sangat baik (fasilitas lengkap & modern)', '5.00', '2025-03-09 09:15:30'),
(78, 'Sari', 116, 'Ya, tersedia banyak pilihan paket wisata', '5.00', '2025-03-09 09:15:30'),
(79, 'Sari', 121, 'Ya, tersedia banyak fasilitas tambahan', '5.00', '2025-03-09 09:15:30'),
(80, 'Sari', 126, 'Sangat aman, tanpa ada risiko', '5.00', '2025-03-09 09:15:30'),
(81, 'Sari', 131, 'Sangat aman, tidak ada kasus kriminal', '5.00', '2025-03-09 09:15:30'),
(82, 'Sari', 136, 'Ya, tersedia petugas keamanan 24 jam', '5.00', '2025-03-09 09:15:30'),
(83, 'Sari', 141, 'Sangat baik, ada prosedur darurat yang jelas', '5.00', '2025-03-09 09:15:30'),
(84, 'Sari', 146, 'Ya, tersedia layanan lengkap', '5.00', '2025-03-09 09:15:30'),
(85, 'Sari', 151, 'Tidak pernah ada kasus pungli', '5.00', '2025-03-09 09:15:30'),
(86, 'Sari', 156, 'Tidak ada biaya tambahan yang tidak resmi', '5.00', '2025-03-09 09:15:30'),
(87, 'Sari', 161, 'Sangat bersih dan terawat', '5.00', '2025-03-09 09:15:30'),
(88, 'Sari', 166, 'Sangat cukup, tidak ada antrean', '5.00', '2025-03-09 09:15:30'),
(89, 'Sari', 171, 'Gratis, tanpa biaya', '5.00', '2025-03-09 09:15:30'),
(90, 'Sari', 176, 'Sangat lengkap (air bersih, sabun, tisu, pengharum, dll.)', '5.00', '2025-03-09 09:15:30'),
(91, 'Sari', 181, 'Sangat cepat dan responsif', '5.00', '2025-03-09 09:15:30'),
(92, 'Sari', 186, 'Sangat luas, tidak pernah penuh', '5.00', '2025-03-09 09:15:30'),
(93, 'Sari', 191, 'Gratis, tidak ada biaya parkir', '5.00', '2025-03-09 09:15:30'),
(94, 'Sari', 196, 'Sangat aman, ada CCTV dan petugas 24 jam', '5.00', '2025-03-09 09:15:30'),
(95, 'Sari', 201, 'Tidak pernah terjadi kasus kehilangan', '5.00', '2025-03-09 09:15:30'),
(96, 'Sari', 206, 'Sangat dekat, langsung ke area wisata', '5.00', '2025-03-09 09:15:30'),
(97, 'Joko3', 26, 'Mobil pribadi atau rental', '5.00', '2025-03-09 09:19:09'),
(98, 'Joko3', 31, 'Sangat mudah (jalan besar, mulus, bisa dilalui semua kendaraan)', '5.00', '2025-03-09 09:19:09'),
(99, 'Joko3', 36, 'Jalan mulus dan lebar, tidak ada kendala', '5.00', '2025-03-09 09:19:09'),
(100, 'Joko3', 41, 'Ya, tersedia bus/angkot dengan biaya murah', '5.00', '2025-03-09 09:19:09'),
(101, 'Joko3', 46, 'Ya, tersedia shuttle gratis dari pengelola wisata', '5.00', '2025-03-09 09:19:09'),
(102, 'Joko3', 76, 'Sangat Murah (< Rp 10.000)', '5.00', '2025-03-09 09:19:09'),
(103, 'Joko3', 81, 'Ya, semua kategori harga tersedia', '5.00', '2025-03-09 09:19:09'),
(104, 'Joko3', 86, 'Ya, diperbolehkan tanpa batasan', '5.00', '2025-03-09 09:19:09'),
(105, 'Joko3', 91, 'Banyak restoran dengan makanan berkualitas dan beragam', '5.00', '2025-03-09 09:19:09'),
(106, 'Joko3', 96, 'Sangat baik (standar kesehatan tinggi, pengawasan ketat)', '5.00', '2025-03-09 09:19:09'),
(107, 'Joko3', 101, 'Sangat murah (< Rp 100.000/malam)', '5.00', '2025-03-09 09:19:09'),
(108, 'Joko3', 106, 'Ya, tersedia untuk semua anggaran', '5.00', '2025-03-09 09:19:09'),
(109, 'Joko3', 111, 'Sangat baik (fasilitas lengkap & modern)', '5.00', '2025-03-09 09:19:09'),
(110, 'Joko3', 116, 'Ya, tersedia banyak pilihan paket wisata', '5.00', '2025-03-09 09:19:09'),
(111, 'Joko3', 121, 'Ya, tersedia banyak fasilitas tambahan', '5.00', '2025-03-09 09:19:09'),
(112, 'Joko3', 126, 'Sangat aman, tanpa ada risiko', '5.00', '2025-03-09 09:19:09'),
(113, 'Joko3', 131, 'Sangat aman, tidak ada kasus kriminal', '5.00', '2025-03-09 09:19:09'),
(114, 'Joko3', 136, 'Ya, tersedia petugas keamanan 24 jam', '5.00', '2025-03-09 09:19:09'),
(115, 'Joko3', 141, 'Sangat baik, ada prosedur darurat yang jelas', '5.00', '2025-03-09 09:19:09'),
(116, 'Joko3', 146, 'Ya, tersedia layanan lengkap', '5.00', '2025-03-09 09:19:09'),
(117, 'Joko3', 151, 'Tidak pernah ada kasus pungli', '5.00', '2025-03-09 09:19:09'),
(118, 'Joko3', 156, 'Tidak ada biaya tambahan yang tidak resmi', '5.00', '2025-03-09 09:19:09'),
(119, 'Joko3', 161, 'Sangat bersih dan terawat', '5.00', '2025-03-09 09:19:09'),
(120, 'Joko3', 166, 'Sangat cukup, tidak ada antrean', '5.00', '2025-03-09 09:19:09'),
(121, 'Joko3', 171, 'Gratis, tanpa biaya', '5.00', '2025-03-09 09:19:09'),
(122, 'Joko3', 176, 'Sangat lengkap (air bersih, sabun, tisu, pengharum, dll.)', '5.00', '2025-03-09 09:19:09'),
(123, 'Joko3', 181, 'Sangat cepat dan responsif', '5.00', '2025-03-09 09:19:09'),
(124, 'Joko3', 186, 'Sangat luas, tidak pernah penuh', '5.00', '2025-03-09 09:19:09'),
(125, 'Joko3', 191, 'Gratis, tidak ada biaya parkir', '5.00', '2025-03-09 09:19:09'),
(126, 'Joko3', 196, 'Sangat aman, ada CCTV dan petugas 24 jam', '5.00', '2025-03-09 09:19:09'),
(127, 'Joko3', 201, 'Tidak pernah terjadi kasus kehilangan', '5.00', '2025-03-09 09:19:09'),
(128, 'Joko3', 206, 'Sangat dekat, langsung ke area wisata', '5.00', '2025-03-09 09:19:09'),
(129, 'Kiki', 26, 'Mobil pribadi atau rental', '5.00', '2025-03-09 09:19:54'),
(130, 'Kiki', 31, 'Sangat mudah (jalan besar, mulus, bisa dilalui semua kendaraan)', '5.00', '2025-03-09 09:19:54'),
(131, 'Kiki', 36, 'Jalan mulus dan lebar, tidak ada kendala', '5.00', '2025-03-09 09:19:54'),
(132, 'Kiki', 41, 'Ya, tersedia bus/angkot dengan biaya murah', '5.00', '2025-03-09 09:19:54'),
(133, 'Kiki', 46, 'Ya, tersedia shuttle gratis dari pengelola wisata', '5.00', '2025-03-09 09:19:54'),
(134, 'Kiki', 76, 'Sangat Murah (< Rp 10.000)', '5.00', '2025-03-09 09:19:54'),
(135, 'Kiki', 81, 'Ya, semua kategori harga tersedia', '5.00', '2025-03-09 09:19:54'),
(136, 'Kiki', 86, 'Ya, diperbolehkan tanpa batasan', '5.00', '2025-03-09 09:19:54'),
(137, 'Kiki', 91, 'Banyak restoran dengan makanan berkualitas dan beragam', '5.00', '2025-03-09 09:19:54'),
(138, 'Kiki', 96, 'Sangat baik (standar kesehatan tinggi, pengawasan ketat)', '5.00', '2025-03-09 09:19:54'),
(139, 'Kiki', 101, 'Sangat murah (< Rp 100.000/malam)', '5.00', '2025-03-09 09:19:54'),
(140, 'Kiki', 106, 'Ya, tersedia untuk semua anggaran', '5.00', '2025-03-09 09:19:54'),
(141, 'Kiki', 111, 'Sangat baik (fasilitas lengkap & modern)', '5.00', '2025-03-09 09:19:54'),
(142, 'Kiki', 116, 'Ya, tersedia banyak pilihan paket wisata', '5.00', '2025-03-09 09:19:54'),
(143, 'Kiki', 121, 'Ya, tersedia banyak fasilitas tambahan', '5.00', '2025-03-09 09:19:54'),
(144, 'Kiki', 126, 'Sangat aman, tanpa ada risiko', '5.00', '2025-03-09 09:19:54'),
(145, 'Kiki', 131, 'Sangat aman, tidak ada kasus kriminal', '5.00', '2025-03-09 09:19:54'),
(146, 'Kiki', 136, 'Ya, tersedia petugas keamanan 24 jam', '5.00', '2025-03-09 09:19:54'),
(147, 'Kiki', 141, 'Sangat baik, ada prosedur darurat yang jelas', '5.00', '2025-03-09 09:19:54'),
(148, 'Kiki', 146, 'Ya, tersedia layanan lengkap', '5.00', '2025-03-09 09:19:54'),
(149, 'Kiki', 151, 'Tidak pernah ada kasus pungli', '5.00', '2025-03-09 09:19:54'),
(150, 'Kiki', 156, 'Tidak ada biaya tambahan yang tidak resmi', '5.00', '2025-03-09 09:19:54'),
(151, 'Kiki', 161, 'Sangat bersih dan terawat', '5.00', '2025-03-09 09:19:54'),
(152, 'Kiki', 166, 'Sangat cukup, tidak ada antrean', '5.00', '2025-03-09 09:19:54'),
(153, 'Kiki', 171, 'Gratis, tanpa biaya', '5.00', '2025-03-09 09:19:55'),
(154, 'Kiki', 176, 'Sangat lengkap (air bersih, sabun, tisu, pengharum, dll.)', '5.00', '2025-03-09 09:19:55'),
(155, 'Kiki', 181, 'Sangat cepat dan responsif', '5.00', '2025-03-09 09:19:55'),
(156, 'Kiki', 186, 'Sangat luas, tidak pernah penuh', '5.00', '2025-03-09 09:19:55'),
(157, 'Kiki', 191, 'Gratis, tidak ada biaya parkir', '5.00', '2025-03-09 09:19:55'),
(158, 'Kiki', 196, 'Sangat aman, ada CCTV dan petugas 24 jam', '5.00', '2025-03-09 09:19:55'),
(159, 'Kiki', 201, 'Tidak pernah terjadi kasus kehilangan', '5.00', '2025-03-09 09:19:55'),
(160, 'Kiki', 206, 'Sangat dekat, langsung ke area wisata', '5.00', '2025-03-09 09:19:55');

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `bobot` decimal(5,2) NOT NULL,
  `jenis` enum('benefit','cost') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `nama`, `bobot`, `jenis`) VALUES
('K001', 'Kendaraan', '0.20', 'benefit'),
('K002', 'Biaya Makan', '0.15', 'cost'),
('K003', 'Biaya Fasilitas Penginapan', '0.15', 'cost'),
('K004', 'Keamanan', '0.20', 'benefit'),
('K005', 'Fasilitas Toilet', '0.15', 'benefit'),
('K006', 'Fasilitas Parkir', '0.15', 'benefit');

-- --------------------------------------------------------

--
-- Table structure for table `kuesioner`
--

CREATE TABLE `kuesioner` (
  `id_kuesioner` int NOT NULL,
  `id_kriteria` varchar(10) NOT NULL,
  `pertanyaan` text NOT NULL,
  `opsi_jawaban_pertanyaan` text NOT NULL,
  `bobot_opsi_jawaban_pertanyaan` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kuesioner`
--

INSERT INTO `kuesioner` (`id_kuesioner`, `id_kriteria`, `pertanyaan`, `opsi_jawaban_pertanyaan`, `bobot_opsi_jawaban_pertanyaan`) VALUES
(26, 'K001', 'Apa jenis kendaraan yang biasanya digunakan pengunjung untuk mencapai destinasi wisata di Berastagi?', 'Mobil pribadi atau rental', '5.00'),
(27, 'K001', 'Apa jenis kendaraan yang biasanya digunakan pengunjung untuk mencapai destinasi wisata di Berastagi?', 'Motor pribadi atau rental', '4.00'),
(28, 'K001', 'Apa jenis kendaraan yang biasanya digunakan pengunjung untuk mencapai destinasi wisata di Berastagi?', 'Bus atau travel umum', '3.00'),
(29, 'K001', 'Apa jenis kendaraan yang biasanya digunakan pengunjung untuk mencapai destinasi wisata di Berastagi?', 'Ojek atau angkutan umum (angkot, becak)', '2.00'),
(30, 'K001', 'Apa jenis kendaraan yang biasanya digunakan pengunjung untuk mencapai destinasi wisata di Berastagi?', 'Berjalan kaki atau bersepeda', '1.00'),
(31, 'K001', 'Apakah jalan menuju destinasi wisata mudah diakses oleh kendaraan pribadi, bus, atau sepeda motor?', 'Sangat mudah (jalan besar, mulus, bisa dilalui semua kendaraan)', '5.00'),
(32, 'K001', 'Apakah jalan menuju destinasi wisata mudah diakses oleh kendaraan pribadi, bus, atau sepeda motor?', 'Mudah (bisa dilalui kendaraan pribadi & transportasi umum)', '4.00'),
(33, 'K001', 'Apakah jalan menuju destinasi wisata mudah diakses oleh kendaraan pribadi, bus, atau sepeda motor?', 'Sedang (akses terbatas, beberapa kendaraan sulit masuk)', '3.00'),
(34, 'K001', 'Apakah jalan menuju destinasi wisata mudah diakses oleh kendaraan pribadi, bus, atau sepeda motor?', 'Sulit (hanya bisa dilewati kendaraan tertentu seperti jeep atau motor trail)', '2.00'),
(35, 'K001', 'Apakah jalan menuju destinasi wisata mudah diakses oleh kendaraan pribadi, bus, atau sepeda motor?', 'Sangat sulit (tidak bisa diakses kendaraan, harus trekking jauh)', '1.00'),
(36, 'K001', 'Bagaimana kondisi jalan menuju lokasi wisata? Apakah ada kendala seperti jalan rusak atau minim penerangan?', 'Jalan mulus dan lebar, tidak ada kendala', '5.00'),
(37, 'K001', 'Bagaimana kondisi jalan menuju lokasi wisata? Apakah ada kendala seperti jalan rusak atau minim penerangan?', 'Jalan cukup baik, ada beberapa bagian yang rusak ringan', '4.00'),
(38, 'K001', 'Bagaimana kondisi jalan menuju lokasi wisata? Apakah ada kendala seperti jalan rusak atau minim penerangan?', 'Jalan berbatu atau berlubang di beberapa titik, minim penerangan', '3.00'),
(39, 'K001', 'Bagaimana kondisi jalan menuju lokasi wisata? Apakah ada kendala seperti jalan rusak atau minim penerangan?', 'Jalan rusak parah dan minim penerangan, sulit diakses', '2.00'),
(40, 'K001', 'Bagaimana kondisi jalan menuju lokasi wisata? Apakah ada kendala seperti jalan rusak atau minim penerangan?', 'Tidak ada akses jalan, harus trekking atau menggunakan kendaraan off-road', '1.00'),
(41, 'K001', 'Apakah tersedia transportasi umum menuju destinasi wisata? Jika ya, apa saja pilihannya dan berapa biaya rata-rata?', 'Ya, tersedia bus/angkot dengan biaya murah', '5.00'),
(42, 'K001', 'Apakah tersedia transportasi umum menuju destinasi wisata? Jika ya, apa saja pilihannya dan berapa biaya rata-rata?', 'Ya, tersedia travel atau shuttle dengan biaya standar', '4.00'),
(43, 'K001', 'Apakah tersedia transportasi umum menuju destinasi wisata? Jika ya, apa saja pilihannya dan berapa biaya rata-rata?', 'Ya, tapi hanya ada ojek atau angkot terbatas', '3.00'),
(44, 'K001', 'Apakah tersedia transportasi umum menuju destinasi wisata? Jika ya, apa saja pilihannya dan berapa biaya rata-rata?', 'Tidak ada transportasi umum langsung ke lokasi, harus menggunakan kendaraan pribadi', '2.00'),
(45, 'K001', 'Apakah tersedia transportasi umum menuju destinasi wisata? Jika ya, apa saja pilihannya dan berapa biaya rata-rata?', 'Tidak tersedia transportasi umum sama sekali', '1.00'),
(46, 'K001', 'Apakah ada layanan shuttle atau kendaraan khusus yang disediakan oleh pengelola destinasi wisata?', 'Ya, tersedia shuttle gratis dari pengelola wisata', '5.00'),
(47, 'K001', 'Apakah ada layanan shuttle atau kendaraan khusus yang disediakan oleh pengelola destinasi wisata?', 'Ya, tersedia shuttle berbayar dengan harga terjangkau', '4.00'),
(48, 'K001', 'Apakah ada layanan shuttle atau kendaraan khusus yang disediakan oleh pengelola destinasi wisata?', 'Ada, tetapi hanya untuk tamu hotel tertentu', '3.00'),
(49, 'K001', 'Apakah ada layanan shuttle atau kendaraan khusus yang disediakan oleh pengelola destinasi wisata?', 'Tidak ada shuttle, tapi bisa menyewa kendaraan lokal', '2.00'),
(50, 'K001', 'Apakah ada layanan shuttle atau kendaraan khusus yang disediakan oleh pengelola destinasi wisata?', 'Tidak tersedia layanan shuttle sama sekali', '1.00'),
(76, 'K002', 'Berapa rata-rata biaya untuk makanan di destinasi wisata di Berastagi?', 'Sangat Murah (< Rp 10.000)', '5.00'),
(77, 'K002', 'Berapa rata-rata biaya untuk makanan di destinasi wisata di Berastagi?', 'Murah (Rp 10.000 - Rp 20.000)', '4.00'),
(78, 'K002', 'Berapa rata-rata biaya untuk makanan di destinasi wisata di Berastagi?', 'Sedang (Rp 20.000 - Rp 50.000)', '3.00'),
(79, 'K002', 'Berapa rata-rata biaya untuk makanan di destinasi wisata di Berastagi?', 'Mahal (Rp 50.000 - Rp 100.000)', '2.00'),
(80, 'K002', 'Berapa rata-rata biaya untuk makanan di destinasi wisata di Berastagi?', 'Sangat Mahal (> Rp 100.000)', '1.00'),
(81, 'K002', 'Apakah tersedia makanan dengan berbagai pilihan harga (murah, sedang, premium)?', 'Ya, semua kategori harga tersedia', '5.00'),
(82, 'K002', 'Apakah tersedia makanan dengan berbagai pilihan harga (murah, sedang, premium)?', 'Sebagian besar pilihan tersedia', '4.00'),
(83, 'K002', 'Apakah tersedia makanan dengan berbagai pilihan harga (murah, sedang, premium)?', 'Hanya makanan kategori sedang tersedia', '3.00'),
(84, 'K002', 'Apakah tersedia makanan dengan berbagai pilihan harga (murah, sedang, premium)?', 'Hanya makanan premium atau mahal tersedia', '2.00'),
(85, 'K002', 'Apakah tersedia makanan dengan berbagai pilihan harga (murah, sedang, premium)?', 'Tidak ada pilihan harga yang beragam', '1.00'),
(86, 'K002', 'Apakah pengunjung diperbolehkan membawa makanan sendiri tanpa dikenakan biaya tambahan?', 'Ya, diperbolehkan tanpa batasan', '5.00'),
(87, 'K002', 'Apakah pengunjung diperbolehkan membawa makanan sendiri tanpa dikenakan biaya tambahan?', 'Ya, tetapi ada batasan tertentu', '4.00'),
(88, 'K002', 'Apakah pengunjung diperbolehkan membawa makanan sendiri tanpa dikenakan biaya tambahan?', 'Hanya makanan ringan yang diperbolehkan', '3.00'),
(89, 'K002', 'Apakah pengunjung diperbolehkan membawa makanan sendiri tanpa dikenakan biaya tambahan?', 'Diperbolehkan dengan biaya tambahan', '2.00'),
(90, 'K002', 'Apakah pengunjung diperbolehkan membawa makanan sendiri tanpa dikenakan biaya tambahan?', 'Tidak diperbolehkan membawa makanan sendiri', '1.00'),
(91, 'K002', 'Apakah ada restoran atau warung di sekitar lokasi wisata? Jika ya, bagaimana kualitas dan variasi makanannya?', 'Banyak restoran dengan makanan berkualitas dan beragam', '5.00'),
(92, 'K002', 'Apakah ada restoran atau warung di sekitar lokasi wisata? Jika ya, bagaimana kualitas dan variasi makanannya?', 'Cukup banyak restoran dengan pilihan baik', '4.00'),
(93, 'K002', 'Apakah ada restoran atau warung di sekitar lokasi wisata? Jika ya, bagaimana kualitas dan variasi makanannya?', 'Hanya beberapa warung makan dengan menu terbatas', '3.00'),
(94, 'K002', 'Apakah ada restoran atau warung di sekitar lokasi wisata? Jika ya, bagaimana kualitas dan variasi makanannya?', 'Sangat sedikit pilihan makanan tersedia', '2.00'),
(95, 'K002', 'Apakah ada restoran atau warung di sekitar lokasi wisata? Jika ya, bagaimana kualitas dan variasi makanannya?', 'Tidak ada restoran atau warung di sekitar lokasi', '1.00'),
(96, 'K002', 'Bagaimana pengelola destinasi menjaga kebersihan dan keamanan makanan yang dijual?', 'Sangat baik (standar kesehatan tinggi, pengawasan ketat)', '5.00'),
(97, 'K002', 'Bagaimana pengelola destinasi menjaga kebersihan dan keamanan makanan yang dijual?', 'Baik (pembersihan rutin, pengawasan cukup)', '4.00'),
(98, 'K002', 'Bagaimana pengelola destinasi menjaga kebersihan dan keamanan makanan yang dijual?', 'Sedang (terkadang ada kendala kebersihan)', '3.00'),
(99, 'K002', 'Bagaimana pengelola destinasi menjaga kebersihan dan keamanan makanan yang dijual?', 'Kurang baik (sering ada keluhan kebersihan)', '2.00'),
(100, 'K002', 'Bagaimana pengelola destinasi menjaga kebersihan dan keamanan makanan yang dijual?', 'Sangat buruk (banyak keluhan terkait kebersihan)', '1.00'),
(101, 'K003', 'Berapa kisaran harga penginapan di sekitar destinasi wisata alam di Berastagi?', 'Sangat murah (< Rp 100.000/malam)', '5.00'),
(102, 'K003', 'Berapa kisaran harga penginapan di sekitar destinasi wisata alam di Berastagi?', 'Murah (Rp 100.000 - Rp 250.000/malam)', '4.00'),
(103, 'K003', 'Berapa kisaran harga penginapan di sekitar destinasi wisata alam di Berastagi?', 'Sedang (Rp 250.000 - Rp 500.000/malam)', '3.00'),
(104, 'K003', 'Berapa kisaran harga penginapan di sekitar destinasi wisata alam di Berastagi?', 'Mahal (Rp 500.000 - Rp 1.000.000/malam)', '2.00'),
(105, 'K003', 'Berapa kisaran harga penginapan di sekitar destinasi wisata alam di Berastagi?', 'Sangat mahal (> Rp 1.000.000/malam)', '1.00'),
(106, 'K003', 'Apakah ada penginapan yang sesuai dengan anggaran backpacker (low-budget) maupun keluarga (mid-to-high budget)?', 'Ya, tersedia untuk semua anggaran', '5.00'),
(107, 'K003', 'Apakah ada penginapan yang sesuai dengan anggaran backpacker (low-budget) maupun keluarga (mid-to-high budget)?', 'Sebagian besar tersedia untuk semua anggaran', '4.00'),
(108, 'K003', 'Apakah ada penginapan yang sesuai dengan anggaran backpacker (low-budget) maupun keluarga (mid-to-high budget)?', 'Hanya tersedia untuk kelas menengah ke atas', '3.00'),
(109, 'K003', 'Apakah ada penginapan yang sesuai dengan anggaran backpacker (low-budget) maupun keluarga (mid-to-high budget)?', 'Hanya tersedia untuk kelas premium', '2.00'),
(110, 'K003', 'Apakah ada penginapan yang sesuai dengan anggaran backpacker (low-budget) maupun keluarga (mid-to-high budget)?', 'Tidak tersedia pilihan penginapan yang sesuai anggaran', '1.00'),
(111, 'K003', 'Bagaimana kualitas fasilitas yang ditawarkan oleh hotel atau penginapan di dekat destinasi wisata?', 'Sangat baik (fasilitas lengkap & modern)', '5.00'),
(112, 'K003', 'Bagaimana kualitas fasilitas yang ditawarkan oleh hotel atau penginapan di dekat destinasi wisata?', 'Baik (fasilitas cukup lengkap)', '4.00'),
(113, 'K003', 'Bagaimana kualitas fasilitas yang ditawarkan oleh hotel atau penginapan di dekat destinasi wisata?', 'Sedang (fasilitas standar, cukup nyaman)', '3.00'),
(114, 'K003', 'Bagaimana kualitas fasilitas yang ditawarkan oleh hotel atau penginapan di dekat destinasi wisata?', 'Kurang baik (fasilitas terbatas & kurang nyaman)', '2.00'),
(115, 'K003', 'Bagaimana kualitas fasilitas yang ditawarkan oleh hotel atau penginapan di dekat destinasi wisata?', 'Sangat buruk (banyak keluhan terkait fasilitas)', '1.00'),
(116, 'K003', 'Apakah hotel/penginapan menyediakan paket wisata ke destinasi tertentu?', 'Ya, tersedia banyak pilihan paket wisata', '5.00'),
(117, 'K003', 'Apakah hotel/penginapan menyediakan paket wisata ke destinasi tertentu?', 'Ya, ada beberapa paket wisata', '4.00'),
(118, 'K003', 'Apakah hotel/penginapan menyediakan paket wisata ke destinasi tertentu?', 'Hanya tersedia paket wisata tertentu', '3.00'),
(119, 'K003', 'Apakah hotel/penginapan menyediakan paket wisata ke destinasi tertentu?', 'Hanya tersedia transportasi menuju lokasi wisata', '2.00'),
(120, 'K003', 'Apakah hotel/penginapan menyediakan paket wisata ke destinasi tertentu?', 'Tidak menyediakan paket wisata', '1.00'),
(121, 'K003', 'Apakah hotel di sekitar lokasi wisata menawarkan fasilitas tambahan seperti transportasi ke destinasi wisata atau sarapan gratis?', 'Ya, tersedia banyak fasilitas tambahan', '5.00'),
(122, 'K003', 'Apakah hotel di sekitar lokasi wisata menawarkan fasilitas tambahan seperti transportasi ke destinasi wisata atau sarapan gratis?', 'Ya, tersedia fasilitas tambahan terbatas', '4.00'),
(123, 'K003', 'Apakah hotel di sekitar lokasi wisata menawarkan fasilitas tambahan seperti transportasi ke destinasi wisata atau sarapan gratis?', 'Hanya tersedia fasilitas dasar seperti WiFi', '3.00'),
(124, 'K003', 'Apakah hotel di sekitar lokasi wisata menawarkan fasilitas tambahan seperti transportasi ke destinasi wisata atau sarapan gratis?', 'Hanya beberapa fasilitas tambahan yang tersedia', '2.00'),
(125, 'K003', 'Apakah hotel di sekitar lokasi wisata menawarkan fasilitas tambahan seperti transportasi ke destinasi wisata atau sarapan gratis?', 'Tidak ada fasilitas tambahan yang disediakan', '1.00'),
(126, 'K004', 'Bagaimana tingkat keamanan di lokasi wisata, terutama saat malam hari?', 'Sangat aman, tanpa ada risiko', '5.00'),
(127, 'K004', 'Bagaimana tingkat keamanan di lokasi wisata, terutama saat malam hari?', 'Aman, dengan pengawasan yang cukup', '4.00'),
(128, 'K004', 'Bagaimana tingkat keamanan di lokasi wisata, terutama saat malam hari?', 'Cukup aman, tetapi ada beberapa risiko', '3.00'),
(129, 'K004', 'Bagaimana tingkat keamanan di lokasi wisata, terutama saat malam hari?', 'Kurang aman, sering terjadi gangguan', '2.00'),
(130, 'K004', 'Bagaimana tingkat keamanan di lokasi wisata, terutama saat malam hari?', 'Tidak aman, sering terjadi insiden', '1.00'),
(131, 'K004', 'Apakah pengunjung merasa aman dari gangguan seperti pencurian, tindakan kriminal, atau gangguan lainnya?', 'Sangat aman, tidak ada kasus kriminal', '5.00'),
(132, 'K004', 'Apakah pengunjung merasa aman dari gangguan seperti pencurian, tindakan kriminal, atau gangguan lainnya?', 'Aman, sangat jarang terjadi kasus', '4.00'),
(133, 'K004', 'Apakah pengunjung merasa aman dari gangguan seperti pencurian, tindakan kriminal, atau gangguan lainnya?', 'Cukup aman, ada kasus tetapi tidak sering', '3.00'),
(134, 'K004', 'Apakah pengunjung merasa aman dari gangguan seperti pencurian, tindakan kriminal, atau gangguan lainnya?', 'Kurang aman, kasus sering terjadi', '2.00'),
(135, 'K004', 'Apakah pengunjung merasa aman dari gangguan seperti pencurian, tindakan kriminal, atau gangguan lainnya?', 'Tidak aman, banyak laporan kriminal', '1.00'),
(136, 'K004', 'Apakah ada petugas keamanan yang berjaga secara rutin di lokasi wisata?', 'Ya, tersedia petugas keamanan 24 jam', '5.00'),
(137, 'K004', 'Apakah ada petugas keamanan yang berjaga secara rutin di lokasi wisata?', 'Ya, ada petugas tetapi tidak selalu', '4.00'),
(138, 'K004', 'Apakah ada petugas keamanan yang berjaga secara rutin di lokasi wisata?', 'Ada, tetapi jumlahnya terbatas', '3.00'),
(139, 'K004', 'Apakah ada petugas keamanan yang berjaga secara rutin di lokasi wisata?', 'Tidak ada petugas tetap, hanya sesekali', '2.00'),
(140, 'K004', 'Apakah ada petugas keamanan yang berjaga secara rutin di lokasi wisata?', 'Tidak ada petugas keamanan sama sekali', '1.00'),
(141, 'K004', 'Bagaimana pengelola menangani situasi darurat, seperti kecelakaan, bencana alam, atau insiden lainnya?', 'Sangat baik, ada prosedur darurat yang jelas', '5.00'),
(142, 'K004', 'Bagaimana pengelola menangani situasi darurat, seperti kecelakaan, bencana alam, atau insiden lainnya?', 'Baik, dengan sistem yang cukup baik', '4.00'),
(143, 'K004', 'Bagaimana pengelola menangani situasi darurat, seperti kecelakaan, bencana alam, atau insiden lainnya?', 'Cukup baik, tetapi ada beberapa kekurangan', '3.00'),
(144, 'K004', 'Bagaimana pengelola menangani situasi darurat, seperti kecelakaan, bencana alam, atau insiden lainnya?', 'Kurang baik, banyak kekurangan dalam sistem', '2.00'),
(145, 'K004', 'Bagaimana pengelola menangani situasi darurat, seperti kecelakaan, bencana alam, atau insiden lainnya?', 'Sangat buruk, tidak ada prosedur yang jelas', '1.00'),
(146, 'K004', 'Apakah tersedia layanan bantuan seperti pos pertolongan pertama, pos polisi, atau hotline darurat yang mudah diakses?', 'Ya, tersedia layanan lengkap', '5.00'),
(147, 'K004', 'Apakah tersedia layanan bantuan seperti pos pertolongan pertama, pos polisi, atau hotline darurat yang mudah diakses?', 'Ya, tetapi hanya beberapa layanan', '4.00'),
(148, 'K004', 'Apakah tersedia layanan bantuan seperti pos pertolongan pertama, pos polisi, atau hotline darurat yang mudah diakses?', 'Cukup tersedia, tetapi sulit diakses', '3.00'),
(149, 'K004', 'Apakah tersedia layanan bantuan seperti pos pertolongan pertama, pos polisi, atau hotline darurat yang mudah diakses?', 'Hanya ada sedikit layanan bantuan', '2.00'),
(150, 'K004', 'Apakah tersedia layanan bantuan seperti pos pertolongan pertama, pos polisi, atau hotline darurat yang mudah diakses?', 'Tidak ada layanan bantuan yang tersedia', '1.00'),
(151, 'K004', 'Apakah pernah terjadi kasus pungutan liar (pungli) di lokasi wisata? Jika ya, bagaimana pengelola atau pihak berwenang menanganinya?', 'Tidak pernah ada kasus pungli', '5.00'),
(152, 'K004', 'Apakah pernah terjadi kasus pungutan liar (pungli) di lokasi wisata? Jika ya, bagaimana pengelola atau pihak berwenang menanganinya?', 'Jarang terjadi, tetapi ditangani dengan baik', '4.00'),
(153, 'K004', 'Apakah pernah terjadi kasus pungutan liar (pungli) di lokasi wisata? Jika ya, bagaimana pengelola atau pihak berwenang menanganinya?', 'Cukup sering terjadi, penanganannya kurang baik', '3.00'),
(154, 'K004', 'Apakah pernah terjadi kasus pungutan liar (pungli) di lokasi wisata? Jika ya, bagaimana pengelola atau pihak berwenang menanganinya?', 'Sering terjadi, tetapi hanya sedikit penanganan', '2.00'),
(155, 'K004', 'Apakah pernah terjadi kasus pungutan liar (pungli) di lokasi wisata? Jika ya, bagaimana pengelola atau pihak berwenang menanganinya?', 'Sangat sering terjadi, dan tidak ada penanganan', '1.00'),
(156, 'K004', 'Apakah pengunjung diwajibkan membayar biaya tambahan yang tidak resmi, seperti untuk masuk kawasan tertentu atau parkir?', 'Tidak ada biaya tambahan yang tidak resmi', '5.00'),
(157, 'K004', 'Apakah pengunjung diwajibkan membayar biaya tambahan yang tidak resmi, seperti untuk masuk kawasan tertentu atau parkir?', 'Jarang ada, dan bisa ditolak', '4.00'),
(158, 'K004', 'Apakah pengunjung diwajibkan membayar biaya tambahan yang tidak resmi, seperti untuk masuk kawasan tertentu atau parkir?', 'Cukup sering, tetapi tidak terlalu mahal', '3.00'),
(159, 'K004', 'Apakah pengunjung diwajibkan membayar biaya tambahan yang tidak resmi, seperti untuk masuk kawasan tertentu atau parkir?', 'Sering terjadi, sulit dihindari', '2.00'),
(160, 'K004', 'Apakah pengunjung diwajibkan membayar biaya tambahan yang tidak resmi, seperti untuk masuk kawasan tertentu atau parkir?', 'Sangat sering terjadi, dan sangat merugikan', '1.00'),
(161, 'K005', 'Bagaimana kondisi toilet umum di destinasi wisata? Apakah kebersihannya terjaga?', 'Sangat bersih dan terawat', '5.00'),
(162, 'K005', 'Bagaimana kondisi toilet umum di destinasi wisata? Apakah kebersihannya terjaga?', 'Bersih, tetapi perlu perawatan lebih', '4.00'),
(163, 'K005', 'Bagaimana kondisi toilet umum di destinasi wisata? Apakah kebersihannya terjaga?', 'Cukup bersih, tetapi sering kotor saat ramai', '3.00'),
(164, 'K005', 'Bagaimana kondisi toilet umum di destinasi wisata? Apakah kebersihannya terjaga?', 'Kurang bersih, sering ditemukan kotoran', '2.00'),
(165, 'K005', 'Bagaimana kondisi toilet umum di destinasi wisata? Apakah kebersihannya terjaga?', 'Sangat kotor dan tidak terawat', '1.00'),
(166, 'K005', 'Apakah fasilitas toilet tersedia dalam jumlah yang cukup untuk menampung jumlah pengunjung, terutama saat musim liburan?', 'Sangat cukup, tidak ada antrean', '5.00'),
(167, 'K005', 'Apakah fasilitas toilet tersedia dalam jumlah yang cukup untuk menampung jumlah pengunjung, terutama saat musim liburan?', 'Cukup, tetapi kadang antre', '4.00'),
(168, 'K005', 'Apakah fasilitas toilet tersedia dalam jumlah yang cukup untuk menampung jumlah pengunjung, terutama saat musim liburan?', 'Sedang, sering antre saat ramai', '3.00'),
(169, 'K005', 'Apakah fasilitas toilet tersedia dalam jumlah yang cukup untuk menampung jumlah pengunjung, terutama saat musim liburan?', 'Kurang, sering penuh saat ramai', '2.00'),
(170, 'K005', 'Apakah fasilitas toilet tersedia dalam jumlah yang cukup untuk menampung jumlah pengunjung, terutama saat musim liburan?', 'Sangat kurang, antre panjang', '1.00'),
(171, 'K005', 'Apakah pengunjung dikenakan biaya untuk menggunakan toilet umum? Jika ya, berapa biayanya?', 'Gratis, tanpa biaya', '5.00'),
(172, 'K005', 'Apakah pengunjung dikenakan biaya untuk menggunakan toilet umum? Jika ya, berapa biayanya?', 'Murah (Rp 1.000 - Rp 2.000)', '4.00'),
(173, 'K005', 'Apakah pengunjung dikenakan biaya untuk menggunakan toilet umum? Jika ya, berapa biayanya?', 'Sedang (Rp 2.000 - Rp 5.000)', '3.00'),
(174, 'K005', 'Apakah pengunjung dikenakan biaya untuk menggunakan toilet umum? Jika ya, berapa biayanya?', 'Mahal (Rp 5.000 - Rp 10.000)', '2.00'),
(175, 'K005', 'Apakah pengunjung dikenakan biaya untuk menggunakan toilet umum? Jika ya, berapa biayanya?', 'Sangat mahal (> Rp 10.000)', '1.00'),
(176, 'K005', 'Apakah toilet dilengkapi dengan air bersih, sabun, dan fasilitas lain yang memadai?', 'Sangat lengkap (air bersih, sabun, tisu, pengharum, dll.)', '5.00'),
(177, 'K005', 'Apakah toilet dilengkapi dengan air bersih, sabun, dan fasilitas lain yang memadai?', 'Lengkap, tetapi kadang kehabisan stok', '4.00'),
(178, 'K005', 'Apakah toilet dilengkapi dengan air bersih, sabun, dan fasilitas lain yang memadai?', 'Cukup tersedia, tetapi terbatas', '3.00'),
(179, 'K005', 'Apakah toilet dilengkapi dengan air bersih, sabun, dan fasilitas lain yang memadai?', 'Kurang, sering tidak tersedia', '2.00'),
(180, 'K005', 'Apakah toilet dilengkapi dengan air bersih, sabun, dan fasilitas lain yang memadai?', 'Sangat kurang, hanya ada air', '1.00'),
(181, 'K005', 'Bagaimana pengelola menangani keluhan terkait kebersihan atau kerusakan toilet?', 'Sangat cepat dan responsif', '5.00'),
(182, 'K005', 'Bagaimana pengelola menangani keluhan terkait kebersihan atau kerusakan toilet?', 'Cepat, tetapi kadang terlambat', '4.00'),
(183, 'K005', 'Bagaimana pengelola menangani keluhan terkait kebersihan atau kerusakan toilet?', 'Cukup, tetapi perlu perbaikan lebih lanjut', '3.00'),
(184, 'K005', 'Bagaimana pengelola menangani keluhan terkait kebersihan atau kerusakan toilet?', 'Lambat, sering dibiarkan', '2.00'),
(185, 'K005', 'Bagaimana pengelola menangani keluhan terkait kebersihan atau kerusakan toilet?', 'Tidak ditangani sama sekali', '1.00'),
(186, 'K006', 'Apakah area parkir di destinasi wisata cukup luas untuk menampung kendaraan pengunjung?', 'Sangat luas, tidak pernah penuh', '5.00'),
(187, 'K006', 'Apakah area parkir di destinasi wisata cukup luas untuk menampung kendaraan pengunjung?', 'Luas, tetapi bisa penuh saat musim liburan', '4.00'),
(188, 'K006', 'Apakah area parkir di destinasi wisata cukup luas untuk menampung kendaraan pengunjung?', 'Cukup, tetapi sering penuh', '3.00'),
(189, 'K006', 'Apakah area parkir di destinasi wisata cukup luas untuk menampung kendaraan pengunjung?', 'Kurang luas, sering kesulitan mencari tempat', '2.00'),
(190, 'K006', 'Apakah area parkir di destinasi wisata cukup luas untuk menampung kendaraan pengunjung?', 'Sangat sempit, sulit untuk parkir', '1.00'),
(191, 'K006', 'Berapa biaya parkir yang dikenakan untuk kendaraan pribadi, sepeda motor, atau bus?', 'Gratis, tidak ada biaya parkir', '5.00'),
(192, 'K006', 'Berapa biaya parkir yang dikenakan untuk kendaraan pribadi, sepeda motor, atau bus?', 'Murah (Rp 2.000 - Rp 5.000)', '4.00'),
(193, 'K006', 'Berapa biaya parkir yang dikenakan untuk kendaraan pribadi, sepeda motor, atau bus?', 'Sedang (Rp 5.000 - Rp 10.000)', '3.00'),
(194, 'K006', 'Berapa biaya parkir yang dikenakan untuk kendaraan pribadi, sepeda motor, atau bus?', 'Mahal (Rp 10.000 - Rp 20.000)', '2.00'),
(195, 'K006', 'Berapa biaya parkir yang dikenakan untuk kendaraan pribadi, sepeda motor, atau bus?', 'Sangat mahal (> Rp 20.000)', '1.00'),
(196, 'K006', 'Bagaimana sistem keamanan di area parkir? Apakah ada CCTV atau petugas yang berjaga?', 'Sangat aman, ada CCTV dan petugas 24 jam', '5.00'),
(197, 'K006', 'Bagaimana sistem keamanan di area parkir? Apakah ada CCTV atau petugas yang berjaga?', 'Aman, ada petugas yang berjaga', '4.00'),
(198, 'K006', 'Bagaimana sistem keamanan di area parkir? Apakah ada CCTV atau petugas yang berjaga?', 'Cukup aman, tetapi pengawasan kurang', '3.00'),
(199, 'K006', 'Bagaimana sistem keamanan di area parkir? Apakah ada CCTV atau petugas yang berjaga?', 'Kurang aman, hanya ada beberapa CCTV', '2.00'),
(200, 'K006', 'Bagaimana sistem keamanan di area parkir? Apakah ada CCTV atau petugas yang berjaga?', 'Tidak ada pengawasan sama sekali', '1.00'),
(201, 'K006', 'Apakah pernah terjadi masalah keamanan, seperti kehilangan kendaraan atau barang, di area parkir?', 'Tidak pernah terjadi kasus kehilangan', '5.00'),
(202, 'K006', 'Apakah pernah terjadi masalah keamanan, seperti kehilangan kendaraan atau barang, di area parkir?', 'Jarang terjadi, tetapi ada pengawasan', '4.00'),
(203, 'K006', 'Apakah pernah terjadi masalah keamanan, seperti kehilangan kendaraan atau barang, di area parkir?', 'Kadang terjadi, tetapi penanganannya cukup baik', '3.00'),
(204, 'K006', 'Apakah pernah terjadi masalah keamanan, seperti kehilangan kendaraan atau barang, di area parkir?', 'Sering terjadi, tetapi jarang tertangani', '2.00'),
(205, 'K006', 'Apakah pernah terjadi masalah keamanan, seperti kehilangan kendaraan atau barang, di area parkir?', 'Sangat sering terjadi, dan tidak ada penanganan', '1.00'),
(206, 'K006', 'Apakah lokasi parkir dekat dengan area wisata atau membutuhkan transportasi tambahan?', 'Sangat dekat, langsung ke area wisata', '5.00'),
(207, 'K006', 'Apakah lokasi parkir dekat dengan area wisata atau membutuhkan transportasi tambahan?', 'Dekat, hanya berjalan kaki sebentar', '4.00'),
(208, 'K006', 'Apakah lokasi parkir dekat dengan area wisata atau membutuhkan transportasi tambahan?', 'Cukup jauh, tetapi masih bisa ditempuh berjalan kaki', '3.00'),
(209, 'K006', 'Apakah lokasi parkir dekat dengan area wisata atau membutuhkan transportasi tambahan?', 'Jauh, membutuhkan kendaraan tambahan', '2.00'),
(210, 'K006', 'Apakah lokasi parkir dekat dengan area wisata atau membutuhkan transportasi tambahan?', 'Sangat jauh, tidak ada akses langsung ke wisata', '1.00');

-- --------------------------------------------------------

--
-- Table structure for table `matrix`
--

CREATE TABLE `matrix` (
  `id_matrix` int NOT NULL,
  `id_alternatif` int NOT NULL,
  `id_kriteria` varchar(10) DEFAULT NULL,
  `nilai` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `matrix`
--

INSERT INTO `matrix` (`id_matrix`, `id_alternatif`, `id_kriteria`, `nilai`) VALUES
(331, 1, 'K001', '4.50'),
(332, 1, 'K002', '4.50'),
(333, 1, 'K003', '4.50'),
(334, 1, 'K004', '4.50'),
(335, 1, 'K005', '4.50'),
(336, 1, 'K006', '4.50'),
(337, 2, 'K001', '5.00'),
(338, 2, 'K002', '5.00'),
(339, 2, 'K003', '5.00'),
(340, 2, 'K004', '5.00'),
(341, 2, 'K005', '5.00'),
(342, 2, 'K006', '5.00'),
(343, 3, 'K001', '5.00'),
(344, 3, 'K002', '5.00'),
(345, 3, 'K003', '5.00'),
(346, 3, 'K004', '5.00'),
(347, 3, 'K005', '5.00'),
(348, 3, 'K006', '5.00'),
(349, 4, 'K001', '4.50'),
(350, 4, 'K002', '4.50'),
(351, 4, 'K003', '4.50'),
(352, 4, 'K004', '4.50'),
(353, 4, 'K005', '4.50'),
(354, 4, 'K006', '4.50'),
(355, 5, 'K001', '5.00'),
(356, 5, 'K002', '5.00'),
(357, 5, 'K003', '5.00'),
(358, 5, 'K004', '5.00'),
(359, 5, 'K005', '5.00'),
(360, 5, 'K006', '5.00');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_rekomendasi`
--

CREATE TABLE `riwayat_rekomendasi` (
  `id_riwayat` int NOT NULL,
  `nama_user` varchar(30) NOT NULL,
  `rekomendasi` text NOT NULL,
  `tanggal` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `riwayat_rekomendasi`
--

INSERT INTO `riwayat_rekomendasi` (`id_riwayat`, `nama_user`, `rekomendasi`, `tanggal`) VALUES
(10, 'Sari', '[{\"id_alternatif\":1,\"nama_wisata\":\"Danau Lau Kawar\",\"nilai\":0},{\"id_alternatif\":2,\"nama_wisata\":\"Gunung Sibayak\",\"nilai\":0},{\"id_alternatif\":3,\"nama_wisata\":\"Air Terjun Sipiso-Piso\",\"nilai\":0}]', '2025-03-09 09:15:30'),
(11, 'Joko3', '[{\"id_alternatif\":2,\"nama_wisata\":\"Gunung Sibayak\",\"nilai\":0.6250000000000001},{\"id_alternatif\":3,\"nama_wisata\":\"Air Terjun Sipiso-Piso\",\"nilai\":0.6250000000000001},{\"id_alternatif\":5,\"nama_wisata\":\"Air Panas Lau Sidebuk-Debuk\",\"nilai\":0.6250000000000001}]', '2025-03-09 09:19:10'),
(12, 'Kiki', '[{\"id_alternatif\":2,\"nama_wisata\":\"Gunung Sibayak\",\"nilai\":0.6250000000000001},{\"id_alternatif\":3,\"nama_wisata\":\"Air Terjun Sipiso-Piso\",\"nilai\":0.6250000000000001},{\"id_alternatif\":5,\"nama_wisata\":\"Air Panas Lau Sidebuk-Debuk\",\"nilai\":0.6250000000000001}]', '2025-03-09 09:19:55');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_users` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_users`, `email`, `username`, `password`, `level`) VALUES
(1, 'admin@gmail.com', 'admin', 'admin', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`id_alternatif`);

--
-- Indexes for table `jawaban_user`
--
ALTER TABLE `jawaban_user`
  ADD PRIMARY KEY (`id_jawaban`),
  ADD KEY `id_kuesioner` (`id_kuesioner`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indexes for table `kuesioner`
--
ALTER TABLE `kuesioner`
  ADD PRIMARY KEY (`id_kuesioner`),
  ADD KEY `id_kriteria` (`id_kriteria`);

--
-- Indexes for table `matrix`
--
ALTER TABLE `matrix`
  ADD PRIMARY KEY (`id_matrix`),
  ADD KEY `id_alternatif` (`id_alternatif`),
  ADD KEY `matrix_ibfk_2` (`id_kriteria`);

--
-- Indexes for table `riwayat_rekomendasi`
--
ALTER TABLE `riwayat_rekomendasi`
  ADD PRIMARY KEY (`id_riwayat`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_users`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alternatif`
--
ALTER TABLE `alternatif`
  MODIFY `id_alternatif` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jawaban_user`
--
ALTER TABLE `jawaban_user`
  MODIFY `id_jawaban` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `kuesioner`
--
ALTER TABLE `kuesioner`
  MODIFY `id_kuesioner` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;

--
-- AUTO_INCREMENT for table `matrix`
--
ALTER TABLE `matrix`
  MODIFY `id_matrix` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=361;

--
-- AUTO_INCREMENT for table `riwayat_rekomendasi`
--
ALTER TABLE `riwayat_rekomendasi`
  MODIFY `id_riwayat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_users` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jawaban_user`
--
ALTER TABLE `jawaban_user`
  ADD CONSTRAINT `jawaban_user_ibfk_1` FOREIGN KEY (`id_kuesioner`) REFERENCES `kuesioner` (`id_kuesioner`) ON DELETE CASCADE;

--
-- Constraints for table `kuesioner`
--
ALTER TABLE `kuesioner`
  ADD CONSTRAINT `kuesioner_ibfk_1` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE;

--
-- Constraints for table `matrix`
--
ALTER TABLE `matrix`
  ADD CONSTRAINT `matrix_ibfk_1` FOREIGN KEY (`id_alternatif`) REFERENCES `alternatif` (`id_alternatif`) ON DELETE CASCADE,
  ADD CONSTRAINT `matrix_ibfk_2` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
