-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2019 at 09:11 AM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smig_survey`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('adminsurvey@semenindonesia.com', 'bfe857804f7ffab6c272a745c82e4eada39210b0');

-- --------------------------------------------------------

--
-- Table structure for table `bidang`
--

CREATE TABLE `bidang` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bidang`
--

INSERT INTO `bidang` (`id`, `nama`) VALUES
(1, 'Pemasaran'),
(2, 'Sumber Daya Manusia');

-- --------------------------------------------------------

--
-- Table structure for table `departemen`
--

CREATE TABLE `departemen` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(40) NOT NULL,
  `id_bidang` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `departemen`
--

INSERT INTO `departemen` (`id`, `nama`, `id_bidang`) VALUES
(1, 'Perencanaan Pemasaran', 1),
(2, 'Penjualan', 1),
(3, 'Pengembangan SDM Grup', 2),
(4, 'Hukum dan Manajemen Resiko', 2),
(5, 'Sarana Umum', 2);

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `nama` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id`, `nama`) VALUES
(0, 'perusahaan'),
(1, 'bidang'),
(2, 'departemen'),
(3, 'unit');

-- --------------------------------------------------------

--
-- Table structure for table `survey`
--

CREATE TABLE `survey` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_author` int(10) UNSIGNED NOT NULL,
  `judul` varchar(50) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `jumlah_pertanyaan` int(11) NOT NULL,
  `batas_pengisian` date NOT NULL,
  `id_level_responden` tinyint(3) UNSIGNED NOT NULL,
  `id_penempatan_responden` int(10) UNSIGNED NOT NULL,
  `waktu_pembuatan` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `survey`
--

