-- USERS TABLE
CREATE TABLE `users` (
  `user_id`INTEGER PRIMARY KEY AUTO_INCREMENT,
  `first_name` VARCHAR(30) NOT NULL,
  `last_name` VARCHAR(100) NOT NULL,
  `username` VARCHAR(32) NOT NULL,
  `email` VARCHAR(128) NOT NULL,
  `password` VARCHAR(64) NOT NULL,
  `city` VARCHAR(85) NOT NULL,
  `phone_number` CHAR(14) DEFAULT NULL,
  `profile_picture` VARCHAR(240) DEFAULT NULL
);

INSERT INTO `users` (`first_name`, `last_name`, `username`, `email`, `password`, `city`, `phone_number`, `profile_picture`) VALUES
('Guillermo', 'Tremols Suarez', 'KubrayKan', 'guillermo@gmail.com', 'guillermobeta', 'Montreal', '514-123-4567', 'Images/guest.jpg'),
('Hina', 'Ou', 'LunarStar', 'hina@yahoo.com', 'hina', 'Montreal', '514-795-3476', NULL),
('Neelu', 'Vaghela', 'ShadowHouse', 'neelu@gmail.com', 'neelu', 'New York', '212-574-2365', NULL),
('Steve', 'Ataky', 'Teacher', 'steve@gmail.com', 'steven', 'Montreal', '514-847-4535', 'Images/guest.jpg'),
('Tania', 'Ivanov', 'Tan', 'tania@gmail.com', '123456', 'Montreal', '438-575-2685', 'Images/swan.jpg'),
('Sabrina', 'Pagliaruli', 'sabpags', 'sabrina@gmail.com', 'sabrina', 'Montreal', '438-575-2685', 'Images/guest.jpg');

-- PETS TABLE
CREATE TABLE `pets` (
  `pet_id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `pet_name` VARCHAR(30) NOT NULL,
  `pet_type` VARCHAR(30) NOT NULL,
  `breed` VARCHAR(64) NOT NULL,
  `gender` CHAR(1) NOT NULL,
  `size` DECIMAL(6,2) NOT NULL,
  `weight` DECIMAL(6,2) NOT NULL,
  `age` INTEGER(3) NOT NULL,
  `user_id` INTEGER(10) NOT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`)
);

INSERT INTO `pets` (`pet_name`, `pet_type`, `breed`, `gender`, `size`, `weight`, `age`, `user_id`) VALUES
('Zed', 'Dog', 'Bulldog', 'M', '25.40', '22.10', 2, 1),
('Mittens', 'Cat', 'Persian', 'F', '32.00', '41.10', 5, 1),
('Goofy', 'Hamstar', 'Dwarf Campbell', 'M', '13.00', '0.09', 2, 3),
('Sophie', 'Dog', 'Poodle', 'F', '28.00', '50.00', 4, 4);


-- EMPLOYEE TABLE
create table `employees`(
    `employee_id` INTEGER PRIMARY KEY AUTO_INCREMENT,
    `user_id` INTEGER(10) NOT NULL,
    `start_date` DATE NOT NULL,
    `end_date` DATE,
    `isAdmin` INTEGER(1) NOT NULL,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`)
);

INSERT INTO `employees` (`user_id`, `start_date`, `end_date`, `isAdmin`) VALUES
(6,DATE '2020-04-23',NULL,1);

-- SERVICES TABLE
create table `services`(
    `service_id` INTEGER PRIMARY KEY AUTO_INCREMENT,
    `service_name` VARCHAR(50) NOT NULL,
    `service_description` VARCHAR(250),
    `service_length` INTEGER(3) NOT NULL,
    `service_price` DECIMAL(3,2) NOT NULL
);

-- INSERT INTO `services` () VALUES ();

-- APPOINTMENTS TABLE
create table `appointments`(
    `appointment_id` INTEGER PRIMARY KEY AUTO_INCREMENT,
    `appointment_datetime` DATE NOT NULL,
    `appointment_expiry` DATE NOT NULL,
    `pet_id` INTEGER(10) NOT NULL,
    `service_id` INTEGER(10) NOT NULL,
    `employee_id` INTEGER(10) NOT NULL,
    FOREIGN KEY (`pet_id`) REFERENCES `pets`(`pet_id`),
    FOREIGN KEY (`service_id`) REFERENCES `services`(`service_id`),
    FOREIGN KEY (`employee_id`) REFERENCES `employees`(`employee_id`)
);

-- MESSAGES TABLES
create table `messages`(
    `message_id` INTEGER PRIMARY KEY AUTO_INCREMENT,
    `user_id` INTEGER(10) NOT NULL,
    `employee_id` INTEGER(10) NOT NULL,
    `message_body` VARCHAR(250) NOT NULL,
    `message_timestamp` TIMESTAMP NOT NULL,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`),
    FOREIGN KEY (`employee_id`) REFERENCES `employees`(`employee_id`)
);

