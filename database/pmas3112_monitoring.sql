-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 04 Agu 2025 pada 22.53
-- Versi server: 11.4.7-MariaDB-cll-lve
-- Versi PHP: 8.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pmas3112_monitoring`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `app_menu`
--

CREATE TABLE `app_menu` (
  `menu_id` varchar(5) NOT NULL,
  `parent_menu_id` varchar(4) DEFAULT NULL,
  `menu_name` varchar(50) DEFAULT NULL,
  `menu_description` varchar(100) DEFAULT NULL,
  `menu_url` varchar(100) DEFAULT NULL,
  `menu_sort` int(10) UNSIGNED DEFAULT NULL,
  `menu_group` enum('utama','system','lainnya') DEFAULT 'utama',
  `menu_icon` varchar(50) DEFAULT NULL COMMENT 'mdi icon class',
  `menu_active` enum('1','0') DEFAULT '1',
  `menu_display` enum('1','0') DEFAULT '1',
  `created_by` varchar(15) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_by` varchar(15) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `app_menu`
--

INSERT INTO `app_menu` (`menu_id`, `parent_menu_id`, `menu_name`, `menu_description`, `menu_url`, `menu_sort`, `menu_group`, `menu_icon`, `menu_active`, `menu_display`, `created_by`, `created_date`, `modified_by`, `modified_date`) VALUES
('01', NULL, 'Setting', 'Menu Pengaturan', '#settings', 7, 'system', 'bx bx-category-alt', '1', '1', '16096390033565', '2021-01-05 13:12:06', '16096390033565', '2023-05-08 09:29:14'),
('02', '01', 'Role', 'Menu Role', 'settings/role', 1, 'system', 'fas fa-user-lock', '1', '1', '16096390033565', '2021-01-05 13:14:23', '16096390033565', '2021-08-10 16:43:40'),
('03', '01', 'Menu', 'Menu Navigation', 'settings/menu', 2, 'system', 'fas fa-user-lock', '1', '1', '16096390033565', '2021-01-05 13:14:23', '16096390033565', '2021-08-10 16:43:40'),
('04', '01', 'User Accounts', 'Menu Akun User', 'settings/accounts', 3, 'system', 'fas fa-users', '1', '1', '16096390033565', '2021-01-06 09:05:15', '16096390033565', '2023-05-08 09:29:54'),
('101', '97', 'Task Flag', 'task flag', '/master/task-flag', 3, 'utama', 'fa-solid fa-database', '1', '1', '16096390033569', '2024-12-09 16:24:15', NULL, NULL),
('102', '97', 'Task Label', 'Task Label', '/master/task-label', 4, 'utama', 'fa-solid fa-database', '1', '1', '16096390033569', '2024-12-09 16:25:09', NULL, NULL),
('103', '97', 'Task Category', 'Task Category', '/master/task-category', 5, 'utama', 'fa-solid fa-database', '1', '1', '16096390033569', '2024-12-09 16:26:07', NULL, NULL),
('104', '97', 'Budget Category', 'Budget Category', '/master/budget-category', 7, 'utama', 'fa-solid fa-database', '1', '1', '16096390033569', '2024-12-09 16:26:53', NULL, NULL),
('105', '97', 'Budget Sub Category', 'category budget', '/master/budget-subcategory', 6, 'utama', 'fa-solid fa-database', '1', '1', '16096390033569', '2024-12-09 16:27:52', '16096390033569', '2024-12-09 16:28:21'),
('106', '97', 'Holiday', 'Master holidays', '/master/holiday', 8, 'utama', 'fa-solid fa-database', '1', '1', '16096390033569', '2024-12-09 16:29:03', NULL, NULL),
('107', '97', 'Unit of Measure', 'UOM atau satuan', '/master/uom', 9, 'utama', 'fa-solid fa-database', '1', '1', '16096390033569', '2024-12-09 16:29:59', NULL, NULL),
('108', '01', 'Hierarchy', 'Hirarki menu', '/settings/hierarcy', 4, 'utama', 'fa fa-sitemap', '1', '1', '16096390033569', '2024-12-12 15:15:10', NULL, NULL),
('109', '90', 'Tasks', 'Task menu', '/projects/{projectId}/tasks', 3, 'utama', 'fa-solid fa-list-check', '1', '1', '16096390033569', '2024-12-13 15:15:46', NULL, NULL),
('110', '90', 'Dashboard', 'Project Dashboard', '/projects/{projectId}/', 1, 'utama', 'fa-solid fa-chart-simple', '1', '1', '16096390033569', '2024-12-13 15:17:14', NULL, NULL),
('111', '90', 'Calendar', 'Calendar', '/projects/{projectId}/calendar', 2, 'utama', 'fa-solid fa-calendar-week', '1', '1', '16096390033569', '2024-12-13 15:17:56', NULL, NULL),
('112', '90', 'Gantt Chart', 'Gantt Chart', '/projects/{projectId}/ganttchart', 4, 'utama', 'fa-solid fa-chart-gantt', '1', '1', '16096390033569', '2024-12-13 15:18:48', NULL, NULL),
('113', '90', 'Release Note', 'release Note', '/projects/{projectId}/release-note', 5, 'utama', 'fa-regular fa-note-sticky', '1', '1', '16096390033569', '2024-12-13 15:19:48', NULL, NULL),
('114', NULL, 'Work From Home', 'work from home', '#wfhCollapse', 5, 'utama', 'fa-solid fa-house-laptop', '1', '1', '16096390033569', '2025-01-19 07:08:46', '16096390033569', '2025-05-18 17:37:54'),
('115', '97', 'Status WFH', 'Status WFH', '/master/status-wfh', 10, 'utama', 'fa-solid fa-database', '1', '1', '16096390033569', '2025-03-08 15:06:09', '16096390033569', '2025-03-08 15:24:00'),
('116', '114', 'Work', 'wfh employee', '/work-from-home', 116, 'utama', 'fa-solid fa-house-laptop', '1', '1', '16096390033569', '2025-05-18 17:47:35', NULL, NULL),
('117', '114', 'Monitoring WFH', 'monitoring', '/work-from-home/monitor', 117, 'utama', 'fa-solid fa-house-laptop', '1', '1', '16096390033569', '2025-05-18 18:12:52', NULL, NULL),
('90', NULL, 'Projects', 'Daftar projects', '/projects', 1, 'utama', 'fa-solid fa-folder-closed', '1', '1', '16096390033569', '2024-12-09 10:00:39', NULL, NULL),
('93', NULL, 'Budget', 'Budgeting', '/budget', 2, 'utama', 'fa-solid fa-dollar-sign', '1', '1', '16096390033569', '2024-12-09 15:49:21', '16096390033569', '2024-12-09 15:53:36'),
('94', NULL, 'Report', 'Report project', '/report', 6, 'utama', 'fa-regular fa-flag', '1', '1', '16096390033569', '2024-12-09 16:03:56', '16096390033569', '2025-01-19 11:55:15'),
('95', NULL, 'Time Card', 'Time Card', '/time-card', 3, 'utama', 'fa-solid fa-stopwatch', '1', '1', '16096390033569', '2024-12-09 16:07:29', NULL, NULL),
('96', NULL, 'Resources Track', 'Resources track atau availibility tracking', '/availability-tracking', 4, 'utama', 'fa-solid fa-chart-column', '1', '1', '16096390033569', '2024-12-09 16:08:47', NULL, NULL),
('97', NULL, 'Master', 'master', '/master', 8, 'utama', 'fa-solid fa-database', '1', '1', '16096390033569', '2024-12-09 16:09:41', '16096390033569', '2025-01-19 11:55:33'),
('98', '97', 'Project Status', 'List Status Projet', '/master/project-status', 1, 'utama', 'fa-solid fa-database', '1', '1', '16096390033569', '2024-12-09 16:10:43', NULL, NULL),
('99', '97', 'Task Status', 'List status task', '/master/task-status', 2, 'utama', 'fa-solid fa-database', '1', '1', '16096390033569', '2024-12-09 16:11:31', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `app_menu_control`
--

CREATE TABLE `app_menu_control` (
  `id` int(11) NOT NULL,
  `menu_id` varchar(5) NOT NULL,
  `code` varchar(20) NOT NULL,
  `control_name` varchar(100) NOT NULL,
  `order_no` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `app_menu_control`
--

INSERT INTO `app_menu_control` (`id`, `menu_id`, `code`, `control_name`, `order_no`) VALUES
(5, '01', 'RTGP', 'Read Gate LPR Performance', 1),
(10, '01', 'C', 'Create', 1),
(11, '01', 'R', 'Read', 2),
(14, '01', 'U', 'Update', 3),
(15, '01', 'D', 'Delete', 4),
(16, '02', 'C', 'Create', 1),
(17, '02', 'R', 'Read', 2),
(18, '02', 'U', 'Update', 3),
(19, '02', 'D', 'Delete', 4),
(20, '03', 'C', 'Create', 1),
(21, '03', 'R', 'Read', 2),
(22, '03', 'U', 'Update', 3),
(23, '03', 'D', 'Delete', 4),
(28, '07', 'C', 'Create', 1),
(29, '07', 'R', 'Read', 2),
(30, '07', 'U', 'Update', 3),
(31, '07', 'D', 'Delete', 4),
(32, '02', 'UAR', 'Update Access Right', 5),
(33, '61', 'C', 'Create', 1),
(34, '61', 'R', 'Read', 2),
(35, '61', 'U', 'Update', 3),
(36, '61', 'D', 'Delete', 4),
(37, '93', 'CP', 'Create Budget Plan', 5),
(45, '04', 'C', 'Create', 1),
(46, '04', 'R', 'Read', 2),
(47, '04', 'U', 'Update', 3),
(48, '04', 'D', 'Delete', 4),
(49, '90', 'F', 'Filter', 12),
(50, '90', 'C', 'Create Project', 2),
(51, '90', 'U', 'Update Project', 3),
(53, '90', 'A', 'Archive Project', 5),
(54, '90', 'O', 'Open Project', 6),
(55, '104', 'C', 'Create', 1),
(56, '104', 'R', 'Read', 2),
(57, '104', 'U', 'Update', 3),
(58, '104', 'D', 'Delete', 4),
(59, '93', 'VL', 'View List Project', 1),
(60, '93', 'VP', 'View Budget Plan', 2),
(61, '93', 'VE', 'View Track Expense', 3),
(62, '93', 'F', 'Filter', 4),
(63, '93', 'EP', 'Export Budget Plan', 6),
(64, '93', 'UP', 'Update  Budget Plan', 7),
(65, '93', 'DP', 'Delete Budget Plan', 8),
(66, '93', 'CE', 'Create Track Expense', 9),
(67, '90', 'VA', 'View Archived Project', 7),
(68, '90', 'VD', 'View Detail Project', 8),
(69, '90', 'VL', 'View List Project', 9),
(70, '93', 'EE', 'Export Track Expense', 10),
(71, '93', 'UE', 'Update Track Expense', 11),
(72, '93', 'DE', 'Delete Track Expense', 12),
(74, '90', 'VAL', 'View Archived List', 10),
(75, '90', 'RA', 'Restore Archived Project', 11),
(76, '90', 'D', 'Delete Project Permanent', 4),
(77, '94', 'VL', 'View List Report', 1),
(78, '94', 'F', 'Filter', 2),
(79, '94', 'E', 'Exprot Report', 3),
(80, '95', 'VL', 'View Time Card List', 1),
(81, '95', 'C', 'Insert Duration and Status', 2),
(83, '95', 'F', 'Filter Time Card', 3),
(84, '95', 'VLt', 'View Task List', 4),
(85, '95', 'Ft', 'Filter Task', 5),
(86, '95', 'Vt', 'View Task Detail', 6),
(87, '95', 'DTt', 'Direct To Task', 7),
(88, '95', 'DTp', 'Direct To Project', 8),
(89, '96', 'VL', 'View List', 1),
(90, '96', 'F', 'Filter', 2),
(91, '98', 'C', 'Create', 1),
(92, '98', 'R', 'Read', 2),
(93, '98', 'U', 'Update', 3),
(94, '98', 'D', 'Delete', 4),
(95, '99', 'C', 'Create', 1),
(96, '99', 'R', 'Read', 2),
(97, '99', 'U', 'Update', 3),
(98, '99', 'D', 'Delete', 4),
(99, '101', 'C', 'Create', 1),
(100, '101', 'R', 'Read', 2),
(101, '101', 'U', 'Update', 3),
(102, '101', 'D', 'Delete', 4),
(103, '102', 'C', 'Create', 1),
(104, '102', 'R', 'Read', 2),
(105, '102', 'U', 'Update', 3),
(106, '102', 'D', 'Delete', 4),
(107, '103', 'C', 'Create', 1),
(108, '103', 'R', 'Read', 2),
(109, '103', 'U', 'Update', 3),
(110, '103', 'D', 'Delete', 4),
(111, '105', 'C', 'Create', 1),
(112, '105', 'R', 'Read', 2),
(113, '105', 'U', 'Update', 3),
(114, '105', 'D', 'Delete', 4),
(115, '106', 'C', 'Create', 1),
(116, '106', 'R', 'Read', 2),
(117, '106', 'U', 'Update', 3),
(118, '106', 'D', 'Delete', 4),
(119, '107', 'C', 'Create', 1),
(120, '107', 'R', 'Read', 2),
(121, '107', 'U', 'Update', 3),
(122, '107', 'D', 'Delete', 4),
(123, '108', 'C', 'Create', 1),
(124, '108', 'R', 'Read', 2),
(125, '108', 'U', 'Update', 3),
(126, '108', 'D', 'Delete', 4),
(127, '90', 'R', 'Read', 1),
(128, '93', 'R', 'Read', 13),
(129, '95', 'R', 'Read', 9),
(130, '96', 'R', 'Read', 3),
(131, '94', 'R', 'Read', 4),
(132, '110', 'R', 'Read', 1),
(133, '109', 'R', 'Read', 1),
(134, '109', 'C', 'Create', 2),
(135, '109', 'U', 'Update', 3),
(136, '109', 'D', 'Delete', 4),
(137, '109', 'A', 'Archive', 5),
(138, '109', 'F', 'Filter', 6),
(139, '111', 'R', 'Read', 1),
(140, '112', 'R', 'Read', 1),
(141, '113', 'C', 'Create', 1),
(142, '113', 'R', 'Read', 2),
(143, '113', 'U', 'Update', 3),
(144, '113', 'D', 'Delete', 4),
(145, '114', 'C', 'Create', 1),
(146, '114', 'R', 'Read', 2),
(147, '114', 'U', 'Update', 3),
(148, '114', 'D', 'Delete', 4),
(149, '115', 'C', 'Create', 1),
(150, '115', 'R', 'Read', 2),
(151, '115', 'U', 'Update', 3),
(152, '115', 'D', 'Delete', 4),
(153, '116', 'C', 'Create', 1),
(154, '116', 'R', 'Read', 2),
(155, '116', 'U', 'Update', 3),
(156, '116', 'D', 'Delete', 4),
(158, '117', 'R', 'Read', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `app_role`
--

CREATE TABLE `app_role` (
  `role_id` varchar(2) NOT NULL,
  `role_name` varchar(100) DEFAULT NULL,
  `role_description` varchar(100) DEFAULT NULL,
  `role_permission` varchar(4) DEFAULT '1000',
  `created_by` varchar(15) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_by` varchar(15) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `app_role`
--

INSERT INTO `app_role` (`role_id`, `role_name`, `role_description`, `role_permission`, `created_by`, `created_date`, `modified_by`, `modified_date`) VALUES
('01', 'Super Admin', 'Pengelola aplikasi, akun dan hak akses.', '1111', '16096390033565', '2021-01-04 08:59:24', NULL, NULL),
('02', 'Marketing', 'Marketing and Finance', '1111', '16096390033565', '2023-03-17 10:11:44', NULL, NULL),
('03', 'Finance', 'Finance', '1111', '16096390033565', '2023-03-17 10:12:02', NULL, NULL),
('04', 'Tax Officer', 'Petugas pajak', '1111', '16096390033565', '2023-03-17 10:12:40', '16096390033565', '2023-05-02 14:11:31'),
('05', 'Staff', 'Staff per divisi', '1111', '16096390033565', '2023-03-24 13:33:07', NULL, NULL),
('06', 'Head', 'Kepala bagian dari masing masing divisi', '1111', '16096390033565', '2023-03-24 13:33:30', NULL, NULL),
('07', 'CTO', 'Chief Technology Officer', '1111', '16096390033565', '2023-03-24 13:36:33', NULL, NULL),
('08', 'Corporate GA and Finance', '-', '1111', '16096390033565', '2023-03-24 13:38:55', NULL, NULL),
('09', 'CEO', '-', '1111', '16096390033565', '2023-03-24 13:39:12', NULL, NULL),
('10', 'HR', 'Human Resource', '1111', '16096390033565', '2023-04-01 20:59:40', NULL, NULL),
('20', 'Admin', 'Admin', '1111', '16096390033565', '2023-04-26 11:08:15', '16096390033569', '2024-12-11 10:10:49'),
('21', 'Project Manager', 'Project Manager', '1111', '16096390033565', '2023-05-12 16:37:45', NULL, NULL),
('22', 'Laporan', 'Laporan', '0100', '16096390033565', '2023-12-15 11:20:18', NULL, NULL),
('23', 'Client', 'Client', '1111', '16096390033565', '2024-02-07 14:19:58', NULL, NULL),
('24', 'PIC', 'PIC Pekerjaan', '1111', '16096390033565', '2024-02-07 14:20:19', NULL, NULL),
('25', 'Admin Setting', 'Admin Setting', '1111', '16096390033565', '2024-02-16 14:39:15', NULL, NULL),
('26', 'User Ticket Management', 'User Ticket Management', '1111', '17156549645531', '2024-08-29 08:35:25', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `app_role_menu`
--

CREATE TABLE `app_role_menu` (
  `role_id` varchar(2) NOT NULL,
  `menu_id` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `app_role_menu`
--

INSERT INTO `app_role_menu` (`role_id`, `menu_id`) VALUES
('01', '01'),
('01', '02'),
('01', '03'),
('01', '04'),
('01', '101'),
('01', '102'),
('01', '103'),
('01', '104'),
('01', '105'),
('01', '106'),
('01', '107'),
('01', '108'),
('01', '109'),
('01', '110'),
('01', '111'),
('01', '112'),
('01', '113'),
('01', '114'),
('01', '115'),
('01', '116'),
('01', '117'),
('01', '90'),
('01', '93'),
('01', '94'),
('01', '95'),
('01', '96'),
('01', '97'),
('01', '98'),
('01', '99'),
('02', '01'),
('03', '01'),
('04', '01'),
('05', '01'),
('06', '01'),
('07', '01'),
('08', '01'),
('09', '01'),
('10', '01'),
('20', '01'),
('20', '03'),
('25', '01'),
('25', '02'),
('25', '04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `app_role_menu_control`
--

CREATE TABLE `app_role_menu_control` (
  `role_id` varchar(2) NOT NULL,
  `menu_id` varchar(5) NOT NULL,
  `menu_control_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `app_role_menu_control`
--

INSERT INTO `app_role_menu_control` (`role_id`, `menu_id`, `menu_control_id`) VALUES
('01', '01', 1),
('01', '01', 2),
('01', '01', 3),
('01', '01', 4),
('01', '01', 5),
('01', '01', 6),
('01', '01', 7),
('01', '01', 8),
('01', '01', 9),
('01', '01', 10),
('01', '01', 11),
('01', '01', 12),
('01', '01', 13),
('01', '01', 14),
('01', '02', 16),
('01', '02', 17),
('01', '02', 18),
('01', '02', 19),
('01', '02', 32),
('01', '03', 20),
('01', '03', 21),
('01', '03', 22),
('01', '03', 23),
('01', '04', 24),
('01', '04', 25),
('01', '04', 26),
('01', '04', 27),
('01', '04', 45),
('01', '04', 46),
('01', '04', 47),
('01', '04', 48),
('01', '07', 28),
('01', '07', 29),
('01', '07', 30),
('01', '07', 31),
('01', '101', 99),
('01', '101', 100),
('01', '101', 101),
('01', '101', 102),
('01', '102', 103),
('01', '102', 104),
('01', '102', 105),
('01', '102', 106),
('01', '103', 107),
('01', '103', 108),
('01', '103', 109),
('01', '103', 110),
('01', '104', 55),
('01', '104', 56),
('01', '104', 57),
('01', '104', 58),
('01', '105', 111),
('01', '105', 112),
('01', '105', 113),
('01', '105', 114),
('01', '106', 115),
('01', '106', 116),
('01', '106', 117),
('01', '106', 118),
('01', '107', 119),
('01', '107', 120),
('01', '107', 121),
('01', '107', 122),
('01', '108', 123),
('01', '108', 124),
('01', '108', 125),
('01', '108', 126),
('01', '109', 133),
('01', '109', 134),
('01', '109', 135),
('01', '109', 136),
('01', '109', 137),
('01', '109', 138),
('01', '110', 132),
('01', '111', 139),
('01', '112', 140),
('01', '113', 141),
('01', '113', 142),
('01', '113', 143),
('01', '113', 144),
('01', '114', 145),
('01', '114', 146),
('01', '114', 147),
('01', '114', 148),
('01', '115', 149),
('01', '115', 150),
('01', '115', 151),
('01', '115', 152),
('01', '116', 153),
('01', '116', 154),
('01', '116', 155),
('01', '116', 156),
('01', '117', 157),
('01', '117', 158),
('01', '117', 159),
('01', '117', 160),
('01', '61', 33),
('01', '61', 34),
('01', '61', 35),
('01', '61', 36),
('01', '90', 49),
('01', '90', 50),
('01', '90', 51),
('01', '90', 52),
('01', '90', 53),
('01', '90', 54),
('01', '90', 67),
('01', '90', 68),
('01', '90', 69),
('01', '90', 73),
('01', '90', 74),
('01', '90', 75),
('01', '90', 76),
('01', '90', 127),
('01', '93', 37),
('01', '93', 38),
('01', '93', 39),
('01', '93', 40),
('01', '93', 41),
('01', '93', 42),
('01', '93', 43),
('01', '93', 44),
('01', '93', 59),
('01', '93', 60),
('01', '93', 61),
('01', '93', 62),
('01', '93', 63),
('01', '93', 64),
('01', '93', 65),
('01', '93', 66),
('01', '93', 70),
('01', '93', 71),
('01', '93', 72),
('01', '93', 128),
('01', '94', 77),
('01', '94', 78),
('01', '94', 79),
('01', '94', 131),
('01', '95', 80),
('01', '95', 81),
('01', '95', 82),
('01', '95', 83),
('01', '95', 84),
('01', '95', 85),
('01', '95', 86),
('01', '95', 87),
('01', '95', 88),
('01', '95', 129),
('01', '96', 89),
('01', '96', 90),
('01', '96', 130),
('01', '98', 91),
('01', '98', 92),
('01', '98', 93),
('01', '98', 94),
('01', '99', 95),
('01', '99', 96),
('01', '99', 97),
('01', '99', 98),
('02', '114', 145),
('02', '114', 146),
('02', '114', 147),
('02', '114', 148),
('02', '116', 153),
('02', '116', 154),
('02', '116', 155),
('02', '116', 156),
('05', '109', 133),
('05', '109', 134),
('05', '109', 135),
('05', '109', 137),
('05', '109', 138),
('05', '110', 132),
('05', '111', 139),
('05', '112', 140),
('05', '113', 141),
('05', '113', 142),
('05', '113', 143),
('05', '113', 144),
('05', '114', 145),
('05', '114', 146),
('05', '114', 147),
('05', '114', 148),
('05', '116', 153),
('05', '116', 154),
('05', '116', 155),
('05', '116', 156),
('05', '90', 49),
('05', '90', 50),
('05', '90', 51),
('05', '90', 53),
('05', '90', 54),
('05', '90', 67),
('05', '90', 68),
('05', '90', 69),
('05', '90', 74),
('05', '90', 75),
('05', '90', 127),
('05', '94', 77),
('05', '94', 78),
('05', '94', 79),
('05', '94', 131),
('05', '95', 80),
('05', '95', 81),
('05', '95', 83),
('05', '95', 84),
('05', '95', 85),
('05', '95', 86),
('05', '95', 87),
('05', '95', 88),
('05', '95', 129),
('05', '96', 89),
('05', '96', 90),
('05', '96', 130),
('10', '114', 145),
('10', '114', 146),
('10', '114', 147),
('10', '114', 148),
('10', '116', 153),
('10', '116', 154),
('10', '116', 155),
('10', '116', 156),
('10', '117', 158),
('20', '01', 5),
('20', '01', 10),
('20', '01', 11),
('20', '01', 14),
('20', '01', 15),
('20', '02', 16),
('20', '02', 17),
('20', '02', 18),
('20', '02', 19),
('20', '02', 32),
('20', '03', 20),
('20', '03', 21),
('20', '03', 22),
('20', '03', 23),
('20', '04', 45),
('20', '04', 46),
('20', '04', 47),
('20', '04', 48),
('20', '07', 28),
('20', '07', 29),
('20', '07', 30),
('20', '07', 31),
('20', '101', 99),
('20', '101', 100),
('20', '101', 101),
('20', '101', 102),
('20', '102', 103),
('20', '102', 104),
('20', '102', 105),
('20', '102', 106),
('20', '103', 107),
('20', '103', 108),
('20', '103', 109),
('20', '103', 110),
('20', '104', 55),
('20', '104', 56),
('20', '104', 57),
('20', '104', 58),
('20', '105', 111),
('20', '105', 112),
('20', '105', 113),
('20', '105', 114),
('20', '106', 115),
('20', '106', 116),
('20', '106', 117),
('20', '106', 118),
('20', '107', 119),
('20', '107', 120),
('20', '107', 121),
('20', '107', 122),
('20', '108', 123),
('20', '108', 124),
('20', '108', 125),
('20', '108', 126),
('20', '61', 33),
('20', '61', 34),
('20', '61', 35),
('20', '61', 36),
('20', '90', 49),
('20', '90', 50),
('20', '90', 51),
('20', '90', 53),
('20', '90', 54),
('20', '90', 67),
('20', '90', 68),
('20', '90', 69),
('20', '90', 74),
('20', '90', 75),
('20', '90', 76),
('20', '93', 37),
('20', '93', 59),
('20', '93', 60),
('20', '93', 61),
('20', '93', 62),
('20', '93', 63),
('20', '93', 64),
('20', '93', 65),
('20', '93', 66),
('20', '93', 70),
('20', '93', 71),
('20', '93', 72),
('20', '94', 77),
('20', '94', 78),
('20', '94', 79),
('20', '95', 80),
('20', '95', 81),
('20', '95', 83),
('20', '95', 84),
('20', '95', 85),
('20', '95', 86),
('20', '95', 87),
('20', '95', 88),
('20', '96', 89),
('20', '96', 90),
('20', '98', 91),
('20', '98', 92),
('20', '98', 93),
('20', '98', 94),
('20', '99', 95),
('20', '99', 96),
('20', '99', 97),
('20', '99', 98),
('25', '01', 5),
('25', '01', 10),
('25', '01', 11),
('25', '01', 14),
('25', '01', 15),
('25', '101', 99),
('25', '101', 100),
('25', '101', 101),
('25', '101', 102),
('25', '102', 103),
('25', '102', 104),
('25', '102', 105),
('25', '102', 106),
('25', '103', 107),
('25', '103', 108),
('25', '103', 109),
('25', '103', 110),
('25', '104', 55),
('25', '104', 56),
('25', '104', 57),
('25', '104', 58),
('25', '105', 111),
('25', '105', 112),
('25', '105', 113),
('25', '105', 114),
('25', '106', 115),
('25', '106', 116),
('25', '106', 117),
('25', '106', 118),
('25', '107', 119),
('25', '107', 120),
('25', '107', 121),
('25', '107', 122),
('25', '108', 123),
('25', '108', 124),
('25', '108', 125),
('25', '108', 126),
('25', '109', 133),
('25', '109', 134),
('25', '109', 135),
('25', '109', 136),
('25', '109', 137),
('25', '109', 138),
('25', '110', 132),
('25', '114', 145),
('25', '114', 146),
('25', '114', 147),
('25', '114', 148),
('25', '115', 149),
('25', '115', 150),
('25', '115', 151),
('25', '115', 152),
('25', '116', 153),
('25', '116', 154),
('25', '116', 155),
('25', '116', 156),
('25', '90', 49),
('25', '90', 50),
('25', '90', 51),
('25', '90', 53),
('25', '90', 54),
('25', '90', 67),
('25', '90', 68),
('25', '90', 69),
('25', '90', 74),
('25', '90', 75),
('25', '90', 127),
('25', '94', 77),
('25', '94', 78),
('25', '94', 79),
('25', '94', 131),
('25', '95', 80),
('25', '95', 81),
('25', '95', 83),
('25', '95', 84),
('25', '95', 85),
('25', '95', 86),
('25', '95', 87),
('25', '95', 88),
('25', '95', 129),
('25', '98', 91),
('25', '98', 92),
('25', '98', 93),
('25', '98', 94),
('25', '99', 95),
('25', '99', 96),
('25', '99', 97),
('25', '99', 98);

-- --------------------------------------------------------

--
-- Struktur dari tabel `app_role_user`
--

CREATE TABLE `app_role_user` (
  `role_id` varchar(2) NOT NULL,
  `user_id` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `app_role_user`
--

INSERT INTO `app_role_user` (`role_id`, `user_id`) VALUES
('01', '16096390033565'),
('01', '16096390033569'),
('01', '16723865912539'),
('01', '16825534938493'),
('01', '17156549645531'),
('02', '16762552150281'),
('05', '1672385124827'),
('05', '17217931175057'),
('08', '16723846172251'),
('10', '16825586100408'),
('20', '16825598905258'),
('20', '3333333333'),
('25', '16837053916801');

-- --------------------------------------------------------

--
-- Struktur dari tabel `app_user`
--

CREATE TABLE `app_user` (
  `user_id` varchar(15) NOT NULL,
  `user_name` varchar(50) DEFAULT NULL,
  `type` enum('umum','head','pic','admin') NOT NULL,
  `user_email` varchar(50) DEFAULT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_active` enum('1','0') NOT NULL DEFAULT '1',
  `user_img_path` varchar(100) DEFAULT NULL,
  `user_img_name` varchar(200) DEFAULT NULL,
  `no_telp` varchar(15) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `created_by` varchar(15) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_by` varchar(15) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `app_user`
--

INSERT INTO `app_user` (`user_id`, `user_name`, `type`, `user_email`, `user_password`, `user_active`, `user_img_path`, `user_img_name`, `no_telp`, `description`, `employee_id`, `created_by`, `created_date`, `modified_by`, `modified_date`) VALUES
('1111111111', 'User Test 1', 'umum', 'usertest1@xyz.com', '$2y$10$aVOLRX7QpbptaBeIhM6glOL4DE35iMeWFyb9aybW3ucqi17NtFd7S', '1', NULL, NULL, NULL, NULL, NULL, NULL, '2020-12-13 15:03:58', NULL, NULL),
('16096390033565', 'Super Admin ABA', 'umum', 'admin@gmail.com', '$2y$10$aVOLRX7QpbptaBeIhM6glOL4DE35iMeWFyb9aybW3ucqi17NtFd7S', '1', '/img/user/', 'super-admin-aba-63ae9c560ac7b.jpg', NULL, NULL, NULL, '2006000001', '2020-12-13 15:03:58', '16096390033565', '2023-05-22 14:49:47'),
('16096390033569', 'Super Admin', 'head', 'admin2@abarobotics.com', '$2y$10$aVOLRX7QpbptaBeIhM6glOL4DE35iMeWFyb9aybW3ucqi17NtFd7S', '1', '/img/user/', 'super-admin-aba-63ae9c560ac7b.jpg', NULL, NULL, NULL, '2006000001', '2020-12-13 15:03:58', '16096390033569', '2024-08-30 15:34:38'),
('16723846172251', 'Hendri ', 'umum', 'hendri@gmail.com', '$2y$10$aVOLRX7QpbptaBeIhM6glOL4DE35iMeWFyb9aybW3ucqi17NtFd7S', '1', '/img/user/', 'hendri-setiawan-6461dbaa2e86d.jpg', '085290919576', '\"Sebaik-baik orang adalah yang bermanfaat bagi orang lain\".', 61, '16096390033565', '2022-12-30 14:16:57', '16723846172251', '2023-05-19 14:26:52'),
('1672385124827', 'Yudi Arif', 'umum', 'user1@abarobotics.com', '$2y$10$aVOLRX7QpbptaBeIhM6glOL4DE35iMeWFyb9aybW3ucqi17NtFd7S', '1', '/img/user/', 'yudi-arif-kurniawan-63ae96144e84d.jpg', NULL, NULL, 78, '16096390033565', '2022-12-30 14:25:24', '16096390033565', '2023-04-27 08:18:02'),
('16723865912539', 'Dimas', 'umum', 'dimas@gmail.com', '$2y$10$aVOLRX7QpbptaBeIhM6glOL4DE35iMeWFyb9aybW3ucqi17NtFd7S', '1', '/img/user/', 'dimas-arfiantino-646b17b714018.jpg', '082221111428', NULL, 66, '1672385124827', '2022-12-30 14:49:51', '16096390033565', '2024-03-27 12:18:58'),
('16762552150281', 'Maulana', 'umum', 'maulana@gmail.com', '$2y$10$aVOLRX7QpbptaBeIhM6glOL4DE35iMeWFyb9aybW3ucqi17NtFd7S', '1', '/img/user/', 'maulana-hanif-ghifari-64337bd4168e0.jpg', '081222205321', NULL, 75, '1672385124827', '2023-02-13 09:26:55', '16762552150281', '2024-04-25 17:46:01'),
('16825534938493', 'Barr', 'umum', 'barr@gmail.com', '$2y$10$aVOLRX7QpbptaBeIhM6glOL4DE35iMeWFyb9aybW3ucqi17NtFd7S', '1', '/img/user/', 'abdul-barr-6461e09fd1de5.jpg', '6287877733447', NULL, 79, NULL, NULL, '1719562608674', '2024-06-28 15:25:41'),
('16825586100408', 'Nurfitri', 'umum', 'asih.nurfitri@gmail.com', '$2y$10$aVOLRX7QpbptaBeIhM6glOL4DE35iMeWFyb9aybW3ucqi17NtFd7S', '1', '/img/user/', 'asih-nurfitri-6461e83b29c68.jpg', NULL, NULL, 65, '16096390033565', '2023-04-27 08:23:30', '16825586100408', '2023-05-19 11:28:48'),
('16825598905258', 'Kauchya', 'umum', 'gkn@gmail.com', '$2y$10$aVOLRX7QpbptaBeIhM6glOL4DE35iMeWFyb9aybW3ucqi17NtFd7S', '1', '/img/user/', 'ghanis-kauchya-nugraha-6451c6fea6f47.jpg', NULL, NULL, 69, '16096390033565', '2023-04-27 08:44:50', '16825598905258', '2024-01-10 08:37:11'),
('16837053916801', 'Dwi', 'umum', 'user2@gmail.com', '$2y$10$aVOLRX7QpbptaBeIhM6glOL4DE35iMeWFyb9aybW3ucqi17NtFd7S', '1', '/img/user/', 'dwi-nurfatma-646475902e0ed.jpg', NULL, NULL, 67, '16096390033565', '2023-05-10 14:56:31', '16096390033565', '2024-02-16 14:41:20'),
('17156549645531', 'Wahyu', 'umum', 'wahyu@gmail.com', '$2y$10$aVOLRX7QpbptaBeIhM6glOL4DE35iMeWFyb9aybW3ucqi17NtFd7S', '1', '/img/user/', 'default.png', '081223861108', NULL, 97, '16096390033565', '2024-05-14 09:49:24', NULL, NULL),
('17217931175057', 'Bagaskara', 'umum', 'user3@gmail.com', '$2y$10$aVOLRX7QpbptaBeIhM6glOL4DE35iMeWFyb9aybW3ucqi17NtFd7S', '1', '/img/user/', 'default.png', NULL, NULL, 110, '16837053916801', '2024-07-24 10:51:57', '17217931175057', '2024-07-24 10:59:52'),
('2222222222', 'User Test 2', 'umum', 'usertest2@abarobotics.com', '$2y$10$aVOLRX7QpbptaBeIhM6glOL4DE35iMeWFyb9aybW3ucqi17NtFd7S', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('3333333333', 'User Test 3', 'umum', 'usertest3@abarobotics.com', '$2y$10$aVOLRX7QpbptaBeIhM6glOL4DE35iMeWFyb9aybW3ucqi17NtFd7S', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '16096390033569', '2024-12-12 01:23:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `button_starts`
--

CREATE TABLE `button_starts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) NOT NULL,
  `button_disabled_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `button_starts`
--

INSERT INTO `button_starts` (`id`, `employee_id`, `button_disabled_at`, `created_at`, `updated_at`) VALUES
(1, 10, '2025-03-16 07:33:28', '2025-03-16 07:33:28', NULL),
(2, 16096390033569, '2025-05-16 14:00:16', '2025-05-16 14:00:16', NULL),
(3, 16096390033565, '2025-07-14 07:44:44', '2025-07-14 07:44:44', NULL),
(4, 17156549645531, '2025-07-18 00:18:27', '2025-07-18 00:18:27', NULL),
(5, 16837053916801, '2025-07-21 04:54:29', '2025-07-21 04:54:29', NULL),
(6, 1672385124827, '2025-07-21 04:54:36', '2025-07-21 04:54:36', NULL),
(7, 16838854691417, '2025-07-21 04:57:30', '2025-07-21 04:57:30', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('peer_id_16096390033569', 's:36:\"75640da6-2bfb-482e-998a-5bddd806e05b\";', 1748076955);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Resources', NULL, NULL),
(2, 'Hardware', NULL, '2024-11-04 18:35:56'),
(3, 'Software', '2024-11-04 18:36:06', '2024-11-04 18:36:06'),
(4, 'Maintenance', '2024-12-11 03:20:04', '2024-12-11 03:20:04'),
(5, 'Dokumentasi', '2024-12-11 03:20:20', '2024-12-11 03:20:20'),
(6, 'Biaya Operasional', '2024-12-11 03:20:50', '2024-12-11 03:20:50'),
(7, 'Instalasi', '2024-12-11 03:36:48', '2024-12-11 03:36:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_task` bigint(20) NOT NULL,
  `id_employee` bigint(20) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parent` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `comments`
--

INSERT INTO `comments` (`id`, `id_task`, `id_employee`, `comment`, `created_at`, `updated_at`, `parent`) VALUES
(1, 61, 16096390033569, '<p>Desain database hari jum\'at</p>', '2024-12-11 03:44:24', NULL, NULL),
(2, 67, 1111111111, '<p>Test comment user 1</p>', '2024-12-11 03:46:37', NULL, NULL),
(3, 67, 16096390033569, '<p>test admin</p>', '2024-12-10 20:47:22', NULL, NULL),
(4, 67, 16096390033569, 'Balas ', '2024-12-10 20:50:42', NULL, 2),
(5, 67, 1111111111, 'Balas admin', '2024-12-11 04:07:10', NULL, 2),
(6, 67, 1111111111, '<p>Test admin</p>', '2024-12-11 05:59:54', NULL, NULL),
(7, 67, 1111111111, '<p>Test</p>', '2024-12-11 06:07:28', NULL, NULL),
(8, 60, 16096390033569, '<p>Coment saya</p>', '2024-12-12 01:56:39', NULL, NULL),
(9, 60, 16096390033569, 'Balasan saya', '2024-12-12 01:56:58', NULL, 8),
(10, 74, 16096390033569, '<p>m</p>', '2024-12-31 07:04:46', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cost_performances`
--

CREATE TABLE `cost_performances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` bigint(20) NOT NULL,
  `sub_category_id` bigint(20) NOT NULL,
  `uom` varchar(255) NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_evm`
--

CREATE TABLE `data_evm` (
  `id` bigint(20) NOT NULL,
  `pv` decimal(20,0) DEFAULT NULL,
  `ev` decimal(20,0) DEFAULT NULL,
  `ac` decimal(20,0) DEFAULT NULL,
  `sv` decimal(20,0) DEFAULT NULL,
  `cv` decimal(20,0) DEFAULT NULL,
  `spi` decimal(5,0) DEFAULT NULL,
  `cpi` decimal(5,0) DEFAULT NULL,
  `eac` decimal(20,0) DEFAULT NULL,
  `projects_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `employee`
--

CREATE TABLE `employee` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` text DEFAULT NULL,
  `nik` text DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('Laki - laki','Perempuan') DEFAULT NULL,
  `blood_group` varchar(10) DEFAULT NULL,
  `religion` varchar(100) DEFAULT NULL,
  `education_level` varchar(100) DEFAULT NULL,
  `education_department` varchar(200) DEFAULT NULL,
  `education_origin` varchar(200) DEFAULT NULL,
  `education_gpa` decimal(15,2) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `work_email` text DEFAULT NULL,
  `work_dprt_id` int(11) DEFAULT NULL,
  `work_position` varchar(200) DEFAULT NULL,
  `work_level_id` int(11) DEFAULT NULL,
  `work_number` varchar(20) DEFAULT NULL COMMENT 'nomor induk kepegawaian',
  `bank_name` varchar(100) DEFAULT NULL,
  `bank_account_name` varchar(100) DEFAULT NULL,
  `bank_account_number` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `photo_name` text DEFAULT NULL,
  `photo_path` text DEFAULT NULL,
  `work_reason` text DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `degree` varchar(50) DEFAULT NULL,
  `ttd_name` text DEFAULT NULL,
  `ttd_path` text DEFAULT NULL,
  `created_by` varchar(15) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_by` varchar(15) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `employee`
--

INSERT INTO `employee` (`id`, `name`, `nik`, `date_of_birth`, `gender`, `blood_group`, `religion`, `education_level`, `education_department`, `education_origin`, `education_gpa`, `phone_number`, `email`, `work_email`, `work_dprt_id`, `work_position`, `work_level_id`, `work_number`, `bank_name`, `bank_account_name`, `bank_account_number`, `status`, `photo_name`, `photo_path`, `work_reason`, `title`, `degree`, `ttd_name`, `ttd_path`, `created_by`, `created_date`, `modified_by`, `modified_date`) VALUES
(1, 'Fatimah', '3331312121212', '2024-09-30', 'Laki - laki', 'B', 'Islam', NULL, NULL, NULL, NULL, '0822222222', 'admin@gmail.com', NULL, 1, 'head', 4, '3131313', 'bca', 'fatm', '123123', 'Belum menikah', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '16096390033569', '2024-09-30 15:30:42', '16096390033569', '2024-09-30 15:32:08'),
(2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '16096390033569', '2024-11-05 14:47:24', NULL, NULL),
(3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '16096390033569', '2024-11-05 15:15:07', NULL, NULL),
(4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '16096390033569', '2024-11-06 16:37:57', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `employee_address`
--

CREATE TABLE `employee_address` (
  `id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(10) UNSIGNED NOT NULL,
  `type` enum('KTP','Domisili') DEFAULT NULL,
  `address` text DEFAULT NULL,
  `province` varchar(200) DEFAULT NULL,
  `city` varchar(200) DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `created_by` varchar(15) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_by` varchar(15) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `employee_address`
--

INSERT INTO `employee_address` (`id`, `employee_id`, `type`, `address`, `province`, `city`, `postal_code`, `created_by`, `created_date`, `modified_by`, `modified_date`) VALUES
(1, 1, 'KTP', 'Jalan X', '1', '2', '5000', '16096390033569', '2024-09-30 15:30:42', '16096390033569', '2024-09-30 15:32:08'),
(2, 1, 'Domisili', 'Jalan X', '1', '2', '5000', '16096390033569', '2024-09-30 15:30:42', '16096390033569', '2024-09-30 15:32:08'),
(3, 2, 'KTP', NULL, NULL, NULL, NULL, '16096390033569', '2024-11-05 14:47:24', NULL, NULL),
(4, 2, 'Domisili', NULL, NULL, NULL, NULL, '16096390033569', '2024-11-05 14:47:24', NULL, NULL),
(5, 3, 'KTP', NULL, NULL, NULL, NULL, '16096390033569', '2024-11-05 15:15:07', NULL, NULL),
(6, 3, 'Domisili', NULL, NULL, NULL, NULL, '16096390033569', '2024-11-05 15:15:07', NULL, NULL),
(7, 4, 'KTP', NULL, NULL, NULL, NULL, '16096390033569', '2024-11-06 16:37:57', NULL, NULL),
(8, 4, 'Domisili', NULL, NULL, NULL, NULL, '16096390033569', '2024-11-06 16:37:57', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `employee_family`
--

CREATE TABLE `employee_family` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `name` text DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `education` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `job` varchar(50) DEFAULT NULL,
  `relation` varchar(50) DEFAULT NULL,
  `created_by` varchar(15) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_by` varchar(15) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Dumping data untuk tabel `employee_family`
--

INSERT INTO `employee_family` (`id`, `employee_id`, `type`, `name`, `date_of_birth`, `education`, `address`, `phone_number`, `job`, `relation`, `created_by`, `created_date`, `modified_by`, `modified_date`) VALUES
(1, 1, 'couple', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '16096390033569', '2024-09-30 15:30:42', NULL, NULL),
(2, 1, 'mother', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '16096390033569', '2024-09-30 15:30:42', NULL, NULL),
(3, 1, 'father', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '16096390033569', '2024-09-30 15:30:42', NULL, NULL),
(4, 1, 'emergency_contact', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '16096390033569', '2024-09-30 15:30:42', NULL, NULL),
(5, 2, 'couple', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '16096390033569', '2024-11-05 14:47:24', NULL, NULL),
(6, 2, 'mother', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '16096390033569', '2024-11-05 14:47:24', NULL, NULL),
(7, 2, 'father', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '16096390033569', '2024-11-05 14:47:24', NULL, NULL),
(8, 2, 'emergency_contact', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '16096390033569', '2024-11-05 14:47:24', NULL, NULL),
(9, 3, 'couple', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '16096390033569', '2024-11-05 15:15:07', NULL, NULL),
(10, 3, 'mother', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '16096390033569', '2024-11-05 15:15:07', NULL, NULL),
(11, 3, 'father', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '16096390033569', '2024-11-05 15:15:07', NULL, NULL),
(12, 3, 'emergency_contact', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '16096390033569', '2024-11-05 15:15:07', NULL, NULL),
(13, 4, 'couple', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '16096390033569', '2024-11-06 16:37:57', NULL, NULL),
(14, 4, 'mother', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '16096390033569', '2024-11-06 16:37:57', NULL, NULL),
(15, 4, 'father', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '16096390033569', '2024-11-06 16:37:57', NULL, NULL),
(16, 4, 'emergency_contact', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '16096390033569', '2024-11-06 16:37:57', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `employee_file`
--

CREATE TABLE `employee_file` (
  `id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(10) UNSIGNED NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `number` varchar(100) DEFAULT NULL,
  `path` text DEFAULT NULL,
  `name` text DEFAULT NULL,
  `created_by` varchar(15) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_by` varchar(15) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `employee_form`
--

CREATE TABLE `employee_form` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `link` text DEFAULT NULL,
  `created_by` varchar(15) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_by` varchar(15) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `employee_hierarchy`
--

CREATE TABLE `employee_hierarchy` (
  `id` int(5) NOT NULL,
  `parent_id` bigint(100) DEFAULT NULL,
  `user_id` bigint(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `employee_hierarchy`
--

INSERT INTO `employee_hierarchy` (`id`, `parent_id`, `user_id`, `created_at`, `updated_at`) VALUES
(22, NULL, 16096390033569, '2024-12-09 20:41:15', '2024-12-09 20:41:15'),
(24, 16096390033569, 16723846172251, '2024-12-09 20:42:00', '2024-12-09 20:42:00'),
(29, NULL, 1111111111, '2024-12-10 06:51:46', '2024-12-10 06:51:46'),
(34, NULL, 17156549645531, '2024-12-09 23:57:38', '2024-12-09 23:57:38'),
(37, 16096390033569, 2222222222, '2024-12-10 07:40:32', '2024-12-10 07:40:32'),
(38, 1111111111, 3333333333, '2024-12-10 07:54:20', '2024-12-10 07:54:20'),
(39, NULL, 16723846172251, '2024-12-12 02:04:06', '2024-12-12 02:04:06'),
(40, 16723846172251, 16762552150281, '2024-12-12 02:04:54', '2024-12-12 02:04:54'),
(41, 16723846172251, 16837053916801, '2024-12-12 02:06:10', '2024-12-12 02:06:10'),
(42, 17156549645531, 17115201074324, '2024-12-31 05:21:35', '2024-12-31 05:21:35'),
(43, 17156549645531, 17211143943934, '2024-12-31 05:22:27', '2024-12-31 05:22:27'),
(44, 17156549645531, 17217931175057, '2024-12-31 05:22:56', '2024-12-31 05:22:56'),
(45, 17156549645531, 17211142220257, '2024-12-31 05:23:49', '2024-12-31 05:23:49'),
(46, 17156549645531, 17223914963322, '2024-12-31 05:24:54', '2024-12-31 05:24:54'),
(47, 17156549645531, 1672385124827, '2024-12-31 06:46:44', '2024-12-31 06:46:44'),
(48, 17156549645531, 17207764525328, '2024-12-31 06:48:10', '2024-12-31 06:48:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `employee_master_department`
--

CREATE TABLE `employee_master_department` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `created_by` varchar(15) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_by` varchar(15) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `employee_master_level`
--

CREATE TABLE `employee_master_level` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `created_by` varchar(15) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_by` varchar(15) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `employee_medical_check`
--

CREATE TABLE `employee_medical_check` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `disease` text DEFAULT NULL,
  `year` varchar(15) DEFAULT NULL,
  `created_by` varchar(15) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_by` varchar(15) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `employee_organization`
--

CREATE TABLE `employee_organization` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `organization_name` text DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `institute` varchar(50) DEFAULT NULL,
  `period` varchar(20) DEFAULT NULL,
  `created_by` varchar(15) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_by` varchar(15) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `employee_salary`
--

CREATE TABLE `employee_salary` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `gaji_pokok` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `employee_salary`
--

INSERT INTO `employee_salary` (`id`, `user_id`, `salary`, `created_at`, `updated_at`, `gaji_pokok`) VALUES
(1, 16096390033565, 50000.00, NULL, NULL, 5000000.00),
(2, 16096390033569, 20000.00, NULL, NULL, 5000000.00),
(3, 16723846172251, 50000.00, NULL, NULL, 5000000.00),
(4, 1672385124827, 50000.00, NULL, NULL, 5000000.00),
(5, 16723865912539, 50000.00, NULL, NULL, 5000000.00),
(6, 16762552150281, 50000.00, NULL, NULL, 5000000.00),
(7, 16825534938493, 50000.00, NULL, NULL, 6000000.00),
(8, 16825586100408, 50000.00, NULL, NULL, 6000000.00),
(9, 16825598905258, 50000.00, NULL, NULL, 5000000.00),
(10, 16825754587971, 50000.00, NULL, NULL, 5000000.00),
(11, 16825755506047, 100000.00, NULL, NULL, 5000000.00),
(12, 16837053916801, 100000.00, NULL, NULL, 5000000.00),
(13, 16838579802061, 100000.00, NULL, NULL, 5000000.00),
(14, 168388315314, 100000.00, NULL, NULL, 5000000.00),
(15, 16838851594326, 100000.00, NULL, NULL, 5000000.00),
(16, 16838852492865, 100000.00, NULL, NULL, 5000000.00),
(17, 16838853519902, 100000.00, NULL, NULL, 5000000.00),
(18, 16838854691417, 100000.00, NULL, NULL, 5000000.00),
(19, 16838855416673, 20000.00, NULL, NULL, 5000000.00),
(20, 16838856867376, 20000.00, NULL, NULL, 5000000.00),
(21, 16838857233377, 20000.00, NULL, NULL, 5000000.00),
(22, 16841244848498, 20000.00, NULL, NULL, 5000000.00),
(23, 16841246252976, 20000.00, NULL, NULL, 5000000.00),
(24, 16841337151856, 20000.00, NULL, NULL, 5000000.00),
(25, 16841337801472, 20000.00, NULL, NULL, 3000000.00),
(26, 16892323614874, 20000.00, NULL, NULL, 3000000.00),
(27, 16905284859094, 40000.00, NULL, NULL, 3000000.00),
(28, 17090954990267, 40000.00, NULL, NULL, 3000000.00),
(29, 17097930633217, 40000.00, NULL, NULL, 3000000.00),
(30, 17115201074324, 40000.00, NULL, NULL, 3000000.00),
(31, 17140090504791, 40000.00, NULL, NULL, 3000000.00),
(32, 17156549645531, 40000.00, NULL, NULL, 3000000.00),
(33, 1716886318734, 40000.00, NULL, NULL, 3000000.00),
(34, 17194754541337, 40000.00, NULL, NULL, 3000000.00),
(35, 17194783592628, 100000.00, NULL, NULL, 3000000.00),
(36, 1719562608674, 100000.00, NULL, NULL, 3000000.00),
(37, 17195686018323, 100000.00, NULL, NULL, 3000000.00),
(38, 17195686687863, 100000.00, NULL, NULL, 3000000.00),
(39, 17207754069012, 100000.00, NULL, NULL, 3000000.00),
(40, 17207764525328, 100000.00, NULL, NULL, 3000000.00),
(41, 17207765000817, 100000.00, NULL, NULL, 3000000.00),
(42, 17211142220257, 100000.00, NULL, NULL, 3000000.00),
(43, 17211142483245, 100000.00, NULL, NULL, 3000000.00),
(44, 17211143656952, 100000.00, NULL, NULL, 3000000.00),
(45, 17211143943934, 100000.00, NULL, NULL, 3000000.00),
(46, 17217931175057, 100000.00, NULL, NULL, 3000000.00),
(47, 17217931482372, 100000.00, NULL, NULL, 3000000.00),
(48, 17223914963322, 100000.00, NULL, NULL, 3000000.00),
(49, 17229326563932, 50000.00, NULL, NULL, 3000000.00),
(50, 17248954127475, 50000.00, NULL, NULL, 3000000.00),
(51, 17248954565951, 50000.00, NULL, NULL, 3000000.00),
(52, 17248955869732, 50000.00, NULL, NULL, 3000000.00),
(53, 17248956331227, 50000.00, NULL, NULL, 3000000.00),
(54, 17248957107296, 50000.00, NULL, NULL, 3000000.00),
(55, 17249828918733, 50000.00, NULL, NULL, NULL),
(56, 1111111111, 20000.00, NULL, NULL, 3000000.00),
(57, 2222222222, 20000.00, NULL, NULL, 3000000.00),
(58, 3333333333, 20000.00, NULL, NULL, 3000000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `employee_skill`
--

CREATE TABLE `employee_skill` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `language` varchar(50) DEFAULT NULL,
  `writing_skill` int(11) DEFAULT NULL,
  `listening_skill` int(11) DEFAULT NULL,
  `reading_skill` int(11) DEFAULT NULL,
  `programming_language` text DEFAULT NULL,
  `programming_skill` int(11) DEFAULT NULL,
  `created_by` varchar(15) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_by` varchar(15) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `employee_training_sertif`
--

CREATE TABLE `employee_training_sertif` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `program` text DEFAULT NULL,
  `training_institute` text DEFAULT NULL,
  `year` varchar(50) DEFAULT NULL,
  `created_by` varchar(15) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_by` varchar(15) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `employee_work_experience`
--

CREATE TABLE `employee_work_experience` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `company_name` varchar(100) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `period` varchar(50) DEFAULT NULL,
  `working_type` varchar(50) DEFAULT NULL,
  `salary` int(11) DEFAULT NULL,
  `resign_reason` text DEFAULT NULL,
  `created_by` varchar(15) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_by` varchar(15) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `employee_work_reason`
--

CREATE TABLE `employee_work_reason` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `created_by` varchar(15) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_by` varchar(15) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `holidays`
--

CREATE TABLE `holidays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `is_national` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `holidays`
--

INSERT INTO `holidays` (`id`, `date`, `name`, `description`, `is_national`, `created_at`, `updated_at`) VALUES
(1, '2024-11-22', 'Libur coblosan update', 'coblosan 1 hari', 0, NULL, NULL),
(2, '2024-11-29', 'Ulang Tahun Korpri', '', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"06bb8756-9fb6-452a-8d4e-8e4ca3ab177a\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"ce575736-f625-4a46-a6c1-7879a2f109d4\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748389391, 1748389391),
(2, 'default', '{\"uuid\":\"3cdc0577-d9f0-4219-b503-69bb7f662642\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:3:\\\"end\\\";s:6:\\\"peerId\\\";s:36:\\\"ce575736-f625-4a46-a6c1-7879a2f109d4\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748390522, 1748390522),
(3, 'default', '{\"uuid\":\"30c9ed3a-58a3-4c37-9a31-71b624fcdfc4\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"2670c42a-7c73-4858-9e3b-cbe67bceb320\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748390550, 1748390550),
(4, 'default', '{\"uuid\":\"b1882140-8e9c-465a-bb63-e535f7e46925\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:3:\\\"end\\\";s:6:\\\"peerId\\\";s:36:\\\"2670c42a-7c73-4858-9e3b-cbe67bceb320\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748390703, 1748390703),
(5, 'default', '{\"uuid\":\"5286eaeb-fc86-4bb8-874c-c0eb8a2151ef\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"d86496f8-b1fc-428b-bb40-7db9ea061c0c\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748390813, 1748390813),
(6, 'default', '{\"uuid\":\"33aa64e1-e93b-4b44-b18f-4fca2fcf657f\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"01839cea-64ef-414d-9565-4794944006a3\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748415779, 1748415779),
(7, 'default', '{\"uuid\":\"318c37c0-a8e6-489a-bbda-4984adaf8485\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:3:\\\"end\\\";s:6:\\\"peerId\\\";s:36:\\\"01839cea-64ef-414d-9565-4794944006a3\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748417537, 1748417537),
(8, 'default', '{\"uuid\":\"f7a9bfbe-84a2-439f-b1d5-3d2e81069339\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:3:\\\"end\\\";s:6:\\\"peerId\\\";s:36:\\\"01839cea-64ef-414d-9565-4794944006a3\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748417541, 1748417541),
(9, 'default', '{\"uuid\":\"01901a4f-a2f4-4733-9f68-1c8a8aff9440\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"00790d63-b733-45a9-a6c7-0d0599637e94\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748417558, 1748417558),
(10, 'default', '{\"uuid\":\"e272df6e-1999-4a6c-bcab-1c8f99a3ed55\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:3:\\\"end\\\";s:6:\\\"peerId\\\";s:36:\\\"00790d63-b733-45a9-a6c7-0d0599637e94\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748421803, 1748421803),
(11, 'default', '{\"uuid\":\"7a16b898-75c9-4e0d-93ac-09a66f6fe768\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"948d887b-67f0-42b9-b069-05cfbb871f8a\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748421829, 1748421829),
(12, 'default', '{\"uuid\":\"af1d53fd-291c-4e97-b03f-447b66b7eef6\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:3:\\\"end\\\";s:6:\\\"peerId\\\";s:36:\\\"948d887b-67f0-42b9-b069-05cfbb871f8a\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748422150, 1748422150),
(13, 'default', '{\"uuid\":\"b152d9e1-26ea-41e6-94bf-61c609e498cf\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"45701a52-6e2d-4da2-858a-027a3e169088\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748422186, 1748422186),
(14, 'default', '{\"uuid\":\"eb4b376a-9047-4348-97d4-8e2f6f5c8452\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:3:\\\"end\\\";s:6:\\\"peerId\\\";s:36:\\\"45701a52-6e2d-4da2-858a-027a3e169088\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748422436, 1748422436),
(15, 'default', '{\"uuid\":\"f1fb234d-fafb-4c0c-ab93-554d3627589d\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"73d7222f-242d-4627-bac5-dcf9bf5fe79c\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748422456, 1748422456),
(16, 'default', '{\"uuid\":\"4a675e93-95d2-408a-b34c-b08c4dd5fe3b\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:3:\\\"end\\\";s:6:\\\"peerId\\\";s:36:\\\"73d7222f-242d-4627-bac5-dcf9bf5fe79c\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748422551, 1748422551),
(17, 'default', '{\"uuid\":\"dffc7495-eceb-4925-9537-5d7180f01378\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"36d9220e-bf8c-4d97-a0f3-12c1a424cfb6\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748422569, 1748422569),
(18, 'default', '{\"uuid\":\"2bce6f3f-4c98-4e7c-a2fd-493c9defea8a\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:3:\\\"end\\\";s:6:\\\"peerId\\\";s:36:\\\"36d9220e-bf8c-4d97-a0f3-12c1a424cfb6\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748423403, 1748423403),
(19, 'default', '{\"uuid\":\"5218d7d9-1dde-4690-bda5-654258aa118b\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"9ceed2b0-0568-47a1-b18a-2f8ec48483d3\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748423476, 1748423476),
(20, 'default', '{\"uuid\":\"aa2e18ec-c240-44dc-8a6d-1168eb92502e\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:3:\\\"end\\\";s:6:\\\"peerId\\\";s:36:\\\"9ceed2b0-0568-47a1-b18a-2f8ec48483d3\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748423631, 1748423631),
(21, 'default', '{\"uuid\":\"3ae49cbc-175f-447f-b6c5-990069e4b00b\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"3f22cefc-8369-48f5-bef1-332a870fe12a\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748423648, 1748423648),
(22, 'default', '{\"uuid\":\"174c81a8-63a7-4466-bc6e-d83dc085a85c\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:3:\\\"end\\\";s:6:\\\"peerId\\\";s:36:\\\"3f22cefc-8369-48f5-bef1-332a870fe12a\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748423740, 1748423740),
(23, 'default', '{\"uuid\":\"92e9f662-c24c-4cc4-a630-9d0e3bdb0e58\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"3f2a9fc0-295e-45d0-9428-140fcfdff873\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748423772, 1748423772),
(24, 'default', '{\"uuid\":\"1d32beb6-f3b2-456b-8ace-fb147fb380ea\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:3:\\\"end\\\";s:6:\\\"peerId\\\";s:36:\\\"3f2a9fc0-295e-45d0-9428-140fcfdff873\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748424567, 1748424567),
(25, 'default', '{\"uuid\":\"63db8902-3a5e-471c-87b3-72bba7b564b7\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"71b8c23b-c271-44ad-a664-fc3a471e4265\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748424592, 1748424592),
(26, 'default', '{\"uuid\":\"db3de649-c4ec-4de9-ab49-7249357607ed\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:3:\\\"end\\\";s:6:\\\"peerId\\\";s:36:\\\"71b8c23b-c271-44ad-a664-fc3a471e4265\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748424634, 1748424634),
(27, 'default', '{\"uuid\":\"c2f854f7-a0e7-4707-b77b-78d4efb4ef62\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"8efe15a4-b7da-4f1a-b110-26569d406139\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748424725, 1748424725),
(28, 'default', '{\"uuid\":\"83ae4e37-497d-4204-80ea-db2153a8313a\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"dba943cd-24bc-48ae-abd8-5d13fa52f89f\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748442221, 1748442221),
(29, 'default', '{\"uuid\":\"453a643d-b577-4164-8168-9e3f9f530457\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:3:\\\"end\\\";s:6:\\\"peerId\\\";s:36:\\\"dba943cd-24bc-48ae-abd8-5d13fa52f89f\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748444456, 1748444456),
(30, 'default', '{\"uuid\":\"0562c3d1-c937-43bf-8ae9-d1e8ba9224e2\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"687a6f6d-7faf-4085-9657-983fb9ee3d3e\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748444486, 1748444486),
(31, 'default', '{\"uuid\":\"2ffaebd3-1634-48c5-9c89-0daed7aa504e\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:3:\\\"end\\\";s:6:\\\"peerId\\\";s:36:\\\"687a6f6d-7faf-4085-9657-983fb9ee3d3e\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748444678, 1748444678),
(32, 'default', '{\"uuid\":\"b66bd2bb-6f2d-4198-906a-9ae1ef45f650\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"6c0354b4-90e0-4cd8-b431-8766e467fb7c\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748444705, 1748444705),
(33, 'default', '{\"uuid\":\"9212b915-4699-4d04-9ce5-69cdfddcea9b\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:3:\\\"end\\\";s:6:\\\"peerId\\\";s:36:\\\"6c0354b4-90e0-4cd8-b431-8766e467fb7c\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748446091, 1748446091),
(34, 'default', '{\"uuid\":\"ca010267-d427-4dd9-9735-07150139d2ae\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"3abde7ce-36e5-4df1-b706-0d8af3ad28b9\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748446119, 1748446119),
(35, 'default', '{\"uuid\":\"1f409bf4-a5ac-4742-8b87-62caf9c3f308\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:3:\\\"end\\\";s:6:\\\"peerId\\\";s:36:\\\"3abde7ce-36e5-4df1-b706-0d8af3ad28b9\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748446123, 1748446123),
(36, 'default', '{\"uuid\":\"31b9de2a-dd32-4684-8857-022bf8f3f298\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"2c25793c-c10b-444d-94dc-139c3eb3438f\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748446142, 1748446142),
(37, 'default', '{\"uuid\":\"b747f4ec-4b93-4f39-963c-421bac43b0d3\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"2394dfb9-1c64-40ab-a1d5-bf9ac90b874e\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748446847, 1748446847),
(38, 'default', '{\"uuid\":\"f7eda6fe-83a1-41c9-be1d-387d954404f5\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:3:\\\"end\\\";s:6:\\\"peerId\\\";s:36:\\\"2394dfb9-1c64-40ab-a1d5-bf9ac90b874e\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748447717, 1748447717),
(39, 'default', '{\"uuid\":\"ba3f32b5-2fb8-4f10-b19f-a1932cbee5d0\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"58758ba5-5bea-4e8f-832c-74c813ad277e\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748447736, 1748447736),
(40, 'default', '{\"uuid\":\"bbf2b7cd-c2a9-449e-8021-9001eac13a26\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:3:\\\"end\\\";s:6:\\\"peerId\\\";s:36:\\\"58758ba5-5bea-4e8f-832c-74c813ad277e\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748449028, 1748449028),
(41, 'default', '{\"uuid\":\"17152d9e-81f9-48c5-afde-eaef9531f89a\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"712b2390-f5a3-4b89-a374-7813f2d224ec\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748449043, 1748449043),
(42, 'default', '{\"uuid\":\"61bfffff-e4eb-4cfe-a42b-6a0d894e3272\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:3:\\\"end\\\";s:6:\\\"peerId\\\";s:36:\\\"712b2390-f5a3-4b89-a374-7813f2d224ec\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748449271, 1748449271),
(43, 'default', '{\"uuid\":\"04db7d12-b5e4-4018-8574-7846406184fd\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"d4346850-dee4-4dd0-a629-86e296604329\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748449286, 1748449286),
(44, 'default', '{\"uuid\":\"57c1b3f7-7974-4579-aa24-0264d5993565\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:3:\\\"end\\\";s:6:\\\"peerId\\\";s:36:\\\"d4346850-dee4-4dd0-a629-86e296604329\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748449942, 1748449942),
(45, 'default', '{\"uuid\":\"b4eeec25-2dba-493e-8217-f444e4c7091f\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"38c4ea80-fa16-4541-bd93-d84e00f9bd5f\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748450012, 1748450012),
(46, 'default', '{\"uuid\":\"fb7ff6b9-5f3e-4993-9707-153342131474\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:3:\\\"end\\\";s:6:\\\"peerId\\\";s:36:\\\"38c4ea80-fa16-4541-bd93-d84e00f9bd5f\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748450506, 1748450506),
(47, 'default', '{\"uuid\":\"a683b7cd-1799-4d52-bb53-04725ab2b272\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"c90d3421-e158-4af8-acaf-6b77206f81c1\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748450522, 1748450522);
INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(48, 'default', '{\"uuid\":\"f0724438-1deb-4bbf-ad23-3b7080695782\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:3:\\\"end\\\";s:6:\\\"peerId\\\";s:36:\\\"c90d3421-e158-4af8-acaf-6b77206f81c1\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748450528, 1748450528),
(49, 'default', '{\"uuid\":\"fdb9629c-e38e-48e8-9cbf-2cbff4b2b451\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"ae8335d0-591d-4d6b-8043-bae1a96af273\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748450552, 1748450552),
(50, 'default', '{\"uuid\":\"5af90f3a-1464-400f-9897-f734b3553699\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:3:\\\"end\\\";s:6:\\\"peerId\\\";s:36:\\\"ae8335d0-591d-4d6b-8043-bae1a96af273\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748451124, 1748451124),
(51, 'default', '{\"uuid\":\"b0df5ea9-447d-4381-af61-92fddf23fb4c\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"598417a6-c270-45bb-9737-5e628f02876c\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748451410, 1748451410),
(52, 'default', '{\"uuid\":\"cbe5ac7f-2af9-4257-9c0e-37805dc383d1\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:3:\\\"end\\\";s:6:\\\"peerId\\\";s:36:\\\"598417a6-c270-45bb-9737-5e628f02876c\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748452272, 1748452272),
(53, 'default', '{\"uuid\":\"59938cfe-bfee-4441-8c1a-b6811720930a\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"1d24d79f-9541-467a-b84a-b935a8d8ca01\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748452570, 1748452570),
(54, 'default', '{\"uuid\":\"8d7ec7cc-bc92-45d2-aded-29d3fd8847b2\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":2:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:3:\\\"end\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748453048, 1748453048),
(55, 'default', '{\"uuid\":\"a2d76e27-eac3-4910-be7d-f2141e2e6b66\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"c5ec51ca-f822-48ee-9076-3058512ef29e\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748453083, 1748453083),
(56, 'default', '{\"uuid\":\"419b440d-d7b5-4dcc-bcc5-a5417587181b\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":2:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:3:\\\"end\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748453405, 1748453405),
(57, 'default', '{\"uuid\":\"9e618823-0a7a-42a9-95e9-23cfc835d002\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"1c0c8909-b4a9-40ea-8d6c-d4e174e7e25c\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748453415, 1748453415),
(58, 'default', '{\"uuid\":\"ad5eaae6-ce62-4b2c-8074-5d2a78dbc336\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":2:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:3:\\\"end\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748453659, 1748453659),
(59, 'default', '{\"uuid\":\"d8ddf6a3-7260-4748-8b89-3e7fc89dad14\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"d9d14af1-a675-4400-8c46-78e96da65f69\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748454635, 1748454635),
(60, 'default', '{\"uuid\":\"8827ea5a-9a53-487a-959c-3e7baa844529\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:3:\\\"end\\\";s:6:\\\"peerId\\\";s:36:\\\"d9d14af1-a675-4400-8c46-78e96da65f69\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748455074, 1748455074),
(61, 'default', '{\"uuid\":\"b92137ba-916c-4b24-9811-8553a048af0c\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"75e88ff1-15d9-44e4-9dda-9544dabae4e8\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748455107, 1748455107),
(62, 'default', '{\"uuid\":\"e1b35f58-d886-4f84-8e23-941270839f34\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"78aa4598-6af9-46e3-8f3b-61198e8298f2\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748455824, 1748455824),
(63, 'default', '{\"uuid\":\"b8b1bee8-0680-4a7a-baf4-6a26465eca0e\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:3:\\\"end\\\";s:6:\\\"peerId\\\";s:36:\\\"78aa4598-6af9-46e3-8f3b-61198e8298f2\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748455991, 1748455991),
(64, 'default', '{\"uuid\":\"96384f78-3657-463e-b2ce-efa349ee560d\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"21361480-7339-40a8-8754-531229f40017\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748456000, 1748456000),
(65, 'default', '{\"uuid\":\"ee00d978-a845-4450-a2d4-215849907f0d\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"b3cc996f-3a1b-4f67-b49a-8f2aa916fdfe\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748456421, 1748456421),
(66, 'default', '{\"uuid\":\"cfc16407-ea00-4c7d-8ea9-481dfb6dce17\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"3f33a534-f9fd-48de-b856-2205d828f5de\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748456894, 1748456894),
(67, 'default', '{\"uuid\":\"ac534975-a5aa-4cf0-9cb2-8f7e127b9f62\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:3:\\\"end\\\";s:6:\\\"peerId\\\";s:36:\\\"3f33a534-f9fd-48de-b856-2205d828f5de\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748457818, 1748457818),
(68, 'default', '{\"uuid\":\"6eb753d3-8a66-4b69-9531-6797f91efbe0\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"413a0b4b-b47d-45ea-892d-97b188d3843f\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748522559, 1748522559),
(69, 'default', '{\"uuid\":\"04e5feda-71ff-49e2-986e-631450634e4a\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"fa1901e9-0519-4dab-acb5-25113fd48c34\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748522607, 1748522607),
(70, 'default', '{\"uuid\":\"30a65715-567e-48e1-8c83-672751a83424\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:3:\\\"end\\\";s:6:\\\"peerId\\\";s:36:\\\"fa1901e9-0519-4dab-acb5-25113fd48c34\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748522640, 1748522640),
(71, 'default', '{\"uuid\":\"9f31a5c4-c91d-4bed-b60d-d749d63e87f8\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:7:\\\"ongoing\\\";s:6:\\\"peerId\\\";s:36:\\\"77d92e92-76ce-4ae4-93ee-eea73e6edf4c\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748522659, 1748522659),
(72, 'default', '{\"uuid\":\"5b77ab6f-3adf-4830-ad62-668bf89bb347\",\"displayName\":\"App\\\\Events\\\\PeerSessionStarted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\PeerSessionStarted\\\":3:{s:4:\\\"user\\\";s:15:\\\"Wahyu Kurniawan\\\";s:6:\\\"status\\\";s:3:\\\"end\\\";s:6:\\\"peerId\\\";s:36:\\\"77d92e92-76ce-4ae4-93ee-eea73e6edf4c\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1748523218, 1748523218);

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_department`
--

CREATE TABLE `master_department` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `created_by` varchar(15) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_by` varchar(15) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Dumping data untuk tabel `master_department`
--

INSERT INTO `master_department` (`id`, `name`, `created_by`, `created_date`, `modified_by`, `modified_date`) VALUES
(1, 'Chief Executive Officer', '16723846172251', '2024-01-04 10:44:08', NULL, NULL),
(3, 'Human Resources', '16723846172251', '2024-01-04 10:46:38', NULL, NULL),
(4, 'Integrated System Division', '16723846172251', '2024-01-04 10:47:49', NULL, NULL),
(5, 'Software Division', '16723846172251', '2024-01-04 10:48:17', NULL, NULL),
(7, 'General Affair & Finance', '16723846172251', '2024-01-04 10:45:31', NULL, NULL),
(8, 'Project Division', '16723846172251', '2024-01-04 10:47:26', NULL, NULL),
(9, 'Technical Division', '16723846172251', '2024-01-04 10:48:38', NULL, NULL),
(11, 'Marketing and Sales', '16723846172251', '2023-05-10 14:07:46', NULL, NULL),
(15, 'Operational', '16723846172251', '2024-01-04 10:46:15', NULL, NULL),
(16, '-', '16096390033565', '2023-05-08 13:55:00', NULL, NULL),
(17, 'Chief Technology Officer', '16723846172251', '2024-01-23 08:56:26', NULL, NULL),
(18, 'Finance', '16723846172251', '2023-05-08 14:49:38', NULL, NULL),
(19, 'Commissioner', '16723846172251', '2023-05-12 11:37:46', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_08_19_064516_create_departmens_table', 1),
(5, '2024_08_19_064927_create_roles_table', 1),
(6, '2024_08_19_070725_create_employees_table', 1),
(7, '2024_08_19_070753_create_projects_table', 1),
(8, '2024_08_19_073352_rename_departmens_to_departments', 1),
(9, '2024_08_19_073738_add_department_id_to_roles_table', 1),
(10, '2024_08_19_151352_create_tasks_table', 1),
(11, '2024_08_21_041423_create_release_notes_table', 1),
(12, '2024_08_21_080252_add_budget_and_created_by_to_projects', 1),
(13, '2024_08_26_083230_create_categories_table', 1),
(14, '2024_08_26_083238_create_sub_categories_table', 1),
(15, '2024_08_26_084512_create_plans_table', 1),
(16, '2024_08_28_084201_create_products_table', 1),
(17, '2024_09_09_095628_create_statuses_table', 1),
(18, '2024_09_10_092940_create_tracks_table', 1),
(19, '2024_09_17_034344_update_status_column_in_tasks_table', 1),
(20, '2024_09_19_013415_create_budgets_table', 1),
(21, '2024_09_19_065525_add_id_project_to_plans', 1),
(22, '2024_09_23_023326_create_project_team_table', 1),
(23, '2024_09_23_042949_add_code_status_to_status_table', 1),
(24, '2024_09_24_073706_change_attachments_column_type', 1),
(25, '2024_09_26_010701_remove_total_all_from_plans_table', 1),
(26, '2024_09_30_035605_add_status_to_projects_table', 1),
(27, '2024_09_30_071046_rename_statuses_to_task_statuses', 1),
(28, '2024_09_30_071440_create_project_statuses_table', 1),
(29, '2024_09_30_091246_create_task_flags_table', 1),
(30, '2024_09_30_093030_modify_status_column_in_projects_table', 1),
(31, '2024_10_01_033106_drop_team_column_from_projects_table', 1),
(32, '2024_10_01_041149_create_task_flagging_table', 1),
(33, '2024_10_01_065704_remove_total_all_from_tracks_table', 1),
(34, '2024_10_02_014451_add_id_project_to_tracks_table', 1),
(35, '2024_10_02_024143_create_time_cards_table', 1),
(36, '2024_10_02_072653_update_start_time_nullable_in_time_cards_table', 1),
(37, '2024_10_02_082448_update_duration_in_time_cards_table', 1),
(38, '2024_10_10_044657_add_completion_time_to_tasks_table', 1),
(39, '2024_10_14_075614_create_task_categories_table', 1),
(40, '2024_10_14_082718_add_category_id_to_tasks_table', 1),
(41, '2024_10_18_071019_update_time_cards_table', 1),
(42, '2024_10_21_033016_remove_description_from_time_cards_table', 1),
(43, '2024_10_21_034712_create_cost_performances_table', 1),
(44, '2024_10_23_081419_add_parent_id_to_employees_table', 1),
(45, '2024_10_23_093126_add_salary_to_employees_table', 1),
(46, '2024_11_04_162239_create_holidays_table', 1),
(47, '2024_11_05_011300_create_live_comments_table', 1),
(48, '2024_11_05_042943_create_workings_table', 1),
(49, '2024_11_06_091651_create_button_starts_table', 1),
(50, '2024_11_13_083719_create_app_menu_table', 1),
(51, '2024_11_13_084624_create_app_role_menu_table', 1),
(52, '2024_11_13_084640_create_app_role_user_table', 1),
(53, '2024_11_13_093659_create_app_role_table', 1),
(54, '2024_11_13_140810_create_app_menu_control_table', 1),
(55, '2024_11_13_140853_create_app_role_menu_control_table', 1),
(56, '2024_11_19_085841_create_employee_salary_table', 1),
(57, '2024_11_21_105412_create_task_labels_table', 1),
(58, '2024_11_28_153518_create_task_labeling_table', 2),
(59, '2024_11_20_114428_add_gaji_pokok_to_employee_salary_table', 3),
(60, '2024_11_29_110829_create_uom_table', 3),
(61, '2025_05_18_195416_create_personal_access_tokens_table', 4),
(62, '2025_05_20_222133_create_pulse_tables', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `plans`
--

CREATE TABLE `plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` bigint(20) NOT NULL,
  `sub_category_id` bigint(20) NOT NULL,
  `uom` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total_per_item` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_project` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `plans`
--

INSERT INTO `plans` (`id`, `name`, `category_id`, `sub_category_id`, `uom`, `quantity`, `unit_price`, `total_per_item`, `created_at`, `updated_at`, `id_project`) VALUES
(9, 'Y. Ihsan', 1, 6, 'hari', 10, 100000.00, 1000000.00, '2025-01-02 10:46:50', NULL, 14),
(10, 'Adhika', 1, 1, 'hari', 60, 200000.00, 12000000.00, '2025-01-02 23:51:36', NULL, 14),
(11, 'fatma', 1, 1, 'mounth', 1, 5000000.00, 5000000.00, '2025-06-17 01:27:14', NULL, 16),
(12, 'Wahyu', 1, 1, 'bulan', 1, 4000000.00, 4000000.00, '2025-06-17 06:56:53', NULL, 18);

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `stocks` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `client` varchar(255) DEFAULT NULL,
  `project_manager` bigint(20) NOT NULL,
  `budget` decimal(15,2) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `due_date_estimation` date DEFAULT NULL,
  `completion` int(11) NOT NULL DEFAULT 0,
  `attachments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`attachments`)),
  `completion_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) NOT NULL,
  `status_id` bigint(20) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `projects`
--

INSERT INTO `projects` (`id`, `title`, `description`, `client`, `project_manager`, `budget`, `start_date`, `due_date_estimation`, `completion`, `attachments`, `completion_date`, `created_at`, `updated_at`, `created_by`, `status_id`, `deleted_at`) VALUES
(14, 'Asta Fleet', 'System aplikasi untuk monitoring kendaraan bermotor atau alat berat dengan gps dan sensor untuk mendeteksi konsumsi bahan bakar ', 'PT Nusa Semesta', 17156549645531, 500000000.00, '2024-12-23', '2025-03-31', 57, '[]', '2024-12-31', '2024-12-31 03:59:39', '2025-01-02 08:11:13', 16096390033569, 2, NULL),
(15, 'Laundry', 'Laundry sistem', 'RS. Setia Medika', 1672385124827, 100000000.00, '2025-03-06', '2025-03-31', 0, '[]', '2025-03-25', '2025-03-06 15:56:06', '2025-07-02 15:51:10', 16096390033569, 2, NULL),
(16, 'BAC Hermina', 'Sistem Akreditasi Hermina Group', 'Hermina', 17156549645531, 500000000.00, '2025-05-01', '2025-07-23', 33, '[]', '2025-06-17', '2025-06-17 00:58:27', '2025-06-17 01:39:22', 16096390033569, 2, NULL),
(17, 'Asta project', 'project internal abarobotics', 'Abe', 17156549645531, 250000000.00, '2025-06-17', '2025-07-23', 0, '[]', NULL, '2025-06-17 06:45:59', NULL, 16096390033569, 1, NULL),
(18, 'Parking system', 'system parkir internal abarobotics', 'Abe', 1672385124827, 350000000.00, '2025-06-17', '2025-07-29', 100, '[]', '2025-06-17', '2025-06-17 06:47:52', '2025-06-17 07:34:10', 16096390033569, 3, NULL),
(19, 'Project menagement', NULL, 'Bu dianni', 17156549645531, 100000000.00, '2025-06-17', '2025-07-30', 100, '[]', '2025-07-02', '2025-06-17 08:13:49', '2025-07-02 04:08:58', 16096390033569, 3, NULL),
(20, 'ab', 'ab', 'ab', 16837053916801, 500000.00, '2025-07-05', '2025-07-19', 0, '[]', NULL, '2025-07-05 15:12:21', NULL, 16096390033569, 1, '2025-07-05 15:12:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `project_statuses`
--

CREATE TABLE `project_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_status` varchar(255) NOT NULL,
  `code_status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `project_statuses`
--

INSERT INTO `project_statuses` (`id`, `project_status`, `code_status`, `created_at`, `updated_at`) VALUES
(1, 'New', 'new', NULL, NULL),
(2, 'On Progress', 'onprogress', NULL, NULL),
(3, 'Complete', 'complete', NULL, NULL),
(4, 'Cancel', 'cancel', NULL, NULL),
(5, 'Hold', 'Hold', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `project_team`
--

CREATE TABLE `project_team` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) NOT NULL,
  `department_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `project_team`
--

INSERT INTO `project_team` (`id`, `project_id`, `department_id`, `created_at`, `updated_at`) VALUES
(1, 1, 17, NULL, NULL),
(2, 1, 18, NULL, NULL),
(7, 2, 1, NULL, NULL),
(8, 1, 5, NULL, NULL),
(9, 9, 1, NULL, NULL),
(10, 9, 3, NULL, NULL),
(13, 4, 1, NULL, NULL),
(14, 4, 4, NULL, NULL),
(15, 4, 5, NULL, NULL),
(16, 5, 1, NULL, NULL),
(17, 5, 4, NULL, NULL),
(18, 6, 1, NULL, NULL),
(19, 6, 4, NULL, NULL),
(20, 6, 5, NULL, NULL),
(21, 7, 1, NULL, NULL),
(22, 7, 2, NULL, NULL),
(23, 7, 3, NULL, NULL),
(24, 7, 4, NULL, NULL),
(25, 7, 5, NULL, NULL),
(30, 8, 4, NULL, NULL),
(31, 8, 5, NULL, NULL),
(32, 8, 8, NULL, NULL),
(33, 8, 9, NULL, NULL),
(34, 10, 1, NULL, NULL),
(35, 9, 5, NULL, NULL),
(36, 10, 1, NULL, NULL),
(41, 11, 4, NULL, NULL),
(42, 11, 5, NULL, NULL),
(43, 11, 8, NULL, NULL),
(44, 11, 9, NULL, NULL),
(45, 12, 1, NULL, NULL),
(46, 12, 5, NULL, NULL),
(47, 13, 4, NULL, NULL),
(48, 13, 5, NULL, NULL),
(49, 13, 7, NULL, NULL),
(66, 14, 1, NULL, NULL),
(67, 14, 4, NULL, NULL),
(68, 14, 5, NULL, NULL),
(69, 14, 8, NULL, NULL),
(70, 14, 9, NULL, NULL),
(71, 14, 11, NULL, NULL),
(72, 14, 15, NULL, NULL),
(73, 14, 17, NULL, NULL),
(80, 16, 5, NULL, NULL),
(81, 16, 8, NULL, NULL),
(82, 16, 15, NULL, NULL),
(83, 16, 17, NULL, NULL),
(84, 17, 1, NULL, NULL),
(85, 17, 3, NULL, NULL),
(86, 17, 5, NULL, NULL),
(87, 17, 7, NULL, NULL),
(88, 17, 8, NULL, NULL),
(89, 17, 9, NULL, NULL),
(90, 17, 15, NULL, NULL),
(91, 17, 17, NULL, NULL),
(92, 17, 18, NULL, NULL),
(93, 18, 1, NULL, NULL),
(94, 18, 3, NULL, NULL),
(95, 18, 4, NULL, NULL),
(96, 18, 5, NULL, NULL),
(97, 18, 7, NULL, NULL),
(98, 18, 8, NULL, NULL),
(99, 18, 9, NULL, NULL),
(100, 18, 11, NULL, NULL),
(101, 18, 15, NULL, NULL),
(102, 18, 17, NULL, NULL),
(107, 19, 1, NULL, NULL),
(108, 19, 3, NULL, NULL),
(109, 15, 1, NULL, NULL),
(110, 15, 4, NULL, NULL),
(111, 15, 5, NULL, NULL),
(112, 15, 7, NULL, NULL),
(113, 15, 8, NULL, NULL),
(114, 15, 9, NULL, NULL),
(115, 20, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pulse_aggregates`
--

CREATE TABLE `pulse_aggregates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bucket` int(10) UNSIGNED NOT NULL,
  `period` mediumint(8) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `key` mediumtext NOT NULL,
  `key_hash` binary(16) GENERATED ALWAYS AS (unhex(md5(`key`))) VIRTUAL,
  `aggregate` varchar(255) NOT NULL,
  `value` decimal(20,2) NOT NULL,
  `count` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pulse_aggregates`
--

INSERT INTO `pulse_aggregates` (`id`, `bucket`, `period`, `type`, `key`, `aggregate`, `value`, `count`) VALUES
(1, 1747754880, 60, 'slow_request', '[\"GET\",\"\\/\",\"App\\\\Livewire\\\\StartWork\"]', 'count', 1.00, NULL),
(2, 1747754640, 360, 'slow_request', '[\"GET\",\"\\/\",\"App\\\\Livewire\\\\StartWork\"]', 'count', 1.00, NULL),
(3, 1747753920, 1440, 'slow_request', '[\"GET\",\"\\/\",\"App\\\\Livewire\\\\StartWork\"]', 'count', 1.00, NULL),
(4, 1747751040, 10080, 'slow_request', '[\"GET\",\"\\/\",\"App\\\\Livewire\\\\StartWork\"]', 'count', 1.00, NULL),
(5, 1747754880, 60, 'slow_request', '[\"GET\",\"\\/\",\"App\\\\Livewire\\\\StartWork\"]', 'max', 1445.00, NULL),
(6, 1747754640, 360, 'slow_request', '[\"GET\",\"\\/\",\"App\\\\Livewire\\\\StartWork\"]', 'max', 1445.00, NULL),
(7, 1747753920, 1440, 'slow_request', '[\"GET\",\"\\/\",\"App\\\\Livewire\\\\StartWork\"]', 'max', 1445.00, NULL),
(8, 1747751040, 10080, 'slow_request', '[\"GET\",\"\\/\",\"App\\\\Livewire\\\\StartWork\"]', 'max', 1445.00, NULL),
(9, 1747754880, 60, 'slow_request', '[\"GET\",\"\\/login\",\"App\\\\Http\\\\Controllers\\\\Auth\\\\LoginController@index\"]', 'count', 1.00, NULL),
(10, 1747754640, 360, 'slow_request', '[\"GET\",\"\\/login\",\"App\\\\Http\\\\Controllers\\\\Auth\\\\LoginController@index\"]', 'count', 1.00, NULL),
(11, 1747753920, 1440, 'slow_request', '[\"GET\",\"\\/login\",\"App\\\\Http\\\\Controllers\\\\Auth\\\\LoginController@index\"]', 'count', 1.00, NULL),
(12, 1747751040, 10080, 'slow_request', '[\"GET\",\"\\/login\",\"App\\\\Http\\\\Controllers\\\\Auth\\\\LoginController@index\"]', 'count', 1.00, NULL),
(13, 1747754880, 60, 'slow_request', '[\"GET\",\"\\/login\",\"App\\\\Http\\\\Controllers\\\\Auth\\\\LoginController@index\"]', 'max', 1714.00, NULL),
(14, 1747754640, 360, 'slow_request', '[\"GET\",\"\\/login\",\"App\\\\Http\\\\Controllers\\\\Auth\\\\LoginController@index\"]', 'max', 1714.00, NULL),
(15, 1747753920, 1440, 'slow_request', '[\"GET\",\"\\/login\",\"App\\\\Http\\\\Controllers\\\\Auth\\\\LoginController@index\"]', 'max', 1714.00, NULL),
(16, 1747751040, 10080, 'slow_request', '[\"GET\",\"\\/login\",\"App\\\\Http\\\\Controllers\\\\Auth\\\\LoginController@index\"]', 'max', 1714.00, NULL),
(17, 1747754940, 60, 'slow_request', '[\"GET\",\"\\/_debugbar\\/open\",\"Barryvdh\\\\Debugbar\\\\Controllers\\\\OpenHandlerController@handle\"]', 'count', 9.00, NULL),
(18, 1747754640, 360, 'slow_request', '[\"GET\",\"\\/_debugbar\\/open\",\"Barryvdh\\\\Debugbar\\\\Controllers\\\\OpenHandlerController@handle\"]', 'count', 9.00, NULL),
(19, 1747753920, 1440, 'slow_request', '[\"GET\",\"\\/_debugbar\\/open\",\"Barryvdh\\\\Debugbar\\\\Controllers\\\\OpenHandlerController@handle\"]', 'count', 10.00, NULL),
(20, 1747751040, 10080, 'slow_request', '[\"GET\",\"\\/_debugbar\\/open\",\"Barryvdh\\\\Debugbar\\\\Controllers\\\\OpenHandlerController@handle\"]', 'count', 10.00, NULL),
(21, 1747754940, 60, 'slow_request', '[\"GET\",\"\\/_debugbar\\/open\",\"Barryvdh\\\\Debugbar\\\\Controllers\\\\OpenHandlerController@handle\"]', 'max', 1824.00, NULL),
(22, 1747754640, 360, 'slow_request', '[\"GET\",\"\\/_debugbar\\/open\",\"Barryvdh\\\\Debugbar\\\\Controllers\\\\OpenHandlerController@handle\"]', 'max', 1824.00, NULL),
(23, 1747753920, 1440, 'slow_request', '[\"GET\",\"\\/_debugbar\\/open\",\"Barryvdh\\\\Debugbar\\\\Controllers\\\\OpenHandlerController@handle\"]', 'max', 2245.00, NULL),
(24, 1747751040, 10080, 'slow_request', '[\"GET\",\"\\/_debugbar\\/open\",\"Barryvdh\\\\Debugbar\\\\Controllers\\\\OpenHandlerController@handle\"]', 'max', 2245.00, NULL),
(89, 1747755180, 60, 'slow_request', '[\"GET\",\"\\/_debugbar\\/open\",\"Barryvdh\\\\Debugbar\\\\Controllers\\\\OpenHandlerController@handle\"]', 'count', 1.00, NULL),
(90, 1747755000, 360, 'slow_request', '[\"GET\",\"\\/_debugbar\\/open\",\"Barryvdh\\\\Debugbar\\\\Controllers\\\\OpenHandlerController@handle\"]', 'count', 1.00, NULL),
(93, 1747755180, 60, 'slow_request', '[\"GET\",\"\\/_debugbar\\/open\",\"Barryvdh\\\\Debugbar\\\\Controllers\\\\OpenHandlerController@handle\"]', 'max', 2245.00, NULL),
(94, 1747755000, 360, 'slow_request', '[\"GET\",\"\\/_debugbar\\/open\",\"Barryvdh\\\\Debugbar\\\\Controllers\\\\OpenHandlerController@handle\"]', 'max', 2245.00, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pulse_entries`
--

CREATE TABLE `pulse_entries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `key` mediumtext NOT NULL,
  `key_hash` binary(16) GENERATED ALWAYS AS (unhex(md5(`key`))) VIRTUAL,
  `value` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pulse_entries`
--

INSERT INTO `pulse_entries` (`id`, `timestamp`, `type`, `key`, `value`) VALUES
(1, 1747754913, 'slow_request', '[\"GET\",\"\\/\",\"App\\\\Livewire\\\\StartWork\"]', 1445),
(2, 1747754915, 'slow_request', '[\"GET\",\"\\/login\",\"App\\\\Http\\\\Controllers\\\\Auth\\\\LoginController@index\"]', 1714),
(3, 1747754959, 'slow_request', '[\"GET\",\"\\/_debugbar\\/open\",\"Barryvdh\\\\Debugbar\\\\Controllers\\\\OpenHandlerController@handle\"]', 1824),
(4, 1747754962, 'slow_request', '[\"GET\",\"\\/_debugbar\\/open\",\"Barryvdh\\\\Debugbar\\\\Controllers\\\\OpenHandlerController@handle\"]', 1099),
(5, 1747754964, 'slow_request', '[\"GET\",\"\\/_debugbar\\/open\",\"Barryvdh\\\\Debugbar\\\\Controllers\\\\OpenHandlerController@handle\"]', 1341),
(6, 1747754966, 'slow_request', '[\"GET\",\"\\/_debugbar\\/open\",\"Barryvdh\\\\Debugbar\\\\Controllers\\\\OpenHandlerController@handle\"]', 1746),
(7, 1747754976, 'slow_request', '[\"GET\",\"\\/_debugbar\\/open\",\"Barryvdh\\\\Debugbar\\\\Controllers\\\\OpenHandlerController@handle\"]', 1450),
(8, 1747754978, 'slow_request', '[\"GET\",\"\\/_debugbar\\/open\",\"Barryvdh\\\\Debugbar\\\\Controllers\\\\OpenHandlerController@handle\"]', 1287),
(9, 1747754979, 'slow_request', '[\"GET\",\"\\/_debugbar\\/open\",\"Barryvdh\\\\Debugbar\\\\Controllers\\\\OpenHandlerController@handle\"]', 1328),
(10, 1747754980, 'slow_request', '[\"GET\",\"\\/_debugbar\\/open\",\"Barryvdh\\\\Debugbar\\\\Controllers\\\\OpenHandlerController@handle\"]', 1292),
(11, 1747754981, 'slow_request', '[\"GET\",\"\\/_debugbar\\/open\",\"Barryvdh\\\\Debugbar\\\\Controllers\\\\OpenHandlerController@handle\"]', 1220),
(12, 1747755200, 'slow_request', '[\"GET\",\"\\/_debugbar\\/open\",\"Barryvdh\\\\Debugbar\\\\Controllers\\\\OpenHandlerController@handle\"]', 2245);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pulse_values`
--

CREATE TABLE `pulse_values` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `key` mediumtext NOT NULL,
  `key_hash` binary(16) GENERATED ALWAYS AS (unhex(md5(`key`))) VIRTUAL,
  `value` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `release_notes`
--

CREATE TABLE `release_notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `attachments` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_project` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1MLUPoL44wIyZ1IZyWYJJ7CoAkQxSOZpjWIF71Oi', 16096390033569, '103.109.210.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiYnA5YzV3OHY4ODBnalFhS2FYV0VMeGVRUjJGa0dOZmxFZUVJRGtwZCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MToiaHR0cHM6Ly9tb25pdG9yaW5nLnBtLWFwcC1hYmFyb2JvdGljcy5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7czoxNDoiMTYwOTYzOTAwMzM1NjkiO3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjU5OiJodHRwczovL21vbml0b3JpbmcucG0tYXBwLWFiYXJvYm90aWNzLmNvbS9wcm9qZWN0cy8xOS90YXNrcyI7fX0=', 1754015997),
('1R1PTRdk44SPjT34aBmisbQLNonx5dzGvDLaEJ7S', NULL, '54.175.74.27', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidUZGS2RSSGo1Y05xZE5oR2ZkdVBxT1N1a2pkbWlFU3drdnczZWhtMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDc6Imh0dHBzOi8vbW9uaXRvcmluZy5wbS1hcHAtYWJhcm9ib3RpY3MuY29tL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1754221651),
('2WzdLhaCL9CS5lhXs74yZAzCjqJ0XZqhh4PyehXM', NULL, '20.55.61.179', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiN3F6NldTNHBmaHVjSXQzM3M3UG1SQnVHUDQ5TUxkR0dhTUNQMTdadSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MToiaHR0cHM6Ly9tb25pdG9yaW5nLnBtLWFwcC1hYmFyb2JvdGljcy5jb20iO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0NzoiaHR0cHM6Ly9tb25pdG9yaW5nLnBtLWFwcC1hYmFyb2JvdGljcy5jb20vbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1754015861),
('A86RzJd3B0ZgFhZI54da3cGsAltqoZ62pDJwOAkN', NULL, '54.175.74.27', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYlQ4SFRvczJJZXdqem5icFJLaHhIU0llTnVKRmNWUzFMc2dlZW9ycSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo1MzoiaHR0cHM6Ly9tb25pdG9yaW5nLnBtLWFwcC1hYmFyb2JvdGljcy5jb20vcHJvamVjdHMvMTgiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1MzoiaHR0cHM6Ly9tb25pdG9yaW5nLnBtLWFwcC1hYmFyb2JvdGljcy5jb20vcHJvamVjdHMvMTgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1754282170),
('BDR40X1SQo5RJ6uFBCVKJ1OIedEyteAHgonobopo', NULL, '184.72.115.35', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoid3Z5YkpESnNSRDNHRWdQWTZ0R2lzdll6YmZMblRUMXMxdkVhTmtvaSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo1MDoiaHR0cHM6Ly9tb25pdG9yaW5nLnBtLWFwcC1hYmFyb2JvdGljcy5jb20vcHJvamVjdHMiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1MDoiaHR0cHM6Ly9tb25pdG9yaW5nLnBtLWFwcC1hYmFyb2JvdGljcy5jb20vcHJvamVjdHMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1754237924),
('dSAyAqK5WW8VgeRyDi3wvYYX2lmyRBYB2nZv56DY', NULL, '54.86.66.252', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNGsybXltcE96NWdQM2FnYUQySnpVeWN3SFZkOVVXSTlZNFdvUHJEOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDc6Imh0dHBzOi8vbW9uaXRvcmluZy5wbS1hcHAtYWJhcm9ib3RpY3MuY29tL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1754217382),
('eijTvHgzuAxShCaSdC3xKOzkup9dE0gIllArphms', 16096390033569, '103.109.210.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaDRCTVFlQmI3VHpBelZRNUJ0UGhoNThybTQ1Z3ZZa29kdGhzOWVreCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTk6Imh0dHBzOi8vbW9uaXRvcmluZy5wbS1hcHAtYWJhcm9ib3RpY3MuY29tL3Byb2plY3RzLzE4L3Rhc2tzIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO3M6MTQ6IjE2MDk2MzkwMDMzNTY5Ijt9', 1754015946),
('gJtuvykq0EdrCcKxFna168QNLercEZhhKjELtRKb', NULL, '3.140.182.19', 'Mozilla/5.0 zgrab/0.x', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUnpTbm1SemNvajRBMndxZGFFS3BxdTJFTlRnaHdlTGtReFlLeVp5dCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MToiaHR0cHM6Ly9tb25pdG9yaW5nLnBtLWFwcC1hYmFyb2JvdGljcy5jb20iO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0MToiaHR0cHM6Ly9tb25pdG9yaW5nLnBtLWFwcC1hYmFyb2JvdGljcy5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1754189899),
('HjplguqH5FbBOApPvBeoTtQxrgUiEqXt5saOXdHl', NULL, '20.171.207.75', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; GPTBot/1.2; +https://openai.com/gptbot)', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYzFjZnBKMzA2SHVXeHUzc3BmV3JvcnVvTVRQNzRuVE5RTW1MaXVnaCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0NToiaHR0cHM6Ly93d3cubW9uaXRvcmluZy5wbS1hcHAtYWJhcm9ib3RpY3MuY29tIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTk6Imh0dHBzOi8vd3d3Lm1vbml0b3JpbmcucG0tYXBwLWFiYXJvYm90aWNzLmNvbS9sdXBhLXBhc3N3b3JkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1754322137),
('l9znN7GyWImeah50ZXRJmDZTg3vcRT9436ImzBrW', NULL, '184.72.115.35', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYkJKTVJxUGNHRTltMnBOWnBZaXVZZWNkU0VtOGRNY2hYb1FpZ2gyUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDc6Imh0dHBzOi8vbW9uaXRvcmluZy5wbS1hcHAtYWJhcm9ib3RpY3MuY29tL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1754237925),
('Mywg473q9wO0e69fMYPSRzPaVTTAJEzPHsAFbgJ2', NULL, '54.175.74.27', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYzdQRHdCMlBYM2J3czg5UGZyWXJmdEVzaklBam0yUURzdDFUZnhobiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDc6Imh0dHBzOi8vbW9uaXRvcmluZy5wbS1hcHAtYWJhcm9ib3RpY3MuY29tL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1754282171),
('p9MWkdKYP8AUcSa5NBUatmJqtuWnlTbZCk5TkCDx', NULL, '20.171.207.163', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; GPTBot/1.2; +https://openai.com/gptbot)', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOEYzRWpnMTlRbk1HMlAxbjJpYW12d3l6Y1FYbUZmTXhqUXRqU1BkNCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MToiaHR0cHM6Ly9tb25pdG9yaW5nLnBtLWFwcC1hYmFyb2JvdGljcy5jb20iO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1NToiaHR0cHM6Ly9tb25pdG9yaW5nLnBtLWFwcC1hYmFyb2JvdGljcy5jb20vbHVwYS1wYXNzd29yZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1754079015),
('PewdaUc0hYwbWL7tR3IzLDtXSeoYN23gbmLmnPwK', NULL, '54.175.74.27', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQThNWno1cFdRdFRqa0w3anBtQ0pXTWwwUTY1eFFvOG5aQWFvUkVwTCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo1OToiaHR0cHM6Ly9tb25pdG9yaW5nLnBtLWFwcC1hYmFyb2JvdGljcy5jb20vcHJvamVjdHMvMTgvdGFza3MiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1OToiaHR0cHM6Ly9tb25pdG9yaW5nLnBtLWFwcC1hYmFyb2JvdGljcy5jb20vcHJvamVjdHMvMTgvdGFza3MiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1754221650),
('pzQx8G9FOhTUnZv1ZSNobuZl5ZLWzwDax3yTSx5z', NULL, '54.86.66.252', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibUZtaFNMV0p3OXZrMUdFc0tqZUh6SklHbXJnaW1vUzhrS1BUU0lOYSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0ODoiaHR0cHM6Ly9tb25pdG9yaW5nLnBtLWFwcC1hYmFyb2JvdGljcy5jb20vbG9nb3V0Ijt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDg6Imh0dHBzOi8vbW9uaXRvcmluZy5wbS1hcHAtYWJhcm9ib3RpY3MuY29tL2xvZ291dCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1754217381),
('Q8z7qE2AZBIK9wvjhYSz1GUxlqwHOldT93JXJfWc', NULL, '54.175.74.27', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRHVyeEFFejd5NHBZOEpQM01wdVF4OVJTMWdJWWQ5ZkFsQWdXeXp3OSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDc6Imh0dHBzOi8vbW9uaXRvcmluZy5wbS1hcHAtYWJhcm9ib3RpY3MuY29tL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1754219974),
('QLYVIogkLM1ZotQjko1zMm5rPDBviKZCHb93cVy5', NULL, '184.72.121.156', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibXFDTEEzMXhNV1AzZFlrQzBiYzVHZVE5V2d1RXFhUnB4dW1MdkxFMCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo1MzoiaHR0cHM6Ly9tb25pdG9yaW5nLnBtLWFwcC1hYmFyb2JvdGljcy5jb20vcHJvamVjdHMvMTkiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1MzoiaHR0cHM6Ly9tb25pdG9yaW5nLnBtLWFwcC1hYmFyb2JvdGljcy5jb20vcHJvamVjdHMvMTkiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1754221259),
('tmNgeQdUfWolvxXjrY6sxUMWUeGsHIDuhaRcMtgn', NULL, '20.171.207.178', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; GPTBot/1.2; +https://openai.com/gptbot)', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZUpVUFpLMnRzWnRzS0h4VU9oeXloNkJzeHlTTE5tTVU4ZnFGQjZJaSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0NToiaHR0cHM6Ly93d3cubW9uaXRvcmluZy5wbS1hcHAtYWJhcm9ib3RpY3MuY29tIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTk6Imh0dHBzOi8vd3d3Lm1vbml0b3JpbmcucG0tYXBwLWFiYXJvYm90aWNzLmNvbS9sdXBhLXBhc3N3b3JkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1754079017),
('WKWnNYXUxFIDdTZh3pqLsHdFUorf2lCuzJxyGrr4', NULL, '103.156.71.116', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieTJka0NJREdUNXFac2YzZjJGUXpJY2pHZmloYUxQbnVxajVWc1E2eSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MToiaHR0cHM6Ly9tb25pdG9yaW5nLnBtLWFwcC1hYmFyb2JvdGljcy5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1754320115),
('yrTYi8vR6nKaV0da7OWd51tBkVo25pgpWTzWazpg', NULL, '184.72.121.156', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNzdsdUpYZUIydFA2cTNQSWZNWklhR1VubU1rR2luZkNmcEN0b0hSZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDc6Imh0dHBzOi8vbW9uaXRvcmluZy5wbS1hcHAtYWJhcm9ib3RpY3MuY29tL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1754221260),
('zkt8co8Lk5Gj2j50li4249ToLG2DK1Gg80n35uLS', NULL, '20.171.207.191', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; GPTBot/1.2; +https://openai.com/gptbot)', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUDJtUkRncTBqb1o0cVhyWmVkbzlaSWZOUXlMeXJlc3IycjIzNkx0NiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MToiaHR0cHM6Ly9tb25pdG9yaW5nLnBtLWFwcC1hYmFyb2JvdGljcy5jb20iO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1NToiaHR0cHM6Ly9tb25pdG9yaW5nLnBtLWFwcC1hYmFyb2JvdGljcy5jb20vbHVwYS1wYXNzd29yZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1754322134),
('zpeVz4jQYk4fhSbVU2LT5LQKhlqCXmij9nZnx8yi', NULL, '3.140.182.19', 'Mozilla/5.0 zgrab/0.x', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRFRjVlY2SDEwSFNWTHdwdG5uTjF3SXM3eUJFSzhRTTF5Tmx4MHBMMCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDc6Imh0dHBzOi8vbW9uaXRvcmluZy5wbS1hcHAtYWJhcm9ib3RpY3MuY29tL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1754189900);

-- --------------------------------------------------------

--
-- Struktur dari tabel `status_wfh`
--

CREATE TABLE `status_wfh` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status_wfh` varchar(45) NOT NULL,
  `code` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `status_wfh`
--

INSERT INTO `status_wfh` (`id`, `status_wfh`, `code`, `created_at`, `updated_at`) VALUES
(14, 'Kerja', 'kerja', '2025-06-16 19:13:36', NULL),
(15, 'Istirahat', 'istirahat', '2025-06-16 19:14:15', NULL),
(16, 'Sholat', 'sholat', '2025-06-16 19:14:24', NULL),
(17, 'Makan', 'makan', '2025-06-16 19:14:34', NULL),
(18, 'Kamar mandi', 'kamar_mandi', '2025-06-16 19:15:13', NULL),
(19, 'Rapat', 'rapat', '2025-06-16 19:15:33', '2025-07-01 13:45:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `status_wfh_has_wfh_session`
--

CREATE TABLE `status_wfh_has_wfh_session` (
  `status_wfh_id` bigint(20) UNSIGNED NOT NULL,
  `wfh_session_id` varchar(255) NOT NULL,
  `start_at` timestamp NULL DEFAULT NULL,
  `end_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `status_wfh_has_wfh_session`
--

INSERT INTO `status_wfh_has_wfh_session` (`status_wfh_id`, `wfh_session_id`, `start_at`, `end_at`) VALUES
(14, 'ed213e8f-effe-4c20-9055-c186c492f400', '2025-07-28 07:14:53', NULL),
(14, '3c50aa9c-83c6-4101-91c7-020583dd0ed5', '2025-07-28 07:15:12', NULL),
(14, 'ddc243dc-6e05-415f-b7ee-b89854a667b8', '2025-07-28 07:15:58', NULL),
(14, '27c4848a-b842-4349-b04a-d464a1303e34', '2025-07-28 07:16:59', '2025-07-28 07:16:59'),
(14, 'fa115e26-5580-4206-91a6-672afafc502a', '2025-07-28 07:17:12', '2025-07-28 07:17:12'),
(14, 'c9d96a8c-ed5d-487d-b16a-f06f2f34c5ff', '2025-07-28 07:18:42', NULL),
(14, 'e399c217-10e8-41e6-a5ef-da592fcb3c39', '2025-07-28 07:19:01', '2025-07-28 07:19:01'),
(14, 'ad596e25-72f0-419d-a022-a829041e5af9', '2025-07-28 07:19:16', NULL),
(14, '71c51270-5cd7-4291-ab96-0ffb84033472', '2025-07-28 07:19:39', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `name`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'Software Engineer', 1, NULL, NULL),
(2, 'Network', 2, NULL, NULL),
(3, 'Mobile Engineer', 1, '2024-11-04 18:51:24', '2024-11-04 19:12:08'),
(5, 'Quality Asurance', 1, '2024-11-04 19:11:25', '2024-11-04 19:11:25'),
(6, 'UI / UX Designer', 1, '2024-11-04 19:12:31', '2024-11-04 19:12:31'),
(7, 'Network Engineer', 1, '2024-11-04 19:12:50', '2024-11-04 19:12:50'),
(8, 'Computer Vision', 1, '2024-11-04 19:13:05', '2024-11-04 19:13:05'),
(9, 'Sensor', 2, '2024-11-04 19:15:12', '2024-11-04 19:15:12'),
(10, 'Controller', 2, '2024-11-04 19:15:27', '2024-11-04 19:15:27'),
(11, 'Perangkat I/O', 2, '2024-11-04 19:19:41', '2024-11-04 19:19:41'),
(12, 'Domain', 3, '2024-11-04 19:19:56', '2024-11-04 19:19:56'),
(13, 'Plugin', 3, '2024-11-04 19:20:29', '2024-11-04 19:20:29'),
(14, 'Cloud', 3, '2024-11-04 19:20:42', '2024-11-04 19:20:42'),
(15, 'Manajer Inventaris', 1, '2024-11-08 01:18:01', '2024-11-08 01:18:01'),
(17, 'Staf Gudang', 1, '2024-11-08 01:24:59', '2024-11-08 01:24:59'),
(18, 'Pelatihan', 1, '2024-11-08 01:25:25', '2024-11-08 01:25:25'),
(19, 'PC', 2, '2024-11-08 01:25:51', '2024-11-08 01:25:51'),
(20, 'Barcode Scanner', 2, '2024-11-08 01:26:16', '2024-11-08 01:26:16'),
(21, 'Printer Barcode', 2, '2024-11-08 01:26:37', '2024-11-08 01:26:37'),
(22, 'Rak Penyimpanan', 2, '2024-11-08 01:27:02', '2024-11-08 01:27:02'),
(23, 'CCTV', 2, '2024-11-08 01:27:15', '2024-11-08 01:27:15'),
(24, 'Sistem Manajemen Inventaris (ERP)', 3, '2024-11-08 01:27:54', '2024-11-08 01:27:54'),
(25, 'Software Barcode Generator', 3, '2024-11-08 01:28:17', '2024-11-08 01:28:17'),
(26, 'Subscription Cloud Storage (50GB)', 3, '2024-11-08 01:28:59', '2024-11-08 01:28:59'),
(27, 'Technical Support', 1, '2024-11-08 02:06:29', '2024-11-08 02:06:29'),
(28, 'monitor', 2, '2024-11-08 02:09:03', '2024-11-08 02:09:03'),
(29, 'printer', 2, '2024-11-08 02:09:36', '2024-11-08 02:09:36'),
(30, 'meja dan kursi', 2, '2024-11-08 02:10:20', '2024-11-08 02:10:20'),
(31, 'Aksesoris (keyboard, mouse)', 2, '2024-11-08 02:11:26', '2024-11-08 02:11:26'),
(32, 'Software POS (Point Of Sale)', 3, '2024-11-08 02:12:32', '2024-11-08 02:12:32'),
(33, 'Lisensi Software', 3, '2024-11-08 02:13:14', '2024-11-08 02:56:22'),
(34, 'Pemeliharaan Software', 3, '2024-11-08 02:13:38', '2024-11-08 02:13:38'),
(35, 'Marketing', 1, '2024-11-08 02:52:13', '2024-11-08 02:52:13'),
(36, 'Operasional', 1, '2024-11-08 02:52:44', '2024-11-08 02:52:44'),
(37, 'Remote Contol', 2, '2024-11-08 02:53:19', '2024-11-08 02:53:19'),
(38, 'Microcontroller', 2, '2024-11-08 02:54:25', '2024-11-08 02:54:25'),
(39, 'Antena Wifi/bluetooth', 2, '2024-11-08 02:54:59', '2024-11-08 02:54:59'),
(40, 'Kabel dan Konektor', 2, '2024-11-08 02:55:26', '2024-11-08 02:55:26'),
(41, 'Pengembangan Aplikasi', 3, '2024-11-08 02:55:46', '2024-11-08 02:55:46'),
(42, 'Pelatihan', 1, '2024-12-11 03:25:46', '2024-12-11 03:25:46'),
(43, 'Pemeliharaan Bulanan', 4, '2024-12-11 03:26:03', '2024-12-11 03:26:03'),
(44, 'Dokumentasi Teknik', 5, '2024-12-11 03:30:40', '2024-12-11 03:30:40'),
(45, 'Biaya Operasional', 6, '2024-12-11 03:31:01', '2024-12-11 03:31:01'),
(46, 'Pemasangan Peralatan', 7, '2024-12-11 03:37:26', '2024-12-11 03:37:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `summary` text DEFAULT NULL,
  `start_date_estimation` date NOT NULL,
  `end_date_estimation` date NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `assign_to` bigint(20) DEFAULT NULL,
  `completion_time` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status_id` bigint(20) NOT NULL,
  `category_id` bigint(20) NOT NULL,
  `use_holiday` tinyint(1) NOT NULL DEFAULT 0,
  `use_weekend` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tasks`
--

INSERT INTO `tasks` (`id`, `project_id`, `title`, `summary`, `start_date_estimation`, `end_date_estimation`, `attachment`, `created_by`, `assign_to`, `completion_time`, `created_at`, `updated_at`, `status_id`, `category_id`, `use_holiday`, `use_weekend`, `deleted_at`) VALUES
(69, 14, 'Analisa Kebutuhan', NULL, '2024-12-23', '2024-12-25', '[]', 17156549645531, 17156549645531, '2024-12-23 17:00:00', '2024-12-31 04:31:44', '2025-01-02 05:55:52', 5, 4, 1, 0, NULL),
(70, 14, 'Design database', NULL, '2024-12-25', '2024-12-25', '\"\"', 17156549645531, 17211142220257, '2024-12-23 17:00:00', '2024-12-31 04:42:43', '2025-01-02 05:56:09', 5, 4, 1, 0, NULL),
(71, 14, 'Desain UI/UX', NULL, '2024-12-25', '2024-12-27', '\"\"', 17156549645531, 17207764525328, '2024-12-26 08:00:30', '2024-12-27 04:46:08', '2025-01-02 05:56:31', 5, 4, 1, 0, NULL),
(72, 14, 'Sliceing UI', NULL, '2024-12-30', '2025-01-03', '\"\"', 17156549645531, 17211143943934, '2025-01-01 08:11:13', '2024-12-31 04:49:10', '2025-01-02 05:56:42', 5, 5, 0, 0, NULL),
(73, 14, 'Membuat migration database', NULL, '2024-12-30', '2025-01-01', '[]', 17156549645531, 1672385124827, NULL, '2024-12-31 04:52:18', '2025-01-02 08:05:47', 2, 6, 0, 0, NULL),
(74, 14, 'API', NULL, '2025-01-01', '2025-01-17', '[]', 16096390033569, NULL, NULL, '2024-12-31 05:06:21', NULL, 1, 6, 1, 0, NULL),
(75, 14, 'Register Login - Mobile app', NULL, '2025-01-02', '2025-01-03', '[]', 16096390033569, NULL, NULL, '2024-12-31 07:07:17', NULL, 1, 6, 0, 0, NULL),
(76, 15, 'Database', '<p><br></p>', '2025-03-25', '2025-03-26', '[]', 16096390033569, NULL, NULL, '2025-03-25 13:50:36', NULL, 1, 4, 0, 0, NULL),
(77, 16, 'Analisis kebutuhan', '<p><br></p>', '2025-05-01', '2025-04-24', '[]', 16096390033569, 16837053916801, '2025-06-17 01:39:22', '2025-06-17 01:18:05', NULL, 5, 4, 0, 0, NULL),
(78, 16, 'Desain system', '<p><br></p>', '2025-05-15', '2025-05-22', '\"\"', 16096390033569, 16837053916801, NULL, '2025-06-17 01:20:20', NULL, 2, 4, 0, 0, NULL),
(79, 16, 'Desain UI', '<p><br></p>', '2025-05-21', '2025-05-30', '[]', 16096390033569, NULL, NULL, '2025-06-17 01:23:59', NULL, 1, 5, 0, 0, NULL),
(80, 18, 'Analisa sistem', '<p><br></p>', '2025-06-17', '2025-06-19', '\"\"', 17156549645531, 17156549645531, '2025-06-17 06:55:19', '2025-06-17 06:49:11', '2025-06-17 06:54:26', 5, 4, 0, 0, NULL),
(81, 18, 'Desain prototype', '<p><br></p>', '2025-06-17', '2025-06-20', '\"\"', 17156549645531, 17156549645531, '2025-06-17 07:34:10', '2025-06-17 06:49:56', '2025-06-17 07:34:10', 5, 4, 0, 0, NULL),
(82, 19, 'Analisis', '<p><br></p>', '2025-06-16', '2025-06-15', '[]', 16096390033569, 16096390033569, '2025-06-14 04:08:58', '2025-06-17 08:14:48', '2025-07-02 04:08:58', 5, 4, 0, 0, NULL),
(83, 19, 'Desain', '<p><br></p>', '2025-06-19', '2025-06-25', '\"\"', 16096390033569, 16837053916801, '2025-06-25 16:11:57', '2025-06-17 08:15:40', '2025-07-01 16:11:57', 5, 5, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `task_categories`
--

CREATE TABLE `task_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_code` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `task_categories`
--

INSERT INTO `task_categories` (`id`, `category_name`, `category_code`, `created_at`, `updated_at`) VALUES
(4, 'Analysis', 'analysis', NULL, NULL),
(5, 'Design', 'design', NULL, NULL),
(6, 'Develop', 'develop', NULL, NULL),
(7, 'Testing', 'testing', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `task_criterias`
--

CREATE TABLE `task_criterias` (
  `id` int(11) NOT NULL,
  `c_name` varchar(45) NOT NULL,
  `c_attribute` enum('cost','benefit') NOT NULL,
  `c_value` int(11) NOT NULL,
  `c_description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `task_criterias`
--

INSERT INTO `task_criterias` (`id`, `c_name`, `c_attribute`, `c_value`, `c_description`, `created_at`, `updated_at`) VALUES
(3, 'use_holiday', 'benefit', 30, 'Task dikerjakan termasuk di hari libur', '2025-04-06 03:29:50', '2025-04-06 03:29:50'),
(4, 'use_weekend', 'benefit', 30, 'Task dikerjakan termasuk hari satu dan minggu', '2025-04-06 03:30:24', '2025-04-06 03:30:24'),
(10, 'flag', 'benefit', 15, 'jumlah flagging dalam task', '2025-04-06 03:58:44', '2025-04-06 03:58:44'),
(12, 'end_date_estimation', 'cost', 25, 'deadline task (hari)', '2025-04-06 08:56:06', '2025-04-06 08:56:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `task_flagging`
--

CREATE TABLE `task_flagging` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_id` bigint(20) NOT NULL,
  `flag_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `task_flagging`
--

INSERT INTO `task_flagging` (`id`, `task_id`, `flag_id`, `created_at`, `updated_at`) VALUES
(1, 1, 4, NULL, NULL),
(3, 3, 2, NULL, NULL),
(4, 4, 3, NULL, NULL),
(9, 3, 2, NULL, NULL),
(18, 8, 2, NULL, NULL),
(20, 9, 2, NULL, NULL),
(23, 12, 2, NULL, NULL),
(24, 13, 2, NULL, NULL),
(25, 14, 2, NULL, NULL),
(26, 15, 2, NULL, NULL),
(27, 16, 2, NULL, NULL),
(28, 17, 2, NULL, NULL),
(29, 18, 2, NULL, NULL),
(30, 19, 2, NULL, NULL),
(31, 20, 3, NULL, NULL),
(32, 21, 2, NULL, NULL),
(33, 22, 2, NULL, NULL),
(34, 23, 6, NULL, NULL),
(35, 24, 6, NULL, NULL),
(36, 25, 2, NULL, NULL),
(37, 25, 3, NULL, NULL),
(38, 26, 2, NULL, NULL),
(39, 27, 2, NULL, NULL),
(40, 28, 3, NULL, NULL),
(41, 29, 2, NULL, NULL),
(42, 30, 2, NULL, NULL),
(43, 31, 2, NULL, NULL),
(59, 41, 2, NULL, NULL),
(60, 42, 2, NULL, NULL),
(61, 43, 5, NULL, NULL),
(63, 34, 6, NULL, NULL),
(65, 36, 6, NULL, NULL),
(68, 39, 2, NULL, NULL),
(77, 52, 2, NULL, NULL),
(78, 53, 2, NULL, NULL),
(79, 55, 2, NULL, NULL),
(80, 44, 5, NULL, NULL),
(81, 46, 6, NULL, NULL),
(82, 47, 5, NULL, NULL),
(83, 48, 5, NULL, NULL),
(84, 49, 5, NULL, NULL),
(85, 50, 5, NULL, NULL),
(86, 51, 2, NULL, NULL),
(89, 40, 2, NULL, NULL),
(90, 11, 2, NULL, NULL),
(92, 57, 2, NULL, NULL),
(93, 56, 2, NULL, NULL),
(94, 58, 2, NULL, NULL),
(95, 5, 2, NULL, NULL),
(96, 5, 3, NULL, NULL),
(97, 5, 4, NULL, NULL),
(98, 5, 5, NULL, NULL),
(99, 7, 2, NULL, NULL),
(103, 32, 6, NULL, NULL),
(104, 35, 6, NULL, NULL),
(105, 33, 2, NULL, NULL),
(106, 37, 5, NULL, NULL),
(107, 38, 2, NULL, NULL),
(126, 62, 2, NULL, NULL),
(128, 64, 2, NULL, NULL),
(133, 63, 2, NULL, NULL),
(137, 65, 2, NULL, NULL),
(141, 66, 2, NULL, NULL),
(142, 67, 2, NULL, NULL),
(143, 68, 2, NULL, NULL),
(144, 59, 3, NULL, NULL),
(145, 59, 4, NULL, NULL),
(146, 59, 5, NULL, NULL),
(147, 59, 6, NULL, NULL),
(148, 60, 6, NULL, NULL),
(149, 61, 6, NULL, NULL),
(155, 74, 5, NULL, NULL),
(157, 75, 2, NULL, NULL),
(158, 69, 5, NULL, NULL),
(159, 70, 5, NULL, NULL),
(160, 71, 5, NULL, NULL),
(161, 72, 5, NULL, NULL),
(162, 73, 5, NULL, NULL),
(163, 76, 5, NULL, NULL),
(164, 77, 5, NULL, NULL),
(165, 78, 6, NULL, NULL),
(166, 79, 5, NULL, NULL),
(170, 80, 5, NULL, NULL),
(172, 81, 5, NULL, NULL),
(186, 83, 5, NULL, NULL),
(189, 82, 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `task_flags`
--

CREATE TABLE `task_flags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `flag_name` varchar(255) NOT NULL,
  `flag_code` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `task_flags`
--

INSERT INTO `task_flags` (`id`, `flag_name`, `flag_code`, `created_at`, `updated_at`) VALUES
(2, 'Feature', 'feature', NULL, NULL),
(3, 'Bug', 'bug', NULL, NULL),
(4, 'Change', 'change', NULL, NULL),
(5, 'Request', 'request', NULL, NULL),
(6, 'Architecture', 'architecture', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `task_labeling`
--

CREATE TABLE `task_labeling` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_id` bigint(20) NOT NULL,
  `label_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `task_labeling`
--

INSERT INTO `task_labeling` (`id`, `task_id`, `label_id`, `created_at`, `updated_at`) VALUES
(1, 4, 1, NULL, NULL),
(2, 4, 2, NULL, NULL),
(3, 2, 2, NULL, NULL),
(6, 57, 1, NULL, NULL),
(7, 56, 2, NULL, NULL),
(8, 58, 3, NULL, NULL),
(9, 5, 1, NULL, NULL),
(22, 62, 1, NULL, NULL),
(24, 64, 1, NULL, NULL),
(29, 63, 1, NULL, NULL),
(33, 65, 1, NULL, NULL),
(37, 66, 1, NULL, NULL),
(38, 67, 1, NULL, NULL),
(39, 68, 1, NULL, NULL),
(40, 59, 1, NULL, NULL),
(41, 60, 1, NULL, NULL),
(42, 61, 1, NULL, NULL),
(48, 74, 2, NULL, NULL),
(50, 75, 2, NULL, NULL),
(51, 69, 1, NULL, NULL),
(52, 70, 1, NULL, NULL),
(53, 71, 1, NULL, NULL),
(54, 72, 2, NULL, NULL),
(55, 73, 2, NULL, NULL),
(56, 76, 1, NULL, NULL),
(57, 77, 1, NULL, NULL),
(58, 78, 1, NULL, NULL),
(59, 79, 1, NULL, NULL),
(63, 80, 1, NULL, NULL),
(65, 81, 1, NULL, NULL),
(71, 84, 1, NULL, NULL),
(72, 85, 1, NULL, NULL),
(73, 86, 2, NULL, NULL),
(74, 87, 2, NULL, NULL),
(75, 88, 2, NULL, NULL),
(79, 83, 1, NULL, NULL),
(82, 82, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `task_labels`
--

CREATE TABLE `task_labels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `label_name` varchar(255) NOT NULL,
  `label_code` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `task_labels`
--

INSERT INTO `task_labels` (`id`, `label_name`, `label_code`, `created_at`, `updated_at`) VALUES
(1, 'Sprint 1', 'SP01', NULL, NULL),
(2, 'Sprint 2', 'SP02', NULL, NULL),
(3, 'Sprint 3', 'SP03', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `task_statuses`
--

CREATE TABLE `task_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `code_status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `task_statuses`
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

-- --------------------------------------------------------

--
-- Struktur dari tabel `task_subcriterias`
--

CREATE TABLE `task_subcriterias` (
  `id` int(11) NOT NULL,
  `criteria_id` int(11) NOT NULL,
  `sc_label` varchar(45) NOT NULL,
  `sc_min` double DEFAULT NULL,
  `sc_max` double DEFAULT NULL,
  `sc_value` double NOT NULL,
  `sc_description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `task_subcriterias`
--

INSERT INTO `task_subcriterias` (`id`, `criteria_id`, `sc_label`, `sc_min`, `sc_max`, `sc_value`, `sc_description`, `created_at`, `updated_at`) VALUES
(1, 3, '1', NULL, NULL, 1, NULL, NULL, NULL),
(2, 3, '0', NULL, NULL, 0, NULL, NULL, NULL),
(3, 4, '1', NULL, NULL, 1, NULL, NULL, NULL),
(4, 4, '0', NULL, NULL, 0, NULL, NULL, NULL),
(5, 10, '<2', 0, 2, 0.25, NULL, NULL, NULL),
(6, 10, '3-5', 3, 5, 0.5, NULL, NULL, NULL),
(7, 10, '6-10', 6, 10, 0.75, NULL, NULL, NULL),
(8, 10, '>10', 11, NULL, 1, NULL, NULL, NULL),
(9, 12, '<1', 0, 0, 1, NULL, NULL, NULL),
(10, 12, '1-2', 1, 2, 0.75, NULL, NULL, NULL),
(11, 12, '3-5', 3, 5, 0.5, NULL, NULL, NULL),
(12, 12, '>5', 6, NULL, 0.25, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `time_cards`
--

CREATE TABLE `time_cards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) NOT NULL,
  `employee_id` bigint(20) NOT NULL,
  `task_id` bigint(20) NOT NULL,
  `duration` decimal(5,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `activity_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `time_cards`
--

INSERT INTO `time_cards` (`id`, `project_id`, `employee_id`, `task_id`, `duration`, `created_at`, `updated_at`, `activity_date`) VALUES
(92, 14, 17156549645531, 69, 3.00, '2025-01-02 05:59:15', NULL, '2025-01-02 05:55:52'),
(93, 14, 17211142220257, 70, 0.00, '2025-01-02 05:56:09', NULL, '2025-01-02 05:56:09'),
(94, 14, 17207764525328, 71, 0.00, '2025-01-02 05:56:31', NULL, '2025-01-02 05:56:31'),
(95, 14, 17211143943934, 72, 0.00, '2025-01-02 05:56:42', NULL, '2025-01-02 05:56:42'),
(99, 14, 17211142220257, 70, 0.00, '2025-01-02 07:05:08', NULL, '2025-01-02 07:05:08'),
(100, 14, 17207764525328, 71, 12.00, '2025-01-02 08:00:30', NULL, '2025-01-02 07:05:08'),
(101, 14, 17211143943934, 72, 12.00, '2025-01-02 08:11:13', NULL, '2025-01-02 07:05:08'),
(102, 14, 1672385124827, 73, 0.00, '2025-01-02 08:05:47', NULL, '2025-01-02 08:05:47'),
(103, 16, 16837053916801, 77, 8.00, '2025-06-17 01:39:22', NULL, '2025-06-17 01:18:05'),
(104, 16, 16837053916801, 78, 0.00, '2025-06-17 01:20:20', NULL, '2025-06-17 01:20:20'),
(105, 18, 17156549645531, 80, 6.00, '2025-06-17 06:55:18', NULL, '2025-06-17 06:54:07'),
(106, 18, 17156549645531, 81, 4.00, '2025-06-17 06:55:01', NULL, '2025-06-17 06:54:38'),
(107, 19, 16096390033569, 82, 0.00, '2025-06-17 08:14:48', NULL, '2025-06-17 08:14:48'),
(108, 19, 16837053916801, 83, 0.00, '2025-07-01 16:10:27', NULL, '2025-07-01 16:10:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tracks`
--

CREATE TABLE `tracks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` bigint(20) NOT NULL,
  `sub_category_id` bigint(20) NOT NULL,
  `uom` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total_per_item` decimal(10,2) NOT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_project` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tracks`
--

INSERT INTO `tracks` (`id`, `name`, `category_id`, `sub_category_id`, `uom`, `quantity`, `unit_price`, `total_per_item`, `attachment`, `purchase_date`, `created_at`, `updated_at`, `id_project`) VALUES
(23, 'Y. Ihsan', 1, 6, 'Hari', 10, 100000.00, 1000000.00, NULL, '2025-01-03', '2025-01-03 00:50:22', NULL, 14),
(24, 'Adhika', 1, 1, 'Hari', 60, 200000.00, 12000000.00, NULL, '2025-01-03', '2025-01-03 00:51:04', NULL, 14),
(25, 'fatma', 1, 1, 'mounth', 1, 3000000.00, 3000000.00, NULL, '2025-06-10', '2025-06-17 01:28:41', NULL, 16),
(26, 'Wahyu', 1, 1, 'bulan', 1, 2000000.00, 2000000.00, NULL, '2025-06-17', '2025-06-17 06:59:05', NULL, 18);

-- --------------------------------------------------------

--
-- Struktur dari tabel `uom`
--

CREATE TABLE `uom` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `wfh_session`
--

CREATE TABLE `wfh_session` (
  `peer_id` varchar(255) NOT NULL,
  `start` timestamp NULL DEFAULT NULL,
  `end` timestamp NULL DEFAULT NULL,
  `status` enum('ongoing','end') DEFAULT NULL,
  `app_user_user_id` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `wfh_session`
--

INSERT INTO `wfh_session` (`peer_id`, `start`, `end`, `status`, `app_user_user_id`) VALUES
('27c4848a-b842-4349-b04a-d464a1303e34', '2025-07-28 07:16:09', '2025-07-28 07:16:59', 'end', '16837053916801'),
('3c50aa9c-83c6-4101-91c7-020583dd0ed5', '2025-07-28 07:15:00', '2025-07-28 07:15:12', 'end', '16837053916801'),
('71c51270-5cd7-4291-ab96-0ffb84033472', '2025-07-28 07:19:08', '2025-07-28 07:19:39', 'end', '16096390033565'),
('ad596e25-72f0-419d-a022-a829041e5af9', '2025-07-28 07:18:47', '2025-07-28 07:19:16', 'end', '16837053916801'),
('c9d96a8c-ed5d-487d-b16a-f06f2f34c5ff', '2025-07-28 07:18:01', '2025-07-28 07:18:42', 'end', '16837053916801'),
('ddc243dc-6e05-415f-b7ee-b89854a667b8', '2025-07-28 07:15:24', '2025-07-28 07:15:58', 'end', '16837053916801'),
('e399c217-10e8-41e6-a5ef-da592fcb3c39', '2025-07-28 07:17:40', '2025-07-28 07:19:01', 'end', '16096390033565'),
('ed213e8f-effe-4c20-9055-c186c492f400', '2025-07-28 07:14:33', '2025-07-28 07:14:53', 'end', '16837053916801'),
('fa115e26-5580-4206-91a6-672afafc502a', '2025-07-28 07:11:33', '2025-07-28 07:17:12', 'end', '16096390033565');

-- --------------------------------------------------------

--
-- Struktur dari tabel `workings`
--

CREATE TABLE `workings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `workings`
--

INSERT INTO `workings` (`id`, `employee_id`, `created_at`, `updated_at`) VALUES
(1, 10, '2024-11-06 23:27:22', NULL),
(2, 10, '2024-11-07 22:58:13', NULL),
(3, 10, '2024-11-17 18:19:32', NULL),
(4, 10, '2024-12-04 06:34:34', NULL),
(5, 10, '2024-12-05 07:00:42', NULL),
(6, 10, '2024-12-12 01:10:34', NULL),
(7, 10, '2025-01-02 07:44:42', NULL),
(8, 10, '2025-01-02 07:44:44', NULL),
(9, 10, '2025-02-18 08:59:56', NULL),
(10, 10, '2025-03-16 07:33:28', NULL),
(11, 16096390033569, '2025-05-16 14:00:16', NULL),
(12, 16096390033565, '2025-07-14 07:44:44', NULL),
(13, 17156549645531, '2025-07-18 00:18:27', NULL),
(14, 16837053916801, '2025-07-18 00:29:32', NULL),
(15, 16837053916801, '2025-07-21 04:54:29', NULL),
(16, 1672385124827, '2025-07-21 04:54:36', NULL),
(17, 16838854691417, '2025-07-21 04:57:30', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `app_menu`
--
ALTER TABLE `app_menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indeks untuk tabel `app_menu_control`
--
ALTER TABLE `app_menu_control`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `app_role`
--
ALTER TABLE `app_role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indeks untuk tabel `app_role_menu`
--
ALTER TABLE `app_role_menu`
  ADD PRIMARY KEY (`menu_id`,`role_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indeks untuk tabel `app_role_menu_control`
--
ALTER TABLE `app_role_menu_control`
  ADD PRIMARY KEY (`role_id`,`menu_id`,`menu_control_id`);

--
-- Indeks untuk tabel `app_role_user`
--
ALTER TABLE `app_role_user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indeks untuk tabel `app_user`
--
ALTER TABLE `app_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indeks untuk tabel `button_starts`
--
ALTER TABLE `button_starts`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `cost_performances`
--
ALTER TABLE `cost_performances`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_evm`
--
ALTER TABLE `data_evm`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_data_evm_projects1_idx` (`projects_id`);

--
-- Indeks untuk tabel `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `employee_address`
--
ALTER TABLE `employee_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indeks untuk tabel `employee_family`
--
ALTER TABLE `employee_family`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `employee_file`
--
ALTER TABLE `employee_file`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indeks untuk tabel `employee_form`
--
ALTER TABLE `employee_form`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `employee_hierarchy`
--
ALTER TABLE `employee_hierarchy`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `employee_master_department`
--
ALTER TABLE `employee_master_department`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `employee_master_level`
--
ALTER TABLE `employee_master_level`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `employee_medical_check`
--
ALTER TABLE `employee_medical_check`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `employee_organization`
--
ALTER TABLE `employee_organization`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `employee_salary`
--
ALTER TABLE `employee_salary`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `employee_skill`
--
ALTER TABLE `employee_skill`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `employee_training_sertif`
--
ALTER TABLE `employee_training_sertif`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `employee_work_experience`
--
ALTER TABLE `employee_work_experience`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `employee_work_reason`
--
ALTER TABLE `employee_work_reason`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `master_department`
--
ALTER TABLE `master_department`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `project_statuses`
--
ALTER TABLE `project_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `project_team`
--
ALTER TABLE `project_team`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pulse_aggregates`
--
ALTER TABLE `pulse_aggregates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pulse_aggregates_bucket_period_type_aggregate_key_hash_unique` (`bucket`,`period`,`type`,`aggregate`,`key_hash`),
  ADD KEY `pulse_aggregates_period_bucket_index` (`period`,`bucket`),
  ADD KEY `pulse_aggregates_type_index` (`type`),
  ADD KEY `pulse_aggregates_period_type_aggregate_bucket_index` (`period`,`type`,`aggregate`,`bucket`);

--
-- Indeks untuk tabel `pulse_entries`
--
ALTER TABLE `pulse_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pulse_entries_timestamp_index` (`timestamp`),
  ADD KEY `pulse_entries_type_index` (`type`),
  ADD KEY `pulse_entries_key_hash_index` (`key_hash`),
  ADD KEY `pulse_entries_timestamp_type_key_hash_value_index` (`timestamp`,`type`,`key_hash`,`value`);

--
-- Indeks untuk tabel `pulse_values`
--
ALTER TABLE `pulse_values`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pulse_values_type_key_hash_unique` (`type`,`key_hash`),
  ADD KEY `pulse_values_timestamp_index` (`timestamp`),
  ADD KEY `pulse_values_type_index` (`type`);

--
-- Indeks untuk tabel `release_notes`
--
ALTER TABLE `release_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `status_wfh`
--
ALTER TABLE `status_wfh`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `status_wfh_has_wfh_session`
--
ALTER TABLE `status_wfh_has_wfh_session`
  ADD KEY `fk_status_wfh_has_wfh_session_wfh_session1_idx` (`wfh_session_id`),
  ADD KEY `fk_status_wfh_has_wfh_session_status_wfh1_idx` (`status_wfh_id`);

--
-- Indeks untuk tabel `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `task_categories`
--
ALTER TABLE `task_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `task_criterias`
--
ALTER TABLE `task_criterias`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `task_flagging`
--
ALTER TABLE `task_flagging`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `task_flags`
--
ALTER TABLE `task_flags`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `task_labeling`
--
ALTER TABLE `task_labeling`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `task_labels`
--
ALTER TABLE `task_labels`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `task_statuses`
--
ALTER TABLE `task_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `task_subcriterias`
--
ALTER TABLE `task_subcriterias`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `time_cards`
--
ALTER TABLE `time_cards`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tracks`
--
ALTER TABLE `tracks`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `uom`
--
ALTER TABLE `uom`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indeks untuk tabel `wfh_session`
--
ALTER TABLE `wfh_session`
  ADD PRIMARY KEY (`peer_id`),
  ADD UNIQUE KEY `wfh_session_peer_id_IDX` (`peer_id`) USING BTREE,
  ADD KEY `fk_wfh_session_app_user1_idx` (`app_user_user_id`);

--
-- Indeks untuk tabel `workings`
--
ALTER TABLE `workings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `app_menu_control`
--
ALTER TABLE `app_menu_control`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT untuk tabel `button_starts`
--
ALTER TABLE `button_starts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `cost_performances`
--
ALTER TABLE `cost_performances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `employee_address`
--
ALTER TABLE `employee_address`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `employee_family`
--
ALTER TABLE `employee_family`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `employee_file`
--
ALTER TABLE `employee_file`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `employee_form`
--
ALTER TABLE `employee_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `employee_hierarchy`
--
ALTER TABLE `employee_hierarchy`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT untuk tabel `employee_master_department`
--
ALTER TABLE `employee_master_department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `employee_master_level`
--
ALTER TABLE `employee_master_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `employee_medical_check`
--
ALTER TABLE `employee_medical_check`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `employee_organization`
--
ALTER TABLE `employee_organization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `employee_salary`
--
ALTER TABLE `employee_salary`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT untuk tabel `employee_skill`
--
ALTER TABLE `employee_skill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `employee_training_sertif`
--
ALTER TABLE `employee_training_sertif`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `employee_work_experience`
--
ALTER TABLE `employee_work_experience`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `employee_work_reason`
--
ALTER TABLE `employee_work_reason`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT untuk tabel `master_department`
--
ALTER TABLE `master_department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `plans`
--
ALTER TABLE `plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `project_statuses`
--
ALTER TABLE `project_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `project_team`
--
ALTER TABLE `project_team`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT untuk tabel `pulse_aggregates`
--
ALTER TABLE `pulse_aggregates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT untuk tabel `pulse_entries`
--
ALTER TABLE `pulse_entries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `pulse_values`
--
ALTER TABLE `pulse_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `release_notes`
--
ALTER TABLE `release_notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `status_wfh`
--
ALTER TABLE `status_wfh`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT untuk tabel `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT untuk tabel `task_categories`
--
ALTER TABLE `task_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `task_criterias`
--
ALTER TABLE `task_criterias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `task_flagging`
--
ALTER TABLE `task_flagging`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=190;

--
-- AUTO_INCREMENT untuk tabel `task_flags`
--
ALTER TABLE `task_flags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `task_labeling`
--
ALTER TABLE `task_labeling`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT untuk tabel `task_labels`
--
ALTER TABLE `task_labels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `task_statuses`
--
ALTER TABLE `task_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `task_subcriterias`
--
ALTER TABLE `task_subcriterias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `time_cards`
--
ALTER TABLE `time_cards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT untuk tabel `tracks`
--
ALTER TABLE `tracks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `uom`
--
ALTER TABLE `uom`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `workings`
--
ALTER TABLE `workings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `app_role_menu`
--
ALTER TABLE `app_role_menu`
  ADD CONSTRAINT `app_role_menu_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `app_menu` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `app_role_menu_ibfk_3` FOREIGN KEY (`role_id`) REFERENCES `app_role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `app_role_user`
--
ALTER TABLE `app_role_user`
  ADD CONSTRAINT `app_role_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `app_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `app_role_user_ibfk_3` FOREIGN KEY (`role_id`) REFERENCES `app_role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `data_evm`
--
ALTER TABLE `data_evm`
  ADD CONSTRAINT `fk_data_evm_projects1` FOREIGN KEY (`projects_id`) REFERENCES `projects` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `employee_address`
--
ALTER TABLE `employee_address`
  ADD CONSTRAINT `employee_address_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `employee_file`
--
ALTER TABLE `employee_file`
  ADD CONSTRAINT `employee_file_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `status_wfh_has_wfh_session`
--
ALTER TABLE `status_wfh_has_wfh_session`
  ADD CONSTRAINT `fk_status_wfh_has_wfh_session_status_wfh1` FOREIGN KEY (`status_wfh_id`) REFERENCES `status_wfh` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `status_wfh_has_wfh_session_wfh_session_FK` FOREIGN KEY (`wfh_session_id`) REFERENCES `wfh_session` (`peer_id`);

--
-- Ketidakleluasaan untuk tabel `wfh_session`
--
ALTER TABLE `wfh_session`
  ADD CONSTRAINT `fk_wfh_session_app_user1` FOREIGN KEY (`app_user_user_id`) REFERENCES `app_user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
