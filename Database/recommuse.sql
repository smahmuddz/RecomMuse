-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 05, 2023 at 05:57 PM
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
-- Table structure for table `albums`
--

CREATE TABLE `albums` (
  `id` int(11) NOT NULL,
  `album_name` varchar(255) NOT NULL,
  `artist_name` varchar(255) NOT NULL,
  `album_cover_link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`id`, `album_name`, `artist_name`, `album_cover_link`) VALUES
(1, 'Jawan', 'Arijit Singh', 'img\\albumcovers\\jawan.jpg'),
(2, 'Raid', 'Madhur Sharma', 'img\\albumcovers\\raid.jpg'),
(3, 'Thriller', 'Michael Jackson', 'img\\albumcovers\\thriller.jpg'),
(4, 'India\'s Raw Star', 'Darshan Raval', 'img\\albumcovers\\rawstar.jpg'),
(5, 'Divide', 'Ed Sheeran', 'img\\albumcovers\\divide.png'),
(6, 'Shayne Ward', 'Shayne Ward', 'img\\albumcovers\\Shayne_Ward_-_Shayne_Ward_(2006).jpg'),
(7, 'Four Strong Winds', 'Sylvia Fricker', 'img\\albumcovers\\four strong winds.jpg'),
(8, 'Kahaani', 'Amitabh Bacchan', 'img\\albumcovers\\kahaani.jpg'),
(9, 'Shershah', 'Darshan Raval', 'img\\albumcovers\\Shershaah_soundtrack.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`id`, `name`, `image`) VALUES
(1, 'Arijit Singh', 'img\\artistimages\\arijit singh.jpg'),
(2, 'Madhur Sharma', 'img\\artistimages\\madhur_sharma.jpg'),
(3, 'Michael Jackson', 'img\\artistimages\\mj.jpg'),
(4, 'Darshan Raval', 'img\\artistimages\\darshan raval.jpg'),
(5, 'Ed Sheeran', 'img\\artistimages\\ed_sheeran.png'),
(6, 'Shayne Ward', 'img\\artistimages\\shayne.jpg'),
(7, 'Sylvia Fricker', 'img\\artistimages\\sylvia.jpg'),
(9, 'Balam', 'img\\albumcovers\\balam.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `liked_songs`
--

CREATE TABLE `liked_songs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL,
  `liked` tinyint(1) NOT NULL,
  `unliked` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `liked_songs`
--

INSERT INTO `liked_songs` (`id`, `user_id`, `song_id`, `liked`, `unliked`) VALUES
(1, 7, 26, 1, 0),
(2, 7, 23, 0, 1),
(3, 7, 32, 0, 1),
(4, 7, 31, 1, 0),
(5, 7, 30, 1, 0),
(6, 7, 24, 0, 1),
(7, 7, 33, 1, 0),
(8, 9, 26, 1, 0),
(9, 9, 23, 0, 1),
(10, 9, 32, 0, 0),
(11, 9, 31, 1, 0),
(12, 9, 30, 1, 0),
(13, 7, 27, 1, 0),
(14, 7, 34, 0, 1),
(15, 7, 35, 1, 0);

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
  `genre` varchar(255) DEFAULT NULL,
  `language` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`id`, `name`, `artist`, `album`, `music`, `coverImage`, `genre`, `language`) VALUES
