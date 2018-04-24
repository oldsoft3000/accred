SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

USE `accred`;

DROP TABLE IF EXISTS hotel;
CREATE TABLE IF NOT EXISTS `hotel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `arrival_date` DATE NOT NULL,
  `departure_date` DATE NOT NULL, 
  `guests` int(2) NOT NULL,
  `type_name` varchar(100) NOT NULL, 
  `category_name` varchar(100) NOT NULL,
  `hotel_index` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);