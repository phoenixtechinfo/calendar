-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: db771819916.hosting-data.io
-- Generation Time: Oct 26, 2019 at 01:38 PM
-- Server version: 5.5.60-0+deb7u1-log
-- PHP Version: 7.0.33-0+deb9u5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db771819916`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth`
--

CREATE TABLE `auth` (
  `id` int(11) NOT NULL,
  `auth` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `auth`
--

INSERT INTO `auth` (`id`, `auth`) VALUES
(1, '$2y$10$N3ekcIR6ltR/Bqk/4UBrG.Y9WywjvCXtyBdwNuFC6irM9crdMuaM2');

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `id` int(11) NOT NULL,
  `page_slug` varchar(200) NOT NULL,
  `page_title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `page_slug`, `page_title`, `content`, `created_at`, `updated_at`) VALUES
(1, 'term-condition', 'Terms And Conditions', '<p>term and condition content......</p>', '2019-09-10 09:15:42', '2019-10-02 10:42:24'),
(2, 'privacy-policy', 'Privacy Policy', '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', '2019-09-10 09:16:05', '2019-09-14 10:10:19');

-- --------------------------------------------------------

--
-- Table structure for table `device_token`
--

CREATE TABLE `device_token` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `device_type` varchar(100) NOT NULL,
  `device_token` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `device_token`
--

INSERT INTO `device_token` (`id`, `user_id`, `device_type`, `device_token`, `created_at`, `updated_at`) VALUES
(1, 3, 'android', 'BZWDlRbkROa1gyQXVuMlhxTjdsSXpTNkhMNXVoRUJVNmk4SG9YTE83VzU5aE84bjB2OUR', '2019-09-14 06:35:45', '2019-09-14 10:35:45'),
(7, 8, 'ios', '8d2942a9973a68b40e4203c3f124ae6ef23c7d8543c18c455efce2a82616d9ca', '2019-09-21 08:46:01', '2019-10-02 10:30:38'),
(11, 4, 'ios', '8753bf35c0ff689f51fe8902a208535c39c9bc74ab0fa22a780478888cd51f77', '2019-09-26 11:08:17', '2019-09-30 13:51:54'),
(12, 5, 'Android', 'fWYanC2wuoo:APA91bEa-4_0gxUlf-K5oNYNcV5BOCpYiApQbOVh7C2E9_gxugSsDEBPuVmt_kcXS15k6nMpoG4rimwiH6PKciavSz-KUHA1FuFWSx3ASdCliHwgJ7PzQGoATRdrBPx1rjFJ_GaBkLa2', '2019-10-01 14:47:36', '2019-10-01 18:47:36'),
(15, 9, 'ios', '999f5c1a3958b00d39c6f45e5e61989d3d4826685e79af4de05ba0554b7a2354', '2019-10-02 06:19:06', '2019-10-25 19:07:46'),
(29, 7, 'ios', 'c2bd0fbc8fd2fc0635b8712f4990f6d31bd63b0af60d86262d40343682def2f0', '2019-10-02 12:36:50', '2019-10-02 16:49:15'),
(30, 7, 'ios', 'aa0b239844c376d10b638de6e9e7722b7190527805edcc969d45505375a201f2', '2019-10-02 13:17:13', '2019-10-02 18:30:08'),
(34, 12, 'ios', 'ce6b38fc78795a1a92512df8fef340012e21d5251cd2e5dac53fd424b443de42', '2019-10-03 10:40:24', '2019-10-03 14:40:24'),
(37, 13, 'Android', 'cZa8kCpMxv4:APA91bEHKUI0vh-aqDCeEv4ypO-8HyKMYXuybcx9IOWj-w5siQx_8BhN6nwxTN4V8fNuCI8X0e23vwND0SW3lxiVuBLmYawgAt14-8BRNlJx43luWNJzcJkq_aapbBVx2mhJXcECho2D', '2019-10-10 09:13:56', '2019-10-10 13:13:56'),
(38, 7, 'ios', '0cd9e91d8527661558383fca2c4e362021ae8e0812ab2f1e175c121e32389222', '2019-10-10 12:06:52', '2019-10-10 17:12:32'),
(42, 4, 'ios', 'c9938c9b779809a21f1dd08cab154141cc006f9ee3293d432e200171048bc656', '2019-10-11 06:51:48', '2019-10-11 11:27:16'),
(43, 4, 'ios', '542c0a3f4eed5080435d4de93231b2c7fc43280b6bc84e067d2973dbbae89ee7', '2019-10-11 07:32:58', '2019-10-11 11:52:46'),
(46, 4, 'ios', 'a5832e40f543f7eccbe8fbc771f446c18ed959840649e3799a3fe7b0d3bc0417', '2019-10-11 09:43:36', '2019-10-11 17:09:10'),
(47, 8, 'ios', '4ce2010716a5deaea98958e5d480fcd00e7c1b29cad67ab811977d1efaaad8bd', '2019-10-12 10:09:47', '2019-10-19 14:35:00'),
(48, 7, 'ios', '1077909b9990c24a0d2ddc48d6ec4dbaf9fc78b7a87f86ddd9a0ca5fe9bd727a', '2019-10-15 05:10:01', '2019-10-15 09:13:17'),
(49, 7, 'ios', '6388d34ff73f9fd77443a8dc66fd53bf72090961177b45fdfacf523fcee27607', '2019-10-15 05:31:42', '2019-10-15 10:00:29'),
(50, 7, 'ios', 'a0d9c3729ad16c671823d13c3fc479667ad0169d358169aabfa0822f7cbd0cdb', '2019-10-15 06:55:25', '2019-10-15 10:55:25'),
(51, 7, 'ios', 'a1b8cba8a93c91e9e8847973e383a3d0ded527c9018edd6cfcf9a1317f4de633', '2019-10-15 07:02:24', '2019-10-15 11:02:24'),
(52, 7, 'ios', '2ca8004a6e020cccbf708a5f960b47897d6536c7dd21520fd2886d0f0e72b573', '2019-10-15 07:19:00', '2019-10-15 11:57:41'),
(53, 7, 'ios', '6c203250660bca26f1ce247b9d8feaeb0060300217fccb6491e2d5faeb76bc2a', '2019-10-15 08:59:58', '2019-10-15 13:09:15'),
(55, 4, 'ios', '0e02e88001cb3bce28fa783110f2a33d796339e8f5053af0353781afd9d5867b', '2019-10-15 10:11:19', '2019-10-16 13:13:17'),
(56, 7, 'ios', '619375f93328e2adcb4c7088a40c5884fd9efb60aa1ff5d1fbd5ad7626ba410d', '2019-10-16 09:42:59', '2019-10-17 16:40:53'),
(57, 7, 'ios', '1d808d2f6ad149d10bb70fd793b71bde763e65b02cd2cf1ee425e24f3c53f239', '2019-10-17 13:26:45', '2019-10-18 13:46:02'),
(58, 7, 'ios', '1a14d0183b1f27c59c6880a0ca5f740abe73b818c99c6da3eeb2791fabaf79a7', '2019-10-18 09:49:40', '2019-10-18 15:23:08'),
(61, 7, 'ios', '846b5c822c471d77c59768fd658ac04dc92e41e2741d591ae8fc54803fe5e00b', '2019-10-18 13:31:28', '2019-10-18 17:33:43'),
(62, 4, 'ios', '5e4c51bd45160f358ec46c0cf1ffc549950238ec145e1d7e35caeddd20d3cefe', '2019-10-19 10:37:01', '2019-10-21 10:33:12'),
(63, 4, 'ios', '928dd2dc86d95cc884caa5b273886f7021a71369e9d417049f144d571f795726', '2019-10-21 06:46:33', '2019-10-21 13:37:42'),
(64, 10, 'ios', 'd5cd36c9640f3abd7a295b69fabe886b375dc62789d7b89701833eddc93646ec', '2019-10-21 14:03:10', '2019-10-26 16:13:04'),
(65, 7, 'ios', 'c6d6d847a000492e380e6b1ba9cc306ea931e0d07522f0b6043f963072c0b379', '2019-10-24 11:01:55', '2019-10-24 15:09:36'),
(66, 7, 'ios', 'a5029a35b374c98cb6be8fb36cc82adccbd96678985e53652bc036544a5f6c9c', '2019-10-24 13:05:16', '2019-10-25 15:32:29'),
(68, 4, 'ios', '965560cadb4a816b61665bca4d28d1b9285626b3583f8167114c3bc2a9c54f7c', '2019-10-25 11:20:41', '2019-10-25 16:01:29'),
(69, 5, 'ios', '1ea517a98b06c30c3d7e216dfc486de94d0e857ef5dc6d7a04e8ad552fe372e9', '2019-10-25 11:41:16', '2019-10-25 16:05:28'),
(71, 8, 'ios', '4e0883c5114cf601ee687a1712fdf10f838d2e8e01fe1c0ecf081325fcc9d360', '2019-10-25 12:52:04', '2019-10-25 18:12:52');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` bigint(20) NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `sender_id`, `receiver_id`, `created_at`, `updated_at`) VALUES
(1, 5, 4, '2019-10-01 14:47:45', '2019-10-01 18:47:45'),
(2, 5, 9, '2019-10-01 14:54:51', '2019-10-01 18:54:51'),
(3, 9, 4, '2019-10-01 15:18:39', '2019-10-01 19:18:39'),
(4, 9, 7, '2019-10-01 15:23:18', '2019-10-01 19:23:18'),
(5, 8, 4, '2019-10-01 15:37:30', '2019-10-01 19:37:30'),
(6, 8, 7, '2019-10-01 15:38:07', '2019-10-01 19:38:07'),
(7, 7, 4, '2019-10-02 05:10:47', '2019-10-02 09:10:47'),
(8, 7, 5, '2019-10-02 05:22:55', '2019-10-02 09:22:55'),
(9, 8, 9, '2019-10-02 06:25:28', '2019-10-02 10:25:28'),
(10, 8, 5, '2019-10-02 06:26:08', '2019-10-02 10:26:08'),
(11, 12, 4, '2019-10-02 07:00:00', '2019-10-02 11:00:00'),
(12, 12, 5, '2019-10-02 07:00:12', '2019-10-02 11:00:12'),
(13, 12, 7, '2019-10-02 14:09:08', '2019-10-02 18:09:08'),
(14, 12, 8, '2019-10-03 05:45:07', '2019-10-03 09:45:07'),
(15, 4, 11, '2019-10-03 05:54:29', '2019-10-03 09:54:29'),
(16, 10, 9, '2019-10-03 13:46:39', '2019-10-03 17:46:39'),
(17, 13, 7, '2019-10-10 09:23:19', '2019-10-10 13:23:19'),
(18, 13, 8, '2019-10-10 10:42:05', '2019-10-10 14:42:05'),
(19, 13, 5, '2019-10-10 11:12:19', '2019-10-10 15:12:19'),
(20, 13, 4, '2019-10-10 11:12:36', '2019-10-10 15:12:36'),
(21, 13, 12, '2019-10-10 15:15:26', '2019-10-10 19:15:26'),
(22, 13, 9, '2019-10-11 07:53:57', '2019-10-11 11:53:57'),
(23, 14, 4, '2019-10-11 10:24:40', '2019-10-11 14:24:40'),
(24, 13, 14, '2019-10-11 10:40:14', '2019-10-11 14:40:14'),
(25, 7, 14, '2019-10-18 12:29:30', '2019-10-18 16:29:30'),
(28, 10, 4, '2019-10-25 06:53:37', '2019-10-25 10:53:37'),
(29, 10, 8, '2019-10-25 06:54:02', '2019-10-25 10:54:02'),
(30, 10, 5, '2019-10-25 12:43:07', '2019-10-25 16:43:07'),
(31, 8, 14, '2019-10-25 13:02:09', '2019-10-25 17:02:09'),
(32, 9, 12, '2019-10-25 14:34:45', '2019-10-25 18:34:45');

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
(1, '2014_10_12_000000_create_users_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '	1= email 2= push	',
  `page_slug` varchar(100) NOT NULL,
  `page` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `type`, `page_slug`, `page`, `content`, `created_at`, `updated_at`) VALUES
