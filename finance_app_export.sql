-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2024 at 03:42 PM
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
-- Database: `finance_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `financial_goals`
--

CREATE TABLE `financial_goals` (
  `goal_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `target_date` date NOT NULL,
  `goal_type_id` int(11) NOT NULL,
  `goal_name` varchar(100) NOT NULL,
  `target_amount` decimal(10,2) NOT NULL,
  `saved_amount` decimal(10,2) DEFAULT 0.00,
  `last_modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `financial_goals`
--

INSERT INTO `financial_goals` (`goal_id`, `user_id`, `created_date`, `target_date`, `goal_type_id`, `goal_name`, `target_amount`, `saved_amount`, `last_modified`, `status_id`) VALUES
(5, 6, '0000-00-00', '2024-12-31', 1, 'Бора Бора', 1500.00, 1100.00, '2024-12-14 12:48:06', 1),
(6, 6, '0000-00-00', '2024-12-31', 5, 'д-р Някоя си', 25.00, 25.00, '2024-12-15 18:36:55', 1),
(7, 6, '0000-00-00', '2024-12-31', 4, 'за Дончо', 20.00, 0.00, '2024-12-13 18:35:01', 1),
(8, 6, '2024-12-13', '2024-05-18', 2, 'Нова Toyota', 25000.00, 5000.00, '2024-12-13 20:08:23', 1),
(11, 4, '2024-12-14', '2024-12-19', 1, 'Коледна ваканция', 500.00, 100.00, '2024-12-18 12:26:36', 1),
(14, 6, '2024-12-15', '2024-12-24', 1, 'Банско', 600.00, 0.00, '2024-12-15 19:46:56', 1),
(15, 5, '2024-12-15', '2024-12-20', 5, 'д-р Радева', 35.00, 5.00, '2024-12-15 18:56:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `financial_liabilities`
--

CREATE TABLE `financial_liabilities` (
  `liability_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `liability_name` varchar(100) NOT NULL,
  `target_amount` decimal(10,2) NOT NULL,
  `paid_amount` decimal(10,2) DEFAULT 0.00,
  `last_modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status_id` int(11) NOT NULL,
  `liability_type_id` int(11) NOT NULL,
  `target_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `financial_liabilities`
--

INSERT INTO `financial_liabilities` (`liability_id`, `user_id`, `created_date`, `liability_name`, `target_amount`, `paid_amount`, `last_modified`, `status_id`, `liability_type_id`, `target_date`) VALUES
(1, 4, '2024-12-14', 'апартамент в кв. Виница', 1500000.00, 0.00, '2024-12-14 16:46:47', 1, 2, '2050-01-01'),
(4, 6, '2024-12-14', 'Да върна на приятел', 20.00, 20.00, '2024-12-15 18:48:42', 2, 5, '2024-12-20'),
(5, 6, '2024-12-14', 'Потребителски кредит', 500.00, 0.00, '2024-12-15 18:51:32', 1, 1, '2024-12-20'),
(10, 5, '2024-12-15', 'да върна 100 лв в картата', 100.00, 0.00, '2024-12-15 19:56:21', 1, 4, '2024-12-31'),
(11, 4, '2024-12-16', 'на Петран', 20.00, 0.00, '2024-12-16 18:52:26', 1, 5, '2024-12-17'),
(12, 4, '2024-12-17', 'Кредитна карта', 100.00, 0.00, '2024-12-18 11:55:18', 1, 4, '2024-12-20');

-- --------------------------------------------------------

--
-- Table structure for table `goal_types`
--

CREATE TABLE `goal_types` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(50) NOT NULL,
  `type_description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `goal_types`
--

