-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2014 at 04:10 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

--
-- Dumping data for table `actions`
--

INSERT INTO `actions` (`id`, `device_id`, `action_type`, `action_setpoint`, `schedule_days`, `schedule_start`, `schedule_end`, `exception_type`, `exception_from`, `exception_to`, `exception_setpoint`, `status`, `description`, `created_by`, `created_date`) VALUES
(12, 1, 0, 21, NULL, '00:00:00', '00:00:00', '0', NULL, NULL, 0, 1, NULL, NULL, 1399646101),
(15, 1, 1, 21, NULL, NULL, NULL, '0', NULL, NULL, 0, 1, NULL, NULL, 1400332530),
(16, 11, 1, 17, NULL, NULL, NULL, '0', NULL, NULL, 0, 1, NULL, NULL, 1400249813),
(17, 13, 0, 17, NULL, '00:00:00', '00:00:00', '0', NULL, NULL, 0, 1, NULL, NULL, 1400332508),
(18, 1, 1, 21, NULL, NULL, NULL, '0', NULL, NULL, 0, 1, NULL, NULL, 1400249788),
(19, 12, 0, 19, NULL, '00:00:00', '00:00:00', '0', NULL, NULL, 0, 1, NULL, NULL, 1400332542),
(20, 1, 1, 21, NULL, NULL, NULL, '0', NULL, NULL, 0, 1, NULL, NULL, 1400332548);

-- --------------------------------------------------------

--
-- Table structure for table `action_conditions`
--

CREATE TABLE IF NOT EXISTS `action_conditions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action_id` int(11) NOT NULL,
  `row_device_id` int(11) NOT NULL,
  `operator` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `condition_setpoint` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `buildings`
--

CREATE TABLE IF NOT EXISTS `buildings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `building_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_date` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `buildings`
--

INSERT INTO `buildings` (`id`, `building_name`, `description`, `status`, `created_date`, `created_by`) VALUES
(1, 'building 1', NULL, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE IF NOT EXISTS `devices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `eep` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `room_id` int(11) NOT NULL,
  `device_type_id` int(11) NOT NULL,
  `device_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created_date` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `layout_top_position` int(3) DEFAULT NULL,
  `layout_left_position` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`id`, `device_id`, `eep`, `room_id`, `device_type_id`, `device_name`, `description`, `created_date`, `created_by`, `status`, `layout_top_position`, `layout_left_position`) VALUES
