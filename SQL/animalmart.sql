-- USERS TABLE
CREATE TABLE `users` (
  `user_id`INTEGER PRIMARY KEY AUTO_INCREMENT,
  `first_name` VARCHAR(30)  NOT NULL,
  `last_name`  VARCHAR(100) NOT NULL,
  `username`   VARCHAR(32)  NOT NULL,
  `email`      VARCHAR(128) NOT NULL,
  `password`   VARCHAR(64)  NOT NULL,
  `city`       VARCHAR(85)  NOT NULL,
  `phone_number`    CHAR(14) DEFAULT NULL,
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
  `pet_id`   INTEGER PRIMARY KEY AUTO_INCREMENT,
  `pet_name` VARCHAR(30)  NOT NULL,
  `pet_type` VARCHAR(30)  NOT NULL,
  `breed`    VARCHAR(64)  NOT NULL,
  `gender`   CHAR(1)      NOT NULL,
  `size`     DECIMAL(6,2) NOT NULL,
  `weight`   DECIMAL(6,2) NOT NULL,
  `age`      INTEGER(3)   NOT NULL,
  `user_id`  INTEGER(10)  NOT NULL,
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
    `user_id`     INTEGER(10) NOT NULL,
    `start_date`  DATE NOT NULL,
    `end_date`    DATE DEFAULT NULL,
    `isAdmin`     INTEGER(1) NOT NULL,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`)
);

INSERT INTO `employees` (`user_id`, `start_date`, `end_date`, `isAdmin`) VALUES
                        (6,DATE '2020-04-23',NULL,1);

-- SERVICES TABLE
create table `services`(
    `service_id`          INTEGER PRIMARY KEY AUTO_INCREMENT,
    `service_type`        VARCHAR(50)  NOT NULL,
    `service_name`        VARCHAR(50)  NOT NULL,
    `service_description` VARCHAR(250),
    `service_length`      INTEGER(3),
    `service_price`       DECIMAL(6,2) NOT NULL
);

 INSERT INTO `services` (`service_type`, `service_name`, `service_description`, `service_length`, `service_price`) VALUES
                        ('grooming', 'Breed-Specific Haircuts','Includes: Cut and style, Deep-cleaning shampoo, Blow-dry, 15-min brushout, Nail trim',60,30.00),
                        ('grooming', 'Baths For Every Breed','Includes: Deep-cleaning shampoo, Blow-dry, 15-min brushout, Nail trim',45,25.00),
                        ('grooming', 'Mini Makeover','Includes nail trim and buffing, ear cleaning, paw balm and scented spritz',20,20.00),
                        ('grooming', 'Mini Makeover Plus','Includes nail trim and buffing, ear cleaning, paw balm and scented spritz, plus teeth-brushing or breath refresh',35,25.00),
                        ('grooming', 'Nail trim','',5,10.00),
                        ('grooming', 'Nail trim and buffing','',10,15.00),
                        ('grooming', 'Teeth-brushing','',10,12.00),
                        ('grooming', 'Breath refresh','',10,12.00),
                        ('grooming', 'Face, Feet, and fanny trim','',15,15.00),
                        ('grooming', 'Ear cleaning','',10,10.00),
                        ('training', 'Single Private Lesson','Get personalized learning that’s focused on your dog’s precise needs.',75,89.00),
                        ('training', '4-Session Private Lesson','Our private packages are a great way to train your dog consistently over a longer duration, all at a great value. ($56 per session!)',75,229.00),
                        ('training', '6-Session Private Lesson','Maximize your training time and budget with consistent, personalized classes that adapt as your dog learns. ($50 per session!)',75,299.00),
                        ('training', 'Group Classes: Complete Package','Create a customized, comprehensive program that meets you and your dog’s needs. 3-Class Package Includes: 19-weeks of training, consisting of your choice of three Group Classes, plus one Private Lesson. Classes end with AKC-certified STAR test (for puppies) or AKC CGC test (for adult dogs)',75,379.00),
                        ('training', 'Group Classes: The Essential Package','Give your puppy or adult dog more confidence by covering all their training basics. 2-Class Package Includes: 12-weeks of training, consisting of your choice of two Group Classes, including Level 1, Level 2 or AKC Canine Good Citizen class',75,249.00),
                        ('training', 'Single Group Class','Pick from our curated assortment of six-session group classes for training tailored to your dog’s needs from puppy to adulthood. More details at our location.',75,149.00),
                        ('vet', 'Healthy Dog/Puppy Package','Package Includes: Distemper/Parvo Combo, Bordetella, Lepto (optional), Round/Hook Dewormer (included if necessary)',60,75.00),
                        ('vet', 'Healthy Dog Plus Package','Package Includes: Distemper/Parvo Combo, Bordetella, Lepto (optional), Round/Hook Dewormer (included if necessary), Heartworm Test + ** $10 Package upgrade includes a 4DX test to check for tick-borne diseases',60,95.00),
                        ('vet', 'Healthy Cat/Kitten Package','Package Includes: FVRCP Vaccine, FeLv Vaccine, Round/Hook Dewormer (included if necessary)',60,69.00),
                        ('vet', 'Rabies Vaccine','(1 or 3 year)',NULL,22.00),
                        ('vet', 'Distemper/Parvo (5 in 1) Combo','',NULL,35.00),
                        ('vet', 'Lepto','',NULL,35.00),
                        ('vet', 'Bordetella','',NULL,35.00),
                        ('vet', 'Lyme','',NULL,35.00),
                        ('vet', 'Canine Influenza (H3N2 & H3N8) ','',NULL,39.00),
                        ('vet', 'Rattlesnake','',NULL,39.00),
                        ('vet', 'Feline Leukemia','',NULL,39.00),
                        ('vet', 'Microchip','',NULL,22.00),
                        ('vet', 'Tapeworm Dewormer','',NULL,35.00),
                        ('vet', 'Canine Heartworm ONLY','',NULL,29.00),
                        ('vet', 'Feline Combo Test FeLv, FIV, Heartworm','',NULL,47.00);

-- APPOINTMENTS TABLE
create table `appointments`(
    `appointment_id`       INTEGER PRIMARY KEY AUTO_INCREMENT,
    `appointment_datetime` DATE NOT NULL,
    `appointment_expiry`   DATE NOT NULL,
    `pet_id`               INTEGER(10) NOT NULL,
    `service_id`           INTEGER(10) NOT NULL,
    `employee_id`          INTEGER(10) NOT NULL,
    FOREIGN KEY (`pet_id`)      REFERENCES `pets`(`pet_id`),
    FOREIGN KEY (`service_id`)  REFERENCES `services`(`service_id`),
    FOREIGN KEY (`employee_id`) REFERENCES `employees`(`employee_id`)
);

-- MESSAGES TABLES
create table `messages`(
    `message_id`        INTEGER PRIMARY KEY AUTO_INCREMENT,
    `user_id`           INTEGER(10) NOT NULL,
    `employee_id`       INTEGER(10) NOT NULL,
    `message_body`      VARCHAR(250) NOT NULL,
    `message_timestamp` TIMESTAMP    NOT NULL,
    FOREIGN KEY (`user_id`)     REFERENCES `users`(`user_id`),
    FOREIGN KEY (`employee_id`) REFERENCES `employees`(`employee_id`)
);

