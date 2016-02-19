-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Апр 29 2015 г., 13:42
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `test_registration`
--

CREATE TABLE IF NOT EXISTS `test_registration` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_avatar_big` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_surename` varchar(255) NOT NULL,
  `user_login` varchar(255) NOT NULL,
  `user_password` varchar(32) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_birth_date` varchar(30) NOT NULL,
  `user_telephone` varchar(30) NOT NULL,
  `user_avatar_small` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `id_user` (`user_id`),
  UNIQUE KEY `id_user_2` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `test_registration`
--

INSERT INTO `test_registration` (`user_id`, `user_avatar_big`, `user_name`, `user_surename`, `user_login`, `user_password`, `user_email`, `user_birth_date`, `user_telephone`, `user_avatar_small`) VALUES
(1, 'files/big/1430300318.jpg', 'BobN', 'BobF', 'Bob123456', '44f8487639f54c9fc3bca42a1206d6b0', 'stacey2008@mail.ru', '1111-11-11', '(111) 111-11-11', 'files/mini/1430300318.jpg');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
