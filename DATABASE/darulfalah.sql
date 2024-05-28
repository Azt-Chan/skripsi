-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 28, 2024 at 12:53 PM
-- Server version: 5.7.39
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `darulfalah`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_training`
--

CREATE TABLE `data_training` (
  `id` int(11) NOT NULL,
  `sains` decimal(10,0) NOT NULL COMMENT '81-90, 71-80, 61-70',
  `math` decimal(10,0) NOT NULL COMMENT '81-90, 71-80, 61-70',
  `bindo` decimal(10,0) NOT NULL COMMENT '81-90, 71-80, 61-70',
  `bing` decimal(10,0) NOT NULL COMMENT '81-90, 71-80, 61-70',
  `ips` decimal(10,0) NOT NULL COMMENT '81-90, 71-80, 61-70',
  `aqidah` decimal(10,0) NOT NULL COMMENT '81-90, 71-80, 61-70',
  `nilai_akhir` decimal(10,0) DEFAULT NULL,
  `terbaik` varchar(10) NOT NULL COMMENT 'Ya / Tidak'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data_uji`
--

CREATE TABLE `data_uji` (
  `id` int(11) NOT NULL,
  `instansi` varchar(10) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `jurusan` varchar(20) DEFAULT NULL,
  `rata_un` double DEFAULT NULL,
  `kerja` varchar(10) DEFAULT NULL,
  `motivasi` varchar(20) DEFAULT NULL,
  `ipk_asli` varchar(10) DEFAULT NULL,
  `ipk_prediksi` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_uji`
--

INSERT INTO `data_uji` (`id`, `instansi`, `status`, `jurusan`, `rata_un`, `kerja`, `motivasi`, `ipk_asli`, `ipk_prediksi`) VALUES
(1, 'SMA', 'Negeri', 'IPA', 8.13, 'Sudah', 'Sendiri', 'Tinggi', 'Tinggi'),
(2, 'SMA', 'Swasta', 'IPA', 8.4, 'Belum', 'Orang Lain', 'Tinggi', 'Tinggi'),
(3, 'MA', 'Negeri', 'IPA', 7.91, 'Sudah', 'Sendiri', 'Tinggi', 'Tinggi'),
(4, 'SMA', 'Negeri', 'IPS', 8.4, 'Sudah', 'Sendiri', 'Tinggi', 'Tinggi'),
(5, 'SMA', 'Swasta', 'IPS', 6.75, 'Sudah', 'Sendiri', 'Tinggi', 'Tinggi'),
(6, 'SMK', 'Negeri', 'Teknik', 8.23, 'Sudah', 'Sendiri', 'Rendah', 'Rendah'),
(7, 'SMK', 'Swasta', 'Teknik', 7.7, 'Belum', 'Sendiri', 'Tinggi', 'Rendah'),
(8, 'SMK', 'Swasta', 'Teknik', 7.9, 'Sudah', 'Sendiri', 'Rendah', 'Rendah'),
(9, 'SMA', 'Negeri', 'IPS', 8.21, 'Belum', 'Orang Tua', 'Rendah', 'Rendah'),
(10, 'SMA', 'Negeri', 'IPA', 8.55, 'Sudah', 'Sendiri', 'Tinggi', 'Tinggi'),
(11, 'SMK', 'Swasta', 'Teknik', 8.45, 'Sudah', 'Sendiri', 'Tinggi', 'Tinggi'),
(12, 'SMK', 'Swasta', 'Teknik', 7, 'Belum', 'Sendiri', 'Rendah', 'Tinggi'),
(13, 'SMA', 'Swasta', 'IPA', 7.93, 'Belum', 'Sendiri', 'Tinggi', 'Tinggi'),
(14, 'MA', 'Swasta', 'IPS', 7.8, 'Belum', 'Sendiri', 'Tinggi', 'Tinggi'),
(15, 'MA', 'Swasta', 'IPA', 8.48, 'Belum', 'Sendiri', 'Tinggi', 'Tinggi'),
(16, 'SMA', 'Swasta', 'Bahasa', 7.86, 'Belum', 'Sendiri', 'Tinggi', 'Tinggi'),
(17, 'SMA', 'Swasta', 'IPA', 8.22, 'Belum', 'Orang Lain', 'Tinggi', 'Tinggi'),
(18, 'SMK', 'Swasta', 'Teknik', 8.39, 'Belum', 'Sendiri', 'Tinggi', 'Tinggi'),
(19, 'SMA', 'Swasta', 'IPA', 8.78, 'Sudah', 'Sendiri', 'Rendah', 'Tinggi'),
(20, 'MA', 'Negeri', 'IPS', 7.9, 'Belum', 'Sendiri', 'Tinggi', 'Tinggi'),
(21, 'MA', 'Negeri', 'IPA', 7.89, 'Belum', 'Sendiri', 'Tinggi', 'Tinggi'),
(22, 'SMK', 'Swasta', 'Teknik', 7.63, 'Sudah', 'Orang Tua', 'Rendah', 'Rendah'),
(23, 'SMA', 'Swasta', 'IPA', 8.73, 'Sudah', 'Sendiri', 'Tinggi', 'Tinggi'),
(24, 'MA', 'Swasta', 'IPA', 7.5, 'Belum', 'Orang Lain', 'Tinggi', 'Tinggi'),
(25, 'SMK', 'Negeri', 'Teknik', 8.3, 'Sudah', 'Sendiri', 'Rendah', 'Rendah'),
(26, 'SMK', 'Swasta', 'Administrasi', 7.59, 'Belum', 'Sendiri', 'Rendah', 'Rendah'),
(27, 'SMA', 'Swasta', 'IPA', 8.1, 'Sudah', 'Sendiri', 'Tinggi', 'Tinggi'),
(28, 'SMK', 'Negeri', 'Teknik', 7.5, 'Belum', 'Sendiri', 'Rendah', 'Rendah'),
(29, 'SMA', 'Negeri', 'IPA', 8.3, 'Sudah', 'Orang Tua', 'Tinggi', 'Tinggi'),
(30, 'SMK', 'Swasta', 'Teknik', 7.69, 'Sudah', 'Sendiri', 'Rendah', 'Rendah');

-- --------------------------------------------------------

--
-- Table structure for table `gain`
--

CREATE TABLE `gain` (
  `id` int(11) NOT NULL,
  `atribut` varchar(20) DEFAULT NULL,
  `gain` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gain`
--

INSERT INTO `gain` (`id`, `atribut`, `gain`) VALUES
(1, 'kerja', 0.016),
(2, 'rata UN posisi 6.5', 0),
(3, 'rata UN posisi 6.75', 0),
(4, 'rata UN posisi 7', 0),
(5, 'rata UN posisi 7.25', 0),
(6, 'rata UN posisi 7.5', 0.016),
(7, 'rata UN posisi 7.75', 0.004),
(8, 'rata UN posisi 8', 0.072),
(9, 'rata UN posisi 8.25', 0.016),
(10, 'rata UN posisi 8.5', 0.016),
(11, 'rata UN posisi 8.75', 0);

-- --------------------------------------------------------

--
-- Table structure for table `hasil_prediksi`
--

CREATE TABLE `hasil_prediksi` (
  `id` int(11) NOT NULL,
  `nim` varchar(15) DEFAULT NULL,
  `instansi` varchar(10) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `jurusan` varchar(20) DEFAULT NULL,
  `rata_un` double DEFAULT NULL,
  `kerja` varchar(10) DEFAULT NULL,
  `motivasi` varchar(20) DEFAULT NULL,
  `hasil` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hasil_prediksi`
--

INSERT INTO `hasil_prediksi` (`id`, `nim`, `instansi`, `status`, `jurusan`, `rata_un`, `kerja`, `motivasi`, `hasil`) VALUES
(9, '14622001', 'SMA', 'Swasta', 'IPS', 7.8, 'Belum', 'OrangLain', 'Rendah'),
(13, '14621009', 'SMK', 'Swasta', 'Teknik', 7, 'Sudah', 'OrangTua', 'Tinggi'),
(14, '14621015', 'SMK', 'Negeri', 'Teknik', 8.9, 'Belum', 'Sendiri', 'Rendah'),
(19, '14621003', 'SMA', 'Swasta', 'IPA', 7.8, 'Belum', 'Sendiri', 'Tinggi'),
(20, '14621001', 'SMA', 'Swasta', 'IPA', 7.8, 'Belum', 'Sendiri', 'Tinggi'),
(21, '14621002', 'SMA', 'Swasta', 'Teknik', 9, 'Sudah', 'Sendiri', 'Tinggi'),
(22, '14621004', 'SMK', 'Negeri', 'Bahasa', 9, 'Belum', 'Sendiri', 'Tinggi'),
(23, '14621005', 'SMK', 'Swasta', 'Teknik', 9, 'Belum', 'Sendiri', 'Tinggi');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `nim` varchar(15) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `jenis_kelamin` char(1) DEFAULT NULL,
  `angkatan` varchar(5) DEFAULT NULL,
  `kelas` varchar(10) DEFAULT NULL,
  `nis` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`nim`, `nama`, `jenis_kelamin`, `angkatan`, `kelas`, `nis`) VALUES
('14622001', 'rizki', 'L', '20', 'A', '14622001');

-- --------------------------------------------------------

--
-- Table structure for table `pohon_keputusan`
--

CREATE TABLE `pohon_keputusan` (
  `id` int(11) NOT NULL,
  `parent` text,
  `akar` text,
  `keputusan` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rasio_gain`
--

CREATE TABLE `rasio_gain` (
  `id` int(11) NOT NULL,
  `opsi` varchar(10) DEFAULT NULL,
  `cabang1` varchar(50) DEFAULT NULL,
  `cabang2` varchar(50) DEFAULT NULL,
  `rasio_gain` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rasio_gain`
--

INSERT INTO `rasio_gain` (`id`, `opsi`, `cabang1`, `cabang2`, `rasio_gain`) VALUES
(1, 'opsi1', 'IPS', 'IPA , Teknik', 0.065),
(2, 'opsi2', 'IPA', 'Teknik , IPS', 0.056),
(3, 'opsi3', 'Teknik', 'IPS , IPA', 0.057);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` varchar(25) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `password` text,
  `type` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `nama`, `password`, `type`) VALUES
('admin', 'Administrator', 'adminadmin', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_training`
--
ALTER TABLE `data_training`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_uji`
--
ALTER TABLE `data_uji`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gain`
--
ALTER TABLE `gain`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hasil_prediksi`
--
ALTER TABLE `hasil_prediksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`nim`);

--
-- Indexes for table `pohon_keputusan`
--
ALTER TABLE `pohon_keputusan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rasio_gain`
--
ALTER TABLE `rasio_gain`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_training`
--
ALTER TABLE `data_training`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_uji`
--
ALTER TABLE `data_uji`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `gain`
--
ALTER TABLE `gain`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `hasil_prediksi`
--
ALTER TABLE `hasil_prediksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `pohon_keputusan`
--
ALTER TABLE `pohon_keputusan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rasio_gain`
--
ALTER TABLE `rasio_gain`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
