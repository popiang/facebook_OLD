-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2019 at 04:51 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `social`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_body` text NOT NULL,
  `posted_by` varchar(60) NOT NULL,
  `posted_to` varchar(60) NOT NULL,
  `date_added` datetime NOT NULL,
  `removed` varchar(3) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_body`, `posted_by`, `posted_to`, `date_added`, `removed`, `post_id`) VALUES
(1, 'Yo whatsapp!!!', 'shahrilmadshah', 'shahrilmadshah', '2019-03-04 16:34:14', 'no', 5),
(0, 'asdf', 'hishamsur_hassan', 'hishamsur_hassan', '2019-10-28 11:42:31', 'no', 22),
(0, 'qewr', 'hishamsur_hassan', 'umisyafira_azmi', '2019-10-28 11:42:51', 'no', 24),
(0, 'dd', 'umisyafira_azmi', 'umisyafira_azmi', '2019-10-28 11:43:08', 'no', 24),
(0, 'jjjj', 'azmi_ahmad', 'umisyafira_azmi', '2019-10-28 11:44:16', 'no', 24);

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

CREATE TABLE `friend_requests` (
  `id` int(11) NOT NULL,
  `user_to` varchar(50) NOT NULL,
  `user_from` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `username` varchar(60) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `username`, `post_id`) VALUES
(1, 'hishamsur_hassan', 6),
(2, 'hishamsur_hassan', 7),
(3, 'azmi_ahmad', 6),
(4, 'azmi_ahmad', 8),
(5, 'hishamsur_hassan', 9),
(6, 'azmi_ahmad', 18),
(7, 'umisyafira_azmi', 24),
(8, 'azmi_ahmad', 24);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `user_to` varchar(50) NOT NULL,
  `user_from` varchar(50) NOT NULL,
  `body` text NOT NULL,
  `date` datetime NOT NULL,
  `opened` varchar(3) NOT NULL,
  `viewed` varchar(3) NOT NULL,
  `deleted` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_to`, `user_from`, `body`, `date`, `opened`, `viewed`, `deleted`) VALUES
(1, 'azmi_ahmad', 'hishamsur_hassan', 'adsf', '2019-10-28 23:22:49', 'no', 'no', 'no'),
(2, 'azmi_ahmad', 'hishamsur_hassan', 'kasi u happy', '2019-10-28 23:26:33', 'no', 'no', 'no'),
(3, 'azmi_ahmad', 'hishamsur_hassan', 'kof', '2019-10-28 23:26:37', 'no', 'no', 'no'),
(4, 'hishamsur_hassan', 'azmi_ahmad', 'bop awesome', '2019-10-28 23:27:46', 'yes', 'yes', 'no'),
(5, 'hishamsur_hassan', 'azmi_ahmad', 'adsf', '2019-10-28 23:27:49', 'yes', 'yes', 'no'),
(6, 'azmi_ahmad', 'hishamsur_hassan', 'kaki kena rantai ka tuan?', '2019-10-28 23:29:15', 'no', 'no', 'no'),
(7, 'azmi_ahmad', 'hishamsur_hassan', 'gggg', '2019-10-29 00:36:42', 'no', 'no', 'no'),
(8, 'azmi_ahmad', 'hishamsur_hassan', 'test', '2019-10-29 00:53:52', 'no', 'no', 'no'),
(9, 'umisyafira_azmi', 'hishamsur_hassan', 'Hi there', '2019-11-03 08:05:54', 'yes', 'no', 'no'),
(10, 'azmi_ahmad', 'hishamsur_hassan', 'yo', '2019-11-10 13:27:31', 'no', 'no', 'no'),
(11, 'azmi_ahmad', 'hishamsur_hassan', 'whatsapp', '2019-11-10 13:27:41', 'no', 'no', 'no'),
(12, 'azmi_ahmad', 'hishamsur_hassan', 'yo again', '2019-11-10 13:28:12', 'no', 'no', 'no'),
(13, 'azmi_ahmad', 'hishamsur_hassan', 'asdf', '2019-11-10 13:29:05', 'no', 'no', 'no'),
(14, 'azmi_ahmad', 'hishamsur_hassan', 'sdf', '2019-11-10 13:35:17', 'no', 'no', 'no'),
(15, 'azmi_ahmad', 'hishamsur_hassan', 'sdf', '2019-11-10 13:36:13', 'no', 'no', 'no'),
(16, 'azmi_ahmad', 'hishamsur_hassan', 'd', '2019-11-10 13:36:20', 'no', 'no', 'no'),
(17, 'azmi_ahmad', 'hishamsur_hassan', 'd', '2019-11-10 13:37:15', 'no', 'no', 'no'),
(18, 'azmi_ahmad', 'hishamsur_hassan', 'g', '2019-11-10 13:41:40', 'no', 'no', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `body` text NOT NULL,
  `added_by` varchar(60) NOT NULL,
  `user_to` varchar(60) NOT NULL,
  `date_added` datetime NOT NULL,
  `user_closed` varchar(3) NOT NULL,
  `deleted` varchar(3) NOT NULL,
  `likes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `body`, `added_by`, `user_to`, `date_added`, `user_closed`, `deleted`, `likes`) VALUES
