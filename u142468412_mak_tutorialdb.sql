-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 22, 2024 at 12:03 PM
-- Server version: 10.11.8-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mak_tutorialdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `user_name` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `full_name`, `contact`, `email`, `password`, `user_name`, `created_at`, `updated_at`) VALUES
(1, 'Mohsin khan', '9930076555', 'mohsin.mohisn6@gmail.com', 'mmkmnkak', '', '2024-08-16 15:48:06', '2024-08-16 15:48:06'),
(2, 'mohsin mohammad shamim khan', '8369286385', 'santrapvtltd@gmaill.com', 'abcd', 'admin', '2024-08-16 15:49:27', '2024-08-16 15:49:27');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `student_id` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'present',
  `attendance_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `batch_id`, `student_id`, `status`, `attendance_date`) VALUES
(2, 1, 'ayraparmar', 'present', '2024-08-16 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_record`
--

CREATE TABLE `attendance_record` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance_record`
--

INSERT INTO `attendance_record` (`id`, `student_id`, `date`, `status`, `created_at`, `updated_at`) VALUES
(0, 1, '2024-09-07', 'Holiday', '2024-09-12 10:24:09', '2024-09-12 10:24:09'),
(0, 2, '2024-09-07', 'Holiday', '2024-09-12 10:24:09', '2024-09-12 10:24:09'),
(0, 3, '2024-09-07', 'Holiday', '2024-09-12 10:24:09', '2024-09-12 10:24:09'),
(0, 4, '2024-09-07', 'Holiday', '2024-09-12 10:24:09', '2024-09-12 10:24:09'),
(0, 9, '2024-09-07', 'Holiday', '2024-09-12 10:24:09', '2024-09-12 10:24:09'),
(0, 11, '2024-09-07', 'Holiday', '2024-09-12 10:24:09', '2024-09-12 10:24:09'),
(0, 12, '2024-09-07', 'Holiday', '2024-09-12 10:24:09', '2024-09-12 10:24:09'),
(0, 14, '2024-09-07', 'Holiday', '2024-09-12 10:24:09', '2024-09-12 10:24:09'),
(0, 1, '2024-09-14', 'Present', '2024-09-14 12:41:53', '2024-09-14 12:41:53'),
(0, 2, '2024-09-14', 'Present', '2024-09-14 12:41:53', '2024-09-14 12:41:53'),
(0, 3, '2024-09-14', 'Present', '2024-09-14 12:41:53', '2024-09-14 12:41:53'),
(0, 4, '2024-09-14', 'Present', '2024-09-14 12:41:53', '2024-09-14 12:41:53'),
(0, 9, '2024-09-14', 'Present', '2024-09-14 12:41:53', '2024-09-14 12:41:53'),
(0, 11, '2024-09-14', 'Present', '2024-09-14 12:41:53', '2024-09-14 12:41:53'),
(0, 12, '2024-09-14', 'Present', '2024-09-14 12:41:53', '2024-09-14 12:41:53'),
(0, 14, '2024-09-14', 'Present', '2024-09-14 12:41:53', '2024-09-14 12:41:53'),
(0, 15, '2024-09-14', 'Present', '2024-09-14 12:41:53', '2024-09-14 12:41:53'),
(0, 16, '2024-09-14', 'Present', '2024-09-14 12:41:53', '2024-09-14 12:41:53'),
(0, 17, '2024-09-14', 'Present', '2024-09-14 12:41:53', '2024-09-14 12:41:53'),
(0, 21, '2024-09-14', 'Present', '2024-09-14 12:41:53', '2024-09-14 12:41:53'),
(0, 22, '2024-09-14', 'Present', '2024-09-14 12:41:53', '2024-09-14 12:41:53'),
(0, 23, '2024-09-14', 'Present', '2024-09-14 12:41:53', '2024-09-14 12:41:53'),
(0, 24, '2024-09-14', 'Present', '2024-09-14 12:41:53', '2024-09-14 12:41:53'),
(0, 25, '2024-09-14', 'Present', '2024-09-14 12:41:53', '2024-09-14 12:41:53'),
(0, 15, '2024-09-07', 'Holiday', '2024-09-14 14:19:09', '2024-09-14 14:19:09'),
(0, 16, '2024-09-07', 'Holiday', '2024-09-14 14:19:09', '2024-09-14 14:19:09'),
(0, 17, '2024-09-07', 'Holiday', '2024-09-14 14:19:09', '2024-09-14 14:19:09'),
(0, 21, '2024-09-07', 'Holiday', '2024-09-14 14:19:09', '2024-09-14 14:19:09'),
(0, 22, '2024-09-07', 'Holiday', '2024-09-14 14:19:09', '2024-09-14 14:19:09'),
(0, 23, '2024-09-07', 'Holiday', '2024-09-14 14:19:09', '2024-09-14 14:19:09'),
(0, 24, '2024-09-07', 'Holiday', '2024-09-14 14:19:09', '2024-09-14 14:19:09'),
(0, 25, '2024-09-07', 'Holiday', '2024-09-14 14:19:09', '2024-09-14 14:19:09'),
(0, 1, '2024-09-16', 'Holiday', '2024-09-16 18:50:14', '2024-09-16 18:50:14'),
(0, 2, '2024-09-16', 'Holiday', '2024-09-16 18:50:14', '2024-09-16 18:50:14'),
(0, 3, '2024-09-16', 'Holiday', '2024-09-16 18:50:14', '2024-09-16 18:50:14'),
(0, 4, '2024-09-16', 'Holiday', '2024-09-16 18:50:14', '2024-09-16 18:50:14'),
(0, 9, '2024-09-16', 'Holiday', '2024-09-16 18:50:14', '2024-09-16 18:50:14'),
(0, 11, '2024-09-16', 'Holiday', '2024-09-16 18:50:14', '2024-09-16 18:50:14'),
(0, 12, '2024-09-16', 'Holiday', '2024-09-16 18:50:14', '2024-09-16 18:50:14'),
(0, 14, '2024-09-16', 'Holiday', '2024-09-16 18:50:14', '2024-09-16 18:50:14'),
(0, 15, '2024-09-16', 'Holiday', '2024-09-16 18:50:14', '2024-09-16 18:50:14'),
(0, 16, '2024-09-16', 'Holiday', '2024-09-16 18:50:14', '2024-09-16 18:50:14'),
(0, 17, '2024-09-16', 'Holiday', '2024-09-16 18:50:14', '2024-09-16 18:50:14'),
(0, 21, '2024-09-16', 'Holiday', '2024-09-16 18:50:14', '2024-09-16 18:50:14'),
(0, 22, '2024-09-16', 'Holiday', '2024-09-16 18:50:14', '2024-09-16 18:50:14'),
(0, 23, '2024-09-16', 'Holiday', '2024-09-16 18:50:14', '2024-09-16 18:50:14'),
(0, 24, '2024-09-16', 'Holiday', '2024-09-16 18:50:14', '2024-09-16 18:50:14'),
(0, 25, '2024-09-16', 'Holiday', '2024-09-16 18:50:14', '2024-09-16 18:50:14'),
(0, 1, '2024-09-19', 'Holiday', '2024-09-19 06:31:49', '2024-09-19 06:31:49'),
(0, 2, '2024-09-19', 'Holiday', '2024-09-19 06:31:49', '2024-09-19 06:31:49'),
(0, 3, '2024-09-19', 'Holiday', '2024-09-19 06:31:49', '2024-09-19 06:31:49'),
(0, 4, '2024-09-19', 'Holiday', '2024-09-19 06:31:49', '2024-09-19 06:31:49'),
(0, 9, '2024-09-19', 'Holiday', '2024-09-19 06:31:49', '2024-09-19 06:31:49'),
(0, 11, '2024-09-19', 'Holiday', '2024-09-19 06:31:49', '2024-09-19 06:31:49'),
(0, 12, '2024-09-19', 'Holiday', '2024-09-19 06:31:49', '2024-09-19 06:31:49'),
(0, 14, '2024-09-19', 'Holiday', '2024-09-19 06:31:49', '2024-09-19 06:31:49'),
(0, 15, '2024-09-19', 'Holiday', '2024-09-19 06:31:49', '2024-09-19 06:31:49'),
(0, 16, '2024-09-19', 'Holiday', '2024-09-19 06:31:49', '2024-09-19 06:31:49'),
(0, 17, '2024-09-19', 'Holiday', '2024-09-19 06:31:49', '2024-09-19 06:31:49'),
(0, 21, '2024-09-19', 'Holiday', '2024-09-19 06:31:49', '2024-09-19 06:31:49'),
(0, 22, '2024-09-19', 'Holiday', '2024-09-19 06:31:49', '2024-09-19 06:31:49'),
(0, 23, '2024-09-19', 'Holiday', '2024-09-19 06:31:49', '2024-09-19 06:31:49'),
(0, 24, '2024-09-19', 'Holiday', '2024-09-19 06:31:49', '2024-09-19 06:31:49'),
(0, 25, '2024-09-19', 'Holiday', '2024-09-19 06:31:49', '2024-09-19 06:31:49'),
(0, 26, '2024-09-19', 'Holiday', '2024-09-19 06:31:49', '2024-09-19 06:31:49'),
(0, 27, '2024-09-19', 'Holiday', '2024-09-19 06:31:49', '2024-09-19 06:31:49'),
(0, 28, '2024-09-19', 'Holiday', '2024-09-19 06:31:49', '2024-09-19 06:31:49');

-- --------------------------------------------------------

--
-- Table structure for table `batch`
--

CREATE TABLE `batch` (
  `batch_id` varchar(200) NOT NULL,
  `batch_name` varchar(200) NOT NULL,
  `batch_location` varchar(200) NOT NULL,
  `batch_teacher` varchar(200) NOT NULL,
  `batch_time` varchar(200) NOT NULL,
  `batch_days` varchar(200) NOT NULL,
  `batch_maximum_slot` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `batch`
--

INSERT INTO `batch` (`batch_id`, `batch_name`, `batch_location`, `batch_teacher`, `batch_time`, `batch_days`, `batch_maximum_slot`) VALUES
('1', '9th', 'Kanaia', 'Mohsin', '3:00', 'All', '10');

-- --------------------------------------------------------

--
-- Table structure for table `enquiry`
--

CREATE TABLE `enquiry` (
  `enquiry_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `course_interested` varchar(255) NOT NULL,
  `enquiry_date` date DEFAULT curdate(),
  `status` enum('Pending','Contacted','Joined','Not Interested') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enquiry`
--

INSERT INTO `enquiry` (`enquiry_id`, `full_name`, `contact_number`, `email`, `course_interested`, `enquiry_date`, `status`, `created_at`, `updated_at`) VALUES
(3, 'Ashmitha mamidi', '8374737039', 'asmiamith@gmail.com', '11th cbse maths jee ', '2024-09-18', 'Pending', '2024-09-18 07:04:24', '2024-09-18 07:04:24');

-- --------------------------------------------------------

--
-- Table structure for table `fees_chart`
--

CREATE TABLE `fees_chart` (
  `fc_id` int(11) NOT NULL,
  `board_exam` varchar(50) DEFAULT NULL,
  `std` varchar(50) DEFAULT NULL,
  `yearly_fees` double DEFAULT NULL,
  `monthly_fees` double DEFAULT NULL,
  `remarks` varchar(50) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `fees_chart`
--

INSERT INTO `fees_chart` (`fc_id`, `board_exam`, `std`, `yearly_fees`, `monthly_fees`, `remarks`, `subject`) VALUES
(1, 'state board', '10', 40000, 3, 'total fees can be reduced if installment reduced', NULL),
(2, 'maharashtra board', '12', 48000, 3, 'total fees can be reduced ', NULL),
(5, 'maharashtra board', '9', 35000, 0, 'above 90 will get 1000 off', 'all');

-- --------------------------------------------------------

--
-- Table structure for table `fees_record`
--

CREATE TABLE `fees_record` (
  `fr_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `total_fees` double NOT NULL,
  `received_fees` double NOT NULL,
  `balance_fees` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fees_record`
--

INSERT INTO `fees_record` (`fr_id`, `student_id`, `total_fees`, `received_fees`, `balance_fees`, `created_at`, `updated_at`) VALUES
(1, 2, 70000, 40000, 30000, '2024-09-03 06:20:48', '2024-09-06 09:45:57'),
(2, 1, 30000, 30000, 0, '2024-09-03 06:22:08', '2024-09-03 06:22:08'),
(3, 9, 1050000, 30000, 54544555, '2024-09-04 10:46:06', '2024-09-04 10:46:06');

-- --------------------------------------------------------

--
-- Table structure for table `installments`
--

CREATE TABLE `installments` (
  `id` int(11) NOT NULL,
  `fr_id` int(11) NOT NULL,
  `installment_no` int(11) NOT NULL,
  `amount` double NOT NULL,
  `due_date` date DEFAULT NULL,
  `receive_date` date DEFAULT NULL,
  `payment_mode` enum('Cash','Card','Bank Transfer') DEFAULT NULL,
  `status` enum('Pending','Paid','Overdue') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `installments`
--

INSERT INTO `installments` (`id`, `fr_id`, `installment_no`, `amount`, `due_date`, `receive_date`, `payment_mode`, `status`) VALUES
(1, 1, 3, 30000, '2024-10-01', '2024-07-01', 'Cash', 'Pending'),
(2, 2, 3, 30000, NULL, NULL, 'Bank Transfer', 'Paid'),
(3, 3, 8, 10000, '2024-09-05', '2024-09-30', 'Cash', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `satff_table`
--

CREATE TABLE `satff_table` (
  `photo` varchar(200) NOT NULL,
  `staff_id` varchar(200) NOT NULL,
  `staff_name` varchar(200) DEFAULT NULL,
  `parent_name` varchar(200) NOT NULL,
  `mobile_no` varchar(200) NOT NULL,
  `gender` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `staff_type` varchar(200) NOT NULL,
  `salary_type` varchar(200) NOT NULL,
  `salary_ammount` varchar(200) NOT NULL,
  `start_date` date NOT NULL,
  `specialization` varchar(200) NOT NULL,
  `qualification` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_record`
