-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2018 at 09:37 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tsl_cube_messenger`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT '1',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `order`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 'Category 1', 'category-1', '2018-01-23 09:46:09', '2018-01-23 09:46:09'),
(2, NULL, 1, 'Category 2', 'category-2', '2018-01-23 09:46:09', '2018-01-23 09:46:09');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'clients/default.png',
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` double(8,5) NOT NULL,
  `longitude` double(8,5) NOT NULL,
  `primary_color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accent_color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `logo`, `email`, `phone`, `latitude`, `longitude`, `primary_color`, `accent_color`, `created_at`, `updated_at`) VALUES
(1, 'Test Client', 'clients/default.jpg', 'testclient@cubemessenger.com', '0723203475', -1.33113, 36.88117, '#4CAF50', '#FF4081', '2018-03-12 08:07:30', '2018-03-12 08:07:30');

-- --------------------------------------------------------

--
-- Table structure for table `client_subscriptions`
--

CREATE TABLE `client_subscriptions` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED DEFAULT NULL,
  `subscription_item_id` int(10) UNSIGNED DEFAULT NULL,
  `quantity` smallint(5) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client_subscription_deliveries`
--

CREATE TABLE `client_subscription_deliveries` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_subscription_id` int(10) UNSIGNED DEFAULT NULL,
  `item_cost` smallint(5) UNSIGNED NOT NULL COMMENT 'Retail price of the item at the time of delivery',
  `delivery_cost` smallint(5) UNSIGNED NOT NULL COMMENT 'includes delivery base cost of the item and cost based on distance',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client_subscription_schedules`
--

CREATE TABLE `client_subscription_schedules` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_subscription_id` int(10) UNSIGNED DEFAULT NULL,
  `subscription_schedule_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courier_options`
--

CREATE TABLE `courier_options` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plural_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `base_cost` double(8,2) NOT NULL DEFAULT '0.00',
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'icons/default.png',
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courier_options`
--