INSERT INTO `goal_types` (`type_id`, `type_name`, `type_description`) VALUES
(1, 'Спестяване за ваканция', NULL),
(2, 'Спестяване за нова кола', NULL),
(3, 'Спестяване за апартамент', NULL),
(4, 'Събиране на пари за подарък', NULL),
(5, 'Събиране за мед. преглед', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `group_members`
--

CREATE TABLE `group_members` (
  `member_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `other_user_member_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `group_members`
--

INSERT INTO `group_members` (`member_id`, `group_id`, `role_id`, `purpose`, `other_user_member_id`, `user_id`) VALUES
(5, 2, 1, 'не знаем още', 4, 0),
(6, 3, 1, 'sdfsdf', 4, 0),
(7, 4, 1, 'kekekfd', 5, 0),
(13, 9, 2, 'Не знаем още', 4, 6),
(14, 9, 1, 'Не знаем още', 6, 4),
(19, 12, 2, 'събираме пари за малки шишета', 4, 6),
(20, 12, 1, 'събираме пари за малки шишета', 6, 4),
(21, 13, 2, 'да тестваме функционалност', 5, 6),
(22, 13, 1, 'да тестваме функционалност', 6, 5),
(23, 14, 2, 'събираме пари за средни шишета', 5, 4),
(24, 14, 1, 'събираме пари за средни шишета', 4, 5);

-- --------------------------------------------------------

--
-- Table structure for table `liability_types`
--

CREATE TABLE `liability_types` (
  `liability_type_id` int(11) NOT NULL,
  `liability_name` varchar(255) NOT NULL,
  `liability_description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `liability_types`
--

INSERT INTO `liability_types` (`liability_type_id`, `liability_name`, `liability_description`) VALUES
(1, 'Потребителски кредит', NULL),
(2, 'Ипотечен кредит', NULL),
(3, 'Лизинг', NULL),
(4, 'Кредитна карта', NULL),
(5, 'Да върна на приятел', NULL),
(6, 'Друго', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `login_activity`
--

CREATE TABLE `login_activity` (
  `activity_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `login_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `ip_address` varchar(45) DEFAULT NULL,
  `device_info` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_activity`
--

INSERT INTO `login_activity` (`activity_id`, `user_id`, `login_date`, `ip_address`, `device_info`) VALUES
(1, 4, '2024-12-13 12:53:34', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(2, 5, '2024-12-13 13:22:00', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(3, 4, '2024-12-13 13:47:34', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(4, 4, '2024-12-13 14:22:10', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(5, 4, '2024-12-13 14:23:06', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(6, 5, '2024-12-13 14:38:06', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(7, 6, '2024-12-13 14:54:34', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(8, 6, '2024-12-13 19:07:06', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(9, 4, '2024-12-14 13:25:31', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(10, 6, '2024-12-14 13:28:37', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(11, 4, '2024-12-14 13:28:52', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(12, 6, '2024-12-14 16:47:39', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(13, 4, '2024-12-15 10:09:31', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(14, 6, '2024-12-15 10:15:30', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(15, 4, '2024-12-15 10:33:32', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(16, 6, '2024-12-15 10:34:33', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(17, 4, '2024-12-15 10:36:15', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(18, 5, '2024-12-15 10:36:34', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(19, 6, '2024-12-15 10:37:13', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(20, 5, '2024-12-15 10:37:56', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(21, 4, '2024-12-15 10:40:56', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(22, 6, '2024-12-15 10:41:18', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(23, 5, '2024-12-15 10:41:49', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(24, 6, '2024-12-15 10:42:30', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(25, 4, '2024-12-15 10:43:22', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(26, 4, '2024-12-15 10:44:44', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(27, 5, '2024-12-15 11:05:17', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(28, 6, '2024-12-15 11:40:30', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(29, 4, '2024-12-15 13:40:52', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(30, 6, '2024-12-15 13:43:21', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(31, 5, '2024-12-15 13:44:43', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(32, 6, '2024-12-15 13:45:54', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(33, 4, '2024-12-15 15:54:17', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(34, 6, '2024-12-15 15:57:43', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(35, 5, '2024-12-15 15:58:08', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(36, 6, '2024-12-15 15:59:55', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(37, 6, '2024-12-15 16:46:20', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(38, 7, '2024-12-15 16:47:20', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(39, 8, '2024-12-15 17:11:12', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(40, 9, '2024-12-15 17:14:36', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(41, 10, '2024-12-15 17:19:34', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(42, 6, '2024-12-15 17:24:51', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(43, 4, '2024-12-15 18:04:48', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(44, 6, '2024-12-15 18:32:25', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(45, 5, '2024-12-15 18:52:56', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(46, 4, '2024-12-15 18:57:50', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(47, 4, '2024-12-17 13:12:23', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(48, 11, '2024-12-17 14:34:20', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(49, 4, '2024-12-17 14:40:20', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0'),
(50, 4, '2024-12-18 11:40:02', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0');

-- --------------------------------------------------------

--
-- Table structure for table `profile_settings`
--

CREATE TABLE `profile_settings` (
  `setting_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_login_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_ip_address` varchar(45) DEFAULT NULL,
  `device_info` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'Създател'),
(2, 'Участник');

-- --------------------------------------------------------

--
-- Table structure for table `shared_balances`
--

CREATE TABLE `shared_balances` (
  `balance_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `balance_date` date NOT NULL,
  `debtor_id` int(11) DEFAULT NULL,
  `creditor_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `last_modified` date DEFAULT NULL,
  `status_id` int(11) NOT NULL,
  `last_modified_by_user_id` int(11) DEFAULT NULL,
  `created_date` date NOT NULL,
  `creator_id` int(11) NOT NULL,
  `saved_amont` decimal(10,2) DEFAULT 0.00,
  `is_active` bit(1) DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shared_balances`
--

INSERT INTO `shared_balances` (`balance_id`, `group_id`, `balance_date`, `debtor_id`, `creditor_id`, `amount`, `purpose`, `last_modified`, `status_id`, `last_modified_by_user_id`, `created_date`, `creator_id`, `saved_amont`, `is_active`) VALUES
(1, 9, '2024-12-20', NULL, NULL, 30.00, 'горна баня', '2024-12-15', 1, 6, '2024-12-15', 6, 0.00, b'0'),
(2, 12, '2024-12-31', NULL, NULL, 50.00, 'водико', NULL, 1, NULL, '2024-12-15', 6, 0.00, b'0'),
(3, 9, '2025-01-01', NULL, NULL, 150.00, 'да си купим дъждобран', '2024-12-17', 1, 4, '2024-12-15', 6, 100.00, b'1'),
(4, 13, '2024-12-31', NULL, NULL, 50.00, 'яаож', NULL, 1, NULL, '2024-12-15', 6, 0.00, b'1'),
(5, 9, '2024-12-27', NULL, NULL, 10.00, 'тнд', '2024-12-15', 1, 6, '2024-12-15', 6, 0.00, b'1'),
(6, 13, '2024-12-25', NULL, NULL, 80.00, 'пластмасата е скъпа', '2024-12-15', 1, 5, '2024-12-15', 4, 0.00, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `shared_groups`
--

CREATE TABLE `shared_groups` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(100) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_active` bit(1) DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shared_groups`
--

INSERT INTO `shared_groups` (`group_id`, `group_name`, `created_by`, `created_date`, `is_active`) VALUES
(1, 'Gensta Shit', 6, '2024-12-14 21:58:31', b'1'),
(2, 'Balkans', 6, '2024-12-15 08:25:40', b'0'),
(3, 'Здрасти', 6, '2024-12-15 08:30:05', b'0'),
(4, 'Нещо тука да има за тест', 6, '2024-12-15 08:43:35', b'0'),
(5, 'аятят', 6, '2024-12-15 09:56:03', b'1'),
(6, 'Мляко с ориз', 6, '2024-12-15 10:29:54', b'1'),
(7, 'dff', 6, '2024-12-15 10:54:16', b'1'),
(8, 'аеоо', 6, '2024-12-15 11:27:51', b'1'),
(9, 'Големи шишета', 6, '2024-12-15 11:33:15', b'1'),
(10, 'Мляко с ориз', 6, '2024-12-15 11:35:05', b'0'),
(11, 'Варна морето сините вълни', 5, '2024-12-15 11:40:42', b'0'),
(12, 'Малки шишета', 6, '2024-12-15 14:00:20', b'1'),
(13, 'Някаква тестова група', 6, '2024-12-15 14:43:58', b'1'),
(14, 'Средни шишета', 4, '2024-12-15 16:55:56', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `status_id` int(11) NOT NULL,
  `status_name` varchar(50) NOT NULL,
  `status_description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`status_id`, `status_name`, `status_description`) VALUES
(1, 'Активна', NULL),
(2, 'Неактивна', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_history`
--

CREATE TABLE `transaction_history` (
  `transaction_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `transaction_date` date NOT NULL,
  `transaction_purpose` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `picture` varchar(255) DEFAULT NULL,
  `is_deleted` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `date_of_birth`, `email`, `password_hash`, `created_at`, `picture`, `is_deleted`) VALUES
(3, 'test', 'test', '1966-02-02', 'test@test.com', '$argon2i$v=19$m=65536,t=4,p=1$TnJTSWhyYUpvMDlWeWJLWg$IVlVog0eYs+nWWb5zZ273nz2z/DjSLIKcRWdIFlxFIQ', '2024-12-13 12:33:13', NULL, b'1'),
(4, 'Иван', 'Иванов', '1994-12-06', 'ivan@abv.bg', '$argon2i$v=19$m=65536,t=4,p=1$RGhFNkFlWFdvQVJiVjJDcA$xEL/Yk/vd+cq03iy4vuQ94CsiGUmIDPyYFf4QcIaWqg', '2024-12-13 12:40:21', 'profile_4.png', b'1'),
(5, 'petran', 'petranov', '2000-05-11', 'petran@abv.bg', '$argon2i$v=19$m=65536,t=4,p=1$dndKR01PSkZ1WEwwcEx1Mg$W57hvot7BvKLgtZGG1HsFyQfa6m1L7YgBDmcTKFDJlw', '2024-12-13 13:21:47', NULL, b'1'),
(6, 'Пупи (котка)', 'Пуфанова', '2024-02-03', 'pupi@abv.bg', '$argon2i$v=19$m=65536,t=4,p=1$L1AwdWFycWV5MmJZWEdQSQ$O5/2/aoN9755EEXG/NkNa/OmknWjt+GyvAuYci/m+z4', '2024-12-13 14:54:24', 'profile_6.gif', b'1'),
(7, 'Milen', 'Milenov', '2000-02-03', 'milen@abv.bg', '$argon2i$v=19$m=65536,t=4,p=1$aXNhT2dHb3MyL0ZCdkp2Sw$K1CPd31J2CLgt9mn1Xsm6u8nEFY3MwEo6oolRwEStBM', '2024-12-15 16:47:10', NULL, b'0'),
(8, 'Jojo', 'Jojev', '1981-05-03', 'jojo@abv.bg', '$argon2i$v=19$m=65536,t=4,p=1$ZTNFQUh4WW9wcFV6aGwzMQ$+B/OcqhIpECWysBY8LRBAYKXcEpn286hs2GrkpGDZXA', '2024-12-15 17:11:04', NULL, b'0'),
(9, 'hoho', 'hoho', '1999-01-01', 'hoho@abv.bg', '$argon2i$v=19$m=65536,t=4,p=1$alVxOFZTczdXcUJYRk1ELw$000VwZhYkzdiMbfMwn87U5GJqd61RrWKqwBylxNuG6w', '2024-12-15 17:14:21', NULL, b'0'),
(10, 'lo', 'lo', '2002-12-12', 'lo@abv.bg', '$argon2i$v=19$m=65536,t=4,p=1$ZTZUT3JDUjNUT2F0VG9FaA$tugL+0AujyH3oxY1p2DxaE8+jN3nORS7bxjBBJw0WOc', '2024-12-15 17:18:20', NULL, b'0'),
(11, 'Мартин', 'Иванов', '1996-04-03', 'martin@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$dUd4SXJoaUJiR1VUUHlpVw$QAv+DjJsF9CJqtRcgHiw+0wpJwi5cQvI1E0mN1ZnSow', '2024-12-17 13:28:29', NULL, b'1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `financial_goals`
--
ALTER TABLE `financial_goals`
  ADD PRIMARY KEY (`goal_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `fk_goal_type` (`goal_type_id`);

--
-- Indexes for table `financial_liabilities`
--
ALTER TABLE `financial_liabilities`
  ADD PRIMARY KEY (`liability_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `fk_liability_type` (`liability_type_id`);

--
-- Indexes for table `goal_types`
--
ALTER TABLE `goal_types`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `group_members`
--
ALTER TABLE `group_members`
  ADD PRIMARY KEY (`member_id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `liability_types`
--
ALTER TABLE `liability_types`
  ADD PRIMARY KEY (`liability_type_id`);

--
-- Indexes for table `login_activity`
--
ALTER TABLE `login_activity`
  ADD PRIMARY KEY (`activity_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `profile_settings`
--
ALTER TABLE `profile_settings`
  ADD PRIMARY KEY (`setting_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `shared_balances`
--
ALTER TABLE `shared_balances`
  ADD PRIMARY KEY (`balance_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `shared_groups`
--
ALTER TABLE `shared_groups`
  ADD PRIMARY KEY (`group_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`status_id`),
  ADD UNIQUE KEY `status_name` (`status_name`);

--
-- Indexes for table `transaction_history`
--
ALTER TABLE `transaction_history`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `financial_goals`
--
ALTER TABLE `financial_goals`
  MODIFY `goal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `financial_liabilities`
--
ALTER TABLE `financial_liabilities`
  MODIFY `liability_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `goal_types`
--
ALTER TABLE `goal_types`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `group_members`
--
ALTER TABLE `group_members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `liability_types`
--
ALTER TABLE `liability_types`
  MODIFY `liability_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `login_activity`
--
ALTER TABLE `login_activity`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `profile_settings`
--
ALTER TABLE `profile_settings`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `shared_balances`
--
ALTER TABLE `shared_balances`
  MODIFY `balance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `shared_groups`
--
ALTER TABLE `shared_groups`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaction_history`
--
ALTER TABLE `transaction_history`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `financial_goals`
--
ALTER TABLE `financial_goals`
  ADD CONSTRAINT `financial_goals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `financial_goals_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`status_id`),
  ADD CONSTRAINT `fk_goal_type` FOREIGN KEY (`goal_type_id`) REFERENCES `goal_types` (`type_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `financial_liabilities`
--
ALTER TABLE `financial_liabilities`
  ADD CONSTRAINT `financial_liabilities_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `financial_liabilities_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`status_id`),
  ADD CONSTRAINT `fk_liability_type` FOREIGN KEY (`liability_type_id`) REFERENCES `liability_types` (`liability_type_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `group_members`
--
ALTER TABLE `group_members`
  ADD CONSTRAINT `group_members_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `shared_groups` (`group_id`),
  ADD CONSTRAINT `group_members_ibfk_3` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);

--
-- Constraints for table `login_activity`
--
ALTER TABLE `login_activity`
  ADD CONSTRAINT `login_activity_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `profile_settings`
--
ALTER TABLE `profile_settings`
  ADD CONSTRAINT `profile_settings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `shared_balances`
--
ALTER TABLE `shared_balances`
  ADD CONSTRAINT `shared_balances_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `shared_groups` (`group_id`),
  ADD CONSTRAINT `shared_balances_ibfk_2` FOREIGN KEY (`debtor_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `shared_balances_ibfk_3` FOREIGN KEY (`creditor_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `shared_groups`
--
ALTER TABLE `shared_groups`
  ADD CONSTRAINT `shared_groups_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `transaction_history`
--
ALTER TABLE `transaction_history`
  ADD CONSTRAINT `transaction_history_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `shared_groups` (`group_id`),
  ADD CONSTRAINT `transaction_history_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
