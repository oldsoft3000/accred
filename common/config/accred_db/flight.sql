USE `accred`;

DROP TABLE IF EXISTS flight;
CREATE TABLE IF NOT EXISTS `flight` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `arrival_place` varchar(100) NOT NULL,
  `arrival_date` DATE NOT NULL,
  `arrival_time` TIME NOT NULL,
  `arrival_flight_number` varchar(100) NOT NULL,
  `arrival_terminal` varchar(100) NOT NULL,
  `departure_place` varchar(100) NOT NULL,
  `departure_date` DATE NOT NULL,
  `departure_time` TIME NOT NULL,
  `departure_flight_number` varchar(100) NOT NULL,
  `departure_terminal` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
);