INSERT INTO `courier_options` (`id`, `name`, `plural_name`, `base_cost`, `icon`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Envelope', 'Envelopes', 50.00, 'icons/envelope.png', NULL, '2018-03-12 08:07:36', '2018-03-12 08:07:36'),
(2, 'Box', 'Boxes', 80.00, 'icons/box.jpg', NULL, '2018-03-12 08:07:36', '2018-03-12 08:07:36');

-- --------------------------------------------------------

--
-- Table structure for table `data_rows`
--

CREATE TABLE `data_rows` (
  `id` int(10) UNSIGNED NOT NULL,
  `data_type_id` int(10) UNSIGNED NOT NULL,
  `field` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `browse` tinyint(1) NOT NULL DEFAULT '1',
  `read` tinyint(1) NOT NULL DEFAULT '1',
  `edit` tinyint(1) NOT NULL DEFAULT '1',
  `add` tinyint(1) NOT NULL DEFAULT '1',
  `delete` tinyint(1) NOT NULL DEFAULT '1',
  `details` text COLLATE utf8mb4_unicode_ci,
  `order` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_rows`
--

INSERT INTO `data_rows` (`id`, `data_type_id`, `field`, `type`, `display_name`, `required`, `browse`, `read`, `edit`, `add`, `delete`, `details`, `order`) VALUES
(1, 1, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, '', 1),
(2, 1, 'author_id', 'text', 'Author', 1, 0, 1, 1, 0, 1, '', 2),
(3, 1, 'category_id', 'text', 'Category', 1, 0, 1, 1, 1, 0, '', 3),
(4, 1, 'title', 'text', 'Title', 1, 1, 1, 1, 1, 1, '', 4),
(5, 1, 'excerpt', 'text_area', 'excerpt', 1, 0, 1, 1, 1, 1, '', 5),
(6, 1, 'body', 'rich_text_box', 'Body', 1, 0, 1, 1, 1, 1, '', 6),
(7, 1, 'image', 'image', 'Post Image', 0, 1, 1, 1, 1, 1, '{\"resize\":{\"width\":\"1000\",\"height\":\"null\"},\"quality\":\"70%\",\"upsize\":true,\"thumbnails\":[{\"name\":\"medium\",\"scale\":\"50%\"},{\"name\":\"small\",\"scale\":\"25%\"},{\"name\":\"cropped\",\"crop\":{\"width\":\"300\",\"height\":\"250\"}}]}', 7),
(8, 1, 'slug', 'text', 'slug', 1, 0, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"title\",\"forceUpdate\":true}}', 8),
(9, 1, 'meta_description', 'text_area', 'meta_description', 1, 0, 1, 1, 1, 1, '', 9),
(10, 1, 'meta_keywords', 'text_area', 'meta_keywords', 1, 0, 1, 1, 1, 1, '', 10),
(11, 1, 'status', 'select_dropdown', 'status', 1, 1, 1, 1, 1, 1, '{\"default\":\"DRAFT\",\"options\":{\"PUBLISHED\":\"published\",\"DRAFT\":\"draft\",\"PENDING\":\"pending\"}}', 11),
(12, 1, 'created_at', 'timestamp', 'created_at', 0, 1, 1, 0, 0, 0, '', 12),
(13, 1, 'updated_at', 'timestamp', 'updated_at', 0, 0, 0, 0, 0, 0, '', 13),
(14, 2, 'id', 'number', 'id', 1, 0, 0, 0, 0, 0, '', 1),
(15, 2, 'author_id', 'text', 'author_id', 1, 0, 0, 0, 0, 0, '', 2),
(16, 2, 'title', 'text', 'title', 1, 1, 1, 1, 1, 1, '', 3),
(17, 2, 'excerpt', 'text_area', 'excerpt', 1, 0, 1, 1, 1, 1, '', 4),
(18, 2, 'body', 'rich_text_box', 'body', 1, 0, 1, 1, 1, 1, '', 5),
(19, 2, 'slug', 'text', 'slug', 1, 0, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"title\"}}', 6),
(20, 2, 'meta_description', 'text', 'meta_description', 1, 0, 1, 1, 1, 1, '', 7),
(21, 2, 'meta_keywords', 'text', 'meta_keywords', 1, 0, 1, 1, 1, 1, '', 8),
(22, 2, 'status', 'select_dropdown', 'status', 1, 1, 1, 1, 1, 1, '{\"default\":\"INACTIVE\",\"options\":{\"INACTIVE\":\"INACTIVE\",\"ACTIVE\":\"ACTIVE\"}}', 9),
(23, 2, 'created_at', 'timestamp', 'created_at', 1, 1, 1, 0, 0, 0, '', 10),
(24, 2, 'updated_at', 'timestamp', 'updated_at', 1, 0, 0, 0, 0, 0, '', 11),
(25, 2, 'image', 'image', 'image', 0, 1, 1, 1, 1, 1, '', 12),
(26, 3, 'id', 'number', 'id', 1, 1, 0, 0, 0, 0, NULL, 1),
(27, 3, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, NULL, 2),
(28, 3, 'email', 'text', 'Email', 0, 1, 1, 1, 1, 1, NULL, 7),
(29, 3, 'password', 'password', 'password', 0, 0, 0, 1, 1, 1, NULL, 8),
(30, 3, 'user_belongsto_role_relationship', 'relationship', 'Role', 0, 1, 1, 1, 1, 0, '{\"model\":\"TCG\\\\Voyager\\\\Models\\\\Role\",\"table\":\"roles\",\"type\":\"belongsTo\",\"column\":\"role_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"roles\",\"pivot\":\"0\"}', 17),
(31, 3, 'remember_token', 'text', 'remember_token', 0, 0, 0, 0, 0, 0, NULL, 9),
(32, 3, 'created_at', 'timestamp', 'Created At', 0, 0, 1, 0, 0, 0, NULL, 10),
(33, 3, 'updated_at', 'timestamp', 'updated_at', 0, 0, 1, 0, 0, 0, NULL, 11),
(34, 3, 'avatar', 'image', 'Avatar', 1, 0, 1, 1, 1, 1, NULL, 14),
(35, 5, 'id', 'number', 'id', 1, 0, 0, 0, 0, 0, '', 1),
(36, 5, 'name', 'text', 'name', 1, 1, 1, 1, 1, 1, '', 2),
(37, 5, 'created_at', 'timestamp', 'created_at', 0, 0, 0, 0, 0, 0, '', 3),
(38, 5, 'updated_at', 'timestamp', 'updated_at', 0, 0, 0, 0, 0, 0, '', 4),
(39, 4, 'id', 'number', 'id', 1, 0, 0, 0, 0, 0, '', 1),
(40, 4, 'parent_id', 'select_dropdown', 'parent_id', 0, 0, 1, 1, 1, 1, '{\"default\":\"\",\"null\":\"\",\"options\":{\"\":\"-- None --\"},\"relationship\":{\"key\":\"id\",\"label\":\"name\"}}', 2),
(41, 4, 'order', 'text', 'order', 1, 1, 1, 1, 1, 1, '{\"default\":1}', 3),
(42, 4, 'name', 'text', 'name', 1, 1, 1, 1, 1, 1, '', 4),
(43, 4, 'slug', 'text', 'slug', 1, 1, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"name\"}}', 5),
(44, 4, 'created_at', 'timestamp', 'created_at', 0, 0, 1, 0, 0, 0, '', 6),
(45, 4, 'updated_at', 'timestamp', 'updated_at', 0, 0, 0, 0, 0, 0, '', 7),
(46, 6, 'id', 'number', 'id', 1, 0, 0, 0, 0, 0, '', 1),
(47, 6, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, '', 2),
(48, 6, 'created_at', 'timestamp', 'created_at', 0, 0, 0, 0, 0, 0, '', 3),
(49, 6, 'updated_at', 'timestamp', 'updated_at', 0, 0, 0, 0, 0, 0, '', 4),
(50, 6, 'display_name', 'text', 'Display Name', 1, 1, 1, 1, 1, 1, '', 5),
(51, 1, 'seo_title', 'text', 'seo_title', 0, 1, 1, 1, 1, 1, '', 14),
(52, 1, 'featured', 'checkbox', 'featured', 1, 1, 1, 1, 1, 1, '', 15),
(53, 3, 'role_id', 'number', 'role_id', 0, 1, 1, 1, 1, 1, NULL, 16),
(54, 3, 'email_verification_code', 'number', 'Email Verification Code', 0, 0, 0, 0, 0, 0, NULL, 12),
(55, 3, 'email_verified', 'checkbox', 'Email Verified', 1, 0, 0, 0, 0, 0, NULL, 13),
(56, 3, 'phone', 'number', 'Phone', 0, 1, 1, 1, 1, 1, NULL, 15),
(57, 3, 'phone_verification_code', 'number', 'Phone Verification Code', 0, 0, 1, 0, 0, 0, NULL, 18),
(58, 3, 'phone_verified', 'checkbox', 'Phone Verified', 1, 0, 0, 0, 0, 0, NULL, 19),
(59, 3, 'password_recovery_code', 'number', 'Password Recovery Code', 0, 0, 0, 0, 0, 0, NULL, 20),
(62, 3, 'account_type', 'text', 'Account Type', 1, 0, 0, 0, 0, 0, NULL, 23),
(65, 3, 'latitude', 'number', 'Latitude', 0, 0, 0, 0, 0, 0, NULL, 25),
(66, 3, 'longitude', 'number', 'Longitude', 0, 0, 0, 0, 0, 0, NULL, 26),
(67, 7, 'id', 'number', 'Id', 1, 1, 1, 0, 0, 0, NULL, 1),
(68, 7, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, NULL, 2),
(69, 7, 'length', 'number', 'Length', 1, 1, 1, 1, 1, 1, NULL, 3),
(70, 7, 'width', 'number', 'Width', 1, 1, 1, 1, 1, 1, NULL, 4),
(71, 7, 'height', 'number', 'Height', 1, 1, 1, 1, 1, 1, NULL, 5),
(72, 7, 'weight', 'number', 'Weight', 1, 1, 1, 1, 1, 1, NULL, 6),
(73, 7, 'base_cost', 'number', 'Base Cost', 1, 1, 1, 1, 1, 1, NULL, 7),
(74, 7, 'cost_per_minute', 'number', 'Cost Per Minute', 1, 1, 1, 1, 1, 1, NULL, 8),
(75, 7, 'cost_per_kilometer', 'number', 'Cost Per Kilometer', 1, 1, 1, 1, 1, 1, NULL, 9),
(76, 7, 'created_at', 'timestamp', 'Created At', 0, 0, 1, 0, 0, 0, NULL, 10),
(77, 7, 'updated_at', 'timestamp', 'Updated At', 0, 0, 1, 0, 0, 0, NULL, 11),
(78, 8, 'user_id', 'number', 'User Id', 1, 1, 1, 1, 1, 1, NULL, 1),
(79, 8, 'vehicle_id', 'number', 'Vehicle Id', 1, 1, 1, 1, 1, 1, NULL, 2),
(80, 8, 'licence_plate', 'text', 'Licence Plate', 1, 1, 1, 1, 1, 1, NULL, 5),
(81, 8, 'driving_licence_number', 'text', 'Driving Licence Number', 1, 1, 1, 1, 1, 1, NULL, 6),
(82, 8, 'created_at', 'timestamp', 'Created At', 0, 0, 1, 0, 0, 0, NULL, 7),
(83, 8, 'updated_at', 'timestamp', 'Updated At', 0, 0, 1, 0, 0, 0, NULL, 8),
(84, 8, 'driver_detail_belongsto_vehicle_relationship', 'relationship', 'Vehicle', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\Vehicle\",\"table\":\"vehicles\",\"type\":\"belongsTo\",\"column\":\"vehicle_id\",\"key\":\"id\",\"label\":\"make\",\"pivot_table\":\"categories\",\"pivot\":\"0\"}', 4),
(85, 8, 'driver_detail_belongsto_user_relationship', 'relationship', 'User', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\User\",\"table\":\"users\",\"type\":\"belongsTo\",\"column\":\"user_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"categories\",\"pivot\":\"0\"}', 3),
(86, 9, 'id', 'number', 'Id', 1, 1, 1, 0, 0, 0, NULL, 1),
(87, 9, 'year', 'number', 'Year', 1, 1, 1, 1, 1, 1, NULL, 2),
(88, 9, 'make', 'number', 'Make', 1, 1, 1, 1, 1, 1, NULL, 3),
(89, 9, 'model', 'number', 'Model', 1, 1, 1, 1, 1, 1, NULL, 4),
(90, 9, 'created_at', 'timestamp', 'Created At', 0, 0, 0, 0, 0, 0, NULL, 5),
(91, 9, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 6),
(92, 10, 'id', 'number', 'Id', 1, 1, 1, 0, 0, 0, NULL, 1),
(93, 10, 'number', 'text', 'Number', 1, 1, 1, 0, 0, 0, NULL, 2),
(94, 10, 'status', 'text', 'Status', 1, 1, 1, 0, 0, 0, NULL, 3),
(95, 10, 'message_id', 'text', 'Message Id', 1, 1, 1, 0, 0, 0, NULL, 4),
(96, 10, 'cost', 'text', 'Cost', 1, 1, 1, 0, 0, 0, NULL, 5),
(97, 10, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 0, 0, 0, NULL, 6),
(98, 10, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 7),
(100, 11, 'id', 'number', 'Id', 1, 1, 1, 0, 0, 0, NULL, 1),
(101, 11, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, NULL, 2),
(102, 11, 'base_cost', 'number', 'Base Cost', 1, 1, 1, 1, 1, 1, NULL, 3),
(103, 11, 'icon', 'image', 'Icon', 1, 1, 1, 1, 1, 1, NULL, 4),
(104, 11, 'description', 'text', 'Description', 0, 1, 1, 1, 1, 1, NULL, 5),
(105, 11, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, NULL, 6),
(106, 11, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 7),
(107, 12, 'id', 'number', 'Id', 1, 1, 1, 0, 0, 0, NULL, 1),
(108, 12, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, NULL, 2),
(109, 12, 'logo', 'image', 'Logo', 1, 1, 1, 1, 1, 1, NULL, 3),
(110, 12, 'email', 'text', 'Email', 1, 1, 1, 1, 1, 1, NULL, 4),
(111, 12, 'phone', 'text', 'Phone', 1, 1, 1, 1, 1, 1, NULL, 5),
(112, 12, 'latitude', 'number', 'Latitude', 1, 0, 1, 1, 1, 1, NULL, 6),
(113, 12, 'longitude', 'number', 'Longitude', 1, 0, 1, 1, 1, 1, NULL, 7),
(114, 12, 'primary_color', 'color', 'Primary Color', 1, 1, 1, 1, 1, 1, NULL, 8),
(115, 12, 'accent_color', 'color', 'Accent Color', 1, 1, 1, 1, 1, 1, NULL, 9),
(116, 12, 'created_at', 'timestamp', 'Created At', 0, 0, 1, 0, 0, 0, NULL, 10),
(117, 12, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 11),
(118, 3, 'client_id', 'number', 'Client Id', 0, 1, 1, 1, 1, 1, NULL, 4),
(119, 3, 'user_belongsto_client_relationship', 'relationship', 'Client', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\Client\",\"table\":\"clients\",\"type\":\"belongsTo\",\"column\":\"client_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"categories\",\"pivot\":\"0\"}', 3),
(120, 13, 'id', 'checkbox', 'Id', 1, 1, 1, 0, 0, 0, NULL, 1),
(121, 13, 'client_id', 'checkbox', 'Client Id', 0, 1, 1, 0, 1, 0, NULL, 2),
(122, 13, 'subscription_item_id', 'checkbox', 'Subscription Item Id', 0, 1, 1, 0, 0, 0, NULL, 4),
(123, 13, 'quantity', 'number', 'Quantity', 1, 1, 1, 0, 0, 0, NULL, 6),
(124, 13, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 0, 0, 0, NULL, 7),
(125, 13, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 8),
(126, 13, 'client_subscription_belongsto_client_relationship', 'relationship', 'Client', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\Client\",\"table\":\"clients\",\"type\":\"belongsTo\",\"column\":\"client_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"categories\",\"pivot\":\"0\"}', 3),
(127, 13, 'client_subscription_belongsto_subscription_item_relationship', 'relationship', 'Subscription Item', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\SubscriptionItem\",\"table\":\"subscription_items\",\"type\":\"belongsTo\",\"column\":\"subscription_item_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"categories\",\"pivot\":\"0\"}', 5),
(128, 14, 'id', 'number', 'Id', 1, 0, 0, 0, 0, 0, NULL, 1),
(129, 14, 'client_id', 'number', 'Client Id', 1, 1, 1, 0, 0, 0, NULL, 2),
(130, 14, 'origin_name', 'checkbox', 'Origin', 1, 1, 1, 0, 0, 0, NULL, 5),
(131, 14, 'origin_vicinity', 'checkbox', 'Origin Vicinity', 1, 0, 0, 0, 0, 0, NULL, 6),
(132, 14, 'origin_formatted_address', 'checkbox', 'Origin Formatted Address', 1, 0, 0, 0, 0, 0, NULL, 7),
(133, 14, 'origin_latitude', 'checkbox', 'Origin Latitude', 1, 0, 0, 0, 0, 0, NULL, 8),
(134, 14, 'origin_longitude', 'checkbox', 'Origin Longitude', 1, 0, 0, 0, 0, 1, NULL, 9),
(135, 14, 'schedule_date', 'date', 'Schedule Date', 1, 1, 1, 1, 0, 0, NULL, 10),
(136, 14, 'schedule_time', 'text', 'Schedule Time', 1, 1, 1, 1, 0, 0, NULL, 11),
(137, 14, 'estimated_cost', 'number', 'Estimated Cost', 1, 1, 1, 0, 0, 1, NULL, 12),
(138, 14, 'estimated_max_distance', 'number', 'Estimated Max Distance', 1, 1, 1, 0, 0, 0, NULL, 13),
(139, 14, 'estimated_max_duration', 'number', 'Estimated Max Duration', 1, 1, 1, 0, 0, 0, NULL, 14),
(140, 14, 'actual_cost', 'number', 'Actual Cost', 1, 1, 1, 1, 0, 0, NULL, 15),
(141, 14, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 0, 0, 0, NULL, 16),
(142, 14, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 17),
(143, 14, 'delivery_belongsto_client_relationship', 'relationship', 'Client', 0, 1, 1, 0, 0, 0, '{\"model\":\"App\\\\Client\",\"table\":\"clients\",\"type\":\"belongsTo\",\"column\":\"client_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"categories\",\"pivot\":\"0\"}', 3),
(145, 15, 'id', 'checkbox', 'Id', 1, 1, 0, 0, 0, 0, NULL, 1),
(146, 15, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, NULL, 4),
(147, 15, 'subscription_type_id', 'checkbox', 'Subscription Type Id', 0, 1, 1, 1, 1, 1, NULL, 2),
(148, 15, 'item_cost', 'number', 'Item Cost', 1, 1, 1, 1, 1, 1, NULL, 5),
(149, 15, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 0, 0, 0, NULL, 6),
(150, 15, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 7),
(151, 16, 'id', 'checkbox', 'Id', 1, 1, 0, 0, 0, 0, NULL, 1),
(152, 16, 'name', 'checkbox', 'Name', 1, 1, 1, 1, 1, 1, NULL, 2),
(153, 16, 'delivery_base_cost', 'checkbox', 'Delivery Base Cost', 1, 1, 1, 1, 1, 1, NULL, 3),
(154, 16, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 0, 0, 0, NULL, 4),
(155, 16, 'updated_at', 'timestamp', 'Updated At', 0, 1, 1, 0, 0, 0, NULL, 5),
(156, 15, 'subscription_item_belongsto_subscription_type_relationship', 'relationship', 'Subscription Type', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\SubscriptionType\",\"table\":\"subscription_types\",\"type\":\"belongsTo\",\"column\":\"subscription_type_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"categories\",\"pivot\":\"0\"}', 3);

-- --------------------------------------------------------

--
-- Table structure for table `data_types`
--

CREATE TABLE `data_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name_singular` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name_plural` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `policy_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `controller` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `generate_permissions` tinyint(1) NOT NULL DEFAULT '0',
  `server_side` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_types`
--

INSERT INTO `data_types` (`id`, `name`, `slug`, `display_name_singular`, `display_name_plural`, `icon`, `model_name`, `policy_name`, `controller`, `description`, `generate_permissions`, `server_side`, `created_at`, `updated_at`) VALUES
(1, 'posts', 'posts', 'Post', 'Posts', 'voyager-news', 'TCG\\Voyager\\Models\\Post', 'TCG\\Voyager\\Policies\\PostPolicy', '', '', 1, 0, '2018-01-23 09:45:54', '2018-01-23 09:45:54'),
(2, 'pages', 'pages', 'Page', 'Pages', 'voyager-file-text', 'TCG\\Voyager\\Models\\Page', NULL, '', '', 1, 0, '2018-01-23 09:45:54', '2018-01-23 09:45:54'),
(3, 'users', 'users', 'User', 'Users', 'voyager-group', 'TCG\\Voyager\\Models\\User', 'TCG\\Voyager\\Policies\\UserPolicy', NULL, NULL, 1, 1, '2018-01-23 09:45:54', '2018-01-24 02:15:36'),
(4, 'categories', 'categories', 'Category', 'Categories', 'voyager-categories', 'TCG\\Voyager\\Models\\Category', NULL, '', '', 1, 0, '2018-01-23 09:45:54', '2018-01-23 09:45:54'),
(5, 'menus', 'menus', 'Menu', 'Menus', 'voyager-list', 'TCG\\Voyager\\Models\\Menu', NULL, '', '', 1, 0, '2018-01-23 09:45:54', '2018-01-23 09:45:54'),
(6, 'roles', 'roles', 'Role', 'Roles', 'voyager-lock', 'TCG\\Voyager\\Models\\Role', NULL, '', '', 1, 0, '2018-01-23 09:45:54', '2018-01-23 09:45:54'),
(7, 'driver_options', 'driver-options', 'Driver Option', 'Driver Options', 'voyager-list', 'App\\DriverOption', NULL, NULL, NULL, 1, 1, '2018-01-23 10:07:59', '2018-01-23 10:07:59'),
(8, 'driver_details', 'driver-details', 'Driver Detail', 'Driver Details', 'voyager-book', 'App\\DriverDetail', NULL, NULL, NULL, 1, 1, '2018-01-23 10:43:43', '2018-01-23 11:00:59'),
(9, 'vehicles', 'vehicles', 'Vehicle', 'Vehicles', 'voyager-params', 'App\\Vehicle', NULL, NULL, NULL, 1, 1, '2018-01-23 10:54:46', '2018-01-23 10:54:46'),
(10, 'verification_messages', 'verification-messages', 'Verification Message', 'Verification Messages', 'voyager-chat', 'App\\VerificationMessage', NULL, NULL, NULL, 1, 1, '2018-01-23 10:58:37', '2018-01-23 11:00:05'),
(11, 'courier_options', 'courier-options', 'Courier Option', 'Courier Options', NULL, 'App\\CourierOption', NULL, NULL, NULL, 1, 0, '2018-02-14 13:15:27', '2018-02-14 13:15:27'),
(12, 'clients', 'clients', 'Client', 'Clients', 'voyager-book', 'App\\Client', NULL, NULL, NULL, 1, 1, '2018-02-14 13:17:33', '2018-03-02 08:50:52'),
(13, 'client_subscriptions', 'client-subscriptions', 'Client Subscription', 'Client Subscriptions', NULL, 'App\\ClientSubscription', NULL, NULL, NULL, 1, 0, '2018-03-02 08:43:45', '2018-03-02 08:43:45'),
(14, 'deliveries', 'deliveries', 'Delivery', 'Deliveries', NULL, 'App\\Delivery', NULL, NULL, NULL, 1, 1, '2018-03-02 08:51:44', '2018-03-02 08:51:44'),
(15, 'subscription_items', 'subscription-items', 'Subscription Item', 'Subscription Items', NULL, 'App\\SubscriptionItem', NULL, NULL, NULL, 1, 0, '2018-03-05 06:20:40', '2018-03-05 06:20:40'),
(16, 'subscription_types', 'subscription-types', 'Subscription Type', 'Subscription Types', NULL, 'App\\SubscriptionType', NULL, NULL, NULL, 1, 1, '2018-03-05 06:24:20', '2018-03-05 06:24:20');

-- --------------------------------------------------------

--
-- Table structure for table `deliveries`
--

CREATE TABLE `deliveries` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `origin_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `origin_vicinity` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `origin_formatted_address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `origin_latitude` double(8,5) NOT NULL,
  `origin_longitude` double(8,5) NOT NULL,
  `schedule_date` date NOT NULL,
  `schedule_time` time NOT NULL,
  `estimated_cost` double(8,2) NOT NULL,
  `estimated_max_distance` double(8,2) NOT NULL,
  `estimated_max_duration` double(8,2) NOT NULL,
  `actual_cost` double(8,2) NOT NULL DEFAULT '0.00',
  `rider_id` int(10) UNSIGNED DEFAULT NULL,
  `pickup_time` timestamp NULL DEFAULT NULL,
  `pickup_latitude` double(8,5) DEFAULT NULL,
  `pickup_longitude` double(8,5) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_items`
--

CREATE TABLE `delivery_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `courier_option_id` int(10) UNSIGNED NOT NULL,
  `delivery_id` int(10) UNSIGNED NOT NULL,
  `destination_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `destination_vicinity` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `destination_formatted_address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `destination_latitude` double(8,5) NOT NULL,
  `destination_longitude` double(8,5) NOT NULL,
  `recipient_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipient_contact` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` smallint(5) UNSIGNED NOT NULL,
  `note` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estimated_distance` double(8,2) NOT NULL,
  `estimated_duration` double(8,2) NOT NULL,
  `status` enum('AT_PICKUP','EN_ROUTE_TO_DESTINATION','AT_DESTINATION') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'AT_PICKUP',
  `estimated_arrival_time` timestamp NULL DEFAULT NULL,
  `received_confirmation_code` smallint(5) UNSIGNED DEFAULT NULL,
  `received_time` timestamp NULL DEFAULT NULL,
  `received_latitude` double(8,5) DEFAULT NULL,
  `received_longitude` double(8,5) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2018-01-23 09:45:57', '2018-01-23 09:45:57');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `menu_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '_self',
  `icon_class` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `route` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameters` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `menu_id`, `title`, `url`, `target`, `icon_class`, `color`, `parent_id`, `order`, `created_at`, `updated_at`, `route`, `parameters`) VALUES
(1, 1, 'Dashboard', '', '_self', 'voyager-boat', NULL, NULL, 1, '2018-01-23 09:45:58', '2018-01-23 09:45:58', 'voyager.dashboard', NULL),
(2, 1, 'Media', '', '_self', 'voyager-images', NULL, NULL, 7, '2018-01-23 09:45:58', '2018-02-14 13:05:20', 'voyager.media.index', NULL),
(3, 1, 'Posts', '', '_self', 'voyager-news', NULL, 8, 7, '2018-01-23 09:45:58', '2018-02-14 13:05:54', 'voyager.posts.index', NULL),
(4, 1, 'Users', '', '_self', 'voyager-group', '#000000', NULL, 3, '2018-01-23 09:45:58', '2018-02-14 13:05:20', 'voyager.users.index', 'null'),
(5, 1, 'Categories', '', '_self', 'voyager-categories', NULL, 8, 8, '2018-01-23 09:45:58', '2018-02-14 13:05:55', 'voyager.categories.index', NULL),
(6, 1, 'Pages', '', '_self', 'voyager-file-text', NULL, 8, 9, '2018-01-23 09:45:58', '2018-02-14 13:05:57', 'voyager.pages.index', NULL),
(7, 1, 'Roles', '', '_self', 'voyager-lock', NULL, 8, 2, '2018-01-23 09:45:58', '2018-02-14 13:16:07', 'voyager.roles.index', NULL),
(8, 1, 'Developer Tools', '', '_self', 'voyager-tools', '#000000', NULL, 2, '2018-01-23 09:45:58', '2018-02-14 13:05:44', NULL, ''),
(9, 1, 'Menu Builder', '', '_self', 'voyager-list', NULL, 8, 4, '2018-01-23 09:45:58', '2018-02-14 13:16:00', 'voyager.menus.index', NULL),
(10, 1, 'Database', '', '_self', 'voyager-data', NULL, 8, 1, '2018-01-23 09:45:58', '2018-02-14 13:16:07', 'voyager.database.index', NULL),
(11, 1, 'Compass', '', '_self', 'voyager-compass', NULL, 8, 3, '2018-01-23 09:45:58', '2018-02-14 13:15:59', 'voyager.compass.index', NULL),
(12, 1, 'Settings', '', '_self', 'voyager-settings', NULL, 8, 6, '2018-01-23 09:45:58', '2018-02-14 13:05:20', 'voyager.settings.index', NULL),
(13, 1, 'Hooks', '', '_self', 'voyager-hook', NULL, 8, 5, '2018-01-23 09:46:12', '2018-02-14 13:16:00', 'voyager.hooks', NULL),
(14, 1, 'Driver Options', '/admin/driver-options', '_self', 'voyager-list', NULL, 18, 1, '2018-01-23 10:08:00', '2018-01-24 04:55:45', NULL, NULL),
(15, 1, 'Driver Details', '/admin/driver-details', '_self', 'voyager-book', '#000000', 18, 2, '2018-01-23 10:43:44', '2018-01-24 04:55:45', NULL, ''),
(17, 1, 'Verification Messages', '/admin/verification-messages', '_self', 'voyager-chat', '#000000', NULL, 8, '2018-01-23 10:58:38', '2018-02-14 13:05:20', NULL, ''),
(18, 1, 'Drivers', '', '_self', 'voyager-list', '#80ff00', NULL, 4, '2018-01-23 11:04:25', '2018-02-14 13:05:20', NULL, ''),
(21, 1, 'Courier Options', '/admin/courier-options', '_self', 'voyager-window-list', '#000000', NULL, 5, '2018-01-30 06:59:31', '2018-02-14 13:05:20', NULL, ''),
(22, 1, 'Clients', '/admin/clients', '_self', 'voyager-book', NULL, NULL, 9, '2018-02-14 13:17:33', '2018-02-14 13:17:33', NULL, NULL),
(23, 1, 'Client Subscriptions', '/admin/client-subscriptions', '_self', NULL, NULL, NULL, 10, '2018-03-02 08:43:46', '2018-03-02 08:43:46', NULL, NULL),
(24, 1, 'Deliveries', '/admin/deliveries', '_self', NULL, NULL, NULL, 11, '2018-03-02 08:51:45', '2018-03-02 08:51:45', NULL, NULL),
(25, 1, 'Subscription Items', '/admin/subscription-items', '_self', NULL, NULL, NULL, 12, '2018-03-05 06:20:40', '2018-03-05 06:20:40', NULL, NULL),
(26, 1, 'Subscription Types', '/admin/subscription-types', '_self', NULL, NULL, NULL, 13, '2018-03-05 06:24:20', '2018-03-05 06:24:20', NULL, NULL);

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
(1, '2014_01_10_071110_create_clients_table', 1),
(2, '2014_10_12_000000_create_users_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2016_01_01_000000_add_voyager_user_fields', 1),
(5, '2016_01_01_000000_create_data_types_table', 1),
(6, '2016_01_01_000000_create_pages_table', 1),
(7, '2016_01_01_000000_create_posts_table', 1),
(8, '2016_02_15_204651_create_categories_table', 1),
(9, '2016_05_19_173453_create_menu_table', 1),
(10, '2016_10_21_190000_create_roles_table', 1),
(11, '2016_10_21_190000_create_settings_table', 1),
(12, '2016_11_30_135954_create_permission_table', 1),
(13, '2016_11_30_141208_create_permission_role_table', 1),
(14, '2016_12_26_201236_data_types__add__server_side', 1),
(15, '2017_01_13_000000_add_route_to_menu_items_table', 1),
(16, '2017_01_14_005015_create_translations_table', 1),
(17, '2017_01_15_000000_add_permission_group_id_to_permissions_table', 1),
(18, '2017_01_15_000000_create_permission_groups_table', 1),
(19, '2017_01_15_000000_make_table_name_nullable_in_permissions_table', 1),
(20, '2017_03_06_000000_add_controller_to_data_types_table', 1),
(21, '2017_04_11_000000_alter_post_nullable_fields_table', 1),
(22, '2017_04_21_000000_add_order_to_data_rows_table', 1),
(23, '2017_07_05_210000_add_policyname_to_data_types_table', 1),
(24, '2017_08_05_000000_add_group_to_settings_table', 1),
(25, '2018_01_12_121710_create_sms_messages_table', 1),
(26, '2018_01_24_054903_create_sessions_table', 1),
(27, '2018_01_30_094836_create_courier_options_table', 1),
(28, '2018_02_08_101907_create_deliveries_table', 1),
(29, '2018_02_08_103250_create_delivery_items_table', 1),
(30, '2018_02_26_134302_create_subscription_types_table', 1),
(31, '2018_02_27_115325_create_subscription_schedules_table', 1),
(32, '2018_02_27_154259_create_subscription_items_table', 1),
(33, '2018_02_27_155538_create_client_subscriptions_table', 1),
(34, '2018_03_01_115347_create_client_subscription_schedules_table', 1),
(35, '2018_03_01_133356_create_client_subscription_deliveries_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `author_id` int(11) NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `body` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci,
  `status` enum('ACTIVE','INACTIVE') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'INACTIVE',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `author_id`, `title`, `excerpt`, `body`, `image`, `slug`, `meta_description`, `meta_keywords`, `status`, `created_at`, `updated_at`) VALUES
(1, 0, 'Hello World', 'Hang the jib grog grog blossom grapple dance the hempen jig gangway pressgang bilge rat to go on account lugger. Nelsons folly gabion line draught scallywag fire ship gaff fluke fathom case shot. Sea Legs bilge rat sloop matey gabion long clothes run a shot across the bow Gold Road cog league.', '<p>Hello World. Scallywag grog swab Cat o\'nine tails scuttle rigging hardtack cable nipper Yellow Jack. Handsomely spirits knave lad killick landlubber or just lubber deadlights chantey pinnace crack Jennys tea cup. Provost long clothes black spot Yellow Jack bilged on her anchor league lateen sail case shot lee tackle.</p>\r\n<p>Ballast spirits fluke topmast me quarterdeck schooner landlubber or just lubber gabion belaying pin. Pinnace stern galleon starboard warp carouser to go on account dance the hempen jig jolly boat measured fer yer chains. Man-of-war fire in the hole nipperkin handsomely doubloon barkadeer Brethren of the Coast gibbet driver squiffy.</p>', 'pages/page1.jpg', 'hello-world', 'Yar Meta Description', 'Keyword1, Keyword2', 'ACTIVE', '2018-01-23 09:46:10', '2018-01-23 09:46:10');

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `permission_group_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `key`, `table_name`, `created_at`, `updated_at`, `permission_group_id`) VALUES
(1, 'browse_admin', NULL, '2018-01-23 09:45:59', '2018-01-23 09:45:59', NULL),
(2, 'browse_database', NULL, '2018-01-23 09:45:59', '2018-01-23 09:45:59', NULL),
(3, 'browse_media', NULL, '2018-01-23 09:45:59', '2018-01-23 09:45:59', NULL),
(4, 'browse_compass', NULL, '2018-01-23 09:45:59', '2018-01-23 09:45:59', NULL),
(5, 'browse_menus', 'menus', '2018-01-23 09:45:59', '2018-01-23 09:45:59', NULL),
(6, 'read_menus', 'menus', '2018-01-23 09:45:59', '2018-01-23 09:45:59', NULL),
(7, 'edit_menus', 'menus', '2018-01-23 09:45:59', '2018-01-23 09:45:59', NULL),
(8, 'add_menus', 'menus', '2018-01-23 09:45:59', '2018-01-23 09:45:59', NULL),
(9, 'delete_menus', 'menus', '2018-01-23 09:45:59', '2018-01-23 09:45:59', NULL),
(10, 'browse_pages', 'pages', '2018-01-23 09:45:59', '2018-01-23 09:45:59', NULL),
(11, 'read_pages', 'pages', '2018-01-23 09:45:59', '2018-01-23 09:45:59', NULL),
(12, 'edit_pages', 'pages', '2018-01-23 09:45:59', '2018-01-23 09:45:59', NULL),
(13, 'add_pages', 'pages', '2018-01-23 09:45:59', '2018-01-23 09:45:59', NULL),
(14, 'delete_pages', 'pages', '2018-01-23 09:45:59', '2018-01-23 09:45:59', NULL),
(15, 'browse_roles', 'roles', '2018-01-23 09:45:59', '2018-01-23 09:45:59', NULL),
(16, 'read_roles', 'roles', '2018-01-23 09:45:59', '2018-01-23 09:45:59', NULL),
(17, 'edit_roles', 'roles', '2018-01-23 09:46:00', '2018-01-23 09:46:00', NULL),
(18, 'add_roles', 'roles', '2018-01-23 09:46:00', '2018-01-23 09:46:00', NULL),
(19, 'delete_roles', 'roles', '2018-01-23 09:46:00', '2018-01-23 09:46:00', NULL),
(20, 'browse_users', 'users', '2018-01-23 09:46:00', '2018-01-23 09:46:00', NULL),
(21, 'read_users', 'users', '2018-01-23 09:46:00', '2018-01-23 09:46:00', NULL),
(22, 'edit_users', 'users', '2018-01-23 09:46:00', '2018-01-23 09:46:00', NULL),
(23, 'add_users', 'users', '2018-01-23 09:46:00', '2018-01-23 09:46:00', NULL),
(24, 'delete_users', 'users', '2018-01-23 09:46:00', '2018-01-23 09:46:00', NULL),
(25, 'browse_posts', 'posts', '2018-01-23 09:46:00', '2018-01-23 09:46:00', NULL),
(26, 'read_posts', 'posts', '2018-01-23 09:46:00', '2018-01-23 09:46:00', NULL),
(27, 'edit_posts', 'posts', '2018-01-23 09:46:00', '2018-01-23 09:46:00', NULL),
(28, 'add_posts', 'posts', '2018-01-23 09:46:00', '2018-01-23 09:46:00', NULL),
(29, 'delete_posts', 'posts', '2018-01-23 09:46:00', '2018-01-23 09:46:00', NULL),
(30, 'browse_categories', 'categories', '2018-01-23 09:46:00', '2018-01-23 09:46:00', NULL),
(31, 'read_categories', 'categories', '2018-01-23 09:46:00', '2018-01-23 09:46:00', NULL),
(32, 'edit_categories', 'categories', '2018-01-23 09:46:01', '2018-01-23 09:46:01', NULL),
(33, 'add_categories', 'categories', '2018-01-23 09:46:01', '2018-01-23 09:46:01', NULL),
(34, 'delete_categories', 'categories', '2018-01-23 09:46:01', '2018-01-23 09:46:01', NULL),
(35, 'browse_settings', 'settings', '2018-01-23 09:46:01', '2018-01-23 09:46:01', NULL),
(36, 'read_settings', 'settings', '2018-01-23 09:46:01', '2018-01-23 09:46:01', NULL),
(37, 'edit_settings', 'settings', '2018-01-23 09:46:01', '2018-01-23 09:46:01', NULL),
(38, 'add_settings', 'settings', '2018-01-23 09:46:01', '2018-01-23 09:46:01', NULL),
(39, 'delete_settings', 'settings', '2018-01-23 09:46:01', '2018-01-23 09:46:01', NULL),
(40, 'browse_hooks', NULL, '2018-01-23 09:46:12', '2018-01-23 09:46:12', NULL),
(41, 'browse_driver_options', 'driver_options', '2018-01-23 10:08:00', '2018-01-23 10:08:00', NULL),
(42, 'read_driver_options', 'driver_options', '2018-01-23 10:08:00', '2018-01-23 10:08:00', NULL),
(43, 'edit_driver_options', 'driver_options', '2018-01-23 10:08:00', '2018-01-23 10:08:00', NULL),
(44, 'add_driver_options', 'driver_options', '2018-01-23 10:08:00', '2018-01-23 10:08:00', NULL),
(45, 'delete_driver_options', 'driver_options', '2018-01-23 10:08:00', '2018-01-23 10:08:00', NULL),
(46, 'browse_driver_details', 'driver_details', '2018-01-23 10:43:43', '2018-01-23 10:43:43', NULL),
(47, 'read_driver_details', 'driver_details', '2018-01-23 10:43:43', '2018-01-23 10:43:43', NULL),
(48, 'edit_driver_details', 'driver_details', '2018-01-23 10:43:43', '2018-01-23 10:43:43', NULL),
(49, 'add_driver_details', 'driver_details', '2018-01-23 10:43:43', '2018-01-23 10:43:43', NULL),
(50, 'delete_driver_details', 'driver_details', '2018-01-23 10:43:44', '2018-01-23 10:43:44', NULL),
(51, 'browse_vehicles', 'vehicles', '2018-01-23 10:54:46', '2018-01-23 10:54:46', NULL),
(52, 'read_vehicles', 'vehicles', '2018-01-23 10:54:46', '2018-01-23 10:54:46', NULL),
(53, 'edit_vehicles', 'vehicles', '2018-01-23 10:54:46', '2018-01-23 10:54:46', NULL),
(54, 'add_vehicles', 'vehicles', '2018-01-23 10:54:46', '2018-01-23 10:54:46', NULL),
(55, 'delete_vehicles', 'vehicles', '2018-01-23 10:54:46', '2018-01-23 10:54:46', NULL),
(56, 'browse_verification_messages', 'verification_messages', '2018-01-23 10:58:38', '2018-01-23 10:58:38', NULL),
(57, 'read_verification_messages', 'verification_messages', '2018-01-23 10:58:38', '2018-01-23 10:58:38', NULL),
(58, 'edit_verification_messages', 'verification_messages', '2018-01-23 10:58:38', '2018-01-23 10:58:38', NULL),
(59, 'add_verification_messages', 'verification_messages', '2018-01-23 10:58:38', '2018-01-23 10:58:38', NULL),
(60, 'delete_verification_messages', 'verification_messages', '2018-01-23 10:58:38', '2018-01-23 10:58:38', NULL),
(61, 'browse_courier_options', 'courier_options', '2018-02-14 13:15:27', '2018-02-14 13:15:27', NULL),
(62, 'read_courier_options', 'courier_options', '2018-02-14 13:15:27', '2018-02-14 13:15:27', NULL),
(63, 'edit_courier_options', 'courier_options', '2018-02-14 13:15:27', '2018-02-14 13:15:27', NULL),
(64, 'add_courier_options', 'courier_options', '2018-02-14 13:15:27', '2018-02-14 13:15:27', NULL),
(65, 'delete_courier_options', 'courier_options', '2018-02-14 13:15:27', '2018-02-14 13:15:27', NULL),
(66, 'browse_clients', 'clients', '2018-02-14 13:17:33', '2018-02-14 13:17:33', NULL),
(67, 'read_clients', 'clients', '2018-02-14 13:17:33', '2018-02-14 13:17:33', NULL),
(68, 'edit_clients', 'clients', '2018-02-14 13:17:33', '2018-02-14 13:17:33', NULL),
(69, 'add_clients', 'clients', '2018-02-14 13:17:33', '2018-02-14 13:17:33', NULL),
(70, 'delete_clients', 'clients', '2018-02-14 13:17:33', '2018-02-14 13:17:33', NULL),
(71, 'browse_client_subscriptions', 'client_subscriptions', '2018-03-02 08:43:46', '2018-03-02 08:43:46', NULL),
(72, 'read_client_subscriptions', 'client_subscriptions', '2018-03-02 08:43:46', '2018-03-02 08:43:46', NULL),
(73, 'edit_client_subscriptions', 'client_subscriptions', '2018-03-02 08:43:46', '2018-03-02 08:43:46', NULL),
(74, 'add_client_subscriptions', 'client_subscriptions', '2018-03-02 08:43:46', '2018-03-02 08:43:46', NULL),
(75, 'delete_client_subscriptions', 'client_subscriptions', '2018-03-02 08:43:46', '2018-03-02 08:43:46', NULL),
(76, 'browse_deliveries', 'deliveries', '2018-03-02 08:51:45', '2018-03-02 08:51:45', NULL),
(77, 'read_deliveries', 'deliveries', '2018-03-02 08:51:45', '2018-03-02 08:51:45', NULL),
(78, 'edit_deliveries', 'deliveries', '2018-03-02 08:51:45', '2018-03-02 08:51:45', NULL),
(79, 'add_deliveries', 'deliveries', '2018-03-02 08:51:45', '2018-03-02 08:51:45', NULL),
(80, 'delete_deliveries', 'deliveries', '2018-03-02 08:51:45', '2018-03-02 08:51:45', NULL),
(81, 'browse_subscription_items', 'subscription_items', '2018-03-05 06:20:40', '2018-03-05 06:20:40', NULL),
(82, 'read_subscription_items', 'subscription_items', '2018-03-05 06:20:40', '2018-03-05 06:20:40', NULL),
(83, 'edit_subscription_items', 'subscription_items', '2018-03-05 06:20:40', '2018-03-05 06:20:40', NULL),
(84, 'add_subscription_items', 'subscription_items', '2018-03-05 06:20:40', '2018-03-05 06:20:40', NULL),
(85, 'delete_subscription_items', 'subscription_items', '2018-03-05 06:20:40', '2018-03-05 06:20:40', NULL),
(86, 'browse_subscription_types', 'subscription_types', '2018-03-05 06:24:20', '2018-03-05 06:24:20', NULL),
(87, 'read_subscription_types', 'subscription_types', '2018-03-05 06:24:20', '2018-03-05 06:24:20', NULL),
(88, 'edit_subscription_types', 'subscription_types', '2018-03-05 06:24:20', '2018-03-05 06:24:20', NULL),
(89, 'add_subscription_types', 'subscription_types', '2018-03-05 06:24:20', '2018-03-05 06:24:20', NULL),
(90, 'delete_subscription_types', 'subscription_types', '2018-03-05 06:24:20', '2018-03-05 06:24:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission_groups`
--

CREATE TABLE `permission_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(87, 1),
(88, 1),
(89, 1),
(90, 1);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `author_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci,
  `status` enum('PUBLISHED','DRAFT','PENDING') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'DRAFT',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `author_id`, `category_id`, `title`, `seo_title`, `excerpt`, `body`, `image`, `slug`, `meta_description`, `meta_keywords`, `status`, `featured`, `created_at`, `updated_at`) VALUES
(1, 0, NULL, 'Lorem Ipsum Post', NULL, 'This is the excerpt for the Lorem Ipsum Post', '<p>This is the body of the lorem ipsum post</p>', 'posts/post1.jpg', 'lorem-ipsum-post', 'This is the meta description', 'keyword1, keyword2, keyword3', 'PUBLISHED', 0, '2018-01-23 09:46:09', '2018-01-23 09:46:09'),
(2, 0, NULL, 'My Sample Post', NULL, 'This is the excerpt for the sample Post', '<p>This is the body for the sample post, which includes the body.</p>\r\n<h2>We can use all kinds of format!</h2>\r\n<p>And include a bunch of other stuff.</p>', 'posts/post2.jpg', 'my-sample-post', 'Meta Description for sample post', 'keyword1, keyword2, keyword3', 'PUBLISHED', 0, '2018-01-23 09:46:09', '2018-01-23 09:46:09'),
(3, 0, NULL, 'Latest Post', NULL, 'This is the excerpt for the latest post', '<p>This is the body for the latest post</p>', 'posts/post3.jpg', 'latest-post', 'This is the meta description', 'keyword1, keyword2, keyword3', 'PUBLISHED', 0, '2018-01-23 09:46:09', '2018-01-23 09:46:09'),
(4, 0, NULL, 'Yarr Post', NULL, 'Reef sails nipperkin bring a spring upon her cable coffer jury mast spike marooned Pieces of Eight poop deck pillage. Clipper driver coxswain galleon hempen halter come about pressgang gangplank boatswain swing the lead. Nipperkin yard skysail swab lanyard Blimey bilge water ho quarter Buccaneer.', '<p>Swab deadlights Buccaneer fire ship square-rigged dance the hempen jig weigh anchor cackle fruit grog furl. Crack Jennys tea cup chase guns pressgang hearties spirits hogshead Gold Road six pounders fathom measured fer yer chains. Main sheet provost come about trysail barkadeer crimp scuttle mizzenmast brig plunder.</p>\r\n<p>Mizzen league keelhaul galleon tender cog chase Barbary Coast doubloon crack Jennys tea cup. Blow the man down lugsail fire ship pinnace cackle fruit line warp Admiral of the Black strike colors doubloon. Tackle Jack Ketch come about crimp rum draft scuppers run a shot across the bow haul wind maroon.</p>\r\n<p>Interloper heave down list driver pressgang holystone scuppers tackle scallywag bilged on her anchor. Jack Tar interloper draught grapple mizzenmast hulk knave cable transom hogshead. Gaff pillage to go on account grog aft chase guns piracy yardarm knave clap of thunder.</p>', 'posts/post4.jpg', 'yarr-post', 'this be a meta descript', 'keyword1, keyword2, keyword3', 'PUBLISHED', 0, '2018-01-23 09:46:09', '2018-01-23 09:46:09');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Administrator', '2018-01-23 09:45:58', '2018-01-23 09:45:58'),
(2, 'user', 'Normal User', '2018-01-23 09:45:58', '2018-01-23 09:45:58'),
(3, 'client_admin', 'Client Administrator', '2018-03-05 06:04:42', '2018-03-05 06:04:42');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(11) NOT NULL DEFAULT '1',
  `group` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `display_name`, `value`, `details`, `type`, `order`, `group`) VALUES