INSERT INTO `survey` (`id`, `id_author`, `judul`, `deskripsi`, `jumlah_pertanyaan`, `batas_pengisian`, `id_level_responden`, `id_penempatan_responden`, `waktu_pembuatan`, `status`) VALUES
(1, 57342, 'judul', 'deskripsi', 2, '1999-06-27', 2, 1, '2019-06-24 02:08:06', 0),
(2, 57342, 'Survey Mahasiswa UM', 'ini deskripsi tentang survey mahasiswa um', 2, '2019-06-27', 0, 0, '2019-06-24 03:41:49', 0),
(3, 57342, 'judul 1', 'deskripsi 1', 2, '2019-06-29', 1, 1, '2019-06-25 07:00:01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `survey_pertanyaan`
--

CREATE TABLE `survey_pertanyaan` (
  `id_survey` int(10) UNSIGNED NOT NULL,
  `nomor` int(10) UNSIGNED NOT NULL,
  `pertanyaan` varchar(255) NOT NULL,
  `jenis_pertanyaan` enum('Essay','Pilihan','Checkbox','Range') NOT NULL,
  `gambar` tinyint(1) NOT NULL,
  `array_option` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `survey_pertanyaan`
--

INSERT INTO `survey_pertanyaan` (`id_survey`, `nomor`, `pertanyaan`, `jenis_pertanyaan`, `gambar`, `array_option`) VALUES
(1, 1, 'essay1', 'Essay', 0, 'a:0:{}'),
(1, 2, 'ganda2', 'Pilihan', 0, 'a:3:{i:0;s:7:\"opsi2.1\";i:1;s:7:\"opsi2.2\";i:2;s:7:\"opsi2.3\";}'),
(2, 1, 'Siapa nama rektor UM', 'Pilihan', 0, 'a:3:{i:0;s:7:\"Pak Aji\";i:1;s:8:\"Bu Shofi\";i:2;s:14:\"Pak Rofi\'uddin\";}'),
(2, 2, 'Kapan istirahat?', 'Essay', 0, 'a:0:{}'),
(3, 1, 'essay', 'Essay', 0, 'a:0:{}'),
(3, 2, 'pertanyaanganda', 'Pilihan', 0, 'a:3:{i:0;s:7:\"opsi2.1\";i:1;s:7:\"opsi2.2\";i:2;s:7:\"opsi2.3\";}');

-- --------------------------------------------------------

--
-- Table structure for table `survey_responden`
--

CREATE TABLE `survey_responden` (
  `token` varchar(255) NOT NULL,
  `id_survey` int(10) UNSIGNED NOT NULL,
  `id_responden` int(10) UNSIGNED NOT NULL,
  `status_pengisian` tinyint(1) NOT NULL,
  `email_sent` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `survey_responden`
--

INSERT INTO `survey_responden` (`token`, `id_survey`, `id_responden`, `status_pengisian`, `email_sent`) VALUES
('5dacfe5961cef422d223e71d893100d10903feb1', 3, 82012, 0, 1),
('a623aedbccb1c84a7bb7ef3ff9b3714a433b6d01', 3, 57342, 0, 1),
('bc5b0676b854e68635be16440bed45c4a1e8f28f', 3, 73245, 0, 1),
('eecd4bcfd4830981ca89adb836a5b3aa0445337f', 3, 76349, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `survey_responden_jawaban`
--

CREATE TABLE `survey_responden_jawaban` (
  `id_token` varchar(255) NOT NULL,
  `nomor` int(10) UNSIGNED NOT NULL,
  `array_jawaban` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama` varchar(50) NOT NULL,
  `id_departemen` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id`, `nama`, `id_departemen`) VALUES
(1, 'Rencana', 1),
(2, 'Persiapan', 1),
(3, 'Berkembang', 3),
(4, 'Survey', 3),
(5, 'Peralatan', 5);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_level` tinyint(3) UNSIGNED NOT NULL,
  `id_penempatan` int(10) UNSIGNED NOT NULL,
  `jabatan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `email`, `password`, `id_level`, `id_penempatan`, `jabatan`) VALUES
(57342, 'Amat Pria Darma', 'az_ndu@yahoo.co.id', '7ffe1aefb204d22814264293ca9ab7dcc3d71147', 1, 1, 'Direktur'),
(73245, 'Prasetya Utomo', 'rizqiirfan23@gmail.com', 'fb19d583c53e486ebb7a4669da6519fcf0ba142d', 1, 1, 'Sekretaris'),
(76349, 'Bambang Djoko S', 'moch_hidayat68@yahoo.co.id', '98becfb9553ea96eae7bb63c5b3465c3a03b3ba8', 2, 1, 'Kepala'),
(82012, 'Eko Rudy Nurcahyanto', 'anaspandu1628@gmail.com', 'f0ecb094d4f03452d8ccefce2beef2448986055e', 2, 1, 'Staff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bidang`
--
ALTER TABLE `bidang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departemen`
--
ALTER TABLE `departemen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_bagian` (`id_bidang`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey`
--
ALTER TABLE `survey`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_author` (`id_author`),
  ADD KEY `id_departemen_responden` (`id_penempatan_responden`),
  ADD KEY `id_level_responden` (`id_level_responden`);

--
-- Indexes for table `survey_pertanyaan`
--
ALTER TABLE `survey_pertanyaan`
  ADD KEY `id_survey` (`id_survey`);

--
-- Indexes for table `survey_responden`
--
ALTER TABLE `survey_responden`
  ADD PRIMARY KEY (`token`),
  ADD KEY `id_survey` (`id_survey`),
  ADD KEY `id_responden` (`id_responden`);

--
-- Indexes for table `survey_responden_jawaban`
--
ALTER TABLE `survey_responden_jawaban`
  ADD KEY `id_token` (`id_token`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_departemen` (`id_departemen`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_departemen` (`id_penempatan`),
  ADD KEY `id_level` (`id_level`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bidang`
--
ALTER TABLE `bidang`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `departemen`
--
ALTER TABLE `departemen`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `survey`
--
ALTER TABLE `survey`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `departemen`
--
ALTER TABLE `departemen`
  ADD CONSTRAINT `departemen_ibfk_1` FOREIGN KEY (`id_bidang`) REFERENCES `bidang` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `survey`
--
ALTER TABLE `survey`
  ADD CONSTRAINT `survey_ibfk_3` FOREIGN KEY (`id_author`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `survey_ibfk_4` FOREIGN KEY (`id_level_responden`) REFERENCES `level` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `survey_pertanyaan`
--
ALTER TABLE `survey_pertanyaan`
  ADD CONSTRAINT `survey_pertanyaan_ibfk_1` FOREIGN KEY (`id_survey`) REFERENCES `survey` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `survey_responden`
--
ALTER TABLE `survey_responden`
  ADD CONSTRAINT `survey_responden_ibfk_3` FOREIGN KEY (`id_survey`) REFERENCES `survey` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `survey_responden_ibfk_4` FOREIGN KEY (`id_responden`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `survey_responden_jawaban`
--
ALTER TABLE `survey_responden_jawaban`
  ADD CONSTRAINT `survey_responden_jawaban_ibfk_1` FOREIGN KEY (`id_token`) REFERENCES `survey_responden` (`token`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `unit`
--
ALTER TABLE `unit`
  ADD CONSTRAINT `unit_ibfk_1` FOREIGN KEY (`id_departemen`) REFERENCES `departemen` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`id_level`) REFERENCES `level` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
