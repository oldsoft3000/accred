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
  `is_agreed` int(1) NULL,
  PRIMARY KEY (`id`)
);


INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'u4qnlunMrSWqcyitTV06gH5C8ZlAaWar', '$2y$13$3.bAhap1AhKjvLs4.CZv0.kXrjvnbdIcrFa7KRKXmbSbJdybEOjO.', '', '', 10, 0, 0, 0);