USE `accred`;

DROP TABLE IF EXISTS flight;
CREATE TABLE IF NOT EXISTS `flight` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `arrival_place` varchar(100) NULL,
  `arrival_date` DATE NULL,
  `arrival_time` TIME NULL,
  `arrival_flight_number` varchar(100) NULL,
  `arrival_terminal` varchar(100) NULL,
  `departure_place` varchar(100) NULL,
  `departure_date` DATE NULL,
  `departurel_time` TIME NULL,
  `departurel_flight_number` varchar(100) NULL,
  `departurel_terminal` varchar(100) NULL,
  PRIMARY KEY (`id`)
);
