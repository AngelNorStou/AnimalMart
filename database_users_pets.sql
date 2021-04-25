
CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(100) NOT NULL,  
  `username` varchar(32) NOT NULL,
  `email` varchar(128) NOT NULL,  
  `password` varchar(64) NOT NULL,
  `city` varchar(85) NOT NULL,
  `phone_number` char(14),  
  `profile_picture` varchar(240)    
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; 






CREATE TABLE `pets` (
  `pet_id` int NOT NULL,
  `pet_name` varchar(30) NOT NULL,
  `pet_type` varchar(30) NOT NULL,  
  `breed` varchar(64) NOT NULL,
  `gender` char(1) NOT NULL,  
  `size` decimal(3,2) NOT NULL,
  `weight` decimal(3,2) NOT NULL,
  `age` int NOT NULL,  
  `user_id` int NOT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;





INSERT INTO `users` (`first_name`,`last_name`,`username`, `email`, `password`, `city`,`phone_number`,`profile_picture`) VALUES
(1,'Guillermo','Tremols Suarez', 'KubrayKan', 'guillermo@gmail.com', 'guillermobeta', 'Montreal','514-123-4567','Images/guest.jpg'),
(2,'Hina', 'Ou', 'LunarStar', 'hina@yahoo.com', 'hina', 'Montreal','514-795-3476', NULL),
(3,'Neelu', 'Vaghela', 'ShadowHouse', 'neelu@gmail.com', 'neelu', 'New York', '212-574-2365',NULL),
(4,'Steve', 'Ataky', 'Teacher', 'steve@gmail.com', 'steven', 'Montreal', '514-847-4535', 'Images/guest.jpg');


INSERT INTO `pets` (`pet_name`,`pet_type`,`breed`, `gender`, `size`, `weight`,`age`,`user_id`) VALUES
(1,'Zed','Dog', 'Bulldog', 'M', 25.4, 22.1 , 2, 1),
(2,'Mittens','Cat', 'Persian', 'F', 32.00, 41.10 , 5, 1),
(3,'Goofy','Hamstar', 'Dwarf Campbell', 'M', 13.00, 0.09 , 2, 3),
(4,'Sophie','Dog', 'Poodle', 'F', 28.00, 50.00 , 4, 4); 





ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

ALTER TABLE `pets`
  ADD PRIMARY KEY (`pet_id`);  




ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;


ALTER TABLE `pets`
  MODIFY `pet_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;


