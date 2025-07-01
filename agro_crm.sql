-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 30, 2025 at 09:58 PM
-- Server version: 10.5.27-MariaDB
-- PHP Version: 8.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `agro_crm`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_leads`
--

CREATE TABLE `tbl_leads` (
  `lead_indx` int(11) NOT NULL,
  `lead_id` varchar(60) NOT NULL,
  `lead_name` varchar(100) NOT NULL,
  `lead_email` varchar(100) DEFAULT NULL,
  `lead_phone` bigint(20) DEFAULT NULL,
  `lead_enquiry_for` varchar(255) DEFAULT NULL,
  `lead_type` varchar(100) DEFAULT NULL,
  `lead_status` varchar(100) DEFAULT NULL,
  `lead_address` text DEFAULT NULL,
  `lead_given_date` varchar(100) DEFAULT NULL,
  `lead_user_id` varchar(60) DEFAULT NULL,
  `lead_assigned_user` varchar(60) NOT NULL,
  `lead_create_date` datetime DEFAULT current_timestamp(),
  `lead_update_date` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `lead_delete` enum('Y','N') DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_indx` int(11) NOT NULL,
  `user_key` varchar(60) NOT NULL,
  `user_fname` varchar(100) DEFAULT NULL,
  `user_mname` varchar(100) DEFAULT NULL,
  `user_lname` varchar(100) DEFAULT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `user_phone` double DEFAULT NULL,
  `user_mobile` double DEFAULT NULL,
  `user_gender` varchar(60) DEFAULT NULL,
  `user_login_name` varchar(60) NOT NULL,
  `user_status` int(11) DEFAULT NULL,
  `user_role` varchar(60) DEFAULT NULL,
  `user_verified` varchar(60) DEFAULT NULL,
  `user_email_vrified` varchar(60) DEFAULT NULL,
  `user_email_token` text DEFAULT NULL,
  `user_image` text DEFAULT NULL,
  `user_permissions` longtext DEFAULT NULL,
  `user_create_date` datetime DEFAULT current_timestamp(),
  `user_update_date` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_password` text DEFAULT NULL,
  `user_remarks` longtext NOT NULL,
  `user_otp` int(11) DEFAULT NULL,
  `user_delete` enum('Y','N') DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_leads`
--
ALTER TABLE `tbl_leads`
  ADD PRIMARY KEY (`lead_id`,`lead_name`,`lead_assigned_user`),
  ADD UNIQUE KEY `lead_indx` (`lead_indx`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_key`),
  ADD UNIQUE KEY `user_indx` (`user_indx`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_leads`
--
ALTER TABLE `tbl_leads`
  MODIFY `lead_indx` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_indx` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
