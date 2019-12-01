-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2019 at 04:59 PM
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
(0, 'jjjj', 'azmi_ahmad', 'umisyafira_azmi', '2019-10-28 11:44:16', 'no', 24),
(0, 'yo', 'hishamsur_hassan', 'hishamsur_hassan', '2019-11-18 13:23:03', 'no', 22),
(0, 'five', 'azmi_ahmad', 'hishamsur_hassan', '2019-11-18 14:40:06', 'no', 22),
(0, 'We should do this again..', 'umisyafira_azmi', 'umisyafira_azmi', '2019-12-01 23:43:24', 'no', 37);

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

CREATE TABLE `friend_requests` (
  `id` int(11) NOT NULL,
  `user_to` varchar(50) NOT NULL,
  `user_from` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friend_requests`
--

INSERT INTO `friend_requests` (`id`, `user_to`, `user_from`) VALUES
(29, 'azmi_ahmad', 'hishamsur_hassan');

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
(8, 'azmi_ahmad', 24),
(10, 'hishamsur_hassan', 24),
(11, 'hishamsur_hassan', 22),
(12, 'azmi_ahmad', 20),
(13, 'hishamsur_hassan', 18),
(14, 'azmi_ahmad', 26),
(16, 'azmi_ahmad', 22),
(17, 'hishamsur_hassan', 8),
(18, 'umisyafira_azmi', 37);

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
(1, 'azmi_ahmad', 'hishamsur_hassan', 'adsf', '2019-10-28 23:22:49', 'yes', 'yes', 'no'),
(2, 'azmi_ahmad', 'hishamsur_hassan', 'kasi u happy', '2019-10-28 23:26:33', 'yes', 'yes', 'no'),
(3, 'azmi_ahmad', 'hishamsur_hassan', 'kof', '2019-10-28 23:26:37', 'yes', 'yes', 'no'),
(4, 'hishamsur_hassan', 'azmi_ahmad', 'bop awesome', '2019-10-28 23:27:46', 'yes', 'yes', 'no'),
(5, 'hishamsur_hassan', 'azmi_ahmad', 'adsf', '2019-10-28 23:27:49', 'yes', 'yes', 'no'),
(6, 'azmi_ahmad', 'hishamsur_hassan', 'kaki kena rantai ka tuan?', '2019-10-28 23:29:15', 'yes', 'yes', 'no'),
(7, 'azmi_ahmad', 'hishamsur_hassan', 'gggg', '2019-10-29 00:36:42', 'yes', 'yes', 'no'),
(8, 'azmi_ahmad', 'hishamsur_hassan', 'test', '2019-10-29 00:53:52', 'yes', 'yes', 'no'),
(9, 'umisyafira_azmi', 'hishamsur_hassan', 'Hi there', '2019-11-03 08:05:54', 'yes', 'yes', 'no'),
(10, 'azmi_ahmad', 'hishamsur_hassan', 'yo', '2019-11-10 13:27:31', 'yes', 'yes', 'no'),
(11, 'azmi_ahmad', 'hishamsur_hassan', 'whatsapp', '2019-11-10 13:27:41', 'yes', 'yes', 'no'),
(12, 'azmi_ahmad', 'hishamsur_hassan', 'yo again', '2019-11-10 13:28:12', 'yes', 'yes', 'no'),
(13, 'azmi_ahmad', 'hishamsur_hassan', 'asdf', '2019-11-10 13:29:05', 'yes', 'yes', 'no'),
(14, 'azmi_ahmad', 'hishamsur_hassan', 'sdf', '2019-11-10 13:35:17', 'yes', 'yes', 'no'),
(15, 'azmi_ahmad', 'hishamsur_hassan', 'sdf', '2019-11-10 13:36:13', 'yes', 'yes', 'no'),
(16, 'azmi_ahmad', 'hishamsur_hassan', 'd', '2019-11-10 13:36:20', 'yes', 'yes', 'no'),
(17, 'azmi_ahmad', 'hishamsur_hassan', 'd', '2019-11-10 13:37:15', 'yes', 'yes', 'no'),
(18, 'azmi_ahmad', 'hishamsur_hassan', 'g', '2019-11-10 13:41:40', 'yes', 'yes', 'no'),
(19, 'paul_gilbert', 'john_petrucci', 'Hi Paul. How\'s your guitar skills?', '2019-11-12 23:55:44', 'no', 'no', 'no'),
(20, 'john_petrucci', 'hishamsur_hassan', 'Yo john...how are you?', '2019-11-13 00:00:35', 'yes', 'yes', 'no'),
(21, 'paul_gilbert', 'hishamsur_hassan', 'Technical Difficulties rocks!!', '2019-11-13 00:01:20', 'no', 'no', 'no'),
(22, 'bucket_head', 'hishamsur_hassan', 'Do you like KFC?', '2019-11-13 00:04:49', 'yes', 'yes', 'no'),
(23, 'hishamsur_hassan', 'mizam_ahmad', 'Bop...whatsapp?', '2019-11-13 00:11:46', 'no', 'yes', 'no'),
(24, 'suriah_jamal', 'hishamsur_hassan', 'kasi u happy', '2019-11-13 00:12:22', 'no', 'no', 'no'),
(25, 'suriah_jamal', 'hishamsur_hassan', 'kasi u happy', '2019-11-13 00:13:31', 'no', 'no', 'no'),
(26, 'shahril_madshah', 'hishamsur_hassan', 'bopp!!!!', '2019-11-13 00:14:40', 'yes', 'yes', 'no'),
(27, 'umisyafira_azmi', 'hishamsur_hassan', 'asdf', '2019-11-13 23:06:30', 'yes', 'yes', 'no'),
(28, 'umisyafira_azmi', 'hishamsur_hassan', 'asdf', '2019-11-13 23:32:47', 'yes', 'yes', 'no'),
(29, 'umisyafira_azmi', 'hishamsur_hassan', 'asdf', '2019-11-13 23:32:57', 'yes', 'yes', 'no'),
(30, 'umisyafira_azmi', 'hishamsur_hassan', 'asdf', '2019-11-13 23:34:42', 'yes', 'yes', 'no'),
(31, 'umisyafira_azmi', 'hishamsur_hassan', 'asdf', '2019-11-13 23:05:32', 'yes', 'yes', 'no'),
(32, 'umisyafira_azmi', 'hishamsur_hassan', 'asdf', '2019-11-13 23:06:53', 'yes', 'yes', 'no'),
(33, 'umisyafira_azmi', 'hishamsur_hassan', 'asdf', '2019-11-13 23:10:01', 'yes', 'yes', 'no'),
(34, 'takayoshi_ohmura', 'hishamsur_hassan', 'dantebayyo!!!', '2019-11-13 23:13:25', 'no', 'no', 'no'),
(35, 'takayoshi_ohmura', 'hishamsur_hassan', 'dantebayyo!!!', '2019-11-13 23:52:13', 'no', 'no', 'no'),
(36, 'hishamsur_hassan', 'shahril_madshah', 'yo whatsapp!!!', '2019-11-17 02:03:26', 'yes', 'yes', 'no'),
(37, 'hishamsur_hassan', 'umisyafira_azmi', 'yo', '2019-11-17 09:50:26', 'yes', 'yes', 'no'),
(38, 'hishamsur_hassan', 'azmi_ahmad', 'asdf', '2019-11-18 14:41:18', 'yes', 'yes', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_to` varchar(50) NOT NULL,
  `user_from` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `link` varchar(100) NOT NULL,
  `datetime` datetime NOT NULL,
  `opened` varchar(3) NOT NULL,
  `viewed` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_to`, `user_from`, `message`, `link`, `datetime`, `opened`, `viewed`) VALUES
(1, 'umisyafira_azmi', 'hishamsur_hassan', 'Hishamsur Hassan liked on your post', 'post.php?id=24', '2019-11-17 18:56:12', 'no', 'yes'),
(2, 'umisyafira_azmi', 'hishamsur_hassan', 'Hishamsur Hassan posted on your profile', 'post.php?id=25', '2019-11-17 18:56:33', 'no', 'yes'),
(3, 'azmi_ahmad', 'hishamsur_hassan', 'Hishamsur Hassan commented on your profile post', 'post.php?id=22', '2019-11-18 13:23:03', 'no', 'yes'),
(4, 'azmi_ahmad', 'hishamsur_hassan', 'Hishamsur Hassan posted on your profile', 'post.php?id=26', '2019-11-18 13:23:14', 'no', 'yes'),
(5, 'hishamsur_hassan', 'azmi_ahmad', 'Azmi Ahmad liked on your post', 'post.php?id=20', '2019-11-18 13:25:51', 'yes', 'yes'),
(6, 'azmi_ahmad', 'hishamsur_hassan', 'Hishamsur Hassan liked on your post', 'post.php?id=18', '2019-11-18 13:26:28', 'no', 'yes'),
(7, 'hishamsur_hassan', 'azmi_ahmad', 'Azmi Ahmad liked on your post', 'post.php?id=26', '2019-11-18 13:27:05', 'yes', 'yes'),
(8, 'hishamsur_hassan', 'azmi_ahmad', 'Azmi Ahmad liked on your post', 'post.php?id=22', '2019-11-18 14:39:56', 'yes', 'yes'),
(9, 'hishamsur_hassan', 'azmi_ahmad', 'Azmi Ahmad commented on your post', 'post.php?id=22', '2019-11-18 14:40:06', 'yes', 'yes'),
(10, 'hishamsur_hassan', 'azmi_ahmad', 'Azmi Ahmad posted on your profile', 'post.php?id=27', '2019-11-18 14:40:39', 'yes', 'yes');

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
  `likes` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `body`, `added_by`, `user_to`, `date_added`, `user_closed`, `deleted`, `likes`, `image`) VALUES
(1, 'My first post!!', 'shahrilmadshah', 'none', '2018-11-29 15:18:12', 'no', 'no', 0, ''),
(2, 'This is umi\'s first post', 'umisyafiraazmi', 'none', '2018-11-29 15:19:15', 'no', 'no', 0, ''),
(3, 'Hallooo', 'shahrilmadshah', 'none', '2019-02-19 16:30:20', 'no', 'no', 0, ''),
(4, 'Hallooo', 'shahrilmadshah', 'none', '2019-02-19 16:39:04', 'no', 'no', 0, ''),
(5, 'Hallooo', 'shahrilmadshah', 'none', '2019-02-19 16:42:13', 'no', 'no', 2, ''),
(6, 'Whatsapp dude!!', 'hishamsur_hassan', 'none', '2019-02-21 16:25:09', 'no', 'no', 2, ''),
(7, 'g d m f!!!!', 'hishamsur_hassan', 'none', '2019-02-21 16:25:17', 'no', 'no', 1, ''),
(8, 'want some prawn??', 'hishamsur_hassan', 'none', '2019-02-21 16:25:31', 'no', 'no', 2, ''),
(9, 'kasi u happy!!!', 'hishamsur_hassan', 'none', '2019-02-21 16:25:48', 'no', 'no', 1, ''),
(10, 'let\'s rock!!', 'john_petrucci', 'none', '2019-02-21 16:26:07', 'no', 'no', 0, ''),
(11, 'suspended animation!', 'john_petrucci', 'none', '2019-02-21 16:26:14', 'no', 'no', 0, ''),
(12, 'guitar is my wife', 'john_petrucci', 'none', '2019-02-21 16:26:35', 'no', 'no', 0, ''),
(13, 'scarified!!', 'paul_gilbert', 'none', '2019-02-21 16:27:38', 'no', 'no', 0, ''),
(14, 'down to maxico!!!', 'paul_gilbert', 'none', '2019-02-21 16:27:51', 'no', 'no', 0, ''),
(16, 'Testing', 'shahrilmadshah', 'none', '2019-03-04 16:39:01', 'no', 'no', 0, ''),
(17, 'Testing', 'shahrilmadshah', 'none', '2019-03-04 17:01:45', 'no', 'no', 0, ''),
(18, 'Azmi\'s first post', 'azmi_ahmad', 'none', '2019-10-27 15:35:11', 'no', 'no', 2, ''),
(19, 'one', 'hishamsur_hassan', 'none', '2019-10-28 11:28:52', 'no', 'yes', 0, ''),
(20, 'two', 'hishamsur_hassan', 'none', '2019-10-28 11:29:54', 'no', 'no', 1, ''),
(21, 'three', 'hishamsur_hassan', 'none', '2019-10-28 11:30:02', 'no', 'no', 0, ''),
(22, 'four', 'hishamsur_hassan', 'azmi_ahmad', '2019-10-28 11:30:22', 'no', 'no', 2, ''),
(23, 'umichan in the house!!!', 'umisyafira_azmi', 'none', '2019-10-28 11:31:30', 'no', 'no', 0, ''),
(24, 'bop vs pop', 'umisyafira_azmi', 'hishamsur_hassan', '2019-10-28 11:32:17', 'no', 'no', 3, ''),
(25, 'asdfasdfasdf', 'hishamsur_hassan', 'umisyafira_azmi', '2019-11-17 18:56:33', 'no', 'no', 0, ''),
(26, 'asdf', 'hishamsur_hassan', 'azmi_ahmad', '2019-11-18 13:23:14', 'no', 'no', 1, ''),
(27, 'rrr', 'azmi_ahmad', 'hishamsur_hassan', '2019-11-18 14:40:39', 'no', 'no', 0, ''),
(28, '<br><iframe with=\'420\' height=\'315\' src=\'https://www.youtube.com/embed/8jbdLsemfdw\'></iframe><br>', 'john_petrucci', 'none', '2019-12-01 18:06:47', 'no', 'no', 0, ''),
(29, 'Hi guys. I am looking forward for my next G3 concert in Malaysia next year!!', 'john_petrucci', 'none', '2019-12-01 20:43:55', 'no', 'yes', 0, ''),
(30, 'Hi guys. I am looking forward for my next G3 concert in Malaysia next year!!', 'john_petrucci', 'none', '2019-12-01 20:44:59', 'no', 'yes', 0, ''),
(31, 'Hi guys. I am looking forward for my next G3 concert next year in Malaysia', 'john_petrucci', 'none', '2019-12-01 20:47:22', 'no', 'yes', 0, ''),
(32, 'asdf', 'john_petrucci', 'none', '2019-12-01 20:48:27', 'no', 'yes', 0, ''),
(33, 'asdf', 'john_petrucci', 'none', '2019-12-01 20:49:04', 'no', 'yes', 0, ''),
(34, 'qwer', 'john_petrucci', 'none', '2019-12-01 20:49:35', 'no', 'yes', 0, ''),
(35, 'Hi guys. I am looking forward for my next G3 concert next year in Malaysia', 'john_petrucci', 'none', '2019-12-01 20:50:26', 'no', 'no', 0, ''),
(36, 'Sweet moment', 'hishamsur_hassan', 'none', '2019-12-01 23:36:38', 'no', 'yes', 0, ''),
(37, 'Sweet moment', 'umisyafira_azmi', 'none', '2019-12-01 23:40:11', 'no', 'no', 1, 'assets/images/posts/5de3dedb1249920170903_154508.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `trends`
--

CREATE TABLE `trends` (
  `title` varchar(50) NOT NULL,
  `hits` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trends`
--

INSERT INTO `trends` (`title`, `hits`) VALUES
('Hi', 1),
('Guys', 1),
('Looking', 1),
('Forward', 1),
('G3', 1),
('Concert', 1),
('Malaysia', 1),
('Sweet', 2),
('Moment', 2);

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
(3, 'Umisyafira', 'Azmi', 'umisyafira_azmi', 'ariana@gmail.com', '0d107d09f5bbe40cade3de5c71e9e9b7', '2019-09-29', 'assets/images/profile_pic/umisyafira_azmi1747d615ad3e4d444dba2e5b5bb78c03n.jpeg', 3, 4, 'no', ',azmi_ahmad,shahril_madshah,john_petrucci,paul_gilbert,bucket_head,hishamsur_hassan,'),
(4, 'Hishamsur', 'Hassan', 'hishamsur_hassan', 'bopiang@hotmail.com', '0d107d09f5bbe40cade3de5c71e9e9b7', '2019-09-30', 'assets/images/profile_pic/hishamsur_hassan926a8bb78c5e81397e0acea233b6566fn.jpeg', 6, 10, 'no', ',shahril,john_petrucci,paul_gilbert,bucket_head,shahril_madshah,suriah_jamal,mizam_ahmad,takayoshi_ohmura,umisyafira_azmi,'),
(5, 'Suriah', 'Jamal', 'suriah_jamal', 'su@gmail.com', '0d107d09f5bbe40cade3de5c71e9e9b7', '2019-09-30', 'assets/images/profile_pic/default/head_carrot.png', 0, 0, 'no', ',hishamsur_hassan,'),
(7, 'Azmi', 'Ahmad', 'azmi_ahmad', 'azmi@gmail.com', '0d107d09f5bbe40cade3de5c71e9e9b7', '2019-10-27', 'assets/images/profile_pic/azmi_ahmad83d0c8ba57eb2c1bfbfda6bd359ca72bn.jpeg', 2, 2, 'no', ',umisyafira_azmi,john_petrucci,paul_gilbert,bucket_head,shahril_madshah,'),
(8, 'Shahril', 'Madshah', 'shahril_madshah', 'popiang@hotmail.com', '0d107d09f5bbe40cade3de5c71e9e9b7', '2019-11-03', 'assets/images/profile_pic/default/head_emerald.png', 0, 0, 'no', ',umisyafira_azmi,hishamsur_hassan,azmi_ahmad,john_petrucci,paul_gilbert,bucket_head,mizam_ahmad,'),
(9, 'Paul', 'Gilbert', 'paul_gilbert', 'paul_gilbert@gmail.com', '0d107d09f5bbe40cade3de5c71e9e9b7', '2019-11-12', 'assets/images/profile_pic/default/head_pumpkin.png', 0, 0, 'no', ',john_petrucci,bucket_head,hishamsur_hassan,azmi_ahmad,umisyafira_azmi,shahril_madshah,'),
(10, 'John', 'Petrucci', 'john_petrucci', 'john@gmail.com', '0d107d09f5bbe40cade3de5c71e9e9b7', '2019-11-12', 'assets/images/profile_pic/john_petrucci72dccb310f0f74db9f580b3276006623n.jpeg', 8, 0, 'no', ',paul_gilbert,bucket_head,hishamsur_hassan,azmi_ahmad,umisyafira_azmi,shahril_madshah,'),
(11, 'Bucket', 'Head', 'bucket_head', 'bucket_head@gmail.com', '0d107d09f5bbe40cade3de5c71e9e9b7', '2019-11-12', 'assets/images/profile_pic/default/head_turqoise.png', 0, 0, 'no', ',paul_gilbert,john_petrucci,hishamsur_hassan,azmi_ahmad,umisyafira_azmi,shahril_madshah,'),
(12, 'Mizam', 'Ahmad', 'mizam_ahmad', 'mizam@gmail.com', '0d107d09f5bbe40cade3de5c71e9e9b7', '2019-11-13', 'assets/images/profile_pic/default/head_nephritis.png', 0, 0, 'no', ',shahril_madshah,hishamsur_hassan,'),
(13, 'Takayoshi', 'Ohmura', 'takayoshi_ohmura', 'takayoshi@hotmail.com', '0d107d09f5bbe40cade3de5c71e9e9b7', '2019-11-13', 'assets/images/profile_pic/default/head_red.png', 0, 0, 'no', ',hishamsur_hassan,');

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
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
