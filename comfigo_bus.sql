-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2026 at 09:05 AM
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
-- Database: `comfigo_bus`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'Super Admin', 'admin@comfigo.com', '$2y$10$ySWjZ3A6gt8TFMrFbg4JlO81Rh3IH69Ngo0c/xBRjPvKohGC/n5Sm', '2025-09-05 09:27:10');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `journey_date` date NOT NULL,
  `seat_numbers` varchar(255) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `booking_status` enum('confirmed','cancelled','pending') DEFAULT 'confirmed',
  `booked_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `schedule_id`, `journey_date`, `seat_numbers`, `total_amount`, `booking_status`, `booked_at`) VALUES
(63, 6, 6, '2026-06-01', '15,16', 1300.00, 'confirmed', '2026-06-01 11:51:53');

-- --------------------------------------------------------

--
-- Table structure for table `buses`
--

CREATE TABLE `buses` (
  `bus_id` int(11) NOT NULL,
  `bus_name` varchar(100) NOT NULL,
  `bus_type` enum('AC','Non-AC','Sleeper','Semi-Sleeper','Luxury') DEFAULT 'Non-AC',
  `total_seats` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buses`
--

INSERT INTO `buses` (`bus_id`, `bus_name`, `bus_type`, `total_seats`, `created_at`) VALUES
(1, 'Comfigo Express', 'AC', 40, '2025-09-30 05:35:50'),
(5, 'Comfigo Luxury', 'Luxury', 30, '2025-10-02 11:30:38'),
(6, 'Comfigo Volvo', 'Sleeper', 35, '2025-10-02 11:31:46'),
(7, 'Comfigo Intercity', 'Non-AC', 40, '2025-10-04 09:39:33');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_mode` enum('credit_card','debit_card','upi','net_banking','cash') NOT NULL,
  `payment_status` enum('success','failed','pending') DEFAULT 'pending',
  `paid_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `booking_id`, `amount`, `payment_mode`, `payment_status`, `paid_at`) VALUES
(18, 63, 1300.00, 'cash', 'pending', '2026-06-01 11:51:53');

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `route_id` int(11) NOT NULL,
  `source_city` varchar(100) NOT NULL,
  `destination_city` varchar(100) NOT NULL,
  `distance_km` int(11) DEFAULT NULL,
  `duration` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`route_id`, `source_city`, `destination_city`, `distance_km`, `duration`) VALUES
(6, 'Rajkot', 'Ahemdabad', NULL, NULL),
(7, 'Ahemdabad', 'Rajkot', NULL, NULL),
(8, 'Rajkot', 'Gandhinagar', NULL, NULL),
(9, 'Rajkot', 'Mumbai', NULL, NULL),
(10, 'Rajkot', 'vadodara', NULL, NULL),
(11, 'Vadodara', 'Rajkot', NULL, NULL),
(12, 'Gandhinagar', 'Rajkot', NULL, NULL),
(13, 'ahemdabad', 'Gandhinagar', NULL, NULL),
(14, 'Rajkot', 'Porbandar', NULL, NULL),
(15, 'Rajkot', 'Surat', NULL, NULL),
(16, 'Surat', 'Rajkot', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `schedule_id` int(11) NOT NULL,
  `bus_id` int(11) NOT NULL,
  `route_id` int(11) NOT NULL,
  `travel_date` date NOT NULL,
  `departure_time` time NOT NULL,
  `arrival_time` time NOT NULL,
  `fare` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`schedule_id`, `bus_id`, `route_id`, `travel_date`, `departure_time`, `arrival_time`, `fare`) VALUES
