-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 21, 2024 at 04:35 AM
-- Server version: 10.5.21-MariaDB-1:10.5.21+maria~ubu2004
-- PHP Version: 8.2.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_management_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `employee_hierarchy`
--

CREATE TABLE `employee_hierarchy` (
  `id` int(11) NOT NULL,
  `parent_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_hierarchy`
--

INSERT INTO `employee_hierarchy` (`id`, `parent_id`, `user_id`, `created_at`, `updated_at`) VALUES
(2, NULL, 16096390033569, '2024-11-07 04:58:17', '0000-00-00 00:00:00'),
(4, 16096390033569, 16825598905258, '2024-11-07 04:59:00', '0000-00-00 00:00:00'),
(8, 16825598905258, 16838855416673, '2024-11-05 07:01:48', '0000-00-00 00:00:00'),
(11, 16838855416673, 1672385124827, '2024-11-07 03:20:55', '2024-11-05 08:39:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employee_hierarchy`
--
ALTER TABLE `employee_hierarchy`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employee_hierarchy`
--
ALTER TABLE `employee_hierarchy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
