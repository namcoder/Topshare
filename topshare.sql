-- phpMyAdmin SQL Dump
-- version 4.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Aug 08, 2015 at 08:40 AM
-- Server version: 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `topshare`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(10) unsigned NOT NULL,
  `customer_id` int(10) DEFAULT NULL,
  `customer_name` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `keyword` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `minimum_wordcount` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `blog_categories` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `img_link` text COLLATE utf8_unicode_ci,
  `max_blogger` bigint(20) DEFAULT NULL,
  `lang_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(1) DEFAULT '1',
  `release_date` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `customer_id`, `customer_name`, `name`, `description`, `keyword`, `minimum_wordcount`, `blog_categories`, `img_link`, `max_blogger`, `lang_code`, `status`, `release_date`, `created_at`, `updated_at`) VALUES
(1, 14, 'Athena.dk', NULL, NULL, 'nam xinh, nam kute', '40', '2', '[{"img":"http:\\/\\/www.riversystem.dk\\/public\\/application\\/riverupload\\/uploads\\/14\\/shutterstock_20317369.jpg","link":"http:\\/\\/www.athena.dk\\/hosting-cloud\\/","anchor_text":""}]', 2, 'DK', 1, '07/20/2015', '2015-07-20 01:50:18', '2015-07-23 00:25:02'),
(2, 137, '4D.dk', NULL, NULL, 'ok', '1800', '2', '[{"img":"http:\\/\\/www.riversystem.dk\\/public\\/application\\/riverupload\\/uploads\\/137\\/axstj-bookandpenimg_3618-1013-540.jpg","link":"http:\\/\\/www.4d.dk\\/Kurser\\/Office\\/Sharepoint","anchor_text":""}]', 2, 'DK', 1, '07/21/2015', '2015-07-21 01:28:29', '2015-07-21 01:28:29'),
(3, 137, '4D.dk', NULL, NULL, '34', '1800', '2', NULL, 2, 'DK', 1, '07/21/2015', '2015-07-21 01:54:09', '2015-07-23 00:29:28');

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` int(10) unsigned NOT NULL,
  `lang_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `lang_code`, `name`, `created_at`, `updated_at`) VALUES
(1, 'en', 'House and Garden', '2015-07-06 01:44:11', '2015-07-06 01:44:11'),
(2, 'DK', 'Hus og Have', '2015-07-06 01:45:23', '2015-07-07 02:52:49');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `code` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', '2015-05-14 21:17:56', '2015-05-14 21:17:56'),
(5, 'Danish', 'DK', '2015-05-17 19:31:52', '2015-05-17 19:31:52'),
(7, 'German', 'DE', '2015-05-18 12:27:33', '2015-05-18 12:27:33');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) unsigned NOT NULL,
  `lang_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `lang_code`, `name`, `value`, `type`, `created_at`, `updated_at`) VALUES
(1, 'en', 'word_count', '2000', 'var', '2015-07-06 00:08:06', '2015-07-06 00:08:06'),
(2, 'DK', 'word_count', '1800', 'var', '2015-07-06 00:08:13', '2015-07-06 00:08:13'),
(3, 'en', 'max_blogger', '5', 'var', '2015-07-06 00:08:36', '2015-07-06 03:06:42'),
(4, 'DK', 'max_blogger', '1', 'var', '2015-07-06 00:08:44', '2015-07-06 00:35:28'),
(5, 'en', 'minute_to_report_assignment', '30', 'var', '2015-07-06 00:09:46', '2015-07-09 00:31:58'),
(6, 'en', 'minute_to_repost_time', '1', 'var', '2015-07-14 01:26:51', '2015-07-14 01:26:51'),
(7, 'en', 'time_to_repost', '3', 'var', '2015-07-14 02:04:49', '2015-07-14 02:24:58'),
(8, 'en', 'star_value', '10', 'var', '2015-07-19 23:53:24', '2015-07-19 23:53:24'),
(10, 'DK', 'star_value', '20', 'var', '2015-07-20 00:06:29', '2015-07-20 00:06:29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `role` int(1) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zipcode` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cpr` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `forgot_string` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_number` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `remember_token`, `address`, `city`, `zipcode`, `phone`, `cpr`, `forgot_string`, `account_number`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@admin.com', '$2y$10$R0EbC.vsu5O0SpEKC5kfkeneJ0QSbQ2F91bfogSkNPRwxwDroRWCy', 1, 'lKlVBD6fv2hUgHiySbTtHkee84dILm38Xcl8SjSyCf7p6I8Dwb9eoDztYHBa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-05-07 00:30:27', '2015-07-17 03:07:57'),
(4, 'test', 'test@yopmail.com', '$2y$10$vypJ8jRF8VrP2xVdhZxhKuj2WbUJvT5LqNfMJ1Me.Vqi4ec16tMTy', 3, '6CwJbbdNGtS7CxzuFVr8svXbqj0sVlVKjbqXAu1eqcSK0rEmtQckxC8nhRNd', 'test', 'test', 'test', 'test', '59866544', NULL, '2222', '2015-07-06 01:57:18', '2015-07-20 20:14:11'),
(5, 'nam', 'nam@yopmail.com', '$2y$10$vypJ8jRF8VrP2xVdhZxhKuj2WbUJvT5LqNfMJ1Me.Vqi4ec16tMTy', 3, 'ORpkMb6LkGZKTLNZykHbHLO6jNGHpDy74reiVrNkRC3q1KKRR4Q6WCICEVSq', 'test', 'test', 'test', 'test', '345534533', NULL, '333', '2015-07-06 01:57:18', '2015-07-21 01:28:41');

