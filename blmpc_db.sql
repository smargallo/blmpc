-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 13, 2023 at 03:29 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blmpc_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `events_tbl`
--

CREATE TABLE `events_tbl` (
  `id` int NOT NULL,
  `event_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `event_date` date NOT NULL,
  `event_description` text COLLATE utf8mb4_general_ci NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `google_calendar_link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events_tbl`
--

INSERT INTO `events_tbl` (`id`, `event_name`, `event_date`, `event_description`, `image_path`, `google_calendar_link`) VALUES
(1, 'Christmas Party', '2023-12-13', 'Celebrate with us!', 'events_banner/6578770473da0.png', 'https://www.google.com/calendar/event?eid=ZmxuOWJmY3ZldDFtN3ZjZ2xhOHBhaXUzNzAgcGFkYXloYWdqZXNzYUBt'),
(2, 'Testing past events', '2023-12-01', 'Testing', 'events_banner/6578819eae2b4.jpg', 'https://www.google.com/calendar/event?eid=azZzdHEzZW1sOWc1bmY4NDU3dHA0cmZyY2sgcGFkYXloYWdqZXNzYUBt'),
(3, 'Test', '2023-12-15', 'Test', 'events_banner/6579c1cccd5b2.png', 'https://www.google.com/calendar/event?eid=czVtMTA5ZWxuMDEzMWJpcGQ0YzV0MXUyc2cgcGFkYXloYWdqZXNzYUBt'),
(4, 'Commemoration of the life and works of José Rizal', '2023-12-30', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio, fuga quasi! Unde dolorem quis quidem dolore consequuntur deleniti. Blanditiis numquam harum consequuntur at modi possimus qui optio eveniet dolore labore.', 'events_banner/6579c7ab58735.jpg', 'https://www.google.com/calendar/event?eid=amNkYmFnamFhODQ1b2N2azJla2xqdDI3MWMgcGFkYXloYWdqZXNzYUBt'),
(5, 'New Year', '2024-01-01', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio, fuga quasi! Unde dolorem quis quidem dolore consequuntur deleniti. Blanditiis numquam harum consequuntur at modi possimus qui optio eveniet dolore labore.', 'events_banner/6579c9b087f14.png', 'https://www.google.com/calendar/event?eid=cjVoNHFhOGpnZDc2aG5hZzVsMW52dDcxNGcgcGFkYXloYWdqZXNzYUBt'),
(6, 'Regular Holiday', '2024-01-02', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio, fuga quasi! Unde dolorem quis quidem dolore consequuntur deleniti. Blanditiis numquam harum consequuntur at modi possimus qui optio eveniet dolore labore.', 'events_banner/6579ca45255ef.png', 'https://www.google.com/calendar/event?eid=bGxyOHM3YmlkMjR2dGpmcDlscjNjOHJuMjQgcGFkYXloYWdqZXNzYUBt');

-- --------------------------------------------------------

--
-- Table structure for table `members_tbl`
--

CREATE TABLE `members_tbl` (
  `id` int NOT NULL,
  `mem_id` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `middlename` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `extension` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `dob` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `age` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `pob` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `civil_status` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tin` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `mobile_number` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'None',
  `brgy` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `municipality` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `province` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_general_ci DEFAULT 'active',
  `region` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members_tbl`
--

INSERT INTO `members_tbl` (`id`, `mem_id`, `firstname`, `middlename`, `lastname`, `extension`, `dob`, `age`, `pob`, `civil_status`, `tin`, `mobile_number`, `email`, `address`, `brgy`, `municipality`, `province`, `image_path`, `status`, `region`) VALUES
(2, '202312121331', 'Shean Louise', 'Pamisa', 'Margallo', 'N/A', '1995-03-10', '28', 'Gimangpang Initao Mis. Or,', 'Married', '111111111111', '09215733164', 'sheanlouisemargallo@gmail.com', 'Sayre Highway, Zone 1B', 'SAN MIGUEL', 'MANOLO FORTICH', 'BUKIDNON', 'uploads/657867503c0a7.png', 'active', '10'),
(3, '202312125582', 'Jay Anne', 'Ratunil', 'Tan', 'N/A', '2003-01-01', '20', 'Initao, Mis. Or.', 'Married', '2222222', '09500060853', 'jayannet4@gmail.com', 'Fatima Village', 'ALAE', 'MANOLO FORTICH', 'BUKIDNON', 'uploads/657868706695d.png', 'active', '10');

-- --------------------------------------------------------

--
-- Table structure for table `sms_logs`
--

CREATE TABLE `sms_logs` (
  `id` int NOT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `date` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email_address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'super_admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email_address`, `username`, `password`, `type`) VALUES
(1, 'gylepmsd@sdfsdfdsfdnn', 'admin', 'admin', 'super_admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events_tbl`
--
ALTER TABLE `events_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members_tbl`
--
ALTER TABLE `members_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_logs`
--
ALTER TABLE `sms_logs`
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
-- AUTO_INCREMENT for table `events_tbl`
--
ALTER TABLE `events_tbl`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `members_tbl`
--
ALTER TABLE `members_tbl`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sms_logs`
--
ALTER TABLE `sms_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
