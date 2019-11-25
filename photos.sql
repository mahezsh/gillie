-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: database-1b.c1x7jt5kkcd5.ap-southeast-2.rds.amazonaws.com
-- Generation Time: Sep 22, 2018 at 01:19 PM
-- Server version: 5.7.22
-- PHP Version: 7.0.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `innodb`
--

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `id` int(11) NOT NULL,
  `photo_title` varchar(225) NOT NULL,
  `description` varchar(225) NOT NULL,
  `date_of_photo` date NOT NULL,
  `keywords` varchar(225) NOT NULL,
  `reference` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`id`, `photo_title`, `description`, `date_of_photo`, `keywords`, `reference`) VALUES
(0, 'autumn leaves', 'autumn leaves des', '2018-04-22', 'autumn, leaves', 'https://gillie-bucket.s3-ap-southeast-2.amazonaws.com/autumn1.jpg'),
(1, 'autumn road', 'autumn road des', '2018-04-25', 'autumn, road', 'https://gillie-bucket.s3-ap-southeast-2.amazonaws.com/autumn2.jpg'),
(2, 'autumn baby', 'autumn baby des', '2018-04-21', 'autumn, baby', 'https://gillie-bucket.s3-ap-southeast-2.amazonaws.com/autumn3.jpg'),
(3, 'winter forest', 'winter forest des', '2018-07-22', 'winter, forest', 'https://gillie-bucket.s3-ap-southeast-2.amazonaws.com/winter1.jpeg'),
(4, 'winter leaves', 'winter leaves des', '2018-07-20', 'winter, leaves', 'https://gillie-bucket.s3-ap-southeast-2.amazonaws.com/winter2.jpg'),
(5, 'winter snowman', 'winter snowman des', '2018-07-12', 'winter, snowman', 'https://gillie-bucket.s3-ap-southeast-2.amazonaws.com/winter3.jpg'),
(6, 'spring flowers', 'spring flowers des', '2018-09-22', 'spring, flowers', 'https://gillie-bucket.s3-ap-southeast-2.amazonaws.com/spring1.jpg'),
(7, 'spring trees', 'spring trees des', '2018-09-16', 'spring, trees', 'https://gillie-bucket.s3-ap-southeast-2.amazonaws.com/spring2.jpg'),
(8, 'spring sky', 'spring sky des', '2018-09-13', 'spring, sky', 'https://gillie-bucket.s3-ap-southeast-2.amazonaws.com/spring3.jpeg'),
(9, 'summer coconut', 'summer coconut des', '2018-12-12', 'summer, coconut', 'https://gillie-bucket.s3-ap-southeast-2.amazonaws.com/summer1.jpg'),
(10, 'summer beach', 'summer beach des', '2018-12-15', 'summer, beach', 'https://gillie-bucket.s3-ap-southeast-2.amazonaws.com/summer2.jpeg'),
(11, 'summer fun', 'summer fun des', '2018-12-25', 'summer, fun', 'https://gillie-bucket.s3-ap-southeast-2.amazonaws.com/summer3.jpg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
