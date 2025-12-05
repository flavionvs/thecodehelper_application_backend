-- phpMyAdmin SQL Dump
-- version 5.2.0-1.el7.remi
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 05, 2025 at 06:09 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bineto_cd`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `hours` decimal(8,2) DEFAULT 0.00,
  `rate` decimal(8,2) DEFAULT 0.00,
  `amount` decimal(8,2) DEFAULT 0.00,
  `admin_commission` decimal(8,2) NOT NULL DEFAULT 0.00,
  `admin_amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `stripe_commission` decimal(8,2) NOT NULL DEFAULT 0.00,
  `stripe_amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `stripe_fee` decimal(8,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `user_data` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_data` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Pending',
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancel_reason` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `user_id`, `project_id`, `hours`, `rate`, `amount`, `admin_commission`, `admin_amount`, `stripe_commission`, `stripe_amount`, `stripe_fee`, `total_amount`, `user_data`, `project_data`, `status`, `remark`, `cancel_reason`, `created_at`, `updated_at`, `deleted_at`, `description`) VALUES
(1, 123, 1, '5.00', '5.00', '25.00', '25.00', '6.25', '2.60', '0.65', '0.30', '32.20', '{\"first_name\":\"John\",\"email\":\"john@gmail.com\",\"phone\":\"4242424248\"}', '{\"id\":1,\"user_id\":122,\"category_id\":1,\"title\":\"Node JS Developer Required Update\",\"slug\":\"node-js-developer-required-update\",\"description\":\"Description of the project&nbsp;\",\"status\":\"Pending\",\"budget\":\"20\",\"attachment\":null,\"tags\":null,\"created_at\":\"2025-08-14T06:22:08.000000Z\",\"updated_at\":\"2025-08-14T06:22:36.000000Z\"}', 'Completed', 'Project Done', NULL, '2025-08-14 06:29:36', '2025-08-14 11:56:39', NULL, NULL),
(2, 123, 2, '4.00', '4.00', '16.00', '25.00', '4.00', '2.60', '0.42', '0.30', '20.72', '{\"first_name\":\"John\",\"email\":\"john@gmail.com\",\"phone\":\"4242424248\"}', '{\"id\":2,\"user_id\":122,\"category_id\":1,\"title\":\"PHP Developer Needed\",\"slug\":\"php-developer-needed\",\"description\":\"Description\",\"status\":null,\"budget\":\"10\",\"attachment\":null,\"tags\":\"Tag\",\"created_at\":\"2025-08-14T06:44:53.000000Z\",\"updated_at\":\"2025-08-14T06:44:53.000000Z\"}', 'Completed', 'Project Done', NULL, '2025-08-14 06:45:08', '2025-08-14 06:59:46', NULL, NULL),
(3, 123, 3, '4.00', '4.00', '16.00', '25.00', '4.00', '2.60', '0.42', '0.30', '20.72', '{\"first_name\":\"John\",\"email\":\"john@gmail.com\",\"phone\":\"4242424248\"}', '{\"id\":3,\"user_id\":122,\"category_id\":2,\"title\":\"React JS\",\"slug\":\"react-js\",\"description\":\"Description\",\"status\":null,\"budget\":\"10\",\"attachment\":null,\"tags\":\"tag\",\"created_at\":\"2025-08-14T06:49:19.000000Z\",\"updated_at\":\"2025-08-14T06:49:19.000000Z\"}', 'Completed', 'Project Done', NULL, '2025-08-14 06:50:40', '2025-08-14 06:59:05', NULL, NULL),
(4, 123, 5, '1.00', '1.00', '1.00', '25.00', '0.25', '2.60', '0.03', '0.30', '1.58', '{\"first_name\":\"John\",\"email\":\"john@gmail.com\",\"phone\":\"4242424248\"}', '{\"id\":5,\"user_id\":122,\"category_id\":1,\"title\":\"Data Engineer\",\"slug\":\"data-engineer\",\"description\":\"Hello Data Engineer,\",\"status\":null,\"budget\":\"10\",\"attachment\":null,\"tags\":\"AWs,bigdata\",\"created_at\":\"2025-08-16T04:58:31.000000Z\",\"updated_at\":\"2025-08-16T04:58:49.000000Z\"}', 'Completed', 'Project Done', NULL, '2025-08-16 04:59:34', '2025-08-16 05:04:44', NULL, NULL),
(5, 123, 6, '2.00', '2.00', '4.00', '25.00', '1.00', '2.60', '0.10', '0.30', '5.40', '{\"first_name\":\"John\",\"email\":\"john@gmail.com\",\"phone\":\"4242424248\"}', '{\"id\":6,\"user_id\":122,\"category_id\":1,\"title\":\"Data Engineer2\",\"slug\":\"data-engineer2\",\"description\":\"Test Data 2\",\"status\":null,\"budget\":\"2\",\"attachment\":null,\"tags\":\"big\",\"created_at\":\"2025-08-16T05:09:30.000000Z\",\"updated_at\":\"2025-08-16T05:09:30.000000Z\"}', 'Completed', 'Project Done', NULL, '2025-08-16 05:10:02', '2025-08-16 05:14:32', NULL, NULL),
(6, 123, 7, '1.00', '1.00', '1.00', '25.00', '0.25', '2.60', '0.03', '0.30', '1.58', '{\"first_name\":\"John\",\"email\":\"john@gmail.com\",\"phone\":\"4242424248\"}', '{\"id\":7,\"user_id\":122,\"category_id\":1,\"title\":\"tets2\",\"slug\":\"tets2\",\"description\":\"trtr\",\"status\":\"Active\",\"budget\":\"10\",\"attachment\":null,\"tags\":\"dd\",\"created_at\":\"2025-08-16T05:22:03.000000Z\",\"updated_at\":\"2025-08-16T05:22:03.000000Z\"}', 'Completion Requested', 'Project Done', NULL, '2025-08-16 05:22:21', '2025-08-16 05:23:46', NULL, NULL),
(7, 123, 8, '10.00', '2.00', '20.00', '25.00', '5.00', '2.60', '0.52', '0.30', '25.82', '{\"first_name\":\"John\",\"email\":\"john@gmail.com\",\"phone\":\"4242424248\"}', '{\"id\":8,\"user_id\":122,\"category_id\":1,\"title\":\"Data Engineer Test\",\"slug\":\"data-engineer-test\",\"description\":\"Abc\",\"status\":\"Active\",\"budget\":\"10\",\"attachment\":null,\"tags\":\"ran\",\"created_at\":\"2025-08-16T06:27:37.000000Z\",\"updated_at\":\"2025-08-16T06:27:37.000000Z\"}', 'Approved', 'Project Done', NULL, '2025-08-16 06:28:57', '2025-08-16 06:48:21', NULL, NULL),
(8, 123, 9, '10.00', '10.00', '100.00', '25.00', '25.00', '2.60', '2.60', '0.30', '127.90', '{\"first_name\":\"John\",\"email\":\"john@gmail.com\",\"phone\":\"4242424248\"}', '{\"id\":9,\"user_id\":122,\"category_id\":1,\"title\":\"Test54\",\"slug\":\"test54\",\"description\":\"dd\",\"status\":null,\"budget\":\"10\",\"attachment\":null,\"tags\":\"dd\",\"created_at\":\"2025-08-16T06:38:06.000000Z\",\"updated_at\":\"2025-08-16T06:38:06.000000Z\"}', 'Completed', 'Project Done', NULL, '2025-08-16 06:51:07', '2025-08-16 06:52:47', NULL, NULL),
(9, 102, 10, '12.00', '100.00', '1200.00', '25.00', '300.00', '2.60', '31.20', '0.30', '1531.50', '{\"first_name\":\"Freelancer\",\"email\":\"freelancer@gmail.com\",\"phone\":\"8171960474\"}', '{\"id\":10,\"user_id\":107,\"category_id\":1,\"title\":\"Ecommerce Website\",\"slug\":\"ecommerce-website\",\"description\":\"New Projects Unleashed\",\"status\":null,\"budget\":\"1000\",\"attachment\":null,\"tags\":\"laravel\",\"created_at\":\"2025-08-18T04:16:49.000000Z\",\"updated_at\":\"2025-08-18T04:16:49.000000Z\"}', 'Approved', 'Project Done', NULL, '2025-08-18 04:17:38', '2025-08-18 04:18:26', NULL, NULL),
(10, 102, 9, '18.00', '10.00', '180.00', '25.00', '45.00', '2.60', '4.68', '0.30', '229.98', '{\"first_name\":\"Freelancer\",\"email\":\"freelancer@gmail.com\",\"phone\":\"8171960474\"}', '{\"id\":9,\"user_id\":122,\"category_id\":1,\"title\":\"Test54\",\"slug\":\"test54\",\"description\":\"dd\",\"status\":null,\"budget\":\"10\",\"attachment\":null,\"tags\":\"dd\",\"created_at\":\"2025-08-16T06:38:06.000000Z\",\"updated_at\":\"2025-08-16T06:38:06.000000Z\"}', 'Approved', 'Project Done', NULL, '2025-08-23 12:27:53', '2025-08-24 18:18:35', NULL, NULL),
(11, 122, 11, '5.00', '5.00', '25.00', '25.00', '6.25', '2.60', '0.65', '0.30', '32.20', '{\"first_name\":\"Steve\",\"email\":\"steve@gmail.com\",\"phone\":\"82828282828\"}', '{\"id\":11,\"user_id\":107,\"category_id\":2,\"title\":\"Data Entry\",\"slug\":\"data-entry\",\"description\":\"Description\",\"status\":null,\"budget\":\"50\",\"attachment\":null,\"tags\":\"tag\",\"created_at\":\"2025-08-23T12:57:34.000000Z\",\"updated_at\":\"2025-08-23T12:57:34.000000Z\"}', 'Pending', 'Project Done', NULL, '2025-08-24 18:03:48', '2025-08-24 18:03:48', NULL, NULL),
(12, 102, 8, '5.00', '5.00', '25.00', '25.00', '6.25', '2.60', '0.65', '0.30', '32.20', '{\"first_name\":\"Freelancer\",\"email\":\"freelancer@gmail.com\",\"phone\":\"8171960474\"}', '{\"id\":8,\"user_id\":122,\"category_id\":1,\"title\":\"Data Engineer Test\",\"slug\":\"data-engineer-test\",\"description\":\"Abc\",\"status\":\"Active\",\"budget\":\"10\",\"attachment\":null,\"tags\":\"ran\",\"created_at\":\"2025-08-16T06:27:37.000000Z\",\"updated_at\":\"2025-08-16T06:27:37.000000Z\"}', 'Pending', 'Project Done', NULL, '2025-08-24 18:51:11', '2025-08-24 18:51:11', NULL, 'DESC'),
(13, 102, 2, '5.00', '5.00', '25.00', '25.00', '6.25', '2.60', '0.65', '0.30', '32.20', '{\"first_name\":\"Freelancer\",\"email\":\"freelancer@gmail.com\",\"phone\":\"8171960474\"}', '{\"id\":2,\"user_id\":122,\"category_id\":1,\"title\":\"PHP Developer Needed\",\"slug\":\"php-developer-needed\",\"description\":\"Description\",\"status\":null,\"budget\":\"10\",\"attachment\":null,\"tags\":\"Tag\",\"created_at\":\"2025-08-14T06:44:53.000000Z\",\"updated_at\":\"2025-08-14T06:44:53.000000Z\"}', 'Pending', 'Project Done', NULL, '2025-08-24 19:05:22', '2025-08-24 19:05:22', NULL, 'DESC'),
(14, 110, 14, '12.00', '100.00', '1200.00', '25.00', '300.00', '2.60', '31.20', '0.30', '1531.50', '{\"first_name\":\"Freelancer1\",\"email\":\"freelancer1@gmail.com\",\"phone\":\"8171963421\"}', '{\"id\":14,\"user_id\":107,\"category_id\":2,\"title\":\"PHP Developer Required\",\"slug\":\"php-developer-required\",\"description\":\"Description\",\"status\":null,\"budget\":\"10\",\"attachment\":null,\"tags\":\"tag\",\"created_at\":\"2025-09-01T11:12:33.000000Z\",\"updated_at\":\"2025-09-01T11:12:33.000000Z\"}', 'Approved', 'Project Done', NULL, '2025-09-01 11:13:21', '2025-10-16 12:46:42', NULL, 'I\'m Rahul interested for this'),
(15, 128, 15, '50.00', '10.00', '500.00', '25.00', '125.00', '2.60', '13.00', '0.30', '638.30', '{\"first_name\":\"Kanishk Chhajed\",\"email\":\"chhajed+freelancer+kanishk.placement@gmail.com\",\"phone\":\"7426032772\"}', '{\"id\":15,\"user_id\":129,\"category_id\":1,\"title\":\"Need a UI\\/UX Designer\",\"slug\":\"need-a-uiux-designer\",\"description\":\"I\'m looking from someone who\'s experience in UI\\/UX and stay up-to-date with industry standard. What someone know how to design&nbsp; an e-commerce.\",\"status\":\"Active\",\"budget\":\"400\",\"attachment\":null,\"tags\":\"Web Developer,UI\\/UX,HTML,CSS,BootStrap,JavaScript\",\"created_at\":\"2025-09-01T13:15:23.000000Z\",\"updated_at\":\"2025-09-01T13:15:23.000000Z\"}', 'Completion Requested', 'Project Done', NULL, '2025-09-01 13:19:06', '2025-09-01 16:30:40', NULL, 'I\'m an experienced Web Designer and stay up-to-date with industry standards.'),
(16, 128, 16, '25.00', '10.00', '250.00', '25.00', '62.50', '2.60', '6.50', '0.30', '319.30', '{\"first_name\":\"Kanishk Chhajed\",\"email\":\"chhajed+freelancer+kanishk.placement@gmail.com\",\"phone\":\"7426032772\"}', '{\"id\":16,\"user_id\":129,\"category_id\":1,\"title\":\"Devlog\",\"slug\":\"devlog\",\"description\":\"Want to create a front-end for my site\",\"status\":\"Inactive\",\"budget\":\"300\",\"attachment\":null,\"tags\":\"Webdev,PHP,HTML,JavaScripty,CSS\",\"created_at\":\"2025-09-02T02:54:04.000000Z\",\"updated_at\":\"2025-09-02T02:54:30.000000Z\"}', 'Completion Requested', 'Project Done', NULL, '2025-09-02 02:56:09', '2025-09-02 02:59:18', NULL, 'I\'m experienced for this task.'),
(17, 130, 17, '1.00', '1.00', '1.00', '25.00', '0.25', '2.60', '0.03', '0.30', '1.58', '{\"first_name\":\"Test Freelancer User\",\"email\":\"testfreelancer@gmail.com\",\"phone\":\"4242424242\"}', '{\"id\":17,\"user_id\":131,\"category_id\":1,\"title\":\"AWS Migration from Onprem\",\"slug\":\"aws-migration-from-onprem\",\"description\":\"Please apply if intrested.\",\"status\":\"Active\",\"budget\":\"1\",\"attachment\":null,\"tags\":\"AWS,Data Engineer\",\"created_at\":\"2025-09-04T08:03:34.000000Z\",\"updated_at\":\"2025-09-04T08:03:34.000000Z\"}', 'Completion Requested', 'Project Done', NULL, '2025-09-04 08:04:09', '2025-09-04 08:11:34', NULL, 'I\'m intrested to apply'),
(18, 134, 18, '12.00', '100.00', '1200.00', '25.00', '300.00', '2.60', '31.20', '0.30', '1531.50', '{\"first_name\":\"Ranjan Team\",\"email\":\"ranjanteam@gmail.com\",\"phone\":\"8979897890\"}', '{\"id\":18,\"user_id\":133,\"category_id\":1,\"title\":\"React Website\",\"slug\":\"react-website\",\"description\":\"Optimize power consumption at your swap station by slow charging batteries in the night and keep them ready for utilisation at peak hours, reducing peak demand on the grid and increasing battery life.<br><br><div class=\\\"col-lg-4 col-md-4 col-sm-12 OneBattery_single_box\\\" style=\\\"padding-right: 12px; padding-left: 12px; position: relative; width: 380px; max-width: 100%; color: rgb(33, 37, 41); font-family: system-ui, -apple-system, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, &quot;Noto Sans&quot;, &quot;Liberation Sans&quot;, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; font-size: 16px; letter-spacing: normal; background-color: rgb(2, 2, 10);\\\"><h3 style=\\\"margin-top: 16px; margin-bottom: 16px; line-height: 37px; font-size: 28px; color: rgb(252, 252, 252); font-family: Lufga500; letter-spacing: -0.01em;\\\">&nbsp;Battery Insights<\\/h3><p style=\\\"margin-bottom: 0px; color: rgb(187, 187, 188); font-family: Manrope, sans-serif; font-size: 16px; line-height: 24px;\\\">Get alerts on battery temperature, current, voltage, state of charge and health monitoring.\\u200b<\\/p><\\/div><div class=\\\"col-lg-4 col-md-4 col-sm-12 OneBattery_single_box\\\" style=\\\"padding-right: 12px; padding-left: 12px; position: relative; width: 380px; max-width: 100%; color: rgb(33, 37, 41); font-family: system-ui, -apple-system, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, &quot;Noto Sans&quot;, &quot;Liberation Sans&quot;, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; font-size: 16px; letter-spacing: normal; background-color: rgb(2, 2, 10);\\\"><img src=\\\"https:\\/\\/race.energy\\/static\\/media\\/onebattery3.284fee5eb06a5e89b69c.png\\\" alt=\\\"img\\\" loading=\\\"lazy\\\" class=\\\"img-fluid OneBattery_single_box_img_three\\\" style=\\\"width: 339px !important;\\\"><h3 style=\\\"margin-top: 16px; margin-bottom: 16px; line-height: 37px; font-size: 28px; color: rgb(252, 252, 252); font-family: Lufga500; letter-spacing: -0.01em;\\\">Seamless &amp; Automatic Swap\\u200b\\u200b<\\/h3><p style=\\\"margin-bottom: 0px; color: rgb(187, 187, 188); font-family: Manrope, sans-serif; font-size: 16px; line-height: 24px;\\\">Swap batteries in seconds, make cashless payments and leave battery maintenance to us.<\\/p><\\/div>\",\"status\":null,\"budget\":\"1000\",\"attachment\":null,\"tags\":\"react,nodejs\",\"created_at\":\"2025-09-12T09:37:01.000000Z\",\"updated_at\":\"2025-09-12T09:37:01.000000Z\"}', 'Completed', NULL, NULL, '2025-09-12 10:39:15', '2025-09-12 10:54:25', NULL, 'I\'m willing to work on this'),
(19, 130, 19, '1.00', '1.00', '1.00', '25.00', '0.25', '2.60', '0.03', '0.30', '1.58', '{\"first_name\":\"Test Freelancer User\",\"email\":\"testfreelancer@gmail.com\",\"phone\":\"4242424242\"}', '{\"id\":19,\"user_id\":131,\"category_id\":1,\"title\":\"AWS Test Now\",\"slug\":\"aws-test-now\",\"description\":\"Hello this is a test project.,&nbsp;\",\"status\":null,\"budget\":\"101\",\"attachment\":null,\"tags\":\"fsf,sfsf,sf,s\",\"created_at\":\"2025-09-18T10:06:07.000000Z\",\"updated_at\":\"2025-09-18T10:06:07.000000Z\"}', 'Completed', NULL, NULL, '2025-09-18 10:08:16', '2025-09-18 10:12:38', NULL, 'Heelo'),
(20, 130, 20, '22.00', '1.00', '22.00', '25.00', '5.50', '2.60', '0.57', '0.30', '28.37', '{\"first_name\":\"Test Freelancer User\",\"email\":\"testfreelancer@gmail.com\",\"phone\":\"4242424242\"}', '{\"id\":20,\"user_id\":131,\"category_id\":2,\"title\":\"AWS nooon\",\"slug\":\"aws-nooon\",\"description\":\"fhfhfh\",\"status\":null,\"budget\":\"22\",\"attachment\":null,\"tags\":null,\"created_at\":\"2025-09-18T10:14:51.000000Z\",\"updated_at\":\"2025-09-18T10:14:51.000000Z\"}', 'Pending', NULL, NULL, '2025-09-18 10:15:22', '2025-09-18 10:15:22', NULL, 'fff'),
(21, 136, 21, '8.00', '200.00', '1600.00', '25.00', '400.00', '2.60', '41.60', '0.30', '2041.90', '{\"first_name\":\"Flavio\",\"email\":\"flavionevesdasilva@thecodehelper.com\",\"phone\":\"+6421114550\"}', '{\"id\":21,\"user_id\":135,\"category_id\":2,\"title\":\"AI Customer Support Bot\",\"slug\":\"ai-customer-support-bot\",\"description\":\"Build an AI-powered chatbot for customer service that integrates with WhatsApp and website chat widgets. Should answer FAQs and escalate to a human when needed.\",\"status\":null,\"budget\":\"800\",\"attachment\":null,\"tags\":null,\"created_at\":\"2025-10-05T02:53:05.000000Z\",\"updated_at\":\"2025-10-05T02:53:05.000000Z\"}', 'Completion Requested', 'Project completed as discussed', NULL, '2025-10-05 03:57:58', '2025-10-05 05:04:09', NULL, 'Test'),
(22, 130, 22, '10.00', '25.00', '250.00', '25.00', '62.50', '2.60', '6.50', '0.30', '319.30', '{\"first_name\":\"Test Freelancer User\",\"email\":\"testfreelancer@gmail.com\",\"phone\":\"4242424242\"}', '{\"id\":22,\"user_id\":131,\"category_id\":2,\"title\":\"Web Development\",\"slug\":\"web-development\",\"description\":\"Test: I need to create a website to the my small store\",\"status\":null,\"budget\":\"700\",\"attachment\":null,\"tags\":\"WebDevelopment,website\",\"created_at\":\"2025-10-06T04:34:25.000000Z\",\"updated_at\":\"2025-10-06T04:34:25.000000Z\"}', 'Approved', NULL, NULL, '2025-10-06 04:42:46', '2025-10-06 04:44:31', NULL, 'teste'),
(23, 110, 22, '6.00', '8.00', '48.00', '25.00', '12.00', '2.60', '1.25', '0.30', '61.55', '{\"first_name\":\"Freelancer1\",\"email\":\"freelancer1@gmail.com\",\"phone\":\"8171963421\"}', '{\"id\":22,\"user_id\":131,\"category_id\":2,\"title\":\"Web Development\",\"slug\":\"web-development\",\"description\":\"Test: I need to create a website to the my small store\",\"status\":null,\"budget\":\"700\",\"attachment\":null,\"tags\":\"WebDevelopment,website\",\"created_at\":\"2025-10-06T04:34:25.000000Z\",\"updated_at\":\"2025-10-06T04:34:25.000000Z\"}', 'Approved', NULL, NULL, '2025-10-13 05:00:46', '2025-10-27 16:49:50', NULL, 'hhkj'),
(24, 110, 21, '5.00', '5.00', '25.00', '25.00', '6.25', '2.60', '0.65', '0.30', '32.20', '{\"first_name\":\"Freelancer1\",\"email\":\"freelancer1@gmail.com\",\"phone\":\"8171963421\"}', '{\"id\":21,\"user_id\":135,\"category_id\":2,\"title\":\"AI Customer Support Bot\",\"slug\":\"ai-customer-support-bot\",\"description\":\"Build an AI-powered chatbot for customer service that integrates with WhatsApp and website chat widgets. Should answer FAQs and escalate to a human when needed.\",\"status\":null,\"budget\":\"800\",\"attachment\":null,\"tags\":null,\"created_at\":\"2025-10-05T02:53:05.000000Z\",\"updated_at\":\"2025-10-05T02:53:05.000000Z\"}', 'Pending', NULL, NULL, '2025-10-13 05:01:50', '2025-10-13 05:01:50', NULL, 'asdfasfd'),
(25, 110, 19, '2.00', '3.00', '6.00', '25.00', '1.50', '2.60', '0.16', '0.30', '7.96', '{\"first_name\":\"Freelancer1\",\"email\":\"freelancer1@gmail.com\",\"phone\":\"8171963421\"}', '{\"id\":19,\"user_id\":131,\"category_id\":1,\"title\":\"AWS Test Now\",\"slug\":\"aws-test-now\",\"description\":\"Hello this is a test project.,&nbsp;\",\"status\":null,\"budget\":\"101\",\"attachment\":null,\"tags\":\"fsf,sfsf,sf,s\",\"created_at\":\"2025-09-18T10:06:07.000000Z\",\"updated_at\":\"2025-09-18T10:06:07.000000Z\"}', 'Pending', NULL, NULL, '2025-10-13 05:12:28', '2025-10-13 05:12:28', NULL, 'asdfa'),
(26, 130, 23, '1.00', '1.00', '1.00', '25.00', '0.25', '2.60', '0.03', '0.30', '1.58', '{\"first_name\":\"Test Freelancer User\",\"email\":\"testfreelancer@gmail.com\",\"phone\":\"4242424242\"}', '{\"id\":23,\"user_id\":107,\"category_id\":2,\"title\":\"Human Test\",\"slug\":\"human-test\",\"description\":\"<p>Hellofsf<\\/p><p><br><\\/p>\",\"status\":null,\"budget\":\"1\",\"attachment\":null,\"tags\":\"f,\\\\sf\",\"created_at\":\"2025-10-16T12:50:50.000000Z\",\"updated_at\":\"2025-10-16T12:50:50.000000Z\"}', 'Completed', NULL, NULL, '2025-10-16 12:51:25', '2025-10-16 13:12:13', NULL, 'gwe'),
(27, 136, 23, '5.00', '200.00', '1000.00', '25.00', '250.00', '2.60', '26.00', '0.30', '1276.30', '{\"first_name\":\"Flavio\",\"email\":\"flavionevesdasilva@thecodehelper.com\",\"phone\":\"+6421114550\"}', '{\"id\":23,\"user_id\":107,\"category_id\":2,\"title\":\"Human Test\",\"slug\":\"human-test\",\"description\":\"<p>Hellofsf<\\/p><p><br><\\/p>\",\"status\":null,\"budget\":\"1\",\"attachment\":null,\"tags\":\"f,\\\\sf\",\"created_at\":\"2025-10-16T12:50:50.000000Z\",\"updated_at\":\"2025-10-16T12:50:50.000000Z\"}', 'Approved', NULL, NULL, '2025-11-04 04:41:43', '2025-11-20 16:02:26', NULL, 'Test'),
(28, 136, 24, '4.00', '200.00', '800.00', '25.00', '200.00', '2.60', '20.80', '0.30', '1021.10', '{\"first_name\":\"Flavio\",\"email\":\"flavionevesdasilva@thecodehelper.com\",\"phone\":\"+6421114550\"}', '{\"id\":24,\"user_id\":135,\"category_id\":9,\"title\":\"AI Test\",\"slug\":\"ai-test\",\"description\":\"Test\",\"status\":null,\"budget\":\"4000\",\"attachment\":null,\"tags\":null,\"created_at\":\"2025-11-04T04:43:09.000000Z\",\"updated_at\":\"2025-11-04T04:43:09.000000Z\"}', 'Approved', NULL, NULL, '2025-11-04 04:43:51', '2025-11-04 04:55:11', NULL, 'test'),
(29, 142, 35, '20.00', '50.00', '1000.00', '25.00', '250.00', '2.60', '26.00', '0.30', '1276.30', '{\"first_name\":\"test540\",\"email\":\"test540@test.com\",\"phone\":\"0211174550\"}', '{\"id\":35,\"user_id\":135,\"category_id\":46,\"title\":\"test Github\",\"slug\":\"test-github\",\"description\":\"test\",\"status\":\"Active\",\"budget\":\"800\",\"attachment\":null,\"tags\":null,\"created_at\":\"2025-11-10T10:46:03.000000Z\",\"updated_at\":\"2025-11-10T10:46:03.000000Z\"}', 'Approved', NULL, NULL, '2025-11-10 10:50:54', '2025-11-10 10:53:20', NULL, 'tesy'),
(30, 110, 36, '20.00', '20.00', '400.00', '25.00', '100.00', '2.60', '10.40', '0.30', '510.70', '{\"first_name\":\"Sam J\",\"email\":\"freelancer1@gmail.com\",\"phone\":\"8171963421\"}', '{\"id\":36,\"user_id\":145,\"category_id\":33,\"title\":\"Laravel Website\",\"slug\":\"laravel-website\",\"description\":\"Test\",\"status\":\"Active\",\"budget\":null,\"attachment\":null,\"tags\":\"php\",\"created_at\":\"2025-11-13T16:49:28.000000Z\",\"updated_at\":\"2025-11-13T16:49:28.000000Z\"}', 'Pending', NULL, NULL, '2025-11-13 16:50:16', '2025-11-13 16:50:16', NULL, 'Yes'),
(31, 148, 37, '1.00', '1.00', '1.00', '25.00', '0.25', '2.60', '0.03', '0.30', '1.58', '{\"first_name\":\"Ranjan Sharma\",\"email\":\"ranjans38@gmail.com\",\"phone\":\"8310037171\"}', '{\"id\":37,\"user_id\":107,\"category_id\":9,\"title\":\"asdf\",\"slug\":\"asdf\",\"description\":\"ads\",\"status\":\"Inactive\",\"budget\":\"10\",\"attachment\":null,\"tags\":null,\"created_at\":\"2025-11-14T12:27:35.000000Z\",\"updated_at\":\"2025-11-14T12:27:35.000000Z\"}', 'Approved', NULL, NULL, '2025-11-14 12:58:22', '2025-11-14 12:59:21', NULL, 'hello'),
(32, 110, 32, '20.00', '20.00', '400.00', '25.00', '100.00', '2.60', '10.40', '0.30', '510.70', '{\"first_name\":\"Sam J\",\"email\":\"freelancer1@gmail.com\",\"phone\":\"8171963421\"}', '{\"id\":32,\"user_id\":107,\"category_id\":33,\"title\":\"Ecommerce Website\",\"slug\":\"ecommerce-website-php\",\"description\":\"Tesyt Urgent\",\"status\":\"Active\",\"budget\":null,\"attachment\":null,\"tags\":\"php\",\"created_at\":\"2025-11-09T07:04:07.000000Z\",\"updated_at\":\"2025-11-09T07:04:07.000000Z\"}', 'Approved', NULL, NULL, '2025-11-15 04:31:07', '2025-11-15 04:31:45', NULL, 'Test'),
(33, 149, 27, '10.00', '20.00', '200.00', '25.00', '50.00', '2.60', '5.20', '0.30', '255.50', '{\"first_name\":\"Working Man\",\"email\":\"freelancernew@gmail.com\",\"phone\":\"89778978978\"}', '{\"id\":27,\"user_id\":107,\"category_id\":33,\"title\":\"New testing project\",\"slug\":\"new-testing-project\",\"description\":\"Description\",\"status\":\"Active\",\"budget\":\"30\",\"attachment\":null,\"tags\":\"tag3\",\"created_at\":\"2025-11-06T06:38:51.000000Z\",\"updated_at\":\"2025-11-06T06:38:51.000000Z\"}', 'Approved', NULL, NULL, '2025-11-15 04:35:33', '2025-11-15 04:36:20', NULL, 'Test');

-- --------------------------------------------------------

--
-- Table structure for table `application_attachments`
--

CREATE TABLE `application_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `application_id` bigint(20) UNSIGNED NOT NULL,
  `attachment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `application_attachments`
--

INSERT INTO `application_attachments` (`id`, `application_id`, `attachment`, `created_at`, `updated_at`) VALUES
(1, 1, '/upload/application/175515297634897.png', '2025-08-14 06:29:36', '2025-08-14 06:29:36'),
(2, 4, '/upload/application/175532037488760.docx', '2025-08-16 04:59:34', '2025-08-16 04:59:34'),
(3, 10, '/upload/application/175595207368892.png', '2025-08-23 12:27:53', '2025-08-23 12:27:53'),
(4, 14, '/upload/application/175672520165875.jpg', '2025-09-01 11:13:21', '2025-09-01 11:13:21'),
(5, 8, '/upload/application/175673274698254.png', '2025-09-01 13:19:06', '2025-09-01 13:19:06'),
(6, 8, '/upload/application/175697304959653.png', '2025-09-04 08:04:09', '2025-09-04 08:04:09'),
(7, 18, '/upload/application/175767355591864.png', '2025-09-12 10:39:15', '2025-09-12 10:39:15');

-- --------------------------------------------------------

--
-- Table structure for table `application_completion_attachments`
--

CREATE TABLE `application_completion_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `application_id` bigint(20) UNSIGNED NOT NULL,
  `attachment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `application_completion_attachments`
--

INSERT INTO `application_completion_attachments` (`id`, `application_id`, `attachment`, `created_at`, `updated_at`) VALUES
(1, 3, '/upload/application/175515471966798.jpg', '2025-08-14 06:58:39', '2025-08-14 06:58:39'),
(2, 4, '/upload/application/175532063455343.jpg', '2025-08-16 05:03:54', '2025-08-16 05:03:54'),
(3, 5, '/upload/application/175532119665343.png', '2025-08-16 05:13:16', '2025-08-16 05:13:16'),
(4, 8, '/upload/application/175532182633377.png', '2025-08-16 05:23:46', '2025-08-16 05:23:46'),
(5, 15, '/upload/application/175674424049516.png', '2025-09-01 16:30:40', '2025-09-01 16:30:40'),
(6, 17, '/upload/application/175697349461447.png', '2025-09-04 08:11:34', '2025-09-04 08:11:34'),
(7, 18, '/upload/application/175767401287744.png', '2025-09-12 10:46:52', '2025-09-12 10:46:52'),
(8, 19, '/upload/application/175819032710748.jpg', '2025-09-18 10:12:07', '2025-09-18 10:12:07');

-- --------------------------------------------------------

--
-- Table structure for table `application_statuses`
--

CREATE TABLE `application_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `application_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `application_statuses`
--

INSERT INTO `application_statuses` (`id`, `application_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 'Completion Requested', '2025-08-14 06:58:39', '2025-08-14 06:58:39'),
(2, 3, 'Completed', '2025-08-14 06:59:05', '2025-08-14 06:59:05'),
(3, 2, 'Completion Requested', '2025-08-14 06:59:37', '2025-08-14 06:59:37'),
(4, 2, 'Completed', '2025-08-14 06:59:46', '2025-08-14 06:59:46'),
(5, 1, 'Completion Requested', '2025-08-14 11:54:00', '2025-08-14 11:54:00'),
(6, 1, 'Completed', '2025-08-14 11:55:22', '2025-08-14 11:55:22'),
(7, 4, 'Completion Requested', '2025-08-16 05:03:54', '2025-08-16 05:03:54'),
(8, 4, 'Completed', '2025-08-16 05:04:44', '2025-08-16 05:04:44'),
(9, 5, 'Completion Requested', '2025-08-16 05:13:16', '2025-08-16 05:13:16'),
(10, 5, 'Completed', '2025-08-16 05:14:32', '2025-08-16 05:14:32'),
(11, 6, 'Completion Requested', '2025-08-16 05:23:46', '2025-08-16 05:23:46'),
(13, 8, 'Completion Requested', '2025-08-16 06:52:11', '2025-08-16 06:52:11'),
(14, 8, 'Completed', '2025-08-16 06:52:47', '2025-08-16 06:52:47'),
(15, 15, 'Completion Requested', '2025-09-01 16:30:40', '2025-09-01 16:30:40'),
(22, 16, 'Completion Requested', '2025-09-02 02:59:18', '2025-09-02 02:59:18'),
(24, 17, 'Completion Requested', '2025-09-04 08:11:34', '2025-09-04 08:11:34'),
(29, 18, 'Completion Requested', '2025-09-12 10:46:52', '2025-09-12 10:46:52'),
(31, 18, 'Completed', '2025-09-12 10:54:25', '2025-09-12 10:54:25'),
(33, 19, 'Completion Requested', '2025-09-18 10:12:07', '2025-09-18 10:12:07'),
(34, 19, 'Completed', '2025-09-18 10:12:38', '2025-09-18 10:12:38'),
(35, 21, 'Completion Requested', '2025-10-05 05:04:09', '2025-10-05 05:04:09'),
(40, 26, 'Completion Requested', '2025-10-16 13:11:12', '2025-10-16 13:11:12'),
(41, 26, 'Completed', '2025-10-16 13:12:13', '2025-10-16 13:12:13');

