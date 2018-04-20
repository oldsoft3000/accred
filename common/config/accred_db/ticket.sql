USE `accred`;

DROP TABLE IF EXISTS ticket;
CREATE TABLE IF NOT EXISTS `ticket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_type` int(1) DEFAULT 0,
  `departure_date` DATE NULL,
  `flight_number` varchar(100) NOT NULL,
  `from` varchar(100) NOT NULL,
  `where` varchar(100) NOT NULL,
  `class` varchar(100) NOT NULL,
  `passport_number` varchar(100) NOT NULL,
  `passport_validity` DATE NULL,
  `bonus_card` varchar(100) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
);
