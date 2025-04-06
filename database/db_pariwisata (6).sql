-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 06, 2025 at 07:25 AM
-- Server version: 8.0.30
-- PHP Version: 7.4.1

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
(1, 'Budi', 214, 'Sangat Baik (Jalan mulus, transportasi lengkap)', '5.00', '2025-04-06 07:21:56'),
(2, 'Budi', 219, 'Sangat Terjangkau (< Rp 10.000 per porsi)', '5.00', '2025-04-06 07:21:56'),
(3, 'Budi', 224, 'Sangat Terjangkau (< Rp 100.000 per malam)', '5.00', '2025-04-06 07:21:56'),
(4, 'Budi', 229, 'Sangat Aman (pengawasan 24 jam, tidak ada kasus kriminal)', '5.00', '2025-04-06 07:21:56'),
(5, 'Budi', 234, 'Sangat Baik (sangat bersih, lengkap dengan perlengkapan)', '5.00', '2025-04-06 07:21:56'),
(6, 'Budi', 239, 'Sangat Baik (luas, aman, gratis/murah)', '5.00', '2025-04-06 07:21:56'),
(7, 'Sari', 214, 'Sangat Baik (Jalan mulus, transportasi lengkap)', '5.00', '2025-04-06 07:24:28'),
(8, 'Sari', 219, 'Sangat Terjangkau (< Rp 10.000 per porsi)', '5.00', '2025-04-06 07:24:28'),
(9, 'Sari', 224, 'Sangat Terjangkau (< Rp 100.000 per malam)', '5.00', '2025-04-06 07:24:28'),
(10, 'Sari', 229, 'Sangat Aman (pengawasan 24 jam, tidak ada kasus kriminal)', '5.00', '2025-04-06 07:24:28'),
(11, 'Sari', 234, 'Sangat Baik (sangat bersih, lengkap dengan perlengkapan)', '5.00', '2025-04-06 07:24:28'),
(12, 'Sari', 239, 'Sangat Baik (luas, aman, gratis/murah)', '5.00', '2025-04-06 07:24:28');

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
(214, 'K001', 'Kondisi Jalan/Transportasi', 'Sangat Baik (Jalan mulus, transportasi lengkap)', '5.00'),
(215, 'K001', 'Kondisi Jalan/Transportasi', 'Baik (Jalan cukup baik, transportasi memadai)', '4.00'),
(216, 'K001', 'Kondisi Jalan/Transportasi', 'Cukup (Jalan sedang, transportasi terbatas)', '3.00'),
(217, 'K001', 'Kondisi Jalan/Transportasi', 'Kurang Baik (Jalan rusak, minim transportasi)', '2.00'),
(218, 'K001', 'Kondisi Jalan/Transportasi', 'Buruk (Tidak ada akses jalan yang baik)', '1.00'),
(219, 'K002', 'Biaya Makan', 'Sangat Terjangkau (< Rp 10.000 per porsi)', '5.00'),
(220, 'K002', 'Biaya Makan', 'Terjangkau (Rp 10.000 - Rp 25.000 per porsi)', '4.00'),
(221, 'K002', 'Biaya Makan', 'Standar (Rp 25.000 - Rp 50.000 per porsi)', '3.00'),
(222, 'K002', 'Biaya Makan', 'Mahal (Rp 50.000 - Rp 100.000 per porsi)', '2.00'),
(223, 'K002', 'Biaya Makan', 'Sangat Mahal (> Rp 100.000 per porsi)', '1.00'),
(224, 'K003', 'Biaya Fasilitas Penginapan', 'Sangat Terjangkau (< Rp 100.000 per malam)', '5.00'),
(225, 'K003', 'Biaya Fasilitas Penginapan', 'Terjangkau (Rp 100.000 - Rp 250.000 per malam)', '4.00'),
(226, 'K003', 'Biaya Fasilitas Penginapan', 'Standar (Rp 250.000 - Rp 500.000 per malam)', '3.00'),
(227, 'K003', 'Biaya Fasilitas Penginapan', 'Mahal (Rp 500.000 - Rp 1.000.000 per malam)', '2.00'),
(228, 'K003', 'Biaya Fasilitas Penginapan', 'Sangat Mahal (> Rp 1.000.000 per malam)', '1.00'),
(229, 'K004', 'Keamanan', 'Sangat Aman (pengawasan 24 jam, tidak ada kasus kriminal)', '5.00'),
(230, 'K004', 'Keamanan', 'Aman (petugas keamanan rutin, jarang terjadi insiden)', '4.00'),
(231, 'K004', 'Keamanan', 'Cukup Aman (pengawasan terbatas, kadang terjadi insiden kecil)', '3.00'),
(232, 'K004', 'Keamanan', 'Kurang Aman (minim pengawasan, sering terjadi gangguan)', '2.00'),
(233, 'K004', 'Keamanan', 'Tidak Aman (tidak ada pengawasan, banyak kasus kriminal)', '1.00'),
(234, 'K005', 'Fasilitas Toilet', 'Sangat Baik (sangat bersih, lengkap dengan perlengkapan)', '5.00'),
(235, 'K005', 'Fasilitas Toilet', 'Baik (bersih, cukup lengkap)', '4.00'),
(236, 'K005', 'Fasilitas Toilet', 'Cukup (cukup bersih, fasilitas standar)', '3.00'),
(237, 'K005', 'Fasilitas Toilet', 'Kurang (kotor, fasilitas minim)', '2.00'),
(238, 'K005', 'Fasilitas Toilet', 'Buruk (sangat kotor, tidak terawat)', '1.00'),
(239, 'K006', 'Fasilitas Parkir', 'Sangat Baik (luas, aman, gratis/murah)', '5.00'),
(240, 'K006', 'Fasilitas Parkir', 'Baik (cukup luas, ada petugas jaga)', '4.00'),
(241, 'K006', 'Fasilitas Parkir', 'Cukup (memadai untuk kendaraan umum, biaya standar)', '3.00'),
(242, 'K006', 'Fasilitas Parkir', 'Kurang (sempit, biaya mahal, keamanan minim)', '2.00'),
(243, 'K006', 'Fasilitas Parkir', 'Buruk (sangat terbatas, tidak ada pengawasan)', '1.00');

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
(91, 1, 'K001', '4.40'),
(92, 1, 'K002', '4.14'),
(93, 1, 'K003', '4.14'),
(94, 1, 'K004', '4.40'),
(95, 1, 'K005', '4.36'),
(96, 1, 'K006', '4.36'),
(97, 2, 'K001', '4.65'),
(98, 2, 'K002', '4.39'),
(99, 2, 'K003', '4.39'),
(100, 2, 'K004', '4.65'),
(101, 2, 'K005', '4.61'),
(102, 2, 'K006', '4.61'),
(103, 3, 'K001', '4.90'),
(104, 3, 'K002', '4.64'),
(105, 3, 'K003', '4.64'),
(106, 3, 'K004', '4.90'),
(107, 3, 'K005', '4.86'),
(108, 3, 'K006', '4.86'),
(109, 4, 'K001', '5.00'),
(110, 4, 'K002', '4.89'),
(111, 4, 'K003', '4.89'),
(112, 4, 'K004', '5.00'),
(113, 4, 'K005', '5.00'),
(114, 4, 'K006', '5.00'),
(115, 5, 'K001', '4.15'),
(116, 5, 'K002', '3.89'),
(117, 5, 'K003', '3.89'),
(118, 5, 'K004', '4.15'),
(119, 5, 'K005', '4.11'),
(120, 5, 'K006', '4.11');

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
(39, 'Sari', '[{\"id_alternatif\":3,\"nama_wisata\":\"Air Terjun Sipiso-Piso\",\"nilai\":0.6118668151499633},{\"id_alternatif\":4,\"nama_wisata\":\"Bukit Gundaling\",\"nilai\":0.5783489628685632},{\"id_alternatif\":2,\"nama_wisata\":\"Gunung Sibayak\",\"nilai\":0.5510853516082521}]', '2025-04-06 07:24:28');

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
  MODIFY `id_jawaban` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `kuesioner`
--
ALTER TABLE `kuesioner`
  MODIFY `id_kuesioner` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=244;

--
-- AUTO_INCREMENT for table `matrix`
--
ALTER TABLE `matrix`
  MODIFY `id_matrix` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `riwayat_rekomendasi`
--
ALTER TABLE `riwayat_rekomendasi`
  MODIFY `id_riwayat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

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