--

CREATE TABLE `student_record` (
  `photo` varchar(200) DEFAULT NULL,
  `student_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `roll_no` varchar(200) DEFAULT NULL,
  `parent_name` varchar(200) NOT NULL,
  `dob` date NOT NULL,
  `mobile_no` varchar(200) NOT NULL,
  `gender` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `batch_name` varchar(200) DEFAULT NULL,
  `start_date` date NOT NULL,
  `class_subject` varchar(200) DEFAULT NULL,
  `school_college` varchar(200) NOT NULL,
  `attachment` varchar(200) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `std` varchar(100) NOT NULL,
  `reciept_no` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `student_record`
--

INSERT INTO `student_record` (`photo`, `student_id`, `first_name`, `last_name`, `roll_no`, `parent_name`, `dob`, `mobile_no`, `gender`, `address`, `batch_name`, `start_date`, `class_subject`, `school_college`, `attachment`, `email`, `std`, `reciept_no`) VALUES
('../student_pic/AaishaNakhwa.jpg', 1, 'Aaisha', 'Nakhwa', '1', 'Aslam', '2010-02-27', '9372653171', 'Female', '603, Tulip/A , Tulip-Orchid , Jangid Enclave , Kanakia Road , Mira Road (e)', '9th Std', '2023-06-01', '0', 'Sardar Vallabhai Pateli Vidyaalya', '', NULL, '9th', 0),
('../student_pic/AyraParmar.jpg', 2, 'Ayra', 'Parmar', '2', 'Arif', '2008-10-20', '9920212707', 'Female', 'JANGID ENCLAVE , KANAKIA ROAD , ORCHID TULIP - A - 1101', '9th ', '2023-06-01', 'PCM', 'Al - Muminal School', '', NULL, '10th', 0),
('../student_pic/barirakhan.jpg', 3, 'barira', 'khan', '3', 'shabnam', '2005-11-29', '589484733', 'Female', 'mira road', 'computer', '2024-08-01', '0', 'nirmala', '', NULL, 'BSCCS', 0),
('../student_pic/ZikraParmar.jpg', 4, 'zikra', 'Parmar', '4', 'arif', '0000-00-00', '', '', '', '', '0000-00-00', '', '', '', NULL, '', 0),
('../student_pic/athiya anjumshaikh.jpg', 9, 'athiya anjum', 'shaikh', '0', '', '2007-11-05', '7738258185', 'female', 'jangid enclave', 'science', '2024-08-12', 'pcb', 'xavier', NULL, NULL, '12th', 0),
('../student_pic/IsaaShaikh.jpg', 11, 'Isaaaa', 'Shaikh', '36', '', '2005-09-08', '07208 532487', 'male', 'Ostwal orchid  bld no. 8/1106 Miraroad (e) Kanakia road near Galaxy hospital', 'b2', '2024-09-08', 'C++', 'Shree Lr tiwari', NULL, NULL, 'BE ENG', 0),
('../student_pic/HamzaShaikh.jpg', 12, 'Hamza', 'Shaikh', '29', '', '2004-03-08', '7045006672', 'male', '1106 Ostwal Orchid 8 Kanakia road', 'Batch - 3', '2024-08-01', 'Calculas', 'SLRTDC', NULL, NULL, 'BSCDS', 9),
('../student_pic/MehekShaokh.jpg', 14, 'Mehek', 'Shaikh', '0', '', '2005-10-07', '9321982447', 'female', 'Mira road', '', '2024-09-09', '', 'Lr tiwari ', NULL, NULL, 'BSCIT', 0),
('../student_pic/Ibrahim Shaikh.jpg', 15, 'Ibrahim ', 'Shaikh', '0', '', '2006-04-03', '932626252525', 'male', 'Mira road ', '', '2024-08-01', '', 'Lr tiwari ', NULL, NULL, 'BSCCS', 0),
('../student_pic/Sukoon Pinzara.jpg', 16, 'Sukoon ', 'Pinzara', '0', '', '2006-11-01', '9930102269', 'female', 'Delta garden', '', '2023-06-01', '', 'Shree lr tiwari degree college ', NULL, NULL, '12th', 0),
('../student_pic/ZiyaanShaikh.jpg', 17, 'Ziyaan', 'Shaikh', '58', '', '2011-03-03', '+91 80973 68030', 'male', 'Room403,4th floor ,Asmita Anita ,opp asmita ', '', '2024-09-14', 'All', 'St Jude high school', NULL, NULL, '8th', 0),
('../student_pic/SafiyaGhatkai.jpg', 21, 'Safiya', 'Ghatkai', '0', '', '2006-12-25', '8452077828', 'female', 'Sita smruti,Naya nagar', '', '2024-05-11', '', 'ST.Xavier\'s College', NULL, NULL, '12th', 0),
('../student_pic/Feona Fatima Sayed.jpg', 22, 'Feona Fatima ', 'Sayed', '0', '', '2007-12-10', '8652387882', 'female', 'Mira tabassum, Naya nagar', '', '2024-09-14', '', 'Shree lr tiwari junior college ', NULL, NULL, '12th', 0),
('../student_pic/Samia Kazi.jpg', 23, 'Samia ', 'Kazi', '0', '', '2004-11-12', '7045658303', 'female', 'Archana Jyoti CHSL, Bldg B-8, Flat 302, Sector 11, Shanti Nagar, Mira Road (E), Thane 401107.', '', '2023-05-23', '', 'Royal College of Arts, Science and Commerce ', NULL, NULL, 'BSCCS', 0),
('../student_pic/AyaanShaikh.jpg', 24, 'Ayaan', 'Shaikh', '0', '', '2011-09-01', '9619680859', 'male', 'Asmita rose , a wing , 402, mira road ', '', '2024-09-14', 'All', 'St judes', NULL, NULL, '8th', 0),
('../student_pic/SufiyaanKhan.jpg', 25, 'Sufiyaan', 'Khan', '0', '', '2006-08-29', '9324762800', 'male', 'A1,102 N.G Estate ,mira road (e),Thane 41107', '', '0000-00-00', '', 'Lr tiwari ', NULL, NULL, 'BSCIT', 0),
('../student_pic/Ayra Parmar.jpg', 26, 'Ayra ', 'Parmar', '0', '', '2008-10-22', '9321452646', 'female', 'Spring rose  B wing 705', '', '2024-09-17', '', 'Al muminah', NULL, NULL, '10th', 0),
('../student_pic/HumairahParmar.jpg', 27, 'Humairah', 'Parmar', '0', '', '2013-10-04', '9920620807', 'female', 'Spring rose  B wing 705', '', '2024-09-17', 'All', 'Al muminah ', NULL, NULL, '8th', 0),
('../student_pic/LaxmiSingh .jpg', 28, 'Laxmi', 'Singh ', '0', '', '2009-11-22', '8657350711', 'female', 'Ridhi sidhi, Laxmi park, Kanakia road', '', '2024-09-18', 'All', 'R.K. English High school ', NULL, NULL, '10th', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`);