(6, 1, 6, '0000-00-00', '12:30:00', '05:40:00', 650.00),
(7, 6, 9, '0000-00-00', '00:00:00', '02:00:00', 980.00),
(8, 5, 6, '0000-00-00', '12:30:00', '15:10:00', 730.00),
(9, 6, 7, '0000-00-00', '16:20:00', '17:50:00', 770.00),
(10, 7, 7, '0000-00-00', '05:00:00', '05:30:00', 600.00),
(11, 6, 6, '0000-00-00', '16:30:00', '17:50:00', 770.00),
(12, 7, 6, '0000-00-00', '05:00:00', '06:30:00', 600.00),
(13, 5, 15, '0000-00-00', '14:15:00', '15:30:00', 650.00),
(14, 6, 16, '0000-00-00', '23:00:00', '23:50:00', 680.00);

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `seat_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `seat_number` varchar(5) NOT NULL,
  `status` enum('available','booked') DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`seat_id`, `schedule_id`, `seat_number`, `status`) VALUES
(1, 6, '1', 'available'),
(2, 6, '2', 'available'),
(3, 6, '3', 'available'),
(4, 6, '4', 'available'),
(5, 6, '5', 'available'),
(6, 6, '6', 'available'),
(7, 6, '7', 'available'),
(8, 6, '8', 'available'),
(9, 6, '9', 'available'),
(10, 6, '10', 'available'),
(11, 6, '11', 'available'),
(12, 6, '12', 'available'),
(13, 6, '13', 'available'),
(14, 6, '14', 'available'),
(15, 6, '15', 'available'),
(16, 6, '16', 'available'),
(17, 6, '17', 'available'),
(18, 6, '18', 'available'),
(19, 6, '19', 'available'),
(20, 6, '20', 'available'),
(21, 6, '21', 'available'),
(22, 6, '22', 'available'),
(23, 6, '23', 'available'),
(24, 6, '24', 'available'),
(25, 6, '25', 'available'),
(26, 6, '26', 'available'),
(27, 6, '27', 'available'),
(28, 6, '28', 'available'),
(29, 6, '29', 'available'),
(30, 6, '30', 'available'),
(31, 6, '31', 'available'),
(32, 6, '32', 'available'),
(33, 6, '33', 'available'),
(34, 6, '34', 'available'),
(35, 6, '35', 'available'),
(36, 6, '36', 'available'),
(37, 6, '37', 'available'),
(38, 6, '38', 'available'),
(39, 6, '39', 'available'),
(40, 6, '40', 'available'),
(121, 7, '1', 'available'),
(122, 8, '1', 'available'),
(123, 9, '1', 'available'),
(124, 10, '1', 'available'),
(125, 11, '1', 'available'),
(126, 12, '1', 'available'),
(127, 13, '1', 'available'),
(128, 14, '1', 'available'),
(129, 7, '2', 'available'),
(130, 8, '2', 'available'),
(131, 9, '2', 'available'),
(132, 10, '2', 'available'),
(133, 11, '2', 'available'),
(134, 12, '2', 'available'),
(135, 13, '2', 'available'),
(136, 14, '2', 'available'),
(137, 7, '3', 'available'),
(138, 8, '3', 'available'),
(139, 9, '3', 'available'),
(140, 10, '3', 'available'),
(141, 11, '3', 'available'),
(142, 12, '3', 'available'),
(143, 13, '3', 'available'),
(144, 14, '3', 'available'),
(145, 7, '4', 'available'),
(146, 8, '4', 'available'),
(147, 9, '4', 'available'),
(148, 10, '4', 'available'),
(149, 11, '4', 'available'),
(150, 12, '4', 'available'),
(151, 13, '4', 'available'),
(152, 14, '4', 'available'),
(153, 7, '5', 'available'),
(154, 8, '5', 'available'),
(155, 9, '5', 'available'),
(156, 10, '5', 'available'),
(157, 11, '5', 'available'),
(158, 12, '5', 'available'),
(159, 13, '5', 'available'),
(160, 14, '5', 'available'),
(161, 7, '6', 'available'),
(162, 8, '6', 'available'),
(163, 9, '6', 'available'),
(164, 10, '6', 'available'),
(165, 11, '6', 'available'),
(166, 12, '6', 'available'),
(167, 13, '6', 'available'),
(168, 14, '6', 'available'),
(169, 7, '7', 'available'),
(170, 8, '7', 'available'),
(171, 9, '7', 'available'),
(172, 10, '7', 'available'),
(173, 11, '7', 'available'),
(174, 12, '7', 'available'),
(175, 13, '7', 'available'),
(176, 14, '7', 'available'),
(177, 7, '8', 'available'),
(178, 8, '8', 'available'),
(179, 9, '8', 'available'),
(180, 10, '8', 'available'),
(181, 11, '8', 'available'),
(182, 12, '8', 'available'),
(183, 13, '8', 'available'),
(184, 14, '8', 'available'),
(185, 7, '9', 'available'),
(186, 8, '9', 'available'),
(187, 9, '9', 'available'),
(188, 10, '9', 'available'),
(189, 11, '9', 'available'),
(190, 12, '9', 'available'),
(191, 13, '9', 'available'),
(192, 14, '9', 'available'),
(193, 7, '10', 'available'),
(194, 8, '10', 'available'),
(195, 9, '10', 'available'),
(196, 10, '10', 'available'),
(197, 11, '10', 'available'),
(198, 12, '10', 'available'),
(199, 13, '10', 'available'),
(200, 14, '10', 'available'),
(201, 7, '11', 'available'),
(202, 8, '11', 'available'),
(203, 9, '11', 'available'),
(204, 10, '11', 'available'),
(205, 11, '11', 'available'),
(206, 12, '11', 'available'),
(207, 13, '11', 'available'),
(208, 14, '11', 'available'),
(209, 7, '12', 'available'),
(210, 8, '12', 'available'),
(211, 9, '12', 'available'),
(212, 10, '12', 'available'),
(213, 11, '12', 'available'),
(214, 12, '12', 'available'),
(215, 13, '12', 'available'),
(216, 14, '12', 'available'),
(217, 7, '13', 'available'),
(218, 8, '13', 'available'),
(219, 9, '13', 'available'),
(220, 10, '13', 'available'),
(221, 11, '13', 'available'),
(222, 12, '13', 'available'),
(223, 13, '13', 'available'),
(224, 14, '13', 'available'),
(225, 7, '14', 'available'),
(226, 8, '14', 'available'),
(227, 9, '14', 'available'),
(228, 10, '14', 'available'),
(229, 11, '14', 'available'),
(230, 12, '14', 'available'),
(231, 13, '14', 'available'),
(232, 14, '14', 'available'),
(233, 7, '15', 'available'),
(234, 8, '15', 'available'),
(235, 9, '15', 'available'),
(236, 10, '15', 'available'),
(237, 11, '15', 'available'),
(238, 12, '15', 'available'),
(239, 13, '15', 'available'),
(240, 14, '15', 'available'),
(241, 7, '16', 'available'),
(242, 8, '16', 'available'),
(243, 9, '16', 'available'),
(244, 10, '16', 'available'),
(245, 11, '16', 'available'),
(246, 12, '16', 'available'),
(247, 13, '16', 'available'),
(248, 14, '16', 'available'),
(249, 7, '17', 'available'),
(250, 8, '17', 'available'),
(251, 9, '17', 'available'),
(252, 10, '17', 'available'),
(253, 11, '17', 'available'),
(254, 12, '17', 'available'),
(255, 13, '17', 'available'),
(256, 14, '17', 'available'),
(257, 7, '18', 'available'),
(258, 8, '18', 'available'),
(259, 9, '18', 'available'),
(260, 10, '18', 'available'),
(261, 11, '18', 'available'),
(262, 12, '18', 'available'),
(263, 13, '18', 'available'),
(264, 14, '18', 'available'),
(265, 7, '19', 'available'),
(266, 8, '19', 'available'),
(267, 9, '19', 'available'),
(268, 10, '19', 'available'),
(269, 11, '19', 'available'),
(270, 12, '19', 'available'),
(271, 13, '19', 'available'),
(272, 14, '19', 'available'),
(273, 7, '20', 'available'),
(274, 8, '20', 'available'),
(275, 9, '20', 'available'),
(276, 10, '20', 'available'),
(277, 11, '20', 'available'),
(278, 12, '20', 'available'),
(279, 13, '20', 'available'),
(280, 14, '20', 'available'),
(281, 7, '21', 'available'),
(282, 8, '21', 'available'),
(283, 9, '21', 'available'),
(284, 10, '21', 'available'),
(285, 11, '21', 'available'),
(286, 12, '21', 'available'),
(287, 13, '21', 'available'),
(288, 14, '21', 'available'),
(289, 7, '22', 'available'),
(290, 8, '22', 'available'),
(291, 9, '22', 'available'),
(292, 10, '22', 'available'),
(293, 11, '22', 'available'),
(294, 12, '22', 'available'),
(295, 13, '22', 'available'),
(296, 14, '22', 'available'),
(297, 7, '23', 'available'),
(298, 8, '23', 'available'),
(299, 9, '23', 'available'),
(300, 10, '23', 'available'),
(301, 11, '23', 'available'),
(302, 12, '23', 'available'),
(303, 13, '23', 'available'),
(304, 14, '23', 'available'),
(305, 7, '24', 'available'),
(306, 8, '24', 'available'),
(307, 9, '24', 'available'),
(308, 10, '24', 'available'),
(309, 11, '24', 'available'),
(310, 12, '24', 'available'),
(311, 13, '24', 'available'),
(312, 14, '24', 'available'),
(313, 7, '25', 'available'),
(314, 8, '25', 'available'),
(315, 9, '25', 'available'),
(316, 10, '25', 'available'),
(317, 11, '25', 'available'),
(318, 12, '25', 'available'),
(319, 13, '25', 'available'),
(320, 14, '25', 'available'),
(321, 7, '26', 'available'),
(322, 8, '26', 'available'),
(323, 9, '26', 'available'),
(324, 10, '26', 'available'),
(325, 11, '26', 'available'),
(326, 12, '26', 'available'),
(327, 13, '26', 'available'),
(328, 14, '26', 'available'),
(329, 7, '27', 'available'),
(330, 8, '27', 'available'),
(331, 9, '27', 'available'),
(332, 10, '27', 'available'),
(333, 11, '27', 'available'),
(334, 12, '27', 'available'),
(335, 13, '27', 'available'),
(336, 14, '27', 'available'),
(337, 7, '28', 'available'),
(338, 8, '28', 'available'),
(339, 9, '28', 'available'),
(340, 10, '28', 'available'),
(341, 11, '28', 'available'),
(342, 12, '28', 'available'),
(343, 13, '28', 'available'),
(344, 14, '28', 'available'),
(345, 7, '29', 'available'),
(346, 8, '29', 'available'),
(347, 9, '29', 'available'),
(348, 10, '29', 'available'),
(349, 11, '29', 'available'),
(350, 12, '29', 'available'),
(351, 13, '29', 'available'),
(352, 14, '29', 'available'),
(353, 7, '30', 'available'),
(354, 8, '30', 'available'),
(355, 9, '30', 'available'),
(356, 10, '30', 'available'),
(357, 11, '30', 'available'),
(358, 12, '30', 'available'),
(359, 13, '30', 'available'),
(360, 14, '30', 'available'),
(361, 7, '31', 'available'),
(362, 8, '31', 'available'),
(363, 9, '31', 'available'),
(364, 10, '31', 'available'),
(365, 11, '31', 'available'),
(366, 12, '31', 'available'),
(367, 13, '31', 'available'),
(368, 14, '31', 'available'),
(369, 7, '32', 'available'),
(370, 8, '32', 'available'),
(371, 9, '32', 'available'),
(372, 10, '32', 'available'),
(373, 11, '32', 'available'),
(374, 12, '32', 'available'),
(375, 13, '32', 'available'),
(376, 14, '32', 'available'),
(377, 7, '33', 'available'),
(378, 8, '33', 'available'),
(379, 9, '33', 'available'),
(380, 10, '33', 'available'),
(381, 11, '33', 'available'),
(382, 12, '33', 'available'),
(383, 13, '33', 'available'),
(384, 14, '33', 'available'),
(385, 7, '34', 'available'),
(386, 8, '34', 'available'),
(387, 9, '34', 'available'),
(388, 10, '34', 'available'),
(389, 11, '34', 'available'),
(390, 12, '34', 'available'),
(391, 13, '34', 'available'),
(392, 14, '34', 'available'),
(393, 7, '35', 'available'),
(394, 8, '35', 'available'),
(395, 9, '35', 'available'),
(396, 10, '35', 'available'),
(397, 11, '35', 'available'),
(398, 12, '35', 'available'),
(399, 13, '35', 'available'),
(400, 14, '35', 'available'),
(401, 7, '36', 'available'),
(402, 8, '36', 'available'),
(403, 9, '36', 'available'),
(404, 10, '36', 'available'),
(405, 11, '36', 'available'),
(406, 12, '36', 'available'),
(407, 13, '36', 'available'),
(408, 14, '36', 'available'),
(409, 7, '37', 'available'),
(410, 8, '37', 'available'),
(411, 9, '37', 'available'),
(412, 10, '37', 'available'),
(413, 11, '37', 'available'),
(414, 12, '37', 'available'),
(415, 13, '37', 'available'),
(416, 14, '37', 'available'),
(417, 7, '38', 'available'),
(418, 8, '38', 'available'),
(419, 9, '38', 'available'),
(420, 10, '38', 'available'),
(421, 11, '38', 'available'),
(422, 12, '38', 'available'),
(423, 13, '38', 'available'),
(424, 14, '38', 'available'),
(425, 7, '39', 'available'),
(426, 8, '39', 'available'),
(427, 9, '39', 'available'),
(428, 10, '39', 'available'),
(429, 11, '39', 'available'),
(430, 12, '39', 'available'),
(431, 13, '39', 'available'),
(432, 14, '39', 'available'),
(433, 7, '40', 'available'),
(434, 8, '40', 'available'),
(435, 9, '40', 'available'),
(436, 10, '40', 'available'),
(437, 11, '40', 'available'),
(438, 12, '40', 'available'),
(439, 13, '40', 'available'),
(440, 14, '40', 'available');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `birth_dt` date DEFAULT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `gender` enum('male','female','other') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `phone`, `password`, `birth_dt`, `role`, `created_at`, `gender`) VALUES
(6, 'abcd', 'abc@gmail.com', '9876543221', '$2y$10$HgaDz6.i8AQjQkZkxsFqqepg2oACZ6LQCcsURLhg2KD3wcm9Z3.GC', '2012-02-02', 'user', '2026-06-01 10:12:22', 'male');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `schedule_id` (`schedule_id`);

--
-- Indexes for table `buses`
--
ALTER TABLE `buses`
  ADD PRIMARY KEY (`bus_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`route_id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `bus_id` (`bus_id`),
  ADD KEY `route_id` (`route_id`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`seat_id`),
  ADD KEY `schedule_id` (`schedule_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `buses`
--
ALTER TABLE `buses`
  MODIFY `bus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `route_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `seat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=441;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`schedule_id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`) ON DELETE CASCADE;

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_ibfk_1` FOREIGN KEY (`bus_id`) REFERENCES `buses` (`bus_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `schedules_ibfk_2` FOREIGN KEY (`route_id`) REFERENCES `routes` (`route_id`) ON DELETE CASCADE;

--
-- Constraints for table `seats`
--
ALTER TABLE `seats`
  ADD CONSTRAINT `seats_ibfk_1` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`schedule_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
