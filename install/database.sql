-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2024 at 03:08 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `booking_box`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `username` varchar(40) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `username`, `email_verified_at`, `image`, `password`, `remember_token`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@site.com', 'admin', NULL, '659bfe4c64e811704721996.png', '$2y$10$wlY66NfdpeZeGeVdDr8A4uQ8P5rYbmp5qPD4KevbCHYB324d53bTS', 'xOHuJTJb0IOQh0PpHSKB9DZvmhvAKnZzTfwXAOw19YJkAZWhsb4hM8ABPqri', 1, NULL, '2024-01-08 13:53:16');

-- --------------------------------------------------------

--
-- Table structure for table `admin_notifications`
--

CREATE TABLE `admin_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `owner_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `title` text DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `click_url` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_password_resets`
--

CREATE TABLE `admin_password_resets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(40) DEFAULT NULL,
  `token` varchar(40) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `advertisements`
--

CREATE TABLE `advertisements` (
  `id` bigint(20) NOT NULL,
  `owner_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `url` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `amenities`
--

CREATE TABLE `amenities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bed_types`
--

CREATE TABLE `bed_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booked_rooms`
--

CREATE TABLE `booked_rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `room_type_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `room_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `room_number` varchar(40) DEFAULT NULL,
  `booked_for` date DEFAULT NULL,
  `fare` decimal(28,8) DEFAULT NULL,
  `discount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `tax_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `cancellation_fee` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '1= success/active; 3 = cancelled; 9 = checked Out',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `owner_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `booking_number` varchar(40) DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `guest_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `check_in` date DEFAULT NULL,
  `check_out` date DEFAULT NULL,
  `contact_info` text DEFAULT NULL,
  `total_adult` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `total_child` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `total_discount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `tax_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `booking_fare` decimal(28,8) NOT NULL DEFAULT 0.00000000 COMMENT 'Total of room * nights fare ',
  `service_cost` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `extra_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `extra_charge_subtracted` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `paid_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `cancellation_fee` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `refunded_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `key_status` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '1= success/active; 3 = cancelled; 9 = checked Out',
  `checked_in_at` datetime DEFAULT NULL,
  `checked_out_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_action_histories`
--

CREATE TABLE `booking_action_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `remark` varchar(40) DEFAULT NULL,
  `details` varchar(40) DEFAULT NULL,
  `booking_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `owner_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `action_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_requests`
--

CREATE TABLE `booking_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `owner_id` int(10) UNSIGNED NOT NULL,
  `booking_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `total_adult` int(11) NOT NULL DEFAULT 0,
  `total_child` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `check_in` date DEFAULT NULL,
  `check_out` date DEFAULT NULL,
  `total_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `contact_info` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = request send,\r\n1 = approved,\r\n3 = cancelled; ',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_request_details`
--

CREATE TABLE `booking_request_details` (
  `id` bigint(20) NOT NULL,
  `booking_request_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `room_type_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `number_of_rooms` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `unit_fare` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `tax_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000 COMMENT 'Total tax calculated on discounted total fare',
  `discount` decimal(28,8) NOT NULL DEFAULT 0.00000000 COMMENT 'Total discount',
  `total_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000 COMMENT 'total fare + total tax - total discount',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) NOT NULL,
  `country_id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_popular` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `name` varchar(40) DEFAULT NULL,
  `code` varchar(40) DEFAULT NULL,
  `dial_code` varchar(40) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `code`, `dial_code`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Afghanistan', 'AF', '93', 1, '2023-11-05 13:21:02', '2023-12-26 10:02:55'),
(2, 'Aland Islands', 'AX', '358', 1, '2023-11-05 13:21:02', '2023-12-23 20:45:22'),
(3, 'Albania', 'AL', '355', 1, '2023-11-05 13:21:02', '2023-12-08 00:46:10'),
(4, 'Algeria', 'DZ', '213', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(5, 'AmericanSamoa', 'AS', '1684', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(6, 'Andorra', 'AD', '376', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(7, 'Angola', 'AO', '244', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(8, 'Anguilla', 'AI', '1264', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(9, 'Antarctica', 'AQ', '672', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(10, 'Antigua and Barbuda', 'AG', '1268', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(11, 'Argentina', 'AR', '54', 1, '2023-11-05 13:21:02', '2023-12-13 19:52:48'),
(12, 'Armenia', 'AM', '374', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(13, 'Aruba', 'AW', '297', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(14, 'Australia', 'AU', '61', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(15, 'Austria', 'AT', '43', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(16, 'Azerbaijan', 'AZ', '994', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(17, 'Bahamas', 'BS', '1242', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(18, 'Bahrain', 'BH', '973', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(19, 'Bangladesh', 'BD', '880', 1, '2023-11-05 13:21:02', '2023-12-08 00:46:27'),
(20, 'Barbados', 'BB', '1246', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(21, 'Belarus', 'BY', '375', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(22, 'Belgium', 'BE', '32', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(23, 'Belize', 'BZ', '501', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(24, 'Benin', 'BJ', '229', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(25, 'Bermuda', 'BM', '1441', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(26, 'Bhutan', 'BT', '975', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(27, 'Plurinational State of Bolivia', 'BO', '591', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(28, 'Bosnia and Herzegovina', 'BA', '387', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(29, 'Botswana', 'BW', '267', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(30, 'Brazil', 'BR', '55', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(31, 'British Indian Ocean Territory', 'IO', '246', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(32, 'Brunei Darussalam', 'BN', '673', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(33, 'Bulgaria', 'BG', '359', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(34, 'Burkina Faso', 'BF', '226', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(35, 'Burundi', 'BI', '257', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(36, 'Cambodia', 'KH', '855', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(37, 'Cameroon', 'CM', '237', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(38, 'Canada', 'CA', '1', 1, '2023-11-05 13:21:02', '2023-12-30 08:28:55'),
(39, 'Cape Verde', 'CV', '238', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(40, 'Cayman Islands', 'KY', '345', 1, '2023-11-05 13:21:02', '2023-11-05 13:21:02'),
(41, 'Central African Republic', 'CF', '236', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(42, 'Chad', 'TD', '235', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(43, 'Chile', 'CL', '56', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(44, 'China', 'CN', '86', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(45, 'Christmas Island', 'CX', '61', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(46, 'Cocos (Keeling) Islands', 'CC', '61', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(47, 'Colombia', 'CO', '57', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(48, 'Comoros', 'KM', '269', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(49, 'Congo', 'CG', '242', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(50, 'The Democratic Republic of the Congo', 'CD', '243', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(51, 'Cook Islands', 'CK', '682', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(52, 'Costa Rica', 'CR', '506', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(53, 'Cote d\'Ivoire', 'CI', '225', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(54, 'Croatia', 'HR', '385', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(55, 'Cuba', 'CU', '53', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(56, 'Cyprus', 'CY', '357', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(57, 'Czech Republic', 'CZ', '420', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(58, 'Denmark', 'DK', '45', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(59, 'Djibouti', 'DJ', '253', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(60, 'Dominica', 'DM', '1767', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(61, 'Dominican Republic', 'DO', '1849', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(62, 'Ecuador', 'EC', '593', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(63, 'Egypt', 'EG', '20', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(64, 'El Salvador', 'SV', '503', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(65, 'Equatorial Guinea', 'GQ', '240', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(66, 'Eritrea', 'ER', '291', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(67, 'Estonia', 'EE', '372', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(68, 'Ethiopia', 'ET', '251', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(69, 'Falkland Islands (Malvinas)', 'FK', '500', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(70, 'Faroe Islands', 'FO', '298', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(71, 'Fiji', 'FJ', '679', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(72, 'Finland', 'FI', '358', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(73, 'France', 'FR', '33', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(74, 'French Guiana', 'GF', '594', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(75, 'French Polynesia', 'PF', '689', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(76, 'Gabon', 'GA', '241', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(77, 'Gambia', 'GM', '220', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(78, 'Georgia', 'GE', '995', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(79, 'Germany', 'DE', '49', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(80, 'Ghana', 'GH', '233', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(81, 'Gibraltar', 'GI', '350', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(82, 'Greece', 'GR', '30', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(83, 'Greenland', 'GL', '299', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(84, 'Grenada', 'GD', '1473', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(85, 'Guadeloupe', 'GP', '590', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(86, 'Guam', 'GU', '1671', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(87, 'Guatemala', 'GT', '502', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(88, 'Guernsey', 'GG', '44', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(89, 'Guinea', 'GN', '224', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(90, 'Guinea-Bissau', 'GW', '245', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(91, 'Guyana', 'GY', '595', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(92, 'Haiti', 'HT', '509', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(93, 'Holy See (Vatican City State)', 'VA', '379', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(94, 'Honduras', 'HN', '504', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(95, 'Hong Kong', 'HK', '852', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(96, 'Hungary', 'HU', '36', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(97, 'Iceland', 'IS', '354', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(98, 'India', 'IN', '91', 1, '2023-11-05 13:21:02', '2023-12-08 00:46:38'),
(99, 'Indonesia', 'ID', '62', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(100, 'Iran, Islamic Republic of Persian Gulf', 'IR', '98', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(101, 'Iraq', 'IQ', '964', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(102, 'Ireland', 'IE', '353', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(103, 'Isle of Man', 'IM', '44', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(104, 'Israel', 'IL', '972', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(105, 'Italy', 'IT', '39', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(106, 'Jamaica', 'JM', '1876', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(107, 'Japan', 'JP', '81', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(108, 'Jersey', 'JE', '44', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(109, 'Jordan', 'JO', '962', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(110, 'Kazakhstan', 'KZ', '77', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(111, 'Kenya', 'KE', '254', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(112, 'Kiribati', 'KI', '686', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(113, 'Democratic People\'s Republic of Korea', 'KP', '850', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(114, 'Republic of South Korea', 'KR', '82', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(115, 'Kuwait', 'KW', '965', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(116, 'Kyrgyzstan', 'KG', '996', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(117, 'Laos', 'LA', '856', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(118, 'Latvia', 'LV', '371', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(119, 'Lebanon', 'LB', '961', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(120, 'Lesotho', 'LS', '266', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(121, 'Liberia', 'LR', '231', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(122, 'Libyan Arab Jamahiriya', 'LY', '218', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(123, 'Liechtenstein', 'LI', '423', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(124, 'Lithuania', 'LT', '370', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(125, 'Luxembourg', 'LU', '352', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(126, 'Macao', 'MO', '853', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(127, 'Macedonia', 'MK', '389', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(128, 'Madagascar', 'MG', '261', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(129, 'Malawi', 'MW', '265', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(130, 'Malaysia', 'MY', '60', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(131, 'Maldives', 'MV', '960', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(132, 'Mali', 'ML', '223', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(133, 'Malta', 'MT', '356', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(134, 'Marshall Islands', 'MH', '692', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(135, 'Martinique', 'MQ', '596', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(136, 'Mauritania', 'MR', '222', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(137, 'Mauritius', 'MU', '230', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(138, 'Mayotte', 'YT', '262', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(139, 'Mexico', 'MX', '52', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(140, 'Federated States of Micronesia', 'FM', '691', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(141, 'Moldova', 'MD', '373', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(142, 'Monaco', 'MC', '377', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(143, 'Mongolia', 'MN', '976', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(144, 'Montenegro', 'ME', '382', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(145, 'Montserrat', 'MS', '1664', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(146, 'Morocco', 'MA', '212', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(147, 'Mozambique', 'MZ', '258', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(148, 'Myanmar', 'MM', '95', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(149, 'Namibia', 'NA', '264', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(150, 'Nauru', 'NR', '674', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(151, 'Nepal', 'NP', '977', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(152, 'Netherlands', 'NL', '31', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(153, 'Netherlands Antilles', 'AN', '599', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(154, 'New Caledonia', 'NC', '687', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(155, 'New Zealand', 'NZ', '64', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(156, 'Nicaragua', 'NI', '505', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(157, 'Niger', 'NE', '227', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(158, 'Nigeria', 'NG', '234', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(159, 'Niue', 'NU', '683', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(160, 'Norfolk Island', 'NF', '672', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(161, 'Northern Mariana Islands', 'MP', '1670', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(162, 'Norway', 'NO', '47', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(163, 'Oman', 'OM', '968', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(164, 'Pakistan', 'PK', '92', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(165, 'Palau', 'PW', '680', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(166, 'Palestinian Territory', 'PS', '970', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(167, 'Panama', 'PA', '507', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(168, 'Papua New Guinea', 'PG', '675', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(169, 'Paraguay', 'PY', '595', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(170, 'Peru', 'PE', '51', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(171, 'Philippines', 'PH', '63', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(172, 'Pitcairn', 'PN', '872', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(173, 'Poland', 'PL', '48', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(174, 'Portugal', 'PT', '351', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(175, 'Puerto Rico', 'PR', '1939', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(176, 'Qatar', 'QA', '974', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(177, 'Romania', 'RO', '40', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(178, 'Russia', 'RU', '7', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(179, 'Rwanda', 'RW', '250', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(180, 'Reunion', 'RE', '262', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(181, 'Saint Barthelemy', 'BL', '590', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(182, 'Saint Helena', 'SH', '290', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(183, 'Saint Kitts and Nevis', 'KN', '1869', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(184, 'Saint Lucia', 'LC', '1758', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(185, 'Saint Martin', 'MF', '590', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(186, 'Saint Pierre and Miquelon', 'PM', '508', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(187, 'Saint Vincent and the Grenadines', 'VC', '1784', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(188, 'Samoa', 'WS', '685', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(189, 'San Marino', 'SM', '378', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(190, 'Sao Tome and Principe', 'ST', '239', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(191, 'Saudi Arabia', 'SA', '966', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(192, 'Senegal', 'SN', '221', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(193, 'Serbia', 'RS', '381', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(194, 'Seychelles', 'SC', '248', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(195, 'Sierra Leone', 'SL', '232', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(196, 'Singapore', 'SG', '65', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(197, 'Slovakia', 'SK', '421', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(198, 'Slovenia', 'SI', '386', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(199, 'Solomon Islands', 'SB', '677', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(200, 'Somalia', 'SO', '252', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(201, 'South Africa', 'ZA', '27', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(202, 'South Sudan', 'SS', '211', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(203, 'South Georgia and the South Sandwich Isl', 'GS', '500', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(204, 'Spain', 'ES', '34', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(205, 'Sri Lanka', 'LK', '94', 1, '2023-11-05 13:21:02', '2023-12-03 12:48:28'),
(206, 'Sudan', 'SD', '249', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(207, 'Suricountry', 'SR', '597', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(208, 'Svalbard and Jan Mayen', 'SJ', '47', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(209, 'Swaziland', 'SZ', '268', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(210, 'Sweden', 'SE', '46', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(211, 'Switzerland', 'CH', '41', 1, '2023-11-05 13:21:02', '2023-12-03 12:48:32'),
(212, 'Syrian Arab Republic', 'SY', '963', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(213, 'Taiwan', 'TW', '886', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(214, 'Tajikistan', 'TJ', '992', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(215, 'Tanzania', 'TZ', '255', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(216, 'Thailand', 'TH', '66', 1, '2023-11-05 13:21:02', '2023-12-03 12:48:35'),
(217, 'Timor-Leste', 'TL', '670', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(218, 'Togo', 'TG', '228', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(219, 'Tokelau', 'TK', '690', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(220, 'Tonga', 'TO', '676', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(221, 'Trinidad and Tobago', 'TT', '1868', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(222, 'Tunisia', 'TN', '216', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(223, 'Turkey', 'TR', '90', 1, '2023-11-05 13:21:02', '2023-12-03 12:48:18'),
(224, 'Turkmenistan', 'TM', '993', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(225, 'Turks and Caicos Islands', 'TC', '1649', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(226, 'Tuvalu', 'TV', '688', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(227, 'Uganda', 'UG', '256', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(228, 'Ukraine', 'UA', '380', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(229, 'United Arab Emirates', 'AE', '971', 1, '2023-11-05 13:21:02', '2023-12-03 12:48:21'),
(230, 'United Kingdom', 'GB', '44', 1, '2023-11-05 13:21:02', '2023-12-04 04:57:48'),
(231, 'United States', 'US', '1', 1, '2023-11-05 13:21:02', '2023-12-04 04:57:51'),
(232, 'Uruguay', 'UY', '598', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(233, 'Uzbekistan', 'UZ', '998', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(234, 'Vanuatu', 'VU', '678', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(235, 'Venezuela', 'VE', '58', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(236, 'Vietnam', 'VN', '84', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(237, 'British Virgin Islands', 'VG', '1284', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(238, 'U.S. Virgin Islands', 'VI', '1340', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(239, 'Wallis and Futuna', 'WF', '681', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(240, 'Yemen', 'YE', '967', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(241, 'Zambia', 'ZM', '260', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(242, 'Zimbabwe', 'ZW', '263', 1, '2023-11-05 13:21:02', '2023-12-02 05:41:33'),
(243, 'Ojana Desh', 'OD', '444', 1, '2023-12-26 10:03:48', '2023-12-26 10:04:11');

-- --------------------------------------------------------

--
-- Table structure for table `cover_photos`
--

CREATE TABLE `cover_photos` (
  `id` bigint(20) NOT NULL,
  `owner_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `cover_photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cron_jobs`
--

CREATE TABLE `cron_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) DEFAULT NULL,
  `alias` varchar(40) DEFAULT NULL,
  `action` text DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `cron_schedule_id` int(11) NOT NULL DEFAULT 0,
  `next_run` datetime DEFAULT NULL,
  `last_run` datetime DEFAULT NULL,
  `is_running` tinyint(1) NOT NULL DEFAULT 1,
  `is_default` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cron_jobs`
--

INSERT INTO `cron_jobs` (`id`, `name`, `alias`, `action`, `url`, `cron_schedule_id`, `next_run`, `last_run`, `is_running`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'Upcoming Bill Payment Reminder', 'upcoming_bill_payment_reminder', '[\n    \"\\\\App\\\\Http\\\\Controllers\\\\CronController\",\n    \"sendUpcomingPaymentNotification\"\n]', NULL, 1, '2023-11-05 13:10:31', '2023-11-04 13:10:31', 1, 1, NULL, '2023-11-04 07:10:31'),
(2, 'Owner Monthly Bill Auto Payment', 'owner_monthly_bill_auto_payment', '[\r\n    \"\\\\App\\\\Http\\\\Controllers\\\\CronController\",\r\n    \"autoPaymentMonthlyBill\"\r\n]', NULL, 1, '2023-11-05 13:13:52', '2023-11-04 13:13:52', 1, 1, NULL, '2023-11-04 07:13:52');

-- --------------------------------------------------------

--
-- Table structure for table `cron_job_logs`
--

CREATE TABLE `cron_job_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cron_job_id` int(11) NOT NULL DEFAULT 0,
  `start_at` datetime DEFAULT NULL,
  `end_at` datetime DEFAULT NULL,
  `duration` int(11) NOT NULL DEFAULT 0,
  `error` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cron_schedules`
--

CREATE TABLE `cron_schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) DEFAULT NULL,
  `interval` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cron_schedules`
--

INSERT INTO `cron_schedules` (`id`, `name`, `interval`, `status`, `created_at`, `updated_at`) VALUES
(1, '1 Day', 86400, 1, '2023-11-02 14:53:25', '2023-11-02 14:58:53');

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `owner_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `booking_id` int(11) DEFAULT 0,
  `pay_for_month` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Ex: owner pay for 12 months',
  `method_code` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `method_currency` varchar(40) DEFAULT NULL,
  `charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `rate` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `final_amo` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `detail` text DEFAULT NULL,
  `btc_amo` varchar(255) DEFAULT NULL,
  `btc_wallet` varchar(255) DEFAULT NULL,
  `trx` varchar(40) DEFAULT NULL,
  `payment_try` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=>success, 2=>pending, 3=>cancel',
  `from_api` tinyint(1) NOT NULL DEFAULT 0,
  `admin_feedback` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `device_tokens`
--

CREATE TABLE `device_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `owner_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_app` tinyint(1) NOT NULL DEFAULT 0,
  `token` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `extensions`
--

CREATE TABLE `extensions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `act` varchar(40) DEFAULT NULL,
  `name` varchar(40) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `script` text DEFAULT NULL,
  `shortcode` text DEFAULT NULL COMMENT 'object',
  `support` text DEFAULT NULL COMMENT 'help section',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=>enable, 2=>disable',
  `deleted_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `extensions`
--

INSERT INTO `extensions` (`id`, `act`, `name`, `description`, `image`, `script`, `shortcode`, `support`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'tawk-chat', 'Tawk.to', 'Key location is shown bellow', 'tawky_big.png', '<script>\r\n                        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();\r\n                        (function(){\r\n                        var s1=document.createElement(\"script\"),s0=document.getElementsByTagName(\"script\")[0];\r\n                        s1.async=true;\r\n                        s1.src=\"https://embed.tawk.to/{{app_key}}\";\r\n                        s1.charset=\"UTF-8\";\r\n                        s1.setAttribute(\"crossorigin\",\"*\");\r\n                        s0.parentNode.insertBefore(s1,s0);\r\n                        })();\r\n                    </script>', '{\"app_key\":{\"title\":\"App Key\",\"value\":\"------\"}}', 'twak.png', 0, NULL, '2019-10-18 17:16:05', '2022-03-21 23:22:24'),
(2, 'google-recaptcha2', 'Google Recaptcha 2', 'Key location is shown bellow', 'recaptcha3.png', '\n<script src=\"https://www.google.com/recaptcha/api.js\"></script>\n<div class=\"g-recaptcha\" data-sitekey=\"{{site_key}}\" data-callback=\"verifyCaptcha\"></div>\n<div id=\"g-recaptcha-error\"></div>', '{\"site_key\":{\"title\":\"Site Key\",\"value\":\"-------------\"},\"secret_key\":{\"title\":\"Secret Key\",\"value\":\"------------\"}}', 'recaptcha.png', 0, NULL, '2019-10-18 17:16:05', '2024-01-28 08:07:12'),
(3, 'custom-captcha', 'Custom Captcha', 'Just put any random string', 'customcaptcha.png', NULL, '{\"random_key\":{\"title\":\"Random String\",\"value\":\"SecureString\"}}', 'na', 0, NULL, '2019-10-18 17:16:05', '2022-10-12 23:02:43'),
(4, 'google-analytics', 'Google Analytics', 'Key location is shown bellow', 'google_analytics.png', '<script async src=\"https://www.googletagmanager.com/gtag/js?id={{app_key}}\"></script>\r\n                <script>\r\n                  window.dataLayer = window.dataLayer || [];\r\n                  function gtag(){dataLayer.push(arguments);}\r\n                  gtag(\"js\", new Date());\r\n                \r\n                  gtag(\"config\", \"{{app_key}}\");\r\n                </script>', '{\"app_key\":{\"title\":\"App Key\",\"value\":\"------\"}}', 'ganalytics.png', 0, NULL, NULL, '2021-05-04 04:19:12'),
(5, 'fb-comment', 'Facebook Comment ', 'Key location is shown bellow', 'Facebook.png', '<div id=\"fb-root\"></div><script async defer crossorigin=\"anonymous\" src=\"https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v4.0&appId={{app_key}}&autoLogAppEvents=1\"></script>', '{\"app_key\":{\"title\":\"App Key\",\"value\":\"----\"}}', 'fb_com.PNG', 0, NULL, NULL, '2022-03-21 23:18:36');

-- --------------------------------------------------------

--
-- Table structure for table `extra_services`
--

CREATE TABLE `extra_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `owner_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `name` varchar(40) DEFAULT NULL,
  `cost` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` bigint(20) NOT NULL,
  `name` varchar(40) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `act` varchar(40) DEFAULT NULL,
  `form_data` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`id`, `act`, `form_data`, `created_at`, `updated_at`) VALUES
(1, 'withdraw_method', '{\"acc_holder_name\":{\"name\":\"Acc Holder Name\",\"label\":\"acc_holder_name\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"account_number\":{\"name\":\"Account Number\",\"label\":\"account_number\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"phone_number\":{\"name\":\"Phone Number\",\"label\":\"phone_number\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"}}', '2023-08-31 10:10:51', '2023-08-31 10:10:51'),
(3, 'manual_deposit', '{\"tcash_number\":{\"name\":\"TCash Number\",\"label\":\"tcash_number\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"}}', '2023-11-01 12:52:50', '2023-11-01 12:53:15'),
(4, 'owner_form', '{\"tiin_number\":{\"name\":\"TIIN Number\",\"label\":\"tiin_number\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"license_picture\":{\"name\":\"License Picture\",\"label\":\"license_picture\",\"is_required\":\"required\",\"extensions\":\"jpg,jpeg,png\",\"options\":[],\"type\":\"file\"}}', '2023-11-07 07:26:15', '2023-12-02 05:24:01'),
(5, 'withdraw_method', '{\"wallet_address\":{\"name\":\"Wallet Address\",\"label\":\"wallet_address\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"}}', '2023-12-09 23:34:48', '2023-12-09 23:34:48');

-- --------------------------------------------------------

--
-- Table structure for table `frontends`
--

CREATE TABLE `frontends` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tempname` varchar(40) DEFAULT NULL,
  `data_keys` varchar(40) DEFAULT NULL,
  `data_values` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `frontends`
--

INSERT INTO `frontends` (`id`, `tempname`, `data_keys`, `data_values`, `created_at`, `updated_at`) VALUES
(1, 'basic', 'seo.data', '{\"seo_image\":\"1\",\"keywords\":[\"hotel\",\"booking\",\"room booking\",\"reservation\",\"room reservation\",\"hotel booking\",\"night\",\"day\",\"premium\",\"royal\",\"delux\"],\"description\":\"Maximize hotel success with our seamless management platform\\u2014intuitive dashboards, efficient reservations, secure billing, and 24\\/7 support for unparalleled operational excellence. Elevate guest experiences and boost profits effortlessly.\",\"social_title\":\"BookingBox- MultiVendor Hotel Booking Application\",\"social_description\":\"Maximize hotel success with our seamless management platform\\u2014intuitive dashboards, efficient reservations, secure billing, and 24\\/7 support for unparalleled operational excellence. Elevate guest experiences and boost profits effortlessly.\",\"image\":\"65b63236c83fe1706439222.png\"}', '2020-07-05 03:42:52', '2024-01-28 15:53:42'),
(24, 'basic', 'about.content', '{\"has_image\":\"1\",\"heading\":\"About Us\",\"sub_heading\":\"Your Trusted Partner for Hotel Success.\",\"description\":\"Leveraging years of experience in empowering businesses through software solutions, we\'re now dedicated to helping hotel owners thrive. We understand the complexities of managing bookings, logistics, and staff, so we\'ve developed a revolutionary SAAS app to automate tasks, streamline operations, and free you up to focus on what matters most - exceeding guest expectations.\",\"image\":\"658d6f720bb931703767922.png\"}', '2020-10-28 04:51:20', '2024-01-02 14:22:49'),
(39, 'basic', 'banner.content', '{\"has_image\":\"1\",\"heading\":\"Say Goodbye to Hotel Management Chaos\",\"subheading\":\"Manage bookings, automate tasks, improve communication, and gain valuable insights.\",\"download_button\":\"Download App\",\"iso_download_link\":\"https:\\/\\/www.apple.com\\/app-store\\/\",\"android_download_link\":\"https:\\/\\/play.google.com\\/\",\"image\":\"658d3a0e62c831703754254.png\"}', '2021-05-02 10:09:30', '2024-01-28 16:53:21'),
(41, 'basic', 'cookie.data', '{\"short_desc\":\"We may use cookies or any other tracking technologies when you visit our website, including any other media form, mobile website, or mobile application related or connected to help customize the Site and improve your experience.\",\"description\":\"<div><h4><br><\\/h4><h4>What information do we collect?<\\/h4><p>We gather data from you when you register on our site, submit a request, buy any services, react to an overview, or round out a structure. At the point when requesting any assistance or enrolling on our site, as suitable, you might be approached to enter your: name, email address, or telephone number. You may, nonetheless, visit our site anonymously.<\\/p><\\/div><div><h4>How do we protect your information?<\\/h4><p>All provided delicate\\/credit data is sent through Stripe.<br>After an exchange, your private data (credit cards, social security numbers, financials, and so on) won\'t be put away on our workers.<\\/p><\\/div><div><h4>Do we disclose any information to outside parties?<\\/h4><p>We don\'t sell, exchange, or in any case move to outside gatherings by and by recognizable data. This does exclude confided in outsiders who help us in working our site, leading our business, or adjusting you, since those gatherings consent to keep this data private. We may likewise deliver your data when we accept discharge is suitable to follow the law, implement our site strategies, or ensure our own or others\' rights, property, or wellbeing.<\\/p><\\/div><div><h4>Children\'s Online Privacy Protection Act Compliance<\\/h4><p>We are consistent with the prerequisites of COPPA (Children\'s Online Privacy Protection Act), we don\'t gather any data from anybody under 13 years old. Our site, items, and administrations are completely coordinated to individuals who are in any event 13 years of age or more established.<\\/p><\\/div><div><h4>Changes to our Privacy Policy<\\/h4><p>If we decide to change our privacy policy, we will post those changes on this page.<\\/p><\\/div><div><h4>How long we retain your information?<\\/h4><p>At the point when you register for our site, we cycle and keep your information we have about you however long you don\'t erase the record or withdraw yourself (subject to laws and guidelines).<\\/p><\\/div><div><h4>What we don\\u2019t do with your data<\\/h4><p>We don\'t and will never share, unveil, sell, or in any case give your information to different organizations for the promoting of their items or administrations.<\\/p><p><br><\\/p><p><br><\\/p><\\/div>\",\"status\":1}', '2020-07-05 03:42:52', '2024-01-09 19:30:51'),
(42, 'basic', 'policy_pages.element', '{\"title\":\"Privacy Policy\",\"details\":\"<div>\\n    <h4>What\\n        information do we collect?<\\/h4>\\n    <p>We gather data from you when you\\n        register on our site, submit a request, buy any services, react to an overview, or round out a structure. At the\\n        point when requesting any assistance or enrolling on our site, as suitable, you might be approached to enter\\n        your: name, email address, or telephone number. You may, nonetheless, visit our site anonymously.<\\/p>\\n<\\/div>\\n<div>\\n    <h4>How do\\n        we protect your information?<\\/h4>\\n    <p>All provided delicate\\/credit data is\\n        sent through Stripe.<br \\/>After an exchange, your private data (credit cards, social security numbers, financials,\\n        and so on) won\'t be put away on our workers.<\\/p>\\n<\\/div>\\n<div>\\n    <h4>Do we\\n        disclose any information to outside parties?<\\/h4>\\n    <p>We don\'t sell, exchange, or in any case\\n        move to outside gatherings by and by recognizable data. This does exclude confided in outsiders who help us in\\n        working our site, leading our business, or adjusting you, since those gatherings consent to keep this data\\n        private. We may likewise deliver your data when we accept discharge is suitable to follow the law, implement our\\n        site strategies, or ensure our own or others\' rights, property, or wellbeing.<\\/p>\\n<\\/div>\\n<div>\\n    <h4>\\n        Children\'s Online Privacy Protection Act Compliance<\\/h4>\\n    <p>We are consistent with the prerequisites\\n        of COPPA (Children\'s Online Privacy Protection Act), we don\'t gather any data from anybody under 13 years old.\\n        Our site, items, and administrations are completely coordinated to individuals who are in any event 13 years of\\n        age or more established.<\\/p>\\n<\\/div>\\n<div>\\n    <h4>Changes\\n        to our Privacy Policy<\\/h4>\\n    <p>If we decide to change our privacy\\n        policy, we will post those changes on this page.<\\/p>\\n<\\/div>\\n<div>\\n    <h4>How long\\n        we retain your information?<\\/h4>\\n    <p>At the point when you register for our\\n        site, we cycle and keep your information we have about you however long you don\'t erase the record or withdraw\\n        yourself (subject to laws and guidelines).<\\/p>\\n<\\/div>\\n<div>\\n    <h4>What we\\n        don\\u2019t do with your data<\\/h4>\\n    <p>We don\'t and will never share, unveil,\\n        sell, or in any case give your information to different organizations for the promoting of their items or\\n        administrations.<\\/p>\\n<\\/div>\"}', '2021-06-09 12:50:42', '2024-01-09 19:24:38'),
(43, 'basic', 'policy_pages.element', '{\"title\":\"Terms of Service\",\"details\":\"<br \\/><div>\\n    <h4>Terms\\n        & Conditions for Users<\\/h4>\\n    <p>Before getting to this site, you are\\n        consenting to be limited by these site Terms and Conditions of Use, every single appropriate law, and\\n        guidelines, and concur that you are answerable for consistency with any material neighborhood laws. If you\\n        disagree with any of these terms, you are restricted from utilizing or getting to this site.<\\/p>\\n<\\/div>\\n<div>\\n    <h4>Support<\\/h4>\\n    <p>Whenever you have downloaded our item,\\n        you may get in touch with us for help through email and we will give a valiant effort to determine your issue.\\n        We will attempt to answer using the Email for more modest bug fixes, after which we will refresh the center\\n        bundle. Content help is offered to confirmed clients by Tickets as it were. Backing demands made by email and\\n        Livechat.<\\/p>\\n    <p>On the off chance\\n        that your help requires extra adjustment of the System, at that point, you have two alternatives:<\\/p>\\n    <ul>\\n        <li>Hang tight for additional update discharge.<\\/li>\\n        <li>Or on the other hand, enlist a specialist (We offer\\n            customization for extra charges).<\\/li><li><br \\/><\\/li>\\n    <\\/ul>\\n<\\/div>\\n<div>\\n    <h4>\\n        Ownership<\\/h4>\\n    <p>You may not guarantee scholarly or\\n        selective possession of any of our items, altered or unmodified. All items are property, we created them. Our\\n        items are given \\\"with no guarantees\\\" without guarantee of any sort, either communicated or suggested. On no\\n        occasion will our juridical individual be subject to any harms including, however not restricted to, immediate,\\n        roundabout, extraordinary, accidental, or significant harms or different misfortunes emerging out of the\\n        utilization of or powerlessness to utilize our items.<\\/p>\\n<\\/div>\\n<div>\\n    <h4>Warranty\\n    <\\/h4>\\n    <p>We don\' t offer any guarantee or\\n        assurance of these Services in any way. When our Services have been modified we can\'t ensure they will work with\\n        all outsider plugins, modules, or internet browsers. Program similarity ought to be tried against the show\\n        formats on the demo worker. If you don\' t mind guarantee that the programs you use will work with the component,\\n        as we can not ensure that our systems will work with all program mixes.<\\/p>\\n<\\/div>\\n<div>\\n    <h4>\\n        Unauthorized\\/Illegal Usage<\\/h4>\\n    <p>You may not utilize our things for any\\n        illicit or unapproved reason or may you,\\n        in the utilization of the stage,\\n        disregard any laws in your locale (counting yet not restricted to copyright laws) just as the laws of your\\n        nation and International law. Specifically,\\n        it is disallowed to utilize the things on our foundation for pages that advance: brutality,\\n        illegal intimidation,\\n        hard sexual entertainment,\\n        bigotry,\\n        obscenity content or warez programming joins.<br \\/><br \\/>You can\'t imitate, copy, duplicate, sell, exchange or\\n        adventure any of our segment, utilization of the offered on our things, or admittance to the administration\\n        without the express composed consent by us or item proprietor.<br \\/><br \\/>Our Members are liable for all substance\\n        posted on the discussion and demo and movement that happens under your record.<br \\/><br \\/>We hold the chance of\\n        hindering your participation account quickly if we will think about a particularly not allowed\\n        conduct.<br \\/><br \\/>If you make a record on our site, you are liable for keeping up the security of your record, and\\n        you are completely answerable for all exercises that happen under the record and some other activities taken\\n        regarding the record. You should quickly inform us, of any unapproved employments of your record or some other\\n        penetrates of security.<\\/p>\\n<\\/div>\\n<div>\\n    <h4>Fiverr,\\n        Seoclerks Sellers Or Affiliates<\\/h4>\\n    <p>We do NOT ensure full SEO campaign\\n        conveyance within 24 hours. We make no assurance for conveyance time by any means. We give our best assessment\\n        to orders during the putting in of requests, anyway, these are gauges. We won\' t be considered liable for loss\\n        of assets,\\n        negative surveys or you being prohibited for late conveyance. If you are selling on a site that requires time\\n        touchy outcomes,\\n        utilize Our SEO Services at your own risk.<\\/p>\\n<\\/div>\\n<div>\\n    <h4>\\n        Payment\\/Refund Policy<\\/h4>\\n    <p>No refund or cash back will be made.\\n        After a deposit has been finished,\\n        it is extremely unlikely to invert it. You should utilize your equilibrium on requests our administrations,\\n        Hosting,\\n        SEO campaign. You concur that once you complete a deposit,\\n        you won\'t document a debate or a chargeback against us in any way, shape, or form.<br \\/><br \\/>If you document a\\n        debate or chargeback against us after a deposit, we claim all authority to end every single future request,\\n        prohibit you from our site. False action, for example, utilizing unapproved or taken charge cards will prompt\\n        the end of your record. There are no special cases.<\\/p>\\n<\\/div>\\n<div>\\n    <h4>Free\\n        Balance \\/ Coupon Policy<\\/h4>\\n    <p>We offer numerous approaches to get FREE\\n        Balance, Coupons and Deposit offers yet we generally reserve the privilege to audit it and deduct it from your\\n        record offset with any explanation we may it is a sort of misuse. If we choose to deduct a few or all of free\\n        Balance from your record balance, and your record balance becomes negative, at that point the record will\\n        naturally be suspended. If your record is suspended because of a negative Balance you can request to make a\\n        custom payment to settle your equilibrium to actuate your record.<\\/p>\\n<\\/div>\"}', '2021-06-09 12:51:18', '2024-01-09 19:27:20'),
(55, 'basic', 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"The consumers who did not spend\",\"description\":\"<h3 style=\\\"margin-top:1.5rem;margin-bottom:1rem;font-weight:600;line-height:1.15;font-size:1.5rem;font-family:\'Josefin Sans\', sans-serif;color:rgb(0,42,71);\\\">Curabitur a felis in nunc fringilla tristique abot escrow.<\\/h3><div class=\\\"mt-4 contact-section__content-text\\\" style=\\\"color:rgb(0,42,71);font-family:Roboto, sans-serif;\\\"><p class=\\\"mt-4 contact-section__content-text\\\" style=\\\"margin-bottom:1.5rem;margin-right:0px;margin-left:0px;color:rgb(0,42,71);font-size:16px;\\\">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In dui maosuere eget, vestibulum et, tempor auctor, justo. In ac felis quis tortor malesuada pretium. Pellentesque auctor neque nec urna. Proin sapien ipsum, porta a, auctor quis, euismod ut, mi. Aenean viverra rhoncus pede. fringilla tstique. Morbi mattis ullamcorper velit. Phasellus gravida semper nisi. Nullam vel sem.<\\/p><p class=\\\"contact-section__content-text\\\" style=\\\"margin-right:0px;margin-bottom:1.5rem;margin-left:0px;color:rgb(0,42,71);font-size:16px;\\\">Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc,<\\/p><h4 style=\\\"margin-top:1.5rem;margin-bottom:1rem;font-weight:600;line-height:1.15;font-size:1.375rem;font-family:\'Josefin Sans\', sans-serif;color:rgb(0,42,71);\\\">Maecenas Dempuget condimentum rhoncus<\\/h4><p class=\\\"contact-section__content-text\\\" style=\\\"margin-right:0px;margin-bottom:1.5rem;margin-left:0px;color:rgb(0,42,71);font-size:16px;\\\">Dorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc,<\\/p><p class=\\\"contact-section__content-text\\\" style=\\\"margin-right:0px;margin-bottom:1.5rem;margin-left:0px;color:rgb(0,42,71);font-size:16px;\\\">Dorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc.<\\/p><\\/div>\",\"image\":\"624c0a7923c511649150585.jpg\"}', '2022-04-05 11:53:05', '2022-06-21 16:10:46'),
(56, 'basic', 'subscribe.content', '{\"has_image\":\"1\",\"heading\":\"Subscribe Newsletter\",\"button_title\":\"Subscribe\",\"image\":\"624c17a47e1771649153956.jpg\"}', '2022-04-05 12:49:16', '2022-06-19 11:33:40'),
(61, 'basic', 'testimonial.content', '{\"heading\":\"Testimonials\",\"sub_heading\":\"Hear What Our Hotels Are Saying\"}', '2022-04-05 16:55:06', '2023-12-28 18:48:55'),
(67, 'basic', 'faq.content', '{\"heading\":\"FAQ\",\"subheading\":\"Please check the question and answer. If any further issues occured, please contact with us, we will solve the issue in correct time.\",\"button_text\":\"See More\",\"button_url\":\"\\/faq\"}', '2022-04-05 17:34:46', '2022-06-19 11:15:02'),
(68, 'basic', 'faq.element', '{\"question\":\"How to booking room?\",\"answer\":\"Condimentum nec, nisi. Praesent nec nisl a purus blandit viverra.raesent ac massa at ligula laoreet iaculis. Nulla neque dolor sagittis eget iaculis quis molestie non velit. Mauris turpis nunc.\"}', '2022-04-05 17:35:20', '2022-04-05 17:35:20'),
(69, 'basic', 'faq.element', '{\"question\":\"Hotel location?\",\"answer\":\"Condimentum nec, nisi. Praesent nec nisl a purus blandit viverra.raesent ac massa at ligula laoreet iaculis. Nulla neque dolor sagittis eget iaculis quis molestie non velit. Mauris turpis nunc.\"}', '2022-04-05 17:35:37', '2022-04-05 17:35:37'),
(70, 'basic', 'faq.element', '{\"question\":\"What we serve?\",\"answer\":\"Condimentum nec, nisi. Praesent nec nisl a purus blandit viverra.raesent ac massa at ligula laoreet iaculis. Nulla neque dolor sagittis eget iaculis quis molestie non velit. Mauris turpis nunc.\"}', '2022-04-05 17:36:31', '2022-04-05 17:36:31'),
(71, 'basic', 'login.content', '{\"has_image\":\"1\",\"title\":\"Hello! Welcome to Single Hotel Room Booking\",\"short_details\":\"Maecenas nec odio et ante tincidunt tempus. Donec vitae apitlibero venenatis\",\"form_heading\":\"Sign In Account\",\"form_subheading\":\"Maecenas nec odio et ante tincidunt tempus. Donec vitae apitlibero venenatis\",\"image\":\"629710f22d70d1654067442.png\"}', '2022-04-06 05:40:04', '2022-06-01 13:28:58'),
(72, 'basic', 'register.content', '{\"has_image\":\"1\",\"title\":\"Hello! Welcome to Single Hotel Room Booking\",\"heading\":\"Register Your Account\",\"subheading\":\"When you create an account, it helps you book your perfect room.\",\"image\":\"6297316e19a5c1654075758.png\"}', '2022-04-06 05:40:45', '2023-01-28 18:33:03'),
(74, 'basic', 'code_verify.content', '{\"description\":\"A 6 digit verification code sent to your email address :\"}', '2022-04-06 08:09:22', '2022-06-26 08:03:14'),
(75, 'basic', 'service.element', '{\"name\":\"Health Care\",\"icon\":\"<i class=\\\"fas fa-ambulance\\\"><\\/i>\"}', '2022-05-21 10:23:17', '2022-05-21 10:23:17'),
(76, 'basic', 'service.element', '{\"name\":\"Swimming Pool\",\"icon\":\"<i class=\\\"fas fa-swimming-pool\\\"><\\/i>\"}', '2022-05-21 10:23:45', '2022-05-21 10:23:45'),
(77, 'basic', 'service.element', '{\"name\":\"Travelling\",\"icon\":\"<i class=\\\"fas fa-plane-departure\\\"><\\/i>\"}', '2022-05-21 10:24:13', '2022-05-21 10:24:13'),
(78, 'basic', 'service.element', '{\"name\":\"BBQ Resturant\",\"icon\":\"<i class=\\\"fas fa-hotel\\\"><\\/i>\"}', '2022-05-21 10:25:33', '2022-05-21 10:26:16'),
(80, 'basic', 'testimonial.element', '{\"has_image\":\"1\",\"name\":\"Mohammad Bright\",\"designation\":\"CEO & Founder\",\"rating\":\"4\",\"review\":\"BookingBox provided an exceptional stay! Impeccable service, cozy rooms, and a central location. The staff\'s friendliness and attention to detail made our experience memorable\",\"photo\":\"658d77668f1c51703769958.png\"}', '2022-05-21 10:31:44', '2023-12-28 18:45:04'),
(81, 'basic', 'testimonial.element', '{\"has_image\":\"1\",\"name\":\"Nasim Knapp\",\"designation\":\"Manager\",\"rating\":\"5\",\"review\":\"BookingBox exceeded expectations! Outstanding service, stylish rooms, and a convenient location. The staff went above and beyond to ensure a pleasant stay\",\"photo\":\"658d77df8a4f91703770079.png\"}', '2022-05-21 10:31:53', '2023-12-28 18:44:52'),
(82, 'basic', 'testimonial.element', '{\"has_image\":\"1\",\"name\":\"Amy Vazquez\",\"designation\":\"Teacher\",\"rating\":\"5\",\"review\":\"BookingBox truly impressed! From the welcoming staff to the modern rooms and central location, our stay was delightful. Exceptional service and attention to detail make it a top choice\",\"photo\":\"658d7810083ae1703770128.png\"}', '2022-05-21 10:32:00', '2023-12-28 18:44:35'),
(83, 'basic', 'testimonial.element', '{\"has_image\":\"1\",\"name\":\"Connor Cooke\",\"designation\":\"Engneer\",\"rating\":\"4\",\"review\":\"BookingBox is a gem! Exceptional service, chic rooms, and a prime location. The staff\'s warmth and dedication create a memorable experience\",\"photo\":\"658d78424cc611703770178.png\"}', '2022-05-21 10:32:09', '2023-12-28 18:44:21'),
(84, 'basic', 'testimonial.element', '{\"has_image\":\"1\",\"name\":\"Hope Mills\",\"designation\":\"Doctor\",\"rating\":\"5\",\"review\":\"BookingBox stands out! Impeccable service, elegant rooms, and a central locale. The staff\'s hospitality made our stay special. A top-notch choice for those seeking comfort and luxury\",\"photo\":\"658d7866d63311703770214.png\"}', '2022-05-21 10:32:16', '2023-12-28 18:44:05'),
(85, 'basic', 'faq.element', '{\"question\":\"How to cancel booking?\",\"answer\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam aliquam at lectus sed dignissim. In posuere ex dui, ac lacinia risus elementum non\"}', '2022-05-21 10:40:42', '2022-05-21 10:40:42'),
(86, 'basic', 'faq.element', '{\"question\":\"What is our refund policy?\",\"answer\":\"Curabitur gravida diam sed facilisis aliquet. Nam vel turpis metus. Fusce luctus convallis purus vel malesuada. Sed ultrices magna quis eros posuere.\"}', '2022-05-21 10:41:17', '2022-05-21 10:41:17'),
(87, 'basic', 'footer.content', '{\"description\":\"Our system is designed for a multivendor hotel management system. By using this platform visitors, tourists or any person can hotel on their visited spot, and also hotel owner can fulfill visitor satisfaction. We also provide hotel owner to manage their booking-related things.\"}', '2022-05-21 11:07:45', '2023-12-02 09:05:14'),
(88, 'basic', 'maintenance.data', '{\"description\":\"<div style=\\\"font-family: Nunito, sans-serif;\\\">\\r\\n        <h2 style=\\\"font-family: Poppins, sans-serif; text-align: center;\\\">\\r\\n            We\'re Just Tuning Up a Few Things\\r\\n        <\\/h2>\\r\\n       \\r\\n        <p style=\\\"text-align: center; font-size: 1rem;\\\">\\r\\n            We apologize for the inconvenience but Front is currently undergoing planned maintenance. Thanks for your patience\\r\\n        <\\/p>\\r\\n        \\r\\n    <\\/div>\",\"tempname\":\"basic\",\"image\":\"65462bfc596ae1699097596.png\",\"heading\":\"THE SITE USNDER MAINTENANCE\",\"button_text\":null}', NULL, '2024-01-20 19:43:47'),
(89, 'basic', 'faq.element', '{\"question\":\"Enim consequatur La ?\",\"answer\":\"It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\"}', '2022-06-02 10:23:27', '2022-06-02 10:23:27'),
(90, 'basic', 'faq.element', '{\"question\":\"Duis velit qui reru ?\",\"answer\":\"There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour.\"}', '2022-06-02 10:23:47', '2022-06-02 10:23:47'),
(91, 'basic', 'faq.element', '{\"question\":\"Magni quas voluptate ?\",\"answer\":\"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis.\"}', '2022-06-02 10:24:08', '2022-06-02 10:24:08'),
(92, 'basic', 'faq.element', '{\"question\":\"Illum sint voluptat ?\",\"answer\":\"But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects.\"}', '2022-06-02 10:24:37', '2022-06-02 10:24:37'),
(93, 'basic', 'faq.element', '{\"question\":\"Iste asperiores illo ?\",\"answer\":\"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis.\"}', '2022-06-02 10:24:48', '2022-06-19 11:13:41'),
(95, 'basic', 'featured_room.content', '{\"heading\":\"Featured Rooms\",\"subheading\":\"Every room type has many rooms. Anyone can send booking requrest from this site.\"}', '2022-06-19 11:05:06', '2022-06-23 10:37:14'),
(97, 'basic', 'maintenance_mode.content', '{\"has_image\":\"1\",\"heading\":\"THE SITE IS UNDER MAINTENANCE\",\"image\":\"62b8578719e9e1656248199.png\"}', '2022-06-26 10:48:45', '2022-06-26 10:56:39'),
(98, 'basic', 'banned_page.content', '{\"has_image\":\"1\",\"heading\":\"You are banned\",\"image\":\"63d77188b0ad61675063688.png\"}', '2022-06-26 11:22:50', '2023-01-30 12:28:08'),
(99, 'basic', 'maintenance_page.content', '{\"has_image\":\"1\",\"heading\":\"THE SITE IS UNDER MAINTENANCE\",\"image\":\"62b92e3bdf08d1656303163.png\"}', '2022-06-27 02:12:43', '2022-06-27 02:12:44'),
(100, 'basic', 'policy_pages.element', '{\"title\":\"Refund and Cancellation Policy\",\"details\":\"<p>\\n    To reduce last-minute cancellations and the risk of \\\"<a href=\\\"https:\\/\\/en.wikipedia.org\\/wiki\\/Chargeback\\\" class=\\\"text--base\\\">chargebacks<\\/a>\\\" from customers, it is always a good idea\\n    to have your customers agree to your cancellation and refund policy. This should be attached to the customers\'\\n    orders for future reference. The occasion makes this easy for you and your customers.<\\/p>\\n<p>\\n    In this article, we will help you define your cancellation and refund policy. Let\'s start by answering the following\\n    questions:<\\/p>\\n<ol>\\n    <li><\\/li>\\n    <li>When do they have to inform you by before the actual\\n        event date starts to cancel?<\\/li>\\n    <li>Do you want to keep their payment and give them store\\n        credit instead?<\\/li>\\n<\\/ol>\\n<p>\\n    By answering the questions above, you can come up with some very simple and basic policies, like this one:\\u00a0<i>To receive a refund, customers must notify at least 4 days before the start of\\n        the event. In all other instances, only store credit is issued.<\\/i><\\/p>\\n<p>\\n    Below are\\u00a0<span><u>six<\\/u><\\/span>\\u00a0great examples of cancellation and refund policies:<\\/p>\\n<ol>\\n    <li>Due\\u00a0to limited seating, we request that you cancel\\n        at least 48 hours before a scheduled class. This gives us the opportunity to fill the class. You may cancel by\\n        phone or online here. If you have to cancel your class, we offer you a credit to your account if you cancel\\n        before 48 hours, but do not offer refunds. You may use these credits for any future class. However, if you do\\n        not cancel prior to the 48 hours, you will lose the payment for the class. The owner has the only right to be\\n        flexible here.<\\/li>\\n    <li>Cancellations made 7 days or more in advance of the\\n        event date will receive a 100% refund. Cancellations made within 3 - 6 days will incur a 20% fee. Cancellations\\n        made within 48 hours of the event will incur a 30% fee.<\\/li>\\n    <li>I understand that I am holding a spot so reservations\\n        for this event are nonrefundable. If I am unable to attend I understand that I can transfer to a friend.<\\/li>\\n    <li>If your cancellation is at least 24 hours in advance of\\n        the class, you will receive a full refund. If your cancellation is less than 24 hours in advance, you will\\n        receive a gift certificate to attend a future class. We will do our best to accommodate your needs.<\\/li>\\n    <li>You may cancel your class up to 24 hours before the\\n        class begins and request receives a full refund. If cancellation is made the day of you will receive a credit to\\n        reschedule at a later date. Credit must be used within 90 days.<\\/li>\\n    <li>You may request to cancel your ticket for a full\\n        refund, up to 72 hours before the date and time of the event. Cancellations between 25-72 hours before the event\\n        may be transferred to a different date\\/time of the same class. Cancellation requests made within 24 hours of the\\n        class date\\/time may not receive a refund or a transfer. When you register for a class, you agree to these terms.\\n    <\\/li>\\n<\\/ol>\"}', '2022-07-04 12:52:24', '2024-01-09 19:25:27'),
(101, 'basic', 'account_recovery.content', '{\"description\":\"Lorem ipsum dolor sit amet. Et consequatur corporis eum laudantium galisum ut nostrum perferendis. Ut tenetur neque eos vitae nulla id itaque possimus aut cupiditate maxime.\"}', '2023-01-30 12:22:26', '2023-01-30 12:22:26'),
(103, 'basic', 'plan_expired.content', '{\"instruction\":\"Your subscription has expired. To continue using our services, please renew your subscription.\"}', '2023-09-11 13:51:05', '2023-09-11 13:51:05'),
(105, 'basic', 'features.content', '{\"heading\":\"Our Features\",\"subheading\":\"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam recusandae aut consequuntur iste sint totam error quae aliquam, ex magni omnis? Cupiditate non optio ullam temporibus. Excepturi illo adipisci quibusdam.\"}', '2023-11-23 18:15:35', '2023-11-23 18:28:55'),
(109, 'basic', 'how_it_work.content', '{\"heading\":\"How It Work\",\"subheading\":\"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam recusandae aut consequuntur iste sint totam error quae aliquam, ex magni omnis? Cupiditate non optio ullam temporibus. Excepturi illo adipisci quibusdam.\"}', '2023-11-23 18:26:47', '2023-11-23 18:26:47'),
(110, 'basic', 'how_it_work.element', '{\"title\":\"Sign up & choose a pricing plan\",\"description\":\"Easy to use and loved by teams. No spying or activity monitoring. Just log the time spent to bill it fairly. Track anywhere using the web app or Telegram bot.\"}', '2023-11-23 18:27:20', '2023-11-23 18:27:20'),
(111, 'basic', 'how_it_work.element', '{\"title\":\"Complete the payment process\",\"description\":\"Easy to use and loved by teams. No spying or activity monitoring. Just log the time spent to bill it fairly. Track anywhere using the web app or Telegram bot.\"}', '2023-11-23 18:27:35', '2023-11-23 18:27:35'),
(112, 'basic', 'how_it_work.element', '{\"title\":\"Configure your system\",\"description\":\"Easy to use and loved by teams. No spying or activity monitoring. Just log the time spent to bill it fairly. Track anywhere using the web app or Telegram bot.\"}', '2023-11-23 18:27:47', '2023-11-23 18:27:47'),
(113, 'basic', 'how_it_work.element', '{\"title\":\"Choose a template for your website\",\"description\":\"Easy to use and loved by teams. No spying or activity monitoring. Just log the time spent to bill it fairly. Track anywhere using the web app or Telegram bot.\"}', '2023-11-23 18:27:56', '2023-11-23 18:27:56'),
(114, 'basic', 'how_it_work.element', '{\"title\":\"Access Hotel Admin Panel\",\"description\":\"Easy to use and loved by teams. No spying or activity monitoring. Just log the time spent to bill it fairly. Track anywhere using the web app or Telegram bot.\"}', '2023-11-23 18:28:12', '2023-11-23 18:28:12'),
(115, 'basic', 'how_it_work.element', '{\"title\":\"Add hotel data & configure setting\",\"description\":\"Easy to use and loved by teams. No spying or activity monitoring. Just log the time spent to bill it fairly. Track anywhere using the web app or Telegram bot.\"}', '2023-11-23 18:28:22', '2023-11-23 18:28:22'),
(117, 'basic', 'social_icon.element', '{\"title\":\"Facebook\",\"social_icon\":\"<i class=\\\"fab fa-facebook-f\\\"><\\/i>\",\"url\":\"https:\\/\\/www.facebook.com\"}', '2023-12-02 08:56:55', '2023-12-02 08:56:55'),
(118, 'basic', 'social_icon.element', '{\"title\":\"Twitter\",\"social_icon\":\"<i class=\\\"fab fa-twitter\\\"><\\/i>\",\"url\":\"https:\\/\\/twitter.com\\/home\"}', '2023-12-02 08:57:10', '2023-12-02 08:57:10'),
(119, 'basic', 'social_icon.element', '{\"title\":\"LinkedIn\",\"social_icon\":\"<i class=\\\"fab fa-linkedin-in\\\"><\\/i>\",\"url\":\"https:\\/\\/www.linkedin.com\\/\"}', '2023-12-02 08:57:31', '2023-12-02 08:57:31'),
(120, 'basic', 'social_icon.element', '{\"title\":\"Instagram\",\"social_icon\":\"<i class=\\\"fab fa-instagram\\\"><\\/i>\",\"url\":\"https:\\/\\/www.instagram.com\\/\"}', '2023-12-02 08:57:53', '2023-12-02 08:57:53'),
(121, 'basic', 'app_link.content', '{\"has_image\":\"1\",\"play_store_link\":\"https:\\/\\/play.google.com\\/store\\/apps?hl=en&gl=US\",\"apple_store_link\":\"https:\\/\\/www.apple.com\\/store\",\"play_store_thumbnail\":\"656aad299994f1701489961.png\",\"apple_store_thumbnail\":\"656aad29cabd41701489961.png\"}', '2023-12-02 09:06:01', '2023-12-02 09:06:01'),
(122, 'basic', 'owner_request.content', '{\"heading\":\"What You Will Get\",\"subheading\":\"Achieve hotel success with our seamless platform\\u2014intuitive dashboards, efficient reservations, secure billing, and 24\\/7 support.\",\"form_title\":\"Send Request To Be An Owner\",\"form_subtitle\":\"By sending request you can be an owner and after approved your request you can maintain your own hotel.\"}', '2023-12-02 09:38:13', '2024-01-09 20:06:53'),
(123, 'basic', 'owner_request.element', '{\"title\":\"You Will Earn Money\",\"description\":\"Optimize profits with our platform\'s lot of financial tools, ensuring unparalleled hotel financial success.\",\"icon\":\"<i class=\\\"fas fa-dollar-sign\\\"><\\/i>\"}', '2023-12-02 09:38:26', '2024-01-09 19:59:19'),
(124, 'basic', 'owner_request.element', '{\"title\":\"Easy to Handle\",\"description\":\"Effortlessly manage your hotel operations with our user-friendly platform, offering an intuitive interface and simplified tools.\",\"icon\":\"<i class=\\\"fas fa-cogs\\\"><\\/i>\"}', '2023-12-02 09:38:40', '2024-01-09 20:00:11'),
(125, 'basic', 'owner_request.element', '{\"title\":\"Monthly Bill Payment System\",\"description\":\"Simplify your monthly bill payments with our streamlined system, ensuring efficient & hassle-free financial management for your hotel.\",\"icon\":\"<i class=\\\"far fa-file-alt\\\"><\\/i>\"}', '2023-12-02 09:38:51', '2024-01-09 20:01:23'),
(126, 'basic', 'owner_request.element', '{\"title\":\"Strong Reporting System\",\"description\":\"Gain powerful insights with our robust reporting system, providing comprehensive analytics & real-time data.\",\"icon\":\"<i class=\\\"las la-receipt\\\"><\\/i>\"}', '2023-12-02 09:39:00', '2024-01-09 20:02:31'),
(127, 'basic', 'vendor_form_data.content', '{\"form_title\":\"By Submitting these information ensure your registration process has been completed\",\"form_subtitle\":\"We check the information and confirm you that you are eligible to continue with us and get our services.\"}', '2023-12-04 13:55:40', '2023-12-04 13:55:40'),
(128, 'basic', 'dashboard_one.content', '{\"has_image\":\"1\",\"image\":\"658d5a3e15b1e1703762494.png\"}', '2023-12-28 16:21:34', '2023-12-28 16:21:34'),
(129, 'basic', 'brand.content', '{\"heading\":\"Used by the word\'s most average companies\"}', '2023-12-28 16:32:41', '2023-12-28 16:32:41'),
(130, 'basic', 'brand.element', '{\"has_image\":\"1\",\"image\":\"65b647f155e581706444785.png\"}', '2023-12-28 16:32:51', '2024-01-28 17:26:25'),
(131, 'basic', 'brand.element', '{\"has_image\":\"1\",\"image\":\"65b648973e93b1706444951.png\"}', '2023-12-28 16:33:00', '2024-01-28 17:29:11'),
(132, 'basic', 'brand.element', '{\"has_image\":\"1\",\"image\":\"65b647fca2b421706444796.png\"}', '2023-12-28 16:33:06', '2024-01-28 17:26:36'),
(133, 'basic', 'brand.element', '{\"has_image\":\"1\",\"image\":\"65b64803a9d121706444803.png\"}', '2023-12-28 16:33:14', '2024-01-28 17:26:43'),
(134, 'basic', 'brand.element', '{\"has_image\":\"1\",\"image\":\"65b6485ea73221706444894.png\"}', '2023-12-28 16:33:20', '2024-01-28 17:28:14'),
(135, 'basic', 'brand.element', '{\"has_image\":\"1\",\"image\":\"65b648358dacb1706444853.png\"}', '2023-12-28 16:33:27', '2024-01-28 17:27:33'),
(136, 'basic', 'brand.element', '{\"has_image\":\"1\",\"image\":\"65b64822226e51706444834.png\"}', '2023-12-28 17:05:50', '2024-01-28 17:27:14'),
(137, 'basic', 'brand.element', '{\"has_image\":\"1\",\"image\":\"65b6487622b9a1706444918.png\"}', '2023-12-28 17:05:56', '2024-01-28 17:28:38'),
(138, 'basic', 'brand.element', '{\"has_image\":\"1\",\"image\":\"65b648302a4891706444848.png\"}', '2023-12-28 17:06:02', '2024-01-28 17:27:28'),
(139, 'basic', 'brand.element', '{\"has_image\":\"1\",\"image\":\"65b6484eb50671706444878.png\"}', '2023-12-28 17:06:08', '2024-01-28 17:27:58'),
(140, 'basic', 'dashboard.content', '{\"has_image\":\"1\",\"image\":\"65968400d24671704363008.png\"}', '2023-12-28 17:10:02', '2024-01-04 15:10:09'),
(142, 'basic', 'feature.content', '{\"heading\":\"We Have a Lot of Functionality\"}', '2023-12-28 17:23:48', '2024-01-04 14:34:07'),
(147, 'basic', 'video.content', '{\"video_link\":\"https:\\/\\/drive.google.com\\/file\\/d\\/1nBEOOyfOVpx9WaZPbHgFhXogWgRFzCts\\/view?usp=sharing\"}', '2023-12-28 17:39:27', '2023-12-28 17:39:27'),
(148, 'basic', 'testimonial.element', '{\"has_image\":\"1\",\"name\":\"Fleur Dotson\",\"designation\":\"Software Devloper\",\"rating\":\"4\",\"review\":\"BookingBox truly impressed! From the welcoming staff to the modern rooms and central location, our stay was delightful. Exceptional service and attention to detail make it a top choice\",\"photo\":\"658d80955467c1703772309.png\"}', '2023-12-28 19:05:09', '2023-12-28 19:05:09'),
(149, 'basic', 'testimonial.element', '{\"has_image\":\"1\",\"name\":\"Donna Meyer\",\"designation\":\"Dancer\",\"rating\":\"4\",\"review\":\"BookingBox exceeded expectations! Outstanding service, stylish rooms, and a convenient location. The staff went above and beyond to ensure a pleasant stay\",\"photo\":\"658d80dee1bc31703772382.png\"}', '2023-12-28 19:06:22', '2023-12-28 19:06:22'),
(150, 'basic', 'cta.content', '{\"has_image\":\"1\",\"heading\":\"Succeed like thousands. Register now!\",\"subheading\":\"Join thousands of thriving hotels and unlock transformative results with our innovative app. Free trial available!\",\"image\":\"65950821398961704265761.png\",\"background_image\":\"6594fb3448c1c1704262452.png\"}', '2023-12-30 14:24:37', '2024-01-03 12:09:21'),
(152, 'basic', 'feature.element', '{\"has_image\":[\"1\"],\"title\":\"Hotel Configuration\",\"features\":\"<ul class=\\\"feature-list\\\">\\r\\n    <li class=\\\"feature-list__item\\\"> <span class=\\\"icon\\\"> <i class=\\\"fas fa-check\\\"><\\/i>\\r\\n        <\\/span>\\u00a0Vendors can configure their hotels.<\\/li>\\r\\n    <li class=\\\"feature-list__item\\\"> <span class=\\\"icon\\\"> <i class=\\\"fas fa-check\\\"><\\/i> <\\/span>\\u00a0Hotel configuration is\\r\\n        fully controllable.<\\/li>\\r\\n    <li class=\\\"feature-list__item\\\"> <span class=\\\"icon\\\"> <i class=\\\"fas fa-check\\\"><\\/i> <\\/span>\\u00a0Only location and\\r\\n        hotel branding can\'t be changed without admin permission.<\\/li>\\r\\n    <li class=\\\"feature-list__item\\\"> <span class=\\\"icon\\\"> <i class=\\\"fas fa-check\\\"><\\/i> <\\/span>\\u00a0Vendors can modify tax\\r\\n        name, tax percentages, and upcoming check-in & checkout lists as they want.<\\/li>\\r\\n<\\/ul>\",\"image\":\"659680d7099331704362199.png\"}', '2023-12-30 17:01:05', '2024-01-04 15:03:51'),
(153, 'basic', 'feature.element', '{\"has_image\":[\"1\"],\"title\":\"Room Management\",\"features\":\"<ul class=\\\"feature-list\\\">\\r\\n    <li class=\\\"feature-list__item\\\"><span class=\\\"icon\\\"><i class=\\\"fas fa-check\\\"><\\/i><\\/span>\\u00a0Vendors can add room types and rooms to their hotels.<\\/li>\\r\\n    <li class=\\\"feature-list__item\\\"><span class=\\\"icon\\\"><i class=\\\"fas fa-check\\\"><\\/i><\\/span>\\u00a0It will controlled by the vendor.<\\/li>\\r\\n    <li class=\\\"feature-list__item\\\"><span class=\\\"icon\\\"><i class=\\\"fas fa-check\\\"><\\/i><\\/span>\\u00a0Vendors can also modify room types and rooms while needed.\\u00a0<\\/li>\\r\\n    <li class=\\\"feature-list__item\\\"><span class=\\\"icon\\\"><i class=\\\"fas fa-check\\\"><\\/i><\\/span>\\u00a0While guest find room they can see vendors available rooms according the total adult and child capacity.<\\/li>\\r\\n<\\/ul>\",\"image\":\"6596824d85e5a1704362573.png\"}', '2023-12-30 17:01:20', '2024-01-04 15:07:15'),
(154, 'basic', 'feature.element', '{\"has_image\":[\"1\"],\"title\":\"Manage Booking Request\",\"features\":\"<ul class=\\\"feature-list\\\">\\r\\n    <li class=\\\"feature-list__item\\\"><span class=\\\"icon\\\"><i class=\\\"fas fa-check\\\"><\\/i><\\/span>\\u00a0Guest booking requests are manageable.<\\/li>\\r\\n    <li class=\\\"feature-list__item\\\"><span class=\\\"icon\\\"><i class=\\\"fas fa-check\\\"><\\/i><\\/span>\\u00a0The vendor can see how many booking requests are sent to his hotel.<\\/li>\\r\\n    <li class=\\\"feature-list__item\\\"><span class=\\\"icon\\\"><i class=\\\"fas fa-check\\\"><\\/i><\\/span>\\u00a0Vendors can approve booking by assigning rooms or also can cancel the booking request.<\\/li>\\r\\n    <li class=\\\"feature-list__item\\\"><span class=\\\"icon\\\"><i class=\\\"fas fa-check\\\"><\\/i><\\/span>\\u00a0For confirmation the booking vendors can charge money from guests if they want, it is a manual process.<\\/li>\\r\\n<\\/ul>\",\"image\":\"659684c7428271704363207.png\"}', '2023-12-30 17:01:59', '2024-01-04 15:13:27'),
(155, 'basic', 'feature.element', '{\"has_image\":[\"1\"],\"title\":\"Room Reservation\",\"features\":\"<ul class=\\\"feature-list\\\">\\r\\n    <li class=\\\"feature-list__item\\\"><span class=\\\"icon\\\"><i class=\\\"fas fa-check\\\"><\\/i><\\/span>\\u00a0Vendors or their assigned staff can book rooms from their panel also.<\\/li>\\r\\n    <li class=\\\"feature-list__item\\\"><span class=\\\"icon\\\"><i class=\\\"fas fa-check\\\"><\\/i><\\/span>\\u00a0It can be for existing guests or walking guests.<\\/li>\\r\\n    <li class=\\\"feature-list__item\\\"><span class=\\\"icon\\\"><i class=\\\"fas fa-check\\\"><\\/i><\\/span>\\u00a0While searching for date date-wise room on the book room page, our system provides the best possible room combination for each date to book.<\\/li>\\r\\n    <li class=\\\"feature-list__item\\\"><span class=\\\"icon\\\"><i class=\\\"fas fa-check\\\"><\\/i><\\/span>\\u00a0The selected room also can be changed.<\\/li>\\r\\n<\\/ul>\",\"image\":\"6596868e246fb1704363662.png\"}', '2023-12-30 17:02:22', '2024-01-04 15:21:02'),
(156, 'basic', 'feature.element', '{\"has_image\":[\"1\"],\"title\":\"Booking Observation\",\"features\":\"<ul class=\\\"feature-list\\\">\\r\\n    <li class=\\\"feature-list__item\\\"><span class=\\\"icon\\\"><i class=\\\"fas fa-check\\\"><\\/i><\\/span>\\u00a0There are huge functionalities to manage booking and observe the booking.<\\/li>\\r\\n    <li class=\\\"feature-list__item\\\"><span class=\\\"icon\\\"><i class=\\\"fas fa-check\\\"><\\/i><\\/span>\\u00a0Vendors can see upcoming check-ins and checkouts.\\u00a0<\\/li>\\r\\n    <li class=\\\"feature-list__item\\\"><span class=\\\"icon\\\"><i class=\\\"fas fa-check\\\"><\\/i><\\/span>\\u00a0Vendors can see delayed checkouts.<\\/li>\\r\\n    <li class=\\\"feature-list__item\\\"><span class=\\\"icon\\\"><i class=\\\"fas fa-check\\\"><\\/i><\\/span>\\u00a0Vendors can also see today\'s available rooms.<\\/li><li class=\\\"feature-list__item\\\"><span class=\\\"icon\\\"><span class=\\\"fas fa-check\\\"><\\/span><\\/span>\\u00a0They can take action against all bookings as they want.<\\/li>\\r\\n<\\/ul>\",\"image\":\"6596877a8a4601704363898.png\"}', '2023-12-30 17:02:50', '2024-01-04 15:24:58'),
(157, 'basic', 'testimonial.element', '{\"has_image\":\"1\",\"name\":\"Thomas Adkins\",\"designation\":\"Receptionist, Hotelion\",\"rating\":\"5\",\"review\":\"Awesome management system for any kind of hotel, easy to handle booking requests, bookings, premium services etc. There are also strong reporting system.\",\"photo\":\"6593e591d74b81704191377.png\"}', '2024-01-02 15:29:37', '2024-01-02 15:31:24'),
(158, 'basic', 'feature.element', '{\"has_image\":[\"1\"],\"title\":\"Flexible Room cancellation\",\"features\":\"<ul class=\\\"feature-list\\\">\\r\\n    <li class=\\\"feature-list__item\\\"><span class=\\\"icon\\\"><i class=\\\"fas fa-check\\\"><\\/i><\\/span>\\u00a0Vendors can cancel any bookings without a past date.<\\/li>\\r\\n    <li class=\\\"feature-list__item\\\"><span class=\\\"icon\\\"><i class=\\\"fas fa-check\\\"><\\/i><\\/span>\\u00a0They can cancel a single room.<\\/li>\\r\\n    <li class=\\\"feature-list__item\\\"><span class=\\\"icon\\\"><i class=\\\"fas fa-check\\\"><\\/i><\\/span>\\u00a0They also can cancel booked rooms on a specific date.<\\/li>\\r\\n    <li class=\\\"feature-list__item\\\"><span class=\\\"icon\\\"><i class=\\\"fas fa-check\\\"><\\/i><\\/span>\\u00a0If possible they also can cancel the full booking.<\\/li>\\r\\n<\\/ul>\",\"image\":\"6596889a5ad601704364186.png\"}', '2024-01-04 11:41:36', '2024-01-04 15:29:46'),
(159, 'basic', 'feature.element', '{\"has_image\":[\"1\"],\"title\":\"Report & Analytics\",\"features\":\"<ul class=\\\"feature-list\\\">\\r\\n    <li class=\\\"feature-list__item\\\"><span class=\\\"icon\\\"><i class=\\\"fas fa-check\\\"><\\/i><\\/span>\\u00a0Vendors can see their booking situations.<\\/li>\\r\\n    <li class=\\\"feature-list__item\\\"><span class=\\\"icon\\\"><i class=\\\"fas fa-check\\\"><\\/i><\\/span>\\u00a0They can filter each report by check-in date range, checkout date range, booking number, guest username, etc.<\\/li>\\r\\n    <li class=\\\"feature-list__item\\\"><span class=\\\"icon\\\"><i class=\\\"fas fa-check\\\"><\\/i><\\/span>\\u00a0Vendors can see the total booking amount, total paid amount, total bookings, and total due amount.<\\/li>\\r\\n    <li class=\\\"feature-list__item\\\"><span class=\\\"icon\\\"><i class=\\\"fas fa-check\\\"><\\/i><\\/span>\\u00a0Vendors also can see their monthly booking report for last 12 months and also can see their monthly payment report.<\\/li>\\r\\n<\\/ul>\",\"image\":\"65968afca2aaf1704364796.png\"}', '2024-01-04 13:43:14', '2024-01-04 15:39:56');

-- --------------------------------------------------------

--
-- Table structure for table `gateways`
--

CREATE TABLE `gateways` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `owner_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `form_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `code` int(11) DEFAULT NULL,
  `name` varchar(40) DEFAULT NULL,
  `alias` varchar(40) NOT NULL DEFAULT 'NULL',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=>enable, 2=>disable',
  `gateway_parameters` text DEFAULT NULL,
  `supported_currencies` text DEFAULT NULL,
  `crypto` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: fiat currency, 1: crypto currency',
  `extra` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gateways`
--

INSERT INTO `gateways` (`id`, `owner_id`, `form_id`, `code`, `name`, `alias`, `status`, `gateway_parameters`, `supported_currencies`, `crypto`, `extra`, `description`, `created_at`, `updated_at`) VALUES
(1, 0, 0, 101, 'Paypal', 'Paypal', 1, '{\"paypal_email\":{\"title\":\"PayPal Email\",\"global\":true,\"value\":\"sb-owud61543012@business.example.com\"}}', '{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"$\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 00:04:38'),
(2, 0, 0, 102, 'Perfect Money', 'PerfectMoney', 1, '{\"passphrase\":{\"title\":\"ALTERNATE PASSPHRASE\",\"global\":true,\"value\":\"hR26aw02Q1eEeUPSIfuwNypXX\"},\"wallet_id\":{\"title\":\"PM Wallet\",\"global\":false,\"value\":\"\"}}', '{\"USD\":\"$\",\"EUR\":\"\\u20ac\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 01:35:33'),
(3, 0, 0, 103, 'Stripe Hosted', 'Stripe', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_51I6GGiCGv1sRiQlEi5v1or9eR0HVbuzdMd2rW4n3DxC8UKfz66R4X6n4yYkzvI2LeAIuRU9H99ZpY7XCNFC9xMs500vBjZGkKG\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51I6GGiCGv1sRiQlEOisPKrjBqQqqcFsw8mXNaZ2H2baN6R01NulFS7dKFji1NRRxuchoUTEDdB7ujKcyKYSVc0z500eth7otOM\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 00:48:36'),
(4, 0, 0, 104, 'Skrill', 'Skrill', 1, '{\"pay_to_email\":{\"title\":\"Skrill Email\",\"global\":true,\"value\":\"merchant@skrill.com\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"---\"}}', '{\"AED\":\"AED\",\"AUD\":\"AUD\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"HRK\":\"HRK\",\"HUF\":\"HUF\",\"ILS\":\"ILS\",\"INR\":\"INR\",\"ISK\":\"ISK\",\"JOD\":\"JOD\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"KWD\":\"KWD\",\"MAD\":\"MAD\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"OMR\":\"OMR\",\"PLN\":\"PLN\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"SAR\":\"SAR\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TND\":\"TND\",\"TRY\":\"TRY\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\",\"COP\":\"COP\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 01:30:16'),
(5, 0, 0, 105, 'PayTM', 'Paytm', 1, '{\"MID\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"DIY12386817555501617\"},\"merchant_key\":{\"title\":\"Merchant Key\",\"global\":true,\"value\":\"bKMfNxPPf_QdZppa\"},\"WEBSITE\":{\"title\":\"Paytm Website\",\"global\":true,\"value\":\"DIYtestingweb\"},\"INDUSTRY_TYPE_ID\":{\"title\":\"Industry Type\",\"global\":true,\"value\":\"Retail\"},\"CHANNEL_ID\":{\"title\":\"CHANNEL ID\",\"global\":true,\"value\":\"WEB\"},\"transaction_url\":{\"title\":\"Transaction URL\",\"global\":true,\"value\":\"https:\\/\\/pguat.paytm.com\\/oltp-web\\/processTransaction\"},\"transaction_status_url\":{\"title\":\"Transaction STATUS URL\",\"global\":true,\"value\":\"https:\\/\\/pguat.paytm.com\\/paytmchecksum\\/paytmCallback.jsp\"}}', '{\"AUD\":\"AUD\",\"ARS\":\"ARS\",\"BDT\":\"BDT\",\"BRL\":\"BRL\",\"BGN\":\"BGN\",\"CAD\":\"CAD\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"HRK\":\"HRK\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EGP\":\"EGP\",\"EUR\":\"EUR\",\"GEL\":\"GEL\",\"GHS\":\"GHS\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"KES\":\"KES\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"MAD\":\"MAD\",\"NPR\":\"NPR\",\"NZD\":\"NZD\",\"NGN\":\"NGN\",\"NOK\":\"NOK\",\"PKR\":\"PKR\",\"PEN\":\"PEN\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"ZAR\":\"ZAR\",\"KRW\":\"KRW\",\"LKR\":\"LKR\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"TRY\":\"TRY\",\"UGX\":\"UGX\",\"UAH\":\"UAH\",\"AED\":\"AED\",\"GBP\":\"GBP\",\"USD\":\"USD\",\"VND\":\"VND\",\"XOF\":\"XOF\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 03:00:44'),
(6, 0, 0, 106, 'Payeer', 'Payeer', 1, '{\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"866989763\"},\"secret_key\":{\"title\":\"Secret key\",\"global\":true,\"value\":\"7575\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"RUB\":\"RUB\"}', 0, '{\"status\":{\"title\": \"Status URL\",\"value\":\"ipn.Payeer\"}}', NULL, '2019-09-14 13:14:22', '2022-08-28 10:11:14'),
(7, 0, 0, 107, 'PayStack', 'Paystack', 1, '{\"public_key\":{\"title\":\"Public key\",\"global\":true,\"value\":\"pk_test_cd330608eb47970889bca397ced55c1dd5ad3783\"},\"secret_key\":{\"title\":\"Secret key\",\"global\":true,\"value\":\"sk_test_8a0b1f199362d7acc9c390bff72c4e81f74e2ac3\"}}', '{\"USD\":\"USD\",\"NGN\":\"NGN\"}', 0, '{\"callback\":{\"title\": \"Callback URL\",\"value\":\"ipn.Paystack\"},\"webhook\":{\"title\": \"Webhook URL\",\"value\":\"ipn.Paystack\"}}\r\n', NULL, '2019-09-14 13:14:22', '2021-05-21 01:49:51'),
(8, 0, 0, 108, 'VoguePay', 'Voguepay', 1, '{\"merchant_id\":{\"title\":\"MERCHANT ID\",\"global\":true,\"value\":\"demo\"}}', '{\"USD\":\"USD\",\"GBP\":\"GBP\",\"EUR\":\"EUR\",\"GHS\":\"GHS\",\"NGN\":\"NGN\",\"ZAR\":\"ZAR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 01:22:38'),
(9, 0, 0, 109, 'Flutterwave', 'Flutterwave', 1, '{\"public_key\":{\"title\":\"Public Key\",\"global\":true,\"value\":\"----------------\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"-----------------------\"},\"encryption_key\":{\"title\":\"Encryption Key\",\"global\":true,\"value\":\"------------------\"}}', '{\"BIF\":\"BIF\",\"CAD\":\"CAD\",\"CDF\":\"CDF\",\"CVE\":\"CVE\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"GHS\":\"GHS\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"KES\":\"KES\",\"LRD\":\"LRD\",\"MWK\":\"MWK\",\"MZN\":\"MZN\",\"NGN\":\"NGN\",\"RWF\":\"RWF\",\"SLL\":\"SLL\",\"STD\":\"STD\",\"TZS\":\"TZS\",\"UGX\":\"UGX\",\"USD\":\"USD\",\"XAF\":\"XAF\",\"XOF\":\"XOF\",\"ZMK\":\"ZMK\",\"ZMW\":\"ZMW\",\"ZWD\":\"ZWD\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-06-05 11:37:45'),
(10, 0, 0, 110, 'RazorPay', 'Razorpay', 1, '{\"key_id\":{\"title\":\"Key Id\",\"global\":true,\"value\":\"rzp_test_kiOtejPbRZU90E\"},\"key_secret\":{\"title\":\"Key Secret \",\"global\":true,\"value\":\"osRDebzEqbsE1kbyQJ4y0re7\"}}', '{\"INR\":\"INR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 02:51:32'),
(11, 0, 0, 111, 'Stripe Storefront', 'StripeJs', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_51I6GGiCGv1sRiQlEi5v1or9eR0HVbuzdMd2rW4n3DxC8UKfz66R4X6n4yYkzvI2LeAIuRU9H99ZpY7XCNFC9xMs500vBjZGkKG\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51I6GGiCGv1sRiQlEOisPKrjBqQqqcFsw8mXNaZ2H2baN6R01NulFS7dKFji1NRRxuchoUTEDdB7ujKcyKYSVc0z500eth7otOM\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 00:53:10'),
(12, 0, 0, 112, 'Instamojo', 'Instamojo', 1, '{\"api_key\":{\"title\":\"API KEY\",\"global\":true,\"value\":\"test_2241633c3bc44a3de84a3b33969\"},\"auth_token\":{\"title\":\"Auth Token\",\"global\":true,\"value\":\"test_279f083f7bebefd35217feef22d\"},\"salt\":{\"title\":\"Salt\",\"global\":true,\"value\":\"19d38908eeff4f58b2ddda2c6d86ca25\"}}', '{\"INR\":\"INR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 02:56:20'),
(13, 0, 0, 501, 'Blockchain', 'Blockchain', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"55529946-05ca-48ff-8710-f279d86b1cc5\"},\"xpub_code\":{\"title\":\"XPUB CODE\",\"global\":true,\"value\":\"xpub6CKQ3xxWyBoFAF83izZCSFUorptEU9AF8TezhtWeMU5oefjX3sFSBw62Lr9iHXPkXmDQJJiHZeTRtD9Vzt8grAYRhvbz4nEvBu3QKELVzFK\"}}', '{\"BTC\":\"BTC\"}', 1, NULL, NULL, '2019-09-14 13:14:22', '2022-03-21 07:41:56'),
(15, 0, 0, 503, 'CoinPayments', 'Coinpayments', 1, '{\"public_key\":{\"title\":\"Public Key\",\"global\":true,\"value\":\"---------------\"},\"private_key\":{\"title\":\"Private Key\",\"global\":true,\"value\":\"------------\"},\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"93a1e014c4ad60a7980b4a7239673cb4\"}}', '{\"BTC\":\"Bitcoin\",\"BTC.LN\":\"Bitcoin (Lightning Network)\",\"LTC\":\"Litecoin\",\"CPS\":\"CPS Coin\",\"VLX\":\"Velas\",\"APL\":\"Apollo\",\"AYA\":\"Aryacoin\",\"BAD\":\"Badcoin\",\"BCD\":\"Bitcoin Diamond\",\"BCH\":\"Bitcoin Cash\",\"BCN\":\"Bytecoin\",\"BEAM\":\"BEAM\",\"BITB\":\"Bean Cash\",\"BLK\":\"BlackCoin\",\"BSV\":\"Bitcoin SV\",\"BTAD\":\"Bitcoin Adult\",\"BTG\":\"Bitcoin Gold\",\"BTT\":\"BitTorrent\",\"CLOAK\":\"CloakCoin\",\"CLUB\":\"ClubCoin\",\"CRW\":\"Crown\",\"CRYP\":\"CrypticCoin\",\"CRYT\":\"CryTrExCoin\",\"CURE\":\"CureCoin\",\"DASH\":\"DASH\",\"DCR\":\"Decred\",\"DEV\":\"DeviantCoin\",\"DGB\":\"DigiByte\",\"DOGE\":\"Dogecoin\",\"EBST\":\"eBoost\",\"EOS\":\"EOS\",\"ETC\":\"Ether Classic\",\"ETH\":\"Ethereum\",\"ETN\":\"Electroneum\",\"EUNO\":\"EUNO\",\"EXP\":\"EXP\",\"Expanse\":\"Expanse\",\"FLASH\":\"FLASH\",\"GAME\":\"GameCredits\",\"GLC\":\"Goldcoin\",\"GRS\":\"Groestlcoin\",\"KMD\":\"Komodo\",\"LOKI\":\"LOKI\",\"LSK\":\"LSK\",\"MAID\":\"MaidSafeCoin\",\"MUE\":\"MonetaryUnit\",\"NAV\":\"NAV Coin\",\"NEO\":\"NEO\",\"NMC\":\"Namecoin\",\"NVST\":\"NVO Token\",\"NXT\":\"NXT\",\"OMNI\":\"OMNI\",\"PINK\":\"PinkCoin\",\"PIVX\":\"PIVX\",\"POT\":\"PotCoin\",\"PPC\":\"Peercoin\",\"PROC\":\"ProCurrency\",\"PURA\":\"PURA\",\"QTUM\":\"QTUM\",\"RES\":\"Resistance\",\"RVN\":\"Ravencoin\",\"RVR\":\"RevolutionVR\",\"SBD\":\"Steem Dollars\",\"SMART\":\"SmartCash\",\"SOXAX\":\"SOXAX\",\"STEEM\":\"STEEM\",\"STRAT\":\"STRAT\",\"SYS\":\"Syscoin\",\"TPAY\":\"TokenPay\",\"TRIGGERS\":\"Triggers\",\"TRX\":\" TRON\",\"UBQ\":\"Ubiq\",\"UNIT\":\"UniversalCurrency\",\"USDT\":\"Tether USD (Omni Layer)\",\"USDT.BEP20\":\"Tether USD (BSC Chain)\",\"USDT.ERC20\":\"Tether USD (ERC20)\",\"USDT.TRC20\":\"Tether USD (Tron/TRC20)\",\"VTC\":\"Vertcoin\",\"WAVES\":\"Waves\",\"XCP\":\"Counterparty\",\"XEM\":\"NEM\",\"XMR\":\"Monero\",\"XSN\":\"Stakenet\",\"XSR\":\"SucreCoin\",\"XVG\":\"VERGE\",\"XZC\":\"ZCoin\",\"ZEC\":\"ZCash\",\"ZEN\":\"Horizen\"}', 1, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 02:07:14'),
(16, 0, 0, 504, 'CoinPayments Fiat', 'CoinpaymentsFiat', 1, '{\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"6515561\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"ISK\":\"ISK\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"RUB\":\"RUB\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TWD\":\"TWD\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 02:07:44'),
(17, 0, 0, 505, 'Coingate', 'Coingate', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"6354mwVCEw5kHzRJ6thbGo-N\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2022-03-30 09:24:57'),
(18, 0, 0, 506, 'Coinbase Commerce', 'CoinbaseCommerce', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"c47cd7df-d8e8-424b-a20a\"},\"secret\":{\"title\":\"Webhook Shared Secret\",\"global\":true,\"value\":\"55871878-2c32-4f64-ab66\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"JPY\":\"JPY\",\"GBP\":\"GBP\",\"AUD\":\"AUD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CNY\":\"CNY\",\"SEK\":\"SEK\",\"NZD\":\"NZD\",\"MXN\":\"MXN\",\"SGD\":\"SGD\",\"HKD\":\"HKD\",\"NOK\":\"NOK\",\"KRW\":\"KRW\",\"TRY\":\"TRY\",\"RUB\":\"RUB\",\"INR\":\"INR\",\"BRL\":\"BRL\",\"ZAR\":\"ZAR\",\"AED\":\"AED\",\"AFN\":\"AFN\",\"ALL\":\"ALL\",\"AMD\":\"AMD\",\"ANG\":\"ANG\",\"AOA\":\"AOA\",\"ARS\":\"ARS\",\"AWG\":\"AWG\",\"AZN\":\"AZN\",\"BAM\":\"BAM\",\"BBD\":\"BBD\",\"BDT\":\"BDT\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"BIF\":\"BIF\",\"BMD\":\"BMD\",\"BND\":\"BND\",\"BOB\":\"BOB\",\"BSD\":\"BSD\",\"BTN\":\"BTN\",\"BWP\":\"BWP\",\"BYN\":\"BYN\",\"BZD\":\"BZD\",\"CDF\":\"CDF\",\"CLF\":\"CLF\",\"CLP\":\"CLP\",\"COP\":\"COP\",\"CRC\":\"CRC\",\"CUC\":\"CUC\",\"CUP\":\"CUP\",\"CVE\":\"CVE\",\"CZK\":\"CZK\",\"DJF\":\"DJF\",\"DKK\":\"DKK\",\"DOP\":\"DOP\",\"DZD\":\"DZD\",\"EGP\":\"EGP\",\"ERN\":\"ERN\",\"ETB\":\"ETB\",\"FJD\":\"FJD\",\"FKP\":\"FKP\",\"GEL\":\"GEL\",\"GGP\":\"GGP\",\"GHS\":\"GHS\",\"GIP\":\"GIP\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"GTQ\":\"GTQ\",\"GYD\":\"GYD\",\"HNL\":\"HNL\",\"HRK\":\"HRK\",\"HTG\":\"HTG\",\"HUF\":\"HUF\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"IMP\":\"IMP\",\"IQD\":\"IQD\",\"IRR\":\"IRR\",\"ISK\":\"ISK\",\"JEP\":\"JEP\",\"JMD\":\"JMD\",\"JOD\":\"JOD\",\"KES\":\"KES\",\"KGS\":\"KGS\",\"KHR\":\"KHR\",\"KMF\":\"KMF\",\"KPW\":\"KPW\",\"KWD\":\"KWD\",\"KYD\":\"KYD\",\"KZT\":\"KZT\",\"LAK\":\"LAK\",\"LBP\":\"LBP\",\"LKR\":\"LKR\",\"LRD\":\"LRD\",\"LSL\":\"LSL\",\"LYD\":\"LYD\",\"MAD\":\"MAD\",\"MDL\":\"MDL\",\"MGA\":\"MGA\",\"MKD\":\"MKD\",\"MMK\":\"MMK\",\"MNT\":\"MNT\",\"MOP\":\"MOP\",\"MRO\":\"MRO\",\"MUR\":\"MUR\",\"MVR\":\"MVR\",\"MWK\":\"MWK\",\"MYR\":\"MYR\",\"MZN\":\"MZN\",\"NAD\":\"NAD\",\"NGN\":\"NGN\",\"NIO\":\"NIO\",\"NPR\":\"NPR\",\"OMR\":\"OMR\",\"PAB\":\"PAB\",\"PEN\":\"PEN\",\"PGK\":\"PGK\",\"PHP\":\"PHP\",\"PKR\":\"PKR\",\"PLN\":\"PLN\",\"PYG\":\"PYG\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"RWF\":\"RWF\",\"SAR\":\"SAR\",\"SBD\":\"SBD\",\"SCR\":\"SCR\",\"SDG\":\"SDG\",\"SHP\":\"SHP\",\"SLL\":\"SLL\",\"SOS\":\"SOS\",\"SRD\":\"SRD\",\"SSP\":\"SSP\",\"STD\":\"STD\",\"SVC\":\"SVC\",\"SYP\":\"SYP\",\"SZL\":\"SZL\",\"THB\":\"THB\",\"TJS\":\"TJS\",\"TMT\":\"TMT\",\"TND\":\"TND\",\"TOP\":\"TOP\",\"TTD\":\"TTD\",\"TWD\":\"TWD\",\"TZS\":\"TZS\",\"UAH\":\"UAH\",\"UGX\":\"UGX\",\"UYU\":\"UYU\",\"UZS\":\"UZS\",\"VEF\":\"VEF\",\"VND\":\"VND\",\"VUV\":\"VUV\",\"WST\":\"WST\",\"XAF\":\"XAF\",\"XAG\":\"XAG\",\"XAU\":\"XAU\",\"XCD\":\"XCD\",\"XDR\":\"XDR\",\"XOF\":\"XOF\",\"XPD\":\"XPD\",\"XPF\":\"XPF\",\"XPT\":\"XPT\",\"YER\":\"YER\",\"ZMW\":\"ZMW\",\"ZWL\":\"ZWL\"}\r\n\r\n', 0, '{\"endpoint\":{\"title\": \"Webhook Endpoint\",\"value\":\"ipn.CoinbaseCommerce\"}}', NULL, '2019-09-14 13:14:22', '2021-05-21 02:02:47'),
(24, 0, 0, 113, 'Paypal Express', 'PaypalSdk', 1, '{\"clientId\":{\"title\":\"Paypal Client ID\",\"global\":true,\"value\":\"Ae0-tixtSV7DvLwIh3Bmu7JvHrjh5EfGdXr_cEklKAVjjezRZ747BxKILiBdzlKKyp-W8W_T7CKH1Ken\"},\"clientSecret\":{\"title\":\"Client Secret\",\"global\":true,\"value\":\"EOhbvHZgFNO21soQJT1L9Q00M3rK6PIEsdiTgXRBt2gtGtxwRer5JvKnVUGNU5oE63fFnjnYY7hq3HBA\"}}', '{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"$\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-20 23:01:08'),
(25, 0, 0, 114, 'Stripe Checkout', 'StripeV3', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_51I6GGiCGv1sRiQlEi5v1or9eR0HVbuzdMd2rW4n3DxC8UKfz66R4X6n4yYkzvI2LeAIuRU9H99ZpY7XCNFC9xMs500vBjZGkKG\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51I6GGiCGv1sRiQlEOisPKrjBqQqqcFsw8mXNaZ2H2baN6R01NulFS7dKFji1NRRxuchoUTEDdB7ujKcyKYSVc0z500eth7otOM\"},\"end_point\":{\"title\":\"End Point Secret\",\"global\":true,\"value\":\"whsec_lUmit1gtxwKTveLnSe88xCSDdnPOt8g5\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, '{\"webhook\":{\"title\": \"Webhook Endpoint\",\"value\":\"ipn.StripeV3\"}}', NULL, '2019-09-14 13:14:22', '2021-05-21 00:58:38'),
(27, 0, 0, 115, 'Mollie', 'Mollie', 1, '{\"mollie_email\":{\"title\":\"Mollie Email \",\"global\":true,\"value\":\"vi@gmail.com\"},\"api_key\":{\"title\":\"API KEY\",\"global\":true,\"value\":\"test_cucfwKTWfft9s337qsVfn5CC4vNkrn\"}}', '{\"AED\":\"AED\",\"AUD\":\"AUD\",\"BGN\":\"BGN\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"HRK\":\"HRK\",\"HUF\":\"HUF\",\"ILS\":\"ILS\",\"ISK\":\"ISK\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 02:44:45'),
(30, 0, 0, 116, 'Cashmaal', 'Cashmaal', 1, '{\"web_id\":{\"title\":\"Web Id\",\"global\":true,\"value\":\"3748\"},\"ipn_key\":{\"title\":\"IPN Key\",\"global\":true,\"value\":\"546254628759524554647987\"}}', '{\"PKR\":\"PKR\",\"USD\":\"USD\"}', 0, '{\"webhook\":{\"title\": \"IPN URL\",\"value\":\"ipn.Cashmaal\"}}', NULL, NULL, '2021-06-22 08:05:04'),
(36, 0, 0, 119, 'Mercado Pago', 'MercadoPago', 1, '{\"access_token\":{\"title\":\"Access Token\",\"global\":true,\"value\":\"APP_USR-7924565816849832-082312-21941521997fab717db925cf1ea2c190-1071840315\"}}', '{\"USD\":\"USD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"NOK\":\"NOK\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"AUD\":\"AUD\",\"NZD\":\"NZD\"}', 0, NULL, NULL, NULL, '2022-09-14 07:41:14'),
(37, 0, 0, 120, 'Authorize.net', 'Authorize', 1, '{\"login_id\":{\"title\":\"Login ID\",\"global\":true,\"value\":\"59e4P9DBcZv\"},\"transaction_key\":{\"title\":\"Transaction Key\",\"global\":true,\"value\":\"47x47TJyLw2E7DbR\"}}', '{\"USD\":\"USD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"NOK\":\"NOK\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"AUD\":\"AUD\",\"NZD\":\"NZD\"}', 0, NULL, NULL, NULL, '2022-08-28 09:33:06'),
(46, 0, 0, 121, 'NMI', 'NMI', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"2F822Rw39fx762MaV7Yy86jXGTC7sCDy\"}}', '{\"AED\":\"AED\",\"ARS\":\"ARS\",\"AUD\":\"AUD\",\"BOB\":\"BOB\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PEN\":\"PEN\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"PYG\":\"PYG\",\"RUB\":\"RUB\",\"SEC\":\"SEC\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TRY\":\"TRY\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\"}', 0, NULL, NULL, NULL, '2022-08-28 10:32:31'),
(51, 0, 0, 122, 'BTCPay', 'BTCPay', 1, '{\"store_id\":{\"title\":\"Store Id\",\"global\":true,\"value\":\"-------\"},\"api_key\":{\"title\":\"Api Key\",\"global\":true,\"value\":\"------\"},\"server_name\":{\"title\":\"Server Name\",\"global\":true,\"value\":\"https:\\/\\/yourbtcpaserver.lndyn.com\"},\"secret_code\":{\"title\":\"Secret Code\",\"global\":true,\"value\":\"----------\"}}', '{\"BTC\":\"Bitcoin\",\"LTC\":\"Litecoin\"}', 1, '{\"webhook\":{\"title\": \"IPN URL\",\"value\":\"ipn.BTCPay\"}}', NULL, NULL, NULL),
(52, 0, 0, 123, 'Now payments hosted', 'NowPaymentsHosted', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"-------------------\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"--------------\"}}', '{\"BTG\":\"BTG\",\"ETH\":\"ETH\",\"XMR\":\"XMR\",\"ZEC\":\"ZEC\",\"XVG\":\"XVG\",\"ADA\":\"ADA\",\"LTC\":\"LTC\",\"BCH\":\"BCH\",\"QTUM\":\"QTUM\",\"DASH\":\"DASH\",\"XLM\":\"XLM\",\"XRP\":\"XRP\",\"XEM\":\"XEM\",\"DGB\":\"DGB\",\"LSK\":\"LSK\",\"DOGE\":\"DOGE\",\"TRX\":\"TRX\",\"KMD\":\"KMD\",\"REP\":\"REP\",\"BAT\":\"BAT\",\"ARK\":\"ARK\",\"WAVES\":\"WAVES\",\"BNB\":\"BNB\",\"XZC\":\"XZC\",\"NANO\":\"NANO\",\"TUSD\":\"TUSD\",\"VET\":\"VET\",\"ZEN\":\"ZEN\",\"GRS\":\"GRS\",\"FUN\":\"FUN\",\"NEO\":\"NEO\",\"GAS\":\"GAS\",\"PAX\":\"PAX\",\"USDC\":\"USDC\",\"ONT\":\"ONT\",\"XTZ\":\"XTZ\",\"LINK\":\"LINK\",\"RVN\":\"RVN\",\"BNBMAINNET\":\"BNBMAINNET\",\"ZIL\":\"ZIL\",\"BCD\":\"BCD\",\"USDT\":\"USDT\",\"USDTERC20\":\"USDTERC20\",\"CRO\":\"CRO\",\"DAI\":\"DAI\",\"HT\":\"HT\",\"WABI\":\"WABI\",\"BUSD\":\"BUSD\",\"ALGO\":\"ALGO\",\"USDTTRC20\":\"USDTTRC20\",\"GT\":\"GT\",\"STPT\":\"STPT\",\"AVA\":\"AVA\",\"SXP\":\"SXP\",\"UNI\":\"UNI\",\"OKB\":\"OKB\",\"BTC\":\"BTC\"}', 1, '', NULL, NULL, '2023-02-14 04:42:09'),
(53, 0, 0, 509, 'Now payments checkout', 'NowPaymentsCheckout', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"-------------------\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"--------------\"}}', '{\"BTG\":\"BTG\",\"ETH\":\"ETH\",\"XMR\":\"XMR\",\"ZEC\":\"ZEC\",\"XVG\":\"XVG\",\"ADA\":\"ADA\",\"LTC\":\"LTC\",\"BCH\":\"BCH\",\"QTUM\":\"QTUM\",\"DASH\":\"DASH\",\"XLM\":\"XLM\",\"XRP\":\"XRP\",\"XEM\":\"XEM\",\"DGB\":\"DGB\",\"LSK\":\"LSK\",\"DOGE\":\"DOGE\",\"TRX\":\"TRX\",\"KMD\":\"KMD\",\"REP\":\"REP\",\"BAT\":\"BAT\",\"ARK\":\"ARK\",\"WAVES\":\"WAVES\",\"BNB\":\"BNB\",\"XZC\":\"XZC\",\"NANO\":\"NANO\",\"TUSD\":\"TUSD\",\"VET\":\"VET\",\"ZEN\":\"ZEN\",\"GRS\":\"GRS\",\"FUN\":\"FUN\",\"NEO\":\"NEO\",\"GAS\":\"GAS\",\"PAX\":\"PAX\",\"USDC\":\"USDC\",\"ONT\":\"ONT\",\"XTZ\":\"XTZ\",\"LINK\":\"LINK\",\"RVN\":\"RVN\",\"BNBMAINNET\":\"BNBMAINNET\",\"ZIL\":\"ZIL\",\"BCD\":\"BCD\",\"USDT\":\"USDT\",\"USDTERC20\":\"USDTERC20\",\"CRO\":\"CRO\",\"DAI\":\"DAI\",\"HT\":\"HT\",\"WABI\":\"WABI\",\"BUSD\":\"BUSD\",\"ALGO\":\"ALGO\",\"USDTTRC20\":\"USDTTRC20\",\"GT\":\"GT\",\"STPT\":\"STPT\",\"AVA\":\"AVA\",\"SXP\":\"SXP\",\"UNI\":\"UNI\",\"OKB\":\"OKB\",\"BTC\":\"BTC\"}', 1, '', NULL, NULL, '2023-02-14 04:42:09'),
(54, 0, 0, 122, '2Checkout', 'TwoCheckout', 1, '{\"merchant_code\": {\"title\": \"Merchant Code\",\"global\": true,\"value\": \"---------\"},\"secret_key\": {\"title\": \"Secret Key\",\"global\": true,\"value\": \"--------\"}}', '{\"AFN\": \"AFN\",\"ALL\": \"ALL\",\"DZD\": \"DZD\",\"ARS\": \"ARS\",\"AUD\": \"AUD\",\"AZN\": \"AZN\",\"BSD\": \"BSD\",\"BDT\": \"BDT\",\"BBD\": \"BBD\",\"BZD\": \"BZD\",\"BMD\": \"BMD\",\"BOB\": \"BOB\",\"BWP\": \"BWP\",\"BRL\": \"BRL\",\"GBP\": \"GBP\",\"BND\": \"BND\",\"BGN\": \"BGN\",\"CAD\": \"CAD\",\"CLP\": \"CLP\",\"CNY\": \"CNY\",\"COP\": \"COP\",\"CRC\": \"CRC\",\"HRK\": \"HRK\",\"CZK\": \"CZK\",\"DKK\": \"DKK\",\"DOP\": \"DOP\",\"XCD\": \"XCD\",\"EGP\": \"EGP\",\"EUR\": \"EUR\",\"FJD\": \"FJD\",\"GTQ\": \"GTQ\",\"HKD\": \"HKD\",\"HNL\": \"HNL\",\"HUF\": \"HUF\",\"INR\": \"INR\",\"IDR\": \"IDR\",\"ILS\": \"ILS\",\"JMD\": \"JMD\",\"JPY\": \"JPY\",\"KZT\": \"KZT\",\"KES\": \"KES\",\"LAK\": \"LAK\",\"MMK\": \"MMK\",\"LBP\": \"LBP\",\"LRD\": \"LRD\",\"MOP\": \"MOP\",\"MYR\": \"MYR\",\"MVR\": \"MVR\",\"MRO\": \"MRO\",\"MUR\": \"MUR\",\"MXN\": \"MXN\",\"MAD\": \"MAD\",\"NPR\": \"NPR\",\"TWD\": \"TWD\",\"NZD\": \"NZD\",\"NIO\": \"NIO\",\"NOK\": \"NOK\",\"PKR\": \"PKR\",\"PGK\": \"PGK\",\"PEN\": \"PEN\",\"PHP\": \"PHP\",\"PLN\": \"PLN\",\"QAR\": \"QAR\",\"RON\": \"RON\",\"RUB\": \"RUB\",\"WST\": \"WST\",\"SAR\": \"SAR\",\"SCR\": \"SCR\",\"SGD\": \"SGD\",\"SBD\": \"SBD\",\"ZAR\": \"ZAR\",\"KRW\": \"KRW\",\"LKR\": \"LKR\",\"SEK\": \"SEK\",\"CHF\": \"CHF\",\"SYP\": \"SYP\",\"THB\": \"THB\",\"TOP\": \"TOP\",\"TTD\": \"TTD\",\"TRY\": \"TRY\",\"UAH\": \"UAH\",\"AED\": \"AED\",\"USD\": \"USD\",\"VUV\": \"VUV\",\"VND\": \"VND\",\"XOF\": \"XOF\",\"YER\": \"YER\"}', 1, '{\"approved_url\":{\"title\": \"Approved URL\",\"value\":\"ipn.TwoCheckout\"}}', NULL, NULL, '2023-02-14 04:42:09'),
(55, 0, 0, 123, 'Checkout', 'Checkout', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_f7f9a069-dcc5-45d8-aa72-e60f605c9514\"},\"public_key\":{\"title\":\"PUBLIC KEY\",\"global\":true,\"value\":\"pk_66e19b3f-a431-44ff-823f-d773d960f6b9\"},\"processing_channel_id\":{\"title\":\"PROCESSING CHANNEL\",\"global\":true,\"value\":\"---\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"AUD\":\"AUD\",\"CAN\":\"CAN\",\"CHF\":\"CHF\",\"SGD\":\"SGD\",\"JPY\":\"JPY\",\"NZD\":\"NZD\"}', 0, NULL, NULL, NULL, NULL),
(56, 0, 3, 1000, 'TCash', 'tcash', 1, '[]', '[]', 0, NULL, 'Fill up the form given below:', '2023-11-01 12:52:50', '2023-11-01 12:52:50');

-- --------------------------------------------------------

--
-- Table structure for table `gateway_currencies`
--

CREATE TABLE `gateway_currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) DEFAULT NULL,
  `currency` varchar(40) DEFAULT NULL,
  `symbol` varchar(40) DEFAULT NULL,
  `method_code` int(11) DEFAULT NULL,
  `gateway_alias` varchar(40) DEFAULT NULL,
  `min_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `max_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `percent_charge` decimal(5,2) NOT NULL DEFAULT 0.00,
  `fixed_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `rate` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `image` varchar(255) DEFAULT NULL,
  `gateway_parameter` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `site_name` varchar(40) DEFAULT NULL,
  `cur_text` varchar(40) DEFAULT NULL COMMENT 'currency text',
  `cur_sym` varchar(40) DEFAULT NULL COMMENT 'currency symbol',
  `email_from` varchar(40) DEFAULT NULL,
  `email_template` text DEFAULT NULL,
  `firebase_template` text DEFAULT NULL,
  `sms_body` varchar(255) DEFAULT NULL,
  `sms_from` varchar(255) DEFAULT NULL,
  `base_color` varchar(40) DEFAULT NULL,
  `mail_config` text DEFAULT NULL COMMENT 'email configuration',
  `sms_config` text DEFAULT NULL,
  `global_shortcodes` text DEFAULT NULL,
  `kv` tinyint(1) NOT NULL DEFAULT 0,
  `ev` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'email verification, 0 - dont check, 1 - check',
  `en` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'email notification, 0 - dont send, 1 - send',
  `sv` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'mobile verication, 0 - dont check, 1 - check',
  `sn` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'sms notification, 0 - dont send, 1 - send',
  `multi_language` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1⇾Enable, 0⇾Disable',
  `maintenance_mode` tinyint(4) NOT NULL DEFAULT 1,
  `force_ssl` tinyint(1) NOT NULL DEFAULT 0,
  `secure_password` tinyint(1) NOT NULL DEFAULT 0,
  `agree` tinyint(1) NOT NULL DEFAULT 0,
  `registration` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: Off	, 1: On',
  `active_template` varchar(40) DEFAULT NULL,
  `is_enable_owner_request` tinyint(1) NOT NULL DEFAULT 1,
  `system_info` text DEFAULT NULL,
  `system_customized` tinyint(1) NOT NULL DEFAULT 0,
  `bill_per_month` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `payment_before` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `max_star_rating` int(11) NOT NULL DEFAULT 0,
  `popularity_count_from` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `remind_before_days` text DEFAULT NULL,
  `maximum_payment_month` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `app_video` text DEFAULT NULL,
  `last_cron` datetime DEFAULT NULL,
  `push_notify` tinyint(1) NOT NULL DEFAULT 0,
  `firebase_config` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `site_name`, `cur_text`, `cur_sym`, `email_from`, `email_template`, `firebase_template`, `sms_body`, `sms_from`, `base_color`, `mail_config`, `sms_config`, `global_shortcodes`, `kv`, `ev`, `en`, `sv`, `sn`, `multi_language`, `maintenance_mode`, `force_ssl`, `secure_password`, `agree`, `registration`, `active_template`, `is_enable_owner_request`, `system_info`, `system_customized`, `bill_per_month`, `payment_before`, `max_star_rating`, `popularity_count_from`, `remind_before_days`, `maximum_payment_month`, `app_video`, `last_cron`, `push_notify`, `firebase_config`, `created_at`, `updated_at`) VALUES
(1, 'BookingBox', 'USD', '$', 'info@viserlab.com', '<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n  <!--[if !mso]><!-->\r\n  <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\r\n  <!--<![endif]-->\r\n  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\r\n  <title></title>\r\n  <style type=\"text/css\">\r\n.ReadMsgBody { width: 100%; background-color: #ffffff; }\r\n.ExternalClass { width: 100%; background-color: #ffffff; }\r\n.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div { line-height: 100%; }\r\nhtml { width: 100%; }\r\nbody { -webkit-text-size-adjust: none; -ms-text-size-adjust: none; margin: 0; padding: 0; }\r\ntable { border-spacing: 0; table-layout: fixed; margin: 0 auto;border-collapse: collapse; }\r\ntable table table { table-layout: auto; }\r\n.yshortcuts a { border-bottom: none !important; }\r\nimg:hover { opacity: 0.9 !important; }\r\na { color: #0087ff; text-decoration: none; }\r\n.textbutton a { font-family: \'open sans\', arial, sans-serif !important;}\r\n.btn-link a { color:#FFFFFF !important;}\r\n\r\n@media only screen and (max-width: 480px) {\r\nbody { width: auto !important; }\r\n*[class=\"table-inner\"] { width: 90% !important; text-align: center !important; }\r\n*[class=\"table-full\"] { width: 100% !important; text-align: center !important; }\r\n/* image */\r\nimg[class=\"img1\"] { width: 100% !important; height: auto !important; }\r\n}\r\n</style>\r\n\r\n\r\n\r\n  <table bgcolor=\"#414a51\" width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n    <tbody><tr>\r\n      <td height=\"50\"></td>\r\n    </tr>\r\n    <tr>\r\n      <td align=\"center\" style=\"text-align:center;vertical-align:top;font-size:0;\">\r\n        <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n          <tbody><tr>\r\n            <td align=\"center\" width=\"600\">\r\n              <!--header-->\r\n              <table class=\"table-inner\" width=\"95%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                <tbody><tr>\r\n                  <td bgcolor=\"#0087ff\" style=\"border-top-left-radius:6px; border-top-right-radius:6px;text-align:center;vertical-align:top;font-size:0;\" align=\"center\">\r\n                    <table width=\"90%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                      <tbody><tr>\r\n                        <td height=\"20\"></td>\r\n                      </tr>\r\n                      <tr>\r\n                        <td align=\"center\" style=\"font-family: \'Open sans\', Arial, sans-serif; color:#FFFFFF; font-size:16px; font-weight: bold;\">This is a System Generated Email</td>\r\n                      </tr>\r\n                      <tr>\r\n                        <td height=\"20\"></td>\r\n                      </tr>\r\n                    </tbody></table>\r\n                  </td>\r\n                </tr>\r\n              </tbody></table>\r\n              <!--end header-->\r\n              <table class=\"table-inner\" width=\"95%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n                <tbody><tr>\r\n                  <td bgcolor=\"#FFFFFF\" align=\"center\" style=\"text-align:center;vertical-align:top;font-size:0;\">\r\n                    <table align=\"center\" width=\"90%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n                      <tbody><tr>\r\n                        <td height=\"35\"></td>\r\n                      </tr>\r\n                      <!--logo-->\r\n                      <tr>\r\n                        <td align=\"center\" style=\"vertical-align:top;font-size:0;\">\r\n                          <a href=\"#\">\r\n                            <img style=\"display:block; line-height:0px; font-size:0px; border:0px;\" src=\"https://i.imgur.com/Z1qtvtV.png\" alt=\"img\">\r\n                          </a>\r\n                        </td>\r\n                      </tr>\r\n                      <!--end logo-->\r\n                      <tr>\r\n                        <td height=\"40\"></td>\r\n                      </tr>\r\n                      <!--headline-->\r\n                      <tr>\r\n                        <td align=\"center\" style=\"font-family: \'Open Sans\', Arial, sans-serif; font-size: 22px;color:#414a51;font-weight: bold;\">Hello {{fullname}}</td>\r\n                      </tr>\r\n                      <!--end headline-->\r\n                      <tr>\r\n                        <td align=\"center\" style=\"text-align:center;vertical-align:top;font-size:0;\">\r\n                          <table width=\"40\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                            <tbody><tr>\r\n                              <td height=\"20\" style=\" border-bottom:3px solid #0087ff;\"></td>\r\n                            </tr>\r\n                          </tbody></table>\r\n                        </td>\r\n                      </tr>\r\n                      <tr>\r\n                        <td height=\"20\"></td>\r\n                      </tr>\r\n                      <!--content-->\r\n                      <tr>\r\n                        <td align=\"left\" style=\"font-family: \'Open sans\', Arial, sans-serif; color:#7f8c8d; font-size:16px; line-height: 28px;\">{{message}}</td>\r\n                      </tr>\r\n                      <!--end content-->\r\n                      <tr>\r\n                        <td height=\"40\"></td>\r\n                      </tr>\r\n              \r\n                    </tbody></table>\r\n                  </td>\r\n                </tr>\r\n                <tr>\r\n                  <td height=\"45\" align=\"center\" bgcolor=\"#f4f4f4\" style=\"border-bottom-left-radius:6px;border-bottom-right-radius:6px;\">\r\n                    <table align=\"center\" width=\"90%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n                      <tbody><tr>\r\n                        <td height=\"10\"></td>\r\n                      </tr>\r\n                      <!--preference-->\r\n                      <tr>\r\n                        <td class=\"preference-link\" align=\"center\" style=\"font-family: \'Open sans\', Arial, sans-serif; color:#95a5a6; font-size:14px;\">\r\n                          © 2021 <a href=\"#\">Website Name</a> . All Rights Reserved. \r\n                        </td>\r\n                      </tr>\r\n                      <!--end preference-->\r\n                      <tr>\r\n                        <td height=\"10\"></td>\r\n                      </tr>\r\n                    </tbody></table>\r\n                  </td>\r\n                </tr>\r\n              </tbody></table>\r\n            </td>\r\n          </tr>\r\n        </tbody></table>\r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td height=\"60\"></td>\r\n    </tr>\r\n  </tbody></table>', 'hi {{fullname}}, {{message}}', 'hi {{fullname}}, {{message}}', 'SMS From Viserlab Admin', '069eff', '{\"name\":\"php\"}', '{\"name\":\"clickatell\",\"clickatell\":{\"api_key\":\"AAAAajheBL0:APA91bFkALYOOezyaw_divqV_jMI4U_wpbcNrLhYw00o8VDkSWmiJpArXOKrC8ysCrpi16wQtvBPjosU95q-qjvGpXFv2Mzba0ENDMns5mBWkKHRvVqe9Z7y2_GoIheompNbpgipiwcu\"},\"infobip\":{\"username\":\"------------\",\"password\":\"-----------------\"},\"message_bird\":{\"api_key\":\"-------------------\"},\"nexmo\":{\"api_key\":\"----------------------\",\"api_secret\":\"----------------------\"},\"sms_broadcast\":{\"username\":\"----------------------\",\"password\":\"-----------------------------\"},\"twilio\":{\"account_sid\":\"-----------------------\",\"auth_token\":\"---------------------------\",\"from\":\"----------------------\"},\"text_magic\":{\"username\":\"-----------------------\",\"apiv2_key\":\"-------------------------------\"},\"custom\":{\"method\":\"get\",\"url\":\"https:\\/\\/hostname\\/demo-api-v1\",\"headers\":{\"name\":[\"api_key\"],\"value\":[\"test_api 555\"]},\"body\":{\"name\":[\"from_number\"],\"value\":[\"5657545757\"]}}}', '{\n    \"site_name\":\"Name of your site\",\n    \"site_currency\":\"Currency of your site\",\n    \"currency_symbol\":\"Symbol of currency\"\n}', 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 1, 'basic', 1, '[]', 0, 100.00000000, 12, 5, 10, '[\"1\",\"3\",\"5\"]', 12, '659d0f787e5ec1704791928.mp4', '2023-12-03 12:16:38', 1, '{\"apiKey\":\"AIzaSyCwoCBGDYPzL-BWDNImb82rk3eqFCZGTNg\",\"authDomain\":\"tradelab-f5e8b.firebaseapp.com\",\"projectId\":\"viserlab-global-app-eaedd\",\"storageBucket\":\"tradelab-f5e8b.appspot.com\",\"messagingSenderId\":\"33806775204\",\"appId\":\"1:456212219069:android:efa8638c825fc6699123d4\",\"measurementId\":\"G-DY0DRM5BJ9\",\"serverKey\":\"AAAAajheBL0:APA91bFkALYOOezyaw_divqV_jMI4U_wpbcNrLhYw00o8VDkSWmiJpArXOKrC8ysCrpi16wQtvBPjosU95q-qjvGpXFv2Mzba0ENDMns5mBWkKHRvVqe9Z7y2_GoIheompNbpgipiwcu\"}', NULL, '2024-01-28 08:07:27');

-- --------------------------------------------------------

--
-- Table structure for table `guests`
--

CREATE TABLE `guests` (
  `id` bigint(20) NOT NULL,
  `name` varchar(40) DEFAULT NULL,
  `mobile` varchar(40) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hotel_settings`
--

CREATE TABLE `hotel_settings` (
  `id` bigint(20) NOT NULL,
  `owner_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `star_rating` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `image` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,6) NOT NULL DEFAULT 0.000000,
  `longitude` decimal(10,6) NOT NULL DEFAULT 0.000000,
  `hotel_address` varchar(255) DEFAULT NULL,
  `country_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `city_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `location_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `tax_name` varchar(40) DEFAULT NULL,
  `tax_percentage` decimal(5,2) NOT NULL DEFAULT 0.00,
  `checkin_time` time DEFAULT NULL,
  `checkout_time` time DEFAULT NULL,
  `upcoming_checkin_days` int(10) UNSIGNED NOT NULL,
  `upcoming_checkout_days` int(10) UNSIGNED NOT NULL,
  `confirmation_amount_percentage` decimal(5,2) NOT NULL DEFAULT 0.00 COMMENT 'Ex: should payment 30% of total amount',
  `description` text DEFAULT NULL,
  `keywords` text DEFAULT NULL,
  `cancellation_policy` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) DEFAULT NULL,
  `code` varchar(40) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: not default language, 1: default language',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `icon`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', NULL, 1, '2023-10-31 12:03:54', '2023-10-31 12:03:54'),
(2, 'Bangla', 'bn', NULL, 0, '2023-10-31 12:04:02', '2023-10-31 12:04:02'),
(3, 'Hindi', 'hn', NULL, 0, '2023-10-31 12:04:09', '2023-10-31 12:04:09');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) NOT NULL,
  `city_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `name` varchar(40) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_logs`
--

CREATE TABLE `notification_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `owner_id` int(10) UNSIGNED NOT NULL,
  `sender` varchar(40) DEFAULT NULL,
  `sent_from` varchar(40) DEFAULT NULL,
  `sent_to` varchar(40) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `notification_type` varchar(40) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_templates`
--

CREATE TABLE `notification_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `act` varchar(40) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `subj` varchar(255) DEFAULT NULL,
  `email_body` text DEFAULT NULL,
  `sms_body` text DEFAULT NULL,
  `shortcodes` text DEFAULT NULL,
  `email_status` tinyint(1) NOT NULL DEFAULT 1,
  `sms_status` tinyint(1) NOT NULL DEFAULT 1,
  `firebase_status` tinyint(1) NOT NULL DEFAULT 0,
  `firebase_body` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_templates`
--

INSERT INTO `notification_templates` (`id`, `act`, `name`, `subj`, `email_body`, `sms_body`, `shortcodes`, `email_status`, `sms_status`, `firebase_status`, `firebase_body`, `created_at`, `updated_at`) VALUES
(1, 'BAL_ADD', 'Balance Added', 'Your Account Has Been Credited', '<div><div style=\"font-family: Montserrat, sans-serif;\">{{amount}} {{site_currency}} has been added to your account .</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><span style=\"color: rgb(33, 37, 41); font-family: Montserrat, sans-serif;\">Your Current Balance is :&nbsp;</span><font style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">{{post_balance}}&nbsp; {{site_currency}}&nbsp;</span></font><br></div><div><font style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></font></div><div>Admin note:&nbsp;<span style=\"color: rgb(33, 37, 41); font-size: 12px; font-weight: 600; white-space: nowrap; text-align: var(--bs-body-text-align);\">{{remark}}</span></div>', '{{amount}} {{site_currency}} credited in your account. Your Current Balance {{post_balance}} {{site_currency}} . Transaction: #{{trx}}. Admin note is \"{{remark}}\"', '{\"trx\":\"Transaction number for the action\",\"amount\":\"Amount inserted by the admin\",\"remark\":\"Remark inserted by the admin\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, 0, 1, 'Test Notification', '2021-11-03 06:00:00', '2023-11-04 13:35:13'),
(2, 'BAL_SUB', 'Balance Subtracted', 'Your Account Has Been Debited', '<div style=\"font-family: Montserrat, sans-serif;\">{{amount}} {{site_currency}} has been subtracted from your account .</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><span style=\"color: rgb(33, 37, 41); font-family: Montserrat, sans-serif;\">Your Current Balance is :&nbsp;</span><font style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">{{post_balance}}&nbsp; {{site_currency}}</span></font><br><div><font style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></font></div><div>Admin Note: {{remark}}</div>', '{{amount}} {{site_currency}} debited from your account. Your Current Balance {{post_balance}} {{site_currency}} . Transaction: #{{trx}}. Admin Note is {{remark}}', '{\"trx\":\"Transaction number for the action\",\"amount\":\"Amount inserted by the admin\",\"remark\":\"Remark inserted by the admin\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, 1, 0, NULL, '2021-11-03 06:00:00', '2022-04-02 20:24:11'),
(3, 'DIRECT_PAYMENT_SUCCESSFUL', 'Automatic Payment Succeeded', 'Payment Completed Successfully', '<div>Your payment for&nbsp;<span style=\"font-weight: 700; font-size: 1rem; text-align: var(--bs-body-text-align);\">{{booking_number}}</span><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">&nbsp;of&nbsp;</span><span style=\"font-size: 1rem; text-align: var(--bs-body-text-align); font-weight: bolder;\">{{amount}} {{site_currency}}</span><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">&nbsp;via&nbsp;&nbsp;</span><span style=\"font-size: 1rem; text-align: var(--bs-body-text-align); font-weight: bolder;\">{{method_name}}&nbsp;</span><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">has&nbsp; been completed Successfully.</span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your payment:<br></span></div><div><br></div><div>Amount : {{amount}} {{site_currency}}</div><div>Charge:&nbsp;<font color=\"#000000\">{{charge}} {{site_currency}}</font></div><div><br></div><div>Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div>Payable : {{method_amount}} {{method_currency}}<br></div><div>Paid via :&nbsp; {{method_name}}</div><div><br style=\"font-family: Montserrat, sans-serif;\"></div>', '{{amount}} {{site_currency}} payment successfully by {{method_name}}', '{\r\n                \"booking_number\":\"Booking Number\",\r\n                \"amount\":\"Amount inserted by the user\",\r\n                \"charge\":\"Gateway charge set by the admin\",\r\n                \"rate\":\"Conversion rate between base currency and method currency\",\r\n                \"method_name\":\"Name of the deposit method\",\r\n                \"method_currency\":\"Currency of the deposit method\",\r\n                \"method_amount\":\"Amount after conversion between base currency and method currency\"\r\n            }', 1, 0, 1, 'Your booking payment process completed successfully', '2021-11-03 12:00:00', '2023-11-04 13:37:06'),
(4, 'PAYMENT_MANUAL_APPROVED', 'Automatic Payment Approved', 'Your Payment is Approved', '<div style=\"font-family: Montserrat, sans-serif;\">Your payment request&nbsp;<span style=\"color: rgb(33, 37, 41); font-family: Poppins, sans-serif; font-size: 1rem; text-align: var(--bs-body-text-align);\">for&nbsp;</span><span style=\"font-family: Poppins, sans-serif; font-size: 1rem; text-align: var(--bs-body-text-align); font-weight: 700;\">{{booking_number}}</span><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">&nbsp;of&nbsp;</span><span style=\"font-size: 1rem; text-align: var(--bs-body-text-align); font-weight: bolder;\">{{amount}}{{site_currency}}</span><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">&nbsp;via&nbsp;&nbsp;</span><span style=\"font-size: 1rem; text-align: var(--bs-body-text-align); font-weight: bolder;\">{{method_name}}&nbsp;</span><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">is Approved .</span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your payment:<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : {{amount}} {{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Payable : {{method_amount}} {{method_currency}}<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; {{method_name}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div>', 'Management Approve Your {{amount}} {{method_currency}} payment request by {{method_name}} Booking Number: {{booking_number}}', '{\"booking_number\":\"Booking Number\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, 1, 0, NULL, '2021-11-03 12:00:00', '2022-06-29 22:42:35'),
(6, 'PAYMENT_MANUAL_REQUEST', 'Manual Payment Request Sent', 'Payment Request Submitted Successfully', '<div>Your payment request&nbsp;<span style=\"color: rgb(33, 37, 41); font-size: 1rem; text-align: var(--bs-body-text-align);\">for&nbsp;</span><span style=\"font-size: 1rem; text-align: var(--bs-body-text-align); font-weight: 700;\">{{booking_number}}</span><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">&nbsp;of&nbsp;</span><span style=\"font-size: 1rem; text-align: var(--bs-body-text-align); font-weight: bolder;\">{{amount}} {{site_currency}}</span><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">&nbsp;via&nbsp;&nbsp;</span><span style=\"font-size: 1rem; text-align: var(--bs-body-text-align); font-weight: bolder;\">{{method_name}}&nbsp;</span><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">submitted successfully</span><span style=\"font-size: 1rem; text-align: var(--bs-body-text-align); font-weight: bolder;\">&nbsp;.</span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your payment:<br></span></div><div><br></div><div>Amount : {{amount}} {{site_currency}}</div><div>Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div><br></div><div>Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div>Payable : {{method_amount}} {{method_currency}}<br></div><div>Pay via :&nbsp; {{method_name}}</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div>', '{{amount}} Payment requested by {{method_name}}. Charge: {{charge}} . Booking Number: {{booking_number}}', '{\"booking_number\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\"}', 1, 1, 0, NULL, '2021-11-03 12:00:00', '2022-06-29 22:42:04'),
(7, 'PASS_RESET_CODE', 'Reset Password Code Sent', 'Password Reset', '<div style=\"font-family: Montserrat, sans-serif;\">We have received a request to reset the password for your account on&nbsp;<span style=\"font-weight: bolder;\">{{time}} .<br></span></div><div style=\"font-family: Montserrat, sans-serif;\">Requested From IP:&nbsp;<span style=\"font-weight: bolder;\">{{ip}}</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">{{browser}}</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">{{operating_system}}&nbsp;</span>.</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><br style=\"font-family: Montserrat, sans-serif;\"><div style=\"font-family: Montserrat, sans-serif;\"><div>Your account recovery code is:&nbsp;&nbsp;&nbsp;<font size=\"6\"><span style=\"font-weight: bolder;\">{{code}}</span></font></div><div><br></div></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\" color=\"#CC0000\">If you do not wish to reset your password, please disregard this message.&nbsp;</font><br></div><div><font size=\"4\" color=\"#CC0000\"><br></font></div>', 'Your account recovery code is: {{code}}', '{\"code\":\"Verification code for password reset\",\"ip\":\"IP address of the user\",\"browser\":\"Browser of the user\",\"operating_system\":\"Operating system of the user\",\"time\":\"Time of the request\"}', 1, 0, 0, NULL, '2021-11-03 12:00:00', '2022-03-20 20:47:05'),
(8, 'PASS_RESET_DONE', 'Password Reset Succeeded', 'Password Changed Successfully', '<p style=\"font-family: Montserrat, sans-serif;\">You have successfully reset your password.</p><p style=\"font-family: Montserrat, sans-serif;\">You changed from&nbsp; IP:&nbsp;<span style=\"font-weight: bolder;\">{{ip}}</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">{{browser}}</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">{{operating_system}}&nbsp;</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">{{time}}</span></p><p style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></p><p style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><font color=\"#ff0000\">If you did not changed that, Please contact with us as soon as possible.</font></span></p>', 'Your password has been changed successfully', '{\"ip\":\"IP address of the user\",\"browser\":\"Browser of the user\",\"operating_system\":\"Operating system of the user\",\"time\":\"Time of the request\"}', 1, 1, 0, NULL, '2021-11-03 12:00:00', '2022-03-20 20:47:25'),
(9, 'ADMIN_SUPPORT_REPLY', 'Support Ticket Replied', 'Support Ticket Reply', '<div><p><span data-mce-style=\"font-size: 11pt;\" style=\"font-size: 11pt;\"><span style=\"font-weight: bolder;\">A member from our support team has replied to the following ticket:</span></span></p><p><span style=\"font-weight: bolder;\"><span data-mce-style=\"font-size: 11pt;\" style=\"font-size: 11pt;\"><span style=\"font-weight: bolder;\"><br></span></span></span></p><p><span style=\"font-weight: bolder;\">[Ticket#{{ticket_id}}] {{ticket_subject}}<br><br>Click here to reply:&nbsp; {{link}}</span></p><p>----------------------------------------------</p><p>Here is the reply :<br></p><p>{{reply}}<br></p></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div>', 'Your Ticket#{{ticket_id}} :  {{ticket_subject}} has been replied.', '{\"ticket_id\":\"ID of the support ticket\",\"ticket_subject\":\"Subject  of the support ticket\",\"reply\":\"Reply made by the admin\",\"link\":\"URL to view the support ticket\"}', 1, 1, 0, NULL, '2021-11-03 12:00:00', '2022-03-20 20:47:51'),
(10, 'EVER_CODE', 'Email Verification Code Sent', 'Email Verification Code', '<br><div><div style=\"font-family: Montserrat, sans-serif;\">Thanks For join with us.<br></div><div style=\"font-family: Montserrat, sans-serif;\">Please use below code to verify your email address.<br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Your email verification code is:<font size=\"6\"><span style=\"font-weight: bolder;\">&nbsp;{{code}}</span></font></div></div>', '---', '{\"code\":\"Email verification code\"}', 1, 0, 0, NULL, '2021-11-03 12:00:00', '2022-03-20 20:49:35'),
(11, 'SVER_CODE', 'Mobile Verification Code Sent', 'Mobile Verification Code', '---', 'Your phone verification code is: {{code}}', '{\"code\":\"SMS Verification Code\"}', 0, 1, 0, NULL, '2021-11-03 12:00:00', '2022-03-20 19:24:37'),
(15, 'DEFAULT', 'Default Template', NULL, '{{message}}', '{{message}}', '{\"subject\":\"Subject\",\"message\":\"Message\"}', 1, 0, 1, '{{message}}', '2019-09-14 13:14:22', '2023-11-04 13:44:42'),
(18, 'ACCOUNT_CREATE', 'Vendor Account Created', 'Vendor Account Created', '<br><div><div style=\"font-family: Montserrat, sans-serif;\">Thanks For join with us.<br></div><div style=\"font-family: Montserrat, sans-serif;\">Now you can log in by this credentials:<br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">username: {{username}}&nbsp;</div><div style=\"font-family: Montserrat, sans-serif;\">email: {{email}}</div><div style=\"font-family: Montserrat, sans-serif;\">password:{{password}}</div>\r\n</div>', '---', '{\"username\":\"username\", \r\n\"email\":\"email\", \"password\":\"password\"}', 1, 0, 0, NULL, '2021-11-03 12:00:00', '2022-04-10 08:30:01'),
(19, 'BOOKING_REQUEST_APPROVED', 'Booking Request Approved', 'Booking Request Approved', '<div style=\"font-family: Montserrat, sans-serif;\">Thanks for booking rooms here.</div><div style=\"font-family: Montserrat, sans-serif;\">Booking Number: {{booking_number}},</div><div style=\"font-family: Montserrat, sans-serif;\">Total Amount:{{amount}}&nbsp;<span style=\"white-space: nowrap; font-family: Poppins, sans-serif; text-align: var(--bs-body-text-align);\"><font size=\"3\">{{site_currency}}</font></span><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">,</span></div><div style=\"\"><span style=\"font-family: Montserrat, sans-serif; color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">Paid Amount :&nbsp;</span><span style=\"text-align: var(--bs-body-text-align);\"><font color=\"#212529\" face=\"Montserrat, sans-serif\">{{paid_amount}}&nbsp;</font></span><span style=\"text-align: var(--bs-body-text-align);\"><font color=\"#212529\" face=\"Montserrat, sans-serif\">{{site_currency}}</font></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Check In Date : {{check_in}}</div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"color: rgb(33, 37, 41);\">Check Out Date : {{check_out}}</span><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"color: rgb(33, 37, 41);\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"3\"><u><b>Booked Rooms:</b></u></font></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"color: rgb(33, 37, 41);\">&nbsp;{{rooms}}</span><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"3\"><b style=\"\"><br></b></font></div>\r\n<div><div style=\"font-family: Montserrat, sans-serif;\">Thanks for being with us.</div></div>', 'Thanks for booking room here. Booking Number : {{booking_number}}, Paid Amount:{{paid_amount}} {{site_currency}} instead of \r\n Your booked rooms: {{rooms}} .', '{\"booking_number\":\"Booking number for the action\",\"amount\":\"Booking total amount\",\r\n\"paid_amount\":\"Paid amount for booking\", \"rooms\":\"booked rooms list\",\"check_in\":\"Check In date\", \"check_out\": \"Check Out Date\"}', 1, 0, 1, 'Your booking request has been approved. Booking Number: #{{booking_number}}', '2021-11-03 12:00:00', '2024-01-22 19:24:39'),
(21, 'BOOKING_REQUEST_CANCELED', 'Booking Request Canceled', 'Booking Request Canceled', '<div><div style=\"font-family: Montserrat, sans-serif;\">Your booking request for&nbsp;<span style=\"color: rgb(33, 37, 41); font-size: 1rem; text-align: var(--bs-body-text-align);\">{{check_in}}&nbsp; to {{check_out}} for <b>{{room_type}}</b></span><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">&nbsp;</span><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">has been cancelled</span><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">.</span></div></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"3\"><b style=\"\"><br></b></font></div>', 'Your booking request for {{check_in}}  to {{check_out}} for {{room_type}} has been cancelled.', '{\"room_type\":\"Room Type\",\"number_of_rooms\":\"Number of Rooms\",\"check_in\":\"Check in date\", \"check_out\": \"Check Out Date\"}', 1, 0, 1, 'Booking Request Canceled', '2021-11-03 06:00:00', '2024-01-22 17:59:11'),
(22, 'BOOKING_CANCELED', 'Booking Canceled', 'Booking Canceled', '<div><div style=\"font-family: Montserrat, sans-serif;\">Your booking&nbsp; for&nbsp;<span style=\"color: rgb(33, 37, 41); font-size: 1rem; text-align: var(--bs-body-text-align);\">{{check_in}}&nbsp; to {{check_out}}&nbsp;</span><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">has been canceled</span><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">.</span></div></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">Booking Number:</span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"color: rgb(33, 37, 41); font-family: Poppins, sans-serif; font-size: 12px; font-weight: 600; white-space: nowrap;\">{{booking_number}}</span><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">Booked rooms:</span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"color: rgb(33, 37, 41); font-family: Poppins, sans-serif; font-size: 12px; font-weight: 600; white-space: nowrap;\">{{rooms}}</span><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"3\"><b style=\"\"><br></b></font></div>', 'Your booking request for {{check_in}}  to {{check_out}} has been canceled.\r\nBooking Number: {{booking_number}}', '{\"booking_number\":\"Booking Number\",\"rooms\":\"rooms\",\"check_in\":\"Check in date\", \"check_out\": \"Check Out Date\"}', 1, 0, 1, 'Booking cancel successfully', '2021-11-03 12:00:00', '2024-01-22 17:58:33'),
(23, 'PAYMENT_MANUAL_REJECT', 'Manual Payment Rejected', 'Payment is Rejected', '<div style=\"font-family: Montserrat, sans-serif;\">Your payment request&nbsp;<span style=\"color: rgb(33, 37, 41); font-family: Poppins, sans-serif; font-size: 1rem; text-align: var(--bs-body-text-align);\">for&nbsp;</span><span style=\"font-family: Poppins, sans-serif; font-size: 1rem; text-align: var(--bs-body-text-align); font-weight: 700;\">{{booking_number}}</span><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">&nbsp;of&nbsp;</span><span style=\"font-size: 1rem; text-align: var(--bs-body-text-align); font-weight: bolder;\">{{amount}}{{site_currency}}</span><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">&nbsp;via&nbsp;&nbsp;</span><span style=\"font-size: 1rem; text-align: var(--bs-body-text-align); font-weight: bolder;\">{{method_name}}&nbsp;</span><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">is rejected.</span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your payment:<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : {{amount}} {{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Payable : {{method_amount}} {{method_currency}}<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; {{method_name}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div>', 'Management reject your {{amount}} {{method_currency}} payment request by {{method_name}} Booking Number: {{booking_number}}', '{\"booking_number\":\"Booking Number\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, 0, 1, 'Payment successfull', '2021-11-03 12:00:00', '2023-11-04 13:36:08'),
(24, 'BOOKING_CANCELED_BY_DATE', 'Booking Canceled for Specific Date', 'Booking Canceled for Specific Date', '<div><div style=\"font-family: Montserrat, sans-serif;\">Your booking for&nbsp;<span style=\"color: rgb(33, 37, 41); font-size: 1rem; text-align: var(--bs-body-text-align);\">{{date}}&nbsp;</span><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">has been canceled</span><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">.</span></div></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">Booking Number:</span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"color: rgb(33, 37, 41); font-family: Poppins, sans-serif; font-size: 12px; font-weight: 600; white-space: nowrap;\">{{booking_number}}</span><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">Booked rooms:</span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"color: rgb(33, 37, 41); font-family: Poppins, sans-serif; font-size: 12px; font-weight: 600; white-space: nowrap;\">{{rooms}}</span><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"3\"><b style=\"\"><br></b></font></div>', 'Your booking request for {{date}} has been canceled.\r\nBooking Number: {{booking_number}}', '{\"booking_number\":\"Booking Number\",\"rooms\":\"rooms\",\"date\":\"The Date of Booked For\"}', 1, 0, 0, NULL, '2021-11-03 12:00:00', '2022-07-03 09:46:50'),
(27, 'CANCEL_BOOKED_ROOM', 'Room Booking Canceled', 'Room Booking Canceled', '<div><div style=\"font-family: Montserrat, sans-serif;\">Room&nbsp;{{room_number}} for&nbsp;{{date}} has been canceled successfully.&nbsp;</div></div><div style=\"font-family: Montserrat, sans-serif;\">Booking Number :&nbsp;{{booking_number}}</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"3\"><b style=\"\"><br></b></font></div>', 'Room {{room_number}} for {{date}} has been canceled successfully. \r\nBooking Number : {{booking_number}}', '{\"booking_number\":\"Booking Number\",\"room_number\":\"Cancelled Room\", \"date\":\"Booking Date\"}', 1, 0, 0, NULL, '2021-11-03 12:00:00', '2023-04-30 06:55:09'),
(31, 'OWNER_REQUEST_APPROVED', 'Vendor Account Request Approved', 'Vendor Account Request Approved', 'Your request to be an owner of this system has been approved. Now you can log in to the owner panel by using these credentials:<div><br><div>Email:&nbsp;{{email}}</div><div>Password:&nbsp;{{password}}</div><div><br></div><div>Login URL:&nbsp;{{login_url}}<br><br><font color=\"#cc3300\">N:B: Change your password after login for your security.&nbsp;</font><br><br></div></div>', 'Your request to be an owner of this system has been approved. Now you can log in to the owner panel by using these credentials:\r\n\r\nEmail: {{email}}\r\nPassword: {{password}}\r\n\r\nLogin URL: {{login_url}}', '{\"email\":\"email\",\"password\":\"password\", \"login_url\":\"Login URL\"}', 1, 0, 0, 'Your request to be an owner of this system has been approved. Now you can log in to the owner panel by using these credentials:\r\n\r\nEmail: {{email}}\r\nPassword: {{password}}\r\n\r\nLogin URL: {{login_url}}', '2021-11-03 06:00:00', '2023-12-02 11:45:51'),
(32, 'OWNER_REQUEST_REJECTED', 'Vendor Account Request Rejected', 'Vendor Account Request Rejected', '<div style=\"font-family: Montserrat, sans-serif;\">Your request to be an owner with username&nbsp;{{username}} has been rejected by admin.</div>', 'Your request to be an owner with username {{username}} has been rejected by admin.', '{\"username\": \"username\"}', 1, 0, 0, NULL, '2021-11-03 06:00:00', '2023-09-09 06:34:02'),
(33, 'BILL_PAYMENT_COMPLETED', 'Subscription Bill Paid ', 'Subscription Bill Paid Successfully', '<div style=\"font-family: Montserrat, sans-serif;\">Your bill payment has been completed.</div><div style=\"font-family: Montserrat, sans-serif;\">You pay for&nbsp;{{total_month}} months.</div><div style=\"font-family: Montserrat, sans-serif;\">Details of your payment:&nbsp;</div><div style=\"font-family: Montserrat, sans-serif;\">Bill per month:&nbsp;{{amount_per_month}}</div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">Amount:&nbsp;{{amount}}&nbsp;</span><span style=\"font-family: Poppins, sans-serif; text-align: var(--bs-body-text-align);\"><font color=\"#212529\" face=\"Montserrat, sans-serif\">{{site_currency}}</font></span><br></div><span style=\"color: rgb(33, 37, 41); font-family: Montserrat, sans-serif;\">Gateway Charge:&nbsp;{{charge}} {{site_currency}}</span><div><font face=\"Montserrat, sans-serif\">Final Amount: {{final_amount}}<br></font><div style=\"font-family: Montserrat, sans-serif;\">Transaction number:&nbsp;{{trx}}&nbsp;</div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\"><br></span></div><div style=\"\"><span style=\"font-family: Montserrat, sans-serif; color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">You can continue in our system until&nbsp;</span><span style=\"text-align: var(--bs-body-text-align);\"><font color=\"#212529\" face=\"Montserrat, sans-serif\">{{expire_at}}</font></span></div></div>', 'Your bill payment has been completed.\r\nYou pay for {{total_month}} months.\r\nDetails of your payment: \r\nBill per month: {{amount_per_month}}\r\nAmount: {{amount}} {{site_currency}}\r\nGateway Charge: {{charge}} {{site_currency}}\r\nFinal Amount: {{final_amount}}\r\nTransaction number: {{trx}} \r\n\r\nYou can continue in our system until {{expire_at}}', '{\"amount_per_month\": \"Bill Per Month\",\"total_month\":\"Bill payment for\",\"amount\":\"Billing Amount\",\"charge\":\"Gateway charge\",\"final_amount\":\"Final Amount\",\"expire_at\":\"Expire At\",\"trx\":\"Transaction Number\"}', 1, 0, 0, NULL, '2021-11-03 12:00:00', '2023-11-02 05:51:56'),
(36, 'BILL_PAYMENT_MANUAL', 'Subscription Bill Payment Request Sent', 'Subscription Bill Payment Request Sent', '<div>Your payment request&nbsp;<span style=\"color: rgb(33, 37, 41); font-size: 1rem; text-align: var(--bs-body-text-align);\">for&nbsp;</span><span style=\"text-align: var(--bs-body-text-align);\"><b>{{total_month}}</b><span style=\"font-size: 1rem;\"><b>&nbsp;months</b></span></span><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">&nbsp;of&nbsp;</span><span style=\"font-size: 1rem; text-align: var(--bs-body-text-align); font-weight: bolder;\">{{amount}} {{site_currency}}</span><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">&nbsp;via&nbsp;&nbsp;</span><span style=\"font-size: 1rem; text-align: var(--bs-body-text-align); font-weight: bolder;\">{{method_name}}&nbsp;</span><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">submitted successfully</span><span style=\"font-size: 1rem; text-align: var(--bs-body-text-align); font-weight: bolder;\">&nbsp;.</span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your payment:<br></span></div><div><br></div><div>Amount : {{amount}} {{site_currency}}</div><div>Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div><br></div><div>Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div>Payable : {{method_amount}} {{method_currency}}<br></div><div>Pay via :&nbsp; {{method_name}}</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div>', '{{amount}} Payment requested by {{method_name}}. Charge: {{charge}} . Month: {{total_month}}', '{\"total_month\":\"Payment for total months\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\"}', 1, 0, 0, NULL, '2021-11-03 12:00:00', '2023-11-02 08:11:09'),
(37, 'BILL_PAYMENT_MANUAL_REJECT', 'Subscription Bill Payment Request Rejected', 'Subscription Bill Payment Request Rejected', '<div style=\"\"><font face=\"Montserrat, sans-serif\">Your payment request&nbsp;</font><span style=\"font-family: Poppins, sans-serif; color: rgb(33, 37, 41); font-size: 1rem; text-align: var(--bs-body-text-align);\">for&nbsp;</span><span style=\"text-align: var(--bs-body-text-align);\"><b>{{total_month}}</b></span><span style=\"font-family: Montserrat, sans-serif; color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">&nbsp;months of&nbsp;</span><span style=\"font-family: Montserrat, sans-serif; font-size: 1rem; text-align: var(--bs-body-text-align); font-weight: bolder;\">{{amount}}{{site_currency}}</span><span style=\"font-family: Montserrat, sans-serif; color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">&nbsp;via&nbsp;&nbsp;</span><span style=\"font-family: Montserrat, sans-serif; font-size: 1rem; text-align: var(--bs-body-text-align); font-weight: bolder;\">{{method_name}}&nbsp;</span><span style=\"font-family: Montserrat, sans-serif; color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">is rejected.</span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your payment:<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : {{amount}} {{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Payable : {{method_amount}} {{method_currency}}<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; {{method_name}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Rejection Reason:&nbsp;{{rejection_reason}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div>', 'Your payment request for {{total_month}} months of {{amount}}{{site_currency}} via  {{method_name}} is rejected.\r\n\r\nDetails of your payment:\r\n\r\nAmount : {{amount}} {{site_currency}}\r\nCharge: {{charge}} {{site_currency}}\r\n\r\nConversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}\r\nPayable : {{method_amount}} {{method_currency}}\r\nPaid via :  {{method_name}}', '{\"total_month\":\"Payment For Total Month\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after this transaction\", \"rejection_reason\":\"Rejection Reason\"}', 1, 0, 0, NULL, '2021-11-03 12:00:00', '2023-11-02 08:09:56'),
(38, 'WITHDRAW_REJECT', 'Withdrawal Request Rejected', 'Withdrawal Request Rejected', '<div style=\"font-family: Montserrat, sans-serif;\">Your withdraw request of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp; via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>has been Rejected.<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your withdraw:<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : {{amount}} {{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">You should get: {{method_amount}} {{method_currency}}<br></div><div style=\"font-family: Montserrat, sans-serif;\">Via :&nbsp; {{method_name}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">----</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"3\"><br></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"3\">{{amount}}&nbsp;</font><span style=\"color: rgb(33, 37, 41);\">{{site_currency}}</span><font size=\"3\">&nbsp;has been&nbsp;<span style=\"font-weight: bolder;\">refunded&nbsp;</span>to your account and your current Balance is&nbsp;<span style=\"font-weight: bolder;\">{{post_balance}}</span><span style=\"font-weight: bolder;\">&nbsp;{{site_currency}}</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">-----</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\">Details of Rejection :</font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\"><span style=\"font-weight: bolder;\">{{admin_details}}</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br><br><br><br><br></div><div></div><div></div>', 'Admin Rejected Your {{amount}} {{site_currency}} withdraw request. Your Main Balance {{post_balance}}  {{method_name}} , Transaction {{trx}}', '{\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount requested by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the withdraw method\",\"method_currency\":\"Currency of the withdraw method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after fter this action\",\"admin_details\":\"Rejection message by the admin\"}', 1, 1, 0, NULL, '2021-11-03 06:00:00', '2023-11-02 09:47:43'),
(39, 'WITHDRAW_REQUEST', 'Withdrawal Request Sent', 'Withdrawal Request Sent', '<div style=\"font-family: Montserrat, sans-serif;\">Your withdraw request of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp; via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>has been submitted Successfully.<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your withdraw:<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : {{amount}} {{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">You will get: {{method_amount}} {{method_currency}}<br></div><div style=\"font-family: Montserrat, sans-serif;\">Via :&nbsp; {{method_name}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">{{post_balance}} {{site_currency}}</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br><br><br></div>', '{{amount}} {{site_currency}} withdraw requested by {{method_name}}. You will get {{method_amount}} {{method_currency}} Trx: {{trx}}', '{\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount requested by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the withdraw method\",\"method_currency\":\"Currency of the withdraw method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after fter this transaction\"}', 1, 1, 0, NULL, '2021-11-03 06:00:00', '2022-03-20 22:39:03'),
(40, 'WITHDRAW_APPROVE', 'Withdrawal Request Approved', 'Withdrawal Request Approved', '<div style=\"font-family: Montserrat, sans-serif;\">Your withdraw request of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp; via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>has been Processed Successfully.<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your withdraw:<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : {{amount}} {{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">You will get: {{method_amount}} {{method_currency}}<br></div><div style=\"font-family: Montserrat, sans-serif;\">Via :&nbsp; {{method_name}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">-----</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\">Details of Processed Payment :</font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\"><span style=\"font-weight: bolder;\">{{admin_details}}</span></font></div>', 'Admin Approve Your {{amount}} {{site_currency}} withdraw request by {{method_name}}. Transaction {{trx}}', '{\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount requested by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the withdraw method\",\"method_currency\":\"Currency of the withdraw method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"admin_details\":\"Details provided by the admin\"}', 1, 1, 0, NULL, '2021-11-03 06:00:00', '2022-03-20 14:50:16'),
(41, 'BILL_PAYMENT_REMINDER', 'Upcoming Bill Payment Reminder', 'Upcoming Bill Payment Reminder', '<div style=\"font-family: Montserrat, sans-serif;\"><div>Your reserve months has been expired at&nbsp;{{expire_at}}.</div><div>You have to pay&nbsp;{{bill_per_month}} for per month cost within&nbsp;{{payment_deadline}}.</div><div>Make sure, you pay the monthly bill on time.</div></div>', 'Your reserve months has been expired at {{expire_at}}.\r\nYou have to pay {{bill_per_month}} for per month cost within {{payment_deadline}}.\r\nMake sure, you pay the monthly bill on time.', '{\"payment_deadline\": \"Payment Deadline\",\"bill_per_month\":\"Amount For Each Month\",\"expire_at\":\"Expire At\"}', 1, 0, 0, NULL, '2021-11-03 12:00:00', '2023-11-02 14:45:01');

-- --------------------------------------------------------

--
-- Table structure for table `owners`
--

CREATE TABLE `owners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `role_id` int(10) UNSIGNED NOT NULL,
  `firstname` varchar(40) DEFAULT NULL,
  `lastname` varchar(40) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `country_code` varchar(40) DEFAULT NULL,
  `mobile` varchar(40) DEFAULT NULL,
  `balance` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `password` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `is_featured` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `req_step` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0 = deactive, 1 = active, 2 = send request completed, 5 = send request without form data',
  `ver_code` varchar(40) DEFAULT NULL COMMENT 'stores verification code',
  `ver_code_send_at` datetime DEFAULT NULL COMMENT 'verification send time',
  `ts` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: 2fa Off; 1: 2fa On',
  `tv` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0: 2fa unverified; 1: 2fa verified',
  `tsc` varchar(255) DEFAULT NULL,
  `form_data` text DEFAULT NULL,
  `ban_reason` text DEFAULT NULL,
  `expire_at` date DEFAULT NULL,
  `avg_rating` decimal(5,2) NOT NULL DEFAULT 0.00,
  `auto_payment` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `owner_logins`
--

CREATE TABLE `owner_logins` (
  `id` bigint(20) NOT NULL,
  `owner_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `owner_ip` varchar(40) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `country` varchar(40) DEFAULT NULL,
  `country_code` varchar(40) DEFAULT NULL,
  `longitude` varchar(40) DEFAULT NULL,
  `latitude` varchar(40) DEFAULT NULL,
  `browser` varchar(40) DEFAULT NULL,
  `os` varchar(40) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `owner_notifications`
--

CREATE TABLE `owner_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `owner_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `title` text DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `click_url` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `owner_password_resets`
--

CREATE TABLE `owner_password_resets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(40) DEFAULT NULL,
  `token` varchar(40) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) DEFAULT NULL,
  `slug` varchar(40) DEFAULT NULL,
  `tempname` varchar(40) DEFAULT NULL COMMENT 'template name',
  `secs` text DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `slug`, `tempname`, `secs`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'HOME', '/', 'templates.basic.', '[\"brand\",\"feature\",\"video\",\"testimonial\"]', 1, '2020-07-11 06:23:58', '2024-01-03 11:09:28');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(40) DEFAULT NULL,
  `token` varchar(40) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_logs`
--

CREATE TABLE `payment_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `owner_id` int(10) UNSIGNED DEFAULT 0,
  `booking_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `type` varchar(40) DEFAULT NULL,
  `payment_system` varchar(40) DEFAULT NULL,
  `action_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_systems`
--

CREATE TABLE `payment_systems` (
  `id` bigint(20) NOT NULL,
  `owner_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `name` varchar(40) DEFAULT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) DEFAULT NULL,
  `group` varchar(40) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `group`, `code`) VALUES
(188, 'Dashboard', 'OwnerController', 'owner.dashboard'),
(189, 'Notifications', 'OwnerController', 'owner.notifications'),
(190, 'Read Notification', 'OwnerController', 'owner.notification.read'),
(191, 'Read All Notifications', 'OwnerController', 'owner.notifications.readAll'),
(192, 'Report Requests', 'OwnerController', 'owner.request.report'),
(193, 'Submit Requested Report', 'OwnerController', 'owner.request.report.submit'),
(194, 'Download Attachment', 'OwnerController', 'owner.download.attachment'),
(195, 'All Staffs', 'StaffController', 'owner.staff.index'),
(196, 'Save Staff', 'StaffController', 'owner.staff.save'),
(197, 'Update Staff Status', 'StaffController', 'owner.staff.status'),
(198, 'Staff Login', 'StaffController', 'owner.staff.login'),
(199, 'All Roles', 'RolesController', 'owner.roles.index'),
(200, 'Add Roles', 'RolesController', 'owner.roles.add'),
(201, 'Update Roles', 'RolesController', 'owner.roles.edit'),
(202, 'Save Roles', 'RolesController', 'owner.roles.save'),
(230, 'All Room Types', 'RoomTypeController', 'owner.hotel.room.type.all'),
(231, 'Create Room Type', 'RoomTypeController', 'owner.hotel.room.type.create'),
(232, 'Update Room Type', 'RoomTypeController', 'owner.hotel.room.type.edit'),
(233, 'Save Room Type', 'RoomTypeController', 'owner.hotel.room.type.save'),
(234, 'Update Room Type Status', 'RoomTypeController', 'owner.hotel.room.type.status'),
(235, 'All Rooms', 'RoomController', 'owner.hotel.room.all'),
(236, 'Update Room Status', 'RoomController', 'owner.hotel.room.status'),
(237, 'All Extra Services', 'ExtraServiceController', 'owner.hotel.extra_services.all'),
(238, 'Add Extra Service', 'ExtraServiceController', 'owner.hotel.extra_services.save'),
(239, 'Update Extra Service Status', 'ExtraServiceController', 'owner.hotel.extra_services.status'),
(240, 'Book Room - Page', 'BookRoomController', 'owner.book.room'),
(241, 'Book Room', 'BookRoomController', 'owner.room.book'),
(242, 'Search Room', 'BookRoomController', 'owner.room.search'),
(243, 'Merge Booking', 'ManageBookingController', 'owner.booking.merge'),
(244, 'Booking Payment - Page', 'ManageBookingController', 'owner.booking.payment'),
(245, 'Booking Payment', 'ManageBookingController', 'owner.booking.payment'),
(246, 'Checkout Bookings - Page', 'ManageBookingController', 'owner.booking.checkout'),
(247, 'Booking Checkout', 'ManageBookingController', 'owner.booking.checkout'),
(248, 'Booked Rooms', 'BookingController', 'owner.booking.booked.rooms'),
(249, 'Booking Service Details', 'ManageBookingController', 'owner.booking.service.details'),
(250, 'Booking Details', 'BookingController', 'owner.booking.details'),
(251, 'Booking Invoice', 'ManageBookingController', 'owner.booking.invoice'),
(252, 'Handover Key', 'ManageBookingController', 'owner.booking.key.handover'),
(253, 'All Bookings', 'BookingController', 'owner.booking.all'),
(254, 'Active Bookings', 'BookingController', 'owner.booking.active'),
(255, 'Canceled Bookings', 'BookingController', 'owner.booking.canceled.list'),
(256, 'Checked Out Bookings', 'BookingController', 'owner.booking.checked.out.list'),
(257, 'Today\'s Booked Bookings', 'BookingController', 'owner.booking.todays.booked'),
(258, 'Today\'s Check-In Bookings', 'BookingController', 'owner.booking.todays.checkin'),
(259, 'Today\'s Checkout Bookings', 'BookingController', 'owner.booking.todays.checkout'),
(260, 'Refundable Bookings', 'BookingController', 'owner.booking.refundable'),
(261, 'Delayed Checkout Bookings', 'BookingController', 'owner.booking.checkout.delayed'),
(262, 'Add Booking Extra Service', 'ManageBookingController', 'owner.booking.extra.charge.add'),
(263, 'Subtract Booking Extra Service', 'ManageBookingController', 'owner.booking.extra.charge.subtract'),
(264, 'Booking Cancel Page', 'CancelBookingController', 'owner.booking.cancel'),
(265, 'Cancel Full Booking', 'CancelBookingController', 'owner.booking.cancel.full'),
(266, 'Booked Room Cancel', 'CancelBookingController', 'owner.booking.booked.room.cancel'),
(267, 'Day Wise Booked Room Cancel', 'CancelBookingController', 'owner.booking.booked.day.cancel'),
(268, 'Upcoming Check-In Bookings', 'BookingController', 'owner.upcoming.booking.checkin'),
(269, 'Upcoming Checkout Bookings', 'BookingController', 'owner.upcoming.booking.checkout'),
(270, 'Pending Check-In Bookings', 'BookingController', 'owner.pending.booking.checkin'),
(271, 'Delayed Checkout Bookings', 'BookingController', 'owner.delayed.booking.checkout'),
(272, 'All Booking Extra Services', 'BookingExtraServiceController', 'owner.extra.service.list'),
(273, 'Add Extra Service Against Booking - Page', 'BookingExtraServiceController', 'owner.extra.service.add'),
(274, 'Add Extra Service Against Booking', 'BookingExtraServiceController', 'owner.extra.service.save'),
(275, 'Delete Added Extra Service Against Booki', 'BookingExtraServiceController', 'owner.extra.service.delete'),
(276, 'All Booking Requests', 'ManageBookingRequestController', 'owner.request.booking.all'),
(278, 'Booking Request Approve - Page', 'ManageBookingRequestController', 'owner.request.booking.approve'),
(279, 'Cancel Booking Request', 'ManageBookingRequestController', 'owner.request.booking.cancel'),
(280, 'Assign Room To Booking Request', 'ManageBookingRequestController', 'owner.request.booking.assign.room'),
(308, 'Email Details Report', 'ReportController', 'owner.report.email.details'),
(310, 'Payments Received Report', 'ReportController', 'owner.report.payments.received'),
(311, 'Payments Returned Report', 'ReportController', 'owner.report.payments.returned'),
(375, 'Hotel Setting', 'HotelSettingController', 'owner.hotel.setting.index'),
(376, 'Update Hotel Setting', 'HotelSettingController', 'owner.hotel.setting.update'),
(377, 'Book Room Session Data Update', 'BookRoomController', 'owner.room.session.data.update'),
(378, 'Withdraw Page', 'WithdrawController', 'owner.withdraw'),
(379, 'Withdraw Money', 'WithdrawController', 'owner.withdraw.money'),
(380, 'Withdraw Preview', 'WithdrawController', 'owner.withdraw.preview'),
(381, 'Withdraw Submit', 'WithdrawController', 'owner.withdraw.submit'),
(382, 'Withdraw History', 'WithdrawController', 'owner.withdraw.history'),
(383, 'Authorization', 'AuthorizationController', 'owner.authorization'),
(384, 'Send Verify Code', 'AuthorizationController', 'owner.send.verify.code'),
(387, 'Go2fa Verify', 'AuthorizationController', 'owner.go2fa.verify'),
(388, 'Payment History', 'OwnerController', 'owner.payment.history'),
(389, 'Update Auto Payment Status', 'OwnerController', 'owner.update.auto.payment.status'),
(390, 'Two Factor', 'OwnerController', 'owner.twofactor'),
(391, 'Enable Two Factor Athuntication', 'OwnerController', 'owner.twofactor.enable'),
(392, 'Disable Two Factor Authentication', 'OwnerController', 'owner.twofactor.disable'),
(393, 'Hotel Payment System', 'HotelSettingController', 'owner.hotel.setting.payment.systems'),
(394, 'Add Payment System', 'HotelSettingController', 'owner.hotel.setting.payment.system.add'),
(395, 'Update Payment System', 'HotelSettingController', 'owner.hotel.setting.payment.system.update'),
(396, 'Update Payment System Status', 'HotelSettingController', 'owner.hotel.setting.payment.system.status.update'),
(397, 'All Hot Deals', 'HotDealController', 'owner.hotel.hot.deal.index'),
(398, 'Update Hot Deals', 'HotDealController', 'owner.hotel.hot.deal.update'),
(399, 'Add Room', 'RoomController', 'owner.hotel.room.add'),
(400, 'Update Room', 'RoomController', 'owner.hotel.room.update'),
(401, 'Get Available Rooms', 'BookRoomController', 'owner.room.available'),
(402, 'Booking Action History', 'BookingController', 'owner.action.history'),
(403, 'Transaction Report', 'ReportController', 'owner.report.transaction'),
(404, 'Bookings Report', 'ReportController', 'owner.report.bookings'),
(405, 'All Tickets', 'TicketController', 'owner.ticket.index'),
(406, 'Open Ticket Page', 'TicketController', 'owner.ticket.open'),
(407, 'Create Ticket', 'TicketController', 'owner.ticket.store'),
(408, 'View Ticket', 'TicketController', 'owner.ticket.view'),
(409, 'Reply On Ticket', 'TicketController', 'owner.ticket.reply'),
(410, 'Close Ticket', 'TicketController', 'owner.ticket.close'),
(411, 'Download Ticket Attachment', 'TicketController', 'owner.ticket.download'),
(412, 'Deposits', 'PaymentController', 'owner.deposit.index'),
(413, 'Insert Deposit', 'PaymentController', 'owner.deposit.insert'),
(414, 'Confirm Deposit Page', 'PaymentController', 'owner.deposit.confirm'),
(415, 'Manual Deposit Confirm', 'PaymentController', 'owner.deposit.manual.confirm'),
(416, 'Update Manual Deposit', 'PaymentController', 'owner.deposit.manual.update');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reminder_notifications`
--

CREATE TABLE `reminder_notifications` (
  `id` bigint(20) NOT NULL,
  `owner_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `send_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) NOT NULL,
  `owner_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `rating` int(11) NOT NULL DEFAULT 0,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `owner_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `name` varchar(40) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `owner_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `room_type_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `room_number` varchar(40) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `room_types`
--

CREATE TABLE `room_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `owner_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `name` varchar(255) DEFAULT NULL,
  `total_adult` int(11) NOT NULL DEFAULT 0,
  `total_child` int(11) NOT NULL DEFAULT 0,
  `fare` decimal(28,16) DEFAULT NULL,
  `discount_percentage` decimal(5,2) NOT NULL DEFAULT 0.00 COMMENT 'in percentage',
  `keywords` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `beds` text DEFAULT NULL,
  `cancellation_fee` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `cancellation_policy` text DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `room_type_amenities`
--

CREATE TABLE `room_type_amenities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_type_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `amenities_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `room_type_facilities`
--

CREATE TABLE `room_type_facilities` (
  `id` bigint(20) NOT NULL,
  `room_type_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `facility_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `room_type_images`
--

CREATE TABLE `room_type_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_type_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(40) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_attachments`
--

CREATE TABLE `support_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `support_message_id` int(10) UNSIGNED DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_messages`
--

CREATE TABLE `support_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `support_ticket_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `admin_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `message` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT 0,
  `owner_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `admin_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `name` varchar(40) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `ticket` varchar(40) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: Open, 1: Answered, 2: Replied, 3: Closed',
  `priority` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = Low, 2 = medium, 3 = heigh',
  `last_reply` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `owner_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `post_balance` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `trx_type` varchar(40) DEFAULT NULL,
  `trx` varchar(40) DEFAULT NULL,
  `details` varchar(255) DEFAULT NULL,
  `remark` varchar(40) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `update_logs`
--

CREATE TABLE `update_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(40) DEFAULT NULL,
  `update_log` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `used_extra_services`
--

CREATE TABLE `used_extra_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `owner_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `action_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `booking_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `extra_service_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `room_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `booked_room_id` int(10) UNSIGNED DEFAULT NULL,
  `qty` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `unit_price` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `total_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `service_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `social_id` varchar(255) DEFAULT NULL,
  `firstname` varchar(40) DEFAULT NULL,
  `lastname` varchar(40) DEFAULT NULL,
  `username` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `country_code` varchar(40) DEFAULT NULL,
  `mobile` varchar(40) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `address` text DEFAULT NULL COMMENT 'contains full address',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0: banned, 1: active',
  `ev` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: email unverified, 1: email verified',
  `sv` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: mobile unverified, 1: mobile verified',
  `profile_complete` tinyint(1) NOT NULL DEFAULT 0,
  `ver_code` varchar(40) DEFAULT NULL COMMENT 'stores verification code',
  `ver_code_send_at` datetime DEFAULT NULL COMMENT 'verification send time',
  `tsc` varchar(255) DEFAULT NULL,
  `ban_reason` varchar(255) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_logins`
--

CREATE TABLE `user_logins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `user_ip` varchar(40) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `country` varchar(40) DEFAULT NULL,
  `country_code` varchar(40) DEFAULT NULL,
  `longitude` varchar(40) DEFAULT NULL,
  `latitude` varchar(40) DEFAULT NULL,
  `browser` varchar(40) DEFAULT NULL,
  `os` varchar(40) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `method_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `owner_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `currency` varchar(40) DEFAULT NULL,
  `rate` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `trx` varchar(40) DEFAULT NULL,
  `final_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `after_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `withdraw_information` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=>success, 2=>pending, 3=>cancel,  ',
  `admin_feedback` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_methods`
--

CREATE TABLE `withdraw_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `form_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `name` varchar(40) DEFAULT NULL,
  `min_limit` decimal(28,8) DEFAULT 0.00000000,
  `max_limit` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `fixed_charge` decimal(28,8) DEFAULT 0.00000000,
  `rate` decimal(28,8) DEFAULT 0.00000000,
  `percent_charge` decimal(5,2) DEFAULT NULL,
  `currency` varchar(40) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`,`username`);

--
-- Indexes for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `advertisements`
--
ALTER TABLE `advertisements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `amenities`
--
ALTER TABLE `amenities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bed_types`
--
ALTER TABLE `bed_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booked_rooms`
--
ALTER TABLE `booked_rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_action_histories`
--
ALTER TABLE `booking_action_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_requests`
--
ALTER TABLE `booking_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_request_details`
--
ALTER TABLE `booking_request_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cover_photos`
--
ALTER TABLE `cover_photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cron_jobs`
--
ALTER TABLE `cron_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cron_job_logs`
--
ALTER TABLE `cron_job_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cron_schedules`
--
ALTER TABLE `cron_schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `device_tokens`
--
ALTER TABLE `device_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `extensions`
--
ALTER TABLE `extensions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `extra_services`
--
ALTER TABLE `extra_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frontends`
--
ALTER TABLE `frontends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gateways`
--
ALTER TABLE `gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gateway_currencies`
--
ALTER TABLE `gateway_currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guests`
--
ALTER TABLE `guests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hotel_settings`
--
ALTER TABLE `hotel_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_logs`
--
ALTER TABLE `notification_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_templates`
--
ALTER TABLE `notification_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `owners`
--
ALTER TABLE `owners`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `owner_logins`
--
ALTER TABLE `owner_logins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `owner_notifications`
--
ALTER TABLE `owner_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `owner_password_resets`
--
ALTER TABLE `owner_password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_logs`
--
ALTER TABLE `payment_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_systems`
--
ALTER TABLE `payment_systems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `reminder_notifications`
--
ALTER TABLE `reminder_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `owner_id` (`owner_id`,`room_number`);

--
-- Indexes for table `room_types`
--
ALTER TABLE `room_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_type_amenities`
--
ALTER TABLE `room_type_amenities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_type_facilities`
--
ALTER TABLE `room_type_facilities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_type_images`
--
ALTER TABLE `room_type_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_attachments`
--
ALTER TABLE `support_attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_messages`
--
ALTER TABLE `support_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `update_logs`
--
ALTER TABLE `update_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `used_extra_services`
--
ALTER TABLE `used_extra_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`,`email`);

--
-- Indexes for table `user_logins`
--
ALTER TABLE `user_logins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraw_methods`
--
ALTER TABLE `withdraw_methods`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `advertisements`
--
ALTER TABLE `advertisements`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `amenities`
--
ALTER TABLE `amenities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bed_types`
--
ALTER TABLE `bed_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booked_rooms`
--
ALTER TABLE `booked_rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_action_histories`
--
ALTER TABLE `booking_action_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_requests`
--
ALTER TABLE `booking_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_request_details`
--
ALTER TABLE `booking_request_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=244;

--
-- AUTO_INCREMENT for table `cover_photos`
--
ALTER TABLE `cover_photos`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cron_jobs`
--
ALTER TABLE `cron_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cron_job_logs`
--
ALTER TABLE `cron_job_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cron_schedules`
--
ALTER TABLE `cron_schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `device_tokens`
--
ALTER TABLE `device_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `extensions`
--
ALTER TABLE `extensions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `extra_services`
--
ALTER TABLE `extra_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `frontends`
--
ALTER TABLE `frontends`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT for table `gateways`
--
ALTER TABLE `gateways`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `gateway_currencies`
--
ALTER TABLE `gateway_currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `guests`
--
ALTER TABLE `guests`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hotel_settings`
--
ALTER TABLE `hotel_settings`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_logs`
--
ALTER TABLE `notification_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_templates`
--
ALTER TABLE `notification_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `owners`
--
ALTER TABLE `owners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `owner_logins`
--
ALTER TABLE `owner_logins`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `owner_notifications`
--
ALTER TABLE `owner_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `owner_password_resets`
--
ALTER TABLE `owner_password_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `payment_logs`
--
ALTER TABLE `payment_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_systems`
--
ALTER TABLE `payment_systems`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=417;

--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reminder_notifications`
--
ALTER TABLE `reminder_notifications`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `room_types`
--
ALTER TABLE `room_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `room_type_amenities`
--
ALTER TABLE `room_type_amenities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `room_type_facilities`
--
ALTER TABLE `room_type_facilities`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `room_type_images`
--
ALTER TABLE `room_type_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_attachments`
--
ALTER TABLE `support_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_messages`
--
ALTER TABLE `support_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `update_logs`
--
ALTER TABLE `update_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `used_extra_services`
--
ALTER TABLE `used_extra_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_logins`
--
ALTER TABLE `user_logins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdraw_methods`
--
ALTER TABLE `withdraw_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