--
-- Indexes for table `batch`
--
ALTER TABLE `batch`
  ADD PRIMARY KEY (`batch_id`(50));

--
-- Indexes for table `enquiry`
--
ALTER TABLE `enquiry`
  ADD PRIMARY KEY (`enquiry_id`);

--
-- Indexes for table `fees_chart`
--
ALTER TABLE `fees_chart`
  ADD PRIMARY KEY (`fc_id`);

--
-- Indexes for table `fees_record`
--
ALTER TABLE `fees_record`
  ADD PRIMARY KEY (`fr_id`);

--
-- Indexes for table `installments`
--
ALTER TABLE `installments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fr_id` (`fr_id`);

--
-- Indexes for table `satff_table`
--
ALTER TABLE `satff_table`
  ADD PRIMARY KEY (`staff_id`(50));

--
-- Indexes for table `student_record`
--
ALTER TABLE `student_record`
  ADD PRIMARY KEY (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `enquiry`
--
ALTER TABLE `enquiry`
  MODIFY `enquiry_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fees_chart`
--
ALTER TABLE `fees_chart`
  MODIFY `fc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `fees_record`
--
ALTER TABLE `fees_record`
  MODIFY `fr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `installments`
--
ALTER TABLE `installments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student_record`
--
ALTER TABLE `student_record`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `installments`
--
ALTER TABLE `installments`
  ADD CONSTRAINT `installments_ibfk_1` FOREIGN KEY (`fr_id`) REFERENCES `fees_record` (`fr_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