(1, '0186CCCD', 'A52001', 1, 1, 'VALVE1.1.1.1', 'This is device 1', 1, 1, 1, NULL, NULL),
(2, '008BD382', 'F60302', 1, 2, 'SWITCH1.1.1.1', NULL, 1, 1, 1, NULL, NULL),
(4, 'C4141198', 'F6DA00', 1, 4, 'DLHUB1.1.1.1', NULL, 1, 1, 1, NULL, NULL),
(6, '0086A88D', '111111', 1, 6, 'EOHUB1.1.1.1', '192.168.0.1', 1, 1, 1, NULL, NULL),
(7, '00000000', '111111', 1, 7, 'WIFIAP1.1.1.1', NULL, 1, 1, 1, NULL, NULL),
(8, '018211CF', 'A51005', 1, 8, 'TEMP1.1.1.1', NULL, 1, 1, 1, NULL, NULL),
(9, '0005F0EB', 'A50701', 1, 9, 'PIR1.1.1.1', NULL, 1, 1, 1, NULL, NULL),
(10, '002DAC00', 'A52DAC', 1, 10, 'W2DAC1.1.1.1', NULL, 1, 1, 1, NULL, NULL),
(11, '001DAC00', 'A51DAC', 1, 11, 'W1DAC1.1.1.1', NULL, 1, 1, 1, NULL, NULL),
(12, '0183B036', 'D20101', 1, 12, 'W1R10NT1.1.1.1', NULL, 1, 1, 1, NULL, NULL),
(13, '01881790', 'A52001', 1, 1, 'VALVE2.1.1.1', NULL, 1, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `device_properties`
--

CREATE TABLE IF NOT EXISTS `device_properties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_date` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `device_properties`
--

INSERT INTO `device_properties` (`id`, `property_name`, `description`, `status`, `created_date`, `created_by`) VALUES
(1, 'ON/OFF', NULL, 1, 1, 1),
(2, 'Dimmer', NULL, 1, 1, 1),
(3, 'Temperature sensor', NULL, 1, 1, 1),
(4, ' Light sensor', NULL, 1, 1, 1),
(5, 'Occupancy detection 360°', NULL, 1, 1, 1),
(6, 'VDC', NULL, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `device_property_values`
--

CREATE TABLE IF NOT EXISTS `device_property_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) NOT NULL,
  `value_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `min_value` float NOT NULL,
  `max_value` float NOT NULL,
  `unit` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `device_property_values`
--

INSERT INTO `device_property_values` (`id`, `property_id`, `value_name`, `min_value`, `max_value`, `unit`) VALUES
(1, 2, NULL, 0, 100, 11),
(2, 3, NULL, 15, 25, 2),
(3, 4, NULL, 0, 510, 3),
(4, 6, NULL, 0, 10, 12);

-- --------------------------------------------------------

--
-- Table structure for table `device_setpoints`
--

CREATE TABLE IF NOT EXISTS `device_setpoints` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `row_device_id` int(11) DEFAULT NULL,
  `value` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `device_setpoints`
--

INSERT INTO `device_setpoints` (`id`, `row_device_id`, `value`) VALUES
(1, 1, 21),
(6, 10, 45),
(8, 11, 18),
(9, 12, 19),
(12, 9, 10),
(13, 8, 10),
(14, 8, 10),
(15, 13, 26);

-- --------------------------------------------------------

--
-- Table structure for table `device_setpoint_logs`
--

CREATE TABLE IF NOT EXISTS `device_setpoint_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `row_device_id` int(11) NOT NULL,
  `current_setpoint` int(11) NOT NULL,
  `log_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `device_setpoint_logs`
--

INSERT INTO `device_setpoint_logs` (`id`, `row_device_id`, `current_setpoint`, `log_time`) VALUES
(1, 13, 26, '2014-05-09 20:03:10'),
(2, 13, 26, '2014-05-09 20:07:03'),
(3, 13, 26, '2014-05-09 20:07:05');

-- --------------------------------------------------------

--
-- Table structure for table `device_states`
--

CREATE TABLE IF NOT EXISTS `device_states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_date` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `device_states`
--

INSERT INTO `device_states` (`id`, `state_name`, `created_date`, `created_by`) VALUES
(1, 'controlled', 1, 1),
(2, 'controller', 1, 1),
(3, 'input', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `device_types`
--

CREATE TABLE IF NOT EXISTS `device_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `controller_device` int(11) NOT NULL DEFAULT '0',
  `type_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type_short_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created_date` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `device_types`
--

INSERT INTO `device_types` (`id`, `state_id`, `controller_device`, `type_name`, `type_short_name`, `description`, `created_date`, `created_by`, `status`) VALUES
(1, '1', 6, 'Wireless valve actuator', 'VALVE', NULL, 1, 1, 1),
(2, '3', 6, 'Button switch', 'SWITCH', NULL, 1, 1, 1),
(4, '2', 6, 'DALI Controller', 'DLHUB', NULL, 1, 1, 1),
(5, '1', 4, 'LED fixture', 'LIGHT', NULL, 1, 1, 1),
(6, '2', 0, 'EnOceanHub ', 'EOHUB', 'The hub of EnOcean device', 1, 1, 1),
(7, '2', 0, 'Wi-Fi router', 'WIFIAP', 'The router/access point to provide the connection between many HUB and server.', 1, 1, 1),
(8, '3', 6, 'Wireless temperature sensor', 'TEMP', NULL, 1, 1, 1),
(9, '3', 6, 'Multilux Sensor PIR', 'PIR', NULL, 1, 1, 1),
(10, '1', 6, 'EnOcean Wireless Receiver with 1 Analog Output Channel', 'W2DAC', NULL, 1, 1, 1),
(11, '1', 6, 'Thermostat Receiver SRC-AO CLIMATE V', 'W1DAC', NULL, 1, 1, 1),
(12, '1', 6, 'One channel wireless actuator 10A in temperature management mode', 'W1R10NT', NULL, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `device_type_properties`
--

CREATE TABLE IF NOT EXISTS `device_type_properties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_type_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Dumping data for table `device_type_properties`
--

INSERT INTO `device_type_properties` (`id`, `device_type_id`, `property_id`) VALUES
(1, 1, 3),
(2, 2, 1),
(6, 12, 3),
(7, 10, 2),
(8, 11, 3),
(9, 1, 3),
(10, 9, 1),
(11, 8, 3);

-- --------------------------------------------------------

--
-- Table structure for table `floors`
--

CREATE TABLE IF NOT EXISTS `floors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `building_id` int(11) NOT NULL,
  `floor_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_date` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `floors`
--

INSERT INTO `floors` (`id`, `building_id`, `floor_name`, `description`, `status`, `created_date`, `created_by`) VALUES
(1, 1, 'Floor 1', NULL, 1, 1, 1),
(2, 1, 'Floor 2', NULL, 1, 1, 1),
(3, 1, 'Floor 3', NULL, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mode_control`
--

CREATE TABLE IF NOT EXISTS `mode_control` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mode_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_date` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `mode_control`
--

INSERT INTO `mode_control` (`id`, `mode_name`, `status`, `created_date`, `created_by`) VALUES
(2, 'Vacation mode', 1, 1399641332, NULL),
(3, 'Spring mode', 0, 1400249818, NULL),
(4, 'test', 0, 1400252165, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mode_control_details`
--

CREATE TABLE IF NOT EXISTS `mode_control_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mode_id` int(11) NOT NULL,
  `action_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Dumping data for table `mode_control_details`
--

INSERT INTO `mode_control_details` (`id`, `mode_id`, `action_id`) VALUES
(14, 3, 16),
(16, 3, 18);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE IF NOT EXISTS `rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zone_id` int(11) NOT NULL,
  `room_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_date` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `zone_id`, `room_name`, `description`, `status`, `created_date`, `created_by`) VALUES
(1, 1, 'Room 1', NULL, 1, 1, 1),
(2, 1, 'Room 2', NULL, 1, 1, 1),
(3, 1, 'Room 3', NULL, 1, 1, 1),
(4, 2, 'Room 4', NULL, 1, 1, 1),
(5, 3, 'Room 5', NULL, 1, 1, 1),
(6, 2, 'Room 6', NULL, 1, 1, 1),
(7, 4, 'Room 7', NULL, 1, 1, 1),
(8, 4, 'Room 8', NULL, 1, 1, 1),
(9, 5, 'Room 9 ', NULL, 1, 1, 1),
(10, 6, 'Room 10', NULL, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE IF NOT EXISTS `units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created_date` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `unit_name`, `description`, `created_date`, `created_by`) VALUES
(1, '°F', 'Fahrenheit', 1, 1),
(2, '°C', 'Celcius', 1, 1),
(3, 'lx', 'lux', 1, 1),
(4, 'ppm', 'ppm', 1, 1),
(5, 'lm', 'lm', 1, 1),
(6, 'cd', 'cd', 1, 1),
(7, 'cd/m2', 'cd/m2', 1, 1),
(8, 'kPa', 'kPa', 1, 1),
(9, 'kW', 'kW', 1, 1),
(10, 'kWh', 'kWh', 1, 1),
(11, '%', 'percent', 1, 1),
(12, 'volt', 'Volt', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `zones`
--

CREATE TABLE IF NOT EXISTS `zones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `floor_id` int(11) NOT NULL,
  `zone_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_date` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `zones`
--

INSERT INTO `zones` (`id`, `floor_id`, `zone_name`, `description`, `status`, `created_date`, `created_by`) VALUES
(1, 1, 'Zone 1', NULL, 1, 1, 1),
(2, 1, 'Zone 2', NULL, 1, 1, 1),
(3, 1, 'Zone 3', NULL, 1, 1, 1),
(4, 2, 'Zone 4', NULL, 1, 1, 1),
(5, 2, 'Zone 5', NULL, 1, 1, 1),
(6, 3, 'Zone 6', NULL, 1, 1, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
