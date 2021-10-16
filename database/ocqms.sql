-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 16, 2021 at 10:13 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ocqms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `Uname` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Uname`, `Password`) VALUES
('d033e22ae348aeb5660fc2140aec35850c4da997', 'd033e22ae348aeb5660fc2140aec35850c4da997');

-- --------------------------------------------------------

--
-- Table structure for table `dispatchers`
--

CREATE TABLE `dispatchers` (
  `Name` varchar(100) NOT NULL,
  `OnDuty` tinyint(1) NOT NULL,
  `PIN` varchar(10) NOT NULL,
  `Contact` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `loaded_passengers`
--

CREATE TABLE `loaded_passengers` (
  `Vehicle` varchar(40) NOT NULL,
  `Passenger` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `Question` varchar(150) NOT NULL,
  `Answer` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`Question`, `Answer`) VALUES
('What is your favorite color?', '78988010b890ce6f4d2136481f392787ec6d6106'),
('What is your mother\'s maiden name?', '030c8062aedaa48ff6a9aec41870ea6996c88cde'),
('What elementary school did you attend?', '0bc076eefbe270fd589098a1af8661881e93a342'),
('When you were young, what did you want to be when you grew up?', 'cfd5acd586398229e9229ee327a0c2bf6a379658'),
('What is the name of the town where you were born?', 'd926ad62e0099098a04df51eefbee30dd6f8f941');

-- --------------------------------------------------------

--
-- Table structure for table `registered_vehicles`
--

CREATE TABLE `registered_vehicles` (
  `PlateNo` varchar(10) NOT NULL,
  `Route` varchar(30) NOT NULL,
  `Capacity` int(11) NOT NULL,
  `Operator` varchar(100) NOT NULL,
  `Contact` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `waiting_passengers`
--

CREATE TABLE `waiting_passengers` (
  `Destination` varchar(50) NOT NULL,
  `Passenger` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `registered_vehicles`
--
ALTER TABLE `registered_vehicles`
  ADD PRIMARY KEY (`PlateNo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
