-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2024 at 06:59 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bikroy_hr`
--

-- --------------------------------------------------------

--
-- Table structure for table `earned_leave_encashments`
--

CREATE TABLE `earned_leave_encashments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `number_of_leave` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `attendance_id` varchar(55) DEFAULT NULL,
  `phone_no` varchar(20) NOT NULL,
  `fathers_name` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `religion` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `tin_no` varchar(255) DEFAULT NULL,
  `date_of_joining` date NOT NULL,
  `end_of_contract_date` date DEFAULT NULL,
  `marital_status` varchar(255) NOT NULL,
  `payment_mode` varchar(255) NOT NULL,
  `vendor_code` varchar(255) DEFAULT NULL,
  `designation` varchar(55) NOT NULL,
  `department` varchar(55) NOT NULL,
  `status` enum('Active','Not Active','Resigned') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `user_id`, `attendance_id`, `phone_no`, `fathers_name`, `date_of_birth`, `religion`, `gender`, `category`, `tin_no`, `date_of_joining`, `end_of_contract_date`, `marital_status`, `payment_mode`, `vendor_code`, `designation`, `department`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'EB009', '34334', 'shakawat hossain', '2022-12-18', 'Muslim', 'Male', 'Permanent', 'tin01', '2024-07-04', NULL, 'Married', 'Cash', 'v', 'Assistant Manager', 'Corporate Sales & KAM', 'Active', '2023-12-18 03:42:50', '2023-12-23 07:42:23'),
(2, 8, 'EB00987', '333', 'd', '2023-12-18', 'Muslim', 'Male', 'Permanent', 't09', '2023-12-18', NULL, 'Married', 'Cash', 'v98', 'Manager', 'Operations', 'Active', '2023-12-18 04:43:22', '2023-12-23 07:42:00'),
(3, 9, 'EB009', '098', 'test', '2023-12-20', 'Muslim', 'Male', 'Permanent', 't5', '2023-12-23', '2023-12-23', 'Single', 'Cash', 'v3', 'Junior Executive', 'Business Development', 'Active', '2023-12-23 05:20:10', '2023-12-23 07:43:10'),
(4, 10, 'EB0010', '98', 'test', '2023-12-23', 'Muslim', 'Male', 'Permanent', 't1', '2023-12-23', '2023-12-23', 'Married', 'Cash', 'v9', 'Junior Executive', 'Business Development', 'Active', '2023-12-23 06:33:47', '2023-12-23 07:43:37'),
(5, 11, 'EB09', '+8801737064777', 'tes', '2023-12-23', 'Muslim', 'Male', 'Permanent', 't3', '2023-12-23', NULL, 'Married', 'Cash', 'v7', 'Executive', 'Marketing', 'Active', '2023-12-23 07:06:36', '2023-12-23 07:43:58'),
(6, 12, 'EB098', '0987', 'test', '2023-12-02', 'Hindu', 'Female', 'Contractual', 't12', '2023-12-03', '2023-12-04', 'Single', 'Cheque', 'v98', 'Junior Executive', 'Business Development', 'Active', '2023-12-23 07:11:36', '2023-12-23 07:44:19'),
(7, 13, 'EB0987', '098', 'test', '2023-12-23', 'Muslim', 'Male', 'Others', 'tin012', '2023-12-23', '2023-12-23', 'Married', 'Bank transfer', 'v02', 'Executive', 'Marketing', 'Active', '2023-12-23 07:14:09', '2023-12-23 07:44:36'),
(8, 14, 'EB00506', '09877', 'shakawat hossain', '2023-12-24', 'Muslim', 'Male', 'Permanent', 'e tin 01', '2023-12-24', NULL, 'Married', 'Bank transfer', 'v 2', 'Senior Executive (L2)', 'Marketing', 'Active', '2023-12-24 04:29:31', '2023-12-24 04:29:31'),
(9, 15, 'EB0000', '00', 'Test', '2024-01-01', 'Muslim', 'Male', 'Permanent', NULL, '2024-01-01', NULL, 'Married', 'Cash', NULL, 'Junior Executive', 'Management', 'Active', '2024-01-01 13:59:40', '2024-01-01 13:59:40'),
(10, 16, 'admin', '0', 'test', '2024-01-03', 'Muslim', 'Male', 'Permanent', NULL, '2024-01-03', NULL, 'Married', 'Cash', NULL, 'CEO', 'Management', 'Active', '2024-01-03 16:37:45', '2024-01-03 16:46:17');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `holiday_calendars`
--