(1, 'site.title', 'Site Title', 'Cube Messenger', '', 'text', 1, 'Site'),
(2, 'site.description', 'Site Description', 'Site Description', '', 'text', 2, 'Site'),
(3, 'site.logo', 'Site Logo', '', '', 'image', 3, 'Site'),
(4, 'site.google_analytics_tracking_id', 'Google Analytics Tracking ID', '', '', 'text', 4, 'Site'),
(5, 'admin.bg_image', 'Admin Background Image', '', '', 'image', 5, 'Admin'),
(6, 'admin.title', 'Admin Title', 'CM Admin', '', 'text', 1, 'Admin'),
(7, 'admin.description', 'Admin Description', 'Admin for Cube Messenger', '', 'text', 2, 'Admin'),
(8, 'admin.loader', 'Admin Loader', '', '', 'image', 3, 'Admin'),
(9, 'admin.icon_image', 'Admin Icon Image', '', '', 'image', 4, 'Admin'),
(10, 'admin.google_analytics_client_id', 'Google Analytics Client ID (used for admin dashboard)', '', '', 'text', 1, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `sms_messages`
--

CREATE TABLE `sms_messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `destination` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscription_items`
--

CREATE TABLE `subscription_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subscription_type_id` int(10) UNSIGNED DEFAULT NULL,
  `item_cost` smallint(5) UNSIGNED NOT NULL COMMENT 'Current retail price of the item',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscription_items`
--

INSERT INTO `subscription_items` (`id`, `name`, `subscription_type_id`, `item_cost`, `created_at`, `updated_at`) VALUES
(1, 'Daily Nation', 1, 35, '2018-03-12 08:07:37', '2018-03-12 08:07:37'),
(2, 'The Standard', 1, 35, '2018-03-12 08:07:37', '2018-03-12 08:07:37'),
(3, 'The Star', 1, 35, '2018-03-12 08:07:37', '2018-03-12 08:07:37'),
(4, 'The EastAfrican', 1, 35, '2018-03-12 08:07:37', '2018-03-12 08:07:37'),
(5, 'Business Daily Africa', 1, 35, '2018-03-12 08:07:38', '2018-03-12 08:07:38'),
(6, 'Taifa Leo', 1, 35, '2018-03-12 08:07:38', '2018-03-12 08:07:38'),
(7, 'Kenya Times', 1, 35, '2018-03-12 08:07:38', '2018-03-12 08:07:38'),
(8, 'Kenya Gazzette', 1, 35, '2018-03-12 08:07:38', '2018-03-12 08:07:38');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_schedules`
--

CREATE TABLE `subscription_schedules` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` enum('Everyday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscription_schedules`
--

INSERT INTO `subscription_schedules` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Everyday', 'Deliver everyday', '2018-03-12 08:07:36', '2018-03-12 08:07:36'),
(2, 'Monday', 'Deliver on Monday', '2018-03-12 08:07:36', '2018-03-12 08:07:36'),
(3, 'Tuesday', 'Deliver on Tuesday', '2018-03-12 08:07:37', '2018-03-12 08:07:37'),
(4, 'Wednesday', 'Deliver on Wednesday', '2018-03-12 08:07:37', '2018-03-12 08:07:37'),
(5, 'Thursday', 'Deliver on Thursday', '2018-03-12 08:07:37', '2018-03-12 08:07:37'),
(6, 'Friday', 'Deliver on Friday', '2018-03-12 08:07:37', '2018-03-12 08:07:37');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_types`
--

CREATE TABLE `subscription_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_base_cost` smallint(5) UNSIGNED NOT NULL COMMENT 'Base cost for delivering the item to the client',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscription_types`
--

INSERT INTO `subscription_types` (`id`, `name`, `delivery_base_cost`, `created_at`, `updated_at`) VALUES
(1, 'Newspaper', 10, '2018-03-12 08:07:36', '2018-03-12 08:07:36'),
(2, 'Milk', 5, '2018-03-12 08:07:36', '2018-03-12 08:07:36');

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `table_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `column_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foreign_key` int(10) UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `translations`
--

INSERT INTO `translations` (`id`, `table_name`, `column_name`, `foreign_key`, `locale`, `value`, `created_at`, `updated_at`) VALUES
(1, 'data_types', 'display_name_singular', 1, 'pt', 'Post', '2018-01-23 09:46:10', '2018-01-23 09:46:10'),
(2, 'data_types', 'display_name_singular', 2, 'pt', 'Página', '2018-01-23 09:46:10', '2018-01-23 09:46:10'),
(3, 'data_types', 'display_name_singular', 3, 'pt', 'Utilizador', '2018-01-23 09:46:10', '2018-01-23 09:46:10'),
(4, 'data_types', 'display_name_singular', 4, 'pt', 'Categoria', '2018-01-23 09:46:10', '2018-01-23 09:46:10'),
(5, 'data_types', 'display_name_singular', 5, 'pt', 'Menu', '2018-01-23 09:46:10', '2018-01-23 09:46:10'),
(6, 'data_types', 'display_name_singular', 6, 'pt', 'Função', '2018-01-23 09:46:10', '2018-01-23 09:46:10'),
(7, 'data_types', 'display_name_plural', 1, 'pt', 'Posts', '2018-01-23 09:46:10', '2018-01-23 09:46:10'),
(8, 'data_types', 'display_name_plural', 2, 'pt', 'Páginas', '2018-01-23 09:46:10', '2018-01-23 09:46:10'),
(9, 'data_types', 'display_name_plural', 3, 'pt', 'Utilizadores', '2018-01-23 09:46:10', '2018-01-23 09:46:10'),
(10, 'data_types', 'display_name_plural', 4, 'pt', 'Categorias', '2018-01-23 09:46:11', '2018-01-23 09:46:11'),
(11, 'data_types', 'display_name_plural', 5, 'pt', 'Menus', '2018-01-23 09:46:11', '2018-01-23 09:46:11'),
(12, 'data_types', 'display_name_plural', 6, 'pt', 'Funções', '2018-01-23 09:46:11', '2018-01-23 09:46:11'),
(13, 'categories', 'slug', 1, 'pt', 'categoria-1', '2018-01-23 09:46:11', '2018-01-23 09:46:11'),
(14, 'categories', 'name', 1, 'pt', 'Categoria 1', '2018-01-23 09:46:11', '2018-01-23 09:46:11'),
(15, 'categories', 'slug', 2, 'pt', 'categoria-2', '2018-01-23 09:46:11', '2018-01-23 09:46:11'),
(16, 'categories', 'name', 2, 'pt', 'Categoria 2', '2018-01-23 09:46:11', '2018-01-23 09:46:11'),
(17, 'pages', 'title', 1, 'pt', 'Olá Mundo', '2018-01-23 09:46:11', '2018-01-23 09:46:11'),
(18, 'pages', 'slug', 1, 'pt', 'ola-mundo', '2018-01-23 09:46:11', '2018-01-23 09:46:11'),
(19, 'pages', 'body', 1, 'pt', '<p>Olá Mundo. Scallywag grog swab Cat o\'nine tails scuttle rigging hardtack cable nipper Yellow Jack. Handsomely spirits knave lad killick landlubber or just lubber deadlights chantey pinnace crack Jennys tea cup. Provost long clothes black spot Yellow Jack bilged on her anchor league lateen sail case shot lee tackle.</p>\r\n<p>Ballast spirits fluke topmast me quarterdeck schooner landlubber or just lubber gabion belaying pin. Pinnace stern galleon starboard warp carouser to go on account dance the hempen jig jolly boat measured fer yer chains. Man-of-war fire in the hole nipperkin handsomely doubloon barkadeer Brethren of the Coast gibbet driver squiffy.</p>', '2018-01-23 09:46:11', '2018-01-23 09:46:11'),
(20, 'menu_items', 'title', 1, 'pt', 'Painel de Controle', '2018-01-23 09:46:11', '2018-01-23 09:46:11'),
(21, 'menu_items', 'title', 2, 'pt', 'Media', '2018-01-23 09:46:11', '2018-01-23 09:46:11'),
(22, 'menu_items', 'title', 3, 'pt', 'Publicações', '2018-01-23 09:46:11', '2018-01-23 09:46:11'),
(23, 'menu_items', 'title', 4, 'pt', 'Utilizadores', '2018-01-23 09:46:11', '2018-01-23 09:46:11'),
(24, 'menu_items', 'title', 5, 'pt', 'Categorias', '2018-01-23 09:46:11', '2018-01-23 09:46:11'),
(25, 'menu_items', 'title', 6, 'pt', 'Páginas', '2018-01-23 09:46:11', '2018-01-23 09:46:11'),
(26, 'menu_items', 'title', 7, 'pt', 'Funções', '2018-01-23 09:46:12', '2018-01-23 09:46:12'),
(27, 'menu_items', 'title', 8, 'pt', 'Ferramentas', '2018-01-23 09:46:12', '2018-01-23 09:46:12'),
(28, 'menu_items', 'title', 9, 'pt', 'Menus', '2018-01-23 09:46:12', '2018-01-23 09:46:12'),
(29, 'menu_items', 'title', 10, 'pt', 'Base de dados', '2018-01-23 09:46:12', '2018-01-23 09:46:12'),
(30, 'menu_items', 'title', 12, 'pt', 'Configurações', '2018-01-23 09:46:12', '2018-01-23 09:46:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `client_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'users/default.png',
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verification_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified` tinyint(1) NOT NULL DEFAULT '0',
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_verification_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_verified` tinyint(1) NOT NULL DEFAULT '0',
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_recovery_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_type` enum('USER','RIDER') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'USER',
  `latitude` double(8,5) DEFAULT NULL,
  `longitude` double(8,5) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `client_id`, `name`, `avatar`, `email`, `email_verification_code`, `email_verified`, `phone`, `phone_verification_code`, `phone_verified`, `password`, `password_recovery_code`, `account_type`, `latitude`, `longitude`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'Administrator', 'users/default.png', 'admin@cube-messenger.com', NULL, 1, NULL, NULL, 0, '$2y$10$UXErtB0T3cP6LwYG5/1Yc..p8GOQ9maTWw81XrTeTu5GjckbPwUQ6', NULL, 'USER', NULL, NULL, 'Y1JWd54jKGZt85urLYi2leEz7HOL37QNUFf38iFMQFmjoSbNJmmHD1Defkvf', '2018-03-12 08:07:30', '2018-03-12 08:07:30'),
(2, 2, 1, 'Test User', 'users/default.png', 'testuser@cube-messenger.com', NULL, 1, '254723203475', NULL, 1, '$2y$10$1amCXpUynRj7t2TeG9LcYehDI8/lGspyLPVjYfw3i.PVI5VcdgiH2', NULL, 'USER', NULL, NULL, 'h5iZFXbalvIS5b9jAWrYptqwhHL22NLbfaPlflRksBoEDQQATrm921S62x9X', '2018-03-12 08:07:30', '2018-03-12 08:07:31'),
(3, 2, NULL, 'Test Rider ', 'users/default.png', 'testrider@cube-messenger.com', NULL, 1, '(693) 734-1676 x122', NULL, 1, '$2y$10$OlybEifb5WYGAStikrFDFO4a./Za7S32OVobkjVrLcChzcUUlACEi', NULL, 'RIDER', -1.37958, 36.52708, 'rU0mw0s5h2TW1LZLGDs1kMNCNYpwbVxP8L6jRUjb8Ko8wpimwVKGn2mUmpJi', '2018-03-12 08:07:34', '2018-03-12 08:07:34'),
(4, 2, NULL, 'Test Rider 1', 'users/default.png', 'testrider1@cube-messenger.com', NULL, 1, '+1 (758) 935-5475', NULL, 1, '$2y$10$TMnY4hwgeeNH0sa6YzPOyelNsxw4EiuO.kR53N2PBNNEtoBf4fs7e', NULL, 'RIDER', -1.55088, 37.10980, 'DuHzEkVG4YwoA5eeqzkbuKRnX0eZXMrzRgiIRfYTPSsS86rvL6cflv1rtaMX', '2018-03-12 08:07:34', '2018-03-12 08:07:34'),
(5, 2, NULL, 'Test Rider 2', 'users/default.png', 'testrider2@cube-messenger.com', NULL, 1, '536.447.3549 x2312', NULL, 1, '$2y$10$ULWiZPD/8ubF6RJIzK981eTglRqGlUTyPbEEXycGW3HusvKQnOxOS', NULL, 'RIDER', -1.27669, 36.85638, '8Tqo7U13aTFogpXqEXcnxNPq24hHmPJ1TzlPo5wX6bQfJYaFs5t5NGylT20S', '2018-03-12 08:07:35', '2018-03-12 08:07:35'),
(6, 2, NULL, 'Test Rider 3', 'users/default.png', 'testrider3@cube-messenger.com', NULL, 1, '574.724.4928', NULL, 1, '$2y$10$Fu9pv74vOulLwtQSkm18t.rIbx4ZtKJI4F8mLtqTEzznCEmBT1Pc.', NULL, 'RIDER', -1.33629, 36.87402, 'ZvYSLWc7yJoB3Yp5HiuhQOGQKWZNPAnLAmslG6ji65oBHxnCAyCQ71b53H63', '2018-03-12 08:07:35', '2018-03-12 08:07:35'),
(7, 2, NULL, 'Test Rider 4', 'users/default.png', 'testrider4@cube-messenger.com', NULL, 1, '+15817188873', NULL, 1, '$2y$10$Q7UaAy6fKEUQ8HJ6HG32jO9WtJABESUA2mpaOzZWqm8bj1f7/pBvy', NULL, 'RIDER', -1.19187, 37.11611, 'dLO95gpB0qTloCarLyDoDCMZlR3GMzDNAHv4ql0zhjPz0faLzjoK18b1vRtv', '2018-03-12 08:07:35', '2018-03-12 08:07:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clients_email_unique` (`email`),
  ADD UNIQUE KEY `clients_phone_unique` (`phone`);

--
-- Indexes for table `client_subscriptions`
--
ALTER TABLE `client_subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_subscriptions_client_id_foreign` (`client_id`),
  ADD KEY `client_subscriptions_subscription_item_id_foreign` (`subscription_item_id`);

--
-- Indexes for table `client_subscription_deliveries`
--
ALTER TABLE `client_subscription_deliveries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_subscription_deliveries_client_subscription_id_foreign` (`client_subscription_id`);

--
-- Indexes for table `client_subscription_schedules`
--
ALTER TABLE `client_subscription_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_subscription_schedules_client_subscription_id_foreign` (`client_subscription_id`),
  ADD KEY `client_subscription_schedules_subscription_schedule_id_foreign` (`subscription_schedule_id`);

--
-- Indexes for table `courier_options`
--
ALTER TABLE `courier_options`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `courier_options_name_unique` (`name`),
  ADD UNIQUE KEY `courier_options_plural_name_unique` (`plural_name`);

--
-- Indexes for table `data_rows`
--
ALTER TABLE `data_rows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `data_rows_data_type_id_foreign` (`data_type_id`);

--
-- Indexes for table `data_types`
--
ALTER TABLE `data_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `data_types_name_unique` (`name`),
  ADD UNIQUE KEY `data_types_slug_unique` (`slug`);

--
-- Indexes for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `deliveries_client_id_foreign` (`client_id`),
  ADD KEY `deliveries_rider_id_foreign` (`rider_id`);

--
-- Indexes for table `delivery_items`
--
ALTER TABLE `delivery_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delivery_items_courier_option_id_foreign` (`courier_option_id`),
  ADD KEY `delivery_items_delivery_id_foreign` (`delivery_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menus_name_unique` (`name`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_items_menu_id_foreign` (`menu_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pages_slug_unique` (`slug`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permissions_key_index` (`key`);

--
-- Indexes for table `permission_groups`
--
ALTER TABLE `permission_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permission_groups_name_unique` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_permission_id_index` (`permission_id`),
  ADD KEY `permission_role_role_id_index` (`role_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `posts_slug_unique` (`slug`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD UNIQUE KEY `sessions_id_unique` (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `sms_messages`
--
ALTER TABLE `sms_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription_items`
--
ALTER TABLE `subscription_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscription_items_subscription_type_id_foreign` (`subscription_type_id`);

--
-- Indexes for table `subscription_schedules`
--
ALTER TABLE `subscription_schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription_types`
--
ALTER TABLE `subscription_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `translations_table_name_column_name_foreign_key_locale_unique` (`table_name`,`column_name`,`foreign_key`,`locale`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD KEY `users_client_id_foreign` (`client_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `client_subscriptions`
--
ALTER TABLE `client_subscriptions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client_subscription_deliveries`
--
ALTER TABLE `client_subscription_deliveries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client_subscription_schedules`
--
ALTER TABLE `client_subscription_schedules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courier_options`
--
ALTER TABLE `courier_options`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `data_rows`
--
ALTER TABLE `data_rows`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table `data_types`
--
ALTER TABLE `data_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `deliveries`
--
ALTER TABLE `deliveries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_items`
--
ALTER TABLE `delivery_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `permission_groups`
--
ALTER TABLE `permission_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sms_messages`
--
ALTER TABLE `sms_messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscription_items`
--
ALTER TABLE `subscription_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `subscription_schedules`
--
ALTER TABLE `subscription_schedules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `subscription_types`
--
ALTER TABLE `subscription_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `client_subscriptions`
--
ALTER TABLE `client_subscriptions`
  ADD CONSTRAINT `client_subscriptions_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `client_subscriptions_subscription_item_id_foreign` FOREIGN KEY (`subscription_item_id`) REFERENCES `subscription_items` (`id`);

--
-- Constraints for table `client_subscription_deliveries`
--
ALTER TABLE `client_subscription_deliveries`
  ADD CONSTRAINT `client_subscription_deliveries_client_subscription_id_foreign` FOREIGN KEY (`client_subscription_id`) REFERENCES `client_subscriptions` (`id`);

--
-- Constraints for table `client_subscription_schedules`
--
ALTER TABLE `client_subscription_schedules`
  ADD CONSTRAINT `client_subscription_schedules_client_subscription_id_foreign` FOREIGN KEY (`client_subscription_id`) REFERENCES `client_subscriptions` (`id`),
  ADD CONSTRAINT `client_subscription_schedules_subscription_schedule_id_foreign` FOREIGN KEY (`subscription_schedule_id`) REFERENCES `subscription_schedules` (`id`);

--
-- Constraints for table `data_rows`
--
ALTER TABLE `data_rows`
  ADD CONSTRAINT `data_rows_data_type_id_foreign` FOREIGN KEY (`data_type_id`) REFERENCES `data_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD CONSTRAINT `deliveries_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `deliveries_rider_id_foreign` FOREIGN KEY (`rider_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `delivery_items`
--
ALTER TABLE `delivery_items`
  ADD CONSTRAINT `delivery_items_courier_option_id_foreign` FOREIGN KEY (`courier_option_id`) REFERENCES `courier_options` (`id`),
  ADD CONSTRAINT `delivery_items_delivery_id_foreign` FOREIGN KEY (`delivery_id`) REFERENCES `deliveries` (`id`);

--
-- Constraints for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `menu_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subscription_items`
--
ALTER TABLE `subscription_items`
  ADD CONSTRAINT `subscription_items_subscription_type_id_foreign` FOREIGN KEY (`subscription_type_id`) REFERENCES `subscription_types` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
