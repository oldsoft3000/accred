SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
 
CREATE DATABASE IF NOT EXISTS `accred` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `accred`;
DROP TABLE IF EXISTS user;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `status` smallint(10) NOT NULL,
  `role` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);

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
  `reservation_hotel` int(11) NOT NULL, 
  PRIMARY KEY (`id`)
);
/*$2y$13$uqe3LPW9ya3RZhynJpPN5um9fvdxUmoqjOqQBJDdIDXSKxRZB5bPu*/
/*$2y$13$2EtYFZtzdGViXaxVI/mz5OsOi1sZbCVvY8po2tV5DM/iDm3HbNUWW*/

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'u4qnlunMrSWqcyitTV06gH5C8ZlAaWar', '$2y$13$3.bAhap1AhKjvLs4.CZv0.kXrjvnbdIcrFa7KRKXmbSbJdybEOjO.', '', '', 10, 0, 0, 0);