(1, 'My first post!!', 'shahrilmadshah', 'none', '2018-11-29 15:18:12', 'no', 'no', 0),
(2, 'This is umi\'s first post', 'umisyafiraazmi', 'none', '2018-11-29 15:19:15', 'no', 'no', 0),
(3, 'Hallooo', 'shahrilmadshah', 'none', '2019-02-19 16:30:20', 'no', 'no', 0),
(4, 'Hallooo', 'shahrilmadshah', 'none', '2019-02-19 16:39:04', 'no', 'no', 0),
(5, 'Hallooo', 'shahrilmadshah', 'none', '2019-02-19 16:42:13', 'no', 'no', 2),
(6, 'Whatsapp dude!!', 'hishamsur_hassan', 'none', '2019-02-21 16:25:09', 'no', 'no', 2),
(7, 'g d m f!!!!', 'hishamsur_hassan', 'none', '2019-02-21 16:25:17', 'no', 'no', 1),
(8, 'want some prawn??', 'hishamsur_hassan', 'none', '2019-02-21 16:25:31', 'no', 'no', 1),
(9, 'kasi u happy!!!', 'hishamsur_hassan', 'none', '2019-02-21 16:25:48', 'no', 'no', 1),
(10, 'let\'s rock!!', 'john_petrucci', 'none', '2019-02-21 16:26:07', 'no', 'no', 0),
(11, 'suspended animation!', 'john_petrucci', 'none', '2019-02-21 16:26:14', 'no', 'no', 0),
(12, 'guitar is my wife', 'john_petrucci', 'none', '2019-02-21 16:26:35', 'no', 'no', 0),
(13, 'scarified!!', 'paul_gilbert', 'none', '2019-02-21 16:27:38', 'no', 'no', 0),
(14, 'down to maxico!!!', 'paul_gilbert', 'none', '2019-02-21 16:27:51', 'no', 'no', 0),
(16, 'Testing', 'shahrilmadshah', 'none', '2019-03-04 16:39:01', 'no', 'no', 0),
(17, 'Testing', 'shahrilmadshah', 'none', '2019-03-04 17:01:45', 'no', 'no', 0),
(18, 'Azmi\'s first post', 'azmi_ahmad', 'none', '2019-10-27 15:35:11', 'no', 'no', 1),
(19, 'one', 'hishamsur_hassan', 'none', '2019-10-28 11:28:52', 'no', 'yes', 0),
(20, 'two', 'hishamsur_hassan', 'none', '2019-10-28 11:29:54', 'no', 'no', 0),
(21, 'three', 'hishamsur_hassan', 'none', '2019-10-28 11:30:02', 'no', 'no', 0),
(22, 'four', 'hishamsur_hassan', 'azmi_ahmad', '2019-10-28 11:30:22', 'no', 'no', 0),
(23, 'umichan in the house!!!', 'umisyafira_azmi', 'none', '2019-10-28 11:31:30', 'no', 'no', 0),
(24, 'bop vs pop', 'umisyafira_azmi', 'hishamsur_hassan', '2019-10-28 11:32:17', 'no', 'no', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `signup_date` date NOT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `num_posts` int(11) NOT NULL,
  `num_likes` int(11) NOT NULL,
  `user_closed` varchar(3) NOT NULL,
  `friends_array` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `signup_date`, `profile_pic`, `num_posts`, `num_likes`, `user_closed`, `friends_array`) VALUES
(3, 'Umisyafira', 'Azmi', 'umisyafira_azmi', 'ariana@gmail.com', '0d107d09f5bbe40cade3de5c71e9e9b7', '2019-09-29', 'assets/images/profile_pic/umisyafira_azmi1747d615ad3e4d444dba2e5b5bb78c03n.jpeg', 2, 2, 'no', ',hishamsur_hassan,azmi_ahmad,shahril_madshah,'),
(4, 'Hishamsur', 'Hassan', 'hishamsur_hassan', 'bopiang@hotmail.com', '0d107d09f5bbe40cade3de5c71e9e9b7', '2019-09-30', 'assets/images/profile_pic/hishamsur_hassan10b1f1fd7fc12b233632fb00105c5782n.jpeg', 3, 5, 'no', ',shahril,azmi_ahmad,umisyafira_azmi,'),
(5, 'Suriah', 'Jamal', 'suriah_jamal', 'su@gmail.com', '0d107d09f5bbe40cade3de5c71e9e9b7', '2019-09-30', 'assets/images/profile_pic/default/head_carrot.png', 0, 0, 'no', ','),
(7, 'Azmi', 'Ahmad', 'azmi_ahmad', 'azmi@gmail.com', '0d107d09f5bbe40cade3de5c71e9e9b7', '2019-10-27', 'assets/images/profile_pic/azmi_ahmad83d0c8ba57eb2c1bfbfda6bd359ca72bn.jpeg', 1, 1, 'no', ',hishamsur_hassan,umisyafira_azmi,'),
(8, 'Shahril', 'Madshah', 'shahril_madshah', 'popiang@hotmail.com', '0d107d09f5bbe40cade3de5c71e9e9b7', '2019-11-03', 'assets/images/profile_pic/default/head_emerald.png', 0, 0, 'no', ',umisyafira_azmi,');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
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
-- AUTO_INCREMENT for table `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
