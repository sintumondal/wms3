-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 06, 2020 at 06:50 PM
-- Server version: 5.5.53
-- PHP Version: 7.1.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wms`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('15533922e9cb99c305253756ff751f70579063df2366f70a5bfef0b32d4c6f8a1c570411552eec85', 2, 1, 'appToken', '[]', 0, '2020-10-04 02:34:55', '2020-10-04 02:34:55', '2021-10-04 08:04:55'),
('22900c2856ad4344a5e04ebc414095ba00ad275b8db7720ee29d3dbf4ec5941df771a1d19cf835db', 2, 1, 'appToken', '[]', 0, '2020-09-27 20:29:51', '2020-09-27 20:29:51', '2021-09-28 01:59:51'),
('2806311c64b9f2fc609e567a67c4436d66426658cf24b1de51a20ee30137f685d8dd07d40863d512', 1, 1, 'appToken', '[]', 0, '2020-10-02 07:17:15', '2020-10-02 07:17:15', '2021-10-02 12:47:15'),
('3f2759b32cf64ea70d75827732fd6eb934f79fbcb5aa3d05a13079454907aa694fc2b45ae7c9c52f', 1, 1, 'appToken', '[]', 0, '2020-10-03 02:24:41', '2020-10-03 02:24:41', '2021-10-03 07:54:41'),
('3f833c3be5946be24f21b493515b6662cc914191fa98bf99f2e748be28a53544169999e96e7b5dad', 1, 1, 'appToken', '[]', 0, '2020-09-22 01:05:11', '2020-09-22 01:05:11', '2021-09-22 06:35:11'),
('41d865fbf99da8ddd2c01ddcef1099099ff6a1b8456a4434dff3e25163998a231f281166a249b4f2', 2, 1, 'appToken', '[]', 0, '2020-09-24 07:37:10', '2020-09-24 07:37:10', '2021-09-24 13:07:10'),
('4e2c362c9e885eb6de5a5c8ad31d82c1f7ae6ea8b7fc7b867c3df0aae0d0659170c79becf6f26cc1', 2, 1, 'appToken', '[]', 0, '2020-10-03 23:51:49', '2020-10-03 23:51:49', '2021-10-04 05:21:49'),
('60a6ae5538bb9414d26f6b3e980665a40c5b93c3c114dab0d169fc061522f2824822460ca37b8afc', 3, 1, 'appToken', '[]', 0, '2020-08-28 00:33:17', '2020-08-28 00:33:17', '2021-08-28 06:03:17'),
('623b993a187511a05e605552a070d7df970fc367281aa8279aa01252120c35301c8f980f19cc761b', 3, 1, 'appToken', '[]', 0, '2020-08-28 00:27:08', '2020-08-28 00:27:08', '2021-08-28 05:57:08'),
('70e5c3c364cc1b66fe53b862005b1dde4d2f97f3050542acc493cd52ae339c1350b9048142a11d4b', 3, 1, 'appToken', '[]', 0, '2020-08-28 00:01:52', '2020-08-28 00:01:52', '2021-08-28 05:31:52'),
('a430e738d42d15012832eb86493118ae9e07216f5602a3ca12e79b92704d9640170e4984bdd5738f', 5, 1, 'appToken', '[]', 0, '2020-11-06 07:35:51', '2020-11-06 07:35:51', '2021-11-06 13:05:51'),
('a9d7bd431f71f3d1c99c45e325ee5aecbbffd99699c7c4f43616e034c81263085e7ce38da6782110', 2, 1, 'appToken', '[]', 0, '2020-10-02 07:19:20', '2020-10-02 07:19:20', '2021-10-02 12:49:20'),
('b789ad8db3abc73cca733238ebdf116f90281506c924aeda55e2f83f4b4c14a56214d492699c145d', 2, 1, 'appToken', '[]', 0, '2020-10-22 00:39:23', '2020-10-22 00:39:23', '2021-10-22 06:09:23'),
('c0c56648f01cd7f67840e01cf3c0de5cada473a6d1ffc592535b770adb0322a532c4b8106b850851', 3, 1, 'appToken', '[]', 0, '2020-11-06 07:38:25', '2020-11-06 07:38:25', '2021-11-06 13:08:25'),
('c847cd148f5e61a2a4a6f5a1dc219bfcf633a079d1b2a23d11b7ae5f793491d9390c49daa1b89cc9', 1, 1, 'appToken', '[]', 0, '2020-08-28 01:58:08', '2020-08-28 01:58:08', '2021-08-28 07:28:08'),
('d4947fdfa6c7221cc01d2825d347b530e625a84197ef8bac553f70161a5d844aeda1641b6046c1d5', 2, 1, 'appToken', '[]', 0, '2020-10-05 02:09:07', '2020-10-05 02:09:07', '2021-10-05 07:39:07'),
('e1aa380313601de753ad9bcec7849d02f3f4e2d0f2762ab0b754e1605aa7e20903a2b3a99fa7e16c', 2, 1, 'appToken', '[]', 0, '2020-09-22 01:16:43', '2020-09-22 01:16:43', '2021-09-22 06:46:43'),
('ecb72f94b8bbba340ac94ab96e2b86b786674ef0c3647f1b0a7617705b06a6481ebef415f7de9e39', 3, 1, 'appToken', '[]', 0, '2020-11-06 07:34:56', '2020-11-06 07:34:56', '2021-11-06 13:04:56');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'cOSb7ShvWYvJ0atGKGdDlZTPckagFGdcNGrQ25hy', NULL, 'http://localhost', 1, 0, 0, '2020-08-27 07:27:03', '2020-08-27 07:27:03'),
(2, NULL, 'Laravel Password Grant Client', 'uQMPC0lrcmpu9nAPt58ZoVCqY1T7eKTLQa3D6gbV', 'users', 'http://localhost', 0, 1, 0, '2020-08-27 07:27:03', '2020-08-27 07:27:03');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2020-08-27 07:27:03', '2020-08-27 07:27:03');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_allowance`
--

