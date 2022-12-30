-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 29, 2022 at 03:11 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `system`
--

-- --------------------------------------------------------

--
-- Table structure for table `access`
--

CREATE TABLE `access` (
  `id` int(11) NOT NULL,
  `event` varchar(30) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `details` text NOT NULL,
  `dates` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `access`
--

INSERT INTO `access` (`id`, `event`, `ip`, `details`, `dates`, `id_user`) VALUES
(1, 'LOGOUT', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36 Edg/108.0.1462.46', '2022-12-28 22:58:38', 11),
(2, 'LOGIN', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36 Edg/108.0.1462.46', '2022-12-28 22:59:06', 11),
(3, 'LOGOUT', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36 Edg/108.0.1462.46', '2022-12-28 23:05:49', 11),
(4, 'LOGIN', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36 Edg/108.0.1462.46', '2022-12-28 23:05:54', 11),
(5, 'LOGIN', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36 Edg/108.0.1462.46', '2022-12-28 23:06:27', 11),
(6, 'LOGOUT', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36 Edg/108.0.1462.46', '2022-12-28 23:07:41', 11),
(7, 'LOGIN', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36 Edg/108.0.1462.46', '2022-12-28 23:08:01', 12),
(8, 'LOGOUT', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36 Edg/108.0.1462.46', '2022-12-28 23:39:05', 12),
(9, 'LOGIN', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36 Edg/108.0.1462.46', '2022-12-28 23:39:30', 12),
(10, 'LOGOUT', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36 Edg/108.0.1462.46', '2022-12-29 00:00:18', 12),
(11, 'LOGIN', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36 Edg/108.0.1462.46', '2022-12-29 00:00:20', 11),
(12, 'LOGOUT', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36 Edg/108.0.1462.46', '2022-12-29 00:26:43', 11),
(13, 'LOGIN', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36 Edg/108.0.1462.46', '2022-12-29 00:26:54', 11),
(14, 'LOGOUT', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36 Edg/108.0.1462.46', '2022-12-29 17:01:13', 11),
(15, 'LOGIN', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36 Edg/108.0.1462.46', '2022-12-29 17:01:17', 11),
(16, 'LOGOUT', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36 Edg/108.0.1462.46', '2022-12-29 18:35:54', 11),
(17, 'LOGIN', '10.0.0.57', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36 Edg/108.0.1462.46', '2022-12-29 18:36:16', 11),
(18, 'LOGIN', '10.0.0.198', 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_1_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.1 Mobile/15E148 Safari/604.1', '2022-12-29 18:42:19', 11),
(19, 'LOGOUT', '10.0.0.198', 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_1_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.1 Mobile/15E148 Safari/604.1', '2022-12-29 18:44:48', 11),
(20, 'LOGOUT', '10.0.0.57', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36 Edg/108.0.1462.46', '2022-12-29 19:23:27', 11),
(21, 'LOGIN', '10.0.0.57', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36 Edg/108.0.1462.46', '2022-12-29 19:23:34', 12),
(22, 'LOGOUT', '10.0.0.57', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36 Edg/108.0.1462.46', '2022-12-29 19:33:37', 12),
(23, 'LOGIN', '10.0.0.57', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36 Edg/108.0.1462.46', '2022-12-29 19:33:50', 11),
(24, 'LOGOUT', '10.0.0.57', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36 Edg/108.0.1462.46', '2022-12-29 19:50:24', 11),
(25, 'LOGIN', '10.0.0.57', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36 Edg/108.0.1462.46', '2022-12-29 19:51:12', 5),
(26, 'LOGOUT', '10.0.0.57', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36 Edg/108.0.1462.46', '2022-12-29 19:51:52', 5),
(27, 'LOGIN', '10.0.0.57', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36 Edg/108.0.1462.46', '2022-12-29 20:00:48', 5),
(28, 'LOGOUT', '10.0.0.57', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36 Edg/108.0.1462.46', '2022-12-29 20:05:54', 5),
(29, 'LOGIN', '10.0.0.57', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36 Edg/108.0.1462.46', '2022-12-29 20:06:06', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cash_register`
--

CREATE TABLE `cash_register` (
  `id` int(11) NOT NULL,
  `initial_amount` decimal(10,2) NOT NULL,
  `opening_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `closing_date` timestamp NULL DEFAULT NULL,
  `final_amount` decimal(10,2) DEFAULT NULL,
  `total_sale` int(11) DEFAULT NULL,
  `outcome` decimal(10,2) DEFAULT NULL,
  `expenses` decimal(10,2) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `dates` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `dates`, `status`) VALUES
(1, 'Technology', '2022-10-08 01:21:37', 1),
(2, 'Electronic', '2022-09-26 13:51:48', 1),
(3, 'Fruits', '2022-09-26 13:48:28', 1),
(4, 'Vehicules', '2022-12-29 17:33:18', 1),
(5, 'SmartPhones', '2022-10-06 21:30:51', 1),
(6, 'Tablets', '2022-09-30 13:34:26', 1),
(7, 'Laptop', '2022-09-26 13:52:05', 1),
(8, 'Planes', '2022-09-26 14:02:07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `identification` varchar(50) NOT NULL,
  `num_identity` varchar(15) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `dates` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `identification`, `num_identity`, `name`, `phone_number`, `email`, `address`, `dates`, `status`) VALUES
(1, 'Driver License', '123456', 'Randy Orton', '1111111111', 'randyorton@wwe.com', '1958 Log Town', '2022-10-28 14:12:58', 1),
(2, 'Maladie', '456789', 'Isabel Fuentes', '2222222222', 'isabelfuentes@telemundo.com', '147 rowe st', '2022-11-02 16:28:30', 1),
(3, 'Passport', '159753258', 'Passport Client', '1234567890', 'passport@client.ca', '<p>1594 Bldv Canada</p>', '2022-10-09 16:41:33', 0),
(4, 'Driver License', '147963654', 'Alex Ross', '4564568520', 'alex@ross.ca', '<p>6667 Ave Xmen</p>', '2022-11-17 02:38:02', 1),
(5, 'Maladie', '12124587', 'Ben Rayleigh', '7893215225', 'ben@rayleigh.com', '<p>1478 Ave Marvel</p>', '2022-10-09 16:37:33', 1),
(6, 'Passport', '85316497', 'Last Entry edited', '7893214560', 'last@entry.ca', '<p>15963 Ave Quebec</p>', '2022-10-09 16:23:10', 1),
(7, 'Driver License', '55664488', 'Tatoo Tazz', '3576824159', 'tatoo@tazz.live', '<p>123 Rue de Mars</p>', '2022-10-09 16:21:36', 1);

-- --------------------------------------------------------

--
-- Table structure for table `configuration`
--

CREATE TABLE `configuration` (
  `id` int(11) NOT NULL,
  `taxID` varchar(15) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone_number` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `message` text NOT NULL,
  `tax` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `configuration`
--

INSERT INTO `configuration` (`id`, `taxID`, `name`, `phone_number`, `email`, `address`, `message`, `tax`) VALUES
(1, '12345678912', 'K.A.Z. CORP', '1115559999', 'kascorp@krem.ca', '1547 Blvd Infinity', '<p>This Company Has two merged companies. <strong>KREM Animation Zoftware</strong> and <i>KREM Application Zoftware</i>, follow this<a href=\"https://www.w3schools.com/typescript/index.php\"> link</a>.</p>', 10);

-- --------------------------------------------------------

--
-- Table structure for table `credits`
--

CREATE TABLE `credits` (
  `id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `dates` date NOT NULL,
  `time_date` time NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `opening` int(11) NOT NULL DEFAULT 1,
  `id_sale` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `deposit`
--

CREATE TABLE `deposit` (
  `id` int(11) NOT NULL,
  `deposits` decimal(10,2) NOT NULL,
  `dates` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `opening` int(11) NOT NULL DEFAULT 1,
  `id_credit` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `detail_reserve`
--

CREATE TABLE `detail_reserve` (
  `id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `dates` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `opening` int(11) NOT NULL DEFAULT 1,
  `id_reserves` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` varchar(255) NOT NULL,
  `photo` varchar(150) DEFAULT NULL,
  `dates` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `opening` int(11) NOT NULL DEFAULT 1,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `movement` varchar(100) NOT NULL,
  `action` varchar(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `old_stock` int(11) NOT NULL,
  `actual_stock` int(11) NOT NULL,
  `dates` date NOT NULL,
  `time_day` time NOT NULL,
  `code` varchar(50) NOT NULL,
  `photo` varchar(100) DEFAULT NULL,
  `id_product` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `movement`, `action`, `quantity`, `old_stock`, `actual_stock`, `dates`, `time_day`, `code`, `photo`, `id_product`, `id_user`) VALUES
(1, 'Sale N°: 1', 'OUT INVENTORY', -5, 60, 55, '2022-11-25', '16:44:12', '12345', 'assets/images/products/20221007004334.jpg', 1, 11),
(2, 'Sale N°: 2', 'OUT INVENTORY', -10, 55, 45, '2022-11-25', '16:45:03', '12345', 'assets/images/products/20221007004334.jpg', 1, 11),
(3, 'Return Sale N°: 2', 'IN INVENTORY', 10, 45, 55, '2022-11-25', '16:45:33', '12345', 'assets/images/products/20221007004334.jpg', 1, 11),
(4, 'Purchase N°: 1', 'IN INVENTORY', 15, 55, 70, '2022-11-25', '16:46:59', '12345', 'assets/images/products/20221007004334.jpg', 1, 11),
(5, 'Purchase N°: 2', 'IN INVENTORY', 5, 70, 75, '2022-11-25', '16:47:36', '12345', 'assets/images/products/20221007004334.jpg', 1, 11),
(6, 'Return Purchase N°: 1', 'OUT INVENTORY', -15, 75, 60, '2022-11-25', '16:47:58', '12345', 'assets/images/products/20221007004334.jpg', 1, 11),
(7, 'Purchase N°: 3', 'IN INVENTORY', 10, 60, 70, '2022-11-25', '16:50:08', '12345', 'assets/images/products/20221007004334.jpg', 1, 11),
(8, 'Return Purchase N°: 3', 'OUT INVENTORY', -10, 70, 60, '2022-11-25', '16:55:17', '12345', 'assets/images/products/20221007004334.jpg', 1, 11),
(21, 'Reserve Delivered N°: 1', 'OUT INVENTORY', -10, 40, 30, '2022-12-21', '16:59:35', '12345', 'assets/images/products/20221007004334.jpg', 1, 11),
(22, 'Reserve Delivered N°: 2', 'OUT INVENTORY', -2, 30, 28, '2022-11-25', '18:19:37', '12345', 'assets/images/products/20221007004334.jpg', 1, 11),
(23, 'Reserve Pending N°: 3', 'OUT INVENTORY', -3, 28, 25, '2022-11-25', '18:18:56', '12345', 'assets/images/products/20221007004334.jpg', 1, 11),
(24, 'Reserve Cancelled N°: 1', 'IN INVENTORY', 10, 25, 35, '2022-11-25', '18:19:04', '12345', 'assets/images/products/20221007004334.jpg', 1, 11),
(25, 'Stock Adjustment', 'OUT INVENTORY', -1, 35, 34, '2022-11-25', '18:34:12', '12345', 'assets/images/products/20221007004334.jpg', 1, 11),
(26, 'Stock Adjustment', 'OUT INVENTORY', -1, 34, 33, '2022-11-25', '18:48:25', '12345', 'assets/images/products/20221007004334.jpg', 1, 11),
(27, 'Stock Adjustment', 'IN INVENTORY', 7, 33, 40, '2022-11-25', '18:49:15', '12345', 'assets/images/products/20221007004334.jpg', 1, 11),
(28, 'Sale N°: 3', 'OUT INVENTORY', -1, 40, 39, '2022-12-01', '15:58:57', '12345', 'assets/images/products/20221007004334.jpg', 1, 11),
(29, 'Sale N°: 3', 'OUT INVENTORY', -1, 35, 34, '2022-12-01', '15:58:57', '8520', 'assets/images/products/20221006214003.jpg', 23, 11),
(30, 'Sale N°: 4', 'OUT INVENTORY', -1, 39, 38, '2022-12-01', '15:59:33', '56789', 'assets/images/products/20221006213716.jpg', 21, 11),
(31, 'Sale N°: 4', 'OUT INVENTORY', -1, 36, 35, '2022-12-01', '15:59:33', '123456789', 'assets/images/products/20221006214149.jpg', 26, 11),
(32, 'Sale N°: 5', 'OUT INVENTORY', -3, 34, 31, '2022-12-01', '16:00:06', '8520', 'assets/images/products/20221006214003.jpg', 23, 11),
(33, 'Sale N°: 5', 'OUT INVENTORY', -100, 575, 475, '2022-12-01', '16:00:06', '456789', 'assets/images/products/20221006213810.jpg', 22, 11),
(34, 'Sale N°: 6', 'OUT INVENTORY', -10, 39, 29, '2022-12-01', '16:26:06', '12345', 'assets/images/products/20221007004334.jpg', 1, 11),
(35, 'Sale N°: 6', 'OUT INVENTORY', -15, 38, 23, '2022-12-01', '16:26:06', '56789', 'assets/images/products/20221006213716.jpg', 21, 11),
(36, 'Purchase N°: 4', 'IN INVENTORY', 1, 29, 30, '2022-12-21', '15:36:38', '12345', 'assets/images/products/20221007004334.jpg', 1, 11),
(37, 'Purchase N°: 4', 'IN INVENTORY', 2, 23, 25, '2022-12-21', '15:36:38', '56789', 'assets/images/products/20221006213716.jpg', 21, 11),
(38, 'Purchase N°: 4', 'IN INVENTORY', 3, 31, 34, '2022-12-21', '15:36:38', '8520', 'assets/images/products/20221006214003.jpg', 23, 11),
(39, 'Sale N°: 7', 'OUT INVENTORY', -1, 30, 29, '2022-12-21', '15:48:48', '12345', 'assets/images/products/20221007004334.jpg', 1, 11),
(40, 'Sale N°: 7', 'OUT INVENTORY', -2, 25, 23, '2022-12-21', '15:48:48', '56789', 'assets/images/products/20221006213716.jpg', 21, 11),
(41, 'Reserve Pending N°: 4', 'OUT INVENTORY', -1, 29, 28, '2022-12-21', '16:15:58', '12345', 'assets/images/products/20221007004334.jpg', 1, 11),
(42, 'Reserve Delivered N°: 1', 'OUT INVENTORY', -3, 28, 25, '2022-12-21', '16:59:35', '12345', 'assets/images/products/20221007004334.jpg', 1, 11),
(43, 'Reserve Delivered N°: 1', 'OUT INVENTORY', -1, 23, 22, '2022-12-21', '16:59:35', '56789', 'assets/images/products/20221006213716.jpg', 21, 11),
(44, 'Reserve Pending N°: 2', 'OUT INVENTORY', -1, 22, 21, '2022-12-21', '17:16:25', '56789', 'assets/images/products/20221006213716.jpg', 21, 11),
(45, 'Reserve Cancelled N°: 2', 'IN INVENTORY', 1, 21, 22, '2022-12-21', '17:19:03', '56789', 'assets/images/products/20221006213716.jpg', 21, 11),
(46, 'Sale N°: 8', 'OUT INVENTORY', -1, 34, 33, '2022-12-22', '11:41:16', '8520', 'assets/images/products/20221006214003.jpg', 23, 11),
(47, 'Purchase N°: 5', 'IN INVENTORY', 6, 25, 31, '2022-12-22', '16:40:23', '12345', 'assets/images/products/20221007004334.jpg', 1, 11),
(48, 'Purchase N°: 5', 'IN INVENTORY', 5, 22, 27, '2022-12-22', '16:40:23', '56789', 'assets/images/products/20221006213716.jpg', 21, 11),
(49, 'Purchase N°: 5', 'IN INVENTORY', 10, 33, 43, '2022-12-22', '16:40:23', '8520', 'assets/images/products/20221006214003.jpg', 23, 11),
(50, 'Sale N°: 9', 'OUT INVENTORY', -1, 27, 26, '2022-12-23', '13:49:16', '56789', 'assets/images/products/20221006213716.jpg', 21, 11),
(51, 'Reserve Pending N°: 3', 'OUT INVENTORY', -2, 43, 41, '2022-12-23', '13:54:11', '8520', 'assets/images/products/20221006214003.jpg', 23, 11),
(52, 'Reserve Pending N°: 4', 'OUT INVENTORY', -1, 26, 25, '2022-12-24', '16:57:59', '56789', 'assets/images/products/20221006213716.jpg', 21, 11);

-- --------------------------------------------------------

--
-- Table structure for table `measures`
--

CREATE TABLE `measures` (
  `id` int(11) NOT NULL,
  `measure` varchar(100) NOT NULL,
  `short_name` varchar(10) NOT NULL,
  `dates` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `measures`
--

INSERT INTO `measures` (`id`, `measure`, `short_name`, `dates`, `status`) VALUES
(1, 'KILOS', 'KL', '2022-09-23 16:00:06', 1),
(2, 'SEKY', 'CX', '2022-09-22 23:42:51', 0),
(3, 'CENTIMETER', 'CM', '2022-09-23 16:00:02', 1),
(6, 'LITER', 'LT', '2022-09-23 00:04:45', 1),
(9, 'KILOMETER', 'KM', '2022-09-22 13:54:27', 1),
(10, 'MILLIMETERS', 'MM', '2022-10-06 14:47:36', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `payment` decimal(10,2) NOT NULL,
  `dates` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_credit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `purchase_price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `photo` varchar(100) DEFAULT NULL,
  `barcode` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `dates` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `sales` int(11) NOT NULL DEFAULT 0,
  `id_measure` int(11) NOT NULL,
  `id_category` int(11) NOT NULL,
  `update_user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `code`, `description`, `purchase_price`, `sale_price`, `quantity`, `photo`, `barcode`, `status`, `dates`, `sales`, `id_measure`, `id_category`, `update_user_id`) VALUES
(1, '12345', 'LENOVO', '1150.00', '2450.00', 31, 'assets/images/products/20221007004334.jpg', 'assets/images/barcode/1.png', 1, '2022-12-26 16:15:39', 25, 1, 7, 11),
(21, '56789', 'MSI', '1052.00', '2896.00', 25, 'assets/images/products/20221006213716.jpg', 'assets/images/barcode/21.png', 1, '2022-12-26 16:15:39', 23, 1, 7, 11),
(22, '456789', 'Mango', '0.52', '1.35', 475, 'assets/images/products/20221006213810.jpg', 'assets/images/barcode/22.png', 1, '2022-12-29 17:32:21', 18, 1, 3, 11),
(23, '8520', 'SmartWatch', '125.00', '250.00', 41, 'assets/images/products/20221006214003.jpg', 'assets/images/barcode/23.png', 1, '2022-12-26 16:15:39', 8, 1, 1, 11),
(24, '845231', 'Plane Jet', '450550.00', '954236.00', 28, 'assets/images/products/20221006214048.jpg', 'assets/images/barcode/24.png', 1, '2022-12-26 16:15:39', 10, 9, 8, 11),
(25, '123456', 'IPAD', '375.00', '685.00', 48, 'assets/images/products/20221006214117.jpg', 'assets/images/barcode/25.png', 1, '2022-12-26 16:15:39', 14, 6, 6, 11),
(26, '123456789', 'TV Flat', '450.00', '741.00', 35, 'assets/images/products/20221006214149.jpg', 'assets/images/barcode/26.png', 1, '2022-12-26 16:15:40', 15, 1, 2, 11),
(28, '582645', 'Ferrari Aperta', '150000.00', '345000.00', 30, 'assets/images/products/20221007162621.jpg', 'assets/images/barcode/28.png', 1, '2022-12-26 16:15:40', 11, 9, 4, 11);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(11) NOT NULL,
  `products` longtext NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `purchase_tps` decimal(10,2) NOT NULL,
  `purchase_tvq` decimal(10,2) NOT NULL,
  `dates` date NOT NULL,
  `time_day` time NOT NULL,
  `serie` varchar(20) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `opening` int(11) NOT NULL DEFAULT 1,
  `id_supplier` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `quotes`
--

CREATE TABLE `quotes` (
  `id` int(11) NOT NULL,
  `products` longtext NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `quote_tps` decimal(10,2) NOT NULL,
  `quote_tvq` decimal(10,2) NOT NULL,
  `dates` date NOT NULL,
  `time_day` time NOT NULL,
  `pay_method` varchar(20) NOT NULL,
  `validity` varchar(30) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `id_client` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `reserves`
--

CREATE TABLE `reserves` (
  `id` int(11) NOT NULL,
  `products` longtext NOT NULL,
  `dates` date DEFAULT NULL,
  `time_day` time NOT NULL,
  `dates_reserves` datetime NOT NULL,
  `dates_withdraw` datetime NOT NULL,
  `payment` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `remaining` decimal(10,2) NOT NULL,
  `colors` varchar(15) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `id_client` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `products` longtext NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `sale_tps` decimal(10,2) NOT NULL,
  `sale_tvq` decimal(10,2) NOT NULL,
  `dates` date NOT NULL,
  `time_day` time NOT NULL,
  `pay_method` varchar(20) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `serie` varchar(20) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `opening` int(11) NOT NULL DEFAULT 1,
  `id_client` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `taxID` varchar(15) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone_number` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `dates` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `taxID`, `name`, `phone_number`, `email`, `address`, `dates`, `status`) VALUES
(1, '25258585', 'Ramdom Corp', '4566548520', 'ramdom@corp.live.ca', '547 Visual Studio', '2022-10-14 00:45:20', 1),
(2, '75321458741', 'KAZ Corp', '3579517931', 'kaz@corp.hotmail.ca', '1478 Blvd Netherlands', '2022-10-10 00:39:35', 1),
(3, '14567895', 'Zombi Corp', '4569871230', 'zombi@corp.live.com', '<p>753 Rue Zombiland</p>', '2022-10-10 00:44:37', 1),
(4, '2365841254', 'Soccer Ball', '1593574562', 'soccer@ball.ca', '<p>2552 Ave Toronto</p>', '2022-11-23 00:01:32', 1),
(5, '147147147', 'Lambda Corp', '9638528520', 'lambda@corp.com', '<p>2536 Rue de Combat</p>', '2022-11-23 00:02:33', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `address` varchar(255) NOT NULL,
  `profile` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(100) DEFAULT NULL,
  `dates` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 1,
  `rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone_number`, `address`, `profile`, `password`, `token`, `dates`, `status`, `rol`) VALUES
(1, 'Seky', 'Perez Moya', 'seky@kazcorp.com', '14384034548', '1873 rue de Breme H7M1Z8', 'assets/images/profile/Seky_Perez Moya_20221229143710.jpg', '$2y$10$r3mStiDYqJez27ubl6rEiOy1zAvcWv7W4UgOY1nltqXV07f3SAVnq', NULL, '2022-12-29 20:05:49', 1, 1),
(2, 'Bryant', 'Perez Genao', 'bryant@kazcorp.com', '4568529510', '1475 Rue Laval E8V5S7', 'assets/images/profile/Bryant_Perez Genao_20221229143927.jpg', '$2y$10$WKJXwe4apgMKm1wzZq9GROuczBrpZv8sMhPqrHpsGN60KgrFnlzhC', NULL, '2022-12-29 19:43:13', 1, 2),
(3, 'Hecsy', 'Nuñez', 'hecsy@kazcorp.com', '7891235831', '5913 rue Cartier', 'assets/images/profile/Hecsy_Nuñez_20221229144244.jpg', '$2y$10$AQMjB.W2WtdbkzJIySHT6.VEHnyVKXn3TB.WXXohiXSbvPro259ha', NULL, '2022-12-29 19:42:44', 1, 1),
(4, 'Eli', 'Pizarro', 'eli@kazcorp.com', '4560257531', '8833 rue Montreal T8M3Z6', 'assets/images/profile/Eli_Pizarro_20221229144508.jpg', '$2y$10$j5LiZZwnPcwuW/8emc.mFOlLTAPCRbXQokgsESgdMtjwiPAcTqHfC', NULL, '2022-12-29 19:45:08', 1, 1),
(5, 'Liobo', 'Perez Moya', 'liobo@kazcorp.com', '6647791133', '4487 rue Saint-Elzear Est J5Q6Z8', 'assets/images/profile/Liobo_Perez Moya_20221229144718.jpg', '$2y$10$Mu58wQLd9eGoRlCae54BPuolJoqHTOhqzfaqukozrI4BphpQTplWK', NULL, '2022-12-29 19:47:18', 1, 1),
(6, 'Alex', 'Vilvert', 'alex@kazcorp.com', '4413365522', '5566 Rue de Jambre L5A6R8', 'assets/images/profile/Alex_Vilvert_20221229144957.jpg', '$2y$10$ntZVTouXfbxUN8mI2MvlTO5D0GfVa3wtBbAJLCAmOuDjGH6lxOyVy', NULL, '2022-12-29 19:49:57', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access`
--
ALTER TABLE `access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash_register`
--
ALTER TABLE `cash_register`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `configuration`
--
ALTER TABLE `configuration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `credits`
--
ALTER TABLE `credits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sale` (`id_sale`);

--
-- Indexes for table `deposit`
--
ALTER TABLE `deposit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detail_reserve`
--
ALTER TABLE `detail_reserve`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_product` (`id_product`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `measures`
--
ALTER TABLE `measures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_credit` (`id_credit`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_category` (`id_category`),
  ADD KEY `id_measure` (`id_measure`),
  ADD KEY `products_ibfk_3` (`update_user_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_supplier` (`id_supplier`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `quotes`
--
ALTER TABLE `quotes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_client` (`id_client`),
  ADD KEY `quotes_ibfk_2` (`id_user`);

--
-- Indexes for table `reserves`
--
ALTER TABLE `reserves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_client` (`id_client`),
  ADD KEY `total` (`total`),
  ADD KEY `reserves_ibfk_2` (`id_user`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_client` (`id_client`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
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
-- AUTO_INCREMENT for table `access`
--
ALTER TABLE `access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `cash_register`
--
ALTER TABLE `cash_register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `configuration`
--
ALTER TABLE `configuration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `credits`
--
ALTER TABLE `credits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deposit`
--
ALTER TABLE `deposit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_reserve`
--
ALTER TABLE `detail_reserve`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `measures`
--
ALTER TABLE `measures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quotes`
--
ALTER TABLE `quotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reserves`
--
ALTER TABLE `reserves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cash_register`
--
ALTER TABLE `cash_register`
  ADD CONSTRAINT `cash_register_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `credits`
--
ALTER TABLE `credits`
  ADD CONSTRAINT `credits_ibfk_1` FOREIGN KEY (`id_sale`) REFERENCES `sales` (`id`);

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`id_product`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `inventory_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`id_credit`) REFERENCES `credits` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`id_measure`) REFERENCES `measures` (`id`),
  ADD CONSTRAINT `products_ibfk_3` FOREIGN KEY (`update_user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id`),
  ADD CONSTRAINT `purchases_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `quotes`
--
ALTER TABLE `quotes`
  ADD CONSTRAINT `quotes_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `quotes_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `reserves`
--
ALTER TABLE `reserves`
  ADD CONSTRAINT `reserves_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `reserves_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `sales_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
