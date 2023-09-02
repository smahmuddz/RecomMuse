-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 02, 2023 at 08:17 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recommuse`
--

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `artist` varchar(255) NOT NULL,
  `album` varchar(255) DEFAULT NULL,
  `music` varchar(255) DEFAULT NULL,
  `coverImage` varchar(255) DEFAULT NULL,
  `genre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`id`, `name`, `artist`, `album`, `music`, `coverImage`, `genre`) VALUES
(23, 'Chaleya', 'Arijit Singh', 'Jawan', 'music\\Chaleya Jawan 128 Kbps.mp3', 'img\\musicCovers\\CHALEYA.jpg', 'POP'),
(24, 'Sanu Ek Pal', 'Madhur Sharma', 'Raid', 'music\\Sanu Ek Pal Madhur Sharma 128 Kbps.mp3', 'img\\musicCovers\\Sanu-Ek-Pal-Madhur-Sharma.jpg', 'POP'),
(25, 'Thriller', 'Michael Jackson', 'Thriller', 'music\\Thriller Michael Jackson.mp3', 'img\\musicCovers\\Michael_Jackson_-_Thriller.png', 'Disco'),
(26, 'Billie Jean', 'Michael Jackson', 'Thriller', 'music\\Billie Jean Michael Jackson 128 Kbps.mp3', 'img\\musicCovers\\Michael_Jackson_-_Thriller.png', 'Disco'),
(27, 'Pehli Mohabbat', 'Darshan Raval', 'India\'s Raw Star', 'music\\Pehli Mohabbat.mp3', 'img\\musicCovers\\Pheli-Mohabbat-Hindi-2014-20210623202025-500x500.jpg', 'POP'),
(28, 'Perfect', 'Ed Sheeran', 'Divide', 'music\\Perfect(Mr-Jatt1.com).mp3', 'img\\musicCovers\\perfect.jpg', 'POP'),
(29, 'Shape of you', 'Ed Sheeran', 'Divide', 'music\\Ed Sheeran - Shape of You(Mr-Jatt1.com).mp3', 'img\\musicCovers\\shape of you.png', 'POP'),
(30, 'No Promises', 'Shayne Ward', 'Shayne Ward', 'music\\Shayne Ward - No Promises (Video).mp3', 'img\\musicCovers\\No promises.jpg', 'Pop'),
(31, 'Ian and Sylvia - Four Strong Winds', 'Sylvia Fricker', 'Four Strong Winds', 'music\\Ian and Sylvia - Four Strong Winds (CBC TV 1986).mp3', 'img\\musicCovers\\Four Strong Winds.jpg', 'Folk'),
(32, 'Ekla Cholo Re Song', 'Amitabh Bachchan', 'Kahaani', 'music\\Ekla Cholo Re Song  Kahaani  Amitabh Bachchan.mp3', 'img\\musicCovers\\ekla cholo re.jpg', 'Folk'),
(33, 'Tum Agar Manaoge', 'Darshan Raval', 'Shershah', 'music\\Tum-Agar-Manoge(PaglaSongs).mp3', 'img\\musicCovers\\tum agar manaoge.jpg', 'Romantic');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
