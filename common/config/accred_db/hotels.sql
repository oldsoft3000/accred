SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
 
CREATE DATABASE IF NOT EXISTS `accred` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `accred`;
DROP TABLE IF EXISTS hotel;
CREATE TABLE IF NOT EXISTS `hotel` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS hotel_room;
CREATE TABLE IF NOT EXISTS `hotel_room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hotel_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL, /*одноместный, двухместный тд*/
  `category_id` int(11) NOT NULL, /*стандартный, супериор и тд*/
  `cost` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS hotel_reservation;
CREATE TABLE IF NOT EXISTS `hotel_reservation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `arrival_date` DATE NOT NULL,
  `departure_date` DATE NOT NULL, /*одноместный, двухместный тд*/
  `guests` int(2) NOT NULL, /*стандартный, супериор и тд*/
  `type_id` int(11) NOT NULL, 
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS room_category;
CREATE TABLE IF NOT EXISTS `room_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS room_type;
CREATE TABLE IF NOT EXISTS `room_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
);

/*Типы номеров*/
/*
1 - одноместный 
2 - двухместный
3 - трехместный
*/

/*Категории номеров*/

/*
1 - Стандартный
2 - Полулюкс
3 - Люкс
4 - Супериор
*/


INSERT INTO `room_category` (`name`) VALUES 
('Стандартный'),
('Полулюкс'),
('Люкс'),
('Супериор');

INSERT INTO `room_type` (`name`) VALUES 
('Одноместный'),
('Двухместный'),
('Трехместный');


INSERT INTO `hotel_room` (`hotel_id`, `type_id`, `category_id`, `cost`) VALUES 
(1, 1, 1, 4000),
(1, 1, 2, 5000),
(1, 2, 2, 6000),
(1, 2, 3, 7000),
(1, 2, 4, 9000),
(2, 1, 1, 4000),
(2, 1, 2, 5000),
(2, 2, 2, 6000),
(2, 2, 3, 7000),
(2, 2, 4, 9000),
(3, 1, 1, 4000),
(3, 1, 2, 5000),
(3, 2, 2, 6000),
(3, 2, 3, 7000),
(3, 2, 4, 9000);


INSERT INTO `hotel` (`id`, `name`, `description`) VALUES 
(1, 'Отель "Звездный"', 'Отель «Звездный» расположен в Сочи, в 15 минутах ходьбы от собственного пляжа на берегу Черного моря. К услугам гостей сезонный открытый бассейн с подогревом.'),
(2, 'Гранд Отель «Жемчужина»', 'До пляжа можно дойти всего за 2 минуты. Этот гостиничный комплекс находится прямо на побережье Черного моря в Сочи и располагает частным пляжем, открытым подогреваемым бассейном с морской водой и теннисными кортами.'),
(3, 'Отель «Mercure Сочи Центр»', 'Отель расположен в центре Сочи, в 2 минут ходьбы от берега Черного моря и в 5 минутах ходьбы от концертного зала «Фестивальный».');

