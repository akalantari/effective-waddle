-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 03, 2021 at 01:09 PM
-- Server version: 10.3.31-MariaDB-0ubuntu0.20.04.1
-- PHP Version: 7.4.3

# Privileges for `jimdo`@`%`

GRANT ALL PRIVILEGES ON *.* TO `worker`@`%` IDENTIFIED BY PASSWORD '*2DF75C10CDEC18DAC41D3F10389E4807209AA14A' WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON `worker\_%`.* TO `worker`@`%`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `worker_example`
--
CREATE DATABASE IF NOT EXISTS `worker_example` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `worker_example`;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `worker_example`
--

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(10) UNSIGNED NOT NULL,
  `appId` varchar(64) NOT NULL,
  `uId` varchar(64) NOT NULL,
  `language` varchar(6) NOT NULL,
  `os` enum('ios','android') NOT NULL,
  `expiration_date` date NOT NULL,
  `status` enum('active','expired','cancelled') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `appId`, `uId`, `language`, `os`, `expiration_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 'fc8efeb1-22ae-11ec-9549-ea727b12ea5f', 'fc8f0373-22ae-11ec-9549-ea727b12ea5f', 'tr', 'ios', '2021-10-03', 'active', '2021-10-02 14:24:10', '2021-10-03 10:04:19'),
(2, '06b81112-22af-11ec-9549-ea727b12ea5f', '06b817c7-22af-11ec-9549-ea727b12ea5f', 'tr', 'ios', '2021-10-01', 'active', '2021-10-02 14:24:10', '2021-10-03 10:04:52'),
(3, '0c0dc03a-22af-11ec-9549-ea727b12ea5f', '0c0dc416-22af-11ec-9549-ea727b12ea5f', 'tr', 'android', '2021-10-01', 'active', '2021-10-02 14:24:10', '2021-10-03 10:04:52'),
(4, '105e4edb-22af-11ec-9549-ea727b12ea5f', '105e52b3-22af-11ec-9549-ea727b12ea5f', 'tr', 'android', '2021-10-01', 'active', '2021-10-02 14:24:10', '2021-10-03 10:04:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