(1, 1, 'new_user', 'New User', '<h1>Hi [name]</h1>\r\n<p>Finish setting up your account as we need to verify that you have access to the email address used to create the account. Use the verification code listed below to complete the sign-up process.</p>\r\n<p>You&#39;re verification code is: [otp]</p>\r\n<p>Our support team is available.</p>\r\n<p>if you have any issues, <a href=\"#\">Contact Us</a>.</p>', '2019-08-30 08:42:55', '0000-00-00 00:00:00'),
(2, 1, 'forgot_password', 'forgot password', '<h1>Hi [name]</h1>\r\n<p>You\'re verification code is: [otp]</p>\r\n<p>Verify above code and than change you new password.</p>', '2019-08-30 10:23:10', '0000-00-00 00:00:00'),
(3, 1, 'contact_support', 'Contact Support', '<h2>Hi Support Team</h2>\r\n<p>[name] have some query.</p>\r\n<p>message : [message]<p>', '2019-09-20 06:00:33', '0000-00-00 00:00:00');

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
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(11) NOT NULL,
  `code_key` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `value` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `code_key`, `value`, `created_at`) VALUES
(1, 'distance_location', '5000', '2019-10-02 18:07:37'),
(2, 'user_search_location', '5', '2019-10-02 18:07:37'),
(3, 'support_email', 'support.sheers@mailinator.com', '2019-10-02 18:07:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` int(11) NOT NULL DEFAULT '1' COMMENT '1= user, 2= admin',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `gender` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `dob` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `profile_pic` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `otp` int(100) DEFAULT '0',
  `forgot_password` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `fb_login` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `login_with` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'App',
  `location` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `lat` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `lng` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `status` int(2) NOT NULL DEFAULT '0',
  `profile_status` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `notification` int(2) NOT NULL DEFAULT '1',
  `availability` int(2) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verified_at` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `email`, `email_verified_at`, `password`, `gender`, `dob`, `profile_pic`, `otp`, `forgot_password`, `fb_login`, `login_with`, `location`, `lat`, `lng`, `status`, `profile_status`, `notification`, `availability`, `remember_token`, `verified_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'admin', 'sheers@admin.com', '2019-08-29 11:00:56', '$2y$10$jfeee3CYlpnmtt9D4yTXI.zfkAodSplVDDmtEr2yGVQBLxXyVcSWK', '', '0000-00-00 00:00:00', '', 0, '', '', 'App', '', '', '', 0, '', 1, 1, NULL, '', '2019-08-29 05:25:58', '2019-08-29 05:25:58'),