-- --------------------------------------------------------

--
-- Table structure for table `user_assignments`
--

CREATE TABLE `user_assignments` (
  `id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `assignment_id` int(10) unsigned NOT NULL,
  `link` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `reason` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `message_update` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(2) unsigned NOT NULL DEFAULT '1',
  `minute_to_report_assignment` int(10) DEFAULT NULL,
  `time_to_repost` int(2) DEFAULT NULL,
  `extra_star` int(2) DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_assignments`
--

INSERT INTO `user_assignments` (`id`, `user_id`, `assignment_id`, `link`, `reason`, `message_update`, `status`, `minute_to_report_assignment`, `time_to_repost`, `extra_star`, `approved_at`, `created_at`, `updated_at`) VALUES
(1, 4, 2, 'http://i-imgs.com', '', '', 5, 30, 3, 2, '2015-07-21 09:09:49', '2015-07-21 02:09:31', '2015-08-07 04:10:19'),
(2, 4, 1, 'http://namcoder.com', '', '', 5, 30, 3, 0, '2015-07-22 09:09:49', '2015-07-21 02:19:35', '2015-08-07 00:03:27'),
(3, 5, 1, 'http://silemypham.com', '', '', 5, 30, 3, 0, '2015-07-24 09:09:49', '2015-07-23 02:19:35', '2015-08-07 00:03:27');

-- --------------------------------------------------------

--
-- Table structure for table `user_blogs`
--

CREATE TABLE `user_blogs` (
  `id` int(10) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `domain_age` varchar(50) NOT NULL,
  `domain_type` int(10) NOT NULL,
  `domain_ip` varchar(50) NOT NULL,
  `blogname` varchar(300) NOT NULL,
  `domain` varchar(200) NOT NULL,
  `blog_categories` varchar(200) NOT NULL,
  `star` int(200) NOT NULL,
  `inbound_link` bigint(20) NOT NULL,
  `lang_code` varchar(10) NOT NULL,
  `report_id` int(20) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_blogs`
--

INSERT INTO `user_blogs` (`id`, `user_id`, `domain_age`, `domain_type`, `domain_ip`, `blogname`, `domain`, `blog_categories`, `star`, `inbound_link`, `lang_code`, `report_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, '1,6', 0, '104.28.29.37', 'i-imgs.com', 'i-imgs.com', '2', 13, 726, 'en', 11281664, 2, '2015-07-06 01:57:21', '2015-07-12 19:39:14'),
(2, 5, '1,6', 0, '128.199.96.31', 'silemypham.com', 'silemypham.com', '2', 13, 726, 'DK', 11281664, 2, '2015-07-06 01:57:21', '2015-07-12 19:39:14');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Super User', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Blogger', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_assignments`
--
ALTER TABLE `user_assignments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_blogs`
--
ALTER TABLE `user_blogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_user_blogs_users` (`user_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user_assignments`
--
ALTER TABLE `user_assignments`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user_blogs`
--
ALTER TABLE `user_blogs`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
