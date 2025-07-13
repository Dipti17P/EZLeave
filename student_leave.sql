-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2025 at 11:57 AM
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
-- Database: `student_leave`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_calendar`
--

CREATE TABLE `academic_calendar` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `event_type` enum('holiday','exam','other') NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `academic_calendar`
--

INSERT INTO `academic_calendar` (`id`, `date`, `event_type`, `description`) VALUES
(1, '2025-01-14', 'holiday', 'Makar Sankranti / Pongal'),
(2, '2025-01-26', 'holiday', 'Republic Day'),
(3, '2025-03-01', 'holiday', 'Maha Shivratri'),
(4, '2025-03-17', 'holiday', 'Holi'),
(5, '2025-03-29', 'holiday', 'Good Friday'),
(6, '2025-04-10', 'holiday', 'Eid al-Fitr (Ramzan Eid)'),
(7, '2025-04-13', 'holiday', 'Vaisakhi'),
(8, '2025-05-23', 'holiday', 'Buddha Purnima'),
(9, '2025-06-17', 'holiday', 'Bakrid / Eid al-Adha'),
(10, '2025-07-17', 'holiday', 'Muharram'),
(11, '2025-08-15', 'holiday', 'Independence Day'),
(12, '2025-08-19', 'holiday', 'Raksha Bandhan'),
(13, '2025-08-26', 'holiday', 'Janmashtami'),
(14, '2025-09-07', 'holiday', 'Ganesh Chaturthi'),
(15, '2025-10-02', 'holiday', 'Gandhi Jayanti'),
(16, '2025-10-03', 'holiday', 'Maha Ashtami'),
(17, '2025-10-12', 'holiday', 'Dussehra'),
(18, '2025-10-31', 'holiday', 'Diwali'),
(19, '2025-11-01', 'holiday', 'Govardhan Puja'),
(20, '2025-11-03', 'holiday', 'Bhai Dooj'),
(21, '2025-11-07', 'holiday', 'Chhath Puja'),
(22, '2025-12-25', 'holiday', 'Christmas Day');

-- --------------------------------------------------------

--
-- Table structure for table `leave_quota`
--

CREATE TABLE `leave_quota` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `sick` int(11) DEFAULT 5,
  `casual` int(11) DEFAULT 5,
  `exam` int(11) DEFAULT 5
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_requests`
--

CREATE TABLE `leave_requests` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `type` enum('sick','casual','exam') NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `reason` text DEFAULT NULL,
  `document` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leave_requests`
--

INSERT INTO `leave_requests` (`id`, `student_id`, `type`, `from_date`, `to_date`, `reason`, `document`, `status`, `remarks`, `created_at`) VALUES
(1, 1, 'casual', '2025-06-17', '2025-06-18', 'qwer', '6851207b48a6a_Screenshot 2025-03-26 193825.png', 'Rejected', '', '2025-06-17 07:59:55'),
(2, 1, 'sick', '2025-06-19', '2025-06-27', 'dad', '', 'Approved', '', '2025-06-17 08:02:38');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `is_read`, `created_at`) VALUES
(1, 1, 'Your leave from 2025-06-19 to 2025-06-27 has been Approved.', 0, '2025-06-17 08:23:16'),
(2, 1, 'Your leave from 2025-06-17 to 2025-06-18 has been Rejected.', 0, '2025-06-17 08:23:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','faculty','admin') NOT NULL DEFAULT 'student',
  `dept` varchar(50) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `dept`, `year`, `reset_token`, `created_at`) VALUES
(1, 'Dipti Pravin Patil', 'diptipatil1722@gmail.com', '$2y$10$Er3uLK36CgxIqk9Ago0Vz.mu8qTcHpTc0OYI/HuU4lgiIBcLVmQli', 'student', 'Computer', 2025, '9a925a137a245f048d1352824f29349487bae4b95c127c2caccee1c991bf28ea', '2025-06-17 07:47:12'),
(2, 'Mrunali Patil', 'kavitapatil1722@gmail.com', '$2y$10$PSR86ZpbpZDYzSu7jTjf/e1Bg5cyt8cH/MscgMmOR2B/oDFguq6dW', 'admin', 'IT', 2025, NULL, '2025-06-17 07:47:51'),
(3, 'Divya Patil', 'dp3133486@gmai.com', '$2y$10$Ill/7lnJWR3eb4QrOqkBj.3Oc.CE3BgIrZI0Uh/u4Q74gvAH.a0dG', 'admin', 'IT', NULL, NULL, '2025-06-17 08:28:25'),
(4, 'kavita patil', 'kavita@gmail.com', '$2y$10$RjgNx1v0NRbEBLoJ34R4h.ws4bGOpY1tclSfaBrDa.MXprw8t1Dhy', 'student', 'IT', NULL, NULL, '2025-06-17 09:21:13'),
(5, 'pravin patil', 'pravin@gmai.com', '$2y$10$j/fF0SBY8DC6z2A83oarrO09r.rwmyQy23uW2X3YBu90tG62dwxOK', 'student', 'electrical', NULL, NULL, '2025-06-17 09:24:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_calendar`
--
ALTER TABLE `academic_calendar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_quota`
--
ALTER TABLE `leave_quota`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_calendar`
--
ALTER TABLE `academic_calendar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `leave_quota`
--
ALTER TABLE `leave_quota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_requests`
--
ALTER TABLE `leave_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `leave_quota`
--
ALTER TABLE `leave_quota`
  ADD CONSTRAINT `leave_quota_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD CONSTRAINT `leave_requests_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