-- --------------------------------------------------------

--
-- Table structure for table `basic_settings`
--

CREATE TABLE `basic_settings` (
  `id` int(11) NOT NULL,
  `ip` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `background_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sidebar_font_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sidebar_font_size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `font_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `header_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `footer_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_background_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `main_content_background_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `main_body_card_background_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `basic_settings`
--

INSERT INTO `basic_settings` (`id`, `ip`, `background_color`, `sidebar_font_color`, `sidebar_font_size`, `font_color`, `header_color`, `footer_color`, `logo_background_color`, `main_content_background_color`, `main_body_card_background_color`, `created_at`, `updated_at`) VALUES
(1, '106.194.107.213, 103.87.45.32,103.170.81.154', '#134e42', '#ffffff', '15', NULL, '#134e42', '#ffffff', '#ffffff', '#ffffff', '#ffffff', '2022-01-28 15:08:41', '2023-04-23 17:20:53');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `status`, `image`, `link`, `location`, `description`, `created_at`, `updated_at`) VALUES
(1, 'PHP', 'php', 'Active', NULL, '', '', '', '2025-10-17 10:17:03', '2025-10-17 10:17:03'),
(2, 'Flutter', 'flutter', 'Active', NULL, '', '', '', '2025-10-17 10:17:03', '2025-10-17 10:17:03'),
(3, 'React.Js', 'react.js', 'Active', NULL, '', '', '', '2025-10-17 10:17:03', '2025-10-17 10:17:03'),
(4, 'NodeJs', 'nodejs', 'Active', NULL, '', '', '', '2025-10-17 10:17:03', '2025-10-17 10:17:03'),
(5, 'HTML', 'html', 'Active', NULL, '', '', '', '2025-10-17 10:17:03', '2025-10-17 10:17:03'),
(6, 'Python', 'python', 'Active', NULL, '', '', '', '2025-10-17 10:17:03', '2025-10-17 10:17:03'),
(7, 'Node', 'node', 'Active', NULL, '', '', '', '2025-10-17 10:17:03', '2025-10-17 10:17:03'),
(8, 'Web Development', 'web-development', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(9, 'App Development', 'app-development', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(10, 'Frontend Development', 'frontend-development', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(11, 'Backend Development', 'backend-development', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(12, 'Full Stack Development', 'full-stack-development', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(13, 'Mobile App Development', 'mobile-app-development', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(14, 'Android App Development', 'android-app-development', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(15, 'iOS App Development', 'ios-app-development', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(16, 'Flutter Development', 'flutter-development', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(17, 'React Native Development', 'react-native-development', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(18, 'Next.js Development', 'next.js-development', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(19, 'Vue.js Development', 'vue.js-development', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(20, 'Angular Development', 'angular-development', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(21, 'Node.js Development', 'node.js-development', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(22, 'Express.js Development', 'express.js-development', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(23, 'Django Development', 'django-development', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(24, 'Flask Development', 'flask-development', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(25, 'FastAPI Development', 'fastapi-development', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(26, 'Laravel Development', 'laravel-development', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(27, 'Spring Boot Development', 'spring-boot-development', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(28, '.NET Core Development', '.net-core-development', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(29, 'WordPress Development', 'wordpress-development', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(30, 'Shopify Development', 'shopify-development', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(31, 'Magento Development', 'magento-development', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(32, 'E-commerce Development', 'e-commerce-development', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(33, 'API Development', 'api-development', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(34, 'REST API', 'rest-api', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(35, 'GraphQL', 'graphql', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(36, 'Database Development', 'database-development', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(37, 'MySQL', 'mysql', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(38, 'PostgreSQL', 'postgresql', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(39, 'MongoDB', 'mongodb', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(40, 'Redis', 'redis', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(41, 'Firebase', 'firebase', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(42, 'AWS', 'aws', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(43, 'Google Cloud', 'google-cloud', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(44, 'Microsoft Azure', 'microsoft-azure', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(45, 'Docker', 'docker', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(46, 'Kubernetes', 'kubernetes', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(47, 'CI/CD Pipelines', 'ci/cd-pipelines', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(48, 'DevOps Engineering', 'devops-engineering', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(49, 'Cloud Architecture', 'cloud-architecture', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(50, 'SaaS Development', 'saas-development', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(51, 'Progressive Web App (PWA) Development', 'progressive-web-app-(pwa)-development', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(52, 'Hybrid App Development', 'hybrid-app-development', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(53, 'Automation & Scripting', 'automation-&-scripting', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(54, 'Web App Development', 'web-app-development', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(55, 'Landing Page Development', 'landing-page-development', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(56, 'Backend as a Service (BaaS)', 'backend-as-a-service-(baas)', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23'),
(57, 'Microservices Architecture', 'microservices-architecture', 'Active', NULL, '', '', '', '2025-10-18 05:58:23', '2025-10-18 05:58:23');

-- --------------------------------------------------------

--
-- Table structure for table `contact_queries`
--

CREATE TABLE `contact_queries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_queries`
--

INSERT INTO `contact_queries` (`id`, `user_id`, `name`, `email`, `phone`, `message`, `created_at`, `updated_at`) VALUES
(1, 122, 'Name', 'email@email.com', '1231231234', 'Message', '2025-09-05 08:28:34', '2025-09-05 08:28:34'),
(2, 132, 'Name', 'email@email.com', '1231231234', 'Message', '2025-09-05 08:30:34', '2025-09-05 08:30:34'),
(3, 131, 'Test', 'flavionvs@hotmail.com', '021114550', 'Teste', '2025-10-06 04:48:03', '2025-10-06 04:48:03'),
(4, 122, 'Test', 'asdf@asdf.com', '23132123', '23132123', '2025-10-11 17:17:14', '2025-10-11 17:17:14');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `langs`
--

CREATE TABLE `langs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `langs`
--

INSERT INTO `langs` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Hindi', 'Active', '2025-10-11 15:58:09', '2025-10-11 15:58:09'),
(2, 'English', 'Active', '2025-10-11 15:58:14', '2025-10-11 15:58:14'),
(3, 'French', 'Active', '2025-10-11 15:58:18', '2025-10-11 15:58:18'),
(4, 'Spanish', 'Active', '2025-10-17 10:06:47', '2025-10-17 10:06:47'),
(5, 'Mandarin Chinese', 'Active', '2025-10-17 10:06:47', '2025-10-17 10:06:47'),
(6, 'Arabic', 'Active', '2025-10-17 10:06:47', '2025-10-17 10:06:47'),
(7, 'Portuguese', 'Active', '2025-10-17 10:06:47', '2025-10-17 10:06:47'),
(8, 'Russian', 'Active', '2025-10-17 10:06:47', '2025-10-17 10:06:47'),
(9, 'Japanese', 'Active', '2025-10-17 10:06:47', '2025-10-17 10:06:47'),
(10, 'German', 'Active', '2025-10-17 10:06:47', '2025-10-17 10:06:47'),
(11, 'Korean', 'Active', '2025-10-17 10:06:47', '2025-10-17 10:06:47'),
(12, 'Italian', 'Active', '2025-10-17 10:06:47', '2025-10-17 10:06:47'),
(13, 'Vietnamese', 'Active', '2025-10-17 10:06:47', '2025-10-17 10:06:47'),
(14, 'Thai', 'Active', '2025-10-17 10:06:47', '2025-10-17 10:06:47'),
(15, 'Persian (Farsi)', 'Active', '2025-10-17 10:06:47', '2025-10-17 10:06:47'),
(16, 'Malay / Indonesian', 'Active', '2025-10-17 10:06:47', '2025-10-17 10:06:47'),
(17, 'Turkish', 'Active', '2025-10-17 10:06:47', '2025-10-17 10:06:47'),
(18, 'Dutch', 'Active', '2025-10-17 10:06:47', '2025-10-17 10:06:47'),
(19, 'Swedish', 'Active', '2025-10-17 10:06:47', '2025-10-17 10:06:47');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `from` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `from`, `to`, `message`, `file`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 107, 102, 'Hello', '', 1, '2025-05-26 13:32:21', '2025-05-26 14:28:38'),
(2, 107, 110, 'Hii', '', 1, '2025-05-26 13:34:12', '2025-05-26 13:34:21'),
(3, 110, 107, 'Hello', '', 1, '2025-05-26 13:34:23', '2025-05-26 13:35:13'),
(4, 107, 110, 'i want to work with you..', '', 1, '2025-05-26 13:34:31', '2025-05-26 13:35:30'),
(5, 110, 107, 'How much cost?', '', 1, '2025-05-26 13:34:46', '2025-05-26 13:35:13'),
(6, 107, 110, 'There??', '', 1, '2025-05-26 13:34:55', '2025-05-26 13:35:30'),
(7, 107, 110, 'Hello', '', 1, '2025-05-26 13:35:23', '2025-05-26 13:35:30'),
(8, 107, 110, 'CLient', '', 1, '2025-05-26 13:35:51', '2025-05-26 13:35:56'),
(9, 107, 110, 'Hii', '', 1, '2025-05-26 13:36:45', '2025-05-28 14:49:01'),
(10, 107, 110, 'Hello', '', 1, '2025-05-26 13:37:17', '2025-05-28 14:49:01'),
(11, 102, 107, 'Hi', '', 1, '2025-05-26 14:28:42', '2025-05-26 14:29:02'),
(12, 107, 102, 'What\'s status of my project', '', 1, '2025-05-26 14:29:15', '2025-05-27 10:06:59'),
(13, 110, 107, 'Hello there...', '', 1, '2025-05-28 14:49:10', '2025-05-28 14:49:38'),
(14, 107, 110, 'Hii', '', 1, '2025-05-28 14:49:42', '2025-05-28 14:49:48'),
(15, 110, 107, 'How are you?', '', 1, '2025-05-28 14:49:54', '2025-05-28 15:20:26'),
(16, 107, 110, 'Hello', '/upload/chat/174844380453815.jpg', 1, '2025-05-28 14:50:04', '2025-05-28 14:50:46'),
(17, 110, 107, 'Hello', '', 1, '2025-05-28 14:50:23', '2025-05-28 15:20:26'),
(18, 107, 110, 'Hello there..', '', 1, '2025-05-28 14:50:36', '2025-05-28 14:50:46'),
(19, 110, 107, 'what is up?', '', 1, '2025-05-28 14:50:55', '2025-05-28 15:20:26'),
(20, 110, 107, 'hii', '', 1, '2025-05-28 14:51:03', '2025-05-28 15:20:26'),
(21, 110, 107, 'hii', '', 1, '2025-05-28 14:51:05', '2025-05-28 15:20:26'),
(22, 107, 102, 'Hello there...', '', 1, '2025-05-28 14:53:02', '2025-05-29 12:59:54'),
(23, 107, 110, 'Hii', '', 1, '2025-05-28 15:17:20', '2025-05-28 15:17:25'),
(24, 110, 107, 'Helo ther', '', 1, '2025-05-28 15:17:30', '2025-05-28 15:20:26'),
(25, 107, 110, 'hello', '', 1, '2025-05-29 13:01:08', '2025-05-30 04:39:50'),
(26, 107, 110, 'hello', '', 1, '2025-05-29 13:01:09', '2025-05-30 04:39:50'),
(27, 102, 107, 'yes', '', 1, '2025-05-29 13:01:17', '2025-05-29 13:01:26'),
(28, 107, 102, 'I\'m here', '', 1, '2025-05-29 13:03:04', '2025-05-30 05:15:06'),
(29, 102, 107, 'This is just testing', '', 1, '2025-05-29 13:03:14', '2025-05-29 13:03:30'),
(30, 110, 107, 'hii', '/upload/chat/174858005738368.png', 1, '2025-05-30 04:40:57', '2025-05-30 04:42:20'),
(31, 107, 110, 'Hello', '', 1, '2025-05-30 04:42:24', '2025-07-06 10:30:16'),
(32, 107, 110, 'yes', '/upload/chat/174858016035281.png', 1, '2025-05-30 04:42:40', '2025-07-06 10:30:16'),
(33, 107, 110, 'new page', '/upload/chat/174858021844979.html', 1, '2025-05-30 04:43:38', '2025-07-06 10:30:16'),
(34, 102, 107, 'Hello Sir', '', 1, '2025-05-30 05:15:13', '2025-05-30 05:15:25'),
(35, 102, 107, 'Any updates', '', 1, '2025-05-30 05:15:19', '2025-05-30 05:15:25'),
(36, 107, 102, 'Need to redesign this image some touching needed', '/upload/chat/174858216026549.jpg', 1, '2025-05-30 05:16:00', '2025-06-20 10:40:47'),
(37, 102, 107, 'okay sir', '', 1, '2025-05-30 05:16:15', '2025-05-30 05:16:52'),
(38, 102, 107, 'waiting for reply', '', 1, '2025-05-30 05:16:43', '2025-05-30 05:16:52'),
(39, 107, 102, 'upload Privacy Policy page on website', '/upload/chat/174858223722303.html', 1, '2025-05-30 05:17:17', '2025-06-20 10:40:47'),
(40, 107, 110, 'Hello', '', 1, '2025-06-06 13:43:12', '2025-07-06 10:30:16'),
(41, 107, 110, 'hii', '', 1, '2025-06-15 10:43:10', '2025-07-06 10:30:16'),
(42, 107, 110, 'Hii', '/upload/chat/174998423250624.jpg', 1, '2025-06-15 10:43:52', '2025-07-06 10:30:16'),
(43, 107, 102, 'hello', '', 1, '2025-07-02 03:18:44', '2025-07-03 09:18:25'),
(44, 107, 102, 'New Image', '/upload/chat/175147731456040.jpg', 1, '2025-07-02 17:28:34', '2025-07-03 09:18:25'),
(45, 107, 110, 'Nwq image', '/upload/chat/175147737022870.jpg', 1, '2025-07-02 17:29:30', '2025-07-06 10:30:16'),
(46, 107, 110, 'New Attachment', '', 1, '2025-07-02 17:30:23', '2025-07-06 10:30:16'),
(47, 102, 107, 'Hello', '', 1, '2025-07-03 09:18:53', '2025-07-03 09:21:58'),
(48, 102, 107, 'Hello', '/upload/chat/175153436853553.jpg', 1, '2025-07-03 09:19:28', '2025-07-03 09:21:58'),
(49, 102, 107, 'hii', '/upload/chat/175153445460587.pdf', 1, '2025-07-03 09:20:54', '2025-07-03 09:21:58'),
(50, 107, 102, 'jjjj', '/upload/chat/175173286895870.pdf', 1, '2025-07-05 16:27:48', '2025-07-05 16:34:40'),
(51, 107, 102, 'heklo', '', 1, '2025-07-05 16:30:07', '2025-07-05 16:34:40'),
(52, 107, 110, 'yesy', '/upload/chat/175186556391073.pdf', 1, '2025-07-07 05:19:23', '2025-07-11 07:09:01'),
(53, 107, 102, 'hello', '', 1, '2025-07-11 06:59:06', '2025-08-24 18:17:35'),
(54, 107, 110, 'hello I have approved the project', '', 1, '2025-07-11 07:08:11', '2025-07-11 07:09:01'),
(55, 110, 107, 'hi yes i good to start', '', 1, '2025-07-11 07:09:16', '2025-07-11 16:30:24'),
(56, 122, 123, 'Hi there...', '', 1, '2025-08-14 11:45:20', '2025-08-14 11:45:43'),
(57, 122, 123, 'Hello', '/upload/chat/175517193283781.jpg', 1, '2025-08-14 11:45:32', '2025-08-14 11:45:43'),
(58, 122, 123, 'How are you?', '', 1, '2025-08-14 11:45:51', '2025-08-14 12:10:28'),
(59, 123, 122, 'Good...', '', 1, '2025-08-14 11:45:57', '2025-08-14 12:07:38'),
(60, 122, 123, 'hi', '', 1, '2025-08-16 04:57:14', '2025-08-16 07:01:04'),
(61, 102, 107, 'hii', '', 1, '2025-08-24 18:17:52', '2025-09-01 19:01:53'),
(62, 129, 128, 'Hello Kanishk Chhajed', '', 1, '2025-09-01 16:00:59', '2025-09-01 16:01:09'),
(63, 128, 129, 'Hello Kan', '', 1, '2025-09-01 16:01:15', '2025-09-01 16:04:06'),
(64, 129, 128, 'What\'s the update of my task?', '', 1, '2025-09-01 16:01:52', '2025-09-01 16:08:33'),
(65, 128, 129, 'It\'s ongoing sir, done with planning, now try to select some design pattern based on modern e-commerce site.', '', 1, '2025-09-01 16:02:42', '2025-09-01 16:04:06'),
(66, 129, 128, 'It\'s good, tag me with the timeline.', '', 1, '2025-09-01 16:03:10', '2025-09-01 16:08:33'),
(67, 128, 129, 'Sure Sir, have a nice day', '', 1, '2025-09-01 16:03:22', '2025-09-01 16:04:06'),
(68, 128, 129, 'Sure Sir, have a nice day', '', 1, '2025-09-01 16:03:27', '2025-09-01 16:04:06'),
(69, 129, 128, 'Hello Kanishk can we discuss the budget', '', 1, '2025-09-01 16:08:26', '2025-09-01 16:08:33'),
(70, 128, 129, 'Sir, I charge around 10 dollar per hour which is the cheapest in the market.', '', 1, '2025-09-01 16:09:32', '2025-09-01 16:11:55'),
(71, 129, 128, 'I know that Kanishk but, my budget is tight can we do something about that.', '', 1, '2025-09-01 16:10:47', '2025-09-01 16:28:09'),
(72, 128, 129, 'Okay Sir, tell me your budget.', '', 1, '2025-09-01 16:11:08', '2025-09-01 16:11:55'),
(73, 129, 128, 'I can offer you 500 dollar only right now, what\'s your take.', '', 1, '2025-09-01 16:12:23', '2025-09-01 16:28:09'),
(74, 128, 129, 'Okay, how about 600 dollars.', '', 1, '2025-09-01 16:13:37', '2025-09-01 16:27:44'),
(75, 129, 128, 'It\'s a tough call for me Kanishk.', '', 1, '2025-09-01 16:14:02', '2025-09-01 16:28:09'),
(76, 128, 129, 'Okay, as I take your task for first time I will accept your budget but my only condition is my deadline might exceed by 2-3 days. Is that okay with you.', '', 1, '2025-09-01 16:15:24', '2025-09-01 16:27:44'),
(77, 129, 128, 'It\'s fine with me, go ahead Kanishk.', '', 1, '2025-09-01 16:16:19', '2025-09-01 16:28:09'),
(78, 128, 129, 'Okay Sir, I will keep updating you', '', 1, '2025-09-01 16:16:41', '2025-09-01 16:27:44'),
(79, 128, 129, 'I have done with the task, please review this I send you.', '', 0, '2025-09-01 16:29:25', '2025-09-01 16:29:25'),
(80, 129, 128, 'Sure', '', 1, '2025-09-01 16:29:34', '2025-09-02 03:19:34'),
(81, 135, 136, 'HI, can we talk about the project', '', 1, '2025-10-05 04:54:03', '2025-10-05 04:57:16'),
(82, 135, 136, 'Client test 1', '', 1, '2025-10-05 04:54:33', '2025-10-05 04:57:16'),
(83, 135, 136, 'Test', '', 1, '2025-10-05 04:55:53', '2025-10-05 04:57:16'),
(84, 136, 135, 'Test', '', 1, '2025-10-05 04:57:35', '2025-10-05 05:08:51'),
(85, 131, 130, 'Teste', '', 1, '2025-10-06 04:44:47', '2025-10-15 08:35:46'),
(86, 131, 130, 'Hello', '/upload/chat/176051720653510.jpg', 1, '2025-10-15 08:33:26', '2025-10-15 08:35:46'),
(87, 131, 130, 'Hello', '/upload/chat/176051720817248.jpg', 1, '2025-10-15 08:33:28', '2025-10-15 08:35:46'),
(88, 131, 110, 'jj]', '', 1, '2025-11-06 11:56:16', '2025-11-06 16:40:50'),
(89, 135, 142, 'test', '', 0, '2025-11-10 10:53:40', '2025-11-10 10:53:40'),
(90, 131, 110, 'hi', '', 1, '2025-11-10 16:50:26', '2025-11-15 04:32:29'),
(91, 107, 107, 'hi', '', 0, '2025-11-13 11:07:43', '2025-11-13 11:07:43'),
(92, 107, 107, 'hi', '', 0, '2025-11-13 11:07:44', '2025-11-13 11:07:44'),
(93, 107, 107, 'kkj', '/upload/chat/176303212472662.png', 0, '2025-11-13 11:08:44', '2025-11-13 11:08:44'),
(94, 107, 107, 'kkj', '/upload/chat/176303212428416.png', 0, '2025-11-13 11:08:44', '2025-11-13 11:08:44'),
(95, 145, 145, 'Hi', '', 0, '2025-11-14 06:49:01', '2025-11-14 06:49:01'),
(96, 107, 107, 'Hi Ranjan', '', 0, '2025-11-14 12:59:41', '2025-11-14 12:59:41'),
(97, 107, 107, 'Hi Ranjan', '', 0, '2025-11-14 12:59:44', '2025-11-14 12:59:44'),
(98, 107, 107, 'Hi Ranjan', '', 0, '2025-11-14 12:59:50', '2025-11-14 12:59:50'),
(99, 107, 107, 'hello there', '', 0, '2025-11-14 13:01:53', '2025-11-14 13:01:53'),
(100, 107, 107, 'hello there', '', 0, '2025-11-14 13:01:55', '2025-11-14 13:01:55'),
(101, 107, 107, 'hello there', '', 0, '2025-11-14 13:01:56', '2025-11-14 13:01:56'),
(102, 148, 148, 'hello dear', '', 0, '2025-11-14 13:03:14', '2025-11-14 13:03:14'),
(103, 148, 148, 'hello dear', '', 0, '2025-11-14 13:03:15', '2025-11-14 13:03:15'),
(104, 107, 107, 'Hello', '', 0, '2025-11-15 04:32:13', '2025-11-15 04:32:13'),
(105, 107, 107, 'Hello', '', 0, '2025-11-15 04:32:15', '2025-11-15 04:32:15'),
(106, 110, 131, 'Hii', '', 0, '2025-11-15 04:32:47', '2025-11-15 04:32:47'),
(107, 149, 149, 'Hi', '', 0, '2025-11-15 04:38:04', '2025-11-15 04:38:04'),
(108, 107, 149, 'Hi', '', 1, '2025-11-15 04:38:55', '2025-11-15 04:39:02'),
(109, 107, 149, 'Hello', '', 0, '2025-11-15 04:39:33', '2025-11-15 04:39:33'),
(110, 149, 107, 'Yes', '', 1, '2025-11-15 04:39:40', '2025-11-15 09:42:16'),
(111, 107, 148, 'hi', '', 0, '2025-11-17 06:32:11', '2025-11-17 06:32:11'),
(112, 107, 148, 'hi', '', 0, '2025-11-17 06:32:12', '2025-11-17 06:32:12'),
(113, 107, 149, 'are you available?', '', 0, '2025-11-17 06:35:42', '2025-11-17 06:35:42'),
(114, 107, 110, 'perfect lets start!', '/upload/chat/176336156731231.png', 0, '2025-11-17 06:39:27', '2025-11-17 06:39:27'),
(115, 135, 142, 'terere', '', 0, '2025-11-19 11:17:10', '2025-11-19 11:17:10');

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
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(35, '2023_05_01_092916_create_permission_tables', 28),
(36, '2023_10_19_224015_create_categories_table', 29),
(37, '2023_10_19_225449_create_sub_categories_table', 30),
(38, '2023_10_19_230139_add_column_in_categories', 31),
(39, '2023_10_19_230237_add_column_in_sub_categories', 32),
(40, '2025_03_04_114407_add_country_in_users', 33),
(41, '2025_03_05_135507_create_projects_table', 34),
(42, '2025_03_13_113806_create_programming_languages_table', 35),
(43, '2025_03_13_113958_add_professional_field_in_users_table', 35),
(44, '2025_03_13_142101_create_user_categories_table', 35),
(45, '2025_03_13_142214_create_user_programming_lanugages_table', 35),
(46, '2025_03_13_150317_create_user_languages_table', 35),
(47, '2025_03_20_121834_create_applications_table', 35),
(48, '2025_04_24_061141_add_amount_in_applications_table', 36),
(49, '2025_05_01_060821_add_number_of_hours_in_applications_table', 37),
(50, '2025_05_01_063023_create_application_attachments_table', 37),
(51, '2025_05_25_145709_create_messages_table', 38),
(52, '2025_06_04_133455_add_amount_breakup_columns_in_applications_table', 39),
(53, '2025_06_04_135316_create_payments_table', 39),
(54, '2025_06_04_194951_add_user_id_in_payments_table', 39),
(55, '2025_03_13_142101_create_user_technologies_table', 40),
(56, '2025_06_18_141437_create_technologies_table', 40),
(57, '2025_06_18_183018_add_slug_in_projects_table', 40),
(58, '2025_06_19_201753_add_is_public_in_users_table', 40),
(59, '2025_06_20_095226_add_completion_in_applications_table', 40),
(60, '2025_06_20_095342_create_application_completion_attachments_table', 40),
(61, '2025_06_20_095826_create_application_statuses_table', 40),
(62, '2025_06_20_160532_add_slug_in_categories_table', 41),
(63, '2025_06_20_160736_add_status_in_categories_table', 42),
(64, '2025_07_20_181436_add_cancel_reason_in_applications_table', 43),
(65, '2025_07_20_184915_create_transactions_table', 44),
(66, '2025_07_29_182828_add_column_in_users_table', 45),
(67, '2025_07_29_192039_add_stripe_transfer_id_in_payments_table', 45),
(68, '2025_08_13_111526_create_unverified_users_table', 46),
(69, '2025_08_13_162925_add_status_in_projects_table', 47),
(70, '2025_08_25_001827_add_desc_in_applications_table', 48),
(71, '2025_09_05_123309_create_contact_queries_table', 49),
(72, '2025_10_11_211329_create_langs_table', 50),
(73, '2025_10_11_211708_create_user_langs_table', 50),
(74, '2025_10_13_101213_create_notifications_table', 51);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 100),
(2, 'App\\Models\\User', 101),
(2, 'App\\Models\\User', 102),
(2, 'App\\Models\\User', 103),
(2, 'App\\Models\\User', 104),
(2, 'App\\Models\\User', 105),
(2, 'App\\Models\\User', 106),
(2, 'App\\Models\\User', 107),
(2, 'App\\Models\\User', 111),
(2, 'App\\Models\\User', 113),
(3, 'App\\Models\\User', 77),
(3, 'App\\Models\\User', 84),
(3, 'App\\Models\\User', 85),
(3, 'App\\Models\\User', 99),
(3, 'App\\Models\\User', 108),
(3, 'App\\Models\\User', 109),
(3, 'App\\Models\\User', 110),
(3, 'App\\Models\\User', 112),
(3, 'App\\Models\\User', 114);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `created_at`, `updated_at`) VALUES
(1, 110, 'New project application', 'You have a new project application', '2025-10-13 05:01:50', '2025-10-13 05:01:50'),
(2, 110, 'New project application', 'You have a new project application', '2025-10-13 05:12:28', '2025-10-13 05:12:28'),
(3, 110, 'Application approved', 'Your application has been approved', '2025-10-16 12:46:42', '2025-10-16 12:46:42'),
(4, 130, 'New project application', 'You have a new project application', '2025-10-16 12:51:25', '2025-10-16 12:51:25'),
(5, 130, 'Application approved', 'Your application has been approved', '2025-10-16 13:10:05', '2025-10-16 13:10:05'),
(6, 130, 'Project completion request', 'Project completion request sent successfully', '2025-10-16 13:11:12', '2025-10-16 13:11:12'),
(7, 130, 'Project completion request accepted', 'Project completion request has been accepted successfully', '2025-10-16 13:12:15', '2025-10-16 13:12:15'),
(8, 110, 'Application approved', 'Your application has been approved', '2025-10-27 16:49:50', '2025-10-27 16:49:50'),
(9, 131, 'You have a new project application.', 'You have a new project application', '2025-10-27 16:49:50', '2025-10-27 16:49:50'),
(10, 136, 'New project application', 'You have a new project application', '2025-11-04 04:41:43', '2025-11-04 04:41:43'),
(11, 107, 'You have a new project application.', 'You have a new project application', '2025-11-04 04:41:43', '2025-11-04 04:41:43'),
(12, 136, 'New project application', 'You have a new project application', '2025-11-04 04:43:51', '2025-11-04 04:43:51'),
(13, 135, 'You have a new project application.', 'You have a new project application', '2025-11-04 04:43:51', '2025-11-04 04:43:51'),
(14, 136, 'Application approved', 'Your application has been approved', '2025-11-04 04:55:11', '2025-11-04 04:55:11'),
(15, 135, 'You have a new project application.', 'You have a new project application', '2025-11-04 04:55:11', '2025-11-04 04:55:11'),
(16, 142, 'New project application', 'You have a new project application', '2025-11-10 10:50:54', '2025-11-10 10:50:54'),
(17, 135, 'You have a new project application.', 'You have a new project application', '2025-11-10 10:50:54', '2025-11-10 10:50:54'),
(18, 142, 'Application approved', 'Your application has been approved', '2025-11-10 10:53:20', '2025-11-10 10:53:20'),
(19, 135, 'You have a new project application.', 'You have a new project application', '2025-11-10 10:53:20', '2025-11-10 10:53:20'),
(20, 110, 'New project application', 'You have a new project application', '2025-11-13 16:50:16', '2025-11-13 16:50:16'),
(21, 145, 'You have a new project application.', 'You have a new project application', '2025-11-13 16:50:16', '2025-11-13 16:50:16'),
(22, 148, 'New project application', 'You have a new project application', '2025-11-14 12:58:22', '2025-11-14 12:58:22'),
(23, 107, 'You have a new project application.', 'You have a new project application', '2025-11-14 12:58:22', '2025-11-14 12:58:22'),
(24, 148, 'Application approved', 'Your application has been approved', '2025-11-14 12:59:21', '2025-11-14 12:59:21'),
(25, 107, 'You have a new project application.', 'You have a new project application', '2025-11-14 12:59:21', '2025-11-14 12:59:21'),
(26, 110, 'New project application', 'You have a new project application', '2025-11-15 04:31:07', '2025-11-15 04:31:07'),
(27, 107, 'You have a new project application.', 'You have a new project application', '2025-11-15 04:31:07', '2025-11-15 04:31:07'),
(28, 110, 'Application approved', 'Your application has been approved', '2025-11-15 04:31:45', '2025-11-15 04:31:45'),
(29, 107, 'You have a new project application.', 'You have a new project application', '2025-11-15 04:31:45', '2025-11-15 04:31:45'),
(30, 149, 'New project application', 'You have a new project application', '2025-11-15 04:35:33', '2025-11-15 04:35:33'),
(31, 107, 'You have a new project application.', 'You have a new project application', '2025-11-15 04:35:33', '2025-11-15 04:35:33'),
(32, 149, 'Application approved', 'Your application has been approved', '2025-11-15 04:36:20', '2025-11-15 04:36:20'),
(33, 107, 'You have a new project application.', 'You have a new project application', '2025-11-15 04:36:20', '2025-11-15 04:36:20'),
(34, 136, 'Application approved', 'Your application has been approved', '2025-11-20 16:02:26', '2025-11-20 16:02:26'),
(35, 107, 'You have a new project application.', 'You have a new project application', '2025-11-20 16:02:26', '2025-11-20 16:02:26');

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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `application_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(8,2) DEFAULT NULL,
  `paymentIntentId` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paymentStatus` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paymentDetails` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_transfer_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `application_id`, `amount`, `paymentIntentId`, `paymentStatus`, `paymentDetails`, `stripe_transfer_id`, `created_at`, `updated_at`) VALUES
(1, 122, 1, '100.00', 'pi_3RvuphJKuUaFK6VW1seUVOjo', 'succeeded', '{\"id\":\"pi_3RvuphJKuUaFK6VW1seUVOjo\",\"object\":\"payment_intent\",\"amount\":100,\"amount_capturable\":0,\"amount_details\":{\"tip\":[]},\"amount_received\":100,\"application\":null,\"application_fee_amount\":null,\"automatic_payment_methods\":{\"allow_redirects\":\"never\",\"enabled\":true},\"canceled_at\":null,\"cancellation_reason\":null,\"capture_method\":\"automatic_async\",\"client_secret\":\"pi_3RvuphJKuUaFK6VW1seUVOjo_secret_iHr9YlJb3L6bxw0Il7qfoWRqd\",\"confirmation_method\":\"automatic\",\"created\":1755153617,\"currency\":\"usd\",\"customer\":null,\"description\":null,\"last_payment_error\":null,\"latest_charge\":\"ch_3RvuphJKuUaFK6VW1GcETaKp\",\"livemode\":false,\"metadata\":[],\"next_action\":null,\"on_behalf_of\":null,\"payment_method\":\"pm_1RvupgJKuUaFK6VWKJ433zMF\",\"payment_method_configuration_details\":{\"id\":\"pmc_1R6XXIJKuUaFK6VW9hXGGlgH\",\"parent\":null},\"payment_method_options\":{\"card\":{\"installments\":null,\"mandate_options\":null,\"network\":null,\"request_three_d_secure\":\"automatic\"},\"link\":{\"persistent_token\":null}},\"payment_method_types\":[\"card\",\"link\"],\"processing\":null,\"receipt_email\":null,\"review\":null,\"setup_future_usage\":null,\"shipping\":null,\"source\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', NULL, '2025-08-14 06:40:18', '2025-08-14 06:40:18'),
(2, 122, 2, '2072.00', 'pi_3Rvuw4JKuUaFK6VW0XBGfKtm', 'succeeded', '{\"id\":\"pi_3Rvuw4JKuUaFK6VW0XBGfKtm\",\"object\":\"payment_intent\",\"amount\":2072,\"amount_capturable\":0,\"amount_details\":{\"tip\":[]},\"amount_received\":2072,\"application\":null,\"application_fee_amount\":null,\"automatic_payment_methods\":{\"allow_redirects\":\"never\",\"enabled\":true},\"canceled_at\":null,\"cancellation_reason\":null,\"capture_method\":\"automatic_async\",\"client_secret\":\"pi_3Rvuw4JKuUaFK6VW0XBGfKtm_secret_YuC3vBE88jhHvo7tQKWkxbMZd\",\"confirmation_method\":\"automatic\",\"created\":1755154012,\"currency\":\"usd\",\"customer\":null,\"description\":null,\"last_payment_error\":null,\"latest_charge\":\"ch_3Rvuw4JKuUaFK6VW0c2N1m69\",\"livemode\":false,\"metadata\":[],\"next_action\":null,\"on_behalf_of\":null,\"payment_method\":\"pm_1Rvuw3JKuUaFK6VWOiyWhtSX\",\"payment_method_configuration_details\":{\"id\":\"pmc_1R6XXIJKuUaFK6VW9hXGGlgH\",\"parent\":null},\"payment_method_options\":{\"card\":{\"installments\":null,\"mandate_options\":null,\"network\":null,\"request_three_d_secure\":\"automatic\"},\"link\":{\"persistent_token\":null}},\"payment_method_types\":[\"card\",\"link\"],\"processing\":null,\"receipt_email\":null,\"review\":null,\"setup_future_usage\":null,\"shipping\":null,\"source\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', NULL, '2025-08-14 06:46:53', '2025-08-14 06:46:53'),
(3, 122, 3, '20.72', 'pi_3Rvv2mJKuUaFK6VW1pdkKuP3', 'succeeded', '{\"id\":\"pi_3Rvv2mJKuUaFK6VW1pdkKuP3\",\"object\":\"payment_intent\",\"amount\":2072,\"amount_capturable\":0,\"amount_details\":{\"tip\":[]},\"amount_received\":2072,\"application\":null,\"application_fee_amount\":null,\"automatic_payment_methods\":{\"allow_redirects\":\"never\",\"enabled\":true},\"canceled_at\":null,\"cancellation_reason\":null,\"capture_method\":\"automatic_async\",\"client_secret\":\"pi_3Rvv2mJKuUaFK6VW1pdkKuP3_secret_LyGSkh7Pvo5xOBG9JeZVzfGJY\",\"confirmation_method\":\"automatic\",\"created\":1755154428,\"currency\":\"usd\",\"customer\":null,\"description\":null,\"last_payment_error\":null,\"latest_charge\":\"ch_3Rvv2mJKuUaFK6VW1upb8jrn\",\"livemode\":false,\"metadata\":[],\"next_action\":null,\"on_behalf_of\":null,\"payment_method\":\"pm_1Rvv2lJKuUaFK6VWoNde0lys\",\"payment_method_configuration_details\":{\"id\":\"pmc_1R6XXIJKuUaFK6VW9hXGGlgH\",\"parent\":null},\"payment_method_options\":{\"card\":{\"installments\":null,\"mandate_options\":null,\"network\":null,\"request_three_d_secure\":\"automatic\"},\"link\":{\"persistent_token\":null}},\"payment_method_types\":[\"card\",\"link\"],\"processing\":null,\"receipt_email\":null,\"review\":null,\"setup_future_usage\":null,\"shipping\":null,\"source\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', NULL, '2025-08-14 06:53:49', '2025-08-14 06:53:49'),
(4, 123, 3, '16.00', NULL, 'succeeded', NULL, 'tr_1Rvv7uJKuUaFK6VW8JxQ196Y', '2025-08-14 06:59:07', '2025-08-14 06:59:07'),
(5, 122, 3, '-16.00', NULL, 'succeeded', NULL, NULL, '2025-08-14 06:59:07', '2025-08-14 06:59:07'),
(6, 123, 2, '16.00', NULL, 'succeeded', NULL, 'tr_1Rvv8ZJKuUaFK6VWGwYQ8Jb7', '2025-08-14 06:59:48', '2025-08-14 06:59:48'),
(7, 122, 2, '-16.00', NULL, 'succeeded', NULL, NULL, '2025-08-14 06:59:48', '2025-08-14 06:59:48'),
(8, 123, 1, '25.00', NULL, 'succeeded', NULL, 'tr_1RvzkdJKuUaFK6VWAsSOXD2o', '2025-08-14 11:55:24', '2025-08-14 11:55:24'),
(9, 122, 1, '-25.00', NULL, 'succeeded', NULL, NULL, '2025-08-14 11:55:24', '2025-08-14 11:55:24'),
(10, 123, 1, '25.00', NULL, 'succeeded', NULL, 'tr_1RvzlsJKuUaFK6VWV3BMVbi6', '2025-08-14 11:56:41', '2025-08-14 11:56:41'),
(11, 122, 1, '-25.00', NULL, 'succeeded', NULL, NULL, '2025-08-14 11:56:41', '2025-08-14 11:56:41'),
(12, 122, 4, '1.58', 'pi_3RwcFvJKuUaFK6VW09r8373j', 'succeeded', '{\"id\":\"pi_3RwcFvJKuUaFK6VW09r8373j\",\"object\":\"payment_intent\",\"amount\":158,\"amount_capturable\":0,\"amount_details\":{\"tip\":[]},\"amount_received\":158,\"application\":null,\"application_fee_amount\":null,\"automatic_payment_methods\":{\"allow_redirects\":\"never\",\"enabled\":true},\"canceled_at\":null,\"cancellation_reason\":null,\"capture_method\":\"automatic_async\",\"client_secret\":\"pi_3RwcFvJKuUaFK6VW09r8373j_secret_JUsMRXoC7nmQjEEq7p8gs8Kyq\",\"confirmation_method\":\"automatic\",\"created\":1755320535,\"currency\":\"usd\",\"customer\":null,\"description\":null,\"excluded_payment_method_types\":null,\"last_payment_error\":null,\"latest_charge\":\"ch_3RwcFvJKuUaFK6VW09xX54Jj\",\"livemode\":false,\"metadata\":[],\"next_action\":null,\"on_behalf_of\":null,\"payment_method\":\"pm_1RwcFtJKuUaFK6VW6Ol4dQ2u\",\"payment_method_configuration_details\":{\"id\":\"pmc_1R6XXIJKuUaFK6VW9hXGGlgH\",\"parent\":null},\"payment_method_options\":{\"card\":{\"installments\":null,\"mandate_options\":null,\"network\":null,\"request_three_d_secure\":\"automatic\"},\"link\":{\"persistent_token\":null}},\"payment_method_types\":[\"card\",\"link\"],\"processing\":null,\"receipt_email\":null,\"review\":null,\"setup_future_usage\":null,\"shipping\":null,\"source\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', NULL, '2025-08-16 05:02:16', '2025-08-16 05:02:16'),
(13, 123, 4, '1.00', NULL, 'succeeded', NULL, 'tr_1RwcILJKuUaFK6VWWQRuCLlo', '2025-08-16 05:04:45', '2025-08-16 05:04:45'),
(14, 122, 4, '-1.00', NULL, 'succeeded', NULL, NULL, '2025-08-16 05:04:45', '2025-08-16 05:04:45'),
(15, 122, 5, '5.40', 'pi_3RwcPFJKuUaFK6VW1YaWLaY1', 'succeeded', '{\"id\":\"pi_3RwcPFJKuUaFK6VW1YaWLaY1\",\"object\":\"payment_intent\",\"amount\":540,\"amount_capturable\":0,\"amount_details\":{\"tip\":[]},\"amount_received\":540,\"application\":null,\"application_fee_amount\":null,\"automatic_payment_methods\":{\"allow_redirects\":\"never\",\"enabled\":true},\"canceled_at\":null,\"cancellation_reason\":null,\"capture_method\":\"automatic_async\",\"client_secret\":\"pi_3RwcPFJKuUaFK6VW1YaWLaY1_secret_jXD9OZf01n4EjhuJf2luWsLWg\",\"confirmation_method\":\"automatic\",\"created\":1755321113,\"currency\":\"usd\",\"customer\":null,\"description\":null,\"excluded_payment_method_types\":null,\"last_payment_error\":null,\"latest_charge\":\"ch_3RwcPFJKuUaFK6VW1yzDWZPU\",\"livemode\":false,\"metadata\":[],\"next_action\":null,\"on_behalf_of\":null,\"payment_method\":\"pm_1RwcPEJKuUaFK6VWpYuYQoZJ\",\"payment_method_configuration_details\":{\"id\":\"pmc_1R6XXIJKuUaFK6VW9hXGGlgH\",\"parent\":null},\"payment_method_options\":{\"card\":{\"installments\":null,\"mandate_options\":null,\"network\":null,\"request_three_d_secure\":\"automatic\"},\"link\":{\"persistent_token\":null}},\"payment_method_types\":[\"card\",\"link\"],\"processing\":null,\"receipt_email\":null,\"review\":null,\"setup_future_usage\":null,\"shipping\":null,\"source\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', NULL, '2025-08-16 05:11:55', '2025-08-16 05:11:55'),
(16, 123, 5, '4.00', NULL, 'succeeded', NULL, 'tr_1RwcRpJKuUaFK6VWWWuq0HuZ', '2025-08-16 05:14:34', '2025-08-16 05:14:34'),
(17, 122, 5, '-4.00', NULL, 'succeeded', NULL, NULL, '2025-08-16 05:14:34', '2025-08-16 05:14:34'),
(18, 122, 6, '1.58', 'pi_3RwcZmJKuUaFK6VW0wb7lqn3', 'succeeded', '{\"id\":\"pi_3RwcZmJKuUaFK6VW0wb7lqn3\",\"object\":\"payment_intent\",\"amount\":158,\"amount_capturable\":0,\"amount_details\":{\"tip\":[]},\"amount_received\":158,\"application\":null,\"application_fee_amount\":null,\"automatic_payment_methods\":{\"allow_redirects\":\"never\",\"enabled\":true},\"canceled_at\":null,\"cancellation_reason\":null,\"capture_method\":\"automatic_async\",\"client_secret\":\"pi_3RwcZmJKuUaFK6VW0wb7lqn3_secret_tQs16mJUXphZyHtSPMrlnAgRi\",\"confirmation_method\":\"automatic\",\"created\":1755321766,\"currency\":\"usd\",\"customer\":null,\"description\":null,\"excluded_payment_method_types\":null,\"last_payment_error\":null,\"latest_charge\":\"ch_3RwcZmJKuUaFK6VW0xa6NYl2\",\"livemode\":false,\"metadata\":[],\"next_action\":null,\"on_behalf_of\":null,\"payment_method\":\"pm_1RwcZkJKuUaFK6VWGQxI1efb\",\"payment_method_configuration_details\":{\"id\":\"pmc_1R6XXIJKuUaFK6VW9hXGGlgH\",\"parent\":null},\"payment_method_options\":{\"card\":{\"installments\":null,\"mandate_options\":null,\"network\":null,\"request_three_d_secure\":\"automatic\"},\"link\":{\"persistent_token\":null}},\"payment_method_types\":[\"card\",\"link\"],\"processing\":null,\"receipt_email\":null,\"review\":null,\"setup_future_usage\":null,\"shipping\":null,\"source\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', NULL, '2025-08-16 05:22:47', '2025-08-16 05:22:47'),
(19, 122, 7, '25.82', 'pi_3RwduaJKuUaFK6VW17TggyX0', 'succeeded', '{\"id\":\"pi_3RwduaJKuUaFK6VW17TggyX0\",\"object\":\"payment_intent\",\"amount\":2582,\"amount_capturable\":0,\"amount_details\":{\"tip\":[]},\"amount_received\":2582,\"application\":null,\"application_fee_amount\":null,\"automatic_payment_methods\":{\"allow_redirects\":\"never\",\"enabled\":true},\"canceled_at\":null,\"cancellation_reason\":null,\"capture_method\":\"automatic_async\",\"client_secret\":\"pi_3RwduaJKuUaFK6VW17TggyX0_secret_BsKtngoiV0MnNCFtbv4qXFf0b\",\"confirmation_method\":\"automatic\",\"created\":1755326900,\"currency\":\"usd\",\"customer\":null,\"description\":null,\"excluded_payment_method_types\":null,\"last_payment_error\":null,\"latest_charge\":\"ch_3RwduaJKuUaFK6VW1MqWcY7d\",\"livemode\":false,\"metadata\":[],\"next_action\":null,\"on_behalf_of\":null,\"payment_method\":\"pm_1RwduYJKuUaFK6VWmapXc4x3\",\"payment_method_configuration_details\":{\"id\":\"pmc_1R6XXIJKuUaFK6VW9hXGGlgH\",\"parent\":null},\"payment_method_options\":{\"card\":{\"installments\":null,\"mandate_options\":null,\"network\":null,\"request_three_d_secure\":\"automatic\"},\"link\":{\"persistent_token\":null}},\"payment_method_types\":[\"card\",\"link\"],\"processing\":null,\"receipt_email\":null,\"review\":null,\"setup_future_usage\":null,\"shipping\":null,\"source\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', NULL, '2025-08-16 06:48:21', '2025-08-16 06:48:21'),
(20, 122, 8, '127.90', 'pi_3RwdxvJKuUaFK6VW0iAHGx1B', 'succeeded', '{\"id\":\"pi_3RwdxvJKuUaFK6VW0iAHGx1B\",\"object\":\"payment_intent\",\"amount\":12790,\"amount_capturable\":0,\"amount_details\":{\"tip\":[]},\"amount_received\":12790,\"application\":null,\"application_fee_amount\":null,\"automatic_payment_methods\":{\"allow_redirects\":\"never\",\"enabled\":true},\"canceled_at\":null,\"cancellation_reason\":null,\"capture_method\":\"automatic_async\",\"client_secret\":\"pi_3RwdxvJKuUaFK6VW0iAHGx1B_secret_sgXaOjhPp5GZ69eASsQ9Fm90h\",\"confirmation_method\":\"automatic\",\"created\":1755327107,\"currency\":\"usd\",\"customer\":null,\"description\":null,\"excluded_payment_method_types\":null,\"last_payment_error\":null,\"latest_charge\":\"ch_3RwdxvJKuUaFK6VW0DLuw8gm\",\"livemode\":false,\"metadata\":[],\"next_action\":null,\"on_behalf_of\":null,\"payment_method\":\"pm_1RwdxtJKuUaFK6VWZkJvd6eP\",\"payment_method_configuration_details\":{\"id\":\"pmc_1R6XXIJKuUaFK6VW9hXGGlgH\",\"parent\":null},\"payment_method_options\":{\"card\":{\"installments\":null,\"mandate_options\":null,\"network\":null,\"request_three_d_secure\":\"automatic\"},\"link\":{\"persistent_token\":null}},\"payment_method_types\":[\"card\",\"link\"],\"processing\":null,\"receipt_email\":null,\"review\":null,\"setup_future_usage\":null,\"shipping\":null,\"source\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', NULL, '2025-08-16 06:51:48', '2025-08-16 06:51:48'),
(21, 123, 8, '100.00', NULL, 'succeeded', NULL, 'tr_1RwdyuJKuUaFK6VWVurI8eOI', '2025-08-16 06:52:48', '2025-08-16 06:52:48'),
(22, 122, 8, '-100.00', NULL, 'succeeded', NULL, NULL, '2025-08-16 06:52:48', '2025-08-16 06:52:48'),
(23, 107, 9, '1531.50', 'pi_3RxKWbJKuUaFK6VW0et8lCi4', 'succeeded', '{\"id\":\"pi_3RxKWbJKuUaFK6VW0et8lCi4\",\"object\":\"payment_intent\",\"amount\":153150,\"amount_capturable\":0,\"amount_details\":{\"tip\":[]},\"amount_received\":153150,\"application\":null,\"application_fee_amount\":null,\"automatic_payment_methods\":{\"allow_redirects\":\"never\",\"enabled\":true},\"canceled_at\":null,\"cancellation_reason\":null,\"capture_method\":\"automatic_async\",\"client_secret\":\"pi_3RxKWbJKuUaFK6VW0et8lCi4_secret_doPGkVcF5g0LvDN8UkpGii6YA\",\"confirmation_method\":\"automatic\",\"created\":1755490705,\"currency\":\"usd\",\"customer\":null,\"description\":null,\"excluded_payment_method_types\":null,\"last_payment_error\":null,\"latest_charge\":\"ch_3RxKWbJKuUaFK6VW0IdZaRvF\",\"livemode\":false,\"metadata\":[],\"next_action\":null,\"on_behalf_of\":null,\"payment_method\":\"pm_1RxKWaJKuUaFK6VWobJCTKPA\",\"payment_method_configuration_details\":{\"id\":\"pmc_1R6XXIJKuUaFK6VW9hXGGlgH\",\"parent\":null},\"payment_method_options\":{\"card\":{\"installments\":null,\"mandate_options\":null,\"network\":null,\"request_three_d_secure\":\"automatic\"},\"link\":{\"persistent_token\":null}},\"payment_method_types\":[\"card\",\"link\"],\"processing\":null,\"receipt_email\":null,\"review\":null,\"setup_future_usage\":null,\"shipping\":null,\"source\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', NULL, '2025-08-18 04:18:26', '2025-08-18 04:18:26'),
(24, 122, 10, '229.98', 'pi_3RziUwJKuUaFK6VW0sEefUGq', 'succeeded', '{\"id\":\"pi_3RziUwJKuUaFK6VW0sEefUGq\",\"object\":\"payment_intent\",\"amount\":22998,\"amount_capturable\":0,\"amount_details\":{\"tip\":[]},\"amount_received\":22998,\"application\":null,\"application_fee_amount\":null,\"automatic_payment_methods\":{\"allow_redirects\":\"never\",\"enabled\":true},\"canceled_at\":null,\"cancellation_reason\":null,\"capture_method\":\"automatic_async\",\"client_secret\":\"pi_3RziUwJKuUaFK6VW0sEefUGq_secret_AicOy9QuoCNcJzTeUQzpNiGGP\",\"confirmation_method\":\"automatic\",\"created\":1756059514,\"currency\":\"usd\",\"customer\":null,\"description\":null,\"excluded_payment_method_types\":null,\"last_payment_error\":null,\"latest_charge\":\"ch_3RziUwJKuUaFK6VW0IKfqDqk\",\"livemode\":false,\"metadata\":[],\"next_action\":null,\"on_behalf_of\":null,\"payment_method\":\"pm_1RziUuJKuUaFK6VWT3TY6jaC\",\"payment_method_configuration_details\":{\"id\":\"pmc_1R6XXIJKuUaFK6VW9hXGGlgH\",\"parent\":null},\"payment_method_options\":{\"card\":{\"installments\":null,\"mandate_options\":null,\"network\":null,\"request_three_d_secure\":\"automatic\"},\"link\":{\"persistent_token\":null}},\"payment_method_types\":[\"card\",\"link\"],\"processing\":null,\"receipt_email\":null,\"review\":null,\"setup_future_usage\":null,\"shipping\":null,\"source\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', NULL, '2025-08-24 18:18:35', '2025-08-24 18:18:35'),
(25, 129, 15, '638.30', 'pi_3S2a9NJKuUaFK6VW1n7YwRJv', 'succeeded', '{\"id\":\"pi_3S2a9NJKuUaFK6VW1n7YwRJv\",\"object\":\"payment_intent\",\"amount\":63830,\"amount_capturable\":0,\"amount_details\":{\"tip\":[]},\"amount_received\":63830,\"application\":null,\"application_fee_amount\":null,\"automatic_payment_methods\":{\"allow_redirects\":\"never\",\"enabled\":true},\"canceled_at\":null,\"cancellation_reason\":null,\"capture_method\":\"automatic_async\",\"client_secret\":\"pi_3S2a9NJKuUaFK6VW1n7YwRJv_secret_eAZWFJZjYocsQ4GoAE9EIqXvL\",\"confirmation_method\":\"automatic\",\"created\":1756742409,\"currency\":\"usd\",\"customer\":null,\"description\":null,\"excluded_payment_method_types\":null,\"last_payment_error\":null,\"latest_charge\":\"ch_3S2a9NJKuUaFK6VW1UvrV54l\",\"livemode\":false,\"metadata\":[],\"next_action\":null,\"on_behalf_of\":null,\"payment_method\":\"pm_1S2a9KJKuUaFK6VWUxhqlfYM\",\"payment_method_configuration_details\":{\"id\":\"pmc_1R6XXIJKuUaFK6VW9hXGGlgH\",\"parent\":null},\"payment_method_options\":{\"card\":{\"installments\":null,\"mandate_options\":null,\"network\":null,\"request_three_d_secure\":\"automatic\"},\"link\":{\"persistent_token\":null}},\"payment_method_types\":[\"card\",\"link\"],\"processing\":null,\"receipt_email\":null,\"review\":null,\"setup_future_usage\":null,\"shipping\":null,\"source\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', NULL, '2025-09-01 16:00:11', '2025-09-01 16:00:11'),
(26, 129, 16, '319.30', 'pi_3S2kPlJKuUaFK6VW1NwiLJGq', 'succeeded', '{\"id\":\"pi_3S2kPlJKuUaFK6VW1NwiLJGq\",\"object\":\"payment_intent\",\"amount\":31930,\"amount_capturable\":0,\"amount_details\":{\"tip\":[]},\"amount_received\":31930,\"application\":null,\"application_fee_amount\":null,\"automatic_payment_methods\":{\"allow_redirects\":\"never\",\"enabled\":true},\"canceled_at\":null,\"cancellation_reason\":null,\"capture_method\":\"automatic_async\",\"client_secret\":\"pi_3S2kPlJKuUaFK6VW1NwiLJGq_secret_BjiRKBxs1IEfifW5TbIJCbw44\",\"confirmation_method\":\"automatic\",\"created\":1756781865,\"currency\":\"usd\",\"customer\":null,\"description\":null,\"excluded_payment_method_types\":null,\"last_payment_error\":null,\"latest_charge\":\"ch_3S2kPlJKuUaFK6VW1OOUN6lR\",\"livemode\":false,\"metadata\":[],\"next_action\":null,\"on_behalf_of\":null,\"payment_method\":\"pm_1S2kPjJKuUaFK6VWpmzV5aLj\",\"payment_method_configuration_details\":{\"id\":\"pmc_1R6XXIJKuUaFK6VW9hXGGlgH\",\"parent\":null},\"payment_method_options\":{\"card\":{\"installments\":null,\"mandate_options\":null,\"network\":null,\"request_three_d_secure\":\"automatic\"},\"link\":{\"persistent_token\":null}},\"payment_method_types\":[\"card\",\"link\"],\"processing\":null,\"receipt_email\":null,\"review\":null,\"setup_future_usage\":null,\"shipping\":null,\"source\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', NULL, '2025-09-02 02:57:46', '2025-09-02 02:57:46'),
(27, 131, 17, '1.58', 'pi_3S3YFgJKuUaFK6VW0DhBq21N', 'succeeded', '{\"id\":\"pi_3S3YFgJKuUaFK6VW0DhBq21N\",\"object\":\"payment_intent\",\"amount\":158,\"amount_capturable\":0,\"amount_details\":{\"tip\":[]},\"amount_received\":158,\"application\":null,\"application_fee_amount\":null,\"automatic_payment_methods\":{\"allow_redirects\":\"never\",\"enabled\":true},\"canceled_at\":null,\"cancellation_reason\":null,\"capture_method\":\"automatic_async\",\"client_secret\":\"pi_3S3YFgJKuUaFK6VW0DhBq21N_secret_14Y5nxht9Qkd4ZJm7bkMg2Iie\",\"confirmation_method\":\"automatic\",\"created\":1756973440,\"currency\":\"usd\",\"customer\":null,\"description\":null,\"excluded_payment_method_types\":null,\"last_payment_error\":null,\"latest_charge\":\"ch_3S3YFgJKuUaFK6VW0aW7MsMm\",\"livemode\":false,\"metadata\":[],\"next_action\":null,\"on_behalf_of\":null,\"payment_method\":\"pm_1S3YFfJKuUaFK6VWtBBiUkoy\",\"payment_method_configuration_details\":{\"id\":\"pmc_1R6XXIJKuUaFK6VW9hXGGlgH\",\"parent\":null},\"payment_method_options\":{\"card\":{\"installments\":null,\"mandate_options\":null,\"network\":null,\"request_three_d_secure\":\"automatic\"},\"link\":{\"persistent_token\":null}},\"payment_method_types\":[\"card\",\"link\"],\"processing\":null,\"receipt_email\":null,\"review\":null,\"setup_future_usage\":null,\"shipping\":null,\"source\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', NULL, '2025-09-04 08:10:42', '2025-09-04 08:10:42'),
(28, 133, 18, '1531.50', 'pi_3S6UU0JKuUaFK6VW14KhkbMx', 'succeeded', '{\"id\":\"pi_3S6UU0JKuUaFK6VW14KhkbMx\",\"object\":\"payment_intent\",\"amount\":153150,\"amount_capturable\":0,\"amount_details\":{\"tip\":[]},\"amount_received\":153150,\"application\":null,\"application_fee_amount\":null,\"automatic_payment_methods\":{\"allow_redirects\":\"never\",\"enabled\":true},\"canceled_at\":null,\"cancellation_reason\":null,\"capture_method\":\"automatic_async\",\"client_secret\":\"pi_3S6UU0JKuUaFK6VW14KhkbMx_secret_SPUhfaZLyg0QxNPKPlLKUzG4B\",\"confirmation_method\":\"automatic\",\"created\":1757673936,\"currency\":\"usd\",\"customer\":null,\"description\":null,\"excluded_payment_method_types\":null,\"last_payment_error\":null,\"latest_charge\":\"ch_3S6UU0JKuUaFK6VW1BaVHBkP\",\"livemode\":false,\"metadata\":[],\"next_action\":null,\"on_behalf_of\":null,\"payment_method\":\"pm_1S6UTyJKuUaFK6VWQmW0CIQ4\",\"payment_method_configuration_details\":{\"id\":\"pmc_1R6XXIJKuUaFK6VW9hXGGlgH\",\"parent\":null},\"payment_method_options\":{\"card\":{\"installments\":null,\"mandate_options\":null,\"network\":null,\"request_three_d_secure\":\"automatic\"},\"link\":{\"persistent_token\":null}},\"payment_method_types\":[\"card\",\"link\"],\"processing\":null,\"receipt_email\":null,\"review\":null,\"setup_future_usage\":null,\"shipping\":null,\"source\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', NULL, '2025-09-12 10:45:37', '2025-09-12 10:45:37'),
(29, 134, 18, '1200.00', NULL, 'succeeded', NULL, 'tr_1S6UcYJKuUaFK6VWydZyFvNP', '2025-09-12 10:54:27', '2025-09-12 10:54:27'),
(30, 133, 18, '-1200.00', NULL, 'succeeded', NULL, NULL, '2025-09-12 10:54:27', '2025-09-12 10:54:27'),
(31, 131, 19, '1.58', 'pi_3S8emZJKuUaFK6VW13j1jn1e', 'succeeded', '{\"id\":\"pi_3S8emZJKuUaFK6VW13j1jn1e\",\"object\":\"payment_intent\",\"amount\":158,\"amount_capturable\":0,\"amount_details\":{\"tip\":[]},\"amount_received\":158,\"application\":null,\"application_fee_amount\":null,\"automatic_payment_methods\":{\"allow_redirects\":\"never\",\"enabled\":true},\"canceled_at\":null,\"cancellation_reason\":null,\"capture_method\":\"automatic_async\",\"client_secret\":\"pi_3S8emZJKuUaFK6VW13j1jn1e_secret_GdbWAJZdMgub8S5VBLqDZv2f2\",\"confirmation_method\":\"automatic\",\"created\":1758190183,\"currency\":\"usd\",\"customer\":null,\"description\":null,\"excluded_payment_method_types\":null,\"last_payment_error\":null,\"latest_charge\":\"ch_3S8emZJKuUaFK6VW1gs8gT6t\",\"livemode\":false,\"metadata\":[],\"next_action\":null,\"on_behalf_of\":null,\"payment_method\":\"pm_1S8emXJKuUaFK6VWmVoA2Eia\",\"payment_method_configuration_details\":{\"id\":\"pmc_1R6XXIJKuUaFK6VW9hXGGlgH\",\"parent\":null},\"payment_method_options\":{\"card\":{\"installments\":null,\"mandate_options\":null,\"network\":null,\"request_three_d_secure\":\"automatic\"},\"link\":{\"persistent_token\":null}},\"payment_method_types\":[\"card\",\"link\"],\"processing\":null,\"receipt_email\":null,\"review\":null,\"setup_future_usage\":null,\"shipping\":null,\"source\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', NULL, '2025-09-18 10:09:44', '2025-09-18 10:09:44'),
(32, 130, 19, '1.00', NULL, 'succeeded', NULL, 'tr_1S8epPJKuUaFK6VWstKM60RW', '2025-09-18 10:12:40', '2025-09-18 10:12:40'),
(33, 131, 19, '-1.00', NULL, 'succeeded', NULL, NULL, '2025-09-18 10:12:40', '2025-09-18 10:12:40'),
(34, 135, 21, '2041.90', 'pi_3SEjwqJKuUaFK6VW13sPrJaL', 'succeeded', '{\"id\":\"pi_3SEjwqJKuUaFK6VW13sPrJaL\",\"object\":\"payment_intent\",\"amount\":204190,\"amount_capturable\":0,\"amount_details\":{\"tip\":[]},\"amount_received\":204190,\"application\":null,\"application_fee_amount\":null,\"automatic_payment_methods\":{\"allow_redirects\":\"never\",\"enabled\":true},\"canceled_at\":null,\"cancellation_reason\":null,\"capture_method\":\"automatic_async\",\"client_secret\":\"pi_3SEjwqJKuUaFK6VW13sPrJaL_secret_LZCUgdUfxzNpBlCfJV38IMeCT\",\"confirmation_method\":\"automatic\",\"created\":1759640008,\"currency\":\"usd\",\"customer\":null,\"description\":null,\"excluded_payment_method_types\":null,\"last_payment_error\":null,\"latest_charge\":\"ch_3SEjwqJKuUaFK6VW1bRnr5Hj\",\"livemode\":false,\"metadata\":[],\"next_action\":null,\"on_behalf_of\":null,\"payment_method\":\"pm_1SEjwpJKuUaFK6VWpJYvFklT\",\"payment_method_configuration_details\":{\"id\":\"pmc_1R6XXIJKuUaFK6VW9hXGGlgH\",\"parent\":null},\"payment_method_options\":{\"card\":{\"installments\":null,\"mandate_options\":null,\"network\":null,\"request_three_d_secure\":\"automatic\"},\"link\":{\"persistent_token\":null}},\"payment_method_types\":[\"card\",\"link\"],\"processing\":null,\"receipt_email\":null,\"review\":null,\"setup_future_usage\":null,\"shipping\":null,\"source\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', NULL, '2025-10-05 04:53:30', '2025-10-05 04:53:30'),
(35, 131, 22, '319.30', 'pi_3SF6HhJKuUaFK6VW14BrXB1I', 'succeeded', '{\"id\":\"pi_3SF6HhJKuUaFK6VW14BrXB1I\",\"object\":\"payment_intent\",\"amount\":31930,\"amount_capturable\":0,\"amount_details\":{\"tip\":[]},\"amount_received\":31930,\"application\":null,\"application_fee_amount\":null,\"automatic_payment_methods\":{\"allow_redirects\":\"never\",\"enabled\":true},\"canceled_at\":null,\"cancellation_reason\":null,\"capture_method\":\"automatic_async\",\"client_secret\":\"pi_3SF6HhJKuUaFK6VW14BrXB1I_secret_R3tfgbnFtTnkpRArghxrK2zaM\",\"confirmation_method\":\"automatic\",\"created\":1759725869,\"currency\":\"usd\",\"customer\":null,\"description\":null,\"excluded_payment_method_types\":null,\"last_payment_error\":null,\"latest_charge\":\"ch_3SF6HhJKuUaFK6VW1pN38FJU\",\"livemode\":false,\"metadata\":[],\"next_action\":null,\"on_behalf_of\":null,\"payment_method\":\"pm_1SF6HgJKuUaFK6VWeCMVizT6\",\"payment_method_configuration_details\":{\"id\":\"pmc_1R6XXIJKuUaFK6VW9hXGGlgH\",\"parent\":null},\"payment_method_options\":{\"card\":{\"installments\":null,\"mandate_options\":null,\"network\":null,\"request_three_d_secure\":\"automatic\"},\"link\":{\"persistent_token\":null}},\"payment_method_types\":[\"card\",\"link\"],\"processing\":null,\"receipt_email\":null,\"review\":null,\"setup_future_usage\":null,\"shipping\":null,\"source\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', NULL, '2025-10-06 04:44:31', '2025-10-06 04:44:31'),
(36, 107, 14, '1531.50', 'pi_3SIqZpJKuUaFK6VW0jiWi2tB', 'succeeded', '{\"id\":\"pi_3SIqZpJKuUaFK6VW0jiWi2tB\",\"object\":\"payment_intent\",\"amount\":153150,\"amount_capturable\":0,\"amount_details\":{\"tip\":[]},\"amount_received\":153150,\"application\":null,\"application_fee_amount\":null,\"automatic_payment_methods\":{\"allow_redirects\":\"never\",\"enabled\":true},\"canceled_at\":null,\"cancellation_reason\":null,\"capture_method\":\"automatic_async\",\"client_secret\":\"pi_3SIqZpJKuUaFK6VW0jiWi2tB_secret_55OB2GQsxPpFqoGeN95KIv8nZ\",\"confirmation_method\":\"automatic\",\"created\":1760618801,\"currency\":\"usd\",\"customer\":null,\"description\":null,\"excluded_payment_method_types\":null,\"last_payment_error\":null,\"latest_charge\":\"ch_3SIqZpJKuUaFK6VW088mC1D5\",\"livemode\":false,\"metadata\":[],\"next_action\":null,\"on_behalf_of\":null,\"payment_method\":\"pm_1SIqZnJKuUaFK6VWaVUcsXZy\",\"payment_method_configuration_details\":{\"id\":\"pmc_1R6XXIJKuUaFK6VW9hXGGlgH\",\"parent\":null},\"payment_method_options\":{\"card\":{\"installments\":null,\"mandate_options\":null,\"network\":null,\"request_three_d_secure\":\"automatic\"},\"link\":{\"persistent_token\":null}},\"payment_method_types\":[\"card\",\"link\"],\"processing\":null,\"receipt_email\":null,\"review\":null,\"setup_future_usage\":null,\"shipping\":null,\"source\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', NULL, '2025-10-16 12:46:42', '2025-10-16 12:46:42'),
(37, 107, 26, '1.58', 'pi_3SIqwSJKuUaFK6VW0BPCMJ2l', 'succeeded', '{\"id\":\"pi_3SIqwSJKuUaFK6VW0BPCMJ2l\",\"object\":\"payment_intent\",\"amount\":158,\"amount_capturable\":0,\"amount_details\":{\"tip\":[]},\"amount_received\":158,\"application\":null,\"application_fee_amount\":null,\"automatic_payment_methods\":{\"allow_redirects\":\"never\",\"enabled\":true},\"canceled_at\":null,\"cancellation_reason\":null,\"capture_method\":\"automatic_async\",\"client_secret\":\"pi_3SIqwSJKuUaFK6VW0BPCMJ2l_secret_s9eWGq59oUVVIBuVFK5oCQFkO\",\"confirmation_method\":\"automatic\",\"created\":1760620204,\"currency\":\"usd\",\"customer\":null,\"description\":null,\"excluded_payment_method_types\":null,\"last_payment_error\":null,\"latest_charge\":\"ch_3SIqwSJKuUaFK6VW0HGUEeiA\",\"livemode\":false,\"metadata\":[],\"next_action\":null,\"on_behalf_of\":null,\"payment_method\":\"pm_1SIqwQJKuUaFK6VWxCMqGZ20\",\"payment_method_configuration_details\":{\"id\":\"pmc_1R6XXIJKuUaFK6VW9hXGGlgH\",\"parent\":null},\"payment_method_options\":{\"card\":{\"installments\":null,\"mandate_options\":null,\"network\":null,\"request_three_d_secure\":\"automatic\"},\"link\":{\"persistent_token\":null}},\"payment_method_types\":[\"card\",\"link\"],\"processing\":null,\"receipt_email\":null,\"review\":null,\"setup_future_usage\":null,\"shipping\":null,\"source\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', NULL, '2025-10-16 13:10:05', '2025-10-16 13:10:05'),
(38, 130, 26, '1.00', NULL, 'succeeded', NULL, 'tr_1SIqyYJKuUaFK6VW5VUJT68K', '2025-10-16 13:12:15', '2025-10-16 13:12:15'),
(39, 107, 26, '-1.00', NULL, 'succeeded', NULL, NULL, '2025-10-16 13:12:15', '2025-10-16 13:12:15'),
(40, 131, 23, '61.55', 'pi_3SMtc8JKuUaFK6VW0uHj25v7', 'succeeded', '{\"id\":\"pi_3SMtc8JKuUaFK6VW0uHj25v7\",\"object\":\"payment_intent\",\"amount\":6155,\"amount_capturable\":0,\"amount_details\":{\"tip\":[]},\"amount_received\":6155,\"application\":null,\"application_fee_amount\":null,\"automatic_payment_methods\":{\"allow_redirects\":\"never\",\"enabled\":true},\"canceled_at\":null,\"cancellation_reason\":null,\"capture_method\":\"automatic_async\",\"client_secret\":\"pi_3SMtc8JKuUaFK6VW0uHj25v7_secret_O2MN21ACUgaN8pHmTWKdE4b9b\",\"confirmation_method\":\"automatic\",\"created\":1761583788,\"currency\":\"usd\",\"customer\":null,\"description\":null,\"excluded_payment_method_types\":null,\"last_payment_error\":null,\"latest_charge\":\"ch_3SMtc8JKuUaFK6VW0JFY0YIq\",\"livemode\":false,\"metadata\":[],\"next_action\":null,\"on_behalf_of\":null,\"payment_method\":\"pm_1SMtc6JKuUaFK6VWSuA9TDlh\",\"payment_method_configuration_details\":{\"id\":\"pmc_1R6XXIJKuUaFK6VW9hXGGlgH\",\"parent\":null},\"payment_method_options\":{\"card\":{\"installments\":null,\"mandate_options\":null,\"network\":null,\"request_three_d_secure\":\"automatic\"},\"link\":{\"persistent_token\":null}},\"payment_method_types\":[\"card\",\"link\"],\"processing\":null,\"receipt_email\":null,\"review\":null,\"setup_future_usage\":null,\"shipping\":null,\"source\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', NULL, '2025-10-27 16:49:50', '2025-10-27 16:49:50'),
(41, 135, 28, '1021.10', 'pi_3SPcGwJKuUaFK6VW1LPGV4VJ', 'succeeded', '{\"id\":\"pi_3SPcGwJKuUaFK6VW1LPGV4VJ\",\"object\":\"payment_intent\",\"amount\":102110,\"amount_capturable\":0,\"amount_details\":{\"tip\":[]},\"amount_received\":102110,\"application\":null,\"application_fee_amount\":null,\"automatic_payment_methods\":{\"allow_redirects\":\"never\",\"enabled\":true},\"canceled_at\":null,\"cancellation_reason\":null,\"capture_method\":\"automatic_async\",\"client_secret\":\"pi_3SPcGwJKuUaFK6VW1LPGV4VJ_secret_MglyiyaaztjXAHo1SGjWbIAg6\",\"confirmation_method\":\"automatic\",\"created\":1762232110,\"currency\":\"usd\",\"customer\":null,\"description\":null,\"excluded_payment_method_types\":null,\"last_payment_error\":null,\"latest_charge\":\"ch_3SPcGwJKuUaFK6VW18bKd5Iv\",\"livemode\":false,\"metadata\":[],\"next_action\":null,\"on_behalf_of\":null,\"payment_method\":\"pm_1SPcGuJKuUaFK6VWRPCODQwU\",\"payment_method_configuration_details\":{\"id\":\"pmc_1R6XXIJKuUaFK6VW9hXGGlgH\",\"parent\":null},\"payment_method_options\":{\"card\":{\"installments\":null,\"mandate_options\":null,\"network\":null,\"request_three_d_secure\":\"automatic\"},\"link\":{\"persistent_token\":null}},\"payment_method_types\":[\"card\",\"link\"],\"processing\":null,\"receipt_email\":null,\"review\":null,\"setup_future_usage\":null,\"shipping\":null,\"source\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', NULL, '2025-11-04 04:55:11', '2025-11-04 04:55:11'),
(42, 135, 29, '1276.30', 'pi_3SRsipJKuUaFK6VW1GMRBD4V', 'succeeded', '{\"id\":\"pi_3SRsipJKuUaFK6VW1GMRBD4V\",\"object\":\"payment_intent\",\"amount\":127630,\"amount_capturable\":0,\"amount_details\":{\"tip\":[]},\"amount_received\":127630,\"application\":null,\"application_fee_amount\":null,\"automatic_payment_methods\":{\"allow_redirects\":\"never\",\"enabled\":true},\"canceled_at\":null,\"cancellation_reason\":null,\"capture_method\":\"automatic_async\",\"client_secret\":\"pi_3SRsipJKuUaFK6VW1GMRBD4V_secret_cC1gzRYz7pz2XaIx1MDlDComx\",\"confirmation_method\":\"automatic\",\"created\":1762771999,\"currency\":\"usd\",\"customer\":null,\"description\":null,\"excluded_payment_method_types\":null,\"last_payment_error\":null,\"latest_charge\":\"ch_3SRsipJKuUaFK6VW1bvqDFfB\",\"livemode\":false,\"metadata\":[],\"next_action\":null,\"on_behalf_of\":null,\"payment_method\":\"pm_1SRsioJKuUaFK6VWOxOuVPRG\",\"payment_method_configuration_details\":{\"id\":\"pmc_1R6XXIJKuUaFK6VW9hXGGlgH\",\"parent\":null},\"payment_method_options\":{\"card\":{\"installments\":null,\"mandate_options\":null,\"network\":null,\"request_three_d_secure\":\"automatic\"},\"link\":{\"persistent_token\":null}},\"payment_method_types\":[\"card\",\"link\"],\"processing\":null,\"receipt_email\":null,\"review\":null,\"setup_future_usage\":null,\"shipping\":null,\"source\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', NULL, '2025-11-10 10:53:20', '2025-11-10 10:53:20'),
(43, 107, 31, '1.58', 'pi_3STMayJKuUaFK6VW1JpXPLvs', 'succeeded', '{\"id\":\"pi_3STMayJKuUaFK6VW1JpXPLvs\",\"object\":\"payment_intent\",\"amount\":158,\"amount_capturable\":0,\"amount_details\":{\"tip\":[]},\"amount_received\":158,\"application\":null,\"application_fee_amount\":null,\"automatic_payment_methods\":{\"allow_redirects\":\"never\",\"enabled\":true},\"canceled_at\":null,\"cancellation_reason\":null,\"capture_method\":\"automatic_async\",\"client_secret\":\"pi_3STMayJKuUaFK6VW1JpXPLvs_secret_Cy8EU5RMUy2o5JIlU6IIYCeyM\",\"confirmation_method\":\"automatic\",\"created\":1763125160,\"currency\":\"usd\",\"customer\":null,\"description\":null,\"excluded_payment_method_types\":null,\"last_payment_error\":null,\"latest_charge\":\"ch_3STMayJKuUaFK6VW1mlU0boE\",\"livemode\":false,\"metadata\":[],\"next_action\":null,\"on_behalf_of\":null,\"payment_method\":\"pm_1STMawJKuUaFK6VW9z80kD0L\",\"payment_method_configuration_details\":{\"id\":\"pmc_1R6XXIJKuUaFK6VW9hXGGlgH\",\"parent\":null},\"payment_method_options\":{\"card\":{\"installments\":null,\"mandate_options\":null,\"network\":null,\"request_three_d_secure\":\"automatic\"},\"link\":{\"persistent_token\":null}},\"payment_method_types\":[\"card\",\"link\"],\"processing\":null,\"receipt_email\":null,\"review\":null,\"setup_future_usage\":null,\"shipping\":null,\"source\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', NULL, '2025-11-14 12:59:21', '2025-11-14 12:59:21'),
(44, 107, 32, '510.70', 'pi_3STb9IJKuUaFK6VW0d6CyFgT', 'succeeded', '{\"id\":\"pi_3STb9IJKuUaFK6VW0d6CyFgT\",\"object\":\"payment_intent\",\"amount\":51070,\"amount_capturable\":0,\"amount_details\":{\"tip\":[]},\"amount_received\":51070,\"application\":null,\"application_fee_amount\":null,\"automatic_payment_methods\":{\"allow_redirects\":\"never\",\"enabled\":true},\"canceled_at\":null,\"cancellation_reason\":null,\"capture_method\":\"automatic_async\",\"client_secret\":\"pi_3STb9IJKuUaFK6VW0d6CyFgT_secret_DGnlJNRyNCymNX42CVL2RC8Ap\",\"confirmation_method\":\"automatic\",\"created\":1763181104,\"currency\":\"usd\",\"customer\":null,\"description\":null,\"excluded_payment_method_types\":null,\"last_payment_error\":null,\"latest_charge\":\"ch_3STb9IJKuUaFK6VW05x7NaTf\",\"livemode\":false,\"metadata\":[],\"next_action\":null,\"on_behalf_of\":null,\"payment_method\":\"pm_1STb9FJKuUaFK6VWx3AMrEDc\",\"payment_method_configuration_details\":{\"id\":\"pmc_1R6XXIJKuUaFK6VW9hXGGlgH\",\"parent\":null},\"payment_method_options\":{\"card\":{\"installments\":null,\"mandate_options\":null,\"network\":null,\"request_three_d_secure\":\"automatic\"},\"link\":{\"persistent_token\":null}},\"payment_method_types\":[\"card\",\"link\"],\"processing\":null,\"receipt_email\":null,\"review\":null,\"setup_future_usage\":null,\"shipping\":null,\"source\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', NULL, '2025-11-15 04:31:45', '2025-11-15 04:31:45'),
(45, 107, 33, '255.50', 'pi_3STbDjJKuUaFK6VW0fUpw8og', 'succeeded', '{\"id\":\"pi_3STbDjJKuUaFK6VW0fUpw8og\",\"object\":\"payment_intent\",\"amount\":25550,\"amount_capturable\":0,\"amount_details\":{\"tip\":[]},\"amount_received\":25550,\"application\":null,\"application_fee_amount\":null,\"automatic_payment_methods\":{\"allow_redirects\":\"never\",\"enabled\":true},\"canceled_at\":null,\"cancellation_reason\":null,\"capture_method\":\"automatic_async\",\"client_secret\":\"pi_3STbDjJKuUaFK6VW0fUpw8og_secret_ZmjsWLuaG5HA280M03BTZBAYq\",\"confirmation_method\":\"automatic\",\"created\":1763181379,\"currency\":\"usd\",\"customer\":null,\"description\":null,\"excluded_payment_method_types\":null,\"last_payment_error\":null,\"latest_charge\":\"ch_3STbDjJKuUaFK6VW0VVhe24z\",\"livemode\":false,\"metadata\":[],\"next_action\":null,\"on_behalf_of\":null,\"payment_method\":\"pm_1STbDhJKuUaFK6VWZQUzqGei\",\"payment_method_configuration_details\":{\"id\":\"pmc_1R6XXIJKuUaFK6VW9hXGGlgH\",\"parent\":null},\"payment_method_options\":{\"card\":{\"installments\":null,\"mandate_options\":null,\"network\":null,\"request_three_d_secure\":\"automatic\"},\"link\":{\"persistent_token\":null}},\"payment_method_types\":[\"card\",\"link\"],\"processing\":null,\"receipt_email\":null,\"review\":null,\"setup_future_usage\":null,\"shipping\":null,\"source\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', NULL, '2025-11-15 04:36:20', '2025-11-15 04:36:20'),
(46, 107, 27, '1276.30', 'pi_3SVaJQJKuUaFK6VW1PVlvB0H', 'succeeded', '{\"id\":\"pi_3SVaJQJKuUaFK6VW1PVlvB0H\",\"object\":\"payment_intent\",\"amount\":127630,\"amount_capturable\":0,\"amount_details\":{\"tip\":[]},\"amount_received\":127630,\"application\":null,\"application_fee_amount\":null,\"automatic_payment_methods\":{\"allow_redirects\":\"never\",\"enabled\":true},\"canceled_at\":null,\"cancellation_reason\":null,\"capture_method\":\"automatic_async\",\"client_secret\":\"pi_3SVaJQJKuUaFK6VW1PVlvB0H_secret_7C7i5kbzo7qeZs3ozMPC43WZK\",\"confirmation_method\":\"automatic\",\"created\":1763654544,\"currency\":\"usd\",\"customer\":null,\"description\":null,\"excluded_payment_method_types\":null,\"last_payment_error\":null,\"latest_charge\":\"ch_3SVaJQJKuUaFK6VW1TyWDzVV\",\"livemode\":false,\"metadata\":[],\"next_action\":null,\"on_behalf_of\":null,\"payment_method\":\"pm_1SVaJOJKuUaFK6VWa3K7i3Aw\",\"payment_method_configuration_details\":{\"id\":\"pmc_1R6XXIJKuUaFK6VW9hXGGlgH\",\"parent\":null},\"payment_method_options\":{\"card\":{\"installments\":null,\"mandate_options\":null,\"network\":null,\"request_three_d_secure\":\"automatic\"},\"link\":{\"persistent_token\":null}},\"payment_method_types\":[\"card\",\"link\"],\"processing\":null,\"receipt_email\":null,\"review\":null,\"setup_future_usage\":null,\"shipping\":null,\"source\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', NULL, '2025-11-20 16:02:26', '2025-11-20 16:02:26');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view state', 'admin', NULL, '2022-08-28 05:40:38'),
(2, 'import state', 'admin', NULL, '2022-08-28 05:40:38'),
(3, 'view agency', 'admin', NULL, '2022-08-28 05:40:38'),
(4, 'create agency', 'admin', NULL, '2022-08-28 05:40:38'),
(5, 'edit agency', 'admin', NULL, '2022-08-28 05:40:38'),
(6, 'delete agency', 'admin', NULL, '2022-08-28 05:40:38'),
(7, 'view state agency category', 'admin', NULL, '2022-08-28 05:40:38'),
(8, 'create state agency category', 'admin', NULL, '2022-08-28 05:40:38'),
(9, 'edit state agency category', 'admin', NULL, '2022-08-28 05:40:38'),
(10, 'delete state agency category', 'admin', NULL, '2022-08-28 05:40:38'),
(11, 'view state agency state', 'admin', NULL, '2022-08-28 05:40:38'),
(12, 'update state agency state category', 'admin', NULL, '2022-08-28 05:40:38'),
(13, 'edit state agency state', 'admin', NULL, '2022-08-28 05:40:38'),
(14, 'delete state agency state', 'admin', NULL, '2022-08-28 05:40:38'),
(15, 'view state agency agency', 'admin', NULL, '2022-08-28 05:40:38'),
(16, 'update state agency agency category', 'admin', NULL, '2022-08-28 05:40:38'),
(17, 'edit state agency agency', 'admin', NULL, '2022-08-28 05:40:38'),
(18, 'delete state agency agency', 'admin', NULL, '2022-08-28 05:40:38'),
(19, 'view beneficiary category', 'admin', NULL, '2022-08-28 05:40:38'),
(20, 'create beneficiary category', 'admin', NULL, '2022-08-28 05:40:38'),
(21, 'edit beneficiary category', 'admin', NULL, '2022-08-28 05:40:38'),
(22, 'delete beneficiary category', 'admin', NULL, '2022-08-28 05:40:38'),
(23, 'view beneficiary', 'admin', NULL, '2022-08-28 05:40:38'),
(24, 'create beneficiary', 'admin', NULL, '2022-08-28 05:40:38'),
(25, 'edit beneficiary', 'admin', NULL, '2022-08-28 05:40:38'),
(26, 'delete beneficiary', 'admin', NULL, '2022-08-28 05:40:38'),
(27, 'view sector', 'admin', NULL, '2022-08-28 05:40:38'),
(28, 'create sector', 'admin', NULL, '2022-08-28 05:40:38'),
(29, 'edit sector', 'admin', NULL, '2022-08-28 05:40:38'),
(30, 'delete sector', 'admin', NULL, '2022-08-28 05:40:38'),
(31, 'view component', 'admin', NULL, NULL),
(32, 'create component', 'admin', NULL, NULL),
(33, 'edit component', 'admin', NULL, NULL),
(34, 'delete component', 'admin', NULL, NULL),
(35, 'view sub component', 'admin', NULL, NULL),
(36, 'create sub component', 'admin', NULL, NULL),
(37, 'edit sub component', 'admin', NULL, NULL),
(38, 'delete sub component', 'admin', NULL, NULL),
(39, 'view scheme', 'admin', NULL, NULL),
(40, 'create scheme', 'admin', NULL, NULL),
(41, 'edit scheme', 'admin', NULL, NULL),
(42, 'delete scheme', 'admin', NULL, NULL),
(43, 'view link scheme', 'admin', NULL, NULL),
(44, 'create link scheme', 'admin', NULL, NULL),
(45, 'edit link scheme', 'admin', NULL, NULL),
(46, 'delete link scheme', 'admin', NULL, NULL),
(47, 'view transfer mode', 'admin', NULL, NULL),
(48, 'create transfer mode', 'admin', NULL, NULL),
(49, 'edit transfer mode', 'admin', NULL, NULL),
(50, 'delete transfer mode', 'admin', NULL, NULL),
(51, 'view role', 'admin', NULL, NULL),
(52, 'create role', 'admin', NULL, NULL),
(53, 'edit role', 'admin', NULL, NULL),
(54, 'delete role', 'admin', NULL, NULL),
(55, 'view permission', 'admin', NULL, NULL),
(56, 'create permission', 'admin', NULL, NULL),
(57, 'edit permission', 'admin', NULL, NULL),
(58, 'delete permission', 'admin', NULL, NULL),
(59, 'view department', 'admin', NULL, NULL),
(60, 'create department', 'admin', NULL, NULL),
(61, 'edit department', 'admin', NULL, NULL),
(62, 'delete department', 'admin', NULL, NULL),
(63, 'view designation', 'admin', NULL, NULL),
(64, 'create designation', 'admin', NULL, NULL),
(65, 'edit designation', 'admin', NULL, NULL),
(66, 'delete designation', 'admin', NULL, NULL),
(67, 'view user', 'admin', NULL, NULL),
(68, 'create user', 'admin', NULL, NULL),
(69, 'edit user', 'admin', NULL, NULL),
(70, 'delete user', 'admin', NULL, NULL),
(71, 'view proposal', 'admin', NULL, NULL),
(72, 'create proposal', 'admin', NULL, NULL),
(73, 'edit proposal', 'admin', NULL, NULL),
(74, 'delete proposal', 'admin', NULL, NULL),
(75, 'view supporting document', 'admin', NULL, NULL),
(76, 'view pmc document', 'admin', NULL, NULL),
(77, 'view aamc document', 'admin', NULL, NULL),
(78, 'proposal submit to pmc', 'admin', NULL, NULL),
(79, 'proposal submit to aamc', 'admin', NULL, NULL),
(80, 'proposal accept or reject', 'admin', NULL, NULL),
(81, 'disburse', 'admin', NULL, NULL),
(82, 'view draft beneficiary', 'admin', NULL, '2022-08-28 05:40:38'),
(83, 'create draft beneficiary', 'admin', NULL, '2022-08-28 05:40:38'),
(84, 'edit draft beneficiary', 'admin', NULL, '2022-08-28 05:40:38'),
(85, 'delete draft beneficiary', 'admin', NULL, '2022-08-28 05:40:38'),
(86, 'view draft proposal', 'admin', NULL, '2022-08-28 05:40:38'),
(87, 'create draft proposal', 'admin', NULL, '2022-08-28 05:40:38'),
(88, 'edit draft proposal', 'admin', NULL, '2022-08-28 05:40:38'),
(89, 'delete draft proposal', 'admin', NULL, '2022-08-28 05:40:38'),
(93, 'proposal preview', 'admin', NULL, '2022-08-28 05:40:38'),
(94, 'beneficiary linking', 'admin', NULL, '2022-08-28 05:40:38'),
(95, 'financial standing', 'admin', NULL, '2022-08-28 05:40:38'),
(96, 'physical tracking', 'admin', NULL, '2022-08-28 05:40:38'),
(97, 'utilization certificate', 'admin', NULL, '2022-08-28 05:40:38'),
(102, 'upload utilization certificate', 'admin', NULL, '2022-08-28 05:40:38'),
(103, 'utilization certificate status change', 'admin', NULL, '2022-08-28 05:40:38'),
(104, 'delete proposal beneficiaries', 'admin', NULL, '2022-08-28 05:40:38'),
(105, 'edit unit and physical cost', 'admin', NULL, '2022-08-28 05:40:38');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `programming_languages`
--

CREATE TABLE `programming_languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `programming_languages`
--

INSERT INTO `programming_languages` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'PHP', 'Active', '2025-06-20 10:33:58', '2025-06-20 10:33:58'),
(2, 'Flutter', 'Active', '2025-06-20 10:34:05', '2025-06-20 10:34:05'),
(3, 'React.Js', 'Active', '2025-06-20 10:34:11', '2025-06-20 10:34:11'),
(4, 'NodeJs', 'Active', '2025-06-20 10:34:21', '2025-06-20 10:34:21'),
(5, 'HTML', 'Active', '2025-06-20 10:34:25', '2025-06-20 10:34:25'),
(6, 'Python', 'Active', '2025-06-20 10:34:30', '2025-06-20 10:34:46'),
(7, 'Node', 'Active', '2025-07-11 07:52:14', '2025-07-11 07:52:14'),
(8, 'JavaScript', 'Active', '2025-10-19 04:12:29', '2025-10-19 04:12:29'),
(9, 'TypeScript', 'Active', '2025-10-19 04:12:38', '2025-10-19 04:12:38'),
(10, 'Java', 'Active', '2025-10-19 04:13:11', '2025-10-19 04:13:11'),
(11, 'C#', 'Active', '2025-10-19 04:13:19', '2025-10-19 04:13:19'),
(12, 'C++', 'Active', '2025-10-19 04:13:25', '2025-10-19 04:13:25'),
(13, 'Ruby', 'Active', '2025-10-19 04:13:37', '2025-10-19 04:13:37'),
(14, 'Go', 'Active', '2025-10-19 04:13:44', '2025-10-19 04:13:44'),
(15, 'Swift', 'Active', '2025-10-19 04:13:51', '2025-10-19 04:13:51'),
(16, 'Kotlin', 'Active', '2025-10-19 04:13:58', '2025-10-19 04:13:58'),
(17, 'Dart', 'Active', '2025-10-19 04:14:04', '2025-10-19 04:14:04'),
(18, 'Rust', 'Active', '2025-10-19 04:14:12', '2025-10-19 04:14:12'),
(19, 'R', 'Active', '2025-10-19 04:14:20', '2025-10-19 04:14:20'),
(20, 'SQL', 'Active', '2025-10-19 04:14:33', '2025-10-19 04:14:33'),
(21, 'NoSQL', 'Active', '2025-10-19 04:14:39', '2025-10-19 04:14:39'),
(22, 'CSS', 'Active', '2025-10-19 04:14:50', '2025-10-19 04:14:50'),
(23, 'React', 'Active', '2025-10-19 04:14:57', '2025-10-19 04:14:57'),
(24, 'Next.js', 'Active', '2025-10-19 04:15:03', '2025-10-19 04:15:03'),
(25, 'Vue.js', 'Active', '2025-10-19 04:15:09', '2025-10-19 04:15:09'),
(26, 'Nuxt.js', 'Active', '2025-10-19 04:15:18', '2025-10-19 04:15:18'),
(27, 'Angular', 'Active', '2025-10-19 04:15:25', '2025-10-19 04:15:25'),
(28, 'Svelte', 'Active', '2025-10-19 04:15:30', '2025-10-19 04:15:30'),
(29, 'Node.js', 'Active', '2025-10-19 04:15:36', '2025-10-19 04:15:36'),
(30, 'Express.js', 'Active', '2025-10-19 04:15:40', '2025-10-19 04:15:40'),
(31, 'Django', 'Active', '2025-10-19 04:15:45', '2025-10-19 04:15:45'),
(32, 'Flask', 'Active', '2025-10-19 04:15:53', '2025-10-19 04:15:53'),
(33, 'FastAPI', 'Active', '2025-10-19 04:15:58', '2025-10-19 04:15:58'),
(34, 'Laravel', 'Active', '2025-10-19 04:16:04', '2025-10-19 04:16:04'),
(35, 'Spring Boot', 'Active', '2025-10-19 04:16:10', '2025-10-19 04:16:10'),
(36, 'Dot . NET Core', 'Active', '2025-10-19 04:16:15', '2025-11-06 06:48:09'),
(37, 'ASP.NET', 'Active', '2025-10-19 04:16:25', '2025-10-19 04:16:25'),
(38, 'Ruby on Rails', 'Active', '2025-10-19 04:16:30', '2025-10-19 04:16:30'),
(39, 'WordPress', 'Active', '2025-10-19 04:16:35', '2025-10-19 04:16:35'),
(40, 'Shopify', 'Active', '2025-10-19 04:16:40', '2025-10-19 04:16:40'),
(41, 'Magento', 'Active', '2025-10-19 04:16:47', '2025-10-19 04:16:47'),
(42, 'WooCommerce', 'Active', '2025-10-19 04:16:52', '2025-10-19 04:16:52'),
(43, 'Firebase', 'Active', '2025-10-19 04:16:57', '2025-10-19 04:16:57'),
(44, 'Supabase', 'Active', '2025-10-19 04:17:05', '2025-10-19 04:17:05'),
(45, 'AWS', 'Active', '2025-10-19 04:17:10', '2025-10-19 04:17:10'),
(46, 'Google Cloud', 'Active', '2025-10-19 04:17:15', '2025-10-19 04:17:15'),
(47, 'Microsoft Azure', 'Active', '2025-10-19 04:17:21', '2025-10-19 04:17:21'),
(48, 'DigitalOcean', 'Active', '2025-10-19 04:17:26', '2025-10-19 04:17:26'),
(49, 'Vercel', 'Active', '2025-10-19 04:17:47', '2025-10-19 04:17:47'),
(50, 'Netlify', 'Active', '2025-10-19 04:17:52', '2025-10-19 04:17:52'),
(51, 'Docker', 'Active', '2025-10-19 04:17:57', '2025-10-19 04:17:57'),
(52, 'Kubernetes', 'Active', '2025-10-19 04:18:02', '2025-10-19 04:18:02'),
(53, 'Git', 'Active', '2025-10-19 04:18:08', '2025-10-19 04:18:08'),
(54, 'GitHub', 'Active', '2025-10-19 04:18:13', '2025-10-19 04:18:13'),
(55, 'GitLab', 'Active', '2025-10-19 04:18:18', '2025-10-19 04:18:18'),
(56, 'Bitbucket', 'Active', '2025-10-19 04:18:22', '2025-10-19 04:18:22'),
(57, 'PostgreSQL', 'Active', '2025-10-19 04:18:27', '2025-10-19 04:18:27'),
(58, 'MySQL', 'Active', '2025-10-19 04:18:34', '2025-10-19 04:18:34'),
(59, 'MongoDB', 'Active', '2025-10-19 04:18:39', '2025-10-19 04:18:39'),
(60, 'Redis', 'Active', '2025-10-19 04:18:44', '2025-10-19 04:18:44'),
(61, 'Elasticsearch', 'Active', '2025-10-19 04:18:50', '2025-10-19 04:18:50'),
(62, 'GraphQL', 'Active', '2025-10-19 04:18:55', '2025-10-19 04:18:55'),
(63, 'REST API', 'Active', '2025-10-19 04:19:02', '2025-10-19 04:19:02'),
(64, 'WebSockets', 'Active', '2025-10-19 04:19:09', '2025-10-19 04:19:09'),
(65, 'Tailwind CSS', 'Active', '2025-10-19 04:19:22', '2025-10-19 04:19:22'),
(66, 'Bootstrap', 'Active', '2025-10-19 04:19:31', '2025-10-19 04:19:31'),
(67, 'Material UI', 'Active', '2025-10-19 04:19:39', '2025-10-19 04:19:39'),
(68, 'Chakra UI', 'Active', '2025-10-19 04:19:45', '2025-10-19 04:19:45'),
(69, 'Framer Motion', 'Active', '2025-10-19 04:19:51', '2025-10-19 04:19:51'),
(70, 'Three.js', 'Active', '2025-10-19 04:19:57', '2025-10-19 04:19:57'),
(71, 'Unity', 'Active', '2025-10-19 04:20:05', '2025-10-19 04:20:05'),
(72, 'Unreal Engine', 'Active', '2025-10-19 04:20:11', '2025-10-19 04:20:11'),
(73, 'Blender', 'Active', '2025-10-19 04:20:16', '2025-10-19 04:20:16'),
(74, 'Figma', 'Active', '2025-10-19 04:20:20', '2025-10-19 04:20:20'),
(75, 'Adobe XD', 'Active', '2025-10-19 04:20:25', '2025-10-19 04:20:25'),
(76, 'Adobe Photoshop', 'Active', '2025-10-19 04:20:31', '2025-10-19 04:20:31'),
(77, 'Illustrator', 'Active', '2025-10-19 04:20:35', '2025-10-19 04:20:35'),
(78, 'After Effects', 'Active', '2025-10-19 04:20:41', '2025-10-19 04:20:41'),
(79, 'Premiere Pro', 'Active', '2025-10-19 04:20:46', '2025-10-19 04:20:46'),
(80, 'Canva', 'Active', '2025-10-19 04:20:50', '2025-10-19 04:20:50'),
(81, 'UI/UX Design', 'Active', '2025-10-19 04:20:58', '2025-10-19 04:20:58'),
(82, 'Product Design', 'Active', '2025-10-19 04:21:03', '2025-10-19 04:21:03'),
(83, 'Mobile App Design', 'Active', '2025-10-19 04:21:09', '2025-10-19 04:21:09'),
(84, 'Web Design', 'Active', '2025-10-19 04:21:18', '2025-10-19 04:21:18'),
(85, 'React Native', 'Active', '2025-10-19 04:21:31', '2025-10-19 04:21:31'),
(86, 'Ionic', 'Active', '2025-10-19 04:21:38', '2025-10-19 04:21:38'),
(87, 'SwiftUI', 'Active', '2025-10-19 04:21:44', '2025-10-19 04:21:44'),
(88, 'Objective-C', 'Active', '2025-10-19 04:21:49', '2025-10-19 04:21:49'),
(89, 'Android SDK', 'Active', '2025-10-19 04:21:54', '2025-10-19 04:21:54'),
(90, 'Machine Learning', 'Active', '2025-10-19 04:22:00', '2025-10-19 04:22:00'),
(91, 'Deep Learning', 'Active', '2025-10-19 04:22:05', '2025-10-19 04:22:05'),
(92, 'Computer Vision', 'Active', '2025-10-19 04:22:10', '2025-10-19 04:22:10'),
(93, 'Natural Language Processing', 'Active', '2025-10-19 04:22:19', '2025-10-19 04:22:19'),
(94, 'TensorFlow', 'Active', '2025-10-19 04:22:26', '2025-10-19 04:22:26'),
(95, 'PyTorch', 'Active', '2025-10-19 04:22:34', '2025-10-19 04:22:34'),
(96, 'Scikit-learn', 'Active', '2025-10-19 04:22:39', '2025-10-19 04:22:39'),
(97, 'OpenCV', 'Active', '2025-10-19 04:22:46', '2025-10-19 04:22:46'),
(98, 'Data Science', 'Active', '2025-10-19 04:22:51', '2025-10-19 04:22:51'),
(99, 'Data Engineering', 'Active', '2025-10-19 04:22:55', '2025-10-19 04:22:55'),
(100, 'Big Data', 'Active', '2025-10-19 04:23:00', '2025-10-19 04:23:00'),
(101, 'Apache Spark', 'Active', '2025-10-19 04:23:08', '2025-10-19 04:23:08'),
(102, 'Hadoop', 'Active', '2025-10-19 04:23:13', '2025-10-19 04:23:13'),
(103, 'Power BI', 'Active', '2025-10-19 04:23:21', '2025-10-19 04:23:21'),
(104, 'Tableau', 'Active', '2025-10-19 04:23:26', '2025-10-19 04:23:26'),
(105, 'Looker', 'Active', '2025-10-19 04:23:30', '2025-10-19 04:23:30'),
(106, 'Salesforce', 'Active', '2025-10-19 04:23:35', '2025-10-19 04:23:35'),
(107, 'HubSpot', 'Active', '2025-10-19 04:23:40', '2025-10-19 04:23:40'),
(108, 'Jira', 'Active', '2025-10-19 04:23:56', '2025-10-19 04:23:56'),
(109, 'Trello', 'Active', '2025-10-19 04:24:01', '2025-10-19 04:24:01'),
(110, 'Asana', 'Active', '2025-10-19 04:24:06', '2025-10-19 04:24:06'),
(111, 'DevOps', 'Active', '2025-10-19 04:24:23', '2025-10-19 04:24:23'),
(112, 'Web3.js', 'Active', '2025-10-19 04:24:29', '2025-10-19 04:24:29'),
(113, 'Blockchain', 'Active', '2025-10-19 04:24:36', '2025-10-19 04:24:36');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `budget` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `user_id`, `category_id`, `title`, `slug`, `description`, `status`, `budget`, `attachment`, `tags`, `created_at`, `updated_at`) VALUES
(1, 122, 1, 'Node JS Developer Required Update', 'node-js-developer-required-update', 'Description of the project&nbsp;', 'Pending', '20', NULL, NULL, '2025-08-14 06:22:08', '2025-08-14 06:22:36'),
(2, 122, 1, 'PHP Developer Needed', 'php-developer-needed', 'Description', NULL, '10', NULL, 'Tag', '2025-08-14 06:44:53', '2025-08-14 06:44:53'),
(3, 122, 2, 'React JS', 'react-js', 'Description', NULL, '10', NULL, 'tag', '2025-08-14 06:49:19', '2025-08-14 06:49:19'),
(5, 122, 1, 'Data Engineer', 'data-engineer', 'Hello Data Engineer,', NULL, '10', NULL, 'AWs,bigdata', '2025-08-16 04:58:31', '2025-08-16 04:58:49'),
(6, 122, 1, 'Data Engineer2', 'data-engineer2', 'Test Data 2', NULL, '2', NULL, 'big', '2025-08-16 05:09:30', '2025-08-16 05:09:30'),
(7, 122, 1, 'tets2', 'tets2', 'trtr', 'Active', '10', NULL, 'dd', '2025-08-16 05:22:03', '2025-08-16 05:22:03'),
(8, 122, 1, 'Data Engineer Test', 'data-engineer-test', 'Abc', 'Active', '10', NULL, 'ran', '2025-08-16 06:27:37', '2025-08-16 06:27:37'),
(9, 122, 1, 'Test54', 'test54', 'dd', NULL, '10', NULL, 'dd', '2025-08-16 06:38:06', '2025-08-16 06:38:06'),
(10, 107, 1, 'Ecommerce Website', 'ecommerce-website', 'New Projects Unleashed', NULL, '1000', NULL, 'laravel', '2025-08-18 04:16:49', '2025-08-18 04:16:49'),
(11, 107, 2, 'Data Entry', 'data-entry', 'Description', NULL, '50', NULL, 'tag', '2025-08-23 12:57:34', '2025-08-23 12:57:34'),
(13, 122, 2, 'HTML Designer', 'html-designer', 'Description', NULL, '10', NULL, 'Tag1', '2025-08-24 18:29:28', '2025-08-24 18:29:28'),
(14, 107, 2, 'PHP Developer Required', 'php-developer-required', 'Description', NULL, '10', NULL, 'tag', '2025-09-01 11:12:33', '2025-09-01 11:12:33'),
(15, 129, 1, 'Need a UI/UX Designer', 'need-a-uiux-designer', 'I\'m looking from someone who\'s experience in UI/UX and stay up-to-date with industry standard. What someone know how to design&nbsp; an e-commerce.', 'Active', '400', NULL, 'Web Developer,UI/UX,HTML,CSS,BootStrap,JavaScript', '2025-09-01 13:15:23', '2025-09-01 13:15:23'),
(16, 129, 1, 'Devlog', 'devlog', 'Want to create a front-end for my site', 'Inactive', '300', NULL, 'Webdev,PHP,HTML,JavaScripty,CSS', '2025-09-02 02:54:04', '2025-09-02 02:54:30'),
(17, 131, 1, 'AWS Migration from Onprem', 'aws-migration-from-onprem', 'Please apply if intrested.', 'Active', '1', NULL, 'AWS,Data Engineer', '2025-09-04 08:03:34', '2025-09-04 08:03:34'),
(18, 133, 1, 'React Website', 'react-website', 'Optimize power consumption at your swap station by slow charging batteries in the night and keep them ready for utilisation at peak hours, reducing peak demand on the grid and increasing battery life.<br><br><div class=\"col-lg-4 col-md-4 col-sm-12 OneBattery_single_box\" style=\"padding-right: 12px; padding-left: 12px; position: relative; width: 380px; max-width: 100%; color: rgb(33, 37, 41); font-family: system-ui, -apple-system, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, &quot;Noto Sans&quot;, &quot;Liberation Sans&quot;, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; font-size: 16px; letter-spacing: normal; background-color: rgb(2, 2, 10);\"><h3 style=\"margin-top: 16px; margin-bottom: 16px; line-height: 37px; font-size: 28px; color: rgb(252, 252, 252); font-family: Lufga500; letter-spacing: -0.01em;\">&nbsp;Battery Insights</h3><p style=\"margin-bottom: 0px; color: rgb(187, 187, 188); font-family: Manrope, sans-serif; font-size: 16px; line-height: 24px;\">Get alerts on battery temperature, current, voltage, state of charge and health monitoring.​</p></div><div class=\"col-lg-4 col-md-4 col-sm-12 OneBattery_single_box\" style=\"padding-right: 12px; padding-left: 12px; position: relative; width: 380px; max-width: 100%; color: rgb(33, 37, 41); font-family: system-ui, -apple-system, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, &quot;Noto Sans&quot;, &quot;Liberation Sans&quot;, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; font-size: 16px; letter-spacing: normal; background-color: rgb(2, 2, 10);\"><img src=\"https://race.energy/static/media/onebattery3.284fee5eb06a5e89b69c.png\" alt=\"img\" loading=\"lazy\" class=\"img-fluid OneBattery_single_box_img_three\" style=\"width: 339px !important;\"><h3 style=\"margin-top: 16px; margin-bottom: 16px; line-height: 37px; font-size: 28px; color: rgb(252, 252, 252); font-family: Lufga500; letter-spacing: -0.01em;\">Seamless &amp; Automatic Swap​​</h3><p style=\"margin-bottom: 0px; color: rgb(187, 187, 188); font-family: Manrope, sans-serif; font-size: 16px; line-height: 24px;\">Swap batteries in seconds, make cashless payments and leave battery maintenance to us.</p></div>', NULL, '1000', NULL, 'react,nodejs', '2025-09-12 09:37:01', '2025-09-12 09:37:01'),
(19, 131, 1, 'AWS Test Now', 'aws-test-now', 'Hello this is a test project.,&nbsp;', NULL, '101', NULL, 'fsf,sfsf,sf,s', '2025-09-18 10:06:07', '2025-09-18 10:06:07'),
(20, 131, 2, 'AWS nooon', 'aws-nooon', 'fhfhfh', NULL, '22', NULL, NULL, '2025-09-18 10:14:51', '2025-09-18 10:14:51'),
(21, 135, 2, 'AI Customer Support Bot', 'ai-customer-support-bot', 'Build an AI-powered chatbot for customer service that integrates with WhatsApp and website chat widgets. Should answer FAQs and escalate to a human when needed.', NULL, '800', NULL, NULL, '2025-10-05 02:53:05', '2025-10-05 02:53:05'),
(22, 131, 2, 'Web Development', 'web-development', 'Test: I need to create a website to the my small store', NULL, '700', NULL, 'WebDevelopment,website', '2025-10-06 04:34:25', '2025-10-06 04:34:25'),
(23, 107, 2, 'Human Test', 'human-test', '<p>Hellofsf</p><p><br></p>', NULL, '1', NULL, 'f,\\sf', '2025-10-16 12:50:50', '2025-10-16 12:50:50'),
(24, 135, 9, 'AI Test', 'ai-test', 'Test', NULL, '4000', NULL, NULL, '2025-11-04 04:43:09', '2025-11-04 04:43:09'),
(25, 135, 29, 'Test 45', 'test-45', 'test', NULL, '100', NULL, NULL, '2025-11-04 05:27:35', '2025-11-04 05:27:35'),
(26, 107, 20, 'Title of the project', 'title-of-the-project', 'Description', 'Active', '20', NULL, 'tag1,tag2', '2025-11-06 06:37:58', '2025-11-06 06:37:58'),
(27, 107, 33, 'New testing project', 'new-testing-project', 'Description', 'Active', '30', NULL, 'tag3', '2025-11-06 06:38:51', '2025-11-06 06:38:51'),
(28, 131, 28, 'Test porject', 'test-porject', 'dfdfdf', 'Active', NULL, NULL, 'rwr,wrw,\\wrw', '2025-11-06 11:58:11', '2025-11-06 11:58:11'),
(29, 139, 47, 'Test764', 'test764', 'test AWS', 'Active', '400', NULL, NULL, '2025-11-07 07:23:19', '2025-11-07 07:23:19'),
(30, 135, 9, 'Test583', 'test583', 'Test web app', 'Active', NULL, NULL, NULL, '2025-11-07 07:42:50', '2025-11-07 07:42:50'),
(31, 110, 20, 'Test Ecommerce', 'test-ecommerce', 'Test&nbsp;', 'Active', NULL, NULL, NULL, '2025-11-08 05:13:28', '2025-11-08 05:13:28'),
(32, 107, 33, 'Ecommerce Website', 'ecommerce-website-php', 'Tesyt Urgent', 'Active', NULL, NULL, 'php', '2025-11-09 07:04:07', '2025-11-09 07:04:07'),
(33, 110, 9, 'adsf', 'adsf', 'adsf', 'Inactive', NULL, NULL, NULL, '2025-11-09 08:56:51', '2025-11-09 08:56:51'),
(34, 110, 20, 'sdaf', 'sdaf', 'ads', 'Inactive', NULL, NULL, NULL, '2025-11-09 10:11:41', '2025-11-09 10:11:41'),
(35, 135, 46, 'test Github', 'test-github', 'test', 'Active', '800', NULL, NULL, '2025-11-10 10:46:03', '2025-11-10 10:46:03'),
(36, 145, 33, 'Laravel Website', 'laravel-website', 'Test', 'Active', NULL, NULL, 'php', '2025-11-13 16:49:28', '2025-11-13 16:49:28'),
(37, 107, 9, 'asdf', 'asdf', 'ads', 'Inactive', '10', NULL, NULL, '2025-11-14 12:27:35', '2025-11-14 12:27:35');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'SuperAdmin', 'superadmin', 'Active', '2022-08-27 14:53:27', '2022-08-27 16:07:11'),
(2, 'Admin', 'admin', 'Active', '2022-08-27 14:54:02', '2022-09-15 13:10:16'),
(3, 'Employee', 'employee', 'Active', '2022-08-28 02:39:46', '2023-09-13 11:18:24');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `category_id`, `name`, `image`, `link`, `location`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'Sub Category', '/images/sub-category/169773658758407.jpg', '#', '', '', '2023-10-19 17:29:47', '2023-10-19 17:37:02');

-- --------------------------------------------------------

--
-- Table structure for table `technologies`
--

CREATE TABLE `technologies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `technologies`
--

INSERT INTO `technologies` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Web Development', 'Active', '2025-06-20 10:32:07', '2025-06-20 10:32:07'),
(2, 'App Development', 'Active', '2025-06-20 10:32:12', '2025-06-20 10:32:12'),
(3, 'Frontend Development', 'Active', '2025-10-17 10:10:22', '2025-10-17 10:10:22'),
(4, 'Backend Development', 'Active', '2025-10-17 10:10:22', '2025-10-17 10:10:22'),
(5, 'Full Stack Development', 'Active', '2025-10-17 10:10:22', '2025-10-17 10:10:22'),
(6, 'Mobile App Development', 'Active', '2025-10-17 10:10:22', '2025-10-17 10:10:22'),
(7, 'Android App Development', 'Active', '2025-10-17 10:10:22', '2025-10-17 10:10:22'),
(8, 'iOS App Development', 'Active', '2025-10-17 10:10:22', '2025-10-17 10:10:22'),
(9, 'Flutter Development', 'Active', '2025-10-17 10:10:22', '2025-10-17 10:10:22'),
(10, 'React Native Development', 'Active', '2025-10-17 10:10:22', '2025-10-17 10:10:22'),
(11, 'Next.js Development', 'Active', '2025-10-17 10:10:22', '2025-10-17 10:10:22'),
(12, 'Vue.js Development', 'Active', '2025-10-17 10:10:22', '2025-10-17 10:10:22'),
(13, 'Angular Development', 'Active', '2025-10-17 10:10:22', '2025-10-17 10:10:22'),
(14, 'Node.js Development', 'Active', '2025-10-17 10:10:22', '2025-10-17 10:10:22'),
(15, 'Express.js Development', 'Active', '2025-10-17 10:10:22', '2025-10-17 10:10:22'),
(16, 'Django Development', 'Active', '2025-10-17 10:10:22', '2025-10-17 10:10:22'),
(17, 'Flask Development', 'Active', '2025-10-17 10:10:22', '2025-10-17 10:10:22'),
(18, 'FastAPI Development', 'Active', '2025-10-17 10:10:22', '2025-10-17 10:10:22'),
(19, 'Laravel Development', 'Active', '2025-10-17 10:10:22', '2025-10-17 10:10:22'),
(20, 'Spring Boot Development', 'Active', '2025-10-17 10:10:22', '2025-10-17 10:10:22'),
(21, '.NET Core Development', 'Active', '2025-10-17 10:10:22', '2025-10-17 10:10:22'),
(22, 'WordPress Development', 'Active', '2025-10-17 10:10:22', '2025-10-17 10:10:22'),
(23, 'Shopify Development', 'Active', '2025-10-17 10:10:22', '2025-10-17 10:10:22'),
(24, 'Magento Development', 'Active', '2025-10-17 10:10:22', '2025-10-17 10:10:22'),
(25, 'E-commerce Development', 'Active', '2025-10-17 10:10:22', '2025-10-17 10:10:22'),
(26, 'API Development', 'Active', '2025-10-17 10:10:22', '2025-10-17 10:10:22'),
(27, 'REST API', 'Active', '2025-10-17 10:10:23', '2025-10-17 10:10:23'),
(28, 'GraphQL', 'Active', '2025-10-17 10:10:23', '2025-10-17 10:10:23'),
(29, 'Database Development', 'Active', '2025-10-17 10:10:23', '2025-10-17 10:10:23'),
(30, 'MySQL', 'Active', '2025-10-17 10:10:23', '2025-10-17 10:10:23'),
(31, 'PostgreSQL', 'Active', '2025-10-17 10:10:23', '2025-10-17 10:10:23'),
(32, 'MongoDB', 'Active', '2025-10-17 10:10:23', '2025-10-17 10:10:23'),
(33, 'Redis', 'Active', '2025-10-17 10:10:23', '2025-10-17 10:10:23'),
(34, 'Firebase', 'Active', '2025-10-17 10:10:23', '2025-10-17 10:10:23'),
(35, 'AWS', 'Active', '2025-10-17 10:10:23', '2025-10-17 10:10:23'),
(36, 'Google Cloud', 'Active', '2025-10-17 10:10:23', '2025-10-17 10:10:23'),
(37, 'Microsoft Azure', 'Active', '2025-10-17 10:10:23', '2025-10-17 10:10:23'),
(38, 'Docker', 'Active', '2025-10-17 10:10:23', '2025-10-17 10:10:23'),
(39, 'Kubernetes', 'Active', '2025-10-17 10:10:23', '2025-10-17 10:10:23'),
(40, 'CI/CD Pipelines', 'Active', '2025-10-17 10:10:23', '2025-10-17 10:10:23'),
(41, 'DevOps Engineering', 'Active', '2025-10-17 10:10:23', '2025-10-17 10:10:23'),
(42, 'Cloud Architecture', 'Active', '2025-10-17 10:10:23', '2025-10-17 10:10:23'),
(43, 'SaaS Development', 'Active', '2025-10-17 10:10:23', '2025-10-17 10:10:23'),
(44, 'Progressive Web App (PWA) Development', 'Active', '2025-10-17 10:10:23', '2025-10-17 10:10:23'),
(45, 'Hybrid App Development', 'Active', '2025-10-17 10:10:23', '2025-10-17 10:10:23'),
(46, 'Automation & Scripting', 'Active', '2025-10-17 10:10:23', '2025-10-17 10:10:23'),
(47, 'Web App Development', 'Active', '2025-10-17 10:10:23', '2025-10-17 10:10:23'),
(48, 'Landing Page Development', 'Active', '2025-10-17 10:10:23', '2025-10-17 10:10:23'),
(49, 'Backend as a Service (BaaS)', 'Active', '2025-10-17 10:10:23', '2025-10-17 10:10:23'),
(50, 'Microservices Architecture', 'Active', '2025-10-17 10:10:23', '2025-10-17 10:10:23');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `payment_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `unverified_users`
--

CREATE TABLE `unverified_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_account_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `certificate` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `professional_title` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `experience` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timezone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `availability` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin_link` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `portfolio_link` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `relevant_link` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `forgot_token` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Public',
  `otp` int(11) DEFAULT NULL,
  `otp_sent_time` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `first_name`, `last_name`, `user_type`, `stripe_account_id`, `certificate`, `location`, `email`, `password`, `image`, `phone`, `country`, `professional_title`, `experience`, `language`, `timezone`, `about`, `availability`, `linkedin_link`, `portfolio_link`, `relevant_link`, `remember_token`, `forgot_token`, `status`, `profile_status`, `otp`, `otp_sent_time`, `created_at`, `updated_at`) VALUES
(1, 'Superadmin', 'Super', 'Admin', NULL, NULL, NULL, 'MakeMy Admin Password \n $2y$10$.pIcc0JfT/R92maA8TSNqOoe1s3EAoUfNAIsr7i/H0wZzLDagrsmy', 'super-admin@gmail.com', '$2y$10$7GEwUG0OGoc.QXjkndnyuevdZ6MgTrFUtlizUyzUe0.yXroJNrTAu', '/profile-pic/167167763028848.jpg', '1241239832', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 'Active', 'Public', 0, '2023-01-08 07:01:54', '2022-01-24 10:10:09', '2023-01-08 13:32:11'),
(101, 'Freelancer', 'Testing', NULL, NULL, NULL, NULL, NULL, 'eail@cad.com', '$2y$10$0WvCtDW8vF/I6N8MUgz0gOGKJJIzXBGy4ikrxW1XWGe68mH6tb2DS', NULL, '345234321', 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Public', NULL, NULL, '2025-03-02 13:29:51', '2025-03-02 13:29:51'),
(102, 'Freelancer', 'Freelancer', NULL, NULL, 'acct_1RruRzFaV7LZIuBT', NULL, NULL, 'freelancer@gmail.com', '', NULL, '8171960474', 'India', 'Freelancer', '2-3 years', '[\"[\\\"[\\\\\\\"Hindi\\\\\\\",\\\\\\\"English\\\\\\\"]\\\"]\"]', 'GMT-09:00', 'About My Self', 'Available', '#', '#', '#', NULL, NULL, 'Active', 'Private', NULL, NULL, '2025-03-03 10:43:10', '2025-08-24 19:10:42'),
(107, 'Client', 'Client', NULL, NULL, 'acct_1RsJyOR7EaxSfxlZ', NULL, NULL, 'client@gmail.com', '$2y$10$uoBG5toceURyqRYcT.b24uTBsKRff2MQi/t8M.iHHD8XjaWNznQG6', '/upload/user/176070859791106.png', '+91 7976955311', 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Public', NULL, NULL, '2025-03-04 06:51:13', '2025-10-17 18:15:25'),
(109, 'Client', 'Client', NULL, NULL, NULL, NULL, NULL, 'client1@gmail.com', '$2y$10$reLqf8ePov5icm4flKlGA.3Srunnb.0QTm95O9wbdYjCoBTlvdvRi', NULL, '7976955312', 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Public', NULL, NULL, '2025-03-04 06:57:41', '2025-03-04 06:57:41'),
(110, 'Freelancer', 'Sam J', NULL, NULL, NULL, NULL, NULL, 'freelancer1@gmail.com', '$2y$10$5gFB/InnbEf5vmOB9uFMkeIrS/LH7DV9LE9EifSG1nfZcJFDS/TyG', '/upload/user/176019701013096.jpg', '8171963421', 'Cyprus', 'WEB DEVELOPER', '2-3 years', '[\"[\\\"English\\\",\\\"Hindi\\\"]\"]', 'GMT+10:00', '<p data-start=\"68\" data-end=\"314\">Hi there! I’m a passionate and experienced web developer with a knack for creating dynamic and visually appealing websites. Whether you need a simple landing page, a full-fledged e-commerce platform, or anything in between, I’ve got you covered.</p>\n<p data-start=\"316\" data-end=\"553\">I specialize in front-end and back-end development, with proficiency in HTML, CSS, JavaScript, React, Node.js, and WordPress. My goal is to deliver responsive, user-friendly, and high-performance websites that exceed client expectations.</p>\n<p data-start=\"555\" data-end=\"698\">I am committed to understanding your vision and bringing it to life with clean, efficient code. Let’s collaborate and create something amazing!</p>\n<p data-start=\"700\" data-end=\"711\"><strong data-start=\"700\" data-end=\"711\">Skills:</strong></p>\n<ul data-start=\"712\" data-end=\"877\">\n<li data-start=\"712\" data-end=\"763\">\n<p data-start=\"714\" data-end=\"763\">Front-end: HTML5, CSS3, JavaScript, React, Vue.js</p>\n</li>\n<li data-start=\"764\" data-end=\"807\">\n<p data-start=\"766\" data-end=\"807\">Back-end: Node.js, Express.js, PHP, MySQL</p>\n</li>\n<li data-start=\"808\" data-end=\"833\">\n<p data-start=\"810\" data-end=\"833\">CMS: WordPress, Shopify</p>\n</li>\n<li data-start=\"834\" data-end=\"877\">\n<p data-start=\"836\" data-end=\"877\">Tools: Git, npm, Webpack, Figma, Adobe XD</p>\n</li>\n</ul>\n<p data-start=\"879\" data-end=\"897\"><strong data-start=\"879\" data-end=\"897\">Why Choose Me?</strong></p>\n<ul data-start=\"898\" data-end=\"1046\">\n<li data-start=\"898\" data-end=\"941\">\n<p data-start=\"900\" data-end=\"941\">Professional, quick, and reliable service</p>\n</li>\n<li data-start=\"942\" data-end=\"983\">\n<p data-start=\"944\" data-end=\"983\">Clear communication and timely delivery</p>\n</li>\n<li data-start=\"984\" data-end=\"1046\">\n<p data-start=\"986\" data-end=\"1046\">Attention to detail with a focus on usability and aesthetics</p>\n</li>\n</ul>\n<p data-start=\"1048\" data-end=\"1100\">Let’s work together to turn your ideas into reality!</p>', 'Available', 'linkedin.com', 'Portfolio', 'google.com', NULL, NULL, 'Active', '', 0, '0000-00-00 00:00:00', '2025-03-04 06:58:40', '2025-11-09 04:52:15'),
(111, 'Client', 'Client2', NULL, NULL, NULL, NULL, NULL, 'client2@gmail.com', '$2y$10$phOyBv2jTSUGA5TKIeri7eN7IdfeTWN3uWbALiekejHqiX0c5CuGi', NULL, '7976955313', 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Public', NULL, NULL, '2025-03-04 07:50:38', '2025-03-04 07:51:22'),
(112, 'Freelancer', 'freelancer2', NULL, NULL, NULL, NULL, NULL, 'freelancer2@gmail.com', '$2y$10$2vfIPBflICiQTLbOCDADaO4P7ZybFyl/oInACDq4CKTjYS4CTXCxG', NULL, '123123134', 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Public', NULL, NULL, '2025-03-06 08:15:09', '2025-03-06 08:15:09'),
(113, 'Freelancer', 'freelancer3', NULL, NULL, NULL, NULL, NULL, 'freelancer3@gmail.com', '$2y$10$ibJ7ebVQQAdVQm2sOONAjeUA5naCcaN6LfdIxe7ItA.pxm19Q8aQG', NULL, '1231231232', 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Public', NULL, NULL, '2025-03-06 08:15:49', '2025-03-06 08:15:49'),
(114, 'Client', 'client3', NULL, NULL, NULL, NULL, NULL, 'client3@gmail.com', '$2y$10$dl5EilWjwNETupAc07/gM.co9RmQh3eLeTAWeuk2gfUIehI7ATR7q', NULL, '8171963422', 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Public', NULL, NULL, '2025-03-06 08:17:38', '2025-03-06 08:18:06'),
(115, 'Freelancer', 'Sam Jain', NULL, NULL, NULL, NULL, NULL, 'samjain1997@yopmail.com', '$2y$10$rpmvfbW0W7ao6C4Dqbabce2eObseh0nw.W0EXUFhKZuAA.jLL/sqG', NULL, '9789978799', 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Public', NULL, NULL, '2025-03-10 05:17:12', '2025-03-10 05:17:12'),
(116, 'Client', 'Flavio Testing', NULL, NULL, NULL, NULL, NULL, 'flavio123@gmail.com', '$2y$10$sMDfrZJYpJCcWgL/q2DPw.ULApQUTvV1MCtH418yEARyirNzmaloi', NULL, '8977899889', 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Public', NULL, NULL, '2025-03-10 05:40:30', '2025-03-10 05:40:30'),
(117, 'Freelancer', 'Freelancer11', NULL, NULL, NULL, NULL, NULL, 'freelancer11@gmail.com', '', '/upload/user/175419910967498.jpg', '9878767656', 'India', 'Full Stack Developer', '7+ years', '[\"English\",\"Hindi\"]', 'GMT-04:00', '<p data-start=\"162\" data-end=\"206\"><strong data-start=\"162\" data-end=\"206\">About Me (Dummy Freelancer Description):</strong></p>\n<p data-start=\"208\" data-end=\"534\">Hi there! 👋 I\'m a passionate and detail-oriented freelancer with over 5 years of experience delivering high-quality work across various industries. I specialize in [your skill here – e.g., web development, graphic design, content writing, etc.] and have worked with clients from around the world to bring their ideas to life.</p>\n<p data-start=\"536\" data-end=\"754\">I pride myself on clear communication, meeting deadlines, and going the extra mile to ensure client satisfaction. Whether you\'re launching a new project or need ongoing support, I\'m here to help you achieve your goals.</p>\n<p data-start=\"756\" data-end=\"808\">Let’s collaborate and make something great together!</p>\n<hr data-start=\"810\" data-end=\"813\">\n<p data-start=\"815\" data-end=\"980\" data-is-last-node=\"\" data-is-only-node=\"\">If you want this tailored to a specific profession (e.g., Laravel developer, React developer, UI/UX designer, etc.), just let me know and I’ll adjust it accordingly.</p>', 'Available', '#', '#', '#', NULL, NULL, 'Active', 'Private', NULL, NULL, '2025-08-03 05:31:24', '2025-08-03 05:47:35'),
(118, 'Client', 'Client11', NULL, NULL, NULL, NULL, NULL, 'client11@gmail.com', '$2y$10$TErNZhY4hhaCyLskGA/XSe1xR/4.8wW8N.DF1sC6jQM1CJCpXnQQ.', NULL, '8987483745', 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Public', NULL, NULL, '2025-08-03 05:34:04', '2025-08-03 05:34:04'),
(119, 'Client', 'Sam', NULL, NULL, 'acct_1Rruq0F2uOGHXI7q', NULL, NULL, 'samjn1995@yopmail.com', '$2y$10$xAHb69ZaqhR5bVOVKjag5O5ZNM//KYG.9uLIDHuLA6M0RV..TxwqC', NULL, 'Jain', 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Public', NULL, NULL, '2025-08-03 05:36:27', '2025-08-03 05:52:07'),
(120, 'Client', 'client5', NULL, NULL, 'acct_1RsRR3QodE6I6Whg', NULL, NULL, 'client5@gmail.com', '$2y$10$jOcrmc88kmZhAophuxrqwubR8QWAhZ32dZukGLELgprRgmCx/j7ni', '/upload/user/175430142142918.jpg', '9187287382', 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Public', NULL, NULL, '2025-08-04 09:56:34', '2025-08-04 16:40:32'),
(121, 'Freelancer', 'freelancer5', NULL, NULL, 'acct_1Rruq0F2uOGHXI7q', NULL, NULL, 'freelancer5@gmail.com', '$2y$10$nw4EbHMevowNjx4glfCH0eUQwYTpQHBBcPY/LjgZlOYfPcwVAgcSe', '/upload/user/175430223666052.jpg', '9879876763', 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Public', NULL, NULL, '2025-08-04 10:02:16', '2025-08-04 10:10:36'),
(122, 'Client', 'Steve', NULL, NULL, 'acct_1RskVKQz4qTkaT9o', NULL, NULL, 'steve@gmail.com', '$2y$10$Nl6iwo4c/oBz26buI3Av..cvsRpuKayANGOOye/bgsqaFRcUJUl2q', NULL, '123456789012345', 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Public', NULL, NULL, '2025-08-05 12:55:36', '2025-10-17 10:03:09'),
(123, 'Freelancer', 'John', NULL, NULL, 'acct_1RskkWJ2IOrY9bIc', NULL, NULL, 'john@gmail.com', '$2y$10$7GEwUG0OGoc.QXjkndnyuevdZ6MgTrFUtlizUyzUe0.yXroJNrTAu', '/upload/user/175515355740044.jpg', '4242424248', 'India', 'John Freelancer', '4-6 years', '[\"[\\\"[\\\\\\\"Hindi\\\\\\\",\\\\\\\"English\\\\\\\"]\\\"]\"]', 'GMT-11:00', '<p data-start=\"99\" data-end=\"615\"><span data-start=\"99\" data-end=\"113\" style=\"font-size: 14px; font-weight: bolder;\">Full Name:</span>&nbsp;Alex Johnson<br data-start=\"126\" data-end=\"129\" style=\"font-size: 14px;\"><span data-start=\"129\" data-end=\"142\" style=\"font-size: 14px; font-weight: bolder;\">Username:</span>&nbsp;alex_johnson89<br data-start=\"157\" data-end=\"160\" style=\"font-size: 14px;\"><span data-start=\"160\" data-end=\"170\" data-is-only-node=\"\" style=\"font-size: 14px; font-weight: bolder;\">Email:</span>&nbsp;<a data-start=\"171\" data-end=\"195\" class=\"cursor-pointer\" rel=\"noopener\" style=\"font-size: 14px;\">alex.johnson@example.com</a><br data-start=\"195\" data-end=\"198\" style=\"font-size: 14px;\"><span data-start=\"198\" data-end=\"208\" style=\"font-size: 14px; font-weight: bolder;\">Phone:</span>&nbsp;+1 555-234-7890<br data-start=\"224\" data-end=\"227\" style=\"font-size: 14px;\"><span data-start=\"227\" data-end=\"239\" style=\"font-size: 14px; font-weight: bolder;\">Address:</span>&nbsp;123 Maple Street, Springfield, IL, USA<br data-start=\"278\" data-end=\"281\" style=\"font-size: 14px;\"><span data-start=\"281\" data-end=\"299\" style=\"font-size: 14px; font-weight: bolder;\">Date of Birth:</span>&nbsp;14 March 1990<br data-start=\"313\" data-end=\"316\" style=\"font-size: 14px;\"><span data-start=\"316\" data-end=\"327\" style=\"font-size: 14px; font-weight: bolder;\">Gender:</span>&nbsp;Male<br data-start=\"332\" data-end=\"335\" style=\"font-size: 14px;\"><span data-start=\"335\" data-end=\"350\" style=\"font-size: 14px; font-weight: bolder;\">Occupation:</span>&nbsp;Software Developer<br data-start=\"369\" data-end=\"372\" style=\"font-size: 14px;\"><span data-start=\"372\" data-end=\"384\" style=\"font-size: 14px; font-weight: bolder;\">Company:</span>&nbsp;BrightTech Solutions<br data-start=\"405\" data-end=\"408\" style=\"font-size: 14px;\"><span data-start=\"408\" data-end=\"420\" style=\"font-size: 14px; font-weight: bolder;\">Website:</span>&nbsp;<a data-start=\"421\" data-end=\"444\" rel=\"noopener\" target=\"_new\" class=\"cursor-pointer\" style=\"font-size: 14px;\">https://alexjohnson.dev</a><br data-start=\"444\" data-end=\"447\" style=\"font-size: 14px;\"><span data-start=\"447\" data-end=\"460\" style=\"font-size: 14px; font-weight: bolder;\">About Me:</span>&nbsp;Passionate coder with a love for solving complex problems and building scalable applications.<br data-start=\"554\" data-end=\"557\" style=\"font-size: 14px;\"><span data-start=\"557\" data-end=\"581\" style=\"font-size: 14px; font-weight: bolder;\">Profile Picture URL:</span>&nbsp;<a data-start=\"582\" data-end=\"613\" rel=\"noopener\" target=\"_new\" class=\"cursor-pointer\" style=\"font-size: 14px;\">https://via.placeholder.com/150</a></p><hr data-start=\"617\" data-end=\"620\" style=\"font-size: 16px; letter-spacing: 0.08px; color: rgb(0, 0, 0);\"><p data-start=\"622\" data-end=\"771\" data-is-last-node=\"\" data-is-only-node=\"\">If you want, I can also create a&nbsp;<span data-start=\"655\" data-end=\"680\" style=\"font-size: 14px; font-weight: bolder;\">realistic JSON object</span>&nbsp;or&nbsp;<span data-start=\"684\" data-end=\"704\" style=\"font-size: 14px; font-weight: bolder;\">SQL insert query</span>&nbsp;for this dummy profile so it can be directly used in your project.<br><br><br>I\'m a Jira Developer with 10 yrs experience</p>', 'Available', 'www.linkedin.com', '#', '#', NULL, NULL, 'Active', 'Private', NULL, NULL, '2025-08-05 13:03:57', '2025-08-16 06:34:58'),
(124, 'Client', 'Testing Client', NULL, NULL, NULL, NULL, NULL, 'test-client@yopmail.com', '$2y$10$hj.8zJYDguKI5czMzvVFguvO.DPiUlq6foGh/HaofhO83U5YokSCW', NULL, '1231233212', 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Public', NULL, NULL, '2025-08-13 06:13:52', '2025-08-13 06:13:52'),
(125, 'Client', 'TestClient', NULL, NULL, NULL, NULL, NULL, 'test-client@gmail.com', '$2y$10$532fgjA.obBIwxH0b8yTqe1tO/2jf1FabtAIwbJPFOEgHW8OvQFRS', NULL, '8987876763', 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Public', NULL, NULL, '2025-08-13 06:20:24', '2025-08-13 06:20:24'),
(126, 'Freelancer', 'TestFreelancer', NULL, NULL, NULL, NULL, NULL, 'TestFreelancer@yopmail.com', '$2y$10$eDHtuAZo3lQX6w.gUgZ0WOotU7koF73AsoSWqKrv/C4lUkVv8gzKe', NULL, '1231231234', 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Public', NULL, NULL, '2025-08-14 06:13:17', '2025-08-14 06:13:17'),
(127, 'Freelancer', 'Abc', NULL, NULL, NULL, NULL, NULL, 'abc@gmail.com', '$2y$10$r68KATsz67V40OiLYB/2quxjf1dvnKHLS/pHbVqxtCO41t2stz18e', NULL, '823232323', 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Public', NULL, NULL, '2025-08-16 06:14:00', '2025-08-16 06:14:00'),
(128, 'Freelancer', 'Kanishk Chhajed', NULL, NULL, 'acct_1S2X6bJMnoNksyQc', NULL, NULL, 'chhajed+freelancer+kanishk.placement@gmail.com', '$2y$10$kzcZwwZ/FWCKPpAQIaM9mO6RvLZt8uS/KS4JCi80Ea6xGgIP.x6xK', '/upload/user/175672971196535.png', '7426032772', 'Canada', 'UI/UX Designer', '0-1 years', '[\"Hindi\",\"English\"]', 'GMT-08:00', 'I\'m an experience Designer, love to create and take inspiration from other sites to bring my own creativity with site optimality hand-in-hand.<br>Look into my existing work from here :[]&nbsp;', 'Available', NULL, NULL, NULL, NULL, NULL, 'Active', 'Private', NULL, NULL, '2025-09-01 04:29:10', '2025-09-01 12:45:08'),
(129, 'Client', 'Kan', NULL, NULL, NULL, NULL, NULL, 'chhajed+client+kanishk.placement@gmail.com', '$2y$10$dFBEcOl8Oz5ttBStXNwj1.31xPt/mTJ5uD6hBvJdSyZ/Jk.xcPOlu', NULL, '07426032772', 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Public', NULL, NULL, '2025-09-01 04:30:25', '2025-09-01 04:30:25'),
(130, 'Freelancer', 'Test Freelancer User', NULL, NULL, 'acct_1S3Y3yJNZHboDspB', NULL, NULL, 'testfreelancer@gmail.com', '$2y$10$g9Lhp4J6rpiWVJoXwdslwORHBYo9yf6vz.nNo9mEGQAXQDZwRLPo6', '/upload/user/175819058922164.jpg', '4242424242', 'India', 'Data Engineer', '4-6 years', '[\"English\"]', 'GMT-08:00', '<div class=\"relative basis-auto flex-col -mb-(--composer-overlap-px) [--composer-overlap-px:28px] grow flex overflow-hidden\"><div class=\"relative h-full\"><div class=\"flex h-full flex-col overflow-y-auto [scrollbar-gutter:stable_both-edges] @[84rem]/thread:pt-(--header-height)\"><div class=\"@thread-xl/thread:pt-header-height flex flex-col text-sm\"><article class=\"text-token-text-primary w-full focus:outline-none scroll-mt-[calc(var(--header-height)+min(200px,max(70px,20svh)))]\" tabindex=\"-1\" dir=\"auto\" data-turn-id=\"4fb3806c-763e-41eb-a6fb-2642e4fb04d5\" data-testid=\"conversation-turn-2\" data-scroll-anchor=\"true\" data-turn=\"assistant\"><div class=\"text-base my-auto mx-auto pb-10 [--thread-content-margin:--spacing(4)] @[37rem]:[--thread-content-margin:--spacing(6)] @[72rem]:[--thread-content-margin:--spacing(16)] px-(--thread-content-margin)\"><div class=\"[--thread-content-max-width:32rem] @[34rem]:[--thread-content-max-width:40rem] @[64rem]:[--thread-content-max-width:48rem] mx-auto max-w-(--thread-content-max-width) flex-1 group/turn-messages focus-visible:outline-hidden relative flex w-full min-w-0 flex-col agent-turn\" tabindex=\"-1\"><div class=\"flex max-w-full flex-col grow\"><div data-message-author-role=\"assistant\" data-message-id=\"88368642-7c26-40bf-a17a-de3ec00f1724\" dir=\"auto\" class=\"min-h-8 text-message relative flex w-full flex-col items-end gap-2 text-start break-words whitespace-normal [.text-message+&amp;]:mt-5\" data-message-model-slug=\"gpt-5\"><div class=\"flex w-full flex-col gap-1 empty:hidden first:pt-[3px]\"><div class=\"markdown prose dark:prose-invert w-full break-words dark markdown-new-styling\"><h4 data-start=\"301\" data-end=\"330\"><strong data-start=\"306\" data-end=\"330\">Key Responsibilities</strong></h4>\n<ul data-start=\"331\" data-end=\"1022\">\n<li data-start=\"331\" data-end=\"429\">\n<p data-start=\"333\" data-end=\"429\">Develop and maintain scalable <strong data-start=\"363\" data-end=\"381\">data pipelines</strong> and ETL (Extract, Transform, Load) processes.</p>\n</li>\n<li data-start=\"430\" data-end=\"539\">\n<p data-start=\"432\" data-end=\"539\">Design and optimize <strong data-start=\"452\" data-end=\"467\">data models</strong>, schemas, and storage solutions for structured and unstructured data.</p>\n</li>\n<li data-start=\"540\" data-end=\"639\">\n<p data-start=\"542\" data-end=\"639\">Integrate data from multiple sources (databases, APIs, streaming platforms, third-party tools).</p>\n</li>\n<li data-start=\"640\" data-end=\"732\">\n<p data-start=\"642\" data-end=\"732\">Ensure <strong data-start=\"649\" data-end=\"695\">data quality, consistency, and reliability</strong> through validation and monitoring.</p>\n</li>\n<li data-start=\"733\" data-end=\"808\">\n<p data-start=\"735\" data-end=\"808\">Implement <strong data-start=\"745\" data-end=\"790\">data security, compliance, and governance</strong> best practices.</p>\n</li>\n<li data-start=\"809\" data-end=\"931\">\n<p data-start=\"811\" data-end=\"931\">Collaborate with <strong data-start=\"828\" data-end=\"877\">data scientists, analysts, and business teams</strong> to enable analytics and machine learning use cases.</p>\n</li>\n<li data-start=\"932\" data-end=\"1022\">\n<p data-start=\"934\" data-end=\"1022\">Monitor and improve <strong data-start=\"954\" data-end=\"1003\">performance, scalability, and cost-efficiency</strong> of data systems.</p>\n</li>\n</ul>\n<h4 data-start=\"1024\" data-end=\"1044\"><strong data-start=\"1029\" data-end=\"1044\">Core Skills</strong></h4>\n<ul data-start=\"1045\" data-end=\"1476\">\n<li data-start=\"1045\" data-end=\"1119\">\n<p data-start=\"1047\" data-end=\"1119\">Proficiency in <strong data-start=\"1062\" data-end=\"1069\">SQL</strong> and database technologies (relational &amp; NoSQL).</p>\n</li>\n<li data-start=\"1120\" data-end=\"1184\">\n<p data-start=\"1122\" data-end=\"1184\">Expertise in <strong data-start=\"1135\" data-end=\"1161\">Python, Java, or Scala</strong> for data processing.</p>\n</li>\n<li data-start=\"1185\" data-end=\"1253\">\n<p data-start=\"1187\" data-end=\"1253\">Experience with <strong data-start=\"1203\" data-end=\"1216\">ETL tools</strong> (Airflow, dbt, Informatica, etc.).</p>\n</li>\n<li data-start=\"1254\" data-end=\"1322\">\n<p data-start=\"1256\" data-end=\"1322\">Familiarity with <strong data-start=\"1273\" data-end=\"1296\">big data frameworks</strong> (Spark, Hadoop, Kafka).</p>\n</li>\n<li data-start=\"1323\" data-end=\"1402\">\n<p data-start=\"1325\" data-end=\"1402\">Knowledge of <strong data-start=\"1338\" data-end=\"1357\">cloud platforms</strong> (AWS, Azure, GCP) and their data services.</p>\n</li>\n<li data-start=\"1403\" data-end=\"1476\">\n<p data-start=\"1405\" data-end=\"1476\">Strong grasp of <strong data-start=\"1421\" data-end=\"1441\">data warehousing</strong> (Snowflake, Redshift, BigQuery).</p>\n</li>\n</ul>\n<h4 data-start=\"1478\" data-end=\"1494\"><strong data-start=\"1483\" data-end=\"1494\">Profile</strong></h4>\n<p data-start=\"1495\" data-end=\"1708\">Data Engineers are problem-solvers who bridge software engineering and data science. They ensure that the right data is accessible, clean, and usable—enabling businesses to make <strong data-start=\"1673\" data-end=\"1707\">data-driven decisions at scale</strong>.</p>\n<hr data-start=\"1710\" data-end=\"1713\">\n<p data-start=\"1715\" data-end=\"1845\" data-is-last-node=\"\" data-is-only-node=\"\">Do you want me to write this description in a <strong data-start=\"1761\" data-end=\"1783\">job posting format</strong> (for hiring) or a <strong data-start=\"1802\" data-end=\"1826\">resume-ready profile</strong> (for a candidate)?</p></div></div></div></div><div class=\"flex min-h-[46px] justify-start\"></div><div class=\"mt-3 w-full empty:hidden\"><div class=\"text-center\"></div></div></div></div></article><div aria-hidden=\"true\" data-edge=\"true\" class=\"pointer-events-none h-px w-px\"></div><div></div></div></div></div></div><div id=\"thread-bottom-container\" class=\"relative isolate z-10 w-full basis-auto has-data-has-thread-error:pt-2 has-data-has-thread-error:[box-shadow:var(--sharp-edge-bottom-shadow)] md:border-transparent md:pt-0 dark:border-white/20 md:dark:border-transparent content-fade single-line flex flex-col\"><div id=\"thread-bottom\"><div class=\"text-base mx-auto [--thread-content-margin:--spacing(4)] @[37rem]:[--thread-content-margin:--spacing(6)] @[72rem]:[--thread-content-margin:--spacing(16)] px-(--thread-content-margin)\"><div class=\"[--thread-content-max-width:32rem] @[34rem]:[--thread-content-max-width:40rem] @[64rem]:[--thread-content-max-width:48rem] mx-auto max-w-(--thread-content-max-width) flex-1\"><div class=\"flex justify-center empty:hidden\"></div><div class=\"max-xs:[--force-hide-label:none] relative z-1 flex h-full max-w-full flex-1 flex-col\"><button type=\"button\" class=\"invisible absolute self-center\" aria-hidden=\"true\" tabindex=\"-1\" aria-haspopup=\"dialog\" aria-expanded=\"false\" aria-controls=\"radix-«R2diaoj59jl58iqcm»\" data-state=\"closed\" name=\"context-connector-pasted-link-popover-trigger\"></button><div class=\"absolute start-0 end-0 bottom-full z-20\"><div class=\"relative h-full w-full\"><div class=\"mb-2 flex flex-col gap-3.5 pt-2\"><aside class=\"flex w-full items-start gap-4 rounded-3xl border py-4 ps-5 pe-3 text-sm [text-wrap:pretty] lg:mx-auto dark:border-transparent shadow-xxs md:items-center border-token-border-default bg-token-main-surface-primary text-token-text-primary dark:bg-token-main-surface-secondary\"><div class=\"flex h-full w-full items-start gap-3 md:items-center\"><div class=\"mt-1.5 flex grow items-start gap-4 md:mt-0 md:flex-row md:items-center md:justify-between md:gap-8 flex-col\"><div class=\"flex max-w-none flex-col\"><h3 class=\"text-sm font-bold text-token-text-primary\"></h3></div></div></div></aside></div></div></div></div></div></div></div></div>', 'Available', 'www.linkedin.com', '#', '#', NULL, NULL, 'Active', '', 170278, '2025-10-16 04:49:11', '2025-09-04 07:53:32', '2025-10-17 18:11:55'),
(131, 'Client', 'Flavio Client', NULL, NULL, NULL, NULL, NULL, 'testclient@gmail.com', '$2y$10$kMHvr/9PCjdVdI5nT54KnOKAU44ioy2Yvnj71e0i8g0OcGeth56X6', '/upload/user/176085668962042.jpg', '+64211174550', 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Public', NULL, NULL, '2025-09-04 08:02:17', '2025-10-19 06:52:25'),
(132, 'Freelancer', 'Tester', NULL, NULL, NULL, NULL, NULL, 'Tester@gmail.com', '$2y$10$lDL4.KB1.EytlZn8PndYKeBXqa3eGFUuDqEQHqRlQ0K9ivfUOIUzK', NULL, '9898767654', 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Public', NULL, NULL, '2025-09-04 16:39:38', '2025-09-04 16:39:38'),
(133, 'Client', 'Sam Jain', NULL, NULL, NULL, NULL, NULL, 'client23@gmail.com', '$2y$10$Q5cMWalk0KuL/afLrkdFyu1lJvs1qQBTQ1f1pPi5LUAUpkcf9TGLK', '/upload/user/175766960831274.jpg', '9788778978', 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Public', NULL, NULL, '2025-09-12 09:32:55', '2025-09-12 09:33:28'),
(134, 'Freelancer', 'Ranjan Team', NULL, NULL, 'acct_1S6UWWBwymP3NFB2', NULL, NULL, 'ranjanteam@gmail.com', '$2y$10$oOe1Ez706aqQMufIctWHB.Cs/W7crmLjPZN.6xznzy2J8UAEEXFNy', NULL, '8979897890', 'India', 'React Developer', '2-3 years', '[\"English\"]', 'GMT+01:00', '<h4 data-start=\"242\" data-end=\"258\">👋 About Me</h4>\n<p data-start=\"259\" data-end=\"652\">I’m a <strong data-start=\"265\" data-end=\"287\">React.js Developer</strong> with [X years] of experience building responsive, high-performance web applications. I specialize in creating dynamic user interfaces with React, integrating APIs, and delivering clean, maintainable code. I’m comfortable working in both independent and collaborative environments, and I follow best practices to ensure scalable and efficient front-end development.</p>\n<hr data-start=\"654\" data-end=\"657\">\n<h4 data-start=\"659\" data-end=\"682\">⚙️ <strong data-start=\"667\" data-end=\"682\">Core Skills</strong></h4>\n<ul data-start=\"683\" data-end=\"1175\">\n<li data-start=\"683\" data-end=\"733\">\n<p data-start=\"685\" data-end=\"733\"><strong data-start=\"685\" data-end=\"697\">React.js</strong> (Hooks, Functional Components, JSX)</p>\n</li>\n<li data-start=\"734\" data-end=\"770\">\n<p data-start=\"736\" data-end=\"770\"><strong data-start=\"736\" data-end=\"757\">JavaScript (ES6+)</strong>, HTML5, CSS3</p>\n</li>\n<li data-start=\"771\" data-end=\"850\">\n<p data-start=\"773\" data-end=\"850\"><strong data-start=\"773\" data-end=\"793\">State Management</strong>: Context API, Redux (or other libs like Zustand, Recoil)</p>\n</li>\n<li data-start=\"851\" data-end=\"878\">\n<p data-start=\"853\" data-end=\"878\"><strong data-start=\"853\" data-end=\"864\">Routing</strong>: React Router</p>\n</li>\n<li data-start=\"879\" data-end=\"938\">\n<p data-start=\"881\" data-end=\"938\"><strong data-start=\"881\" data-end=\"900\">API Integration</strong>: REST, Axios, GraphQL (if applicable)</p>\n</li>\n<li data-start=\"939\" data-end=\"1004\">\n<p data-start=\"941\" data-end=\"1004\"><strong data-start=\"941\" data-end=\"952\">Styling</strong>: Tailwind CSS, Styled-Components, SCSS, CSS Modules</p>\n</li>\n<li data-start=\"1005\" data-end=\"1048\">\n<p data-start=\"1007\" data-end=\"1048\"><strong data-start=\"1007\" data-end=\"1026\">Version Control</strong>: Git, GitHub / GitLab</p>\n</li>\n<li data-start=\"1049\" data-end=\"1122\">\n<p data-start=\"1051\" data-end=\"1122\"><strong data-start=\"1051\" data-end=\"1079\">Performance Optimization</strong>: Lazy loading, code splitting, memoization</p>\n</li>\n<li data-start=\"1123\" data-end=\"1175\">\n<p data-start=\"1125\" data-end=\"1175\"><strong data-start=\"1125\" data-end=\"1146\">Responsive Design</strong>: Mobile-first, Flexbox, Grid</p>\n</li>\n</ul>\n<hr data-start=\"1177\" data-end=\"1180\">\n<h4 data-start=\"1182\" data-end=\"1214\">🔨 <strong data-start=\"1190\" data-end=\"1214\">Tools &amp; Technologies</strong></h4>\n<ul data-start=\"1215\" data-end=\"1432\">\n<li data-start=\"1215\" data-end=\"1241\">\n<p data-start=\"1217\" data-end=\"1241\">VS Code, Chrome DevTools</p>\n</li>\n<li data-start=\"1242\" data-end=\"1266\">\n<p data-start=\"1244\" data-end=\"1266\">Git, GitHub, Bitbucket</p>\n</li>\n<li data-start=\"1267\" data-end=\"1318\">\n<p data-start=\"1269\" data-end=\"1318\">Vite / Create React App / Next.js (if applicable)</p>\n</li>\n<li data-start=\"1319\" data-end=\"1369\">\n<p data-start=\"1321\" data-end=\"1369\">Figma / Adobe XD (for turning designs into code)</p>\n</li>\n<li data-start=\"1370\" data-end=\"1432\">\n<p data-start=\"1372\" data-end=\"1432\">Firebase, Supabase, Node.js (if familiar with backend tasks)</p>\n</li>\n</ul>\n<hr data-start=\"1434\" data-end=\"1437\">\n<h4 data-start=\"1439\" data-end=\"1465\">🚀 <strong data-start=\"1447\" data-end=\"1465\">What I Deliver</strong></h4>\n<ul data-start=\"1466\" data-end=\"1708\">\n<li data-start=\"1466\" data-end=\"1507\">\n<p data-start=\"1468\" data-end=\"1507\">Pixel-perfect, responsive UI components</p>\n</li>\n<li data-start=\"1508\" data-end=\"1542\">\n<p data-start=\"1510\" data-end=\"1542\">Clean and modular code structure</p>\n</li>\n<li data-start=\"1543\" data-end=\"1599\">\n<p data-start=\"1545\" data-end=\"1599\">Fully functional features integrated with backend APIs</p>\n</li>\n<li data-start=\"1600\" data-end=\"1634\">\n<p data-start=\"1602\" data-end=\"1634\">Component reuse and optimization</p>\n</li>\n<li data-start=\"1635\" data-end=\"1664\">\n<p data-start=\"1637\" data-end=\"1664\">Cross-browser compatibility</p>\n</li>\n<li data-start=\"1665\" data-end=\"1708\">\n<p data-start=\"1667\" data-end=\"1708\">Strong communication and on-time delivery</p>\n</li>\n</ul>', 'Available', '#', 'https://github.com', 'https://google.com', NULL, NULL, 'Active', '', NULL, NULL, '2025-09-12 10:37:20', '2025-09-12 10:48:14'),
(135, 'Client', 'Flavio Neves da Silva', NULL, NULL, NULL, NULL, NULL, 'flavionvs@hotmail.com', '$2y$10$cPDC5IL5hAyxbI.JwhfMpOY8zF8pbWApUoQdEpcDP8cK6ikmWOomG', NULL, '021114550', 'Brazil', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Public', 581686, '2025-11-04 07:06:32', '2025-10-05 02:29:03', '2025-11-04 01:43:13'),
(136, 'Freelancer', 'Flavio', NULL, NULL, NULL, NULL, NULL, 'flavionevesdasilva@thecodehelper.com', '$2y$10$nRbykvh/zpygRJRyy5Bicu23NprYHDTfz8slfVQzz3zD.l3/xHlM.', NULL, '+6421114550', 'Brazil', 'Full-Stack Developer & Automation Specialist', '4-6 years', '[\"English\"]', 'GMT+12:00', 'I’m a detail-oriented full-stack developer with 5 years of experience building scalable web applications, APIs, and automation tools. I’ve worked across multiple industries, helping clients streamline operations through clean code, efficient data models, and user-friendly interfaces. I’m passionate about delivering high-quality results and continuously improving through feedback and collaboration.', 'Available', 'teste', 'teste', 'Teste', NULL, NULL, 'Active', '', NULL, NULL, '2025-10-05 03:08:27', '2025-11-04 04:49:23'),
(137, 'Client', 'Client', NULL, NULL, NULL, NULL, NULL, 'client123@gmail.com', '$2y$10$RWqwnS4Ymuf4IuOTduLMlOy6Ivc9LyEHr5Ym5yNSy.8uAfPCw/TV2', '/upload/user/176019694355477.jpg', '8987676545', 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Public', NULL, NULL, '2025-10-11 15:30:49', '2025-10-11 15:35:43'),
(138, 'Client', 'test456', NULL, NULL, NULL, NULL, NULL, 'test@test.com', '$2y$10$A2FZRtTtQ/vLt.oZEelvdOLg83oZzC9FaP98gC6Jqksjc9QTDYDo2', NULL, '021114550', 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Public', NULL, NULL, '2025-11-07 07:02:58', '2025-11-07 07:02:58'),
(139, 'Client', 'Test 3402', NULL, NULL, NULL, NULL, NULL, 'test@test345.com', '$2y$10$LgTKfl9udnyZvym1.W9uieqSalzvx4PUfeB5v9L4Bk8AWcDQvIuMu', NULL, '21212', 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Public', NULL, NULL, '2025-11-07 07:21:27', '2025-11-07 07:21:27'),
(140, 'Client', 'Dilip vishwakarma', NULL, NULL, NULL, NULL, NULL, 'test@gmail.com', '$2y$10$yqhhdoGpEY45EaTd2o8wnuC8rzI8604aTyTVhT40Ydr0ZgKgFaZXK', NULL, '7047671849', 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Public', NULL, NULL, '2025-11-09 10:44:56', '2025-11-09 10:44:56'),
(141, 'Client', 'test', NULL, NULL, NULL, NULL, NULL, 'test568@test.com', '$2y$10$/HA5va1daSqua6IcI2DyoOIWoKibu4HN4w8BN5WStz8k8dSh6Q1Zu', NULL, '021114550', 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Public', NULL, NULL, '2025-11-10 10:38:13', '2025-11-10 10:38:13'),
(142, 'Freelancer', 'test540', NULL, NULL, NULL, NULL, NULL, 'test540@test.com', '$2y$10$HYKeWd23c4XnjKRH7IeuI.Qkhej6y8wJBogFknsv433aXdaf.0Hs2', NULL, '0211174550', 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Public', NULL, NULL, '2025-11-10 10:50:15', '2025-11-10 10:50:15'),
(143, 'Client', 'Ranjan Sharma', NULL, NULL, NULL, NULL, NULL, 'ranjans838@gmail.com', '$2y$10$ZV.WsbvMkQ8nP3/lIHgoHu4xj/Q1I7EaMVa5zbQIhu/Q5YEyhWXVW', '/upload/user/176303233643898.png', '8310037171', 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Public', NULL, NULL, '2025-11-13 11:11:28', '2025-11-13 11:12:16'),
(144, 'Freelancer', 'Ranjan Sharma', NULL, NULL, NULL, NULL, NULL, 'ranjans83@gmail.com', '$2y$10$4jwEXmoD.yg4q0STjhQV2uN3SHEtvdta0qsjUxoO4I6pse0MrfuIa', NULL, '8310037171', 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Public', NULL, NULL, '2025-11-13 11:20:11', '2025-11-13 11:20:11'),
(145, 'Client', 'Dinesh', NULL, NULL, NULL, NULL, NULL, 'client25@gmail.com', '$2y$10$DDJkmo1jZN5I9S3rwEvqmOrRXTDXT5b60YmFhtDc1kv3EU3DgbRry', NULL, '9890724909', 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Public', NULL, NULL, '2025-11-13 13:37:39', '2025-11-13 13:37:39'),
(146, 'Client', 'adfs', NULL, NULL, NULL, NULL, NULL, 'asdf@gmail.com', '$2y$10$Dd59bZzSCsdnWZagUrrrPOegu/Hc31sjxT1XhwLvw01I4VxndZQRu', NULL, '1234567890', 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Public', NULL, NULL, '2025-11-14 12:32:26', '2025-11-14 12:32:26'),
(147, 'Freelancer', 'Dilip vishwakarma', NULL, NULL, NULL, NULL, NULL, 'dilip@gmail.com', '$2y$10$frG6Hy3XCzOVe7We7/0/I.i3PEH9YOQd9tYMbDGKChMnEkYTOkmkK', NULL, '7047671849', 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Public', NULL, NULL, '2025-11-14 12:37:46', '2025-11-14 12:37:46'),
(148, 'Freelancer', 'Ranjan Sharma', NULL, NULL, NULL, NULL, NULL, 'ranjans38@gmail.com', '$2y$10$9sjwURSeMk41ZYDPaei.VujWeogD88f6gIKGwhWIbfX2e/4O/WaGS', NULL, '8310037171', 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Public', NULL, NULL, '2025-11-14 12:51:14', '2025-11-14 12:51:14'),
(149, 'Freelancer', 'Working Man', NULL, NULL, NULL, NULL, NULL, 'freelancernew@gmail.com', '$2y$10$gGOdTJUJwTmDqUfC54wnyOB4xmKtqt5DdE3IeQL5xCb1qWw8OCKeG', NULL, '89778978978', 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Public', NULL, NULL, '2025-11-15 04:34:16', '2025-11-15 04:34:16');

-- --------------------------------------------------------

--
-- Table structure for table `user_categories`
--

CREATE TABLE `user_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_langs`
--

CREATE TABLE `user_langs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `lang_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_langs`
--

INSERT INTO `user_langs` (`id`, `user_id`, `lang_id`, `created_at`, `updated_at`) VALUES
(1, 110, 1, '2025-10-11 16:06:54', '2025-10-11 16:06:54'),
(3, 102, 2, '2025-10-11 16:07:03', '2025-10-11 16:07:03'),
(4, 130, 1, '2025-10-17 18:11:55', '2025-10-17 18:11:55');

-- --------------------------------------------------------

--
-- Table structure for table `user_languages`
--

CREATE TABLE `user_languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_languages`
--

INSERT INTO `user_languages` (`id`, `user_id`, `language`, `created_at`, `updated_at`) VALUES
(3, 117, 'English', '2025-08-03 05:33:14', '2025-08-03 05:33:14'),
(4, 117, 'Hindi', '2025-08-03 05:33:14', '2025-08-03 05:33:14'),
(13, 123, '[\"[\\\"Hindi\\\",\\\"English\\\"]\"]', '2025-08-16 06:30:17', '2025-08-16 06:30:17'),
(14, 102, '[\"[\\\"Hindi\\\",\\\"English\\\"]\"]', '2025-08-24 19:08:40', '2025-08-24 19:08:40'),
(15, 128, 'Hindi', '2025-09-01 12:43:56', '2025-09-01 12:43:56'),
(16, 128, 'English', '2025-09-01 12:43:56', '2025-09-01 12:43:56'),
(20, 134, 'English', '2025-09-12 10:43:14', '2025-09-12 10:43:14'),
(21, 136, 'English', '2025-10-05 03:19:40', '2025-10-05 03:19:40');

-- --------------------------------------------------------

--
-- Table structure for table `user_programming_languages`
--

CREATE TABLE `user_programming_languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `programming_language_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_programming_languages`
--

INSERT INTO `user_programming_languages` (`id`, `user_id`, `programming_language_id`, `created_at`, `updated_at`) VALUES
(3, 102, 2, '2025-07-28 17:48:08', '2025-07-28 17:48:08'),
(4, 117, 2, '2025-08-03 05:33:13', '2025-08-03 05:33:13'),
(5, 117, 4, '2025-08-03 05:33:13', '2025-08-03 05:33:13'),
(6, 117, 5, '2025-08-03 05:33:14', '2025-08-03 05:33:14'),
(7, 117, 6, '2025-08-03 05:33:14', '2025-08-03 05:33:14'),
(11, 123, 2, '2025-08-16 06:30:17', '2025-08-16 06:30:17'),
(12, 128, 5, '2025-09-01 12:43:56', '2025-09-01 12:43:56'),
(16, 110, 1, '2025-09-05 14:15:23', '2025-09-05 14:15:23'),
(17, 134, 1, '2025-09-12 10:43:14', '2025-09-12 10:43:14'),
(18, 134, 3, '2025-09-12 10:43:14', '2025-09-12 10:43:14'),
(19, 134, 4, '2025-09-12 10:43:14', '2025-09-12 10:43:14'),
(20, 136, 3, '2025-10-05 03:19:40', '2025-10-05 03:19:40'),
(21, 136, 5, '2025-10-05 03:19:40', '2025-10-05 03:19:40'),
(22, 136, 7, '2025-10-05 03:19:40', '2025-10-05 03:19:40'),
(24, 110, 3, '2025-10-11 16:41:24', '2025-10-11 16:41:24'),
(25, 130, 1, '2025-10-17 18:11:55', '2025-10-17 18:11:55'),
(26, 130, 3, '2025-10-17 18:11:55', '2025-10-17 18:11:55'),
(27, 130, 5, '2025-10-17 18:11:55', '2025-10-17 18:11:55');

-- --------------------------------------------------------

--
-- Table structure for table `user_technologies`
--

CREATE TABLE `user_technologies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `technology_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_technologies`
--

INSERT INTO `user_technologies` (`id`, `user_id`, `technology_id`, `created_at`, `updated_at`) VALUES
(3, 117, 1, '2025-08-03 05:33:13', '2025-08-03 05:33:13'),
(4, 117, 2, '2025-08-03 05:33:13', '2025-08-03 05:33:13'),
(6, 123, 1, '2025-08-11 08:40:11', '2025-08-11 08:40:11'),
(8, 102, 2, '2025-08-24 19:08:40', '2025-08-24 19:08:40'),
(9, 128, 1, '2025-09-01 12:43:56', '2025-09-01 12:43:56'),
(10, 130, 1, '2025-09-04 07:57:57', '2025-09-04 07:57:57'),
(12, 110, 1, '2025-09-05 14:15:23', '2025-09-05 14:15:23'),
(13, 134, 1, '2025-09-12 10:43:14', '2025-09-12 10:43:14'),
(14, 136, 1, '2025-10-05 03:19:40', '2025-10-05 03:19:40'),
(15, 110, 2, '2025-10-11 16:41:24', '2025-10-11 16:41:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `applications_user_id_foreign` (`user_id`),
  ADD KEY `applications_project_id_foreign` (`project_id`);

--
-- Indexes for table `application_attachments`
--
ALTER TABLE `application_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_attachments_application_id_foreign` (`application_id`);

--
-- Indexes for table `application_completion_attachments`
--
ALTER TABLE `application_completion_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_completion_attachments_application_id_foreign` (`application_id`);

--
-- Indexes for table `application_statuses`
--
ALTER TABLE `application_statuses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_statuses_application_id_foreign` (`application_id`);

--
-- Indexes for table `basic_settings`
--
ALTER TABLE `basic_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_queries`
--
ALTER TABLE `contact_queries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `langs`
--
ALTER TABLE `langs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_from_foreign` (`from`),
  ADD KEY `messages_to_foreign` (`to`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_application_id_foreign` (`application_id`),
  ADD KEY `payments_user_id_foreign` (`user_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `programming_languages`
--
ALTER TABLE `programming_languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projects_user_id_foreign` (`user_id`),
  ADD KEY `projects_category_id_foreign` (`category_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `technologies`
--
ALTER TABLE `technologies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_user_id_foreign` (`user_id`),
  ADD KEY `transactions_payment_id_foreign` (`payment_id`);

--
-- Indexes for table `unverified_users`
--
ALTER TABLE `unverified_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_categories`
--
ALTER TABLE `user_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_categories_user_id_foreign` (`user_id`),
  ADD KEY `user_categories_category_id_foreign` (`category_id`);

--
-- Indexes for table `user_langs`
--
ALTER TABLE `user_langs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_langs_user_id_foreign` (`user_id`),
  ADD KEY `user_langs_lang_id_foreign` (`lang_id`);

--
-- Indexes for table `user_languages`
--
ALTER TABLE `user_languages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_languages_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_programming_languages`
--
ALTER TABLE `user_programming_languages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_programming_languages_user_id_foreign` (`user_id`),
  ADD KEY `user_programming_languages_programming_language_id_foreign` (`programming_language_id`);

--
-- Indexes for table `user_technologies`
--
ALTER TABLE `user_technologies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_technologies_user_id_foreign` (`user_id`),
  ADD KEY `user_technologies_technology_id_foreign` (`technology_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `application_attachments`
--
ALTER TABLE `application_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `application_completion_attachments`
--
ALTER TABLE `application_completion_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `application_statuses`
--
ALTER TABLE `application_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `basic_settings`
--
ALTER TABLE `basic_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `contact_queries`
--
ALTER TABLE `contact_queries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `langs`
--
ALTER TABLE `langs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `programming_languages`
--
ALTER TABLE `programming_languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `technologies`
--
ALTER TABLE `technologies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unverified_users`
--
ALTER TABLE `unverified_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT for table `user_categories`
--
ALTER TABLE `user_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_langs`
--
ALTER TABLE `user_langs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_languages`
--
ALTER TABLE `user_languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `user_programming_languages`
--
ALTER TABLE `user_programming_languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `user_technologies`
--
ALTER TABLE `user_technologies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  ADD CONSTRAINT `applications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `application_attachments`
--
ALTER TABLE `application_attachments`
  ADD CONSTRAINT `application_attachments_application_id_foreign` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `application_completion_attachments`
--
ALTER TABLE `application_completion_attachments`
  ADD CONSTRAINT `application_completion_attachments_application_id_foreign` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `application_statuses`
--
ALTER TABLE `application_statuses`
  ADD CONSTRAINT `application_statuses_application_id_foreign` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_from_foreign` FOREIGN KEY (`from`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_to_foreign` FOREIGN KEY (`to`) REFERENCES `users` (`id`);

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_application_id_foreign` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `projects_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_categories`
--
ALTER TABLE `user_categories`
  ADD CONSTRAINT `user_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_categories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_langs`
--
ALTER TABLE `user_langs`
  ADD CONSTRAINT `user_langs_lang_id_foreign` FOREIGN KEY (`lang_id`) REFERENCES `langs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_langs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_languages`
--
ALTER TABLE `user_languages`
  ADD CONSTRAINT `user_languages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_programming_languages`
--
ALTER TABLE `user_programming_languages`
  ADD CONSTRAINT `user_programming_languages_programming_language_id_foreign` FOREIGN KEY (`programming_language_id`) REFERENCES `programming_languages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_programming_languages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_technologies`
--
ALTER TABLE `user_technologies`
  ADD CONSTRAINT `user_technologies_technology_id_foreign` FOREIGN KEY (`technology_id`) REFERENCES `technologies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_technologies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
