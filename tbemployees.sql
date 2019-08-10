-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Aug 10, 2019 at 04:47 AM
-- Server version: 5.6.34-log
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webd166`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbemployees`
--

CREATE TABLE `tbemployees` (
  `id` int(6) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `hire_date` date NOT NULL,
  `comments` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbemployees`
--

INSERT INTO `tbemployees` (`id`, `fullname`, `gender`, `title`, `hire_date`, `comments`) VALUES
(1, 'Sofia Faverman', 'Female', 'Web Developer', '2019-06-09', 'Moved from San Diego.!'),
(6, 'Bella Malamud', 'Female', 'Supervisor', '2009-08-05', 'The best!!'),
(7, 'Goldie Malamud', 'Female', 'Data Scientist II', '2016-08-15', 'MS from Chapman University!!!!!'),
(8, 'Nicholas Malmud', 'Male', 'Intern', '2018-09-17', 'Welcome!!'),
(9, 'Paul Martin', 'Male', 'Manager', '2011-05-07', 'Promoted last year!'),
(10, 'John McDonald', 'Male', 'Project Manager', '2000-10-18', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbemployees`
--
ALTER TABLE `tbemployees`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbemployees`
--
ALTER TABLE `tbemployees`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
