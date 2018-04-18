
USE `accred`;
DROP TABLE IF EXISTS bigcities;
CREATE TABLE IF NOT EXISTS `bigcities` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `region` varchar(255) NOT NULL,
  `district` varchar(255) NOT NULL,
  `population` int(11) NOT NULL,
  `year_of_foundation` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);

LOAD DATA INFILE 'bigcities.csv'
INTO TABLE bigcities 
FIELDS TERMINATED BY ',';
/*ENCLOSED BY '"'
LINES TERMINATED BY 'rn';*/