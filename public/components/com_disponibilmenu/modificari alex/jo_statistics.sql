-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 05 Iun 2015 la 17:16
-- Server version: 5.5.36
-- PHP Version: 5.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `public`
--

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `jo_statistics`
--

CREATE TABLE IF NOT EXISTS `jo_statistics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_asset` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `ip` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Salvarea datelor din tabel `jo_statistics`
--

INSERT INTO `jo_statistics` (`id`, `id_asset`, `datetime`, `ip`) VALUES
(1, 446, '2015-06-05 16:58:30', '::1'),
(2, 446, '2015-06-05 16:58:57', '::1'),
(3, 446, '2015-06-05 16:59:01', '::1'),
(4, 446, '2015-06-05 16:59:04', '::1'),
(5, 446, '2015-06-05 16:59:07', '::1'),
(6, 446, '2015-06-05 17:02:03', '::1'),
(7, 446, '2015-06-05 17:02:30', '::1'),
(8, 446, '2015-06-05 17:02:41', '::1'),
(9, 446, '2015-06-05 17:03:38', '::1'),
(10, 446, '2015-06-05 17:03:56', '::1'),
(11, 446, '2015-06-05 17:04:05', '::1'),
(12, 446, '2015-06-05 17:04:10', '::1'),
(13, 450, '2015-06-05 17:04:20', '::1'),
(14, 450, '2015-06-05 17:04:25', '::1'),
(15, 312, '2015-06-05 17:04:36', '::1'),
(16, 312, '2015-06-05 17:04:41', '::1'),
(17, 312, '2015-06-05 17:04:45', '::1'),
(18, 446, '2015-06-05 17:15:44', '192.168.1.70'),
(19, 446, '2015-06-05 17:15:51', '192.168.1.70');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
