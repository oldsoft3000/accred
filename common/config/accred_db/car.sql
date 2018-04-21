USE `accred`;

DROP TABLE IF EXISTS car;
CREATE TABLE IF NOT EXISTS `car` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country` varchar(100) NOT NULL,
  `car_number` varchar(100) NOT NULL,
  `car_brand` varchar(100) NOT NULL,
  `is_particip` int(1) NOT NULL,
  `first_name` varchar(100) NULL,
  `middle_name` varchar(100) NULL,
  `last_name` varchar(100) NULL,
  `first_name_latin` varchar(100) NULL,
  `last_name_latin` varchar(100) NULL,
  `date_of_birth` DATE NULL,
  `passport_series` int(11) NULL,
  `passport_number` int(11) NULL,
  `place_of_birth` varchar(100) NULL,
  PRIMARY KEY (`id`)
);