(23, 'Chaleya', 'Arijit Singh', 'Jawan', 'music\\Chaleya Jawan 128 Kbps.mp3', 'img\\musicCovers\\CHALEYA.jpg', 'POP', 'Hindi'),
(24, 'Sanu Ek Pal', 'Madhur Sharma', 'Raid', 'music\\Sanu Ek Pal Madhur Sharma 128 Kbps.mp3', 'img\\musicCovers\\Sanu-Ek-Pal-Madhur-Sharma.jpg', 'POP', 'Hindi'),
(25, 'Thriller', 'Michael Jackson', 'Thriller', 'music\\Thriller Michael Jackson.mp3', 'img\\musicCovers\\Michael_Jackson_-_Thriller.png', 'Disco', 'English'),
(26, 'Billie Jean', 'Michael Jackson', 'Thriller', 'music\\Billie Jean Michael Jackson 128 Kbps.mp3', 'img\\musicCovers\\Michael_Jackson_-_Thriller.png', 'Disco', 'English'),
(27, 'Pehli Mohabbat', 'Darshan Raval', 'India\'s Raw Star', 'music\\Pehli Mohabbat.mp3', 'img\\musicCovers\\Pheli-Mohabbat-Hindi-2014-20210623202025-500x500.jpg', 'POP', 'Hindi'),
(28, 'Perfect', 'Ed Sheeran', 'Divide', 'music\\Perfect(Mr-Jatt1.com).mp3', 'img\\musicCovers\\perfect.jpg', 'POP', 'English'),
(29, 'Shape of you', 'Ed Sheeran', 'Divide', 'music\\Ed Sheeran - Shape of You(Mr-Jatt1.com).mp3', 'img\\musicCovers\\shape of you.png', 'POP', 'English'),
(30, 'No Promises', 'Shayne Ward', 'Shayne Ward', 'music\\Shayne Ward - No Promises (Video).mp3', 'img\\musicCovers\\No promises.jpg', 'Pop', 'English'),
(31, 'Four Strong Winds', 'Sylvia Fricker', 'Four Strong Winds', 'music\\Ian and Sylvia - Four Strong Winds (CBC TV 1986).mp3', 'img\\musicCovers\\Four Strong Winds.jpg', 'Folk', 'English'),
(32, 'Ekla Cholo Re Song', 'Amitabh Bachchan', 'Kahaani', 'music\\Ekla Cholo Re Song  Kahaani  Amitabh Bachchan.mp3', 'img\\musicCovers\\ekla cholo re.jpg', 'Folk', 'Bangla'),
(33, 'Tum Agar Manaoge', 'Darshan Raval', 'Shershah', 'music\\Tum-Agar-Manoge(PaglaSongs).mp3', 'img\\musicCovers\\tum agar manaoge.jpg', 'Romantic', 'Hindi'),
(34, 'Balam - Ashar Nichachol', 'Balam', 'BALAM', 'music\\Ashar Nichachol.mp3', 'img\\musicCovers\\balam.jpg', 'Pop', 'Bangla'),
(35, 'Balam - Lukochuri', 'Balam', 'BALAM', 'music\\Lukochuri.mp3', 'img\\musicCovers\\balam.jpg', 'Pop', 'Bangla'),
(36, 'Balam - Rupkotha', 'Balam', 'BALAM', 'music\\Rupkotha.mp3', 'img\\musicCovers\\balam.jpg', 'Pop', 'Bangla');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `uid` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `profile_image`, `uid`) VALUES
(7, 'smahmuddz@gmail.com', '$2y$10$B0U5eG8jdf4nHrY7AemyJucoDAwN4pSkbDkmoXezU0t82WCBp7S9O', 'Sabbir Mahmud Afridi', '1693640074_1693594724_1693594374_dp.jpg', 'smahmuddz'),
(8, 'smahmuddz04@gmail.com', '$2y$10$cAZ4WToedhEGfI4IG20e4u2deK82wK3tRwNZxsshX4jKs6cCsedbm', 'Sabbir Mahmud Afridi', '1693644449_1693640074_1693594724_1693594374_dp.jpg', 'smahmuddz04'),
(9, 'samiha@gmail.com', '$2y$10$ehPOEDXbBgFM0pvOrZTIE.d97vC9VhbHC9D1lpdQq0mW/6olHb85K', 'Samiha Karim Chowdhury', '1693831750_snapedit_1693825874784.jpg', 'samiha');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `liked_songs`
--
ALTER TABLE `liked_songs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_like` (`user_id`,`song_id`),
  ADD KEY `song_id` (`song_id`);

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `liked_songs`
--
ALTER TABLE `liked_songs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `liked_songs`
--
ALTER TABLE `liked_songs`
  ADD CONSTRAINT `liked_songs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `liked_songs_ibfk_2` FOREIGN KEY (`song_id`) REFERENCES `songs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
