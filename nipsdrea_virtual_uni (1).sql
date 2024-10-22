-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2024 at 04:20 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nipsdrea_virtual_uni`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_discussion_boards`
--

CREATE TABLE `tbl_discussion_boards` (
  `board_id` bigint(20) UNSIGNED NOT NULL,
  `board_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_discussion_boards`
--

INSERT INTO `tbl_discussion_boards` (`board_id`, `board_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'General Discussion', 'Talk about anything and everything here!', '2024-09-22 14:30:37', '2024-09-22 14:30:37'),
(2, 'Homework Help', 'Get help with your assignments and projects.', '2024-09-22 14:30:37', '2024-09-22 14:30:37'),
(3, 'Project Collaboration', 'Find team members for your group projects.', '2024-09-22 14:30:37', '2024-09-22 14:30:37'),
(4, 'Event Announcements', 'Stay updated on upcoming events and activities.', '2024-09-22 14:30:37', '2024-09-22 14:30:37');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_events`
--

CREATE TABLE `tbl_events` (
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `event_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_events`
--

INSERT INTO `tbl_events` (`event_id`, `event_name`, `description`, `start_time`, `end_time`, `location`, `created_at`, `updated_at`) VALUES
(1, 'Tech Conference 2024', 'Join us for a day of tech talks and networking.', '2024-10-15 04:00:00', '2024-10-15 12:00:00', 'Auditorium A', '2024-09-21 17:56:18', '2024-09-21 17:56:18'),
(2, 'Art Exhibition', 'Explore contemporary art by local artists.', '2024-11-01 05:00:00', '2024-11-01 13:00:00', 'Gallery Room 2', '2024-09-21 17:56:18', '2024-09-21 17:56:18'),
(3, 'Career Fair', 'Meet potential employers and explore job opportunities.', '2024-11-10 06:00:00', '2024-11-10 11:00:00', 'Main Hall', '2024-09-21 17:56:18', '2024-09-21 17:56:18'),
(4, 'Music Festival', 'Enjoy performances from various bands and artists.', '2024-12-05 09:00:00', '2024-12-05 17:00:00', 'Central Park', '2024-09-21 17:56:18', '2024-09-21 17:56:18'),
(5, 'Coding Bootcamp', 'A weekend workshop on the latest programming languages.', '2024-12-12 04:00:00', '2024-12-13 12:00:00', 'Computer Lab 3', '2024-09-21 17:56:18', '2024-09-21 17:56:18'),
(6, 'something', 'somethingsomethingsomethingsomethingsomething', '2024-09-20 19:06:00', '2024-09-29 19:06:00', 'somethingsomethingsomethingsomethingsomethingsomethingsomethingsomethingsomethingsomething', '2024-09-23 19:06:40', '2024-09-23 19:06:40'),
(7, 'something', 'sdfsdfsdfsdf', '2024-10-04 23:47:00', '2024-09-29 23:47:00', 'somethingsomethingsomethingsomethingsomethingsomethingsomethingsomethingsomethingsomething', '2024-09-23 23:48:05', '2024-09-23 23:48:05');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_feedback`
--

CREATE TABLE `tbl_feedback` (
  `feedback_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `feedback_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_information_kiosks`
--

CREATE TABLE `tbl_information_kiosks` (
  `kiosk_id` bigint(20) UNSIGNED NOT NULL,
  `location_name` varchar(100) NOT NULL,
  `content` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_posts`
--

CREATE TABLE `tbl_posts` (
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `board_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_posts`
--

INSERT INTO `tbl_posts` (`post_id`, `board_id`, `user_id`, `content`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'This is a post by user 1 on board 1.', '2024-09-23 17:09:25', '2024-09-23 17:09:25'),
(2, 2, 8, 'This is a post by user 8 on board 2.', '2024-09-23 17:09:25', '2024-09-23 17:09:25'),
(3, 1, 9, 'This is a post by user 9 on board 1.', '2024-09-23 17:09:25', '2024-09-23 17:09:25'),
(4, 3, 20, 'This is a post by user 20 on board 3.', '2024-09-23 17:09:25', '2024-09-23 17:09:25'),
(5, 1, 1, 'Another post by user 1 on board 1.', '2024-09-23 17:09:25', '2024-09-23 17:09:25'),
(6, 2, 9, 'User 9 making a post on board 2.', '2024-09-23 17:09:25', '2024-09-23 17:09:25'),
(7, 4, 8, 'User 8 posting on board 4', '2024-09-23 17:09:25', '2024-09-23 18:08:46'),
(8, 1, 20, 'User 20 sharing thoughts on board 1.', '2024-09-23 17:09:25', '2024-09-23 17:09:25'),
(9, 1, 1, 'sdfsdf', '2024-09-23 18:51:58', '2024-09-23 18:51:58'),
(10, 1, 1, 'blablobli', '2024-09-23 23:50:13', '2024-09-23 23:50:13'),
(11, 1, 1, 'just testing some special characters !@#$%^&', '2024-09-24 13:35:01', '2024-09-24 13:35:01'),
(12, 1, 1, 'just testing some special characters !@#$%^&', '2024-09-24 13:35:04', '2024-09-24 13:35:04'),
(13, 1, 1, 'testing numbers 123456789', '2024-09-24 13:36:34', '2024-09-24 13:36:34'),
(14, 1, 1, 'testing !@#$%^&*(()_+    !@#!@!@ !@ aaaa <php echo \"testing\"?>', '2024-09-24 13:40:06', '2024-09-24 13:40:06');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `token` varchar(5) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `username`, `password_hash`, `email`, `first_name`, `last_name`, `role`, `profile_picture`, `bio`, `token`, `created_at`, `updated_at`) VALUES
(1, 'testuser', '$2y$10$eSNeh9WxEFK.E9gRUVyDEOR.ETB1dlXHH8SdkHitHoD5GmORvi2mi', 'testuser@example.com', 'First', 'Last', 'student', './profile/1727135475_go.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse sagittis volutpat neque. Vestibulum finibus id elit ac luctus. Donec accumsan risus ut metus egestas, feugiat pellentesque elit feugiat. Vestibulum egestas eget nulla eu mollis. Quisque maximus augue ornare risus dignissim elementum. Vivamus egestas quis metus vitae sagittis. Donec et ornare purus, quis scelerisque nibh. Vestibulum id finibus turpis. Donec ullamcorper porta imperdiet. Vestibulum scelerisque fringi', '37390', '2024-09-11 02:44:46', '2024-09-24 13:29:43'),
(8, 'asd', '$2y$10$uFUfVsPYrAxSvDLW.xk83uxBpiL0NsTADdxrP0MjEJTZ56rzivM5C', 'testuser1@example.com', 'asd', 'asd', 'teacher', './profile/1727010884_Zero Two Chibi Sticker by cherrygloss.jpg', NULL, '33880', '2024-09-17 12:06:56', '2024-09-23 17:22:41'),
(9, 'test', '$2y$10$749CNo5nvHZEKbC/6ilVb.i9yqXOtuiKuGIONeOmEb0wufbmza9ZO', 'testuser123@example.com', 'testuser', 'testuser', 'student', './profile/1727010884_Zero Two Chibi Sticker by cherrygloss.jpg', NULL, '76071', '2024-09-18 18:56:16', '2024-09-23 17:22:39'),
(20, 'BurningYOLO', '$2y$10$7S768dDmBOz.ctAIboIfdOlrXamwCdQCfOmKNFoM.qFZNNzqvbsnu', 'testuser1234@example.com', 'testuser', 'testuser', 'student', './profile/1727010884_Zero Two Chibi Sticker by cherrygloss.jpg', NULL, '37382', '2024-09-18 19:12:26', '2024-09-23 17:22:32'),
(25, 'updated', '$2y$10$I/q80VB2TO83kZZVoFf4M.jP8I9ExVgnm6W/nqoGiToUyB978PuJ2', 'test@test.com', 'updated1', 'updated2', 'student', './profile/1727010884_Zero Two Chibi Sticker by cherrygloss.jpg', 'something something something something something something something something something something', '51996', '2024-09-22 11:03:51', '2024-09-24 12:45:05');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_roles`
--

CREATE TABLE `tbl_user_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`permissions`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_virtual_classrooms`
--

CREATE TABLE `tbl_virtual_classrooms` (
  `classroom_id` bigint(20) UNSIGNED NOT NULL,
  `classroom_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_virtual_library`
--

CREATE TABLE `tbl_virtual_library` (
  `resource_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_virtual_library`
--

INSERT INTO `tbl_virtual_library` (`resource_id`, `title`, `author`, `type`, `file_path`, `metadata`, `created_at`, `updated_at`) VALUES
(1, 'Machine Learning Basics', 'John Doe', 'Book', './books/paper-1._1727127939.pdf', '{\"pages\": 200, \"language\": \"English\"}', '2024-09-21 19:27:10', '2024-09-24 14:15:09'),
(2, 'Advanced PHP Programming', 'Jane Smith', 'Ebook', './books/paper-1._1727127939.pdf', '{\"pages\": 350, \"language\": \"English\"}', '2024-09-21 19:27:10', '2024-09-24 14:15:14'),
(3, 'Data Structures in C++', 'Alan Turing', 'Book', './books/paper-1._1727127939.pdf', '{\"pages\": 450, \"edition\": \"2nd\"}', '2024-09-21 19:27:10', '2024-09-24 14:15:19'),
(4, 'Web Development with JavaScript', 'Grace Hopper', 'Tutorial', './books/something.pdf', '{\"level\": \"Beginner\", \"duration\": \"4 hours\"}', '2024-09-21 19:27:10', '2024-09-21 19:56:00'),
(5, 'AI in Healthcare', 'Isaac Newton', 'Research Paper', './books/something.pdf', '{\"journal\": \"AI Journal\", \"published\": \"2023\"}', '2024-09-21 19:27:10', '2024-09-24 14:15:27'),
(6, 'Blockchain for Beginners', 'Satoshi Nakamoto', 'Ebook', './books/something.pdf', '{\"pages\": 180, \"topic\": \"Cryptocurrency\"}', '2024-09-21 19:27:10', '2024-09-24 14:15:31'),
(7, 'Big Data Analysis', 'Ada Lovelace', 'Book', './books/something.pdf', '{\"pages\": 400, \"language\": \"English\"}', '2024-09-21 19:27:10', '2024-09-24 14:15:35'),
(8, 'Python for Data Science', 'Guido van Rossum', 'Ebook', './books/paper-1._1727127939.pdf', '{\"pages\": 300, \"language\": \"English\"}', '2024-09-21 19:27:10', '2024-09-24 14:15:39'),
(9, 'Introduction to Neural Networks', 'Yann LeCun', 'Research Paper', './books/paper-1._1727127939.pdf', '{\"journal\": \"Neural Networks\", \"published\": \"2022\"}', '2024-09-21 19:27:10', '2024-09-24 14:15:43'),
(10, 'Cybersecurity Fundamentals', 'Kevin Mitnick', 'Tutorial', './books/paper-1._1727127939.pdf', '{\"level\": \"Intermediate\", \"duration\": \"6 hours\"}', '2024-09-21 19:27:10', '2024-09-24 14:15:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_discussion_boards`
--
ALTER TABLE `tbl_discussion_boards`
  ADD PRIMARY KEY (`board_id`),
  ADD UNIQUE KEY `board_id` (`board_id`);

--
-- Indexes for table `tbl_events`
--
ALTER TABLE `tbl_events`
  ADD PRIMARY KEY (`event_id`),
  ADD UNIQUE KEY `event_id` (`event_id`);

--
-- Indexes for table `tbl_feedback`
--
ALTER TABLE `tbl_feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD UNIQUE KEY `feedback_id` (`feedback_id`);

--
-- Indexes for table `tbl_information_kiosks`
--
ALTER TABLE `tbl_information_kiosks`
  ADD PRIMARY KEY (`kiosk_id`),
  ADD UNIQUE KEY `kiosk_id` (`kiosk_id`);

--
-- Indexes for table `tbl_posts`
--
ALTER TABLE `tbl_posts`
  ADD PRIMARY KEY (`post_id`),
  ADD UNIQUE KEY `post_id` (`post_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tbl_user_roles`
--
ALTER TABLE `tbl_user_roles`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `role_id` (`role_id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `tbl_virtual_classrooms`
--
ALTER TABLE `tbl_virtual_classrooms`
  ADD PRIMARY KEY (`classroom_id`),
  ADD UNIQUE KEY `classroom_id` (`classroom_id`);

--
-- Indexes for table `tbl_virtual_library`
--
ALTER TABLE `tbl_virtual_library`
  ADD PRIMARY KEY (`resource_id`),
  ADD UNIQUE KEY `resource_id` (`resource_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_discussion_boards`
--
ALTER TABLE `tbl_discussion_boards`
  MODIFY `board_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_events`
--
ALTER TABLE `tbl_events`
  MODIFY `event_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_feedback`
--
ALTER TABLE `tbl_feedback`
  MODIFY `feedback_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_information_kiosks`
--
ALTER TABLE `tbl_information_kiosks`
  MODIFY `kiosk_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_posts`
--
ALTER TABLE `tbl_posts`
  MODIFY `post_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tbl_user_roles`
--
ALTER TABLE `tbl_user_roles`
  MODIFY `role_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_virtual_classrooms`
--
ALTER TABLE `tbl_virtual_classrooms`
  MODIFY `classroom_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_virtual_library`
--
ALTER TABLE `tbl_virtual_library`
  MODIFY `resource_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
