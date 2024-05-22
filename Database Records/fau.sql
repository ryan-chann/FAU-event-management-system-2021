-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2021 at 08:38 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fau`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminID` int(11) NOT NULL,
  `Name` varchar(40) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Contact` varchar(11) NOT NULL,
  `Password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminID`, `Name`, `Email`, `Contact`, `Password`) VALUES
(1, 'FAU', 'fau@tarc.my', '0102394668', 'Fau12345');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `EventID` int(11) NOT NULL,
  `EventName` varchar(40) CHARACTER SET utf8 NOT NULL,
  `Category` varchar(30) CHARACTER SET utf8 NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL,
  `StartTime` time NOT NULL,
  `EndTime` time NOT NULL,
  `Venue` varchar(40) CHARACTER SET utf8 NOT NULL,
  `No_of_Booking` int(11) NOT NULL,
  `Picture_location` varchar(40) CHARACTER SET utf8 NOT NULL,
  `Description` varchar(255) CHARACTER SET utf8 NOT NULL,
  `LimitBooking` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`EventID`, `EventName`, `Category`, `StartDate`, `EndDate`, `StartTime`, `EndTime`, `Venue`, `No_of_Booking`, `Picture_location`, `Description`, `LimitBooking`) VALUES
(1, 'First Aid Talk', 'Workshop', '2021-10-20', '2021-10-20', '14:00:00', '16:00:00', 'TARUC Function Room', 1, '../picture/workshop/event1.jpeg', 'First Aid Talk are open to all students. If you want to learn first aid knowledge, don\'t miss this lecture! There will be professional teaching and many interesting activities waiting for you on the day!', 100),
(2, 'Volunteer in Nursing Home', 'Volunteering', '2021-09-29', '2021-09-29', '08:00:00', '20:00:00', 'KV GUARDIAN ELDERLY CARE CENTER', 1, '../picture/volunteering/event1.jpg', 'This volunteer activity is to be a volunteer in a nursing home. We will conduct physical examinations and explain some simple first aid knowledge for them for free. If you want to join us, please book now, the seats are limited!', 50),
(3, 'First Aid Common Sense Competition 2021', 'Competitions', '2021-12-21', '2021-12-21', '14:00:00', '16:00:00', 'TARUC Main Hall', 1, '../picture/competition/event1.jpg', 'This competition is to let more students understand first aid knowledge, and the rewards of the competition are also very attractive! The champion will have a chance to get up to rm300 in cash!', 50),
(4, 'Fundraising For Mercy Malaysia', 'Charity Event', '2021-12-17', '2021-12-18', '12:00:00', '15:00:00', 'TARUC Main Hall', 0, '../picture/charity/event1.jpg', 'We will organize fundraising activities to help the organization that needs funds for the epidemic. We will sell food and beverages, and all the money we receive will be donated to Mercy Malaysia. If you want to contribute, please make booking, so that we', 50),
(5, 'October 2021 Blood Donation Campaign', 'Blood Donation', '2021-10-25', '2021-10-25', '11:00:00', '15:00:00', 'TARUC Main Hall', 0, '../picture/blood_donation/event1.jpeg', 'In addition to saving lives, blood donation activities can also increase the blood stock of the national blood bank. Before the blood donation, a professional nurse will conduct a physical examination to determine whether the blood can be donated. If you', 5);

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `BookingID` int(11) NOT NULL,
  `StudentID` varchar(10) CHARACTER SET utf8 NOT NULL,
  `EventID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`BookingID`, `StudentID`, `EventID`, `Quantity`) VALUES
(10, '20WMD01878', 1, 1),
(11, '20WMD01878', 2, 1),
(12, '20WMD01878', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `StudentID` varchar(10) CHARACTER SET utf8 NOT NULL,
  `Email` varchar(60) CHARACTER SET utf8 NOT NULL,
  `Password` varchar(30) CHARACTER SET utf8 NOT NULL,
  `Name` varchar(30) CHARACTER SET utf8 NOT NULL,
  `Phone` varchar(14) CHARACTER SET utf8 NOT NULL,
  `Gender` varchar(10) CHARACTER SET utf8 NOT NULL,
  `Faculty` varchar(4) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`StudentID`, `Email`, `Password`, `Name`, `Phone`, `Gender`, `Faculty`) VALUES
('20WMD01878', 'ryancjy-wm20@student.tarc.edu.my', 'Ry@n1234', 'Ryan Chan', '012-345-6789', 'MALE', 'FOCS'),
('20WMD02045', 'yeohml-wm20@student.tarc.edu.my', 'M@ili123', 'Mei Li', '014-345-6789', 'FEMALE', 'FOCS'),
('20WMD02225', 'tayjm-wm20@student.tarc.edu.my', 'J@smie123', 'Jes Mie', '010-345-6789', 'FEMALE', 'FOCS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`EventID`),
  ADD KEY `EventID` (`EventID`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`BookingID`),
  ADD UNIQUE KEY `TicketID` (`BookingID`),
  ADD KEY `StudentID` (`StudentID`),
  ADD KEY `EventID` (`EventID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`StudentID`),
  ADD UNIQUE KEY `StudentID` (`StudentID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `BookingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`StudentID`) REFERENCES `user` (`StudentID`),
  ADD CONSTRAINT `ticket_ibfk_2` FOREIGN KEY (`EventID`) REFERENCES `event` (`EventID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
