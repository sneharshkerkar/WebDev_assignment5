-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2023 at 11:28 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cubicle_booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `Admin_id` varchar(10) NOT NULL,
  `Username` varchar(100) NOT NULL,
  `Mobile_no` int(11) NOT NULL,
  `email_id` varchar(50) NOT NULL,
  `Password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Admin_id`, `Username`, `Mobile_no`, `email_id`, `Password`) VALUES
('an1', 'sjkjjk1', 2147483647, 'saishsawant25102001@gmail.com', '$2y$09$oOx1VFN4dr2HgAV.51FjseTlkRYwH0eII3sMvHqbPf8bTKD8myN3O'),
('h3', 'je3', 7537356, 'xyz@gmail.com', '$2y$09$MMzRucsg5Fy3CjL0CNC79eQfZGb5.Ss944gfXXMq26hcj6xRM1laS');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `Emp_ID` varchar(30) NOT NULL,
  `Cubicle_ID` varchar(30) NOT NULL,
  `Start_Time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `End_Time` timestamp NOT NULL DEFAULT current_timestamp(),
  `Booking_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`Emp_ID`, `Cubicle_ID`, `Start_Time`, `End_Time`, `Booking_ID`) VALUES
('ah1', '3j', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
('ja8', '3j', '2023-04-04 08:16:00', '2023-05-05 08:16:00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `cubicle`
--

CREATE TABLE `cubicle` (
  `cubicle_id` varchar(10) NOT NULL,
  `room` varchar(50) NOT NULL,
  `cubicle_no` int(11) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cubicle`
--

INSERT INTO `cubicle` (`cubicle_id`, `room`, `cubicle_no`, `status`) VALUES
('3j', 'a', 2, NULL),
('c21', 'b', 6, 'Available'),
('j23', 'a', 5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `Emp_id` varchar(10) NOT NULL,
  `First_name` varchar(30) NOT NULL,
  `Last_name` varchar(30) NOT NULL,
  `Mobile_no` int(11) NOT NULL,
  `email_id` varchar(50) NOT NULL,
  `Emp_photo` blob DEFAULT NULL,
  `Password` varchar(200) NOT NULL,
  `token` varchar(150) DEFAULT NULL,
  `exp_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`Emp_id`, `First_name`, `Last_name`, `Mobile_no`, `email_id`, `Emp_photo`, `Password`, `token`, `exp_date`) VALUES
('ah1', 'Sai', 'Kai', 2147483647, 'saishsawant25102001@gmail.com', 0x494d472d32303232303630322d5741303033332e6a7067, '$2y$09$1CIW9blBCCccLM/RVSVJuOXovpSRqgTZEbDoKx4OLt/I.fCTln55G', 'null', '0000-00-00 00:00:00'),
('bna2', 'kj', 'djh', 2147483647, 'abc@gmail.com', 0x362d74797065732d6f662d736f6369616c2d656e67696e656572696e672d61747461636b732e6a706567, '$2y$09$vRFH3oPCaVMSgJ5j85Uhuu6sgtYOGhEdaDWjopVg89dqzPyo5Knxu', NULL, '2023-04-22 06:55:50'),
('h6', 'kyo', 'df', 2147483647, 'xyz@gmail.com', 0x6162616e646f6e65642d6368696c642d77616c6c70617065722d707265766965772e6a7067, '$2y$09$V7yK7LjxjsR8.iJ8KFidXe802sI3Z4OzZuva80KcFfkK3NYZqTOaa', NULL, '2023-04-22 06:55:50'),
('ja8', 'Ken', 'Timber', 2147483647, 'ultrainstant25@gmail.com', 0x494d472d32303232303630322d5741303033312e6a7067, '$2y$09$TGcpbtQFMflG7KqXfkdA8e8.Cfrr2CNLEQMTPuB67KyPRWorkah/e', '2be148e23d3d6b11d9e7589e8c20b6c630258e8f009e107d7efb637708cdb4af62dcdad741320fa096df39eff4fe544c2da3', '2023-04-23 04:19:25');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `fid` int(11) NOT NULL,
  `Emp_id` varchar(11) DEFAULT NULL,
  `msg` varchar(1000) DEFAULT NULL,
  `emailid` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`fid`, `Emp_id`, `msg`, `emailid`) VALUES
(5, 'ja8', 'jdgdgkghfghf', 'ultrainstant25@gmail.com'),
(6, 'ja8', 'suidgd', 'ultrainstant25@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Admin_id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`Booking_ID`),
  ADD KEY `Emp_ID` (`Emp_ID`),
  ADD KEY `Cubicle_ID` (`Cubicle_ID`);

--
-- Indexes for table `cubicle`
--
ALTER TABLE `cubicle`
  ADD PRIMARY KEY (`cubicle_id`),
  ADD UNIQUE KEY `cubicle_no` (`cubicle_no`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`Emp_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `Emp_id` (`Emp_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `Booking_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`Emp_ID`) REFERENCES `employee` (`Emp_id`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`Cubicle_ID`) REFERENCES `cubicle` (`cubicle_id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`Emp_id`) REFERENCES `employee` (`Emp_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
