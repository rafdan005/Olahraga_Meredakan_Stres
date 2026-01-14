-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2026 at 06:16 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webdailyjournal`
--

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `judul` text CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `isi` text CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `gambar` text CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `tanggal` datetime NOT NULL DEFAULT current_timestamp(),
  `username` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id`, `judul`, `isi`, `gambar`, `tanggal`, `username`) VALUES
(11, 'Jogging', 'Jogging sangat efektif untuk meredakan stres karena memicu respons kimiawi dan psikologis dalam tubuh. Saat Anda bergerak, tubuh akan melepaskan hormon kebahagiaan yang membantu memperbaiki suasana hati sekaligus mengalihkan pikiran dari hal-hal yang memicu stres.', 'jogging.jpg', '2025-12-30 11:40:09', 'admin'),
(12, 'Yoga', 'Yoga bermanfaat untuk meredakan stres karena menggabungkan teknik pernapasan, meditasi, dan gerakan fisik untuk menenangkan pikiran dan tubuh. Latihan ini membantu menurunkan kadar hormon stres (kortisol) dan meningkatkan hormon kebahagiaan (endorfin), mengurangi ketegangan fisik dan mental, serta meningkatkan kualitas tidur.', 'Yoga.jpeg', '2025-12-30 11:40:09', 'admin'),
(13, 'Bersepeda', 'Bersepeda memiliki banyak manfaat untuk meredakan stres, baik secara fisik maupun mental. Aktivitas ini dapat menjadi cara efektif untuk menenangkan pikiran, meningkatkan suasana hati, dan mengurangi hormon stres dalam tubuh.', 'Bersepeda.jpg', '2025-12-30 11:40:09', 'admin'),
(14, 'Berenang', 'Berenang sangat efektif untuk meredakan stres melalui beberapa mekanisme, baik fisik maupun mental. Aktivitas ini memicu pelepasan hormon bahagia dan memberikan efek menenangkan seperti terapi air.', 'Berenang.jpg', '2025-12-30 11:40:09', 'admin'),
(15, 'Menari', 'Manfaat menari yang dapat mengurangi stres adalah tumbuhnya kontak dan hubungan dengan orang lain. Misalnya ketika kamu berusaha menyamakan ritme dengan gerakan musik, semua itu akan mengalihkan pikiran dari berbagai masalah dan membuat otak kembali berpikir jernih.', 'Menari.jpg', '2025-12-30 11:40:09', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `foto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `foto`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