CREATE TABLE `tbl_allowance` (
  `code` int(11) NOT NULL,
  `allowance_type` int(10) NOT NULL,
  `name_of_allowance` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_allowance`
--

INSERT INTO `tbl_allowance` (`code`, `allowance_type`, `name_of_allowance`, `created_at`, `updated_at`) VALUES
(1, 1, 'BASIC', '2020-10-09 10:28:39', '2020-10-09 10:28:39'),
(2, 1, 'HRA', '2020-10-09 10:28:47', '2020-10-09 10:28:47'),
(3, 1, 'DA', '2020-10-09 10:29:31', '2020-10-15 00:52:18'),
(4, 2, 'PF', '2020-10-12 06:14:48', '2020-10-12 06:14:48'),
(5, 2, 'PTax', '2020-10-16 01:50:14', '2020-10-16 01:50:14');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attendance_entry`
--

CREATE TABLE `tbl_attendance_entry` (
  `code` int(11) NOT NULL,
  `emp_code` int(11) NOT NULL,
  `in_date_time` datetime DEFAULT NULL,
  `out_date_time` datetime DEFAULT NULL,
  `att_status` int(11) NOT NULL DEFAULT '0' COMMENT '1= IN, 2=OUT',
  `emp_image` varchar(200) NOT NULL,
  `emp_image_out` varchar(200) DEFAULT NULL,
  `current_att_date` date NOT NULL,
  `att_lat` varchar(100) DEFAULT NULL,
  `att_long` varchar(100) DEFAULT NULL,
  `att_lat_out` varchar(100) DEFAULT NULL,
  `att_long_out` varchar(100) DEFAULT NULL,
  `shift_code` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_attendance_entry`
--

INSERT INTO `tbl_attendance_entry` (`code`, `emp_code`, `in_date_time`, `out_date_time`, `att_status`, `emp_image`, `emp_image_out`, `current_att_date`, `att_lat`, `att_long`, `att_lat_out`, `att_long_out`, `shift_code`, `created_at`, `updated_at`) VALUES
(1, 1, '2020-09-08 12:33:55', NULL, 1, 'ttt.jpg', NULL, '2020-10-22', '23.9129', '87.5268', NULL, NULL, 2, '2020-10-04 02:39:55', '2020-10-04 03:08:28'),
(2, 1, '2020-09-08 12:33:54', '2020-09-08 15:33:57', 2, 'tttrr.jpg', NULL, '2020-10-04', '23.9129', '87.5268', NULL, NULL, 2, '2020-10-04 03:10:32', '2020-10-04 03:12:57'),
(3, 1, '2020-09-08 12:33:55', '2020-09-08 16:33:52', 2, 'ppp.jpg', 'pppoo.jpg', '2020-09-05', '23.9129', '87.5268', NULL, NULL, 2, '2020-10-05 02:11:03', '2020-10-05 02:16:29'),
(4, 2, '2020-09-08 12:33:55', '2020-09-08 16:33:52', 2, 'ppp.jpg', 'pppoo.jpg', '2020-10-01', '23.9129', '87.5268', NULL, NULL, 2, '2020-10-05 02:11:03', '2020-10-05 02:16:29'),
(5, 2, '2020-09-08 12:33:55', '2020-09-08 16:33:52', 2, 'ppp.jpg', 'pppoo.jpg', '2020-10-05', '23.9129', '87.5268', NULL, NULL, 2, '2020-10-05 02:11:03', '2020-10-05 02:16:29'),
(6, 3, '2020-09-08 12:33:55', '2020-09-08 16:33:52', 2, 'ppp.jpg', 'pppoo.jpg', '2020-10-01', '23.9129', '87.5268', NULL, NULL, 2, '2020-10-05 02:11:03', '2020-10-05 02:16:29'),
(7, 3, '2020-09-08 12:33:55', '2020-09-08 16:33:52', 2, 'ppp.jpg', 'pppoo.jpg', '2020-10-07', '23.9129', '87.5268', NULL, NULL, 2, '2020-10-05 02:11:03', '2020-10-05 02:16:29');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_department`
--

CREATE TABLE `tbl_department` (
  `code` int(11) NOT NULL,
  `department` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_department`
--

INSERT INTO `tbl_department` (`code`, `department`, `created_at`, `updated_at`) VALUES
(3, 'COMPUTER', '2020-09-02 06:12:09', '2020-11-06 04:19:18'),
(4, 'MINING', '2020-09-02 06:13:38', '2020-11-06 04:19:40'),
(5, 'DLLRO', '2020-09-02 06:27:42', '2020-11-06 04:20:00'),
(6, 'MGNRGA', '2020-09-02 06:28:13', '2020-11-06 04:19:01'),
(7, 'BDO', '2020-09-02 06:28:55', '2020-11-06 04:20:17');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_designation`
--

CREATE TABLE `tbl_designation` (
  `code` int(11) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_designation`
--

INSERT INTO `tbl_designation` (`code`, `designation`, `created_at`, `updated_at`) VALUES
(1, 'Project Lead', '2020-08-28 06:42:36', '2020-11-06 04:18:13'),
(2, 'Team Lead', '2020-09-02 01:58:58', '2020-11-06 04:18:34'),
(3, 'System Analyst', '2020-09-02 02:02:16', '2020-11-06 04:17:52'),
(5, 'Developer', '2020-09-02 02:07:17', '2020-11-06 04:16:02'),
(6, 'Trainee Engineer', '2020-09-08 05:55:53', '2020-11-06 04:17:26'),
(7, 'Accountent', '2020-09-08 05:56:32', '2020-11-06 04:16:26');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_designation_wise_allowance`
--

CREATE TABLE `tbl_designation_wise_allowance` (
  `code` int(11) NOT NULL,
  `designation_code` int(11) NOT NULL,
  `allowance_code` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_designation_wise_allowance`
--

INSERT INTO `tbl_designation_wise_allowance` (`code`, `designation_code`, `allowance_code`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 1, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 1, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 1, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 1, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 2, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 2, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 2, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 2, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 3, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 3, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 3, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 3, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 5, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 5, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 5, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 5, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 5, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 6, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 6, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 6, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 6, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 6, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 7, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, 7, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26, 7, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(27, 7, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_designation_wise_leave_assign`
--

CREATE TABLE `tbl_designation_wise_leave_assign` (
  `code` int(11) NOT NULL,
  `year` varchar(50) NOT NULL,
  `designation_code` int(11) NOT NULL,
  `type_of_leave_code` int(11) NOT NULL,
  `no_of_leave` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_designation_wise_leave_assign`
--

INSERT INTO `tbl_designation_wise_leave_assign` (`code`, `year`, `designation_code`, `type_of_leave_code`, `no_of_leave`, `created_at`, `updated_at`) VALUES
(1, '2020', 1, 1, 10, '2020-11-06 04:23:49', '2020-11-06 04:23:49'),
(2, '2020', 1, 2, 10, '2020-11-06 04:23:49', '2020-11-06 04:23:49'),
(3, '2020', 1, 4, 5, '2020-11-06 04:23:49', '2020-11-06 04:23:49'),
(4, '2020', 1, 5, 2, '2020-11-06 04:23:50', '2020-11-06 04:23:50'),
(5, '2020', 2, 1, 10, '2020-11-06 04:29:07', '2020-11-06 04:29:07'),
(6, '2020', 2, 2, 10, '2020-11-06 04:29:07', '2020-11-06 04:29:07'),
(7, '2020', 2, 3, 5, '2020-11-06 04:29:07', '2020-11-06 04:29:07'),
(8, '2020', 2, 4, 5, '2020-11-06 04:29:07', '2020-11-06 04:29:07'),
(9, '2020', 2, 5, 5, '2020-11-06 04:29:07', '2020-11-06 04:29:07'),
(10, '2020', 3, 1, 10, '2020-11-06 04:29:38', '2020-11-06 04:29:38'),
(11, '2020', 3, 2, 10, '2020-11-06 04:29:39', '2020-11-06 04:29:39'),
(12, '2020', 3, 3, 5, '2020-11-06 04:29:39', '2020-11-06 04:29:39'),
(13, '2020', 3, 4, 5, '2020-11-06 04:29:39', '2020-11-06 04:29:39'),
(14, '2020', 3, 5, 5, '2020-11-06 04:29:39', '2020-11-06 04:29:39'),
(15, '2020', 5, 1, 10, '2020-11-06 04:30:02', '2020-11-06 04:30:02'),
(16, '2020', 5, 2, 10, '2020-11-06 04:30:02', '2020-11-06 04:30:02'),
(17, '2020', 5, 3, 10, '2020-11-06 04:30:02', '2020-11-06 04:30:02'),
(18, '2020', 5, 4, 10, '2020-11-06 04:30:02', '2020-11-06 04:30:02'),
(19, '2020', 5, 5, 10, '2020-11-06 04:30:02', '2020-11-06 04:30:02'),
(20, '2020', 6, 1, 5, '2020-11-06 04:30:21', '2020-11-06 04:30:21'),
(21, '2020', 6, 2, 5, '2020-11-06 04:30:21', '2020-11-06 04:30:21'),
(22, '2020', 6, 3, 5, '2020-11-06 04:30:21', '2020-11-06 04:30:21'),
(23, '2020', 6, 4, 2, '2020-11-06 04:30:21', '2020-11-06 04:30:21'),
(24, '2020', 6, 5, 2, '2020-11-06 04:30:21', '2020-11-06 04:30:21'),
(25, '2020', 7, 1, 12, '2020-11-06 04:30:40', '2020-11-06 04:30:40'),
(26, '2020', 7, 2, 5, '2020-11-06 04:30:40', '2020-11-06 04:30:40'),
(27, '2020', 7, 3, 5, '2020-11-06 04:30:40', '2020-11-06 04:30:40'),
(28, '2020', 7, 4, 5, '2020-11-06 04:30:40', '2020-11-06 04:30:40'),
(29, '2020', 7, 5, 10, '2020-11-06 04:30:40', '2020-11-06 04:30:40');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee_allowance_entry`
--

CREATE TABLE `tbl_employee_allowance_entry` (
  `code` int(11) NOT NULL,
  `emp_code` int(11) NOT NULL,
  `salary_type` int(11) NOT NULL,
  `allowance_code` int(11) NOT NULL,
  `fixed_persentage` int(10) DEFAULT NULL,
  `on_allowance_code` int(10) DEFAULT NULL,
  `amount` float NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_employee_allowance_entry`
--

INSERT INTO `tbl_employee_allowance_entry` (`code`, `emp_code`, `salary_type`, `allowance_code`, `fixed_persentage`, `on_allowance_code`, `amount`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 0, 0, 12000, '2020-11-06 04:45:30', '2020-11-06 04:45:30'),
(2, 1, 1, 2, 1, 0, 200, '2020-11-06 04:45:30', '2020-11-06 04:45:30'),
(3, 1, 1, 3, 1, 0, 300, '2020-11-06 04:45:30', '2020-11-06 04:45:30'),
(4, 1, 1, 4, 1, 0, 300, '2020-11-06 04:45:30', '2020-11-06 04:45:30'),
(5, 1, 1, 5, 1, 0, 300, '2020-11-06 04:45:30', '2020-11-06 04:45:30'),
(6, 2, 1, 1, 0, 0, 20000, '2020-11-06 04:51:43', '2020-11-06 04:51:43'),
(7, 2, 1, 2, 1, 0, 200, '2020-11-06 04:51:43', '2020-11-06 04:51:43'),
(8, 2, 1, 3, 1, 0, 200, '2020-11-06 04:51:43', '2020-11-06 04:51:43'),
(9, 2, 1, 4, 1, 0, 100, '2020-11-06 04:51:43', '2020-11-06 04:51:43'),
(10, 3, 1, 1, 0, 0, 30000, '2020-11-06 04:58:28', '2020-11-06 04:58:28'),
(11, 3, 1, 2, 1, 0, 500, '2020-11-06 04:58:29', '2020-11-06 04:58:29'),
(12, 3, 1, 3, 1, 0, 500, '2020-11-06 04:58:29', '2020-11-06 04:58:29'),
(13, 3, 1, 4, 1, 0, 500, '2020-11-06 04:58:29', '2020-11-06 04:58:29'),
(14, 3, 1, 5, 1, 0, 500, '2020-11-06 04:58:29', '2020-11-06 04:58:29'),
(15, 4, 1, 1, 0, 0, 12000, '2020-11-06 07:22:56', '2020-11-06 07:22:56'),
(16, 4, 1, 2, 1, 0, 200, '2020-11-06 07:22:56', '2020-11-06 07:22:56'),
(17, 4, 1, 3, 1, 0, 500, '2020-11-06 07:22:56', '2020-11-06 07:22:56'),
(18, 4, 1, 4, 1, 0, 700, '2020-11-06 07:22:56', '2020-11-06 07:22:56'),
(19, 4, 1, 5, 1, 0, 400, '2020-11-06 07:22:56', '2020-11-06 07:22:56'),
(20, 5, 1, 1, 0, 0, 10000, '2020-11-06 07:26:14', '2020-11-06 07:26:14'),
(21, 5, 1, 2, 1, 0, 100, '2020-11-06 07:26:14', '2020-11-06 07:26:14'),
(22, 5, 1, 3, 1, 0, 1000, '2020-11-06 07:26:14', '2020-11-06 07:26:14'),
(23, 5, 1, 4, 1, 0, 100, '2020-11-06 07:26:14', '2020-11-06 07:26:14'),
(24, 6, 1, 1, 0, 0, 30000, '2020-11-06 07:27:18', '2020-11-06 07:27:18'),
(25, 6, 1, 2, 1, 0, 500, '2020-11-06 07:27:18', '2020-11-06 07:27:18'),
(26, 6, 1, 3, 1, 0, 500, '2020-11-06 07:27:18', '2020-11-06 07:27:18'),
(27, 6, 1, 4, 1, 0, 500, '2020-11-06 07:27:18', '2020-11-06 07:27:18'),
(28, 6, 1, 5, 1, 0, 500, '2020-11-06 07:27:18', '2020-11-06 07:27:18'),
(29, 7, 1, 1, 0, 0, 25000, '2020-11-06 07:30:00', '2020-11-06 07:30:00'),
(30, 7, 1, 2, 1, 0, 400, '2020-11-06 07:30:00', '2020-11-06 07:30:00'),
(31, 7, 1, 3, 1, 0, 400, '2020-11-06 07:30:00', '2020-11-06 07:30:00'),
(32, 7, 1, 4, 1, 0, 400, '2020-11-06 07:30:00', '2020-11-06 07:30:00'),
(33, 8, 1, 1, 0, 0, 20000, '2020-11-06 07:32:23', '2020-11-06 07:32:23'),
(34, 8, 1, 2, 1, 0, 400, '2020-11-06 07:32:23', '2020-11-06 07:32:23'),
(35, 8, 1, 3, 1, 0, 400, '2020-11-06 07:32:23', '2020-11-06 07:32:23'),
(36, 8, 1, 4, 1, 0, 400, '2020-11-06 07:32:23', '2020-11-06 07:32:23'),
(37, 8, 1, 5, 1, 0, 400, '2020-11-06 07:32:23', '2020-11-06 07:32:23');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee_details`
--

CREATE TABLE `tbl_employee_details` (
  `code` int(10) UNSIGNED NOT NULL,
  `emp_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emp_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `father_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_image` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_designation` int(10) DEFAULT NULL,
  `emp_deparment` int(10) DEFAULT NULL,
  `dob` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `blood_group` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phno` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hqualification` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pan_no` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marital_status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `spouse_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `noofchildren` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `userImage` text COLLATE utf8mb4_unicode_ci,
  `contact_person` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emg_address` text COLLATE utf8mb4_unicode_ci,
  `emg_phno` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emg_alt_phno` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `relationship` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `c_address` text COLLATE utf8mb4_unicode_ci,
  `c_dist` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `c_state` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `c_pin` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `p_address` text COLLATE utf8mb4_unicode_ci,
  `p_dist` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `p_state` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `p_pin` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `joining_date` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salary_per_day` int(10) DEFAULT NULL,
  `status` int(10) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_employee_details`
--

INSERT INTO `tbl_employee_details` (`code`, `emp_id`, `emp_name`, `father_name`, `mother_name`, `emp_type`, `profile_image`, `emp_designation`, `emp_deparment`, `dob`, `gender`, `blood_group`, `phno`, `hqualification`, `email`, `pan_no`, `marital_status`, `spouse_name`, `noofchildren`, `userImage`, `contact_person`, `emg_address`, `emg_phno`, `emg_alt_phno`, `relationship`, `c_address`, `c_dist`, `c_state`, `c_pin`, `p_address`, `p_dist`, `p_state`, `p_pin`, `joining_date`, `salary_per_day`, `status`, `created_at`, `updated_at`) VALUES
(1, '600000', 'Arpan Ghosh', 'K Ghosh', 'M Ghosh', '1', NULL, 5, 3, '17/10/1996', 'Male', 'O+', '7777777777', 'B Tech', 'aa@gmail.com', NULL, 'No', NULL, NULL, NULL, 'Sintu', 'Ghatal', '8888888888', NULL, 'Friend', 'Panagarh', 'Paschim Barbhaman', 'WB', '713148', 'Panagarh', 'Paschim Barbhaman', 'WB', '713148', '28/11/2020', 300, 0, '2020-11-06 04:42:35', '2020-11-06 04:43:58'),
(2, '600001', 'Sintu Mondal', 'S Mondal', 'R Mondal', '2', NULL, 3, 4, '07/02/1998', 'Male', 'O+', '7777777777', 'BCA', 'abcd@gmail.com', NULL, 'No', NULL, NULL, NULL, 'Arpan', 'Suri', '8888888888', NULL, 'Friend', 'Ghatal', 'Paschim Medinipur', 'West Bengal', '721146', 'Ghatal', 'Paschim Medinipur', 'West Bengal', '721146', '05/11/2020', 200, 1, '2020-11-06 04:48:56', '2020-11-06 04:59:09'),
(3, '600002', 'Partha Sarathi Bhandari', 'A Bhandari', 'S Bhandari', '2', NULL, 5, 6, '09/05/1996', 'Male', 'A+', '5555555555', 'B COM', 'gfgd@gmail.com', NULL, 'Yes', 'B Bhandari', '1', NULL, 'Arabinda', 'Suri', '9999999999', NULL, 'Sir', 'Suri', 'Birbhum', 'West Bengal', '782056', 'Suri', 'Birbhum', 'West Bengal', '782056', '27/10/2020', 500, 1, '2020-11-06 04:55:12', '2020-11-06 04:59:09'),
(4, '600003', 'Oly Rajak', 'G Rajak', 'M Rajak', '2', NULL, 5, 3, '23/11/2020', 'Female', 'O+', '7777777777', 'BCA', 'OO@gg', NULL, 'No', NULL, NULL, NULL, 'Sintu', 'Suri', '8989898989', NULL, 'Friend', 'Suri', 'Nodia', 'WB', '777777', 'Suri', 'Nodia', 'WB', '777777', '21/11/2020', 300, 1, '2020-11-06 07:21:11', '2020-11-06 07:33:08'),
(5, '600004', 'Sk Lutfar', 'Md uuuu', 'hhhhhh', '2', NULL, 7, 5, '01/11/2020', 'Male', 'AB+', '7777777777', 'BSC', 'ggg@ggg', NULL, 'Yes', 'rrrrrrr', '1', NULL, 'Sintu', 'fffffff', '8888888888', NULL, 'hhhhhh', 'Suri', 'Birbhum', 'WB', '888888', 'Suri', 'Birbhum', 'WB', '888888', '07/11/2020', 600, 1, '2020-11-06 07:24:38', '2020-11-06 07:33:08'),
(6, '600005', 'Arabinda Hazra', 'S Hazra', 'R Hazra', '2', NULL, 1, 3, '08/11/1995', 'Male', 'O+', '9544788844', 'B Tech', 'arbinda@gmail.com', NULL, 'Yes', 'S Hazra', '1', NULL, 'Arpan', 'Suri', '7545985259', NULL, 'Friend', 'Suri', 'Birbhum', 'WB', '785449', 'Suri', 'Birbhum', 'WB', '785449', '02/11/2018', 500, 1, '2020-11-06 07:24:55', '2020-11-06 07:33:08'),
(7, '600006', 'Suman Das', 'S Das', 'S Das', '2', NULL, 2, 5, '11/05/1996', 'Male', 'AB+', '7854555155', 'B Tech', 'suman@gmail.com', NULL, 'No', NULL, NULL, NULL, 'Arbinda', 'Suri', '7887551552', NULL, 'Friend', 'Suri', 'Nodia', 'WB', '878848', 'Suri', 'Nodia', 'WB', '878848', '07/11/2017', 400, 1, '2020-11-06 07:28:18', '2020-11-06 07:33:08'),
(8, '600007', 'Binoy Das', 'B Das', 'R Das', '1', NULL, 5, 7, '07/05/1997', 'Male', 'B+', '7874454984', 'BCA', 'sa@gg', NULL, 'No', NULL, NULL, NULL, 'Arpan', 'Suri', '8877455555', NULL, 'Friend', 'Suri', 'Nodia', 'WB', '744888', 'Suri', 'Nodia', 'WB', '744888', '07/05/2018', 400, 0, '2020-11-06 07:30:48', '2020-11-06 07:31:55');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee_leave_taken`
--

CREATE TABLE `tbl_employee_leave_taken` (
  `code` int(11) NOT NULL,
  `emp_code` int(11) NOT NULL,
  `leave_date` date NOT NULL,
  `year` varchar(200) NOT NULL,
  `type_of_leave_code` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_employee_leave_taken`
--

INSERT INTO `tbl_employee_leave_taken` (`code`, `emp_code`, `leave_date`, `year`, `type_of_leave_code`, `created_at`, `updated_at`) VALUES
(1, 1, '2020-10-01', '2020', 1, '2020-11-06 05:07:16', '2020-11-06 05:07:16'),
(2, 1, '2020-10-05', '2020', 2, '2020-11-06 05:07:55', '2020-11-06 05:07:55'),
(3, 3, '2020-10-03', '2020', 2, '2020-11-06 05:08:58', '2020-11-06 05:08:58'),
(4, 3, '2020-10-05', '2020', 1, '2020-11-06 05:09:11', '2020-11-06 05:09:11'),
(5, 2, '2020-10-19', '2020', 1, '2020-11-06 05:10:18', '2020-11-06 05:10:18'),
(6, 2, '2020-10-16', '2020', 1, '2020-11-06 05:10:29', '2020-11-06 05:10:29');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee_salary_generation`
--

CREATE TABLE `tbl_employee_salary_generation` (
  `code` int(11) NOT NULL,
  `year_month_designation_code` int(11) NOT NULL,
  `table_head` text NOT NULL,
  `table_data` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_employee_salary_generation`
--

INSERT INTO `tbl_employee_salary_generation` (`code`, `year_month_designation_code`, `table_head`, `table_data`, `created_at`, `updated_at`) VALUES
(1, 1, 'Employee ID,Employee Name,Working Days,Present Days,Absent Days,Holidays,Leave,BASIC,HRA,DA,Gross,PF,PTax,Ded,Net', '600000~Arpan Ghosh~31~2~22~5~2~12000~200~300~12500~300~300~600~11900&600002~Partha Sarathi Bhandari~31~2~22~5~2~30000~500~500~31000~500~500~1000~30000', '2020-11-06 06:02:32', '2020-11-06 06:02:32');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee_wise_shift_allocation`
--

CREATE TABLE `tbl_employee_wise_shift_allocation` (
  `code` int(11) NOT NULL,
  `emp_code` int(11) NOT NULL,
  `shift_code` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_employee_wise_shift_allocation`
--

INSERT INTO `tbl_employee_wise_shift_allocation` (`code`, `emp_code`, `shift_code`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '2020-11-06 06:10:06', '2020-11-06 06:10:06'),
(2, 2, 2, '2020-11-06 06:10:12', '2020-11-06 06:10:12'),
(3, 3, 2, '2020-11-06 06:10:19', '2020-11-06 06:10:19'),
(4, 1, 1, '2020-11-06 06:10:42', '2020-11-06 06:10:42'),
(5, 6, 2, '2020-11-06 07:42:52', '2020-11-06 07:42:52'),
(6, 7, 2, '2020-11-06 07:42:57', '2020-11-06 07:42:57'),
(7, 4, 2, '2020-11-06 07:43:04', '2020-11-06 07:43:04'),
(8, 8, 2, '2020-11-06 07:43:11', '2020-11-06 07:43:11'),
(9, 5, 2, '2020-11-06 07:43:17', '2020-11-06 07:43:17');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mobile_user`
--

CREATE TABLE `tbl_mobile_user` (
  `code` int(10) UNSIGNED NOT NULL,
  `emp_code` int(10) NOT NULL,
  `emp_type` int(10) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_no` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imie_no` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `userImage` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_mobile_user`
--

INSERT INTO `tbl_mobile_user` (`code`, `emp_code`, `emp_type`, `name`, `designation`, `mobile_no`, `password`, `imie_no`, `status`, `userImage`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 0, 0, 'Admin', 'Admin', '9999999990', '$2a$10$VCfI3mLV067sFbBzYCYhuOXvcNxm83sUNLE6QCeEWS9Rr9qKZFnBG', NULL, 1, NULL, '2020-09-11 12:18:45', NULL, NULL),
(3, 1, 1, 'Arpan Ghosh', 'Supervisor', '9999999999', NULL, NULL, 1, NULL, '2020-11-06 06:51:49', '2020-11-06 06:51:49', NULL),
(5, 8, 1, 'Binoy Das', 'Supervisor', '8888888888', NULL, NULL, 1, NULL, '2020-11-06 07:34:27', '2020-11-06 07:34:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_month_year_designation_salary_generation`
--

CREATE TABLE `tbl_month_year_designation_salary_generation` (
  `code` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `designation_code` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_month_year_designation_salary_generation`
--

INSERT INTO `tbl_month_year_designation_salary_generation` (`code`, `year`, `month`, `designation_code`, `created_at`, `updated_at`) VALUES
(1, 2020, 10, 5, '2020-11-06 06:02:32', '2020-11-06 06:02:32');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_of_holiday`
--

CREATE TABLE `tbl_of_holiday` (
  `code` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `holiday_date` date NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_of_holiday`
--

INSERT INTO `tbl_of_holiday` (`code`, `year`, `holiday_date`, `description`, `created_at`, `updated_at`) VALUES
(1, 2020, '2020-10-23', 'Saptami', '2020-10-20 06:03:15', '2020-10-20 06:03:15'),
(2, 2020, '2020-10-24', 'Astami', '2020-10-20 06:03:34', '2020-10-20 06:03:34'),
(3, 2020, '2020-10-25', 'Nabami', '2020-10-20 06:04:34', '2020-10-20 06:04:34'),
(4, 2020, '2020-10-26', 'Dasami', '2020-10-20 06:04:34', '2020-10-20 06:04:34'),
(5, 2020, '2020-10-02', 'Gandhi Jayanti', '2020-10-20 06:04:55', '2020-10-20 06:04:55');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_otp_verified`
--

CREATE TABLE `tbl_otp_verified` (
  `code` int(11) NOT NULL,
  `mobile_no` varchar(10) NOT NULL,
  `mobile_otp` varchar(100) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=notverified,1=verified',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_otp_verified`
--

INSERT INTO `tbl_otp_verified` (`code`, `mobile_no`, `mobile_otp`, `status`, `created_at`, `updated_at`) VALUES
(1, '7584061326', '123456', 1, '2020-05-02 20:41:33', '2020-05-04 12:18:40'),
(2, '7584061326', '123456', 1, '2020-05-02 21:15:07', '2020-05-04 12:18:40'),
(3, '7584061326', '40665', 1, '2020-05-03 10:20:31', '2020-05-03 10:21:02'),
(4, '7584061326', '123456', 1, '2020-05-04 03:45:15', '2020-05-04 12:18:40'),
(5, '7584061326', '12345', 1, '2020-05-04 03:47:05', '2020-05-06 14:48:15'),
(6, '7584061326', '12345', 1, '2020-05-04 10:53:24', '2020-05-06 14:48:15'),
(7, '7584061326', '12345', 1, '2020-05-04 11:58:56', '2020-05-06 14:48:15'),
(8, '7584061326', '12345', 1, '2020-05-04 12:00:16', '2020-05-06 14:48:15'),
(9, '7584061326', '12345', 1, '2020-05-04 12:03:20', '2020-05-06 14:48:15'),
(10, '7584061326', '12345', 1, '2020-05-04 12:33:35', '2020-05-06 14:48:15'),
(11, '7584061326', '12345', 1, '2020-05-04 12:37:34', '2020-05-06 14:48:15'),
(12, '7584061326', '12345', 1, '2020-05-04 12:40:28', '2020-05-06 14:48:15'),
(13, '7584061326', '12345', 1, '2020-05-04 12:45:36', '2020-05-06 14:48:15'),
(14, '7584061326', '12345', 1, '2020-05-04 12:48:03', '2020-05-06 14:48:15'),
(15, '7584061326', '12345', 1, '2020-05-04 12:48:12', '2020-05-06 14:48:15'),
(16, '7584061326', '12345', 1, '2020-05-04 12:50:34', '2020-05-06 14:48:15'),
(17, '7584061326', '12345', 1, '2020-05-04 13:08:04', '2020-05-06 14:48:15'),
(18, '7584061326', '12345', 1, '2020-05-04 13:09:14', '2020-05-06 14:48:15'),
(19, '7584061326', '12345', 1, '2020-05-04 13:19:21', '2020-05-06 14:48:15'),
(20, '7584061326', '12345', 1, '2020-05-04 13:32:06', '2020-05-06 14:48:15'),
(21, '7584061326', '12345', 1, '2020-05-04 13:54:25', '2020-05-06 14:48:15'),
(22, '7584061326', '12345', 1, '2020-05-04 13:55:01', '2020-05-06 14:48:15'),
(23, '7584061326', '12345', 1, '2020-05-05 11:04:51', '2020-05-06 14:48:15'),
(24, '7584061326', '12345', 1, '2020-05-05 11:05:41', '2020-05-06 14:48:15'),
(25, '7584061326', '12345', 1, '2020-05-05 11:15:50', '2020-05-06 14:48:15'),
(26, '7584061326', '12345', 1, '2020-05-05 11:19:15', '2020-05-06 14:48:15'),
(27, '7584061326', '12345', 1, '2020-05-05 11:22:12', '2020-05-06 14:48:15'),
(28, '7584061326', '12345', 1, '2020-05-05 12:17:10', '2020-05-06 14:48:15'),
(29, '7584061326', '12345', 1, '2020-05-05 12:19:03', '2020-05-06 14:48:15'),
(30, '7584061326', '12345', 1, '2020-05-05 23:16:21', '2020-05-06 14:48:15'),
(31, '7584061326', '12345', 1, '2020-05-05 23:46:40', '2020-05-06 14:48:15'),
(32, '7584061326', '12345', 1, '2020-05-06 13:29:33', '2020-05-06 14:48:15'),
(33, '7584061326', '12345', 1, '2020-05-06 13:43:50', '2020-05-06 14:48:15'),
(34, '7584061326', '12345', 1, '2020-05-06 14:48:08', '2020-05-06 14:48:15'),
(35, '9999999999', '12345', 1, '2020-05-07 13:01:58', '2020-11-06 07:38:25'),
(36, '9999999999', '12345', 1, '2020-05-07 13:11:00', '2020-11-06 07:38:25'),
(37, '9999999999', '12345', 1, '2020-05-08 01:30:05', '2020-11-06 07:38:25'),
(38, '9999999999', '12345', 1, '2020-05-09 00:41:16', '2020-11-06 07:38:25'),
(39, '9999999999', '12345', 1, '2020-05-09 02:16:14', '2020-11-06 07:38:25'),
(40, '9999999999', '12345', 1, '2020-05-09 02:56:27', '2020-11-06 07:38:25'),
(41, '9999999999', '12345', 1, '2020-05-09 07:30:41', '2020-11-06 07:38:25'),
(42, '9999999999', '12345', 1, '2020-05-09 07:38:14', '2020-11-06 07:38:25'),
(43, '9999999999', '12345', 1, '2020-05-09 09:41:21', '2020-11-06 07:38:25'),
(44, '9999999999', '12345', 1, '2020-05-09 11:30:31', '2020-11-06 07:38:25'),
(45, '9999999999', '12345', 1, '2020-05-09 11:58:10', '2020-11-06 07:38:25'),
(46, '9999999999', '12345', 1, '2020-05-09 12:02:08', '2020-11-06 07:38:25'),
(47, '9999999999', '12345', 1, '2020-05-09 12:08:27', '2020-11-06 07:38:25'),
(48, '9999999999', '12345', 1, '2020-05-09 12:20:23', '2020-11-06 07:38:25'),
(49, '9999999999', '12345', 1, '2020-05-09 13:14:04', '2020-11-06 07:38:25'),
(50, '9999999999', '12345', 1, '2020-05-09 13:20:27', '2020-11-06 07:38:25'),
(51, '9999999999', '12345', 1, '2020-05-09 13:23:12', '2020-11-06 07:38:25'),
(52, '8888888888', '12345', 1, '2020-05-09 13:33:08', '2020-11-06 07:35:51'),
(53, '9999999999', '12345', 1, '2020-05-09 14:33:50', '2020-11-06 07:38:25'),
(54, '8888888888', '12345', 1, '2020-05-09 14:40:39', '2020-11-06 07:35:51'),
(55, '9999999999', '12345', 1, '2020-05-09 16:08:03', '2020-11-06 07:38:25'),
(56, '9999999999', '12345', 1, '2020-05-09 16:24:26', '2020-11-06 07:38:25'),
(57, '9999999999', '12345', 1, '2020-05-09 16:25:14', '2020-11-06 07:38:25'),
(58, '9999999999', '12345', 1, '2020-05-11 00:12:16', '2020-11-06 07:38:25'),
(59, '9999999999', '12345', 1, '2020-05-11 00:45:03', '2020-11-06 07:38:25'),
(60, '9999999999', '12345', 1, '2020-05-11 01:40:13', '2020-11-06 07:38:25'),
(61, '9999999999', '12345', 1, '2020-05-11 01:50:27', '2020-11-06 07:38:25'),
(62, '9999999999', '12345', 1, '2020-05-11 01:53:28', '2020-11-06 07:38:25'),
(63, '9999999999', '12345', 1, '2020-05-11 07:46:37', '2020-11-06 07:38:25'),
(64, '9999999999', '12345', 1, '2020-05-11 15:57:35', '2020-11-06 07:38:25'),
(65, '9999999999', '12345', 1, '2020-05-11 15:58:10', '2020-11-06 07:38:25'),
(66, '9999999999', '12345', 1, '2020-05-11 15:58:36', '2020-11-06 07:38:25'),
(67, '9999999999', '12345', 1, '2020-05-11 15:59:16', '2020-11-06 07:38:25'),
(68, '9999999999', '12345', 1, '2020-05-11 16:01:56', '2020-11-06 07:38:25'),
(69, '9999999999', '12345', 1, '2020-05-11 18:14:58', '2020-11-06 07:38:25'),
(70, '9999999999', '12345', 1, '2020-05-12 04:12:28', '2020-11-06 07:38:25'),
(71, '9999999999', '12345', 1, '2020-05-12 04:13:04', '2020-11-06 07:38:25'),
(72, '9999999999', '12345', 1, '2020-05-12 04:13:33', '2020-11-06 07:38:25'),
(73, '9999999999', '12345', 1, '2020-05-12 04:15:41', '2020-11-06 07:38:25'),
(74, '9999999999', '12345', 1, '2020-05-12 04:17:14', '2020-11-06 07:38:25'),
(75, '9999999999', '12345', 1, '2020-05-12 04:18:55', '2020-11-06 07:38:25'),
(76, '9999999999', '12345', 1, '2020-05-12 04:46:45', '2020-11-06 07:38:25'),
(77, '9999999999', '12345', 1, '2020-05-12 05:01:36', '2020-11-06 07:38:25'),
(78, '9999999999', '12345', 1, '2020-05-12 05:01:59', '2020-11-06 07:38:25'),
(79, '9999999999', '12345', 1, '2020-05-12 05:05:44', '2020-11-06 07:38:25'),
(80, '9999999999', '12345', 1, '2020-05-12 05:10:16', '2020-11-06 07:38:25'),
(81, '9999999999', '12345', 1, '2020-05-13 06:30:36', '2020-11-06 07:38:25'),
(82, '9999999999', '12345', 1, '2020-05-13 06:40:44', '2020-11-06 07:38:25'),
(83, '9999999999', '12345', 1, '2020-05-13 06:42:02', '2020-11-06 07:38:25'),
(84, '9999999999', '12345', 1, '2020-05-13 11:24:17', '2020-11-06 07:38:25'),
(85, '9999999999', '12345', 1, '2020-05-13 12:15:06', '2020-11-06 07:38:25'),
(86, '9999999999', '12345', 1, '2020-05-13 12:49:46', '2020-11-06 07:38:25'),
(87, '9999999999', '12345', 1, '2020-05-13 14:44:19', '2020-11-06 07:38:25'),
(88, '9999999999', '12345', 1, '2020-05-13 14:59:31', '2020-11-06 07:38:25'),
(89, '9999999999', '12345', 1, '2020-05-17 15:36:46', '2020-11-06 07:38:25'),
(90, '9999999999', '12345', 1, '2020-05-17 15:46:00', '2020-11-06 07:38:25'),
(91, '9999999999', '12345', 1, '2020-05-17 16:57:35', '2020-11-06 07:38:25'),
(92, '9999999999', '12345', 1, '2020-06-10 04:43:00', '2020-11-06 07:38:25'),
(93, '9999999999', '12345', 1, '2020-06-10 05:02:18', '2020-11-06 07:38:25'),
(94, '6788787878', '12345', 1, '2020-08-27 08:25:24', '2020-08-28 00:33:17'),
(95, '6788787878', '12345', 1, '2020-08-27 23:39:55', '2020-08-28 00:33:17'),
(96, '6788787878', '12345', 1, '2020-08-28 00:26:21', '2020-08-28 00:33:17'),
(97, '6788787878', '12345', 1, '2020-08-28 00:32:55', '2020-08-28 00:33:17'),
(98, '9999999999', '12345', 1, '2020-08-28 01:57:38', '2020-11-06 07:38:25'),
(99, '9999999999', '12345', 1, '2020-09-22 01:04:28', '2020-11-06 07:38:25'),
(100, '9999999990', '12345', 1, '2020-09-22 01:16:09', '2020-10-22 00:39:21'),
(101, '9999999999', '12345', 1, '2020-09-24 07:19:32', '2020-11-06 07:38:25'),
(102, '9999999990', '12345', 1, '2020-09-24 07:19:43', '2020-10-22 00:39:21'),
(103, '9999999990', '12345', 1, '2020-09-24 07:34:42', '2020-10-22 00:39:21'),
(104, '9999999990', '12345', 1, '2020-09-24 07:36:49', '2020-10-22 00:39:21'),
(105, '9999999990', '12345', 1, '2020-09-27 20:29:29', '2020-10-22 00:39:21'),
(106, '9999999999', '12345', 1, '2020-10-02 07:16:43', '2020-11-06 07:38:25'),
(107, '9999999990', '12345', 1, '2020-10-02 07:18:53', '2020-10-22 00:39:21'),
(108, '9999999999', '12345', 1, '2020-10-03 02:24:16', '2020-11-06 07:38:25'),
(109, '9999999990', '12345', 1, '2020-10-03 23:51:24', '2020-10-22 00:39:21'),
(110, '9999999990', '12345', 1, '2020-10-04 02:34:34', '2020-10-22 00:39:21'),
(111, '9999999990', '12345', 1, '2020-10-05 02:08:35', '2020-10-22 00:39:21'),
(112, '9999999990', '12345', 1, '2020-10-22 00:38:53', '2020-10-22 00:39:21'),
(113, '9999999999', '12345', 1, '2020-11-06 07:34:49', '2020-11-06 07:38:25'),
(114, '8888888888', '12345', 1, '2020-11-06 07:35:45', '2020-11-06 07:35:51'),
(115, '9999999999', '12345', 1, '2020-11-06 07:38:20', '2020-11-06 07:38:25');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ptax`
--

CREATE TABLE `tbl_ptax` (
  `code` int(11) NOT NULL,
  `from_amt` int(11) NOT NULL,
  `to_amt` int(11) NOT NULL,
  `amt` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_ptax`
--

INSERT INTO `tbl_ptax` (`code`, `from_amt`, `to_amt`, `amt`, `created_at`, `updated_at`) VALUES
(1, 10001, 15000, 110, '2020-10-16 07:17:50', '2020-10-16 07:17:50'),
(2, 15001, 25000, 130, '2020-10-16 07:17:50', '2020-10-16 07:17:50'),
(3, 25001, 40000, 150, '2020-10-16 07:18:11', '2020-10-16 07:18:11'),
(4, 40001, 10000000, 200, '2020-10-16 07:18:44', '2020-10-16 07:18:44');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_shift`
--

CREATE TABLE `tbl_shift` (
  `code` int(11) NOT NULL,
  `shift` varchar(200) NOT NULL,
  `shift_in_time` time NOT NULL,
  `shift_out_time` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_shift`
--

INSERT INTO `tbl_shift` (`code`, `shift`, `shift_in_time`, `shift_out_time`, `created_at`, `updated_at`) VALUES
(1, 'Monning Shift', '08:00:00', '12:00:00', '2020-10-20 08:00:46', '2020-10-20 08:00:46'),
(2, 'Day Shift', '12:00:00', '18:00:00', '2020-10-20 08:02:52', '2020-10-20 08:02:52'),
(3, 'Evening Shift', '18:00:00', '23:00:00', '2020-10-20 08:03:52', '2020-10-20 08:03:52');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supervisor_wise_worker`
--

CREATE TABLE `tbl_supervisor_wise_worker` (
  `code` int(11) NOT NULL,
  `supervisor_code` int(11) NOT NULL,
  `worker_code` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_supervisor_wise_worker`
--

INSERT INTO `tbl_supervisor_wise_worker` (`code`, `supervisor_code`, `worker_code`, `created_at`, `updated_at`) VALUES
(1, 1, 2, NULL, NULL),
(2, 1, 3, NULL, NULL),
(3, 8, 4, NULL, NULL),
(4, 8, 5, NULL, NULL),
(5, 8, 6, NULL, NULL),
(6, 8, 7, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_type_of_leave`
--

CREATE TABLE `tbl_type_of_leave` (
  `code` int(11) NOT NULL,
  `type_of_leave` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_type_of_leave`
--

INSERT INTO `tbl_type_of_leave` (`code`, `type_of_leave`, `created_at`, `updated_at`) VALUES
(1, 'Casual Leave', '2020-10-09 07:13:30', '2020-10-09 07:13:30'),
(2, 'Sick leave', '2020-10-09 07:13:30', '2020-10-09 07:13:30'),
(3, 'Maternity Leave', '2020-10-09 07:14:21', '2020-10-09 07:14:21'),
(4, 'Paternity Leave', '2020-10-09 07:14:21', '2020-10-09 07:14:21'),
(5, 'Earn Leave', '2020-10-09 07:14:57', '2020-10-09 07:14:57');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_years`
--

CREATE TABLE `tbl_years` (
  `code` int(11) NOT NULL,
  `year` varchar(50) NOT NULL,
  `starting_date` varchar(50) NOT NULL,
  `end_date` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_years`
--

INSERT INTO `tbl_years` (`code`, `year`, `starting_date`, `end_date`, `created_at`, `updated_at`) VALUES
(1, '2020', '01/01/2020', '31/12/2020', '2020-10-09 07:49:42', '2020-10-09 07:49:42'),
(2, '2021', '01/01/2021', '31/12/2021', '2020-10-09 07:49:59', '2020-10-09 07:49:59'),
(3, '2022', '01/01/2022', '31/12/2022', '2020-10-09 07:50:11', '2020-10-09 07:50:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`(191));

--
-- Indexes for table `tbl_allowance`
--
ALTER TABLE `tbl_allowance`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `tbl_attendance_entry`
--
ALTER TABLE `tbl_attendance_entry`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `tbl_department`
--
ALTER TABLE `tbl_department`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `tbl_designation`
--
ALTER TABLE `tbl_designation`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `tbl_designation_wise_allowance`
--
ALTER TABLE `tbl_designation_wise_allowance`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `tbl_designation_wise_leave_assign`
--
ALTER TABLE `tbl_designation_wise_leave_assign`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `tbl_employee_allowance_entry`
--
ALTER TABLE `tbl_employee_allowance_entry`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `tbl_employee_details`
--
ALTER TABLE `tbl_employee_details`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `tbl_employee_leave_taken`
--
ALTER TABLE `tbl_employee_leave_taken`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `tbl_employee_salary_generation`
--
ALTER TABLE `tbl_employee_salary_generation`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `tbl_employee_wise_shift_allocation`
--
ALTER TABLE `tbl_employee_wise_shift_allocation`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `tbl_mobile_user`
--
ALTER TABLE `tbl_mobile_user`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `tbl_month_year_designation_salary_generation`
--
ALTER TABLE `tbl_month_year_designation_salary_generation`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `tbl_of_holiday`
--
ALTER TABLE `tbl_of_holiday`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `tbl_otp_verified`
--
ALTER TABLE `tbl_otp_verified`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `tbl_ptax`
--
ALTER TABLE `tbl_ptax`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `tbl_shift`
--
ALTER TABLE `tbl_shift`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `tbl_supervisor_wise_worker`
--
ALTER TABLE `tbl_supervisor_wise_worker`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `tbl_type_of_leave`
--
ALTER TABLE `tbl_type_of_leave`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `tbl_years`
--
ALTER TABLE `tbl_years`
  ADD PRIMARY KEY (`code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_allowance`
--
ALTER TABLE `tbl_allowance`
  MODIFY `code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_attendance_entry`
--
ALTER TABLE `tbl_attendance_entry`
  MODIFY `code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_department`
--
ALTER TABLE `tbl_department`
  MODIFY `code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_designation`
--
ALTER TABLE `tbl_designation`
  MODIFY `code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_designation_wise_allowance`
--
ALTER TABLE `tbl_designation_wise_allowance`
  MODIFY `code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tbl_designation_wise_leave_assign`
--
ALTER TABLE `tbl_designation_wise_leave_assign`
  MODIFY `code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tbl_employee_allowance_entry`
--
ALTER TABLE `tbl_employee_allowance_entry`
  MODIFY `code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tbl_employee_details`
--
ALTER TABLE `tbl_employee_details`
  MODIFY `code` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_employee_leave_taken`
--
ALTER TABLE `tbl_employee_leave_taken`
  MODIFY `code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_employee_salary_generation`
--
ALTER TABLE `tbl_employee_salary_generation`
  MODIFY `code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_employee_wise_shift_allocation`
--
ALTER TABLE `tbl_employee_wise_shift_allocation`
  MODIFY `code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_mobile_user`
--
ALTER TABLE `tbl_mobile_user`
  MODIFY `code` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_month_year_designation_salary_generation`
--
ALTER TABLE `tbl_month_year_designation_salary_generation`
  MODIFY `code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_of_holiday`
--
ALTER TABLE `tbl_of_holiday`
  MODIFY `code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_otp_verified`
--
ALTER TABLE `tbl_otp_verified`
  MODIFY `code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `tbl_ptax`
--
ALTER TABLE `tbl_ptax`
  MODIFY `code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_shift`
--
ALTER TABLE `tbl_shift`
  MODIFY `code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_supervisor_wise_worker`
--
ALTER TABLE `tbl_supervisor_wise_worker`
  MODIFY `code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_type_of_leave`
--
ALTER TABLE `tbl_type_of_leave`
  MODIFY `code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_years`
--
ALTER TABLE `tbl_years`
  MODIFY `code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
