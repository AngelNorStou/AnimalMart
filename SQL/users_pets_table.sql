-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2021 at 07:08 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

CREATE DATABASE animalmartdatabase;

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

CREATE TABLE pets (
  pet_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  pet_name VARCHAR(50) NOT NULL,
  pet_type VARCHAR(30) NOT NULL,
  breed VARCHAR(100) NOT NULL,
  gender ENUM('M','F','U') NOT NULL,
  size DECIMAL(5,2) NOT NULL,
  weight DECIMAL(6,2) NOT NULL,
  age TINYINT UNSIGNED NOT NULL,
  user_id INT UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `pets` (`pet_name`, `pet_type`, `breed`, `gender`, `size`, `weight`, `age`, `user_id`) VALUES
( 'Zed', 'Dog', 'Bulldog', 'M', '25.40', '22.10', 2, 1),
( 'Mittens', 'Cat', 'Persian', 'F', '32.00', '41.10', 5, 1),
( 'Goofy', 'Hamstar', 'Dwarf Campbell', 'M', '13.00', '0.09', 2, 3),
( 'Sophie', 'Dog', 'Poodle', 'F', '28.00', '50.00', 4, 4);


CREATE TABLE users (
  user_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(50) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  username VARCHAR(50) NOT NULL UNIQUE,
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  city VARCHAR(100) NOT NULL,
  phone_number VARCHAR(20) DEFAULT NULL,
  profile_picture VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`first_name`, `last_name`, `username`, `email`, `password`, `city`, `phone_number`, `profile_picture`) VALUES
('Pedro', 'Garcia', 'StarDust', 'pedroGar@gmail.com', 'notgarcia', 'Montreal', '514-123-4567', 'Images/guest.jpg'),
( 'Billy', 'Rogers', 'BillyHilly', 'hilly@yahoo.com', 'bestpass123', 'Montreal', '514-795-3476', NULL),
( 'Mike', 'Wheeler', 'ShadowHouse', 'wheel@gmail.com', 'wheel', 'New York', '212-574-2365', NULL),
( 'Steve', 'Smith', 'Teacher', 'steve@gmail.com', 'steven', 'Montreal', '514-847-4535', 'Images/guest.jpg'),
( 'Tania', 'Ivanova', 'Tan', 'tania@gmail.com', 'whyme123', 'Montreal', '438-575-2685', 'Images/swan.jpg');


ALTER TABLE `pets`
  ADD CONSTRAINT `pet_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

CREATE TABLE employees (
  employee_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL UNIQUE,
  start_date DATE NOT NULL,
  end_date DATE NULL,
  is_admin BOOLEAN NOT NULL DEFAULT FALSE,
  CONSTRAINT fk_employee_user
    FOREIGN KEY (user_id)
    REFERENCES users(user_id)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE services (
  service_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,  
  description VARCHAR(255) NOT NULL,
  type ENUM (
  'Pet Care',
  'Grooming',
  'Health',
  'Training',
  'Boarding',
  'Transportation',
  'Retail',
  'End-of-Life',
  'Specialized'
	),
    duration INT NOT NULL,
    price DECIMAL NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE messages (
  message_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NULL,
  name VARCHAR(150) NULL,
  email VARCHAR(255) NULL,
  phone_number VARCHAR(20) NULL,
  subject VARCHAR(150) NOT NULL,
  message TEXT NOT NULL,
  message_status ENUM ('New', 'Read', 'Replied', 'Closed') DEFAULT 'New',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_messages_user
    FOREIGN KEY (user_id)
    REFERENCES users(user_id)
    ON DELETE CASCADE    
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE appointments (
  appointment_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  
  employee_id INT UNSIGNED NOT NULL,
  user_id INT UNSIGNED NOT NULL,
  pet_id INT UNSIGNED NOT NULL,
  service_id INT UNSIGNED NOT NULL,
  
  start_date DATETIME NOT NULL,
  app_status ENUM('Available','Pending','Booked') DEFAULT 'Available',
  expiry DATETIME NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  
  CONSTRAINT fk_appointment_employee
    FOREIGN KEY (employee_id) 
    REFERENCES employees(employee_id)
    ON DELETE CASCADE,
  
  CONSTRAINT fk_appointment_user
    FOREIGN KEY (user_id)
    REFERENCES users(user_id)
    ON DELETE CASCADE,
    
  CONSTRAINT fk_appointment_pet
  FOREIGN KEY (pet_id)
  REFERENCES pets(pet_id)
  ON DELETE CASCADE,
  
  CONSTRAINT fk_appointment_service
    FOREIGN KEY (service_id)
    REFERENCES services(service_id)
    ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `employees` (`user_id`, `start_date`, `end_date`, `is_admin`) VALUES
(2, '2022-01-15', NULL, TRUE),   -- Billy is an admin
(3, '2023-03-01', NULL, FALSE),  -- Mike is staff
(4, '2021-11-10', NULL, FALSE);  -- Steve is staff


INSERT INTO `services` (`name`, `description`, `type`, `duration`, `price`) VALUES
('Basic Grooming', 'Bath and brush for dogs and cats', 'Grooming', 60, 45.00),
('Dog Walking', '30-minute walk around the neighborhood', 'Pet Care', 30, 25.00),
('Pet Vaccination', 'Routine vaccination for pets', 'Health', 20, 60.00),
('Obedience Training', 'Basic obedience for dogs', 'Training', 90, 80.00),
('Boarding Stay', 'Overnight boarding for your pet', 'Boarding', 1440, 100.00),
('Pet Taxi', 'Transportation to vet or groomer', 'Transportation', 30, 30.00);




INSERT INTO `users` (`first_name`, `last_name`, `username`, `email`, `password`, `city`, `phone_number`, `profile_picture`) VALUES
('Lucas', 'Brown', 'LucasB', 'lucas@gmail.com', 'lucaspass', 'Toronto', '416-555-7890', NULL);

INSERT INTO `employees` (`user_id`, `start_date`, `end_date`, `is_admin`) VALUES
(7, '2024-06-01', NULL, FALSE);

INSERT INTO `appointments` (`employee_id`, `user_id`, `pet_id`, `service_id`, `start_date`, `app_status`, `expiry`) VALUES
(4, 1, 1, 1, '2026-01-10 10:00:00', 'Booked', '2026-01-10 12:00:00'),  -- New employee handles user 1's pet
(2, 1, 2, 2, '2026-01-11 09:00:00', 'Pending', '2026-01-11 09:30:00'),  -- Employee 2 handles user 1's pet
(3, 3, 3, 3, '2026-01-12 14:00:00', 'Booked', '2026-01-12 14:20:00'),   -- Employee 3 handles user 3's pet
(4, 4, 4, 4, '2026-01-15 16:00:00', 'Available', '2026-01-15 17:30:00'); -- New employee handles user 4's pet

INSERT INTO `messages` (`user_id`, `name`, `email`, `phone_number`, `subject`, `message`, `message_status`) VALUES
(1, NULL, NULL, NULL, 'Inquiry about grooming', 'Hi, I want to book a grooming session for my dog.', 'New'),
(NULL, 'Anna Lee', 'anna@gmail.com', '438-555-1234', 'Question about boarding', 'Do you have overnight boarding for cats?', 'New'),
(3, NULL, NULL, NULL, 'Pet vaccination question', 'Is my hamster eligible for vaccination?', 'Read'),
(4, NULL, NULL, NULL, 'Training schedule', 'Can I book obedience training this weekend?', 'Replied');




