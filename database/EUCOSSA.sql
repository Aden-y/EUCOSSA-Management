-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 25, 2018 at 11:21 AM
-- Server version: 10.1.8-MariaDB
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eucossa`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `user_id` int(11) NOT NULL,
  `post_id` varchar(100) NOT NULL,
  `c_id` varchar(100) NOT NULL,
  `c_text` text,
  `c_file` varchar(100) DEFAULT NULL,
  `replies` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`user_id`, `post_id`, `c_id`, `c_text`, `c_file`, `replies`) VALUES
(6, '6-2', '6-2-1', 'ssup man what is up now you good', NULL, 0),
(6, '6-2', '6-2-2', 'ssup man what is up now you good show me', NULL, 0),
(6, '6-2', '6-2-3', 'ssup man what is up now you good show me 2', NULL, 0),
(6, '6-2', '6-2-4', 'ssup man what is up now you good show me 2 3', NULL, 0),
(0, '6-6', '6-6-1', 'That is not true', NULL, 0),
(0, '6-7', '6-7-1', '', NULL, 0),
(0, '6-7', '6-7-2', 'hjhlkhjkllkjohjklj', NULL, 0),
(0, '6-7', '6-7-3', 'hdksjdlkajdlakd', NULL, 0),
(0, '6-7', '6-7-4', 'fjdslkjfsjdslkfsk', NULL, 0),
(6, '6-7', '6-7-5', 'hello world', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `user_id` int(11) NOT NULL,
  `post_id` varchar(100) NOT NULL,
  `post_text` text,
  `post_file` varchar(100) DEFAULT NULL,
  `comments` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`user_id`, `post_id`, `post_text`, `post_file`, `comments`) VALUES
(6, '6-2', 'ssup my niggs', 'monsterfire1.png', 4),
(6, '6-3', 'howdy do', 'monster1.png', 0),
(6, '6-5', 'Hey am new here!! Here''s my pic', 'robo1.png', 0),
(6, '6-6', 'Here i am again', 'monsterfire2.png', 1),
(6, '6-7', 'Bruh!!!!! it works', 'fell.png', 5);

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `u_id` int(11) NOT NULL,
  `p_id` varchar(100) NOT NULL,
  `cmnt_id` varchar(100) NOT NULL,
  `reply_id` varchar(100) NOT NULL DEFAULT '',
  `reply_text` text,
  `reply_file` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `usr_nm` varchar(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `pwd` varchar(100) NOT NULL,
  `day` date NOT NULL,
  `posts` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `usr_nm`, `email`, `pwd`, `day`, `posts`) VALUES
(1, 'Adeny', 'admin@admin.com', '$2y$10$8dJlTWw30HgmwoSZ6kQo8eUCF66AISuoTH75QTLP96xtqn7GbW6wu', '0000-00-00', 0),
(2, 'Adenyl', 'admdin@admin.com', '$2y$10$QttcQRskdKqFcwHlfZ9Gb.ShdvcnrXMBol0zlUh8dNtrD.ZPnLoh.', '0000-00-00', 0),
(3, 'Adenylf', 'adfmdin@admin.com', '$2y$10$LXKS9uEh2eSEGwMVp4A6BOOPkFMVML235ivuVFCP6fwvH/ZleR/Ea', '0000-00-00', 0),
(4, 'adams', 'ads@gmail.com', '$2y$10$hNfmeTj40zQYz9NwmjR0HOAZrfYzbTLNLiFnBLWul4oTAqZSjDgjy', '0000-00-00', 0),
(5, 'user', 'user@gmail.com', '$2y$10$N3QARCKYfx2e7kmdRVUZ0.rFUcBpFDjd8nIbEBhJHPJuxMdtEhQh6', '0000-00-00', 0),
(6, 'brayo', 'bjmbugus@gmail.com', '$2y$10$.miYjMJImwQUyGOR9eM.4unmaTarcdybNBb5HgjQxiVwPyfTro2bG', '2023-07-18', 7),
(7, 'Anonymous', 'null', 'null', '0000-00-00', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `posts_fk` (`post_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `users_fk` (`user_id`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`reply_id`),
  ADD KEY `comments_fk` (`cmnt_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usr_nm` (`usr_nm`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `posts_fk` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `users_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `replies`
--
ALTER TABLE `replies`
  ADD CONSTRAINT `comments_fk` FOREIGN KEY (`cmnt_id`) REFERENCES `comments` (`c_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
