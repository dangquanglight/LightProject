-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2014 at 02:41 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gehouse`
--

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

CREATE TABLE IF NOT EXISTS `actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` int(11) NOT NULL,
  `action_type` tinyint(1) NOT NULL,
  `action_setpoint` float NOT NULL,
  `schedule_days` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `schedule_start` time DEFAULT NULL,
  `schedule_end` time DEFAULT NULL,
  `exception_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `exception_from` date DEFAULT NULL,
  `exception_to` date DEFAULT NULL,
  `exception_setpoint` float DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created_by` int(11) DEFAULT NULL,
  `created_date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `actions`
--

INSERT INTO `actions` (`id`, `device_id`, `action_type`, `action_setpoint`, `schedule_days`, `schedule_start`, `schedule_end`, `exception_type`, `exception_from`, `exception_to`, `exception_setpoint`, `status`, `description`, `created_by`, `created_date`) VALUES
(1, 1, 0, 19, '0,1,3', '17:05:00', '20:55:00', 'duration', '2014-04-23', '2014-05-08', 17, 1, NULL, NULL, 1398681092),
(2, 10, 1, 5, NULL, NULL, NULL, 'duration', '2014-04-23', '2014-05-09', 10, 1, NULL, NULL, 1398681298);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
