-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2018 at 09:08 AM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

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

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `client_id`, `department_id`, `role_id`, `avatar`, `name`, `email`, `phone`, `password`, `password_recovery_code`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, NULL, 1, 'users/default.png', 'Administrator', 'admin@cube-messenger.com', '254700000000', '$2y$10$P2bYd00H2xLb3uALXH7h3OiKK1JktLDtYOAsm1uyyBG4fzF/yrSOW', NULL, 'Ak8CUJgxS9dWcgiSKhcXfc7m1LgAcqAWpjLa9z35HumvnRnDEYchyCMfwwCi', '2018-06-07 07:05:26', '2018-06-07 07:05:26', NULL),
(2, NULL, NULL, 2, 'users/default.png', 'Operations', 'operations@cube-messenger.com', '254700000001', '$2y$10$lAOgHGQ3swJoxUQa8FNI/.ZePDCwv2GohpSuahLiZw4fR/HI44VJq', NULL, 'NgRh1iuiMIifUAMmKgNpcpXqXP5IfO1j676nmLpEJbgZ7PfjTugCwE6xIREp', '2018-06-07 07:05:26', '2018-06-07 07:05:26', NULL),
(3, 1, NULL, 4, 'users/default.png', 'Test Admin', 'testadmin@cube-messenger.com', NULL, '$2y$10$xq7.VktMcdpDOFNGXXpVtejkgBaXe/cWBNYnhx5wVNFo8E0IH.f5.', NULL, 'Csb33DjMRNpA0MoJF7OwpFlE5hXeSTZ7RQHyfes8EeARXb7pJKlqPWVzFeRW', '2018-06-07 07:05:26', '2018-06-07 07:05:26', NULL),
(4, NULL, NULL, 3, 'users/default.png', 'Test Supplier', 'testsupplier@cube-messenger.com', NULL, '$2y$10$OlHWdKz8iXv2gYBV3lhu0upSDyw5KH0UybtICgkORyh0wrWMOZaly', NULL, 'Ak4fw5ckr2kSgTz08z8F01goWxa6NFixTluqyQ0REDvdzLS80iEgFQsTYkg2', '2018-06-07 07:05:27', '2018-06-07 07:05:27', NULL),
(5, 1, NULL, 5, 'users/default.png', 'Test Purchasing Head', 'testpurchasinghead@cube-messenger.com', NULL, '$2y$10$uPQQcJcjlzeXYNxHmf0oF.IAw/.L7eVICxGPm8uFc35GcfWF7BlIu', NULL, 'S5jfqsK1ebZvnBTrwE1xRshwpaof8kQfaZf4QdyznGM2E4Qafzif70bXaqHc', '2018-06-07 07:05:27', '2018-06-07 07:05:27', NULL),
(6, 1, 1, 6, 'users/default.png', 'Test Department Head', 'testdepartmenthead@cube-messenger.com', NULL, '$2y$10$R7DafhSV5cNUQiO79oXs0.67MR.1JmJrJdyjpeouvyeY3lrQJmaau', NULL, 'ZOMBq8lrLsehgVoAnbsnjTmkwF114X8lZt0gpmnaQXX9VAbmuAawKhmCHAdE', '2018-06-07 07:05:27', '2018-06-07 07:05:27', NULL),
(7, 1, 1, 7, 'users/default.png', 'Test Department User', 'testdepartmentuser@cube-messenger.com', NULL, '$2y$10$2DrBuedwhBu9AA0sjDuR/uT6KzsJSZhia8xcGPnPYnwm.KWBNy2vS', NULL, 'enhYYwZjNDL9xv3J0438vpVAHRL5y5uPQnjtaTjUgCULsJlxL7AN0OMU1m8l', '2018-06-07 07:05:27', '2018-06-07 07:05:27', NULL),
(8, NULL, NULL, 8, 'users/default.png', 'Test Rider ', 'testrider@cube-messenger.com', '+1-713-609-2430', '$2y$10$KOn.qsXV4YS/evzUNFGx2urA.S2suKlHncx1/xsa8llfca118iBp.', NULL, 'm25ontY1WWE23c0g81oZ54vQeqcYgUClWIJoQBXxtdWrTCnFqNXThxaucSeN', '2018-06-07 07:05:28', '2018-06-07 07:05:28', NULL),
(9, NULL, NULL, 8, 'users/default.png', 'Test Rider 1', 'testrider1@cube-messenger.com', '(268) 414-0293', '$2y$10$74Jau0bZ1c/f5ctwhVKoTO7QJKDWgEgBqooxjeRg2IciBZz/rggce', NULL, '6ka5mBoLVEaTQtXMsF8wUpz9qW30btIg4LQcdqbVY4dk3NZC9PQrMO9tdZtt', '2018-06-07 07:05:29', '2018-06-07 07:05:29', NULL),
(10, NULL, NULL, 8, 'users/default.png', 'Test Rider 2', 'testrider2@cube-messenger.com', '(581) 239-8339', '$2y$10$/sj9DLOMlIcayGcFfk./GeYr/LN7jpfHhW9Noks0iehoa1L6Wubsa', NULL, 'oHQlSpTNMxKwnOiZnMWgzpitwdwy9OetcbP8JoOFs69EvxrgwdIVewrdiSCR', '2018-06-07 07:05:29', '2018-06-07 07:05:29', NULL),
(11, NULL, NULL, 8, 'users/default.png', 'Test Rider 3', 'testrider3@cube-messenger.com', '261-502-3046', '$2y$10$oXebfUr76PsJrsiZK5YFtusuqhdN3jEJjEzhR6iOASJTEtdCSYOqu', NULL, 'xbuOhZYA2CpSYjb3IDsVhX5rVTonfpqHmRtrqVR7XOggJNppQNijM1FdwOc7', '2018-06-07 07:05:29', '2018-06-07 07:05:29', NULL),
(12, NULL, NULL, 8, 'users/default.png', 'Test Rider 4', 'testrider4@cube-messenger.com', '+1-326-943-6684', '$2y$10$kSFOKobfmxkEmi5lYODUd.SMGZGAhbsXNg8XkOCYwVl49F43NgcvG', NULL, 'AJQ8b4hAyyxdHLAc0kotT2C1mCBZU7woWWG2ptHPaTA4j5vBFsPwXZdD1BZb', '2018-06-07 07:05:29', '2018-06-07 07:05:29', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
