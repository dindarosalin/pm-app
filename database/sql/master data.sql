-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 21, 2024 at 04:29 AM
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
-- Table structure for table `categories`
--

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Resources', NULL, NULL),
(2, 'Hardware', NULL, '2024-11-05 01:35:56'),
(3, 'Software', '2024-11-05 01:36:06', '2024-11-05 01:36:06');

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--


--
-- Dumping data for table `holidays`
--

INSERT INTO `holidays` (`id`, `date`, `name`, `description`, `is_national`, `created_at`, `updated_at`) VALUES
(1, '2024-11-22', 'Libur coblosan update', 'coblosan 1 hari', 0, NULL, NULL),
(2, '2024-11-29', 'Ulang Tahun Korpri', '', 1, NULL, NULL);

--
-- Dumping data for table `project_statuses`
--

INSERT INTO `project_statuses` (`id`, `project_status`, `code_status`, `created_at`, `updated_at`) VALUES
(1, 'New', 'new', NULL, NULL),
(2, 'On Progress', 'onprogress', NULL, NULL),
(3, 'Complete', 'complete', NULL, NULL),
(4, 'Cancel', 'cancel', NULL, NULL),
(5, 'Hold', 'Hold', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--


--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `name`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'Software Engineer', 1, NULL, NULL),
(2, 'Network', 2, NULL, NULL),
(3, 'Mobile Engineer', 1, '2024-11-05 01:51:24', '2024-11-05 02:12:08'),
(5, 'Quality Asurance', 1, '2024-11-05 02:11:25', '2024-11-05 02:11:25'),
(6, 'UI / UX Designer', 1, '2024-11-05 02:12:31', '2024-11-05 02:12:31'),
(7, 'Network Engineer', 1, '2024-11-05 02:12:50', '2024-11-05 02:12:50'),
(8, 'Computer Vision', 1, '2024-11-05 02:13:05', '2024-11-05 02:13:05'),
(9, 'Sensor', 2, '2024-11-05 02:15:12', '2024-11-05 02:15:12'),
(10, 'Controller', 2, '2024-11-05 02:15:27', '2024-11-05 02:15:27'),
(11, 'Perangkat I/O', 2, '2024-11-05 02:19:41', '2024-11-05 02:19:41'),
(12, 'Domain', 3, '2024-11-05 02:19:56', '2024-11-05 02:19:56'),
(13, 'Plugin', 3, '2024-11-05 02:20:29', '2024-11-05 02:20:29'),
(14, 'Cloud', 3, '2024-11-05 02:20:42', '2024-11-05 02:20:42'),
(15, 'Manajer Inventaris', 1, '2024-11-08 08:18:01', '2024-11-08 08:18:01'),
(17, 'Staf Gudang', 1, '2024-11-08 08:24:59', '2024-11-08 08:24:59'),
(18, 'Pelatihan', 1, '2024-11-08 08:25:25', '2024-11-08 08:25:25'),
(19, 'PC', 2, '2024-11-08 08:25:51', '2024-11-08 08:25:51'),
(20, 'Barcode Scanner', 2, '2024-11-08 08:26:16', '2024-11-08 08:26:16'),
(21, 'Printer Barcode', 2, '2024-11-08 08:26:37', '2024-11-08 08:26:37'),
(22, 'Rak Penyimpanan', 2, '2024-11-08 08:27:02', '2024-11-08 08:27:02'),
(23, 'CCTV', 2, '2024-11-08 08:27:15', '2024-11-08 08:27:15'),
(24, 'Sistem Manajemen Inventaris (ERP)', 3, '2024-11-08 08:27:54', '2024-11-08 08:27:54'),
(25, 'Software Barcode Generator', 3, '2024-11-08 08:28:17', '2024-11-08 08:28:17'),
(26, 'Subscription Cloud Storage (50GB)', 3, '2024-11-08 08:28:59', '2024-11-08 08:28:59'),
(27, 'Technical Support', 1, '2024-11-08 09:06:29', '2024-11-08 09:06:29'),
(28, 'monitor', 2, '2024-11-08 09:09:03', '2024-11-08 09:09:03'),
(29, 'printer', 2, '2024-11-08 09:09:36', '2024-11-08 09:09:36'),
(30, 'meja dan kursi', 2, '2024-11-08 09:10:20', '2024-11-08 09:10:20'),
(31, 'Aksesoris (keyboard, mouse)', 2, '2024-11-08 09:11:26', '2024-11-08 09:11:26'),
(32, 'Software POS (Point Of Sale)', 3, '2024-11-08 09:12:32', '2024-11-08 09:12:32'),
(33, 'Lisensi Software', 3, '2024-11-08 09:13:14', '2024-11-08 09:56:22'),
(34, 'Pemeliharaan Software', 3, '2024-11-08 09:13:38', '2024-11-08 09:13:38'),
(35, 'Marketing', 1, '2024-11-08 09:52:13', '2024-11-08 09:52:13'),
(36, 'Operasional', 1, '2024-11-08 09:52:44', '2024-11-08 09:52:44'),
(37, 'Remote Contol', 2, '2024-11-08 09:53:19', '2024-11-08 09:53:19'),
(38, 'Microcontroller', 2, '2024-11-08 09:54:25', '2024-11-08 09:54:25'),
(39, 'Antena Wifi/bluetooth', 2, '2024-11-08 09:54:59', '2024-11-08 09:54:59'),
(40, 'Kabel dan Konektor', 2, '2024-11-08 09:55:26', '2024-11-08 09:55:26'),
(41, 'Pengembangan Aplikasi', 3, '2024-11-08 09:55:46', '2024-11-08 09:55:46');

--
-- Dumping data for table `task_categories`
--

INSERT INTO `task_categories` (`id`, `category_name`, `category_code`, `created_at`, `updated_at`) VALUES
(4, 'Analysis', 'analysis', NULL, NULL),
(5, 'Design', 'design', NULL, NULL),
(6, 'Develop', 'develop', NULL, NULL),
(7, 'Testing', 'testing', NULL, NULL);

--
-- Dumping data for table `task_flags`
--

INSERT INTO `task_flags` (`id`, `flag_name`, `flag_code`, `created_at`, `updated_at`) VALUES
(2, 'Feature', 'feature', NULL, NULL),
(3, 'Bug', 'bug', NULL, NULL),
(4, 'Change', 'change', NULL, NULL),
(5, 'Request', 'request', NULL, NULL),
(6, 'Architecture', 'architecture', NULL, NULL);

--
-- Dumping data for table `task_labels`
--

INSERT INTO `task_labels` (`id`, `label_name`, `label_code`, `created_at`, `updated_at`) VALUES
(1, 'label ', 'code ', NULL, NULL);

--
-- Dumping data for table `task_statuses`
--

INSERT INTO `task_statuses` (`id`, `task_status`, `created_at`, `updated_at`, `code_status`) VALUES
(1, 'New', NULL, NULL, 'new'),
(2, 'Assign', NULL, NULL, 'assign'),
(3, 'On Progress', NULL, NULL, 'onprogress'),
(4, 'Testing', NULL, NULL, 'testing'),
(5, 'Done', NULL, NULL, 'done'),
(6, 'Production', NULL, NULL, 'production'),
(7, 'Hold', NULL, NULL, 'hold'),
(8, 'Cancel', NULL, NULL, 'cancel');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