(2, 1, 'manish', 'manish@mailinator.com', NULL, '$2y$10$23By.OGRQRIH8kjYWmPjMOetWKTEurlvwMfhzlM3xs8IzmRiMkexq', 'male', '2019-08-10', '', 7314, '', '', 'App', 'hilton', '51.1301196', '4.9329317', 0, '', 1, 1, 'dTVORHZnZm1NNFlVdzVZc2J3Z1FoekpFSXo1R3ljenY2Ynk0RWhkQjJOb2RZTnEwN2JaMmNwTkdGUFdS5d7c8a0255b07', 'email', '2019-09-14 06:34:42', '2019-09-14 10:34:42'),
(3, 1, 'manish', 'virendra.nagda@techcronus.com', NULL, '$2y$10$QKfKDNKjBrxwEmQhpzh5SOLX6k8UIyfIT/Bli5uSMc0BqokGMYTyC', 'male', '2019-08-10', '', 1613, '', '', 'App', 'hilton', '51.1301196', '4.9329317', 0, '', 1, 1, 'T0V0QkxockY0cFF5U1gzRWpkRWxXZVlzTmZJckRCanNKVFhhSVdIU05BM3NOOXJYNmxSMXBNajNON3Rt5d7c8a40ef315', 'email', '2019-09-14 06:35:45', '2019-09-14 10:35:45'),
(4, 1, 'Nishit', 'nishit.barochiya@techcronus.com', NULL, '$2y$10$Wcmal2zpK.5aXY9QuaO.ou3l5eQoTmdHoXxhdNjvKBsz.ThdKqbEi', 'Male', '28-Mar-1997', 'http://techcronus.com/staging/sheers/assets/images/user/1571649844.jpeg', 0, '2991', '', 'App', 'Brussels', '50.8503396', '4.3517103', 1, 'Be Happy', 1, 1, 'QVZ4YWdldWZZczF4U2tXN2tiWDN2ZEhPSkMzcTlubktJZ1hHaFNaWUh2TjlNaGpGUG5peFhWQ1pGWE1R5d84df260c597', 'email', '2019-09-20 14:16:06', '2019-10-25 16:51:16'),
(5, 1, 'Jainik Techcronus', 'jainik.techcronus@gmail.com', NULL, '', 'Male', '1970-01-01', 'http://techcronus.com/staging/sheers/assets/images/user/1569997940.jpeg', 0, '', '533175420782737', 'Fb', 'Porto', '41.1579438', '-8.629105299999999', 1, 'Available', 1, 1, 'V2JhTE9rMkY3NGJmZWNNWEJCdjZHWU5JYlVZbE1sOU50MHF6SEtHOUtvcFZmbTRXZ3ZhY3N4ZGZIOFFS5d84e06e53f4c', '', '2019-09-20 14:21:34', '2019-10-25 16:17:30'),
(6, 1, 'Chaitali', 'chaitali@mailinator.com', NULL, '$2y$10$NUziSv0RjxofIQR9UdTrquWlTcRi/ddPHa9hLn8jKMZqm/tMTN0vG', 'Female', '1994-09-20', '', 1676, '', '', 'App', '', '', '', 0, '', 1, 1, 'b1djWnZoWkgzZXVQNEVyM2hZcjdyZlE5Z2E2YWlLZW9VcTRZQWZUUHRsRjlYc1NmWE1VUTh1NnBDUjZF5d84e417650b0', 'email', '2019-09-20 14:37:11', '2019-09-20 18:37:11'),
(7, 1, 'Chaitali', 'chaitali.lad@techcronus.com', NULL, '$2y$10$OgqssNvl5EzNd3I5EqpMVOPasvX51KWX7C9ahBmer0WVwQ9RTj5Xu', 'Female', '1995-04-27', 'http://techcronus.com/staging/sheers/assets/images/user/1571985497.jpeg', 0, '', '', 'App', 'Russia', '61.52401', '105.318756', 1, 'Developer', 1, 1, 'MTVHNnhDRXRiYk9HeHpvcEFIakpUa0hmaTI3bG5DSnZFY1JPbmpZbnh3TXhYczNKS2JYNTljdjB6QjR35d84e44b3189b', 'email', '2019-09-20 14:38:03', '2019-10-25 17:10:41'),
(8, 1, 'Ketul Sheth', 'ketul.sheth85@yahoo.com', NULL, '', 'Male', '1970-01-01', 'http://techcronus.com/staging/sheers/assets/images/user/1572012497.jpeg', 0, '', '10214414554373447', 'Fb', 'Vrije Universiteit Brussel', '50.821658', '4.394886', 1, 'happy', 0, 1, 'YUJaOWYyY3RNU3JmRFRTR0FEMWNkbWJPREcweWprbW5YRWpMTzd5VFFDM1ZnZksxakhLUlQ3WGRGcXMz5d84fa8b54ae2', '', '2019-09-20 16:12:59', '2019-10-25 18:23:34'),
(9, 1, 'parth', 'parth.parikh@techcronus.com', NULL, '$2y$10$W0oTqt/2FnFAlsDDXjBnTubzZLFxBgn6Ko533iUK0d68VISpJ.ifK', 'Male', '1991-04-06', 'http://techcronus.com/staging/sheers/assets/images/user/1570069977.jpeg', 0, '', '', 'App', 'Maa Anandmiya Marg, India', '23.013485061288062', '72.52148024896569', 1, 'Time to have fun!!!!', 1, 1, 'SEttNUV0NlNwSVB5Z0wzNFBKak9qQTZRVFVIYVgxSmJ0a3VVTHYzbTFqVGc2YldkZWpEOUs1N0pFQjRY5d85b6ed549e1', 'email', '2019-09-21 05:36:45', '2019-10-10 21:57:09'),
(10, 1, 'David', 'haeckdavid.marc@hotmail.fr', NULL, '$2y$10$fdkcXc/owqSA2Zqy20NW9.DGbMwrOmUhzb6QP5aGkQ4rj3cc42dum', 'Male', '1992-10-03', 'http://techcronus.com/staging/sheers/assets/images/user/1572022068.jpeg', 0, '5814', '', 'App', 'Rue d\'Idalie', '50.8370424', '4.3714395', 1, 'HDM', 1, 1, 'blZJcWJUek5SWXJEMmNCUGFRREpQN1BpbFB6UXpWZGpFa1BhZjVVWXUxOExPekZVU0pPNVNuelBrc3hy5d8884a7a9ff3', 'email', '2019-09-23 08:39:03', '2019-10-25 22:56:18'),
(11, 1, 'Max Koning', 'belgiquemaxkoning@gmail.com', NULL, '', '', '', NULL, 0, '', '975626569450518', 'Fb', '', '', '', 1, '', 1, 1, 'UWNEUmRaejJIYTBnTnNyV3BoSDdubjUxRjU1S284ZFlMODRRU1lvNjUyWnRMUTRXYm8wRkhuM01PaE9r5d8b1e4b449bf', '', '2019-09-25 07:59:07', '2019-09-25 11:59:07'),
(12, 1, 'Dhaval Sakhiya', 'dhaval.sakhiya@techcronus.com', NULL, '$2y$10$HdFgvXdkdu7xSZiRqj8xrezM1lAWKzfvPIuPQE.GaJ4emm5NJtGjm', 'Male', '1996-03-15', 'http://techcronus.com/staging/sheers/assets/images/user/1570002783.jpeg', 0, '', '', 'App', 'Gulbai Tekra Road, India', '23.02283828370877', '72.55549290264948', 1, NULL, 0, 1, 'N1pidlJsUnRTY04yY3B3SkR4eE91M1hhNDdVSzAzVjNlaUtscmhoZUJ0dzV3dzU3NDJZTWpiYzdmNWFh5d944a2c17b9e', 'email', '2019-10-02 06:56:44', '2019-10-11 13:22:28'),
(13, 1, 'MohammadAli', 'mohammadali.kadiwala@techcronus.com', NULL, '$2y$10$aJxWGTQgKrvW1kfEDNYvC.IclzX3hlaCcAvX4ldb90rLSlEMIpKGy', 'Male', '1994-05-15', 'https://techcronus.com/staging/sheers/assets/images/user/1570716018.png', 0, '', '', 'App', 'Center Point, Panchavati Society, Gulbai Tekra, Ahmedabad, Gujarat 380009, India', '23.0227507', '72.5555127', 1, 'Joker', 1, 1, 'T2hlVHJWdHBhRUtEYmZ1cFJSdXJMVjZlejM4NFVoSzkzUGt6UGVIQ2FHSExXSHVJVGZocGcwdmM5S1pY5d9ef65458008', 'email', '2019-10-10 09:13:56', '2019-10-25 18:10:25'),
(14, 1, 'sazzadhusen iproliya', 'sazzad.iproliya@techcronus.com', NULL, '$2y$10$VE5/0pL3QXFikf5mnBPLbegZ87fScATPQXBQMY8mndoAudhZnmPGi', 'Male', '1991-05-25', '', 0, '', '', 'App', 'Center Point, Panchavati Society, Gulbai Tekra, Ahmedabad, Gujarat 380009, India', '23.0227641', '72.5554876', 1, '', 1, 1, 'SWhsQUxpOGdFWnJSMHpQUXRBRzJGWUM2VHdYYWZtUHkxRTlNa01zV3lrQldRN1JTUU55VDZTcE80Umtu5da055712e9fa', 'email', '2019-10-11 10:12:01', '2019-10-25 15:40:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth`
--
ALTER TABLE `auth`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `device_token`
--
ALTER TABLE `device_token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `sender user` (`sender_id`),
  ADD KEY `receiver user` (`receiver_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auth`
--
ALTER TABLE `auth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `device_token`
--
ALTER TABLE `device_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `receiver user` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sender user` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
