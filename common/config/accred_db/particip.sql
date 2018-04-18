USE `accred`;

DROP TABLE IF EXISTS particip;
CREATE TABLE IF NOT EXISTS `particip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` int(1) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `first_name_latin` varchar(100) NOT NULL,
  `last_name_latin` varchar(100) NOT NULL,
  `gender` int(1) NOT NULL,
  `email` varchar(100) NOT NULL,
  `date_of_birth` DATE NOT NULL,
  `citizenship` varchar(32) NOT NULL,
  `passport_series` int(11) NOT NULL,
  `passport_number` int(11) NOT NULL,
  `registration_address` varchar(100) NOT NULL,
  `phone_number` varchar(32) NOT NULL,
  `visa_required` int(1) NOT NULL,
  `visa_passport_validity` DATE NULL,
  `visa_country` varchar(100) NULL,
  `visa_city` varchar(100) NULL,
  `place_of_birth` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `organization` varchar(100) NOT NULL,
  `organization_latin` varchar(100) NOT NULL,
  `position_latin` varchar(100) NOT NULL,
  `photo` LONGBLOB NULL,
  `created_by` int(11) NOT NULL,
  `hotel_reservation_id` int(11) NOT NULL, 
  `flight_id` int(11) NOT NULL, 
  PRIMARY KEY (`id`)
);
