-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2021 at 12:10 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `animalmartdatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `pets`
--

CREATE TABLE `pets` (
  `pet_id` int(11) NOT NULL,
  `pet_name` varchar(30) NOT NULL,
  `pet_type` varchar(30) NOT NULL,
  `breed` varchar(64) NOT NULL,
  `gender` char(1) NOT NULL,
  `size` decimal(6,2) NOT NULL,
  `weight` decimal(6,2) NOT NULL,
  `age` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pets`
--

INSERT INTO `pets` (`pet_id`, `pet_name`, `pet_type`, `breed`, `gender`, `size`, `weight`, `age`, `user_id`) VALUES
(1, 'Zed', 'Dog', 'Bulldog', 'M', '25.40', '22.10', 2, 1),
(2, 'Mittens', 'Cat', 'Persian', 'F', '32.00', '41.10', 5, 1),
(3, 'Goofy', 'Hamstar', 'Dwarf Campbell', 'M', '13.00', '0.09', 2, 3),
(4, 'Sophie', 'Dog', 'Poodle', 'F', '28.00', '50.00', 4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `username` varchar(32) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(64) NOT NULL,
  `city` varchar(85) NOT NULL,
  `phone_number` char(14) DEFAULT NULL,
  `profile_picture` varchar(240) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `username`, `email`, `password`, `city`, `phone_number`, `profile_picture`) VALUES
(1, 'Guillermo', 'Tremols Suarez', 'KubrayKan', 'guillermo@gmail.com', 'guillermobeta', 'Montreal', '514-123-4567', 'Images/guest.jpg'),
(2, 'Hina', 'Ou', 'LunarStar', 'hina@yahoo.com', 'hina', 'Montreal', '514-795-3476', NULL),
(3, 'Neelu', 'Vaghela', 'ShadowHouse', 'neelu@gmail.com', 'neelu', 'New York', '212-574-2365', NULL),
(4, 'Steve', 'Ataky', 'Teacher', 'steve@gmail.com', 'steven', 'Montreal', '514-847-4535', 'Images/guest.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`pet_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pets`
--
ALTER TABLE `pets`
  ADD CONSTRAINT `pet_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