CREATE TABLE `holiday_calendars` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `holiday_date` date NOT NULL,
  `holiday_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `holiday_calendars`
--

INSERT INTO `holiday_calendars` (`id`, `holiday_date`, `holiday_name`, `created_at`, `updated_at`) VALUES
(2, '2023-12-16', 'Bijoy Dibos', '2023-12-26 06:27:25', '2023-12-26 06:27:25'),
(3, '2023-02-21', 'Mattri vasa dibos', '2023-12-26 06:28:43', '2023-12-26 06:28:43');

-- --------------------------------------------------------

--
-- Table structure for table `leave_applications`
--

CREATE TABLE `leave_applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `leave_type` varchar(255) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `duration` float NOT NULL,
  `is_half_day` tinyint(4) NOT NULL DEFAULT 0,
  `half_day_type` enum('1st half','2nd half','Others') DEFAULT NULL,
  `reason` text NOT NULL,
  `status` enum('Pending','Approved','Rejected') NOT NULL DEFAULT 'Pending',
  `status_updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_applications`
--

INSERT INTO `leave_applications` (`id`, `user_id`, `leave_type`, `from_date`, `to_date`, `duration`, `is_half_day`, `half_day_type`, `reason`, `status`, `status_updated_by`, `created_at`, `updated_at`) VALUES
(2, 14, 'Sick Leave', '2023-12-24', '2023-12-24', 0, 0, NULL, 'a', 'Pending', NULL, '2023-12-24 05:20:29', '2023-12-24 05:20:29'),
(3, 14, 'Casual Leave', '2023-12-24', '2023-12-24', 0, 0, NULL, 'sd', 'Pending', NULL, '2023-12-24 05:21:04', '2023-12-24 05:21:04'),
(4, 14, 'Sick Leave', '2023-12-24', '2023-12-24', 0, 1, '2nd half', 'test', 'Pending', NULL, '2023-12-24 05:22:47', '2023-12-24 05:22:47'),
(5, 14, 'Paternal Leave for 1st Child', '2023-12-24', '2023-12-24', 0, 0, NULL, 'ddd', 'Pending', NULL, '2023-12-24 05:24:42', '2023-12-24 05:24:42'),
(6, 1, 'Earned Leave', '2023-12-26', '2023-12-30', 0, 0, NULL, 'My earned leave', 'Approved', NULL, '2023-12-26 06:32:05', '2023-12-26 06:32:05'),
(7, 1, 'Casual Leave', '2023-12-27', '2023-12-27', 0.5, 1, 'Others', 'test', 'Pending', NULL, '2023-12-27 05:57:36', '2024-01-03 19:37:43'),
(8, 9, 'Casual Leave', '2023-12-27', '2023-12-27', 1, 0, NULL, 'test 3', 'Approved', NULL, '2023-12-27 12:02:13', '2024-01-03 17:48:40'),
(9, 10, 'Casual Leave', '2024-01-01', '2024-01-02', 0.5, 1, '2nd half', 'd', 'Approved', NULL, '2024-01-01 12:17:25', '2024-01-01 13:55:36'),
(10, 10, 'Casual Leave', '2024-01-03', '2024-01-03', 0.5, 1, '1st half', 'test', 'Approved', NULL, '2024-01-03 17:21:48', '2024-01-03 17:29:53'),
(11, 16, 'Casual Leave', '2024-01-04', '2024-01-05', 2, 0, NULL, 'a', 'Approved', NULL, '2024-01-03 18:18:36', '2024-01-03 18:18:36'),
(12, 9, 'Casual Leave', '2024-01-06', '2024-01-07', 2, 0, NULL, 'test', 'Approved', NULL, '2024-01-03 18:36:51', '2024-01-03 18:41:28'),
(13, 1, 'Casual Leave', '2024-01-04', '2024-01-04', 0.5, 1, 'Others', 't', 'Pending', NULL, '2024-01-03 19:19:55', '2024-01-03 19:32:56'),
(14, 9, 'Sick Leave', '2024-01-06', '2024-01-07', 2, 0, NULL, 'test', 'Pending', NULL, '2024-01-03 19:58:45', '2024-01-03 19:58:45');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_12_18_073428_create_employees_table', 2),
(6, '2023_12_19_111120_create_interested_users_table', 3),
(8, '2023_12_22_123355_create_leave_applications_table', 4),
(9, '2023_12_26_115136_create_holiday_calendars_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
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
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `team_leaders`
--

CREATE TABLE `team_leaders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `department` varchar(55) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_leaders`
--

INSERT INTO `team_leaders` (`id`, `user_id`, `department`, `created_at`, `updated_at`) VALUES
(5, 9, 'Business Development', '2024-01-03 19:59:36', '2024-01-03 19:59:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'fuad', 'forkadulislam@gmail.com', NULL, '$2y$10$N2xAYtzm7KNJ3d6.maV.YewKWHH9FqWZLrhLw8qf0yECxPZ/XqenK', NULL, NULL, NULL),
(7, 2, 'sdf', 'sdflasjf@lkasdjfl.com', NULL, '$2y$12$HYAlurUcWEfKljVzIYAN3eRCP5aGVFjP9/RFwBtX2CCSYvZEliQcC', NULL, '2023-12-18 03:42:50', '2023-12-18 03:42:50'),
(8, 2, 'Forkadul Islam Fuad', 'test@mail.com', NULL, '$2y$12$reLrkzPPQ7VwDP5hLJuRc.AhuOWzC.laVnCU623Bygm8ztmeFh2oS', NULL, '2023-12-18 04:43:22', '2023-12-18 04:43:22'),
(9, 2, 'Arifin Hossain', 'arifin@bikroy.com', NULL, '$2y$12$YYfRYJ1zDbLrXVma4Ulmhuv8aqPSZNAMvNbyvgCh3/RZpSS9//zCu', NULL, '2023-12-23 05:20:10', '2023-12-23 05:20:10'),
(10, 2, 'MD Khairul alom', 'khairulalom@bikroy.com', NULL, '$2y$12$oPlIRuRA8Cr87STL/pvjFeFHHqMTR6.8ege0IC2m2xqzZvcmPB/by', NULL, '2023-12-23 06:33:47', '2023-12-23 06:33:47'),
(11, 2, 'Sanjoy Bissah', 'sanjoy.biswas@bikroy.com', NULL, '$2y$12$RSqhlpEfR8ma19jnR.d.luVaACwq7XCeTFLGgF6.X0H0CFdCpmILO', NULL, '2023-12-23 07:06:36', '2023-12-23 07:06:36'),
(12, 2, 'Khan topu', 'khan@gmail.com', NULL, '$2y$12$CoGnGFyes4WQSZ8MS/olIueR/a4Y7Z6Z5YwGegWsk4cLLisKQTdvK', NULL, '2023-12-23 07:11:36', '2023-12-23 07:11:36'),
(13, 2, 'Siam', 'siam@gmail.com', NULL, '$2y$12$z/eGqwwNc81u2Cr7lGm2rugsRUlYROf6RPbcJp1Xnn8I69Jd0nWzm', NULL, '2023-12-23 07:14:09', '2023-12-23 07:14:09'),
(14, 2, 'fuad hasan', 'fuad2@mail.com', NULL, '$2y$12$GIzgOSyYTu9oNNbP8LVJA.qL/vXCYTnnRM3xsHsQH7VE/BDS3EodG', NULL, '2023-12-24 04:29:31', '2023-12-24 04:29:31'),
(15, 1, 'HR Manager', 'hr@bikroy.com', NULL, '$2y$12$wfO3Epv5SiYhEiEpJ1V.bu/Y6.mEQtMU3mmjsUVCE79U9OZytLwZu', NULL, '2024-01-01 13:59:40', '2024-01-01 13:59:40'),
(16, 2, 'Eshita Sharmin', 'eahita@bikroy.com', NULL, '$2y$12$OdsDPE9mmK8ksFJileizmeZQd5m2RM06qgWxfWlnlbkjZ2.p/w4WC', NULL, '2024-01-03 16:37:45', '2024-01-03 16:37:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `earned_leave_encashments`
--
ALTER TABLE `earned_leave_encashments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employees_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `holiday_calendars`
--
ALTER TABLE `holiday_calendars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_applications`
--
ALTER TABLE `leave_applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `team_leaders`
--
ALTER TABLE `team_leaders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `earned_leave_encashments`
--
ALTER TABLE `earned_leave_encashments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `holiday_calendars`
--
ALTER TABLE `holiday_calendars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `leave_applications`
--
ALTER TABLE `leave_applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `team_leaders`
--
ALTER TABLE `team_leaders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
