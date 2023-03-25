-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2016 at 08:36 AM
-- Server version: 5.6.25
-- PHP Version: 5.5.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dynamicdost_beta6`
--

-- --------------------------------------------------------

--
-- Table structure for table `bud_sh_packing`
--

CREATE TABLE IF NOT EXISTS `bud_sh_packing` (
  `box_id` int(11) NOT NULL,
  `box_no` bigint(20) NOT NULL,
  `item_group_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `shade_id` int(11) NOT NULL,
  `lot_no` varchar(20) NOT NULL,
  `no_boxes` int(11) NOT NULL,
  `no_cones` int(11) NOT NULL,
  `gr_weight` decimal(10,3) NOT NULL,
  `nt_weight` decimal(10,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bud_sh_packing`
--
ALTER TABLE `bud_sh_packing`
  ADD PRIMARY KEY (`box_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bud_sh_packing`
--
ALTER TABLE `bud_sh_packing`
  MODIFY `box_id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
