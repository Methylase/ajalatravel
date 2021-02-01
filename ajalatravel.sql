-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2020 at 09:17 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ajalatravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `ajalatravel_bus`
--

CREATE TABLE `ajalatravel_bus` (
  `bus_id` int(11) NOT NULL,
  `bus_name` varchar(100) NOT NULL,
  `bus_color` varchar(100) NOT NULL,
  `bus_state` varchar(150) NOT NULL,
  `bus_localG` varchar(150) NOT NULL,
  `bus_features` varchar(100) NOT NULL,
  `bus_day` varchar(100) NOT NULL,
  `bus_time` varchar(100) NOT NULL,
  `bus_seatNo` varchar(100) NOT NULL,
  `bus_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ajalatravel_bus`
--

INSERT INTO `ajalatravel_bus` (`bus_id`, `bus_name`, `bus_color`, `bus_state`, `bus_localG`, `bus_features`, `bus_day`, `bus_time`, `bus_seatNo`, `bus_date`) VALUES
(1, 'luxaury', 'blue', 'Bauchi', 'Lagos', 'Full-AC,Seater', 'morning', '7:22 AM', '14', '2020-03-28'),
(2, 'luxuary', 'blue', 'Delta', 'Sapele', 'Full-AC,Seater,Sleeper', 'morning', '7:47 AM', '18', '2020-03-28'),
(3, 'luxuary', 'white', 'Adamawa', 'Fufure', 'Full-AC,Non-AC,Seater,Sleeper', 'evening/night', '7:50 AM', '14', '2020-03-28'),
(5, 'luxuary', 'white', 'Bayelsa', 'Ogbia', 'Seater,Sleeper,Lead-TV', 'morning', '2:39 AM', '18', '2020-03-28');

-- --------------------------------------------------------

--
-- Table structure for table `ajalatravel_bus_route`
--

CREATE TABLE `ajalatravel_bus_route` (
  `route_id` int(11) NOT NULL,
  `route_name` varchar(100) NOT NULL,
  `route_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ajalatravel_bus_route`
--

INSERT INTO `ajalatravel_bus_route` (`route_id`, `route_name`, `route_date`) VALUES
(1, 'abaeast', '2020-02-03');

-- --------------------------------------------------------

--
-- Table structure for table `ajalatravel_bus_to_route`
--

CREATE TABLE `ajalatravel_bus_to_route` (
  `bus_route_id` int(11) NOT NULL,
  `route_id` varchar(100) NOT NULL,
  `bus_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ajalatravel_bus_to_route`
--

INSERT INTO `ajalatravel_bus_to_route` (`bus_route_id`, `route_id`, `bus_id`) VALUES
(1, '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `ajalatravel_bus_travel_fee`
--

CREATE TABLE `ajalatravel_bus_travel_fee` (
  `bus_travel_fee_id` int(11) NOT NULL,
  `bus_travelFee` varchar(100) NOT NULL,
  `dateCreated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ajalatravel_bus_travel_fee`
--

INSERT INTO `ajalatravel_bus_travel_fee` (`bus_travel_fee_id`, `bus_travelFee`, `dateCreated`) VALUES
(1, '2000', '2020-02-03'),
(2, '3000', '2020-02-29'),
(3, '4500', '2020-02-20'),
(4, '2500', '2020-02-01');

-- --------------------------------------------------------

--
-- Table structure for table `ajalatravel_company`
--

CREATE TABLE `ajalatravel_company` (
  `company_id` int(11) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `company_email` varchar(100) NOT NULL,
  `company_phone` varchar(150) NOT NULL,
  `company_address1` varchar(150) NOT NULL,
  `company_address2` varchar(150) NOT NULL,
  `company_state` varchar(100) NOT NULL,
  `company_localG` varchar(100) NOT NULL,
  `company_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ajalatravel_company`
--

INSERT INTO `ajalatravel_company` (`company_id`, `company_name`, `company_email`, `company_phone`, `company_address1`, `company_address2`, `company_state`, `company_localG`, `company_date`) VALUES
(1, 'Aba', 'methyl2007@yahoo.com', '08188373898', '20, Adediran close', '', 'Lagos', 'Ikeja', '2020-03-28'),
(2, 'Goodness', 'methyl2008@yahoo.com', '08188373978', '21, Adebowale', '', 'Lagos', 'Ikeja', '2020-03-28');

-- --------------------------------------------------------

--
-- Table structure for table `ajalatravel_company_bus`
--

CREATE TABLE `ajalatravel_company_bus` (
  `company_bus_id` int(11) NOT NULL,
  `company_id` int(100) NOT NULL,
  `bus_id` int(100) NOT NULL,
  `bus_travel_fee_id` int(100) NOT NULL,
  `park_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ajalatravel_company_bus`
--

INSERT INTO `ajalatravel_company_bus` (`company_bus_id`, `company_id`, `bus_id`, `bus_travel_fee_id`, `park_id`) VALUES
(1, 1, 1, 1, 1),
(2, 2, 2, 1, 1),
(3, 1, 2, 1, 1),
(8, 1, 5, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ajalatravel_company_park`
--

CREATE TABLE `ajalatravel_company_park` (
  `park_id` int(11) NOT NULL,
  `park_name` varchar(100) NOT NULL,
  `park_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ajalatravel_company_park`
--

INSERT INTO `ajalatravel_company_park` (`park_id`, `park_name`, `park_date`) VALUES
(1, 'abule-egba', '2020-01-28'),
(2, 'ikeja', '2020-02-20');

-- --------------------------------------------------------

--
-- Table structure for table `ajalatravel_company_transaction`
--

CREATE TABLE `ajalatravel_company_transaction` (
  `company_customer_transaction_id` int(11) NOT NULL,
  `customer_id` varchar(100) NOT NULL,
  `company_id` varchar(11) NOT NULL,
  `park_id` varchar(11) NOT NULL,
  `route_id` varchar(11) NOT NULL,
  `bus_id` varchar(11) NOT NULL,
  `bus_travel_fee_id` varchar(11) NOT NULL,
  `paymentCode` varchar(11) NOT NULL,
  `payment` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ajalatravel_company_transaction`
--

INSERT INTO `ajalatravel_company_transaction` (`company_customer_transaction_id`, `customer_id`, `company_id`, `park_id`, `route_id`, `bus_id`, `bus_travel_fee_id`, `paymentCode`, `payment`) VALUES
(1, 'methyl2007@yahoo.com', '1', '1', '1', '1', '1', 'czwzob', 'no'),
(2, 'methyl2007@yahoo.com', '1', '1', '1', '1', '1', '6favkf', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `ajalatravel_park_to_company`
--

CREATE TABLE `ajalatravel_park_to_company` (
  `park_company_id` int(11) NOT NULL,
  `company_id` varchar(100) NOT NULL,
  `park_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ajalatravel_park_to_company`
--

INSERT INTO `ajalatravel_park_to_company` (`park_company_id`, `company_id`, `park_id`) VALUES
(1, '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `ajalatravel_users`
--

CREATE TABLE `ajalatravel_users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `checker` varchar(50) NOT NULL,
  `checker2` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ajalatravel_users`
--

INSERT INTO `ajalatravel_users` (`user_id`, `username`, `password`, `checker`, `checker2`) VALUES
(1, 'superadmin', 'f3e4891254eb8c57cd7fb3273ccf580e', '1', 'Super Admin');

-- --------------------------------------------------------

--
-- Table structure for table `ajalatravel_user_information`
--

CREATE TABLE `ajalatravel_user_information` (
  `user_information_id` int(11) NOT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `middlename` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phonenumber` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `localG` varchar(50) DEFAULT NULL,
  `address1` varchar(150) DEFAULT NULL,
  `address2` varchar(150) DEFAULT NULL,
  `image` longblob NOT NULL,
  `date` date DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ajalatravel_user_information`
--

INSERT INTO `ajalatravel_user_information` (`user_information_id`, `firstname`, `middlename`, `lastname`, `gender`, `email`, `phonenumber`, `state`, `localG`, `address1`, `address2`, `image`, `date`, `user_id`) VALUES

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ajalatravel_bus`
--
ALTER TABLE `ajalatravel_bus`
  ADD PRIMARY KEY (`bus_id`);

--
-- Indexes for table `ajalatravel_bus_route`
--
ALTER TABLE `ajalatravel_bus_route`
  ADD PRIMARY KEY (`route_id`);

--
-- Indexes for table `ajalatravel_bus_to_route`
--
ALTER TABLE `ajalatravel_bus_to_route`
  ADD PRIMARY KEY (`bus_route_id`);

--
-- Indexes for table `ajalatravel_bus_travel_fee`
--
ALTER TABLE `ajalatravel_bus_travel_fee`
  ADD PRIMARY KEY (`bus_travel_fee_id`);

--
-- Indexes for table `ajalatravel_company`
--
ALTER TABLE `ajalatravel_company`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `ajalatravel_company_bus`
--
ALTER TABLE `ajalatravel_company_bus`
  ADD PRIMARY KEY (`company_bus_id`);

--
-- Indexes for table `ajalatravel_company_park`
--
ALTER TABLE `ajalatravel_company_park`
  ADD PRIMARY KEY (`park_id`);

--
-- Indexes for table `ajalatravel_company_transaction`
--
ALTER TABLE `ajalatravel_company_transaction`
  ADD PRIMARY KEY (`company_customer_transaction_id`);

--
-- Indexes for table `ajalatravel_park_to_company`
--
ALTER TABLE `ajalatravel_park_to_company`
  ADD PRIMARY KEY (`park_company_id`);

--
-- Indexes for table `ajalatravel_users`
--
ALTER TABLE `ajalatravel_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `ajalatravel_user_information`
--
ALTER TABLE `ajalatravel_user_information`
  ADD PRIMARY KEY (`user_information_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ajalatravel_bus`
--
ALTER TABLE `ajalatravel_bus`
  MODIFY `bus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `ajalatravel_bus_route`
--
ALTER TABLE `ajalatravel_bus_route`
  MODIFY `route_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ajalatravel_bus_to_route`
--
ALTER TABLE `ajalatravel_bus_to_route`
  MODIFY `bus_route_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ajalatravel_bus_travel_fee`
--
ALTER TABLE `ajalatravel_bus_travel_fee`
  MODIFY `bus_travel_fee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `ajalatravel_company`
--
ALTER TABLE `ajalatravel_company`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ajalatravel_company_bus`
--
ALTER TABLE `ajalatravel_company_bus`
  MODIFY `company_bus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `ajalatravel_company_park`
--
ALTER TABLE `ajalatravel_company_park`
  MODIFY `park_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ajalatravel_company_transaction`
--
ALTER TABLE `ajalatravel_company_transaction`
  MODIFY `company_customer_transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ajalatravel_park_to_company`
--
ALTER TABLE `ajalatravel_park_to_company`
  MODIFY `park_company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ajalatravel_users`
--
ALTER TABLE `ajalatravel_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ajalatravel_user_information`
--
ALTER TABLE `ajalatravel_user_information`
  MODIFY `user_information_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;