-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 21, 2017 at 05:54 PM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 7.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bamboo_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment_table`
--

CREATE TABLE `comment_table` (
  `id` int(11) NOT NULL,
  `comment_body` text NOT NULL,
  `photo` varchar(255) NOT NULL,
  `user_name` varchar(111) NOT NULL,
  `user_email` varchar(111) NOT NULL,
  `author_id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `time_date` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comment_table`
--

INSERT INTO `comment_table` (`id`, `comment_body`, `photo`, `user_name`, `user_email`, `author_id`, `thread_id`, `time_date`) VALUES
(5, 'Message here...', 'test.jpeg', 'Hasna', 'no_mail@gmail.com', 0, 4, '1487695630');

-- --------------------------------------------------------

--
-- Table structure for table `thread_table`
--

CREATE TABLE `thread_table` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(30) NOT NULL,
  `thread_body` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `author_id` int(11) NOT NULL,
  `time_date` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `thread_table`
--

INSERT INTO `thread_table` (`id`, `title`, `category`, `thread_body`, `image`, `author_id`, `time_date`) VALUES
(4, 'Nam commodo turpis sit amet magna', 'Culture', 'Aliquam eu ante felis. Vivamus vitae ex arcu. Nullam posuere dignissim est. Aenean at lorem lacus. Fusce consectetur sollicitudin leo sit amet lacinia. Curabitur eget eleifend mauris, vitae imperdiet neque. Sed elementum, nulla ac tempus vulputate, justo libero dapibus enim, non placerat turpis risus vel elit. Nam venenatis accumsan viverra. Maecenas rhoncus malesuada diam, a feugiat nunc tempus quis. Fusce eget commodo felis. Nulla non convallis dui. Maecenas nisi lectus, eleifend eu sem eget, interdum faucibus lacus. Donec nec blandit ligula. Aenean facilisis lacinia lacus ut aliquet.Mauris congue bibendum lectus id gravida. Maecenas scelerisque vehicula ligula, non maximus eros euismod sed. Morbi aliquam ligula massa, eget malesuada nulla rhoncus sed. Duis suscipit, ipsum placerat accumsan pharetra, quam mi tincidunt erat, nec fringilla ex neque eu nibh. Etiam lacinia est fermentum orci gravida facilisis. Morbi blandit est quis dictum consequat. In hendrerit placerat faucibus. Etiam id mattis lacus. Maecenas vel arcu vulputate, imperdiet odio ac, pretium nisi. Cras sit amet aliquam magna. Donec quam nibh, scelerisque vel faucibus non, molestie ac elit. Phasellus pharetra arcu eget nisl rhoncus laoreet. Fusce luctus justo nec ipsum iaculis lobortis.\r\n\r\nMorbi in enim et justo varius rutrum nec ut libero. Proin nec purus leo. Sed gravida diam et nibh facilisis cursus. In ut scelerisque urna, sed fringilla ipsum. Duis sed porttitor dolor. Duis sagittis mollis gravida. Mauris eget efficitur tortor.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse gravida, mauris in tincidunt finibus, sapien metus blandit lorem, tincidunt tincidunt risus risus euismod leo. Proin vehicula elementum nisl, vitae lacinia risus accumsan quis. Fusce vel nibh quis leo vulputate fermentum eget ac mauris. Proin non imperdiet sem. Nulla facilisi. Fusce malesuada dignissim eleifend. Integer vel mauris consequat, facilisis diam sed, accumsan augue. Praesent vulputate nisl pharetra libero hendrerit pretium.', '472526_2762_4.jpg', 1, '1487620016');

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE `user_table` (
  `id` int(11) NOT NULL,
  `user_name` varchar(111) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `e_mail` varchar(155) NOT NULL,
  `password` varchar(111) NOT NULL,
  `profile_picture` varchar(255) NOT NULL,
  `email_verified` varchar(155) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`id`, `user_name`, `phone`, `e_mail`, `password`, `profile_picture`, `email_verified`) VALUES
(1, 'Jobayer Hossain', '12457895615', 'jobayerfx09@gmail.com', 'c20ad4d76fe97759aa27a0c99bff6710', '11822795_950078011722185_1089942377169858174_n.jpg', 'Yes'),
(3, 'Haider', '125896452', 'sn_jobayer@yahoo.com', '202cb962ac59075b964b07152d234b70', 'default_avatar.png', 'Yes');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment_table`
--
ALTER TABLE `comment_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `thread_table`
--
ALTER TABLE `thread_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment_table`
--
ALTER TABLE `comment_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `thread_table`
--
ALTER TABLE `thread_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user_table`
--
ALTER TABLE `user_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
