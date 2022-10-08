-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2022 at 04:50 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `weshare`
--

-- --------------------------------------------------------

--
-- Table structure for table `adjust_product_wallets`
--

CREATE TABLE `adjust_product_wallets` (
  `id` int(11) NOT NULL,
  `user_id` varchar(191) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(191) CHARACTER SET utf8 DEFAULT NULL,
  `updated_by` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_code` int(11) DEFAULT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `f_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `l_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `youtube` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_hidden` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website_logo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_hidden` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website_name` varchar(191) CHARACTER SET utf8 DEFAULT NULL,
  `lvl` int(11) DEFAULT NULL,
  `permission_lvl` int(11) DEFAULT NULL,
  `profile_logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bg_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `remember_token` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `country_code`, `code`, `email`, `password`, `f_name`, `l_name`, `gender`, `dob`, `phone`, `contact_email`, `facebook`, `twitter`, `youtube`, `google`, `instagram`, `logo_hidden`, `website_logo`, `name_hidden`, `website_name`, `lvl`, `permission_lvl`, `profile_logo`, `bg_image`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, 'AD000001', 'admin@weshare.com', '$2y$10$PDGeEQBuuH/CxVjt6P1YeOy9f.ZA6Z84KFfkfpgf.fG6QvQYUWYJG', 'Admin', 'Dietary', 'Male', '06/13/2022', '+60174097028', 'support@dietary.com', 'https://www.facebook.com/', 'https://www.twitter.com/', 'https://www.youtube.com/', 'https://www.google.com/', 'https://www.instagram.com/', '1', 'uploads/logo/b9c910a92f8c1e653c9f26652b0ad823.jpg', '0', 'Dietary Website Backend', 2, 1, 'uploads/profile_logo/9a424c8492f3b0802af1d15f049d73e8.jpg', 'uploads/bg_image/fab6a0a5faa53a022e25d69887c17f45.png', 1, 'NHJB2tHx5G8zylFxVwTFjv3HhoyjggPhbPd0tmHdUX9SzJ2gaXwIOXknNIsZ', '2019-11-26 07:24:56', '2022-07-04 14:27:52');

-- --------------------------------------------------------

--
-- Table structure for table `affiliates`
--

CREATE TABLE `affiliates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `affiliate_id` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_level` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `affiliates`
--

INSERT INTO `affiliates` (`id`, `affiliate_id`, `user_id`, `sort_level`, `status`, `created_at`, `updated_at`) VALUES
(1, 'M000002', 'AD000001', '1', 1, '2020-12-04 05:17:16', '2020-12-04 05:17:16'),
(2, 'M000001', 'AD000001', '1', 1, '2020-12-04 05:20:24', '2020-12-04 05:20:24'),
(3, 'M000003', 'AD000001', '1', 1, '2020-12-17 01:27:00', '2020-12-17 01:27:00'),
(4, 'M000004', 'M000003', '1', 1, '2020-12-17 04:56:25', '2020-12-17 04:56:25'),
(5, 'M000004', 'AD000001', '2', 1, '2020-12-17 04:56:25', '2020-12-17 04:56:25'),
(6, 'M000005', 'M000003', '1', 1, '2020-12-17 05:06:53', '2020-12-17 05:06:53'),
(7, 'M000005', 'AD000001', '2', 1, '2020-12-17 05:06:53', '2020-12-17 05:06:53'),
(8, 'M000006', 'M000004', '1', 1, '2020-12-17 05:10:49', '2020-12-17 05:10:49'),
(9, 'M000006', 'M000003', '2', 1, '2020-12-17 05:10:49', '2020-12-17 05:10:49'),
(10, 'M000006', 'AD000001', '3', 1, '2020-12-17 05:10:49', '2020-12-17 05:10:49'),
(11, 'M000007', 'AD000001', '1', 1, '2020-12-23 02:23:13', '2020-12-23 02:23:13'),
(12, 'M000008', 'M000007', '1', 1, '2020-12-23 02:29:15', '2020-12-23 02:29:15'),
(13, 'M000008', 'AD000001', '2', 1, '2020-12-23 02:29:15', '2020-12-23 02:29:15'),
(14, 'M000009', 'M000008', '1', 1, '2020-12-23 02:32:31', '2020-12-23 02:32:31'),
(15, 'M000009', 'M000007', '2', 1, '2020-12-23 02:32:31', '2020-12-23 02:32:31'),
(16, 'M000009', 'AD000001', '3', 1, '2020-12-23 02:32:31', '2020-12-23 02:32:31'),
(17, 'M000010', 'M000008', '1', 1, '2020-12-23 02:33:36', '2020-12-23 02:33:36'),
(18, 'M000010', 'M000007', '2', 1, '2020-12-23 02:33:36', '2020-12-23 02:33:36'),
(19, 'M000010', 'AD000001', '3', 1, '2020-12-23 02:33:36', '2020-12-23 02:33:36'),
(20, 'M000011', 'M000009', '1', 1, '2020-12-23 02:35:12', '2020-12-23 02:35:12'),
(21, 'M000011', 'M000008', '2', 1, '2020-12-23 02:35:12', '2020-12-23 02:35:12'),
(22, 'M000011', 'M000007', '3', 1, '2020-12-23 02:35:12', '2020-12-23 02:35:12'),
(23, 'M000011', 'AD000001', '4', 1, '2020-12-23 02:35:12', '2020-12-23 02:35:12'),
(24, 'M000012', 'M000009', '1', 1, '2020-12-23 02:36:32', '2020-12-23 02:36:32'),
(25, 'M000012', 'M000008', '2', 1, '2020-12-23 02:36:33', '2020-12-23 02:36:33'),
(26, 'M000012', 'M000007', '3', 1, '2020-12-23 02:36:33', '2020-12-23 02:36:33'),
(27, 'M000012', 'AD000001', '4', 1, '2020-12-23 02:36:33', '2020-12-23 02:36:33'),
(28, 'M000013', 'M000010', '1', 1, '2020-12-23 02:37:57', '2020-12-23 02:37:57'),
(29, 'M000013', 'M000008', '2', 1, '2020-12-23 02:37:57', '2020-12-23 02:37:57'),
(30, 'M000013', 'M000007', '3', 1, '2020-12-23 02:37:57', '2020-12-23 02:37:57'),
(31, 'M000013', 'AD000001', '4', 1, '2020-12-23 02:37:57', '2020-12-23 02:37:57'),
(32, 'M000014', 'M000010', '1', 1, '2020-12-23 02:41:47', '2020-12-23 02:41:47'),
(33, 'M000014', 'M000008', '2', 1, '2020-12-23 02:41:47', '2020-12-23 02:41:47'),
(34, 'M000014', 'M000007', '3', 1, '2020-12-23 02:41:47', '2020-12-23 02:41:47'),
(35, 'M000014', 'AD000001', '4', 1, '2020-12-23 02:41:47', '2020-12-23 02:41:47'),
(36, 'M000015', 'M000009', '1', 1, '2020-12-23 02:46:50', '2020-12-23 02:46:50'),
(37, 'M000015', 'M000008', '2', 1, '2020-12-23 02:46:50', '2020-12-23 02:46:50'),
(38, 'M000015', 'M000007', '3', 1, '2020-12-23 02:46:50', '2020-12-23 02:46:50'),
(39, 'M000015', 'AD000001', '4', 1, '2020-12-23 02:46:50', '2020-12-23 02:46:50'),
(40, 'M000016', 'M000015', '1', 1, '2020-12-23 02:48:07', '2020-12-23 02:48:07'),
(41, 'M000016', 'M000009', '2', 1, '2020-12-23 02:48:07', '2020-12-23 02:48:07'),
(42, 'M000016', 'M000008', '3', 1, '2020-12-23 02:48:07', '2020-12-23 02:48:07'),
(43, 'M000016', 'M000007', '4', 1, '2020-12-23 02:48:07', '2020-12-23 02:48:07'),
(44, 'M000016', 'AD000001', '5', 1, '2020-12-23 02:48:07', '2020-12-23 02:48:07'),
(45, 'M000017', 'M000016', '1', 1, '2020-12-23 02:49:03', '2020-12-23 02:49:03'),
(46, 'M000017', 'M000015', '2', 1, '2020-12-23 02:49:03', '2020-12-23 02:49:03'),
(47, 'M000017', 'M000009', '3', 1, '2020-12-23 02:49:03', '2020-12-23 02:49:03'),
(48, 'M000017', 'M000008', '4', 1, '2020-12-23 02:49:03', '2020-12-23 02:49:03'),
(49, 'M000017', 'M000007', '5', 1, '2020-12-23 02:49:03', '2020-12-23 02:49:03'),
(50, 'M000017', 'AD000001', '6', 1, '2020-12-23 02:49:03', '2020-12-23 02:49:03'),
(51, 'M000018', 'M000017', '1', 1, '2020-12-23 02:50:37', '2020-12-23 02:50:37'),
(52, 'M000018', 'M000016', '2', 1, '2020-12-23 02:50:37', '2020-12-23 02:50:37'),
(53, 'M000018', 'M000015', '3', 1, '2020-12-23 02:50:37', '2020-12-23 02:50:37'),
(54, 'M000018', 'M000009', '4', 1, '2020-12-23 02:50:37', '2020-12-23 02:50:37'),
(55, 'M000018', 'M000008', '5', 1, '2020-12-23 02:50:37', '2020-12-23 02:50:37'),
(56, 'M000018', 'M000007', '6', 1, '2020-12-23 02:50:37', '2020-12-23 02:50:37'),
(57, 'M000018', 'AD000001', '7', 1, '2020-12-23 02:50:37', '2020-12-23 02:50:37'),
(58, 'M000019', 'M000018', '1', 1, '2020-12-23 02:51:28', '2020-12-23 02:51:28'),
(59, 'M000019', 'M000017', '2', 1, '2020-12-23 02:51:28', '2020-12-23 02:51:28'),
(60, 'M000019', 'M000016', '3', 1, '2020-12-23 02:51:28', '2020-12-23 02:51:28'),
(61, 'M000019', 'M000015', '4', 1, '2020-12-23 02:51:28', '2020-12-23 02:51:28'),
(62, 'M000019', 'M000009', '5', 1, '2020-12-23 02:51:28', '2020-12-23 02:51:28'),
(63, 'M000019', 'M000008', '6', 1, '2020-12-23 02:51:28', '2020-12-23 02:51:28'),
(64, 'M000019', 'M000007', '7', 1, '2020-12-23 02:51:28', '2020-12-23 02:51:28'),
(65, 'M000019', 'AD000001', '8', 1, '2020-12-23 02:51:28', '2020-12-23 02:51:28'),
(66, 'M000020', 'M000019', '1', 1, '2020-12-23 02:52:52', '2020-12-23 02:52:52'),
(67, 'M000020', 'M000018', '2', 1, '2020-12-23 02:52:52', '2020-12-23 02:52:52'),
(68, 'M000020', 'M000017', '3', 1, '2020-12-23 02:52:52', '2020-12-23 02:52:52'),
(69, 'M000020', 'M000016', '4', 1, '2020-12-23 02:52:52', '2020-12-23 02:52:52'),
(70, 'M000020', 'M000015', '5', 1, '2020-12-23 02:52:52', '2020-12-23 02:52:52'),
(71, 'M000020', 'M000009', '6', 1, '2020-12-23 02:52:52', '2020-12-23 02:52:52'),
(72, 'M000020', 'M000008', '7', 1, '2020-12-23 02:52:52', '2020-12-23 02:52:52'),
(73, 'M000020', 'M000007', '8', 1, '2020-12-23 02:52:52', '2020-12-23 02:52:52'),
(74, 'M000020', 'AD000001', '9', 1, '2020-12-23 02:52:52', '2020-12-23 02:52:52'),
(75, 'M000021', 'M000020', '1', 1, '2020-12-23 02:54:06', '2020-12-23 02:54:06'),
(76, 'M000021', 'M000019', '2', 1, '2020-12-23 02:54:06', '2020-12-23 02:54:06'),
(77, 'M000021', 'M000018', '3', 1, '2020-12-23 02:54:06', '2020-12-23 02:54:06'),
(78, 'M000021', 'M000017', '4', 1, '2020-12-23 02:54:06', '2020-12-23 02:54:06'),
(79, 'M000021', 'M000016', '5', 1, '2020-12-23 02:54:06', '2020-12-23 02:54:06'),
(80, 'M000021', 'M000015', '6', 1, '2020-12-23 02:54:06', '2020-12-23 02:54:06'),
(81, 'M000021', 'M000009', '7', 1, '2020-12-23 02:54:06', '2020-12-23 02:54:06'),
(82, 'M000021', 'M000008', '8', 1, '2020-12-23 02:54:06', '2020-12-23 02:54:06'),
(83, 'M000021', 'M000007', '9', 1, '2020-12-23 02:54:06', '2020-12-23 02:54:06'),
(84, 'M000021', 'AD000001', '10', 1, '2020-12-23 02:54:06', '2020-12-23 02:54:06'),
(85, 'M000022', 'M000021', '1', 1, '2020-12-23 02:55:11', '2020-12-23 02:55:11'),
(86, 'M000022', 'M000020', '2', 1, '2020-12-23 02:55:11', '2020-12-23 02:55:11'),
(87, 'M000022', 'M000019', '3', 1, '2020-12-23 02:55:11', '2020-12-23 02:55:11'),
(88, 'M000022', 'M000018', '4', 1, '2020-12-23 02:55:11', '2020-12-23 02:55:11'),
(89, 'M000022', 'M000017', '5', 1, '2020-12-23 02:55:11', '2020-12-23 02:55:11'),
(90, 'M000022', 'M000016', '6', 1, '2020-12-23 02:55:11', '2020-12-23 02:55:11'),
(91, 'M000022', 'M000015', '7', 1, '2020-12-23 02:55:11', '2020-12-23 02:55:11'),
(92, 'M000022', 'M000009', '8', 1, '2020-12-23 02:55:11', '2020-12-23 02:55:11'),
(93, 'M000022', 'M000008', '9', 1, '2020-12-23 02:55:11', '2020-12-23 02:55:11'),
(94, 'M000022', 'M000007', '10', 1, '2020-12-23 02:55:11', '2020-12-23 02:55:11'),
(95, 'M000022', 'AD000001', '11', 1, '2020-12-23 02:55:11', '2020-12-23 02:55:11'),
(96, 'M000023', 'M000022', '1', 1, '2020-12-23 02:57:06', '2020-12-23 02:57:06'),
(97, 'M000023', 'M000021', '2', 1, '2020-12-23 02:57:07', '2020-12-23 02:57:07'),
(98, 'M000023', 'M000020', '3', 1, '2020-12-23 02:57:07', '2020-12-23 02:57:07'),
(99, 'M000023', 'M000019', '4', 1, '2020-12-23 02:57:07', '2020-12-23 02:57:07'),
(100, 'M000023', 'M000018', '5', 1, '2020-12-23 02:57:07', '2020-12-23 02:57:07'),
(101, 'M000023', 'M000017', '6', 1, '2020-12-23 02:57:07', '2020-12-23 02:57:07'),
(102, 'M000023', 'M000016', '7', 1, '2020-12-23 02:57:07', '2020-12-23 02:57:07'),
(103, 'M000023', 'M000015', '8', 1, '2020-12-23 02:57:07', '2020-12-23 02:57:07'),
(104, 'M000023', 'M000009', '9', 1, '2020-12-23 02:57:07', '2020-12-23 02:57:07'),
(105, 'M000023', 'M000008', '10', 1, '2020-12-23 02:57:07', '2020-12-23 02:57:07'),
(106, 'M000023', 'M000007', '11', 1, '2020-12-23 02:57:07', '2020-12-23 02:57:07'),
(107, 'M000023', 'AD000001', '12', 1, '2020-12-23 02:57:07', '2020-12-23 02:57:07'),
(108, 'M000024', 'M000022', '1', 1, '2020-12-23 03:01:10', '2020-12-23 03:01:10'),
(109, 'M000024', 'M000021', '2', 1, '2020-12-23 03:01:10', '2020-12-23 03:01:10'),
(110, 'M000024', 'M000020', '3', 1, '2020-12-23 03:01:10', '2020-12-23 03:01:10'),
(111, 'M000024', 'M000019', '4', 1, '2020-12-23 03:01:10', '2020-12-23 03:01:10'),
(112, 'M000024', 'M000018', '5', 1, '2020-12-23 03:01:10', '2020-12-23 03:01:10'),
(113, 'M000024', 'M000017', '6', 1, '2020-12-23 03:01:10', '2020-12-23 03:01:10'),
(114, 'M000024', 'M000016', '7', 1, '2020-12-23 03:01:10', '2020-12-23 03:01:10'),
(115, 'M000024', 'M000015', '8', 1, '2020-12-23 03:01:10', '2020-12-23 03:01:10'),
(116, 'M000024', 'M000009', '9', 1, '2020-12-23 03:01:10', '2020-12-23 03:01:10'),
(117, 'M000024', 'M000008', '10', 1, '2020-12-23 03:01:10', '2020-12-23 03:01:10'),
(118, 'M000024', 'M000007', '11', 1, '2020-12-23 03:01:10', '2020-12-23 03:01:10'),
(119, 'M000024', 'AD000001', '12', 1, '2020-12-23 03:01:10', '2020-12-23 03:01:10');

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_commissions`
--

CREATE TABLE `affiliate_commissions` (
  `id` int(11) NOT NULL,
  `type` int(11) DEFAULT NULL,
  `user_id` varchar(191) NOT NULL,
  `transaction_no` varchar(191) DEFAULT NULL,
  `product_name` varchar(191) CHARACTER SET utf8 DEFAULT NULL,
  `product_qty` varchar(191) DEFAULT NULL,
  `product_amount` double DEFAULT NULL,
  `comm_pa_type` varchar(15) DEFAULT NULL,
  `comm_pa` double DEFAULT NULL,
  `comm_amount` double NOT NULL,
  `comm_desc` varchar(191) NOT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `affiliate_commissions`
--

INSERT INTO `affiliate_commissions` (`id`, `type`, `user_id`, `transaction_no`, `product_name`, `product_qty`, `product_amount`, `comm_pa_type`, `comm_pa`, `comm_amount`, `comm_desc`, `status`, `created_at`, `updated_at`) VALUES
(1, 10, 'M000003', '160816860900001', NULL, NULL, 48, 'Percentage', 6, 45.12, 'Payment From Transaction No. #160816860900001', 1, '2020-12-17 05:50:51', '2020-12-17 05:50:51'),
(2, 8, 'M000019', NULL, NULL, NULL, 2000, 'Percentage', 25, 500, 'Cash Rebate From #M000019', 99, '2021-01-11 07:29:10', '2021-01-11 07:29:10'),
(3, 8, 'M000021', NULL, NULL, NULL, 4000, 'Percentage', 20, 800, 'Cash Rebate From #M000021', 99, '2021-01-11 07:29:10', '2021-01-11 07:29:10'),
(4, 8, 'M000020', NULL, NULL, NULL, 4000, 'Percentage', 5, 200, 'Cash Rebate From #M000021', 99, '2021-01-11 07:29:10', '2021-01-11 07:29:10'),
(5, 8, 'M000022', NULL, NULL, NULL, 2000, 'Percentage', 20, 400, 'Cash Rebate From #M000022', 99, '2021-01-11 07:29:10', '2021-01-11 07:29:10'),
(6, 8, 'M000020', NULL, NULL, NULL, 2000, 'Percentage', 5, 100, 'Cash Rebate From #M000022', 99, '2021-01-11 07:29:10', '2021-01-11 07:29:10'),
(7, 8, 'M000023', NULL, NULL, NULL, 2000, 'Percentage', 10, 200, 'Cash Rebate From #M000023', 99, '2021-01-11 07:29:10', '2021-01-11 07:29:10'),
(8, 8, 'M000022', NULL, NULL, NULL, 2000, 'Percentage', 10, 200, 'Cash Rebate From #M000023', 99, '2021-01-11 07:29:10', '2021-01-11 07:29:10'),
(9, 8, 'M000020', NULL, NULL, NULL, 2000, 'Percentage', 5, 100, 'Cash Rebate From #M000023', 99, '2021-01-11 07:29:10', '2021-01-11 07:29:10'),
(10, 8, 'M000024', NULL, NULL, NULL, 2000, 'Percentage', 10, 200, 'Cash Rebate From #M000024', 99, '2021-01-11 07:29:10', '2021-01-11 07:29:10'),
(11, 8, 'M000022', NULL, NULL, NULL, 2000, 'Percentage', 10, 200, 'Cash Rebate From #M000024', 99, '2021-01-11 07:29:10', '2021-01-11 07:29:10'),
(12, 8, 'M000020', NULL, NULL, NULL, 2000, 'Percentage', 5, 100, 'Cash Rebate From #M000024', 99, '2021-01-11 07:29:10', '2021-01-11 07:29:10'),
(13, 8, 'M000021', NULL, NULL, NULL, 4000, 'Percentage', 20, 800, 'Cash Rebate From #M000021', 99, '2021-01-11 07:29:32', '2021-01-11 07:29:32'),
(14, 8, 'M000022', NULL, NULL, NULL, 2000, 'Percentage', 20, 400, 'Cash Rebate From #M000022', 99, '2021-01-11 07:29:32', '2021-01-11 07:29:32'),
(15, 8, 'M000023', NULL, NULL, NULL, 2000, 'Percentage', 10, 200, 'Cash Rebate From #M000023', 99, '2021-01-11 07:29:32', '2021-01-11 07:29:32'),
(16, 8, 'M000022', NULL, NULL, NULL, 2000, 'Percentage', 10, 200, 'Cash Rebate From #M000023', 99, '2021-01-11 07:29:32', '2021-01-11 07:29:32'),
(17, 8, 'M000024', NULL, NULL, NULL, 2000, 'Percentage', 10, 200, 'Cash Rebate From #M000024', 99, '2021-01-11 07:29:32', '2021-01-11 07:29:32'),
(18, 8, 'M000022', NULL, NULL, NULL, 2000, 'Percentage', 10, 200, 'Cash Rebate From #M000024', 99, '2021-01-11 07:29:32', '2021-01-11 07:29:32');

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_duals`
--

CREATE TABLE `affiliate_duals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `affiliate_id` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `agent_levels`
--

CREATE TABLE `agent_levels` (
  `id` int(11) NOT NULL,
  `agent_lvl` varchar(191) CHARACTER SET utf8 DEFAULT NULL,
  `product_id` varchar(191) DEFAULT NULL,
  `buy_quantity` double DEFAULT NULL,
  `affiliate_quantity` double DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `agent_levels`
--

INSERT INTO `agent_levels` (`id`, `agent_lvl`, `product_id`, `buy_quantity`, `affiliate_quantity`, `status`, `created_at`, `updated_at`) VALUES
(1, 'AP', '', 1000, 0, 1, NULL, NULL),
(2, 'AP Executive', '', 5000, 0, 1, NULL, NULL),
(3, 'AP Manager', '', 20000, 0, 1, NULL, NULL),
(4, 'AP Director', '', 100000, 0, 1, NULL, NULL),
(5, 'AP Executive Director', '', 400000, 0, 1, NULL, NULL),
(6, 'AP Presidential Council', NULL, 800000, NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `agent_rebate_histories`
--

CREATE TABLE `agent_rebate_histories` (
  `id` int(11) NOT NULL,
  `user_id` varchar(191) DEFAULT NULL,
  `commision_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `applied_promotions`
--

CREATE TABLE `applied_promotions` (
  `id` int(11) NOT NULL,
  `promotion_id` int(11) DEFAULT NULL,
  `user_id` varchar(191) DEFAULT NULL,
  `transaction_id` varchar(191) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 99,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bank_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_holder_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`id`, `bank_name`, `bank_code`, `bank_holder_name`, `bank_account`, `status`, `created_at`, `updated_at`) VALUES
(1, 'MAYBANK', '10001021', 'Vesson Web Design', '2151651651', 1, '2019-11-26 07:24:56', NULL),
(2, 'CIMB', '10001019', 'Vesson Web Design', '5136151549841251', 1, '2019-11-26 07:24:56', NULL),
(3, 'Public Bank', '10001020', 'Vesson Web Design', '213515484631418', 1, '2019-11-26 07:24:56', NULL),
(4, 'RHB', '10001023', 'Vesson Web Design', '846245874123484', 1, '2019-11-26 07:24:56', NULL),
(5, 'Hong Leong', '10001022', 'Vesson Web Design', '23400011160', 1, '2019-11-26 07:24:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bank_accounts`
--

CREATE TABLE `bank_accounts` (
  `id` int(11) NOT NULL,
  `user_id` varchar(191) DEFAULT NULL,
  `bank_name` varchar(10) DEFAULT NULL,
  `bank_holder_name` varchar(191) DEFAULT NULL,
  `bank_account` varchar(191) DEFAULT NULL,
  `default_banks` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bank_accounts`
--

INSERT INTO `bank_accounts` (`id`, `user_id`, `bank_name`, `bank_holder_name`, `bank_account`, `default_banks`, `status`, `created_at`, `updated_at`) VALUES
(1, 'M000003', 'Maybank', '2342342', '32423412542345', 1, 1, '2020-12-17 05:51:25', '2020-12-17 05:51:25'),
(2, 'AD000001', 'Maybank', 'ddd', '343434', 1, 1, '2021-12-11 17:48:21', '2021-12-11 17:48:21'),
(3, 'AD000001', 'Maybank', 'ddd', '343434', NULL, 1, '2022-06-18 04:08:26', '2022-06-18 04:08:26');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `image` varchar(191) DEFAULT NULL,
  `title` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `blog_date` date DEFAULT NULL,
  `blog_tags` varchar(191) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `image`, `title`, `description`, `blog_date`, `blog_tags`, `status`, `created_at`, `updated_at`) VALUES
(1, 'uploads/blogs/5aeb4f0c1311a69c080e86f7babf01f8.png', 'LMAO', '<hr />\r\n<p>LMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAOLMAO</p>\r\n\r\n<p>descriptiontest</p>', '2021-01-11', 'LMAO TAG', 3, '2021-01-06 09:46:06', '2022-06-12 08:27:38'),
(2, 'uploads/blogs/77fa021f44bc8e8573e0a1abd2e87c57.jpg', 'Seven Layer Salad Recipe / Healthy Salad', '<p>Description<br />\r\n<span style=\"font-size:14px\"><span style=\"color:#333333\"><span style=\"font-family:Roboto,Arial,Helvetica,sans-serif\"><span style=\"background-color:#ffffff\">As we all know that salad favorite dish for us. Today we know about Seven layer salad recipe. Salad has many types of nutrients and fulfill with fiber.</span></span></span></span><br />\r\n<br />\r\n<span style=\"font-size:14px\"><span style=\"color:#333333\"><span style=\"font-family:Roboto,Arial,Helvetica,sans-serif\"><span style=\"background-color:#ffffff\">It&rsquo;s also good for our digestive system and good for our health.</span></span></span></span><br />\r\n<span style=\"font-size:14px\"><span style=\"color:#333333\"><span style=\"font-family:Roboto,Arial,Helvetica,sans-serif\"><span style=\"background-color:#ffffff\">Seven Layer Salad Recipe / Healthy Salad</span></span></span></span></p>\r\n\r\n<p>Secret Ingredients</p>\r\n\r\n<ul>\r\n	<li>1\\2 Pound bacon</li>\r\n	<li>1 medium red onion</li>\r\n	<li>1\\2 cup cauliflower chopped</li>\r\n	<li>1 spoon white sugar</li>\r\n	<li>1 head ice berg lettuce ( rinsed, dried and chopped )</li>\r\n	<li>2\\3 cup grated Parmesan cheese</li>\r\n	<li>2.5 cup package frozen green peas</li>\r\n	<li>6 ounces sheddar cheese</li>\r\n	<li>2.5 spoon mayonnaise</li>\r\n	<li>3 Hard Boil Eggs</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>', '2022-06-12', 'Healthy Salad', 1, '2022-06-12 08:17:22', '2022-06-12 08:17:42'),
(3, 'uploads/blogs/6645404013a90485ac252bf02db0da83.jpg', 'Healthy Mexican Pizza', '<p>Secret Ingredients</p>\r\n\r\n<ul>\r\n	<li>2 whole wheat tortillas</li>\r\n	<li>1/4 cup black beans, pureed</li>\r\n	<li>1/4 cup tomato, sliced</li>\r\n	<li>1/4 cup bell pepper, sliced</li>\r\n	<li>1/4 cup corn, canned</li>\r\n	<li>1/4 cup spinach leaves</li>\r\n	<li>1 teaspoon oregano</li>\r\n	<li>1/4 cup mango, sliced (pineapple works too)</li>\r\n	<li>1/2 cup salsa</li>\r\n	<li>1/4 cup mexican blend cheese, shredded</li>\r\n	<li>1/4 cup cottage cheese</li>\r\n</ul>\r\n\r\n<p>Directions</p>\r\n\r\n<ol>\r\n	<li>Preheat oven to 350.</li>\r\n	<li>Slice tomatoes, bell peppers, and pineapples/mangoes.</li>\r\n	<li>Stack and bake tortillas at 350 for a few minutes or until crispy.</li>\r\n	<li>Using a food processor, puree black beans and spread on the tortilla, place spinach leaves on top of the beans and add pineapple/mango, sliced vegetables, corn and salsa.</li>\r\n	<li>Sprinkle cheese and oregano all over and put back in oven and bake for 10-12 minutes, or until cheese is melted and pizza heats up all over. Top with cool salsa and cottage cheese.</li>\r\n</ol>', '2022-06-12', 'Healthy Mexican Pizza', 1, '2022-06-12 08:21:13', '2022-06-12 08:21:13'),
(4, 'uploads/blogs/68afb642862df82f4f6c1454f688280d.jpg', 'Healthy Pumpkin Bread', '<p>Secret Ingredients</p>\r\n\r\n<ul>\r\n	<li>1 1/4 cups canned pumpkin</li>\r\n	<li>1/2 cup granulated sugar</li>\r\n	<li>1/2 cup brown sugar</li>\r\n	<li>1/2 cup water</li>\r\n	<li>1 cup applesauce</li>\r\n	<li>1 egg</li>\r\n	<li>2 egg whites</li>\r\n	<li>1 cup all-purpose flour</li>\r\n	<li>2/3 cup whole wheat flour</li>\r\n	<li>1 teaspoon baking soda</li>\r\n	<li>1 teaspoon cinnamon</li>\r\n	<li>1/2 teaspoon salt</li>\r\n	<li>1/2 teaspoon baking powder</li>\r\n	<li>1/4 teaspoon ground ginger</li>\r\n	<li>1/4 teaspoon nutmeg</li>\r\n	<li>1/8 teaspoon clove</li>\r\n</ul>\r\n\r\n<p>Directions</p>\r\n\r\n<ol>\r\n	<li>Heat oven to 350.</li>\r\n	<li>In large bowl, combine pumpkin, sugars, water, applesauce, and eggs. Beat until well mixed.</li>\r\n	<li>Combine flours, baking soda, baking powder, salt and spices in a separate bowl. Stir until combined.</li>\r\n	<li>Slowly add dry ingredients to pumpkin mixture. Stir until well combined.</li>\r\n	<li>Grease a 9x5 loaf pan and dust with flour. Pour batter into pan.</li>\r\n	<li>Bake for 50-60 minutes, or until cooked through and golden brown.</li>\r\n	<li>Cool for 5 minutes and remove from pan. Cool on cooling rack until fully cooled.</li>\r\n</ol>', '2022-06-15', 'Healthy Pumpkin Bread', 1, '2022-06-12 08:27:33', '2022-06-12 08:27:33'),
(5, 'uploads/blogs/80e6f05c32eb6ec19360aaf442483004.jpg', 'HEALTHY 10 GRAINS NASI \'LEMAK\'', '<p>Description<br />\r\n<span style=\"font-size:14px\"><span style=\"color:#333333\"><span style=\"font-family:Roboto,Arial,Helvetica,sans-serif\"><span style=\"background-color:#ffffff\">Healthy Ten Grain Rice Nasi Lemak is acutally made up with Love Earth Organic Extra Virgin Coconut which bring you the 100% Original Nasi Lemak flavor. Try now an you will definitely love it.</span></span></span></span></p>\r\n\r\n<p>Secret Ingredients</p>\r\n\r\n<ul>\r\n	<li>1 cup of Love Earth Organic Ten Grain Rice</li>\r\n	<li>1 tbs of Love Earth Organic Coconut Oil</li>\r\n	<li>2 leaves of Pandan</li>\r\n	<li>1 3/4 cups of water</li>\r\n	<li>A pinch of Love Earth Himalaya Mineral Salt</li>\r\n	<li>A pinch of Love Earth Pure Ginger Powder</li>\r\n</ul>\r\n\r\n<p>Directions</p>\r\n\r\n<ol>\r\n	<li>1)Wash and soak the Ten Grain Rice for 30 minutes (For a better &amp; softer texture)</li>\r\n	<li>2)Mix all the ingredients into the rice cooker togther with the soaked rice</li>\r\n	<li>3)Add in 1 3/4 cups of waters (Depend on preference and it&#39;s around the same amount of water used to cook a normal rice)</li>\r\n	<li>4)Start you rice cooker and ready to smell the aroma.</li>\r\n</ol>', '2022-06-25', 'GRAINS NASI \'LEMAK\'', 1, '2022-06-12 08:28:35', '2022-06-12 08:28:35');

-- --------------------------------------------------------

--
-- Table structure for table `blog_comments`
--

CREATE TABLE `blog_comments` (
  `id` int(11) NOT NULL,
  `blog_id` int(11) DEFAULT NULL,
  `user_id` varchar(191) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brand_name` text CHARACTER SET utf8 DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `brand_name`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Zelcos', 'uploads/brand/a1ebcecae1391b69150ecbe5128e0c61.jpg', 3, '2020-10-23 06:38:32', '2020-12-01 09:20:21'),
(2, 'CONTORO', 'uploads/brand/5ac6648da0bb26cb94b691a068a434da.png', 3, '2020-12-01 09:21:15', '2022-06-12 11:43:42'),
(3, 'Gia-Skinpert', 'uploads/brand/488e36a173b2b20ee6f509733381624f.png', 3, '2020-12-01 09:21:42', '2022-06-12 11:43:40'),
(4, 'Diet Plans', 'uploads/brand/8d9b33c871932734556eae6750f08269.png', 1, '2020-12-01 09:22:15', '2022-06-12 11:45:12'),
(5, 'Fitness Plans', 'uploads/brand/4d50faabdc48fcb16524742571938c5b.png', 1, '2020-12-01 09:22:35', '2022-06-12 11:44:46');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_category_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `second_sub_category_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `product_id`, `sub_category_id`, `second_sub_category_id`, `qty`, `status`, `created_at`, `updated_at`) VALUES
(19, 'M000003', '11', 'undefined', 'undefined', '1', 1, '2021-01-06 08:33:10', '2021-01-06 08:40:55');

-- --------------------------------------------------------

--
-- Table structure for table `cart_links`
--

CREATE TABLE `cart_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unique_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_category_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `second_sub_category_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_links`
--

INSERT INTO `cart_links` (`id`, `unique_id`, `user_id`, `product_id`, `sub_category_id`, `second_sub_category_id`, `qty`, `status`, `created_at`, `updated_at`) VALUES
(3, '1608177188', 'M000003', '16', 'undefined', NULL, '3', 1, '2020-12-17 03:53:08', '2020-12-17 03:53:08');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_bar` int(11) DEFAULT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_name` varchar(191) CHARACTER SET utf8 DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `menu_bar`, `code`, `category_name`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Cream', 'Cream', NULL, 3, '2020-10-23 04:10:26', '2022-06-12 11:16:00'),
(2, 1, 'Cleanser', 'Cleanser', NULL, 3, '2020-10-23 04:10:37', '2022-06-12 11:15:58'),
(3, 0, 'Essence', 'Essence', NULL, 3, '2020-10-23 04:10:57', '2022-06-12 11:16:04'),
(4, 0, 'Mask', 'Mask', NULL, 3, '2020-10-23 04:11:22', '2022-06-12 11:16:06'),
(5, 0, 'Hygiene Wash', 'Hygiene Wash', NULL, 3, '2020-10-23 04:12:23', '2022-06-12 11:16:08'),
(6, 1, 'Toner', 'Toner', NULL, 3, '2020-10-23 04:12:41', '2022-06-12 11:16:11'),
(7, 0, 'Wear', 'Wear', NULL, 3, '2020-10-23 04:13:27', '2022-06-12 11:16:13'),
(8, 1, 'CONTORNO', 'CONTORNO', NULL, 3, '2020-11-30 11:58:55', '2022-06-12 11:16:21'),
(9, 1, 'GS', 'Gia-Skinpert', NULL, 3, '2020-11-30 11:59:32', '2022-06-12 11:16:23'),
(10, 1, 'Diet Plans', 'Diet Plans', NULL, 1, '2020-11-30 11:59:56', '2022-06-12 11:18:18'),
(11, 1, 'Fitness Plans', 'Fitness Plans', NULL, 1, '2020-11-30 12:00:43', '2022-06-12 11:17:59');

-- --------------------------------------------------------

--
-- Table structure for table `category_images`
--

CREATE TABLE `category_images` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category_images`
--

INSERT INTO `category_images` (`id`, `category_id`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'uploads/category/3d05f02d3904ac097c4eed694716e509.png', 1, '2020-11-03 08:25:27', '2020-11-03 08:25:27'),
(2, 2, 'uploads/category/071c73bc4f6cc9f7ca6671e1627b3ae1.png', 1, '2020-11-03 08:25:38', '2020-11-03 08:25:38'),
(3, 3, 'uploads/category/7c7414a38cdc998d3a759f88774be4ce.jpg', 1, '2020-11-03 08:25:48', '2020-11-03 08:25:48'),
(4, 4, 'uploads/category/96dddbbbf54ff83a8afe96e144be1f19.jpg', 1, '2020-11-03 08:26:00', '2020-11-03 08:26:00'),
(5, 5, 'uploads/category/2112bb1bf7c47feb97f4ee61cac8916b.jpeg', 1, '2020-11-03 08:26:11', '2020-11-03 08:26:11'),
(6, 8, 'uploads/category/65007e5c8d16a295ee6baba9ee0cf00d.png', 1, '2020-11-30 11:58:55', '2020-11-30 11:58:55'),
(7, 9, 'uploads/category/2973c522f03d88b8e42205e607b3989c.png', 1, '2020-11-30 11:59:32', '2020-11-30 11:59:32'),
(8, 10, 'uploads/category/0c6709f3eb4ed673bbcd4eecb66615b1.png', 1, '2020-11-30 11:59:56', '2020-11-30 11:59:56'),
(9, 11, 'uploads/category/7b9d4414fb09087b4048616bcd19bcf1.png', 1, '2020-11-30 12:00:43', '2020-11-30 12:00:43');

-- --------------------------------------------------------

--
-- Table structure for table `favourites`
--

CREATE TABLE `favourites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `merchants`
--

CREATE TABLE `merchants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `master_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dual_master_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `f_name` varchar(191) CHARACTER SET utf8 NOT NULL,
  `l_name` varchar(191) CHARACTER SET utf8 NOT NULL,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `e_shop_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ic` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `point` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lvl` int(11) DEFAULT NULL,
  `permission_lvl` int(11) DEFAULT NULL,
  `profile_logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bg_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agent_type` int(11) DEFAULT NULL,
  `kkm` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about_us` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `merchants`
--

INSERT INTO `merchants` (`id`, `master_id`, `dual_master_id`, `code`, `country_code`, `email`, `password`, `f_name`, `l_name`, `gender`, `dob`, `phone`, `e_shop_name`, `ic`, `address`, `point`, `lvl`, `permission_lvl`, `profile_logo`, `bg_image`, `agent_type`, `kkm`, `about_us`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'AD000001', NULL, 'M000001', NULL, 'wooikeat@sugawa.com.my', '$2y$10$q09/C0pqtGIESVO66GgeU.0yxKMDvHGR981XJfoJ7mNi8GqPCDqny', 'AA01', '', NULL, NULL, '0125669543', 'AA AA01', '1', '7 & 9 LORONG TEMBIKAI 8\r\nKAWASAN PERNIAGAAN SG. RAMBAI', NULL, 2, NULL, NULL, NULL, 2, NULL, NULL, 1, NULL, '2020-12-04 05:07:51', '2021-12-11 17:50:12'),
(2, 'AD000001', NULL, 'M000002', NULL, 'Q@COM', '$2y$10$Ik6kdiRlB3tKK1mqG3ee0eOmW1V1eId0IZgAVJclyzrc8NLytsJYu', 'AA01', '', NULL, NULL, '125669543', 'AA AA 01', '1', '7 & 9 LORONG TEMBIKAI 8\r\nKAWASAN PERNIAGAAN SG. RAMBAI', NULL, 1, NULL, NULL, NULL, 2, NULL, NULL, 3, NULL, '2020-12-04 05:11:22', '2021-01-06 08:47:19'),
(3, 'AD000001', NULL, 'M000003', NULL, 'tester@gmail.com', '$2y$10$bY1puLhS7Ai3wXdcAHK4eeDXIKa2bxM8MA.EzMJ.P.v7Ainu9XOo2', 'test', '', '', NULL, '123123', 'test Shope Name', '8889522156665', 'tester@gmail.com', NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2020-12-17 01:27:00', '2020-12-17 16:00:42'),
(4, 'M000003', NULL, 'M000004', NULL, 'Destiny43420024420@gmail.com', '$2y$10$k1gzHVEtI33ns6WXByEMUeok0oDgWVn4RPOKU9AvS04c2Uv0KhAaW', 'AGent testin', '', NULL, NULL, '012345678952', 'AGent testin', '1234123124322', 'Mahkota Selatan Jalan Forest 1,\r\nPulau Satu', NULL, 1, NULL, NULL, NULL, 2, NULL, NULL, 1, NULL, '2020-12-17 04:55:10', '2020-12-17 16:00:42'),
(5, 'M000003', NULL, 'M000005', NULL, 'admin@razer.com', '$2y$10$ge6qB4xoDL7kpu4CgxPWme18O2zBdHuJIa8u9QQzcfrWAFekqb73u', 'Agent Testing Two', '', NULL, NULL, '0123456789523', 'Agent Testing Two', '12323345465632', '68 taman sentosa', NULL, 1, NULL, NULL, NULL, 2, NULL, NULL, 1, NULL, '2020-12-17 05:06:45', '2020-12-17 16:00:42'),
(6, 'M000004', NULL, 'M000006', NULL, 'admi123n@gmail.com', '$2y$10$EvB9lhU2GKKZtzLxqzChkeBC/c4FmIcriDZCVYmeaHd7xRFn5zTo6', 'Agent Three', '', NULL, NULL, '0123456478951632', 'Agent Three', '123123123123', '68 taman sentosa', NULL, 1, NULL, NULL, NULL, 2, NULL, NULL, 1, NULL, '2020-12-17 05:10:31', '2020-12-17 16:00:43'),
(7, 'AD000001', NULL, 'M000007', NULL, 'A01@A01', '$2y$10$HeERlH1CFp1hsSV2yy.mHOoon5J1i39nnIxFPC7oPhSq5jfL99Oi6', 'A01', '', '', NULL, '01', 'E A01', '1', 'A01@A01', NULL, 6, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2020-12-23 02:23:13', '2020-12-23 02:38:19'),
(8, 'M000007', NULL, 'M000008', NULL, 'A02@A02', '$2y$10$9dDqXEZ7iCT3Qx2ak8H3Y.XqFzAHkb15WBrzww6kG5lcSOjfT20Y.', 'A02', '', NULL, NULL, '1', 'E A02', '1', 'W', NULL, 6, NULL, NULL, NULL, 2, NULL, NULL, 1, NULL, '2020-12-23 02:25:49', '2020-12-23 02:38:57'),
(9, 'M000008', NULL, 'M000009', NULL, 'A03@A03', '$2y$10$aGGXWO/8Bw/9bMoiLwzffO.UvQ6ObxGZAhRzE1QW9Ej./2pTB.eWm', 'A03', '', NULL, NULL, '2', 'E A03', '1', '1', NULL, 6, NULL, NULL, NULL, 2, NULL, NULL, 1, NULL, '2020-12-23 02:31:51', '2020-12-23 02:39:29'),
(10, 'M000008', NULL, 'M000010', NULL, 'A04@A04', '$2y$10$Hk.bLEjIo64pPKbNgCFXKuVDa1X/j5UxGj/HQXvJU.QJNUYp.2Ltm', 'A04', '', '', NULL, '3', 'E A04', '1', 'A04@A04', NULL, 5, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2020-12-23 02:33:36', '2020-12-23 02:39:58'),
(11, 'M000009', NULL, 'M000011', NULL, 'A05@A05', '$2y$10$8cNnTYdF6m0JnAEMjWuD8uoce/q9uzha9WXocA80lcu8mHwuJm9Fe', 'A05', '', '', NULL, '4', 'E A05', '2', 'A05@A05', NULL, 5, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2020-12-23 02:35:11', '2020-12-23 02:40:17'),
(12, 'M000009', NULL, 'M000012', NULL, 'A06', '$2y$10$CU96rlrCakxdQcAhZLs.F.yyiyPJ3vpMpECTi8/qV9eZH83TDAOvS', 'A06', '', '', NULL, '6', 'E A06', '3', 'A06', NULL, 4, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2020-12-23 02:36:32', '2020-12-23 02:40:39'),
(13, 'M000010', NULL, 'M000013', NULL, 'A07@A07', '$2y$10$GLZgOSQZXm3RGqLkbMTXu.MDdUBcS9roarjCwyxhkNifWA1ANnYv.', 'A07', '', '', NULL, '7', 'E A07', '1', 'A07@A07', NULL, 4, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2020-12-23 02:37:57', '2020-12-23 02:40:53'),
(14, 'M000010', NULL, 'M000014', NULL, 'A08@A08', '$2y$10$II365xtlK2PB1TCGc.9x6eRier8Y5gepAycGVzra2Z8S/ccFyiPwa', 'A08', '', '', NULL, '8', 'E A08', '3', 'A08@A08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2020-12-23 02:41:47', '2020-12-23 02:41:47'),
(15, 'M000009', NULL, 'M000015', NULL, 'B01@B01', '$2y$10$3ysb0f45uZHPf0jW7kMIDeGOuSKHuwiI2LKsCnaNJjUHud2dV24KS', 'B01', '', '', NULL, '21', 'E B01', '1', 'B01@B01', NULL, 5, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2020-12-23 02:46:50', '2020-12-23 02:46:50'),
(16, 'M000015', NULL, 'M000016', NULL, 'B02@B02', '$2y$10$nKiftWeRe/5cHGKsq4GNIOZDh.hI3Bt8.saC2X0mMktdD8dAw6K/.', 'B02', '', '', NULL, '22', 'E B02', '1', 'B02@B02', NULL, 5, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2020-12-23 02:48:07', '2020-12-23 02:48:07'),
(17, 'M000016', NULL, 'M000017', NULL, 'B03@B03', '$2y$10$owquNKJbL2X6kp4o80eaA.HqboyMbj5nJgXjgvUm30y04AZGJ5KG2', 'B03', '', '', NULL, 'B23', 'E B03', '1', 'B03@B03', NULL, 4, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2020-12-23 02:49:03', '2020-12-23 02:49:03'),
(18, 'M000017', NULL, 'M000018', NULL, 'B04@B04', '$2y$10$DSSTTZNWO.g0eh0X.wEElOhJLcBCQBS89Lgo6rn2k/6mRiiAMeVtm', 'B04', '', '', NULL, '23', 'E B04', '1', 'B04@B04', NULL, 4, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2020-12-23 02:50:35', '2020-12-23 02:50:35'),
(19, 'M000018', NULL, 'M000019', NULL, 'B05@B05', '$2y$10$jadOCGun9rsf2gOQYEvZTOASryJgB88IzCtMqhVCUpgl5O5YVrNm.', 'B05', '', '', NULL, 'B25', 'E B05', '1', 'B05@B05', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2020-12-23 02:51:28', '2020-12-23 02:51:28'),
(20, 'M000019', NULL, 'M000020', NULL, 'B06@B06', '$2y$10$IUX811f6FRCUpqd.1G/9hu02vOS4KLX4oql3pH1LAN8cMWq0RO28K', 'B06', '', '', NULL, 'B26', 'E B06', '1', 'B06@B06', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2020-12-23 02:52:52', '2020-12-23 02:52:52'),
(21, 'M000020', NULL, 'M000021', NULL, 'B07@B07', '$2y$10$7CntmnF8emVF98NESoyTD.RJQE5zT9dMC9.wu/4boTP.mZy2e8TR6', 'B07', '', '', NULL, 'B27', 'E B07', '1', 'B07@B07', NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2020-12-23 02:54:06', '2020-12-23 02:54:06'),
(22, 'M000021', NULL, 'M000022', NULL, 'B08@B08', '$2y$10$conhPeyY8ylAUhRMpPuVYetqJ7.RKKcbp/NOE9/A7IbyYX8Pylj86', 'B08', '', '', NULL, 'B28', 'E B08', '1', 'B08@B08', NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2020-12-23 02:55:11', '2020-12-23 02:55:11'),
(23, 'M000022', NULL, 'M000023', NULL, 'B09@B09', '$2y$10$iuurW4vNGolxD9HqgkgeQeorw.I1JSiRZkI7/NY2nNwZikg0/28MW', 'B09', '', '', NULL, 'B29', 'E B09', '1', 'B09@B09', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2020-12-23 02:57:06', '2020-12-24 16:01:01'),
(24, 'M000022', NULL, 'M000024', NULL, 'B10@B10', '$2y$10$xxats.aQyjmEgKs1i1UPR.BM30Zr/1ksDk2bOHqt0ybEREjawUWD.', 'B10', '', NULL, NULL, 'B210', 'E B10', '1', '1', NULL, 1, NULL, NULL, NULL, 2, NULL, NULL, 1, NULL, '2020-12-23 03:00:46', '2020-12-24 16:01:01');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_password_resets_table', 1),
(2, '2014_10_12_1000000_create_cart_table', 1),
(3, '2014_10_12_100000_create_users_table', 1),
(4, '2014_10_12_1100000_create_state_table', 1),
(5, '2014_10_12_1100000_create_user_shipping_addresses_table', 1),
(6, '2014_10_12_1200000_create_favourite_table', 1),
(7, '2014_10_12_1300000_create_search_history_table', 1),
(8, '2014_10_12_1400000_create_brand_table', 1),
(9, '2014_10_12_1500000_create_promotion_table', 1),
(10, '2014_10_12_1600000_create_affiliate_table', 1),
(11, '2014_10_12_1700000_create_setting_merchant_bonus_table', 1),
(12, '2014_10_12_1800000_create_setting_banks_table', 1),
(13, '2014_10_12_1900000_create_sub_category_table', 1),
(14, '2014_10_12_200000_create_merchant_table', 1),
(15, '2014_10_12_300000_create_admin_table', 1),
(16, '2014_10_12_400000_create_product_table', 1),
(17, '2014_10_12_500000_create_product_image_table', 1),
(18, '2014_10_12_600000_create_transaction_table', 1),
(19, '2014_10_12_700000_create_transaction_details_table', 1),
(20, '2014_10_12_800000_create_stock_table', 1),
(21, '2014_10_12_900000_create_category_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `overiding_qualifications`
--

CREATE TABLE `overiding_qualifications` (
  `id` int(11) NOT NULL,
  `user_id` varchar(191) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `package_items`
--

CREATE TABLE `package_items` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `products` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `unit_price` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `package_items`
--

INSERT INTO `package_items` (`id`, `product_id`, `products`, `qty`, `unit_price`) VALUES
(2, 10, 12, 1, 50),
(4, 10, 17, NULL, 50);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_banks`
--

CREATE TABLE `payment_banks` (
  `id` int(11) NOT NULL,
  `bank_name` varchar(191) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_banks`
--

INSERT INTO `payment_banks` (`id`, `bank_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Maybank', 1, '2020-12-05 17:43:20', '2020-12-05 17:46:18'),
(2, 'CIMB Bank', 1, '2020-12-05 17:46:29', '2020-12-05 17:46:29'),
(3, 'Public Bank', 1, '2020-12-05 17:46:40', '2020-12-05 17:46:40'),
(4, 'RHB Bank', 2, '2020-12-05 17:47:11', '2020-12-09 11:11:03'),
(5, 'Hong Leong', 2, '2020-12-08 10:59:33', '2020-12-09 11:10:19');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `permission_lvl` int(11) DEFAULT NULL,
  `page` varchar(191) DEFAULT NULL,
  `status` tinyint(11) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `permission_lvl`, `page`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'dashboard', 1, '2020-12-08 19:20:07', '2020-12-08 19:20:07'),
(2, 1, 'profile', 1, '2020-12-08 19:20:08', '2020-12-08 19:20:08'),
(3, 1, 'permission-control', 1, '2020-12-08 19:20:09', '2020-12-08 19:20:09'),
(4, 1, 'agent-add', 1, '2020-12-08 19:20:18', '2020-12-08 19:20:18'),
(5, 1, 'agent-list', 1, '2020-12-08 19:20:18', '2020-12-08 19:20:18'),
(6, 1, 'agent-pending', 1, '2020-12-08 19:20:20', '2020-12-08 19:20:20'),
(7, 1, 'member-list', 1, '2020-12-08 19:20:21', '2020-12-08 19:20:21'),
(8, 1, 'member-add', 1, '2020-12-08 19:20:22', '2020-12-08 19:20:22'),
(9, 1, 'member-pending', 1, '2020-12-08 19:20:23', '2020-12-08 19:20:23'),
(10, 1, 'product-list', 1, '2020-12-08 19:20:24', '2020-12-08 19:20:24'),
(11, 1, 'product-add', 1, '2020-12-08 19:20:24', '2020-12-08 19:20:24'),
(12, 1, 'product-packages', 1, '2020-12-08 19:20:25', '2020-12-08 19:20:25'),
(13, 1, 'product-packages-add', 1, '2020-12-08 19:20:26', '2020-12-08 19:20:26'),
(14, 1, 'category-list', 1, '2020-12-08 19:20:27', '2020-12-08 19:20:27'),
(15, 1, 'category-add', 1, '2020-12-08 19:20:28', '2020-12-08 19:20:28'),
(16, 1, 'sub-category-list', 1, '2020-12-08 19:20:29', '2020-12-08 19:20:29'),
(17, 1, 'sub-category-add', 1, '2020-12-08 19:20:29', '2020-12-08 19:20:29'),
(18, 1, 'brand-list', 1, '2020-12-08 19:20:31', '2020-12-08 19:20:31'),
(19, 1, 'brand-add', 1, '2020-12-08 19:20:31', '2020-12-08 19:20:31'),
(20, 1, 'bank-list', 1, '2020-12-08 19:20:33', '2020-12-08 19:20:33'),
(21, 1, 'bank-add', 1, '2020-12-08 19:20:33', '2020-12-08 19:20:33'),
(22, 1, 'promotion-list', 1, '2020-12-08 19:20:35', '2020-12-08 19:20:35'),
(23, 1, 'promotion-add', 1, '2020-12-08 19:20:35', '2020-12-08 19:20:35'),
(24, 1, 'transaction-list', 1, '2020-12-08 19:20:37', '2020-12-08 19:20:37'),
(25, 1, 'withdrawal-list', 1, '2020-12-08 19:20:38', '2020-12-08 19:20:38'),
(26, 1, 'sales-report', 1, '2020-12-08 19:20:38', '2020-12-08 19:20:38'),
(27, 1, 'order-report', 1, '2020-12-08 19:20:39', '2020-12-08 19:20:39'),
(28, 1, 'commission-report', 1, '2020-12-08 19:20:40', '2020-12-08 19:20:40'),
(29, 1, 'affiliate-list', 1, '2020-12-08 19:20:41', '2020-12-08 19:20:41'),
(30, 1, 'agent-level', 1, '2020-12-08 19:20:42', '2020-12-08 19:20:42'),
(31, 1, 'agent-order-rebate', 1, '2020-12-08 19:20:43', '2020-12-09 10:45:05'),
(33, 1, 'setting-banner', 1, '2020-12-08 19:20:45', '2020-12-08 19:20:45'),
(34, 1, 'shipping-fee', 1, '2020-12-08 19:20:46', '2020-12-08 19:20:46'),
(35, 1, 'setting-uom', 1, '2020-12-08 19:20:47', '2020-12-08 19:20:47'),
(36, 1, 'product-topup', 1, '2020-12-08 19:20:47', '2020-12-08 19:21:18'),
(37, 1, 'affiliate-topup', 1, '2020-12-08 19:20:48', '2020-12-08 19:21:16'),
(38, 1, 'setting-charges', 1, '2020-12-08 19:20:49', '2020-12-08 19:21:15'),
(39, 2, 'dashboard', 1, '2020-12-08 19:21:27', '2020-12-08 19:21:27'),
(40, 2, 'profile', 1, '2020-12-08 19:21:29', '2020-12-08 19:21:29'),
(41, 2, 'permission-control', 1, '2020-12-08 19:21:30', '2020-12-08 19:21:30'),
(42, 2, 'agent-list', 1, '2020-12-08 19:21:31', '2020-12-08 19:21:31'),
(43, 2, 'agent-add', 1, '2020-12-08 19:21:33', '2020-12-08 19:21:33'),
(44, 2, 'agent-pending', 1, '2020-12-08 19:21:34', '2020-12-08 19:21:34'),
(45, 2, 'member-list', 1, '2020-12-08 19:21:35', '2020-12-08 19:21:35'),
(46, 2, 'member-add', 1, '2020-12-08 19:21:37', '2020-12-08 19:21:37'),
(47, 2, 'member-pending', 1, '2020-12-08 19:21:38', '2020-12-08 19:21:38'),
(48, 2, 'product-list', 1, '2020-12-08 19:21:39', '2020-12-08 19:21:39'),
(49, 2, 'product-add', 1, '2020-12-08 19:21:40', '2020-12-08 19:21:40'),
(50, 2, 'product-packages', 1, '2020-12-08 19:21:42', '2020-12-08 19:21:42'),
(51, 2, 'product-packages-add', 1, '2020-12-08 19:21:43', '2020-12-08 19:21:43'),
(52, 2, 'category-list', 1, '2020-12-08 19:21:44', '2020-12-08 19:21:44'),
(53, 2, 'category-add', 1, '2020-12-08 19:21:45', '2020-12-08 19:21:45'),
(54, 2, 'sub-category-list', 1, '2020-12-08 19:21:47', '2020-12-08 19:21:47'),
(55, 2, 'sub-category-add', 1, '2020-12-08 19:21:48', '2020-12-08 19:21:48'),
(56, 2, 'brand-list', 1, '2020-12-08 19:21:49', '2020-12-08 19:21:49'),
(57, 2, 'brand-add', 1, '2020-12-08 19:21:51', '2020-12-08 19:21:51'),
(58, 2, 'bank-list', 1, '2020-12-08 19:21:52', '2020-12-08 19:21:52'),
(59, 2, 'bank-add', 1, '2020-12-08 19:21:53', '2020-12-08 19:21:53'),
(60, 2, 'promotion-list', 1, '2020-12-08 19:21:55', '2020-12-08 19:21:55'),
(61, 2, 'promotion-add', 1, '2020-12-08 19:21:56', '2020-12-08 19:21:56'),
(62, 2, 'transaction-list', 1, '2020-12-08 19:21:57', '2020-12-08 19:21:57'),
(63, 2, 'withdrawal-list', 1, '2020-12-08 19:21:58', '2020-12-08 19:21:58'),
(64, 2, 'sales-report', 1, '2020-12-08 19:22:00', '2020-12-08 19:22:00'),
(65, 2, 'order-report', 1, '2020-12-08 19:22:01', '2020-12-08 19:22:04'),
(66, 2, 'commission-report', 1, '2020-12-08 19:22:03', '2020-12-08 19:22:03'),
(67, 2, 'affiliate-list', 1, '2020-12-08 19:22:05', '2020-12-08 19:22:05'),
(68, 2, 'agent-level', 1, '2020-12-08 19:22:07', '2020-12-08 19:22:07'),
(69, 2, 'agent-order-rebate', 1, '2020-12-08 19:22:08', '2020-12-08 19:22:08'),
(71, 2, 'setting-banner', 1, '2020-12-08 19:22:10', '2020-12-08 19:22:10'),
(72, 2, 'shipping-fee', 1, '2020-12-08 19:22:12', '2020-12-08 19:22:12'),
(73, 2, 'setting-uom', 1, '2020-12-08 19:22:13', '2020-12-08 19:22:13'),
(74, 2, 'product-topup', 1, '2020-12-08 19:22:14', '2020-12-08 19:22:14'),
(75, 2, 'affiliate-topup', 1, '2020-12-08 19:22:15', '2020-12-08 19:22:15'),
(76, 2, 'setting-charges', 1, '2020-12-08 19:22:16', '2020-12-08 19:22:16'),
(77, 3, 'dashboard', 1, '2020-12-08 19:22:18', '2020-12-08 19:22:18'),
(78, 3, 'profile', 0, '2020-12-08 19:22:19', '2020-12-09 11:18:02'),
(79, 3, 'permission-control', 0, '2020-12-08 19:22:21', '2020-12-09 11:18:01'),
(80, 3, 'agent-list', 0, '2020-12-08 19:22:22', '2020-12-09 11:17:49'),
(81, 3, 'agent-add', 0, '2020-12-08 19:22:23', '2020-12-09 11:17:48'),
(82, 3, 'agent-pending', 0, '2020-12-08 19:22:24', '2020-12-09 11:17:50'),
(83, 3, 'member-list', 0, '2020-12-08 19:22:26', '2020-12-09 11:17:58'),
(84, 3, 'member-add', 0, '2020-12-08 19:22:27', '2020-12-09 11:18:00'),
(85, 3, 'member-pending', 0, '2020-12-08 19:22:28', '2020-12-09 11:18:03'),
(86, 3, 'product-list', 0, '2020-12-08 19:22:30', '2020-12-09 11:17:39'),
(87, 3, 'product-add', 0, '2020-12-08 19:22:31', '2020-12-09 11:17:40'),
(88, 3, 'product-packages', 0, '2020-12-08 19:22:32', '2020-12-09 11:17:41'),
(89, 3, 'product-packages-add', 0, '2020-12-08 19:22:34', '2020-12-09 11:17:42'),
(90, 3, 'category-list', 0, '2020-12-08 19:22:35', '2020-12-09 11:17:43'),
(91, 3, 'category-add', 0, '2020-12-08 19:22:37', '2020-12-09 11:17:44'),
(92, 3, 'sub-category-list', 1, '2020-12-08 19:22:38', '2020-12-08 19:22:38'),
(93, 3, 'sub-category-add', 1, '2020-12-08 19:22:39', '2020-12-08 19:22:39'),
(94, 3, 'brand-list', 1, '2020-12-08 19:22:41', '2020-12-08 19:22:41'),
(95, 3, 'brand-add', 1, '2020-12-08 19:22:42', '2020-12-08 19:22:42'),
(96, 3, 'bank-add', 0, '2020-12-08 19:22:43', '2020-12-09 11:17:37'),
(97, 3, 'bank-list', 0, '2020-12-08 19:22:45', '2020-12-09 11:17:36'),
(98, 3, 'promotion-list', 0, '2020-12-08 19:22:46', '2020-12-09 11:17:35'),
(99, 3, 'promotion-add', 0, '2020-12-08 19:22:47', '2020-12-09 11:17:34'),
(100, 3, 'transaction-list', 1, '2020-12-08 19:22:49', '2020-12-08 19:22:49'),
(101, 3, 'withdrawal-list', 1, '2020-12-08 19:22:50', '2020-12-08 19:22:50'),
(102, 3, 'sales-report', 0, '2020-12-08 19:22:52', '2020-12-09 11:17:30'),
(103, 3, 'order-report', 0, '2020-12-08 19:22:53', '2020-12-09 11:17:31'),
(104, 3, 'commission-report', 0, '2020-12-08 19:22:54', '2020-12-09 11:17:32'),
(105, 3, 'affiliate-list', 0, '2020-12-08 19:22:56', '2020-12-09 11:17:30'),
(106, 3, 'agent-level', 0, '2020-12-08 19:22:57', '2020-12-09 11:17:29'),
(107, 3, 'agent-order-rebate', 0, '2020-12-08 19:22:59', '2020-12-09 11:17:27'),
(109, 3, 'setting-banner', 0, '2020-12-08 19:23:02', '2020-12-09 11:17:26'),
(110, 3, 'shipping-fee', 0, '2020-12-08 19:23:04', '2020-12-09 11:17:23'),
(111, 3, 'setting-uom', 0, '2020-12-08 19:23:06', '2020-12-09 11:17:24'),
(112, 3, 'product-topup', 0, '2020-12-08 19:23:07', '2020-12-09 11:17:25'),
(113, 3, 'affiliate-topup', 0, '2020-12-08 19:23:08', '2020-12-09 11:17:22'),
(114, 3, 'setting-charges', 0, '2020-12-08 19:23:10', '2020-12-09 11:17:21'),
(117, 4, 'dashboard', 1, '2020-12-08 19:23:40', '2020-12-08 19:23:40'),
(118, 4, 'profile', 1, '2020-12-08 19:23:41', '2020-12-08 19:23:41'),
(119, 4, 'permission-control', 1, '2020-12-08 19:23:42', '2020-12-08 19:23:42'),
(120, 4, 'agent-list', 1, '2020-12-08 19:23:43', '2020-12-08 19:23:43'),
(121, 4, 'agent-add', 1, '2020-12-08 19:23:44', '2020-12-08 19:23:44'),
(122, 4, 'agent-pending', 1, '2020-12-08 19:23:46', '2020-12-08 19:23:46'),
(123, 4, 'member-list', 1, '2020-12-08 19:23:47', '2020-12-08 19:23:47'),
(124, 4, 'member-add', 1, '2020-12-08 19:23:48', '2020-12-08 19:23:48'),
(125, 4, 'member-pending', 1, '2020-12-08 19:23:50', '2020-12-08 19:23:50'),
(126, 4, 'product-list', 1, '2020-12-08 19:23:51', '2020-12-08 19:23:51'),
(127, 4, 'product-add', 1, '2020-12-08 19:23:52', '2020-12-08 19:23:52'),
(128, 4, 'product-packages', 1, '2020-12-08 19:23:53', '2020-12-08 19:23:53'),
(129, 4, 'product-packages-add', 1, '2020-12-08 19:23:55', '2020-12-08 19:23:55'),
(130, 4, 'category-list', 1, '2020-12-08 19:23:56', '2020-12-08 19:23:56'),
(131, 4, 'category-add', 1, '2020-12-08 19:23:57', '2020-12-08 19:23:57'),
(132, 4, 'sub-category-list', 1, '2020-12-08 19:23:58', '2020-12-08 19:23:58'),
(133, 4, 'sub-category-add', 1, '2020-12-08 19:24:00', '2020-12-08 19:24:00'),
(134, 4, 'brand-list', 1, '2020-12-08 19:24:01', '2020-12-08 19:24:01'),
(135, 4, 'brand-add', 1, '2020-12-08 19:24:02', '2020-12-08 19:24:02'),
(136, 4, 'bank-list', 1, '2020-12-08 19:24:03', '2020-12-08 19:24:03'),
(137, 4, 'bank-add', 1, '2020-12-08 19:24:05', '2020-12-08 19:24:05'),
(138, 4, 'promotion-list', 1, '2020-12-08 19:24:06', '2020-12-08 19:24:06'),
(139, 4, 'promotion-add', 1, '2020-12-08 19:24:07', '2020-12-08 19:24:07'),
(140, 4, 'transaction-list', 1, '2020-12-08 19:24:08', '2020-12-08 19:24:08'),
(141, 4, 'withdrawal-list', 1, '2020-12-08 19:24:09', '2020-12-08 19:24:09'),
(142, 4, 'sales-report', 1, '2020-12-08 19:24:11', '2020-12-08 19:24:11'),
(143, 4, 'order-report', 1, '2020-12-08 19:24:12', '2020-12-08 19:24:12'),
(144, 4, 'commission-report', 1, '2020-12-08 19:24:13', '2020-12-08 19:24:13'),
(145, 4, 'affiliate-list', 1, '2020-12-08 19:24:14', '2020-12-08 19:24:14'),
(146, 4, 'agent-level', 1, '2020-12-08 19:24:16', '2020-12-08 19:24:16'),
(147, 4, 'setting-banner', 1, '2020-12-08 19:24:19', '2020-12-08 19:24:19'),
(148, 4, 'shipping-fee', 1, '2020-12-08 19:24:21', '2020-12-08 19:24:21'),
(149, 4, 'setting-uom', 1, '2020-12-08 19:24:22', '2020-12-08 19:24:22'),
(150, 4, 'product-topup', 1, '2020-12-08 19:24:23', '2020-12-08 19:24:23'),
(151, 4, 'affiliate-topup', 1, '2020-12-08 19:24:24', '2020-12-08 19:24:24'),
(152, 4, 'setting-charges', 1, '2020-12-08 19:24:26', '2020-12-08 19:24:26'),
(153, 5, 'dashboard', 1, '2020-12-08 19:24:27', '2020-12-08 19:24:27'),
(154, 5, 'profile', 1, '2020-12-08 19:24:29', '2020-12-08 19:24:29'),
(155, 5, 'permission-control', 1, '2020-12-08 19:24:31', '2020-12-08 19:24:31'),
(156, 5, 'agent-list', 1, '2020-12-08 19:24:32', '2020-12-08 19:24:32'),
(157, 5, 'agent-pending', 1, '2020-12-08 19:24:33', '2020-12-08 19:24:33'),
(158, 5, 'agent-add', 1, '2020-12-08 19:24:35', '2020-12-08 19:24:35'),
(159, 5, 'member-list', 1, '2020-12-08 19:24:36', '2020-12-08 19:24:36'),
(160, 5, 'member-add', 1, '2020-12-08 19:24:37', '2020-12-08 19:24:37'),
(161, 5, 'member-pending', 1, '2020-12-08 19:24:39', '2020-12-08 19:24:39'),
(162, 5, 'product-list', 1, '2020-12-08 19:24:40', '2020-12-08 19:24:40'),
(163, 5, 'product-add', 1, '2020-12-08 19:24:41', '2020-12-08 19:24:41'),
(164, 5, 'product-packages', 1, '2020-12-08 19:24:42', '2020-12-08 19:24:42'),
(165, 5, 'product-packages-add', 1, '2020-12-08 19:24:44', '2020-12-08 19:24:44'),
(166, 5, 'category-list', 1, '2020-12-08 19:24:45', '2020-12-08 19:24:45'),
(167, 5, 'category-add', 1, '2020-12-08 19:24:47', '2020-12-08 19:24:47'),
(168, 5, 'sub-category-list', 1, '2020-12-08 19:24:48', '2020-12-08 19:24:48'),
(169, 5, 'sub-category-add', 1, '2020-12-08 19:24:49', '2020-12-08 19:24:49'),
(170, 5, 'brand-list', 1, '2020-12-08 19:24:50', '2020-12-08 19:24:50'),
(171, 5, 'brand-add', 1, '2020-12-08 19:24:51', '2020-12-08 19:24:51'),
(172, 5, 'bank-list', 1, '2020-12-08 19:24:52', '2020-12-08 19:24:52'),
(173, 5, 'bank-add', 1, '2020-12-08 19:24:53', '2020-12-08 19:24:53'),
(174, 5, 'promotion-list', 1, '2020-12-08 19:24:54', '2020-12-08 19:24:54'),
(175, 5, 'promotion-add', 1, '2020-12-08 19:24:56', '2020-12-08 19:24:56'),
(176, 5, 'transaction-list', 1, '2020-12-08 19:24:57', '2020-12-08 19:24:57'),
(177, 5, 'withdrawal-list', 1, '2020-12-08 19:24:58', '2020-12-08 19:24:58'),
(178, 5, 'sales-report', 1, '2020-12-08 19:24:59', '2020-12-08 19:24:59'),
(179, 5, 'order-report', 1, '2020-12-08 19:25:00', '2020-12-08 19:25:00'),
(180, 5, 'commission-report', 1, '2020-12-08 19:25:02', '2020-12-08 19:25:02'),
(181, 5, 'agent-level', 1, '2020-12-08 19:25:03', '2020-12-08 19:25:03'),
(182, 5, 'agent-order-rebate', 1, '2020-12-08 19:25:04', '2020-12-08 19:25:04'),
(184, 5, 'setting-banner', 1, '2020-12-08 19:25:05', '2020-12-08 19:25:05'),
(185, 5, 'shipping-fee', 1, '2020-12-08 19:25:06', '2020-12-08 19:25:06'),
(186, 5, 'setting-charges', 1, '2020-12-08 19:25:06', '2020-12-08 19:25:06'),
(187, 5, 'affiliate-topup', 1, '2020-12-08 19:25:06', '2020-12-08 19:25:06'),
(188, 5, 'affiliate-list', 1, '2020-12-08 19:25:14', '2020-12-08 19:25:14'),
(189, 5, 'setting-uom', 1, '2020-12-08 19:25:20', '2020-12-08 19:25:20'),
(190, 5, 'product-topup', 1, '2020-12-08 19:25:22', '2020-12-08 19:25:22'),
(191, 4, 'agent-order-rebate', 1, '2020-12-08 19:26:19', '2020-12-08 19:26:19'),
(193, 1, 'set-pickup-address', 1, '2020-12-09 10:45:11', '2020-12-09 10:45:11'),
(194, 3, 'set-pickup-address', 0, '2020-12-09 10:45:36', '2020-12-09 11:17:20');

-- --------------------------------------------------------

--
-- Table structure for table `permission_level_lists`
--

CREATE TABLE `permission_level_lists` (
  `id` int(11) NOT NULL,
  `name` varchar(191) CHARACTER SET utf8 DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permission_level_lists`
--

INSERT INTO `permission_level_lists` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, '管理员', 1, NULL, NULL),
(2, '代理', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `packages` int(11) DEFAULT NULL,
  `featured` int(11) DEFAULT NULL,
  `product_type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `f_banner` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `s_banner` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_name` varchar(191) CHARACTER SET utf8 NOT NULL,
  `category_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_category_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double DEFAULT NULL,
  `special_price` double DEFAULT NULL,
  `agent_price` double DEFAULT NULL,
  `agent_special_price` double DEFAULT NULL,
  `quantity` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deduct_quantity` double DEFAULT NULL,
  `description` text CHARACTER SET utf8 DEFAULT NULL,
  `free_gift` text CHARACTER SET utf8 DEFAULT NULL,
  `short_description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `faq` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `efficacy` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inspection_report` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_comm_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_comm_amount` double DEFAULT NULL,
  `in_product_comm_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `in_product_comm_amount` double DEFAULT NULL,
  `own_product_comm_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `own_product_comm_amount` double DEFAULT NULL,
  `mall` int(11) DEFAULT NULL,
  `variation_enable` int(11) DEFAULT NULL,
  `agent_level` int(11) DEFAULT NULL,
  `sort_level` int(11) DEFAULT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `packages`, `featured`, `product_type`, `f_banner`, `s_banner`, `item_code`, `product_code`, `product_name`, `category_id`, `sub_category_id`, `brand_id`, `price`, `special_price`, `agent_price`, `agent_special_price`, `quantity`, `deduct_quantity`, `description`, `free_gift`, `short_description`, `weight`, `faq`, `efficacy`, `inspection_report`, `product_comm_type`, `product_comm_amount`, `in_product_comm_type`, `in_product_comm_amount`, `own_product_comm_type`, `own_product_comm_amount`, `mall`, `variation_enable`, `agent_level`, `sort_level`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 0, NULL, NULL, NULL, 'Cream001', '', 'Acne Cream', '1', 'Select Subcategory', '', 89, 89, 88, 88, '100', NULL, '', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 3, '2020-10-23 04:27:04', '2020-12-01 09:23:13'),
(2, NULL, 0, NULL, NULL, NULL, 'Cleanser001', NULL, 'Cleanser', '2', NULL, '', 55, 55, 33, 33, '1', NULL, '', NULL, NULL, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 3, '2020-10-23 04:28:17', '2020-12-01 09:23:10'),
(3, NULL, 0, NULL, NULL, NULL, 'Essence001', NULL, 'E-essence', '3', NULL, '', 56, 55, 56, 45, '1', NULL, '&lt;p&gt;test&lt;/p&gt;', NULL, 'test short', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 3, '2020-10-23 04:39:42', '2020-12-01 09:23:08'),
(4, NULL, 0, NULL, NULL, NULL, 'Mask001', NULL, 'E-Mask', '4', '2', '', 43, 33, 32, 21, '1', NULL, '', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 3, '2020-10-23 04:40:56', '2020-12-01 09:23:05'),
(5, NULL, 1, NULL, NULL, NULL, 'Hygiene Wash001', NULL, 'Hygiene Wash', '5', NULL, '', 55, 44, 44, 33, '11', NULL, '', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 3, '2020-10-23 06:31:25', '2020-12-01 09:23:16'),
(6, NULL, 0, NULL, NULL, NULL, 'Mask002', NULL, 'Lazy Mask', '4', '1', '', 77, 66, 66, 55, '1', NULL, '', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 3, '2020-10-23 06:33:37', '2020-12-01 09:23:01'),
(7, NULL, 1, NULL, NULL, NULL, 'Wear002', NULL, 'Lingerie Wash', '7', 'Select Subcategory', '', 88, 55, 77, 44, '100', NULL, '', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 3, '2020-10-23 06:34:51', '2020-12-01 09:22:58'),
(8, NULL, 1, NULL, NULL, NULL, 'Toner001', '', 'Toner', '6', 'Select Subcategory', '', 88, 77, 66, 55, '100', NULL, '', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 3, '2020-10-23 06:35:42', '2020-12-01 09:23:19'),
(9, NULL, 1, NULL, NULL, NULL, 'Wear001', NULL, 'Underwear', '7', NULL, '', 88, 77, 66, 55, '100', NULL, '', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 3, '2020-10-23 06:37:00', '2020-12-01 09:22:54'),
(10, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'Package 1', NULL, NULL, NULL, 150, NULL, 140, NULL, NULL, NULL, '<p>package</p>', '<p>New Giveaway</p>', NULL, 1, NULL, NULL, NULL, 'Percentage', NULL, 'Percentage', NULL, 'Percentage', NULL, NULL, NULL, NULL, NULL, 2, '2020-10-23 09:22:53', '2020-11-30 11:57:12'),
(11, NULL, 1, '1', NULL, NULL, 'CONTORNO001', NULL, 'Body Shaping Cream', '8', '3', '2', 50, 48, 30, 20, '10', NULL, '&lt;p&gt;Long Description Testing&lt;/p&gt;', NULL, 'Short Description Testing', 0.1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 3, '2020-12-01 03:40:53', '2022-06-12 11:59:22'),
(12, NULL, 1, '1', NULL, NULL, 'CONTORNO002', NULL, 'Bust Firming Therapy', '8', '4', '', 50, 40, 30, 20, '10', NULL, '', NULL, NULL, 0.2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 3, '2020-12-01 03:42:49', '2022-06-12 11:59:24'),
(13, NULL, 1, '1', NULL, NULL, 'GS001', NULL, 'Skinpert Avocado Cleanser', '9', NULL, '', 50, 40, 30, 20, '10', NULL, '&lt;p&gt;Description&lt;/p&gt;', NULL, 'Short Description', 0.5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 3, '2020-12-01 07:11:09', '2022-06-12 11:59:26'),
(14, NULL, 1, '1', NULL, NULL, 'GS002', NULL, 'Skinpert Hydro Silk Cleanser', '9', NULL, '', 50, 40, 30, 20, '10', NULL, '&lt;p&gt;Description&lt;/p&gt;', NULL, 'Short Description', 0.5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 3, '2020-12-01 07:20:16', '2022-06-12 11:59:29'),
(15, NULL, 1, '1', NULL, NULL, 'GS003', NULL, 'Skinpert loral Toning', '9', NULL, '', 50, 40, 30, 20, '10', NULL, '&lt;p&gt;Description&lt;/p&gt;', NULL, 'Short Description', 0.1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 3, '2020-12-01 07:23:50', '2022-06-12 11:59:31'),
(16, NULL, 1, '1', NULL, NULL, 'CONTORNO-Bust Firming Therapy003', '', 'Bust Firming Essence', '8', '4', '2', 50, 40, 30, 20, '10', NULL, '<p>Description</p>', NULL, 'Short Description', 0.5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 3, '2020-12-01 09:57:20', '2022-06-12 12:14:12'),
(17, NULL, 0, '1', NULL, NULL, 'Fitness Plans001', NULL, 'Alpha M\'s Tailored: 6 Weeks to Living Lean', '11', 'Select Subcategory', '5', 35, 0, 0, 0, '10', NULL, '&lt;p&gt;Aaron Marino, better known as Alpha M, helps men around the world build style, strength, and substance. This is his plan to get your body where you want it to be, while also laying the foundation for a whole-life transformation. Be the total package and embrace total personal development. You&amp;#39;ll get in, get out, and get the best workouts&amp;mdash;and results&amp;mdash;of your life.&lt;/p&gt;\r\n\r\n&lt;h2&gt;Add muscle. Burn fat. Change your life.&lt;/h2&gt;\r\n\r\n&lt;h4&gt;6 workouts per week / 45-60 min. per workout&lt;/h4&gt;\r\n\r\n&lt;p&gt;This comprehensive six-week program is exactly how Aaron Marino trains. It&amp;#39;s designed to be done in any gym, and can be scaled down for beginning lifters, or done as written for intermediate to advanced lifters.&lt;/p&gt;', NULL, 'Short Description', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 1, '2020-12-01 10:04:22', '2022-06-12 12:13:27'),
(18, NULL, 0, '4', NULL, NULL, 'Diet Plans002', NULL, 'CHARGRILLED PIECES WITH CREAMY BUTTER SAUCE', '10', 'Select Subcategory', '4', 24, 0, 0, 0, '40', NULL, '&lt;p&gt;INGREDIENTS&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;- 1 Packet Harvest Gourmet Chargrilled Pieces&lt;br /&gt;\r\n&amp;nbsp;- 3 Tablespoons Margerine&lt;br /&gt;\r\n&amp;nbsp;- 4 Cloves Garlic&lt;br /&gt;\r\n&amp;nbsp;- 2 Sprigs Curry Leaf&lt;br /&gt;\r\n&amp;nbsp;- 3 Sprigs Bird&amp;#39;s Eye Chilli&lt;br /&gt;\r\n&amp;nbsp;- 1 Cup Evaporated Milk&lt;br /&gt;\r\n&amp;nbsp;- 1/2 Cup Water&lt;br /&gt;\r\n&amp;nbsp;- 2 Teaspoons Mushroom Seasoning&lt;br /&gt;\r\n&amp;nbsp;- 15 Grams Corn starch&lt;br /&gt;\r\n&amp;nbsp;- 1 Teaspoon Sugar&lt;/p&gt;\r\n\r\n&lt;h2&gt;PREPARATION&lt;/h2&gt;\r\n\r\n&lt;p&gt;Bake Harvest Gourmet Chargrilled Pieces using air fryer at 180 &amp;deg; C for 4 minutes. Set it aside.&lt;/p&gt;\r\n\r\n&lt;p&gt;Heat a frying pan, melt the margerine. Fry the chopped garlic with the curry leaves and rice chilli until fragrant.&lt;/p&gt;\r\n\r\n&lt;p&gt;Add liquid milk, water, mushroom seasoning and sugar. Mix well.&lt;/p&gt;\r\n\r\n&lt;p&gt;Thicken with cornflour mixture.&lt;/p&gt;\r\n\r\n&lt;p&gt;Add the Harvest Gourmet Chargrilled Pieces and mix well. Ready to be served.&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;', NULL, 'sef', 0, '<p>test faq</p>', '<p>test efficacy</p>', '<p>test report</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 1, '2020-12-01 10:15:37', '2022-07-05 02:31:15'),
(19, NULL, NULL, NULL, NULL, NULL, 'Diet Plans002', '', 'testing', '10', NULL, '', 20, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 1, '2022-07-05 02:33:00', '2022-07-05 02:33:00');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_level` int(11) DEFAULT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image`, `sort_level`, `status`, `created_at`, `updated_at`) VALUES
(1, '1', 'uploads/1/5b038456a87c29aab7f805c81a7898c0.png', NULL, 1, '2020-10-23 04:26:46', '2020-10-23 04:27:04'),
(2, '1', 'uploads/1/96b14e340fb790525b95ad5d8e3d4ad2.png', NULL, 1, '2020-10-23 04:26:46', '2020-10-23 04:27:04'),
(3, '2', 'uploads/2/5a8b9ec9679483857bc4ba7b3f434047.png', 2, 1, '2020-10-23 04:38:07', '2020-10-23 04:38:10'),
(4, '2', 'uploads/2/9e18e00bd15ceef427cbe37894c51c8f.png', 1, 1, '2020-10-23 04:38:07', '2020-10-23 04:38:10'),
(5, '3', 'uploads/3/de3469ea06e34f1c0f8f66667bb0d0c0.png', 2, 1, '2020-10-23 04:39:27', '2020-10-23 04:39:42'),
(6, '3', 'uploads/3/39aa9bffc0b375dfbec16939e65cad88.png', 1, 1, '2020-10-23 04:39:27', '2020-10-23 04:39:42'),
(7, '4', 'uploads/4/2c42f4de20fe0d59e0da5f18f3c04a68.png', NULL, 1, '2020-10-23 04:40:54', '2020-10-23 04:40:56'),
(8, '5', 'uploads/5/ad721b7438b5cfb9e2d40591b719bdde.png', 2, 1, '2020-10-23 06:31:24', '2020-10-23 06:32:05'),
(9, '5', 'uploads/5/828c55ddc62de6e2f300332d376ae302.png', 1, 1, '2020-10-23 06:31:24', '2020-10-23 06:32:05'),
(10, '6', 'uploads/6/aea128a79fdfa3d659623565ff78cd0e.png', NULL, 1, '2020-10-23 06:33:35', '2020-10-23 06:33:37'),
(11, '6', 'uploads/6/41187d0edad0461f1436c38b3169514a.png', NULL, 1, '2020-10-23 06:33:35', '2020-10-23 06:33:37'),
(12, '7', 'uploads/7/93bcf5d4be8fff57c6a72617c1ad5aca.png', 2, 1, '2020-10-23 06:34:45', '2020-10-23 06:34:51'),
(13, '7', 'uploads/7/06e70779240342f359afced5c5e6232e.png', 1, 1, '2020-10-23 06:34:45', '2020-10-23 06:34:51'),
(14, '8', 'uploads/8/a354c073844b2a246e34b9e9e7ccc0b9.png', NULL, 1, '2020-10-23 06:35:39', '2020-10-23 06:35:42'),
(15, '8', 'uploads/8/72849c4d9ac7cc18613103e840487672.png', NULL, 1, '2020-10-23 06:35:39', '2020-10-23 06:35:42'),
(16, '9', 'uploads/9/b58ba417a417c1e9261d8988da57f357.png', NULL, 1, '2020-10-23 07:06:18', '2020-10-23 07:06:18'),
(17, '9', 'uploads/9/12e0931ff8dfc7268ca10778754e7b3f.png', NULL, 1, '2020-10-23 07:06:18', '2020-10-23 07:06:18'),
(18, '10', 'uploads/10/4da45401dd1128dfd8dfe7621f3e2971.png', NULL, 1, '2020-10-23 09:22:50', '2020-10-23 09:22:53'),
(27, '13', 'uploads/13/89529c37b03a7ce74fad516999cfe956.png', NULL, 1, '2020-12-01 07:28:09', '2020-12-01 07:28:09'),
(28, '14', 'uploads/14/6e8d6815cb8a5456c38c0388d5e0d4c3.png', NULL, 1, '2020-12-01 08:28:43', '2020-12-01 08:28:43'),
(29, '15', 'uploads/15/4c3a3dc990e1476e4d9bc8583fb5aed5.png', NULL, 1, '2020-12-01 08:29:12', '2020-12-01 08:29:12'),
(32, '11', 'uploads/11/b11992314fc6744997e8766d1694c377.png', NULL, 1, '2020-12-01 09:16:30', '2020-12-01 09:16:30'),
(34, '16', 'uploads/16/ce08129465e2ff314dc5fd4e3783bcbd.png', NULL, 1, '2020-12-01 09:57:19', '2020-12-01 09:57:20'),
(35, '12', 'uploads/12/6e40a8b8af671ea4436f2812ec1dca98.png', NULL, 1, '2020-12-01 09:59:12', '2020-12-01 09:59:12'),
(42, '18', 'uploads/18/af268696689074dfc4680a9b61a44c37.jpg', NULL, 1, '2022-06-12 11:49:39', '2022-06-12 11:49:39'),
(43, '18', 'uploads/18/c0c96973aeefda0d6e1a4ec4935eee32.PNG', NULL, 1, '2022-06-12 11:52:41', '2022-06-12 11:52:41'),
(46, '17', 'uploads/17/f2f1e29c3b3a4e8beda76c18b5849a06.jpg', NULL, 1, '2022-06-12 12:13:15', '2022-06-12 12:13:15'),
(47, '17', 'uploads/17/008fa3b55eda3efe23f1c3900824c26f.PNG', NULL, 1, '2022-06-12 12:13:25', '2022-06-12 12:13:25'),
(48, '17', 'uploads/17/19ec6f9c13125b43c80a6be63ab65e3d.PNG', NULL, 1, '2022-06-12 12:13:25', '2022-06-12 12:13:25');

-- --------------------------------------------------------

--
-- Table structure for table `product_ratings`
--

CREATE TABLE `product_ratings` (
  `id` int(11) NOT NULL,
  `user_id` varchar(191) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_variations`
--

CREATE TABLE `product_variations` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `variation_name` varchar(191) CHARACTER SET utf8 DEFAULT NULL,
  `variation_price` double DEFAULT NULL,
  `variation_special_price` double DEFAULT NULL,
  `variation_agent_price` double DEFAULT NULL,
  `variation_agent_special_price` double DEFAULT NULL,
  `variation_weight` double DEFAULT NULL,
  `variation_sku` varchar(191) DEFAULT NULL,
  `variation_stock` varchar(191) DEFAULT NULL,
  `variation_deduct_quantity` double DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_variations`
--

INSERT INTO `product_variations` (`id`, `product_id`, `variation_name`, `variation_price`, `variation_special_price`, `variation_agent_price`, `variation_agent_special_price`, `variation_weight`, `variation_sku`, `variation_stock`, `variation_deduct_quantity`, `status`, `created_at`, `updated_at`) VALUES
(1, 13, '100g', 0, 0, 0, 0, 0, NULL, '0', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dow` int(11) DEFAULT NULL,
  `promotion_title` varchar(191) CHARACTER SET utf8 DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `limit_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usage_limit` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `products` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`id`, `dow`, `promotion_title`, `image`, `discount_code`, `amount_type`, `amount`, `quantity`, `limit_type`, `usage_limit`, `products`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Naruto Boruto The Movie', 'uploads/promotions/5a1d84cd8dc463c9d4af92b9eebbfd8f.jpg', 'NarutoUzumaki', 'Amount', '2.00', '20', '1', NULL, '12,15', '2022-06-10 00:00:00', '2022-06-30 00:00:00', 1, '2022-06-12 05:31:51', '2022-06-12 05:31:51');

-- --------------------------------------------------------

--
-- Table structure for table `register_wallets`
--

CREATE TABLE `register_wallets` (
  `id` int(11) NOT NULL,
  `user_id` varchar(191) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `transfer_type` int(11) DEFAULT NULL COMMENT '1 = in\r\n2 = out',
  `created_by` varchar(191) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `search_history`
--

CREATE TABLE `search_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `search_text` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `setting_affiliate_topups`
--

CREATE TABLE `setting_affiliate_topups` (
  `id` int(11) NOT NULL,
  `topup_amount` varchar(191) DEFAULT NULL,
  `profit_type` varchar(191) DEFAULT NULL,
  `profit_amount` double DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `setting_affiliate_topups`
--

INSERT INTO `setting_affiliate_topups` (`id`, `topup_amount`, `profit_type`, `profit_amount`, `status`, `created_at`, `updated_at`) VALUES
(1, '1000', 'Percentage', 20, 1, NULL, NULL),
(2, '2000', 'Percentage', 25, 1, NULL, NULL),
(3, '4000', 'Percentage', 30, 1, NULL, NULL),
(4, '8000', 'Percentage', 40, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `setting_agent_discounts`
--

CREATE TABLE `setting_agent_discounts` (
  `id` int(11) NOT NULL,
  `type` varchar(191) DEFAULT NULL,
  `amount` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `setting_agent_discounts`
--

INSERT INTO `setting_agent_discounts` (`id`, `type`, `amount`) VALUES
(1, 'Percentage', 20);

-- --------------------------------------------------------

--
-- Table structure for table `setting_banners`
--

CREATE TABLE `setting_banners` (
  `id` int(11) NOT NULL,
  `image` varchar(191) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `setting_banners`
--

INSERT INTO `setting_banners` (`id`, `image`, `status`, `created_at`, `updated_at`) VALUES
(17, 'uploads/banner/a11062ccb2e6305d88000d0867cac77a.jpg', 1, '2022-06-12 08:07:15', '2022-06-12 08:07:15'),
(18, 'uploads/banner/cd9de0b4d938775a356f521eaffbb89b.jpg', 1, '2022-06-12 08:07:59', '2022-06-12 08:07:59'),
(19, 'uploads/banner/403a7608cd542f3f42952aee3026b78e.jpg', 1, '2022-06-12 08:08:47', '2022-06-12 08:08:47');

-- --------------------------------------------------------

--
-- Table structure for table `setting_banner_testings`
--

CREATE TABLE `setting_banner_testings` (
  `id` int(11) NOT NULL,
  `banner_id` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `setting_banner_testings`
--

INSERT INTO `setting_banner_testings` (`id`, `banner_id`, `image`, `status`, `created_at`, `updated_at`) VALUES
(3, NULL, 'uploads/bannertesting/8911c906d1f44eedb546e9676046afe3.jpg', 1, '2022-06-12 08:04:15', '2022-06-12 08:04:15'),
(4, NULL, 'uploads/bannertesting/f8108cb4e7f86913d8face925f238d1f.jpg', 1, '2022-06-12 08:04:30', '2022-06-12 08:04:30');

-- --------------------------------------------------------

--
-- Table structure for table `setting_banner_videos`
--

CREATE TABLE `setting_banner_videos` (
  `id` int(11) NOT NULL,
  `video` text CHARACTER SET latin1 NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `setting_banner_videos`
--

INSERT INTO `setting_banner_videos` (`id`, `video`, `status`, `created_at`, `updated_at`) VALUES
(1, 'uploads/bannervideo/b396385bd4b411374925e16d9d7796b3.mp4', 1, '2022-06-12 06:20:21', '2022-06-12 08:03:31');

-- --------------------------------------------------------

--
-- Table structure for table `setting_charges`
--

CREATE TABLE `setting_charges` (
  `id` int(11) NOT NULL,
  `purchase_charges_type` varchar(191) DEFAULT NULL,
  `purchase_charges_amount` double DEFAULT NULL,
  `withdrawal_charges_type` varchar(191) DEFAULT NULL,
  `withdrawal_charges_amount` double DEFAULT NULL,
  `transfer_wallet_charges_type` varchar(191) DEFAULT NULL,
  `transfer_wallet_charges_amount` double DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `setting_charges`
--

INSERT INTO `setting_charges` (`id`, `purchase_charges_type`, `purchase_charges_amount`, `withdrawal_charges_type`, `withdrawal_charges_amount`, `transfer_wallet_charges_type`, `transfer_wallet_charges_amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Percentage', 10, 'Percentage', 5, 'Percentage', 6, 1, '2020-10-30 05:31:34', '2020-10-31 21:58:08');

-- --------------------------------------------------------

--
-- Table structure for table `setting_downline_bonuses`
--

CREATE TABLE `setting_downline_bonuses` (
  `id` int(11) NOT NULL,
  `level_id` int(11) DEFAULT NULL,
  `target` double DEFAULT NULL,
  `comm_type` varchar(191) DEFAULT NULL,
  `comm_amount` double DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setting_downline_bonuses`
--

INSERT INTO `setting_downline_bonuses` (`id`, `level_id`, `target`, `comm_type`, `comm_amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 30, 'Percentage', 1, 1, NULL, NULL),
(2, 1, 1000, 'Percentage', 2, 1, NULL, NULL),
(3, 2, 30, 'Percentage', 3, 1, NULL, NULL),
(4, 2, 3000, 'Percentage', 4, 1, NULL, NULL),
(5, 3, 30, 'Percentage', 5, 1, NULL, NULL),
(6, 3, 5000, 'Percentage', 6, 1, NULL, NULL),
(7, 1, 6000, 'Percentage', 7, 1, NULL, NULL),
(8, 2, 7000, 'Percentage', 8, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `setting_dual_commissions`
--

CREATE TABLE `setting_dual_commissions` (
  `id` int(11) NOT NULL,
  `agent_lvl` int(11) DEFAULT NULL,
  `comm_type` int(11) DEFAULT NULL,
  `comm_amount` varchar(191) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `setting_dual_commissions`
--

INSERT INTO `setting_dual_commissions` (`id`, `agent_lvl`, `comm_type`, `comm_amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '0.2', 1, '2020-08-18 08:24:19', '2020-08-18 08:24:19'),
(2, 2, 1, '0.3', 1, '2020-08-18 08:24:19', '2020-08-18 08:24:19'),
(3, 3, 1, '0.5', 1, '2020-08-18 08:24:19', '2020-08-18 08:24:19');

-- --------------------------------------------------------

--
-- Table structure for table `setting_dual_mains`
--

CREATE TABLE `setting_dual_mains` (
  `id` int(11) NOT NULL,
  `comm_type` int(11) DEFAULT NULL,
  `comm_amount` double DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `setting_dual_mains`
--

INSERT INTO `setting_dual_mains` (`id`, `comm_type`, `comm_amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 1, '2020-08-18 08:23:34', '2020-08-18 08:23:34');

-- --------------------------------------------------------

--
-- Table structure for table `setting_extra_cash_rebates`
--

CREATE TABLE `setting_extra_cash_rebates` (
  `id` int(11) NOT NULL,
  `agent_lvl` int(11) DEFAULT NULL,
  `type` varchar(191) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `setting_gallery_images`
--

CREATE TABLE `setting_gallery_images` (
  `id` int(11) NOT NULL,
  `image` varchar(191) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `setting_gallery_images`
--

INSERT INTO `setting_gallery_images` (`id`, `image`, `status`, `created_at`, `updated_at`) VALUES
(3, 'uploads/gallery/08616b533cb2df0361b02715e01e0690.png', 1, '2022-06-12 10:44:01', '2022-06-12 10:44:01'),
(4, 'uploads/gallery/a5edb940cac08e65f5f58662368ddb06.jpg', 1, '2022-06-12 10:47:19', '2022-06-12 10:47:19'),
(5, 'uploads/gallery/303f66a43d0686b9af42572cc2a595a3.jpg', 1, '2022-06-12 10:47:35', '2022-06-12 10:47:35'),
(6, 'uploads/gallery/26034e8bbbbba6bb5e78788abc5fad54.PNG', 1, '2022-06-12 11:03:31', '2022-06-12 11:03:31');

-- --------------------------------------------------------

--
-- Table structure for table `setting_materials`
--

CREATE TABLE `setting_materials` (
  `id` int(11) NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `images` varchar(191) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setting_materials`
--

INSERT INTO `setting_materials` (`id`, `type_id`, `images`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'uploads/Material/1/91e4d91e2a3366f9be26c78bd5ef7a5d.jpg', 1, '2020-10-06 16:33:59', '2020-10-06 16:33:59'),
(2, 1, 'uploads/Material/1/46b037215348186e0ce7bb9c461ceff5.jpg', 1, '2020-10-06 16:34:00', '2020-10-06 16:34:00'),
(3, 1, 'uploads/Material/1/34960543c16a42eb04e6d85596b2ce4b.jpeg', 1, '2020-10-06 16:34:00', '2020-10-06 16:34:00'),
(4, 1, 'uploads/Material/1/4470151c69e32d08d6b0ff40b9e5500d.jpg', 1, '2020-10-06 16:34:00', '2020-10-06 16:34:00'),
(5, 1, 'uploads/Material/1/3360df63b7278eb342c556fdebf61e54.jpeg', 1, '2020-10-06 16:34:00', '2020-10-06 16:34:00'),
(6, 2, 'uploads/Material/2/e591f730a2a74ad1eef18afddf00f9a8.mp4', 1, '2020-10-06 16:37:25', '2020-10-06 16:37:25'),
(7, 3, 'uploads/Material/3/341aa62bd72c1d22e6f24fe7758878de.pdf', 1, '2020-10-06 16:45:13', '2020-10-06 16:45:13'),
(8, 3, 'uploads/Material/3/f284b29da4d2de616e4a86c7666f7e98.pdf', 1, '2020-10-06 16:47:33', '2020-10-06 16:47:33');

-- --------------------------------------------------------

--
-- Table structure for table `setting_merchant_bonuses`
--

CREATE TABLE `setting_merchant_bonuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `agent_lvl` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `setting_merchant_commissions`
--

CREATE TABLE `setting_merchant_commissions` (
  `id` int(11) NOT NULL,
  `agent_lvl` varchar(191) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `comm_type` varchar(191) DEFAULT NULL,
  `comm_amount` varchar(191) NOT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setting_merchant_commissions`
--

INSERT INTO `setting_merchant_commissions` (`id`, `agent_lvl`, `level`, `comm_type`, `comm_amount`, `status`, `created_at`, `updated_at`) VALUES
(1, '1', 1, 'Percentage', '7', 1, '2020-08-15 20:43:25', '0000-00-00 00:00:00'),
(2, '1', 2, 'Percentage', '2', 1, '2020-08-15 20:43:25', '0000-00-00 00:00:00'),
(3, '1', 3, 'Percentage', '1', 1, '2020-08-15 20:43:25', '0000-00-00 00:00:00'),
(4, '2', 1, 'Percentage', '10', 1, '2020-08-15 20:43:25', '0000-00-00 00:00:00'),
(5, '2', 2, 'Percentage', '2.5', 1, '2020-08-15 20:43:25', '0000-00-00 00:00:00'),
(6, '2', 3, 'Percentage', '1.5', 1, '2020-08-15 20:43:25', '0000-00-00 00:00:00'),
(7, '3', 1, 'Percentage', '15', 1, '2020-08-15 20:43:25', '0000-00-00 00:00:00'),
(8, '3', 2, 'Percentage', '3', 1, '2020-08-15 20:43:25', '0000-00-00 00:00:00'),
(9, '3', 3, 'Percentage', '2', 1, '2020-08-15 20:43:25', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `setting_merchant_rebates`
--

CREATE TABLE `setting_merchant_rebates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `agent_lvl` int(11) DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `personal_sale` double DEFAULT NULL,
  `line_group_sale` int(11) DEFAULT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `setting_merchant_rebates`
--

INSERT INTO `setting_merchant_rebates` (`id`, `agent_lvl`, `type`, `amount`, `personal_sale`, `line_group_sale`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Percentage', '10', 0, 0, 1, NULL, NULL),
(2, 2, 'Percentage', '20', 0, 0, 1, NULL, NULL),
(3, 3, 'Percentage', '25', 2000, 1, 1, NULL, NULL),
(4, 4, 'Percentage', '30', 4000, 2, 1, NULL, NULL),
(5, 5, 'Percentage', '35', 6000, 3, 1, NULL, NULL),
(6, 6, 'Percentage', '40', 10000, 3, 1, NULL, NULL),
(7, 6, 'Percentage', '40', 10000, 3, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `setting_monthly_agent_sales_bonuses`
--

CREATE TABLE `setting_monthly_agent_sales_bonuses` (
  `id` int(11) NOT NULL,
  `monthly_type` int(11) DEFAULT NULL,
  `target` double DEFAULT NULL,
  `comm_type` varchar(191) DEFAULT NULL,
  `comm_amount` double DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setting_monthly_agent_sales_bonuses`
--

INSERT INTO `setting_monthly_agent_sales_bonuses` (`id`, `monthly_type`, `target`, `comm_type`, `comm_amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 500, 'Percentage', 1, 1, '2020-08-21 05:55:23', '2020-08-21 05:55:23'),
(2, 1, 1000, 'Percentage', 2, 1, '2020-08-21 05:55:23', '2020-08-21 05:55:23'),
(3, 2, 1000, 'Percentage', 1, 1, '2020-08-21 05:55:23', '2020-08-21 05:55:23'),
(4, 2, 2000, 'Percentage', 2, 1, '2020-08-21 05:55:23', '2020-08-21 05:55:23');

-- --------------------------------------------------------

--
-- Table structure for table `setting_performance_dividends`
--

CREATE TABLE `setting_performance_dividends` (
  `id` int(11) NOT NULL,
  `lvl` int(11) DEFAULT NULL,
  `target` double DEFAULT NULL,
  `amount` varchar(191) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `setting_performance_mains`
--

CREATE TABLE `setting_performance_mains` (
  `id` int(11) NOT NULL,
  `date_update` int(11) NOT NULL,
  `target` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `setting_pick_up_addresses`
--

CREATE TABLE `setting_pick_up_addresses` (
  `id` int(11) NOT NULL,
  `company_name` varchar(191) DEFAULT NULL,
  `contact` varchar(191) DEFAULT NULL,
  `address` text CHARACTER SET utf8 DEFAULT NULL,
  `postcode` varchar(191) DEFAULT NULL,
  `city` varchar(191) DEFAULT NULL,
  `state` varchar(191) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setting_pick_up_addresses`
--

INSERT INTO `setting_pick_up_addresses` (`id`, `company_name`, `contact`, `address`, `postcode`, `city`, `state`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Vesson Web Design', '0123456789', 'Address', '11900', 'City', '1', 1, '2020-12-09 09:10:36', '2020-12-09 09:13:02');

-- --------------------------------------------------------

--
-- Table structure for table `setting_pop_up_images`
--

CREATE TABLE `setting_pop_up_images` (
  `id` int(11) NOT NULL,
  `image` varchar(191) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `setting_pop_up_images`
--

INSERT INTO `setting_pop_up_images` (`id`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'uploads/popup/2898b2644486ea1bbaa004bc85e54145.PNG', 1, '2021-10-19 15:20:06', '2021-10-19 15:20:06');

-- --------------------------------------------------------

--
-- Table structure for table `setting_refferal_rewards`
--

CREATE TABLE `setting_refferal_rewards` (
  `id` int(11) NOT NULL,
  `agent_lvl` varchar(191) DEFAULT NULL,
  `amount` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setting_refferal_rewards`
--

INSERT INTO `setting_refferal_rewards` (`id`, `agent_lvl`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(1, '1', 5, 1, '2020-10-07 17:55:01', '0000-00-00 00:00:00'),
(2, '2', 10, 1, '2020-10-07 17:55:01', '0000-00-00 00:00:00'),
(3, '3', 15, 1, '2020-10-07 17:55:01', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `setting_shipping_fees`
--

CREATE TABLE `setting_shipping_fees` (
  `id` int(11) NOT NULL,
  `area` varchar(191) DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `shipping_fee` varchar(191) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setting_shipping_fees`
--

INSERT INTO `setting_shipping_fees` (`id`, `area`, `weight`, `shipping_fee`, `status`, `created_at`, `updated_at`) VALUES
(1, 'west', 1, '10', 1, NULL, NULL),
(2, 'west', 2, '20', 1, NULL, NULL),
(3, 'east', 1, '15', 1, NULL, NULL),
(4, 'east', 2, '25', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `setting_team_dividends`
--

CREATE TABLE `setting_team_dividends` (
  `id` int(11) NOT NULL,
  `lvl` int(11) DEFAULT NULL,
  `target_box` double DEFAULT NULL,
  `amount` varchar(191) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setting_team_dividends`
--

INSERT INTO `setting_team_dividends` (`id`, `lvl`, `target_box`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, '1', 1, NULL, NULL),
(2, 2, NULL, '1.25', 1, NULL, NULL),
(3, 3, NULL, '1.5', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `setting_team_mains`
--

CREATE TABLE `setting_team_mains` (
  `id` int(11) NOT NULL,
  `date_update` int(11) DEFAULT NULL,
  `target` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setting_team_mains`
--

INSERT INTO `setting_team_mains` (`id`, `date_update`, `target`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 1, '2020-08-19 10:18:02', '2020-08-19 10:18:02');

-- --------------------------------------------------------

--
-- Table structure for table `setting_topups`
--

CREATE TABLE `setting_topups` (
  `id` int(11) NOT NULL,
  `topup_amount` varchar(191) DEFAULT NULL,
  `profit_type` varchar(191) DEFAULT NULL,
  `profit_amount` double DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `setting_topups`
--

INSERT INTO `setting_topups` (`id`, `topup_amount`, `profit_type`, `profit_amount`, `status`, `created_at`, `updated_at`) VALUES
(1, '100', 'Percentage', 10, 1, NULL, NULL),
(2, '1000', 'Percentage', 20, 1, NULL, NULL),
(3, '2000', 'Percentage', 25, 1, NULL, NULL),
(4, '4000', 'Percentage', 30, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `setting_uoms`
--

CREATE TABLE `setting_uoms` (
  `id` int(11) NOT NULL,
  `uom_name` varchar(191) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setting_uoms`
--

INSERT INTO `setting_uoms` (`id`, `uom_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Pcs', '1', '2020-05-27 05:11:41', '2020-05-27 13:11:41'),
(2, 'Pkg', '1', '2020-05-27 05:11:41', '2020-05-27 13:11:41'),
(3, 'Bag', '1', '2020-05-27 05:11:41', '2020-05-27 13:11:41'),
(4, 'Box', '1', '2020-05-27 05:11:41', '2020-05-27 13:11:41'),
(5, '', '1', '2020-05-27 05:11:41', '2020-05-27 13:11:41');

-- --------------------------------------------------------

--
-- Table structure for table `setting_website_images`
--

CREATE TABLE `setting_website_images` (
  `id` int(11) NOT NULL,
  `image` varchar(191) DEFAULT NULL,
  `sort_level` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `setting_website_images`
--

INSERT INTO `setting_website_images` (`id`, `image`, `sort_level`, `status`, `created_at`, `updated_at`) VALUES
(1, 'uploads/banner/bdb0cc0b64b8c71123dbee9818ca048c.jpg', 2, 1, '2020-10-05 14:58:34', '2020-10-05 15:14:43'),
(2, 'uploads/banner/f6cbff515b0094eea4f01fcf35a3db68.jpg', 4, 1, '2020-10-05 14:58:35', '2020-10-05 15:14:43'),
(3, 'uploads/banner/54a44c7428727b961c30a8151313311c.jpg', 1, 1, '2020-10-05 14:58:35', '2020-10-05 15:14:42'),
(4, 'uploads/banner/7f86bbb72ad875053b54b9d7ca5fa9a4.jpeg', 5, 1, '2020-10-05 14:58:35', '2020-10-05 15:14:43'),
(5, 'uploads/banner/53a19c5db9c42dea073dad79741d007d.jpeg', 3, 1, '2020-10-05 14:58:36', '2020-10-05 15:14:42');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `country_id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 'WP Kuala Lumpur', 1, '2019-11-26 07:24:56', NULL),
(2, NULL, 'Johor', 1, '2019-11-26 07:24:56', NULL),
(3, NULL, 'Kedah', 1, '2019-11-26 07:24:56', NULL),
(4, NULL, 'Kelantan', 1, '2019-11-26 07:24:56', NULL),
(5, NULL, 'Melaka', 1, '2019-11-26 07:24:56', NULL),
(6, NULL, 'Negeri Sembilan', 1, '2019-11-26 07:24:56', NULL),
(7, NULL, 'Pahang', 1, '2019-11-26 07:24:56', NULL),
(8, NULL, 'Penang', 1, '2019-11-26 07:24:56', NULL),
(9, NULL, 'Perak', 1, '2019-11-26 07:24:56', NULL),
(10, NULL, 'Perlis', 1, '2019-11-26 07:24:56', NULL),
(11, NULL, 'Sabah', 1, '2019-11-26 07:24:56', NULL),
(12, NULL, 'Sarawak', 1, '2019-11-26 07:24:56', NULL),
(13, NULL, 'Selangor', 1, '2019-11-26 07:24:56', NULL),
(14, NULL, 'Terengganu', 1, '2019-11-26 07:24:56', NULL),
(15, NULL, 'Wp Labuan', 1, '2019-11-26 07:24:56', NULL),
(16, NULL, 'Wp Putrajaya', 1, '2019-11-26 07:24:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `product_id`, `type`, `quantity`, `remark`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Increase', '100', 'Open Stock', 1, '2020-10-23 04:27:04', '2020-10-23 04:27:04'),
(2, 2, 'Increase', '1', 'Open Stock', 1, '2020-10-23 04:28:17', '2020-10-23 04:28:17'),
(3, 3, 'Increase', '1', 'Open Stock', 1, '2020-10-23 04:39:42', '2020-10-23 04:39:42'),
(4, 4, 'Increase', '1', 'Open Stock', 1, '2020-10-23 04:40:56', '2020-10-23 04:40:56'),
(5, 5, 'Increase', '11', 'Open Stock', 1, '2020-10-23 06:31:25', '2020-10-23 06:31:25'),
(6, 6, 'Increase', '1', 'Open Stock', 1, '2020-10-23 06:33:37', '2020-10-23 06:33:37'),
(7, 7, 'Increase', '100', 'Open Stock', 1, '2020-10-23 06:34:51', '2020-10-23 06:34:51'),
(8, 8, 'Increase', '100', 'Open Stock', 1, '2020-10-23 06:35:42', '2020-10-23 06:35:42'),
(9, 9, 'Increase', '100', 'Open Stock', 1, '2020-10-23 06:37:00', '2020-10-23 06:37:00'),
(10, 10, 'Increase', '12', 'Open Stock', 1, '2020-10-23 07:02:57', '2020-10-23 07:02:57'),
(11, 11, 'Increase', '10', 'Open Stock', 1, '2020-12-01 03:40:53', '2020-12-01 03:40:53'),
(12, 12, 'Increase', '10', 'Open Stock', 1, '2020-12-01 03:42:49', '2020-12-01 03:42:49'),
(13, 13, 'Increase', '10', 'Open Stock', 1, '2020-12-01 07:11:09', '2020-12-01 07:11:09'),
(14, 14, 'Increase', '10', 'Open Stock', 1, '2020-12-01 07:20:16', '2020-12-01 07:20:16'),
(15, 15, 'Increase', '10', 'Open Stock', 1, '2020-12-01 07:23:51', '2020-12-01 07:23:51'),
(16, 16, 'Increase', '10', 'Open Stock', 1, '2020-12-01 09:57:20', '2020-12-01 09:57:20'),
(17, 17, 'Increase', '10', 'Open Stock', 1, '2020-12-01 10:04:22', '2020-12-01 10:04:22'),
(18, 18, 'Increase', '40', 'Open Stock', 1, '2020-12-01 10:15:37', '2020-12-01 10:15:37'),
(19, 16, 'Increase', '5000', NULL, 1, '2020-12-02 10:48:10', '2020-12-02 10:48:10'),
(20, 19, 'Increase', NULL, 'Open Stock', 1, '2022-07-05 02:33:00', '2022-07-05 02:33:00');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sub_category_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `sub_category_name` varchar(191) CHARACTER SET utf8 DEFAULT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `sub_category_code`, `category_id`, `sub_category_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'LZM', 4, 'Lazy Mask', 3, '2020-10-23 06:50:56', '2020-12-01 09:38:44'),
(2, 'EM', 4, 'E-Mask', 3, '2020-10-23 06:51:04', '2020-12-01 09:38:41'),
(3, 'Body Shaping Cream', 8, 'Body Shaping Cream', 1, '2020-12-01 09:39:11', '2020-12-01 09:39:11'),
(4, 'Bust Firming Therapy', 8, 'Bust Firming Therapy', 1, '2020-12-01 09:39:50', '2020-12-01 09:39:50');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_countries`
--

CREATE TABLE `tbl_countries` (
  `country_id` int(11) NOT NULL,
  `country_code` varchar(2) NOT NULL,
  `country_status` int(1) NOT NULL COMMENT '1=enable select',
  `country_name` varchar(50) NOT NULL,
  `country_name_CN` varchar(255) DEFAULT NULL,
  `country_name_CN_trad` varchar(255) DEFAULT NULL,
  `country_contact` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_countries`
--

INSERT INTO `tbl_countries` (`country_id`, `country_code`, `country_status`, `country_name`, `country_name_CN`, `country_name_CN_trad`, `country_contact`) VALUES
(1, 'AD', 0, 'Andorra', NULL, NULL, '376'),
(2, 'AE', 0, 'United Arab Emirates', NULL, NULL, '971'),
(3, 'AF', 0, 'Afghanistan', NULL, NULL, '93'),
(4, 'AG', 0, 'Antigua', NULL, NULL, '1268'),
(5, 'AI', 0, 'Anguilla', NULL, NULL, '1264'),
(6, 'AL', 0, 'Albania', NULL, NULL, '355'),
(7, 'AM', 0, 'Armenia', NULL, NULL, '374'),
(8, 'AN', 0, 'Netherlands Antilles', NULL, NULL, '31'),
(9, 'AO', 0, 'Angola', NULL, NULL, '244'),
(10, 'AQ', 0, 'Antarctica', NULL, NULL, ''),
(11, 'AR', 0, 'Argentina', NULL, NULL, '54'),
(12, 'AS', 0, 'American Samoa', NULL, NULL, '1684'),
(13, 'AT', 0, 'Austria', NULL, NULL, '43'),
(14, 'AU', 1, 'Australia', NULL, NULL, '61'),
(15, 'AW', 0, 'Aruba', NULL, NULL, '297'),
(16, 'AX', 0, 'Aland Islands', NULL, NULL, ''),
(17, 'AZ', 0, 'Azerbaijan', NULL, NULL, '994'),
(18, 'BA', 0, 'Bosnia and Herzegovina', NULL, NULL, '387'),
(19, 'BB', 0, 'Barbados', NULL, NULL, '1246'),
(20, 'BD', 0, 'Bangladesh', NULL, NULL, '880'),
(21, 'BE', 0, 'Belgium', NULL, NULL, '32'),
(22, 'BF', 0, 'Burkina Faso', NULL, NULL, '226'),
(23, 'BG', 0, 'Bulgaria', NULL, NULL, '359'),
(24, 'BH', 0, 'Bahrain', NULL, NULL, '973'),
(25, 'BI', 0, 'Burundi', NULL, NULL, '257'),
(26, 'BJ', 0, 'Benin', NULL, NULL, '229'),
(27, 'BL', 0, 'Saint Barthelemy', NULL, NULL, '590'),
(28, 'BM', 0, 'Bermuda', NULL, NULL, '1441'),
(29, 'BN', 0, 'Brunei', NULL, NULL, '673'),
(30, 'BO', 0, 'Bolivia', NULL, NULL, '591'),
(31, 'BQ', 0, 'Bonaire, Saint Eustatius and Saba ', NULL, NULL, ''),
(32, 'BR', 0, 'Brazil', NULL, NULL, '55'),
(33, 'BS', 0, 'Bahamas', NULL, NULL, '1242'),
(34, 'BT', 0, 'Bhutan', NULL, NULL, '975'),
(35, 'BV', 0, 'Bouvet Island', NULL, NULL, ''),
(36, 'BW', 0, 'Botswana', NULL, NULL, '267'),
(37, 'BY', 0, 'Belarus', NULL, NULL, '375'),
(38, 'BZ', 0, 'Belize', NULL, NULL, '501'),
(39, 'CA', 0, 'Canada', NULL, NULL, '1'),
(40, 'CC', 0, 'Cocos Islands', NULL, NULL, ''),
(41, 'CD', 0, 'Congo (Republic)', NULL, NULL, '242'),
(42, 'CF', 0, 'Central African Republic', NULL, NULL, '236'),
(43, 'CG', 0, 'Republic of the Congo', NULL, NULL, ''),
(44, '', 0, 'Switzerland', NULL, NULL, '41'),
(45, 'CI', 0, 'Ivory Coast', NULL, NULL, ''),
(46, 'CK', 0, 'Cook Islands', NULL, NULL, '682'),
(47, 'CL', 0, 'Chile', NULL, NULL, '56'),
(48, 'CM', 0, 'Cameroon', NULL, NULL, '237'),
(49, 'CN', 1, 'China', NULL, NULL, '86'),
(50, 'CO', 0, 'Colombia', NULL, NULL, '57'),
(51, 'CR', 0, 'Costa Rica', NULL, NULL, '506'),
(52, 'CS', 0, 'Serbia and Montenegro', NULL, NULL, ''),
(53, 'CU', 0, 'Cuba', NULL, NULL, '53'),
(54, 'CV', 0, 'Cape Verde', NULL, NULL, '238'),
(55, 'CW', 0, 'Curacao', NULL, NULL, '599'),
(56, 'CX', 0, 'Christmas Island', NULL, NULL, ''),
(57, 'CY', 0, 'Cyprus', NULL, NULL, '357'),
(58, 'CZ', 0, 'Czech Republic', NULL, NULL, '420'),
(59, 'DE', 0, 'Germany', NULL, NULL, '49'),
(60, 'DJ', 0, 'Djibouti', NULL, NULL, '253'),
(61, 'DK', 0, 'Denmark', NULL, NULL, '45'),
(62, 'DM', 0, 'Dominica', NULL, NULL, '1767'),
(63, 'DO', 0, 'Dominican Republic', NULL, NULL, '1'),
(64, 'DZ', 0, 'Algeria', NULL, NULL, '213'),
(65, 'EC', 0, 'Ecuador', NULL, NULL, '593'),
(66, 'EE', 0, 'Estonia', NULL, NULL, '372'),
(67, 'EG', 0, 'Egypt', NULL, NULL, '20'),
(68, 'EH', 0, 'Western Sahara', NULL, NULL, ''),
(69, 'ER', 0, 'Eritrea', NULL, NULL, '291'),
(70, 'ES', 0, 'Spain', NULL, NULL, '34'),
(71, 'ET', 0, 'Ethiopia', NULL, NULL, '251'),
(72, 'FI', 0, 'Finland', NULL, NULL, '358'),
(73, 'FJ', 0, 'Fiji', NULL, NULL, '679'),
(74, 'FK', 0, 'Falkland Islands', NULL, NULL, '500'),
(75, 'FM', 0, 'Micronesia', NULL, NULL, '691'),
(76, 'FO', 0, 'Faroe Islands', NULL, NULL, '298'),
(77, 'FR', 0, 'France', NULL, NULL, '33'),
(78, 'GA', 0, 'Gabon', NULL, NULL, '241'),
(79, 'GB', 1, 'United Kingdom', NULL, NULL, '44'),
(80, 'GD', 0, 'Grenada', NULL, NULL, '1473'),
(81, 'GE', 0, 'Georgia', NULL, NULL, '995'),
(82, 'GF', 0, 'French Guiana', NULL, NULL, '594'),
(83, 'GG', 0, 'Guernsey', NULL, NULL, ''),
(84, 'GH', 0, 'Ghana', NULL, NULL, '233'),
(85, 'GI', 0, 'Gibraltar', NULL, NULL, '350'),
(86, 'GL', 0, 'Greenland', NULL, NULL, '299'),
(87, 'GM', 0, 'Gambia', NULL, NULL, '220'),
(88, 'GN', 0, 'Guinea', NULL, NULL, '224'),
(89, 'GP', 0, 'Guadeloupe', NULL, NULL, '590'),
(90, 'GQ', 0, 'Equatorial Guinea', NULL, NULL, '240'),
(91, 'GR', 0, 'Greece', NULL, NULL, '30'),
(92, 'GS', 0, 'South Georgia and the South Sandwich Islands', NULL, NULL, ''),
(93, 'GT', 0, 'Guatemala', NULL, NULL, '502'),
(94, 'GU', 0, 'Guam', NULL, NULL, '1671'),
(95, 'GW', 0, 'Guinea-Bissau', NULL, NULL, '245'),
(96, 'GY', 0, 'Guyana', NULL, NULL, '592'),
(97, 'HK', 1, 'Hong Kong', NULL, NULL, '852'),
(98, 'HM', 0, 'Heard Island and McDonald Islands', NULL, NULL, ''),
(99, 'HN', 0, 'Honduras', NULL, NULL, '504'),
(100, 'HR', 0, 'Croatia', NULL, NULL, '385'),
(101, 'HT', 0, 'Haiti', NULL, NULL, '509'),
(102, 'HU', 0, 'Hungary', NULL, NULL, '36'),
(103, 'ID', 1, 'Indonesia', NULL, NULL, '62'),
(104, 'IE', 0, 'Ireland', NULL, NULL, '353'),
(105, 'IL', 0, 'Israel', NULL, NULL, '972'),
(106, 'IM', 0, 'Isle of Man', NULL, NULL, ''),
(107, 'IN', 1, 'India', NULL, NULL, '91'),
(108, 'IO', 1, 'British Indian Ocean Territory', NULL, NULL, '246'),
(109, 'IQ', 0, 'Iraq', NULL, NULL, '964'),
(110, 'IR', 0, 'Iran', NULL, NULL, '98'),
(111, 'IS', 0, 'Iceland', NULL, NULL, '354'),
(112, 'IT', 0, 'Italy', NULL, NULL, '39'),
(113, 'JE', 0, 'Jersey', NULL, NULL, ''),
(114, 'JM', 0, 'Jamaica', NULL, NULL, '1876'),
(115, 'JO', 0, 'Jordan', NULL, NULL, '962'),
(116, 'JP', 1, 'Japan', NULL, NULL, '81'),
(117, 'KE', 0, 'Kenya', NULL, NULL, '254'),
(118, 'KG', 0, 'Kyrgyzstan', NULL, NULL, '996'),
(119, 'KH', 1, 'Cambodia', NULL, NULL, '855'),
(120, 'KI', 0, 'Kiribati', NULL, NULL, '686'),
(121, 'KM', 0, 'Comoros', NULL, NULL, '269'),
(122, 'KN', 0, 'Saint Kitts and Nevis', NULL, NULL, '1869'),
(123, 'KP', 1, 'North Korea', NULL, NULL, '850'),
(124, 'KR', 1, 'South Korea', NULL, NULL, '82'),
(125, 'KW', 0, 'Kuwait', NULL, NULL, '965'),
(126, 'KY', 0, 'Cayman Islands', NULL, NULL, '1345'),
(127, 'KZ', 0, 'Kazakhstan', NULL, NULL, '7'),
(128, 'LA', 0, 'Laos', NULL, NULL, '856'),
(129, 'LB', 0, 'Lebanon', NULL, NULL, '961'),
(130, 'LC', 0, 'Saint Lucia', NULL, NULL, '1758'),
(131, 'LI', 0, 'Liechtenstein', NULL, NULL, '423'),
(132, 'LK', 0, 'Sri Lanka', NULL, NULL, '94'),
(133, 'LR', 0, 'Liberia', NULL, NULL, '231'),
(134, 'LS', 0, 'Lesotho', NULL, NULL, '266'),
(135, 'LT', 0, 'Lithuania', NULL, NULL, '370'),
(136, 'LU', 0, 'Luxembourg', NULL, NULL, '352'),
(137, 'LV', 0, 'Latvia', NULL, NULL, '371'),
(138, 'LY', 0, 'Libya', NULL, NULL, '218'),
(139, 'MA', 0, 'Morocco', NULL, NULL, '212'),
(140, 'MC', 0, 'Monaco', NULL, NULL, '377'),
(141, 'MD', 0, 'Moldova', NULL, NULL, '373'),
(142, 'ME', 0, 'Montenegro', NULL, NULL, '382'),
(143, 'MF', 0, 'Saint Martin', NULL, NULL, '590'),
(144, 'MG', 0, 'Madagascar', NULL, NULL, '261'),
(145, 'MH', 0, 'Marshall Islands', NULL, NULL, '692'),
(146, 'MK', 0, 'Macedonia', NULL, NULL, '389'),
(147, 'ML', 0, 'Mali', NULL, NULL, '223'),
(148, 'MM', 0, 'Myanmar', NULL, NULL, '95'),
(149, 'MN', 0, 'Mongolia', NULL, NULL, '976'),
(150, 'MO', 0, 'Macao', NULL, NULL, '853'),
(151, 'MP', 0, 'Northern Mariana Islands', NULL, NULL, '1670'),
(152, 'MQ', 0, 'Martinique', NULL, NULL, '596'),
(153, 'MR', 0, 'Mauritania', NULL, NULL, '222'),
(154, 'MS', 0, 'Montserrat', NULL, NULL, '1664'),
(155, 'MT', 0, 'Malta', NULL, NULL, '356'),
(156, 'MU', 0, 'Mauritius', NULL, NULL, '230'),
(157, 'MV', 0, 'Maldives', NULL, NULL, '960'),
(158, 'MW', 0, 'Malawi', NULL, NULL, '265'),
(159, 'MX', 0, 'Mexico', NULL, NULL, '52'),
(160, 'MY', 1, 'Malaysia', '马来西亚', '馬來西亞', '60'),
(161, 'MZ', 0, 'Mozambique', NULL, NULL, '258'),
(162, 'NA', 0, 'Namibia', NULL, NULL, '264'),
(163, 'NC', 0, 'New Caledonia', NULL, NULL, '687'),
(164, 'NE', 0, 'Niger', NULL, NULL, '227'),
(165, 'NF', 0, 'Norfolk Island', NULL, NULL, '672'),
(166, 'NG', 0, 'Nigeria', NULL, NULL, '234'),
(167, 'NI', 0, 'Nicaragua', NULL, NULL, '505'),
(168, 'NL', 0, 'Netherlands', NULL, NULL, '31'),
(169, 'NO', 0, 'Norway', NULL, NULL, '47'),
(170, 'NP', 0, 'Nepal', NULL, NULL, '977'),
(171, 'NR', 0, 'Nauru', NULL, NULL, '674'),
(172, 'NU', 0, 'Niue', NULL, NULL, '683'),
(173, 'NZ', 1, 'New Zealand', NULL, NULL, '684'),
(174, 'OM', 0, 'Oman', NULL, NULL, '968'),
(175, 'PA', 0, 'Panama', NULL, NULL, '507'),
(176, 'PE', 0, 'Peru', NULL, NULL, '51'),
(177, 'PF', 0, 'French Polynesia', NULL, NULL, '689'),
(178, 'PG', 0, 'Papua New Guinea', NULL, NULL, '675'),
(179, 'PH', 0, 'Philippines', NULL, NULL, '63'),
(180, 'PK', 0, 'Pakistan', NULL, NULL, '92'),
(181, 'PL', 0, 'Poland', NULL, NULL, '48'),
(182, 'PM', 0, 'Saint Pierre and Miquelon', NULL, NULL, '508'),
(183, 'PN', 0, 'Pitcairn', NULL, NULL, ''),
(184, 'PR', 0, 'Puerto Rico', NULL, NULL, '1'),
(185, 'PS', 0, 'Palestinian Territory', NULL, NULL, ''),
(186, 'PT', 0, 'Portugal', NULL, NULL, '351'),
(187, 'PW', 0, 'Palau', NULL, NULL, '680'),
(188, 'PY', 0, 'Paraguay', NULL, NULL, '595'),
(189, 'QA', 0, 'Qatar', NULL, NULL, '974'),
(190, 'RE', 0, 'Reunion', NULL, NULL, '262'),
(191, 'RO', 0, 'Romania', NULL, NULL, '40'),
(192, 'RS', 0, 'Serbia', NULL, NULL, '381'),
(193, 'RU', 0, 'Russia', NULL, NULL, '7'),
(194, 'RW', 0, 'Rwanda', NULL, NULL, '250'),
(195, 'SA', 0, 'Saudi Arabia', NULL, NULL, '966'),
(196, 'SB', 0, 'Solomon Islands', NULL, NULL, '677'),
(197, 'SC', 0, 'Seychelles', NULL, NULL, '248'),
(198, 'SD', 0, 'Sudan', NULL, NULL, '249'),
(199, 'SE', 0, 'Sweden', NULL, NULL, '46'),
(200, 'SG', 1, 'Singapore', NULL, NULL, '65'),
(201, 'SH', 0, 'Saint Helena', NULL, NULL, '290'),
(202, 'SI', 0, 'Slovenia', NULL, NULL, '386'),
(203, 'SJ', 0, 'Svalbard and Jan Mayen', NULL, NULL, ''),
(204, 'SK', 0, 'Slovakia', NULL, NULL, '421'),
(205, 'SL', 0, 'Sierra Leone', NULL, NULL, '232'),
(206, 'SM', 0, 'San Marino', NULL, NULL, '378'),
(207, 'SN', 0, 'Senegal', NULL, NULL, '221'),
(208, 'SO', 0, 'Somalia', NULL, NULL, '252'),
(209, 'SR', 0, 'Suriname', NULL, NULL, '597'),
(210, 'SS', 0, 'South Sudan', NULL, NULL, '211'),
(211, 'ST', 0, 'Sao Tome and Principe', NULL, NULL, '239'),
(212, 'SV', 0, 'El Salvador', NULL, NULL, '503'),
(213, 'SX', 0, 'Sint Maarten', NULL, NULL, '1721'),
(214, 'SY', 0, 'Syria', NULL, NULL, '963'),
(215, 'SZ', 0, 'Swaziland', NULL, NULL, '268'),
(216, 'TC', 0, 'Turks and Caicos Islands', NULL, NULL, '1649'),
(217, 'TD', 0, 'Chad', NULL, NULL, '235'),
(218, 'TF', 0, 'French Southern Territories', NULL, NULL, ''),
(219, 'TG', 0, 'Togo', NULL, NULL, '228'),
(220, 'TH', 1, 'Thailand', NULL, NULL, '66'),
(221, 'TJ', 0, 'Tajikistan', NULL, NULL, '992'),
(222, 'TK', 0, 'Tokelau', NULL, NULL, '690'),
(223, 'TL', 0, 'East Timor', NULL, NULL, ''),
(224, 'TM', 0, 'Turkmenistan', NULL, NULL, ''),
(225, 'TN', 0, 'Tunisia', NULL, NULL, '216'),
(226, 'TO', 0, 'Tonga', NULL, NULL, '676'),
(227, 'TR', 0, 'Turkey', NULL, NULL, '90'),
(228, 'TT', 0, 'Trinidad and Tobago', NULL, NULL, '1868'),
(229, 'TV', 0, 'Tuvalu', NULL, NULL, '688'),
(230, 'TW', 1, 'Taiwan', NULL, NULL, '886'),
(231, 'TZ', 0, 'Tanzania', NULL, NULL, '255'),
(232, 'UA', 0, 'Ukraine', NULL, NULL, '380'),
(233, 'UG', 0, 'Uganda', NULL, NULL, '256'),
(234, 'UM', 0, 'United States Minor Outlying Islands', NULL, NULL, ''),
(235, 'US', 1, 'United States', NULL, NULL, '1'),
(236, 'UY', 0, 'Uruguay', NULL, NULL, '598'),
(237, 'UZ', 0, 'Uzbekistan', NULL, NULL, '998'),
(238, 'VA', 0, 'Vatican', NULL, NULL, '39'),
(239, 'VC', 0, 'Saint Vincent and the Grenadines', NULL, NULL, '1784'),
(240, 'VE', 0, 'Venezuela', NULL, NULL, '58'),
(241, 'VG', 0, 'British Virgin Islands', NULL, NULL, '1284'),
(242, 'VI', 0, 'U.S. Virgin Islands', NULL, NULL, ''),
(243, 'VN', 1, 'Vietnam', NULL, NULL, '84'),
(244, 'VU', 0, 'Vanuatu', NULL, NULL, '678'),
(245, 'WF', 0, 'Wallis and Futuna', NULL, NULL, '681'),
(246, 'WS', 0, 'Samoa', NULL, NULL, '685'),
(247, 'XK', 0, 'Kosovo', NULL, NULL, ''),
(248, 'YE', 0, 'Yemen', NULL, NULL, '967'),
(249, 'YT', 0, 'Mayotte', NULL, NULL, ''),
(250, 'ZA', 0, 'South Africa', NULL, NULL, '27'),
(251, 'ZM', 0, 'Zambia', NULL, NULL, '260'),
(252, 'ZW', 0, 'Zimbabwe', NULL, NULL, '263');

-- --------------------------------------------------------

--
-- Table structure for table `topup_transactions`
--

CREATE TABLE `topup_transactions` (
  `id` int(11) NOT NULL,
  `topup_no` varchar(191) DEFAULT NULL,
  `user_id` varchar(191) CHARACTER SET latin1 DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `amount_desc` text DEFAULT NULL,
  `actual_amount` double DEFAULT NULL,
  `topup_payment_method` int(11) DEFAULT NULL,
  `bank_slip` varchar(191) DEFAULT NULL,
  `topup_type` int(11) DEFAULT NULL COMMENT '1 = product wallet\r\n2 = affiliate topup',
  `upgrade_agent` int(11) DEFAULT NULL COMMENT '1 = customer upgrade agent',
  `charges_type` varchar(191) DEFAULT NULL,
  `charges_amount` double DEFAULT NULL,
  `new_agent` int(11) DEFAULT NULL,
  `created_by` varchar(191) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `topup_transactions`
--

INSERT INTO `topup_transactions` (`id`, `topup_no`, `user_id`, `package_id`, `amount`, `amount_desc`, `actual_amount`, `topup_payment_method`, `bank_slip`, `topup_type`, `upgrade_agent`, `charges_type`, `charges_amount`, `new_agent`, `created_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'T160696913100001', 'M000001', 3, 5200, 'RM 4000 + (RM 1200)', 4000, 2, 'uploads/bank_slip/3379a1cf79de51f394ab3166c6ff9278.png', 2, 1, NULL, NULL, NULL, 'Mb000001', 1, '2020-12-03 04:18:51', '2020-12-03 04:20:12'),
(2, 'T160697125000002', 'M000002', 2, 2500, 'RM 2000 + (RM 500)', 2000, 2, 'uploads/bank_slip/5844d0d48a31e990df9be1fec4828865.png', 2, 1, NULL, NULL, NULL, 'Mb000002', 1, '2020-12-03 04:54:10', '2020-12-03 04:54:28'),
(3, 'T160697465400003', 'M000001', 2, 2500, 'RM 2000 + (RM 500)', 2000, NULL, NULL, 2, NULL, NULL, NULL, NULL, 'AD000001', 1, '2020-12-03 05:50:54', '2020-12-03 05:50:54'),
(4, 'T160697505400004', 'M000002', 1, 1200, 'RM 1000 + (RM 200)', 1000, NULL, NULL, 2, NULL, NULL, NULL, NULL, 'AD000001', 1, '2020-12-03 05:57:34', '2020-12-03 05:57:34'),
(5, 'T160705847100005', 'M000001', 1, 1200, 'RM 1000 + (RM 200)', 1000, 2, 'uploads/bank_slip/M000001/a0ee0410ecbfc28555e380cdbf3e30ef.jpg', 2, NULL, NULL, NULL, 1, NULL, 1, '2020-12-04 05:07:51', '2020-12-04 05:20:24'),
(6, 'T160705868200006', 'M000002', 1, 1200, 'RM 1000 + (RM 200)', 1000, 2, 'uploads/bank_slip/M000002/12bfc8a93aa91bded1e15baa0276dc94.jpg', 2, NULL, NULL, NULL, 1, NULL, 1, '2020-12-04 05:11:22', '2020-12-04 05:17:16'),
(7, 'T160816842000007', 'M000003', 2, 2500, 'RM 2000 + (RM 500)', 2000, 2, NULL, 2, NULL, NULL, NULL, NULL, 'AD000001', 1, '2020-12-17 01:27:00', '2020-12-17 01:27:00'),
(8, 'T160818091000008', 'M000004', 1, 1200, 'RM 1000 + (RM 200)', 1000, 2, 'uploads/bank_slip/M000004/e21ab130bbb104bb41048679f166fb93.jpg', 2, NULL, NULL, NULL, 1, NULL, 1, '2020-12-17 04:55:10', '2020-12-17 04:56:25'),
(9, 'T160818160500009', 'M000005', 1, 1200, 'RM 1000 + (RM 200)', 1000, 2, 'uploads/bank_slip/M000005/dbf5fe669afe27a6554de2da9d6252a1.jpg', 2, NULL, NULL, NULL, 1, NULL, 1, '2020-12-17 05:06:45', '2020-12-17 05:06:53'),
(10, 'T160818183700010', 'M000006', 1, 1200, 'RM 1000 + (RM 200)', 1000, 2, 'uploads/bank_slip/M000006/9114bc259236db77baf490dcc2cf6521.jpg', 2, NULL, NULL, NULL, 1, NULL, 1, '2020-12-17 05:10:37', '2020-12-17 05:10:49'),
(11, 'T160818467000011', 'M000003', 1, 110, 'RM 100 + (RM 10)', 100, 2, 'uploads/bank_slip/M000003/6e1b84c86e043e66aa9a86e452d2023b.jpg', 1, NULL, NULL, NULL, NULL, 'M000003', 1, '2020-12-17 05:57:50', '2020-12-17 05:58:20'),
(12, 'T160869019300012', 'M000007', 2, 2500, 'RM 2000 + (RM 500)', 2000, 2, NULL, 2, NULL, NULL, NULL, NULL, 'AD000001', 1, '2020-12-23 02:23:13', '2020-12-23 02:23:13'),
(13, 'T160869034900013', 'M000008', 2, 2500, 'RM 2000 + (RM 500)', 2000, 2, 'uploads/bank_slip/M000008/48c96cdfbdf0bfc7a9aa96dbe7f26762.jpg', 2, NULL, NULL, NULL, 1, NULL, 1, '2020-12-23 02:25:49', '2020-12-23 02:29:15'),
(14, 'T160869071100014', 'M000009', 2, 2500, 'RM 2000 + (RM 500)', 2000, 2, 'uploads/bank_slip/M000009/8e780cc4e563e48208d81808f2681571.jpg', 2, NULL, NULL, NULL, 1, NULL, 1, '2020-12-23 02:31:51', '2020-12-23 02:32:31'),
(15, 'T160869091300015', 'M000011', 2, 2500, 'RM 2000 + (RM 500)', 2000, 2, NULL, 2, NULL, NULL, NULL, NULL, 'AD000001', 1, '2020-12-23 02:35:13', '2020-12-23 02:35:13'),
(16, 'T160869168700016', 'M000016', 2, 2500, 'RM 2000 + (RM 500)', 2000, 2, NULL, 2, NULL, NULL, NULL, NULL, 'AD000001', 1, '2020-12-23 02:48:07', '2020-12-23 02:48:07'),
(17, 'T160869174300017', 'M000017', 2, 2500, 'RM 2000 + (RM 500)', 2000, 2, NULL, 2, NULL, NULL, NULL, NULL, 'AD000001', 1, '2020-12-23 02:49:03', '2020-12-23 02:49:03'),
(18, 'T160869188800018', 'M000019', 2, 2500, 'RM 2000 + (RM 500)', 2000, 2, NULL, 2, NULL, NULL, NULL, NULL, 'AD000001', 1, '2020-12-23 02:51:28', '2020-12-23 02:51:28'),
(19, 'T160869204600019', 'M000021', 3, 5200, 'RM 4000 + (RM 1200)', 4000, 2, NULL, 2, NULL, NULL, NULL, NULL, 'AD000001', 1, '2020-12-23 02:54:06', '2020-12-23 02:54:06'),
(20, 'T160869211200020', 'M000022', 2, 2500, 'RM 2000 + (RM 500)', 2000, 2, NULL, 2, NULL, NULL, NULL, NULL, 'AD000001', 1, '2020-12-23 02:55:12', '2020-12-23 02:55:12'),
(21, 'T160869222800021', 'M000023', 2, 2500, 'RM 2000 + (RM 500)', 2000, 2, NULL, 2, NULL, NULL, NULL, NULL, 'AD000001', 1, '2020-12-23 02:57:08', '2020-12-23 02:57:08'),
(22, 'T160869244600022', 'M000024', 2, 2500, 'RM 2000 + (RM 500)', 2000, 2, 'uploads/bank_slip/M000024/e6cd89f5e13baa1e44e987f70371ac35.jpg', 2, NULL, NULL, NULL, 1, NULL, 1, '2020-12-23 03:00:46', '2020-12-23 03:01:10');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `guest_agent` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mall` int(11) DEFAULT NULL,
  `transaction_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `discount_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_total` double DEFAULT NULL,
  `ad_discount` double DEFAULT NULL,
  `discount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `processing_fee` double DEFAULT 0,
  `tax` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_fee` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grand_total` double DEFAULT NULL,
  `address_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postcode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_id` int(11) DEFAULT NULL,
  `cdm_bank_id` int(11) DEFAULT NULL,
  `bank_slip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_slip_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `to_receive` tinyint(4) DEFAULT NULL,
  `completed` tinyint(4) DEFAULT NULL,
  `transaction_type` int(11) DEFAULT NULL,
  `transaction_to` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `order_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tracking_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parcel_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `courier` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `courier_logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `awb_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deduct_wallet` int(11) DEFAULT NULL,
  `transaction_charges_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_charges_amount` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `guest_agent`, `mall`, `transaction_no`, `user_id`, `weight`, `discount_code`, `sub_total`, `ad_discount`, `discount`, `processing_fee`, `tax`, `shipping_fee`, `grand_total`, `address_name`, `address`, `postcode`, `city`, `state`, `country`, `phone`, `email`, `bank_id`, `cdm_bank_id`, `bank_slip`, `bank_slip_no`, `remark`, `status`, `to_receive`, `completed`, `transaction_type`, `transaction_to`, `created_at`, `updated_at`, `order_number`, `tracking_no`, `parcel_number`, `courier`, `courier_logo`, `awb_no`, `deduct_wallet`, `transaction_charges_type`, `transaction_charges_amount`) VALUES
(1, NULL, NULL, '160816860900001', 'Mb000002', 0.1, NULL, 48, NULL, '0', 0, NULL, '10', 58, 'asdasd ', 'asdasd', '123123', '123', '1', NULL, '1231231232', 'agenta@gmail.com', NULL, 10000743, 'uploads/bank_slip/Mb000002/4f4585ea6e88393c24f5e0d1260d0208.png', NULL, NULL, 1, 1, 1, NULL, NULL, '2020-12-17 01:30:09', '2020-12-17 03:50:28', NULL, NULL, NULL, 'sdvb', NULL, 'EHA140780625MY', 1, 'Percentage', 6),
(2, NULL, 1, '160817673000002', 'M000003', 0.2, NULL, 40, NULL, '0', 0, NULL, '10', 50, 'daniel daniel ', '123123', '654', '65', '7', NULL, '0174120696', 'darksoulz1021@hotmail.com', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, '2020-12-17 03:45:30', '2020-12-17 05:37:47', NULL, NULL, NULL, 'sdbfdngfmh', NULL, 'EHA140780625MY', NULL, NULL, NULL),
(3, NULL, NULL, '165555477400003', 'AD000001', 0, NULL, 0, NULL, '0', 0, NULL, '0', 0, 'Sarvesh ', 'No,32', '33000', 'Kuala kangsar', '9', NULL, '+60174097028', 'naruto@gmail.com', 2, 10000743, NULL, NULL, NULL, 95, NULL, NULL, NULL, NULL, '2022-06-18 12:19:34', '2022-06-18 12:31:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, NULL, NULL, '165555520600004', 'AD000001', 0, NULL, 0, NULL, '0', 0, NULL, '0', 0, 'Sarvesh ', 'No,32', '33000', 'Kuala kangsar', '9', NULL, '+60174097028', 'naruto@gmail.com', NULL, 10000743, 'uploads/bank_slip/AD000001/7ebbe2157407a156c2f1a738dfbcf909.jpg', NULL, NULL, 95, NULL, NULL, NULL, NULL, '2022-06-18 12:26:46', '2022-06-18 12:31:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, NULL, NULL, '165555527000005', 'AD000001', 0, NULL, 0, NULL, '0', 0, NULL, '0', 0, 'Sarvesh ', 'No,32', '33000', 'Kuala kangsar', '9', NULL, '+60174097028', 'naruto@gmail.com', NULL, 10000743, 'uploads/bank_slip/AD000001/61c51647f463321f0d75d1213423f6d1.jpg', NULL, NULL, 95, NULL, NULL, NULL, NULL, '2022-06-18 12:27:50', '2022-06-18 12:31:48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, NULL, NULL, '165555535200006', 'AD000001', 0, NULL, 0, NULL, '0', 0, NULL, '0', 0, 'Sarvesh ', 'No,32', '33000', 'Kuala kangsar', '9', NULL, '+60174097028', 'naruto@gmail.com', NULL, 10000743, 'uploads/bank_slip/AD000001/62cfffc1ec20933f321a4c29e4a21e84.jpg', NULL, NULL, 95, NULL, NULL, NULL, NULL, '2022-06-18 12:29:12', '2022-06-18 12:31:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, NULL, NULL, '165694493400007', 'AD000001', 0, NULL, 0, NULL, '0', 0, NULL, '0', 0, 'Sarvesh ', 'No,32', '33000', 'Kuala kangsar', '9', NULL, '+60174097028', 'naruto@gmail.com', NULL, 10000743, 'uploads/bank_slip/AD000001/8885c08fa3bac53ee53a4831b22822ec.png', NULL, NULL, 1, 1, 1, NULL, NULL, '2022-07-04 14:28:54', '2022-07-04 15:16:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_details`
--

CREATE TABLE `transaction_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `variation_id` int(11) DEFAULT NULL,
  `item_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_weight` double DEFAULT NULL,
  `sub_category` varchar(191) CHARACTER SET utf8 DEFAULT NULL,
  `second_sub_category` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_name` varchar(191) CHARACTER SET utf8 DEFAULT NULL,
  `unit_price` double DEFAULT NULL,
  `product_comm_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_comm_amount` double DEFAULT NULL,
  `own_product_comm_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `own_product_comm_amount` double DEFAULT NULL,
  `quantity` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deduct_qty` double DEFAULT NULL,
  `total_amount` double DEFAULT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction_details`
--

INSERT INTO `transaction_details` (`id`, `transaction_id`, `product_image`, `product_id`, `variation_id`, `item_code`, `product_code`, `unit_weight`, `sub_category`, `second_sub_category`, `product_name`, `unit_price`, `product_comm_type`, `product_comm_amount`, `own_product_comm_type`, `own_product_comm_amount`, `quantity`, `deduct_qty`, `total_amount`, `status`, `created_at`, `updated_at`) VALUES
(1, '1', 'uploads/11/b11992314fc6744997e8766d1694c377.png', '11', NULL, 'CONTORNO001', NULL, 0.1, NULL, NULL, 'Body Shaping Cream', 48, NULL, NULL, '', 0, '1', NULL, 48, 1, '2020-12-17 01:30:09', '2020-12-17 01:30:09'),
(2, '2', 'uploads/11/b11992314fc6744997e8766d1694c377.png', '11', NULL, 'CONTORNO001', NULL, 0.1, NULL, NULL, 'Body Shaping Cream', 20, NULL, NULL, NULL, NULL, '2', NULL, 96, 1, '2020-12-17 03:45:33', '2020-12-17 03:45:33'),
(3, '3', 'uploads/17/f2f1e29c3b3a4e8beda76c18b5849a06.jpg', '17', NULL, 'Fitness Plans001', NULL, 0, NULL, NULL, 'Alpha M\'s Tailored: 6 Weeks to Living Lean', 0, NULL, NULL, '', 0, '1', NULL, 105, 1, '2022-06-18 12:19:34', '2022-06-18 12:19:34'),
(4, '4', 'uploads/18/af268696689074dfc4680a9b61a44c37.jpg', '18', NULL, 'Diet Plans002', NULL, 0, NULL, NULL, 'CHARGRILLED PIECES WITH CREAMY BUTTER SAUCE', 0, NULL, NULL, '', 0, '1', NULL, 40, 1, '2022-06-18 12:26:46', '2022-06-18 12:26:46'),
(5, '5', 'uploads/18/af268696689074dfc4680a9b61a44c37.jpg', '18', NULL, 'Diet Plans002', NULL, 0, NULL, NULL, 'CHARGRILLED PIECES WITH CREAMY BUTTER SAUCE', 0, NULL, NULL, '', 0, '1', NULL, 40, 1, '2022-06-18 12:27:50', '2022-06-18 12:27:50'),
(6, '6', 'uploads/18/af268696689074dfc4680a9b61a44c37.jpg', '18', NULL, 'Diet Plans002', NULL, 0, NULL, NULL, 'CHARGRILLED PIECES WITH CREAMY BUTTER SAUCE', 0, NULL, NULL, '', 0, '1', NULL, 40, 1, '2022-06-18 12:29:12', '2022-06-18 12:29:12'),
(7, '7', 'uploads/17/f2f1e29c3b3a4e8beda76c18b5849a06.jpg', '17', NULL, 'Fitness Plans001', NULL, 0, NULL, NULL, 'Alpha M\'s Tailored: 6 Weeks to Living Lean', 0, NULL, NULL, '', 0, '1', NULL, 105, 1, '2022-07-04 14:28:54', '2022-07-04 14:28:54');

-- --------------------------------------------------------

--
-- Table structure for table `transfer_product_wallets`
--

CREATE TABLE `transfer_product_wallets` (
  `id` int(11) NOT NULL,
  `transfer_pw` tinyint(4) DEFAULT 1,
  `user_id` varchar(191) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `actual_amount` double DEFAULT NULL,
  `charges_type` varchar(191) DEFAULT NULL,
  `charges_amount` double DEFAULT NULL,
  `created_by` varchar(191) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `master_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dual_master_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `f_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `l_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lvl` int(11) DEFAULT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 99,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `country_code`, `master_id`, `dual_master_id`, `code`, `email`, `password`, `f_name`, `l_name`, `gender`, `dob`, `phone`, `lvl`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '60', 'AD000001', NULL, 'Mb000001', 'darksoulz1021@hotmail.com', '$2y$10$8QcNtInllCrriM.e9JfgzOxIkVfzrx/DcHti3Uczm8lUGrg1EKXx2', 'daniel daniel', '', NULL, NULL, '0174120696', NULL, 1, NULL, '2020-12-17 01:16:37', '2021-12-11 17:39:50'),
(2, '60', 'M000003', NULL, 'Mb000002', 'jkl@gmail.com', '$2y$10$eyGjZjeBMvxXJyIWAp665OjOzLY9vsjuNZHbCcdIVBl9dwkFtq9V.', 'jkl', '', NULL, NULL, '5768756765', NULL, 1, NULL, '2020-12-17 01:29:17', '2020-12-17 01:29:42'),
(3, '60', 'AD000001', NULL, 'Mb000003', 'AA01@AA', '$2y$10$TwxQTT9TAXvyAuaQDLV0J.6hBIhYRaY77fe0sjBWD9u51SnF3OSQS', 'AA01', '', '', NULL, '11', NULL, 1, NULL, '2020-12-23 02:19:40', '2020-12-23 02:19:40'),
(4, '60', 'M000002', NULL, '12315', 'tester34@gmail.com', '$2y$10$jsd2LYODc7uOZpM.H02eQOWrjaGpAXk0lrr87lGTJc3AWDtYpkFu.', 'Tester', '', NULL, NULL, '1223456789', NULL, 1, 'tzsEJodnkt9JS7S3yAxdAYcU2OoKYdaTN3NoQV2ZSPzAQbXmYjDnMviXDwVf', '2022-07-05 02:45:19', '2022-07-05 02:45:53');

-- --------------------------------------------------------

--
-- Table structure for table `user_shipping_addresses`
--

CREATE TABLE `user_shipping_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `f_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `l_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postcode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_shipping_addresses`
--

INSERT INTO `user_shipping_addresses` (`id`, `user_id`, `default`, `f_name`, `l_name`, `email`, `phone`, `address`, `country`, `state`, `city`, `postcode`, `status`, `created_at`, `updated_at`) VALUES
(1, 'M000003', '1', 'daniel daniel', NULL, 'darksoulz1021@hotmail.com', '0174120696', '123123', NULL, '7', '65', '654', 1, '2020-12-17 01:27:42', '2020-12-17 01:27:42'),
(2, 'Mb000002', '1', 'asdasd', NULL, 'agenta@gmail.com', '1231231232', 'asdasd', NULL, '1', '123', '123123', 1, '2020-12-17 01:28:28', '2020-12-17 01:29:59'),
(3, '1608176330306239', '1', 'Zack Teoh', NULL, 'sonezack5577@gmail.com', '0174194868', '30-05-09 pangsapuri sri abadi', NULL, '8', 'Bayan lepas', '11900', 1, '2020-12-17 03:39:04', '2020-12-17 03:39:04'),
(4, '1608177424794783', '1', 'Zack Teoh', NULL, 'sonezack5577@gmail.com', '0174194868', '30-05-09 pangsapuri sri abadi', NULL, '8', 'Bayan lepas', '11900', 1, '2020-12-17 03:59:06', '2020-12-17 03:59:06'),
(5, 'M000003', '1', 'Zack Teoh', NULL, 'sonezack5577@gmail.com', '0174194868', '30-05-09 pangsapuri sri abadi', NULL, '8', 'Bayan lepas', '11900', 1, '2020-12-17 04:27:44', '2020-12-17 04:30:10'),
(6, 'M000003', '1', 'Admin Tan Xiang', NULL, 'admin@razer.com', '+10175942686', '68 taman sentosa', NULL, '3', 'sungai petani', '08000', 1, '2020-12-17 04:32:03', '2020-12-17 04:47:45'),
(7, 'M000003', '1', 'Staff One', NULL, 'staff1@gmail.com', '0174194868', 'uiy', NULL, '1', '123', '123', 1, '2021-01-06 08:33:55', '2021-01-06 08:40:55'),
(8, 'AD000001', '1', 'Sarvesh', NULL, 'naruto@gmail.com', '+60174097028', 'No,32', NULL, '9', 'Kuala kangsar', '33000', 1, '2022-06-18 12:19:01', '2022-06-18 12:19:01');

-- --------------------------------------------------------

--
-- Table structure for table `verify_codes`
--

CREATE TABLE `verify_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `verify_codes`
--

INSERT INTO `verify_codes` (`id`, `phone`, `code`, `status`, `created_at`, `updated_at`) VALUES
(2, '0193537580', '932660', 1, '2020-06-23 05:19:45', '2020-06-23 05:19:45'),
(3, '0166204627', '247923', 1, '2020-06-23 05:22:18', '2020-06-23 05:22:18'),
(4, '0162660946', '845692', 1, '2020-06-23 05:26:11', '2020-06-23 05:26:11'),
(6, '0193169336', '222263', 1, '2020-06-23 05:55:59', '2020-06-23 05:55:59'),
(9, '0123381784', '265595', 1, '2020-06-23 06:00:07', '2020-06-23 06:00:07'),
(10, '0126585873', '973115', 1, '2020-06-23 06:01:08', '2020-06-23 06:01:08'),
(11, '0162858878', '838678', 1, '2020-06-23 06:05:57', '2020-06-23 06:05:57'),
(12, '0123871096', '590705', 1, '2020-06-23 06:12:24', '2020-06-23 06:12:24'),
(14, '0123210128', '883413', 1, '2020-06-23 06:58:49', '2020-06-23 06:58:49'),
(15, '0102210496', '736321', 1, '2020-06-23 07:01:12', '2020-06-23 07:01:12'),
(19, '0166233659', '333302', 1, '2020-06-23 07:35:33', '2020-06-23 07:35:33'),
(20, '60162701392', '605403', 1, '2020-06-23 07:37:12', '2020-06-23 07:37:12'),
(22, '0122671277', '604650', 1, '2020-06-23 07:39:24', '2020-06-23 07:39:24'),
(23, '0162859955', '249122', 1, '2020-06-23 07:41:39', '2020-06-23 07:41:39'),
(25, '0122033418', '327207', 1, '2020-06-23 07:49:25', '2020-06-23 07:49:25'),
(26, '60103666770', '992953', 1, '2020-06-23 07:54:35', '2020-06-23 07:54:35'),
(27, '0125608360', '890153', 1, '2020-06-23 08:08:15', '2020-06-23 08:08:15'),
(28, '0122352723', '250344', 1, '2020-06-23 08:17:14', '2020-06-23 08:17:14'),
(29, '0132790927', '176113', 1, '2020-06-23 09:52:12', '2020-06-23 09:52:12'),
(30, '0143343140', '146426', 1, '2020-06-23 10:52:21', '2020-06-23 10:52:21'),
(31, '0122328616', '510556', 1, '2020-06-23 11:22:58', '2020-06-23 11:22:58'),
(32, '0122971811', '548265', 1, '2020-06-23 11:42:46', '2020-06-23 11:42:46'),
(33, '0163536616', '863757', 1, '2020-06-23 11:53:06', '2020-06-23 11:53:06'),
(34, '0123756802', '281832', 1, '2020-06-23 13:47:31', '2020-06-23 13:47:31'),
(35, '0162637762', '492033', 1, '2020-06-23 14:44:21', '2020-06-23 14:44:21'),
(36, '0122064264', '769907', 1, '2020-06-24 05:56:08', '2020-06-24 05:56:08'),
(41, '0123910906', '942862', 1, '2020-06-24 07:27:20', '2020-06-24 07:27:20'),
(45, '162701392', '453353', 1, '2020-06-24 07:58:22', '2020-06-24 07:58:22'),
(46, '174194868', '277528', 1, '2020-06-24 07:59:17', '2020-06-24 07:59:17'),
(50, '0165172661', '421734', 1, '2020-06-24 08:26:07', '2020-06-24 08:26:07'),
(52, '0165208021', '519491', 1, '2020-06-24 08:30:09', '2020-06-24 08:30:09'),
(54, '0163419848', '901531', 1, '2020-06-24 08:35:56', '2020-06-24 08:35:56'),
(56, '0172642199', '645364', 1, '2020-06-24 09:00:44', '2020-06-24 09:00:44'),
(57, '0192123863', '977310', 1, '2020-06-24 09:38:18', '2020-06-24 09:38:18'),
(58, '0162233687', '960021', 1, '2020-06-24 10:08:52', '2020-06-24 10:08:52'),
(59, '0178925431', '736835', 1, '2020-06-24 11:03:05', '2020-06-24 11:03:05'),
(60, '0184740574', '528633', 1, '2020-06-24 11:52:49', '2020-06-24 11:52:49'),
(61, '0182921136', '427804', 1, '2020-06-24 14:24:55', '2020-06-24 14:24:55'),
(62, '0123240864', '161901', 1, '2020-06-25 00:50:29', '2020-06-25 00:50:29'),
(63, '0129323866', '785567', 1, '2020-06-25 01:52:10', '2020-06-25 01:52:10'),
(64, '174120696', '790476', 1, '2020-06-25 02:01:45', '2020-06-25 02:01:45'),
(65, '0174120696', '281079', 1, '2020-06-25 02:04:13', '2020-06-25 02:04:13'),
(66, '0189892887', '209818', 1, '2020-06-25 03:33:38', '2020-06-25 03:33:38'),
(67, '122367938', '814144', 1, '2020-06-25 03:34:59', '2020-06-25 03:34:59'),
(68, '0133697616', '107440', 1, '2020-06-25 03:40:51', '2020-06-25 03:40:51'),
(69, '0122310448', '178363', 1, '2020-06-25 05:41:06', '2020-06-25 05:41:06'),
(70, '0162701392', '550612', 1, '2020-06-25 05:57:20', '2020-06-25 05:57:20'),
(73, '0122396065', '358194', 1, '2020-06-25 06:56:44', '2020-06-25 06:56:44'),
(74, '0122077377', '734680', 1, '2020-06-25 09:17:12', '2020-06-25 09:17:12'),
(75, '0196686612', '638337', 1, '2020-06-25 10:22:07', '2020-06-25 10:22:07'),
(76, '0102206678', '965499', 1, '2020-06-25 13:34:15', '2020-06-25 13:34:15'),
(77, '0168305301', '173723', 1, '2020-06-25 15:05:54', '2020-06-25 15:05:54'),
(78, '0129202622', '670643', 1, '2020-06-25 21:10:34', '2020-06-25 21:10:34'),
(79, '0162298819', '492227', 1, '2020-06-26 08:39:49', '2020-06-26 08:39:49'),
(81, '0122533950', '824114', 1, '2020-06-27 11:54:54', '2020-06-27 11:54:54'),
(82, '0174194868', '637713', 1, '2020-06-27 13:28:10', '2020-06-27 13:28:10'),
(83, '01139581855', '787373', 1, '2020-06-28 12:34:47', '2020-06-28 12:34:47'),
(85, '0182275888', '223144', 1, '2020-07-01 06:21:57', '2020-07-01 06:21:57'),
(86, '0122822391', '971738', 1, '2020-07-04 08:00:33', '2020-07-04 08:00:33'),
(87, '0197056021', '327353', 1, '2020-07-07 03:50:54', '2020-07-07 03:50:54'),
(88, '0149556068', '357731', 1, '2020-07-07 08:47:44', '2020-07-07 08:47:44'),
(90, '123094063', '767885', 1, '2020-07-07 09:53:58', '2020-07-07 09:53:58'),
(92, '0122316033', '831283', 1, '2020-07-10 04:53:36', '2020-07-10 04:53:36'),
(94, '60123094063', '245115', 1, '2020-07-10 07:16:17', '2020-07-10 07:16:17'),
(95, '0125344799', '528398', 1, '2020-07-11 07:35:18', '2020-07-11 07:35:18');

-- --------------------------------------------------------

--
-- Table structure for table `website_settings`
--

CREATE TABLE `website_settings` (
  `id` int(11) NOT NULL,
  `company_registration_no` varchar(191) DEFAULT NULL,
  `sst_registration_no` varchar(191) DEFAULT NULL,
  `about_us` text DEFAULT NULL,
  `faqs` text CHARACTER SET utf8 DEFAULT NULL,
  `address` text DEFAULT NULL,
  `about_us_image` varchar(191) DEFAULT NULL,
  `contact_us` text DEFAULT NULL,
  `contact_us_image` varchar(191) DEFAULT NULL,
  `contact_whatsapp` varchar(191) DEFAULT NULL,
  `privacy_policy_description` text DEFAULT NULL,
  `return_policy_description` text DEFAULT NULL,
  `shipping_policy_description` text DEFAULT NULL,
  `join_us_description` text DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `website_settings`
--

INSERT INTO `website_settings` (`id`, `company_registration_no`, `sst_registration_no`, `about_us`, `faqs`, `address`, `about_us_image`, `contact_us`, `contact_us_image`, `contact_whatsapp`, `privacy_policy_description`, `return_policy_description`, `shipping_policy_description`, `join_us_description`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, '<p>Please fill in your company details</p>', '<p>Please fill for support</p>', 'No. 20 , 1st Floor, Persiaran Permatang Rawa\r\nBukit Mertajam Wellesley\r\n14000 Bukit Mertajam Pulau Pinang Malaysia', NULL, NULL, NULL, NULL, '<p>1</p>', '<p>2</p>', '<p>3</p>', '<p>Come join our family now</p>', 1, '2020-01-28 14:43:02', '2020-12-02 07:22:36');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawal_transactions`
--

CREATE TABLE `withdrawal_transactions` (
  `id` int(11) NOT NULL,
  `withdrawal_no` varchar(191) DEFAULT NULL,
  `user_id` varchar(191) DEFAULT NULL,
  `bank_name` varchar(191) DEFAULT NULL,
  `bank_holder_name` varchar(191) DEFAULT NULL,
  `bank_account` varchar(191) DEFAULT NULL,
  `amount` varchar(191) DEFAULT NULL,
  `actual_amount` double DEFAULT NULL,
  `charges_type` varchar(191) DEFAULT NULL,
  `charges_amount` double DEFAULT NULL,
  `withdrawal_slip` varchar(191) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `withdrawal_transactions`
--

INSERT INTO `withdrawal_transactions` (`id`, `withdrawal_no`, `user_id`, `bank_name`, `bank_holder_name`, `bank_account`, `amount`, `actual_amount`, `charges_type`, `charges_amount`, `withdrawal_slip`, `status`, `created_at`, `updated_at`) VALUES
(1, 'W160818431600001', 'M000003', 'Maybank', '2342342', '32423412542345', '40', 38, 'Percentage', 5, 'uploads/withdrawal_bank_slip/ce1044a31d1dcb86af944a406ba8bb7e.png', 1, '2020-12-17 05:51:56', '2020-12-17 05:53:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adjust_product_wallets`
--
ALTER TABLE `adjust_product_wallets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_code_unique` (`code`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `affiliates`
--
ALTER TABLE `affiliates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `affiliate_commissions`
--
ALTER TABLE `affiliate_commissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `affiliate_duals`
--
ALTER TABLE `affiliate_duals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agent_levels`
--
ALTER TABLE `agent_levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agent_rebate_histories`
--
ALTER TABLE `agent_rebate_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applied_promotions`
--
ALTER TABLE `applied_promotions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_links`
--
ALTER TABLE `cart_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_images`
--
ALTER TABLE `category_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favourites`
--
ALTER TABLE `favourites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `merchants`
--
ALTER TABLE `merchants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `merchants_code_unique` (`code`),
  ADD UNIQUE KEY `merchants_email_unique` (`email`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `overiding_qualifications`
--
ALTER TABLE `overiding_qualifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package_items`
--
ALTER TABLE `package_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment_banks`
--
ALTER TABLE `payment_banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_level_lists`
--
ALTER TABLE `permission_level_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_ratings`
--
ALTER TABLE `product_ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_variations`
--
ALTER TABLE `product_variations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register_wallets`
--
ALTER TABLE `register_wallets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `search_history`
--
ALTER TABLE `search_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_affiliate_topups`
--
ALTER TABLE `setting_affiliate_topups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_agent_discounts`
--
ALTER TABLE `setting_agent_discounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_banners`
--
ALTER TABLE `setting_banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_banner_testings`
--
ALTER TABLE `setting_banner_testings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_banner_videos`
--
ALTER TABLE `setting_banner_videos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_charges`
--
ALTER TABLE `setting_charges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_downline_bonuses`
--
ALTER TABLE `setting_downline_bonuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_dual_commissions`
--
ALTER TABLE `setting_dual_commissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_dual_mains`
--
ALTER TABLE `setting_dual_mains`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_extra_cash_rebates`
--
ALTER TABLE `setting_extra_cash_rebates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_gallery_images`
--
ALTER TABLE `setting_gallery_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_materials`
--
ALTER TABLE `setting_materials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_merchant_bonuses`
--
ALTER TABLE `setting_merchant_bonuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_merchant_commissions`
--
ALTER TABLE `setting_merchant_commissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_merchant_rebates`
--
ALTER TABLE `setting_merchant_rebates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_monthly_agent_sales_bonuses`
--
ALTER TABLE `setting_monthly_agent_sales_bonuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_performance_dividends`
--
ALTER TABLE `setting_performance_dividends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_performance_mains`
--
ALTER TABLE `setting_performance_mains`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_pick_up_addresses`
--
ALTER TABLE `setting_pick_up_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_pop_up_images`
--
ALTER TABLE `setting_pop_up_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_refferal_rewards`
--
ALTER TABLE `setting_refferal_rewards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_shipping_fees`
--
ALTER TABLE `setting_shipping_fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_team_dividends`
--
ALTER TABLE `setting_team_dividends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_team_mains`
--
ALTER TABLE `setting_team_mains`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_topups`
--
ALTER TABLE `setting_topups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_uoms`
--
ALTER TABLE `setting_uoms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_website_images`
--
ALTER TABLE `setting_website_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_countries`
--
ALTER TABLE `tbl_countries`
  ADD PRIMARY KEY (`country_id`),
  ADD KEY `country_code` (`country_code`),
  ADD KEY `country_name` (`country_name`);

--
-- Indexes for table `topup_transactions`
--
ALTER TABLE `topup_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfer_product_wallets`
--
ALTER TABLE `transfer_product_wallets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_code_unique` (`code`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_shipping_addresses`
--
ALTER TABLE `user_shipping_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `verify_codes`
--
ALTER TABLE `verify_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `website_settings`
--
ALTER TABLE `website_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawal_transactions`
--
ALTER TABLE `withdrawal_transactions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adjust_product_wallets`
--
ALTER TABLE `adjust_product_wallets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `affiliates`
--
ALTER TABLE `affiliates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `affiliate_commissions`
--
ALTER TABLE `affiliate_commissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `affiliate_duals`
--
ALTER TABLE `affiliate_duals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agent_levels`
--
ALTER TABLE `agent_levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `agent_rebate_histories`
--
ALTER TABLE `agent_rebate_histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `applied_promotions`
--
ALTER TABLE `applied_promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `blog_comments`
--
ALTER TABLE `blog_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `cart_links`
--
ALTER TABLE `cart_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `category_images`
--
ALTER TABLE `category_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `favourites`
--
ALTER TABLE `favourites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `merchants`
--
ALTER TABLE `merchants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `overiding_qualifications`
--
ALTER TABLE `overiding_qualifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `package_items`
--
ALTER TABLE `package_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payment_banks`
--
ALTER TABLE `payment_banks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;

--
-- AUTO_INCREMENT for table `permission_level_lists`
--
ALTER TABLE `permission_level_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `product_ratings`
--
ALTER TABLE `product_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_variations`
--
ALTER TABLE `product_variations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `register_wallets`
--
ALTER TABLE `register_wallets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `search_history`
--
ALTER TABLE `search_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `setting_affiliate_topups`
--
ALTER TABLE `setting_affiliate_topups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `setting_agent_discounts`
--
ALTER TABLE `setting_agent_discounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `setting_banners`
--
ALTER TABLE `setting_banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `setting_banner_testings`
--
ALTER TABLE `setting_banner_testings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `setting_banner_videos`
--
ALTER TABLE `setting_banner_videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `setting_charges`
--
ALTER TABLE `setting_charges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `setting_downline_bonuses`
--
ALTER TABLE `setting_downline_bonuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `setting_dual_commissions`
--
ALTER TABLE `setting_dual_commissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `setting_dual_mains`
--
ALTER TABLE `setting_dual_mains`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `setting_extra_cash_rebates`
--
ALTER TABLE `setting_extra_cash_rebates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `setting_gallery_images`
--
ALTER TABLE `setting_gallery_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `setting_materials`
--
ALTER TABLE `setting_materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `setting_merchant_bonuses`
--
ALTER TABLE `setting_merchant_bonuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `setting_merchant_commissions`
--
ALTER TABLE `setting_merchant_commissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `setting_merchant_rebates`
--
ALTER TABLE `setting_merchant_rebates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `setting_monthly_agent_sales_bonuses`
--
ALTER TABLE `setting_monthly_agent_sales_bonuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `setting_performance_dividends`
--
ALTER TABLE `setting_performance_dividends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `setting_performance_mains`
--
ALTER TABLE `setting_performance_mains`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `setting_pick_up_addresses`
--
ALTER TABLE `setting_pick_up_addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `setting_pop_up_images`
--
ALTER TABLE `setting_pop_up_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `setting_refferal_rewards`
--
ALTER TABLE `setting_refferal_rewards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `setting_shipping_fees`
--
ALTER TABLE `setting_shipping_fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `setting_team_dividends`
--
ALTER TABLE `setting_team_dividends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `setting_team_mains`
--
ALTER TABLE `setting_team_mains`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `setting_topups`
--
ALTER TABLE `setting_topups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `setting_uoms`
--
ALTER TABLE `setting_uoms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `setting_website_images`
--
ALTER TABLE `setting_website_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `topup_transactions`
--
ALTER TABLE `topup_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `transaction_details`
--
ALTER TABLE `transaction_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `transfer_product_wallets`
--
ALTER TABLE `transfer_product_wallets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_shipping_addresses`
--
ALTER TABLE `user_shipping_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `verify_codes`
--
ALTER TABLE `verify_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `website_settings`
--
ALTER TABLE `website_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `withdrawal_transactions`
--
ALTER TABLE `withdrawal_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
