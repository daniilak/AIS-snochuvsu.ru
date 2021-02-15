-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Фев 15 2021 г., 11:00
-- Версия сервера: 5.6.39-83.1
-- Версия PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `bikluss_ais`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `enrolment_regions`
--

CREATE TABLE IF NOT EXISTS `enrolment_regions` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `enrolment_region` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name_event` text NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `date_close_event` date NOT NULL,
  `date_close_add` date NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `is_plan` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `facs`
--

CREATE TABLE IF NOT EXISTS `facs` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `id_lk_chuvsu` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `count_users` int(11) NOT NULL,
  `count_teachers` int(11) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `full_name` text NOT NULL,
  `decan` varchar(40) NOT NULL,
  `photo_url` varchar(255) NOT NULL,
  `pass` varchar(60) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `id_lk_chuvsu` (`id_lk_chuvsu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `guests`
--

CREATE TABLE IF NOT EXISTS `guests` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `id_section` int(11) NOT NULL,
  `id_user_types_inst` int(11) NOT NULL DEFAULT '1',
  `id_position` int(11) NOT NULL DEFAULT '1',
  `count` int(11) NOT NULL DEFAULT '0',
  `name_organization` text NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `id_user_types_inst` (`id_user_types_inst`),
  KEY `id_section` (`id_section`),
  KEY `id_position` (`id_position`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `leaders`
--

CREATE TABLE IF NOT EXISTS `leaders` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `id_section` int(11) NOT NULL,
  `id_request` varchar(5000) NOT NULL DEFAULT '[]',
  `first_name` varchar(255) NOT NULL DEFAULT '',
  `last_name` varchar(255) NOT NULL DEFAULT '',
  `middle_name` varchar(255) NOT NULL DEFAULT '',
  `id_position` int(11) NOT NULL DEFAULT '1',
  `id_user_who_add` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `managers`
--

CREATE TABLE IF NOT EXISTS `managers` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `id_section` int(11) NOT NULL,
  `type_manager` int(11) NOT NULL DEFAULT '3',
  `first_name` varchar(255) NOT NULL DEFAULT '',
  `last_name` varchar(255) NOT NULL DEFAULT '',
  `middle_name` varchar(255) NOT NULL DEFAULT '',
  `id_position` int(11) NOT NULL DEFAULT '1',
  `text_position` text NOT NULL,
  `id_user_who_add` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `id_report` (`id_section`),
  KEY `id_position` (`id_position`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `panels`
--

CREATE TABLE IF NOT EXISTS `panels` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `type` varchar(10) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `positions`
--

CREATE TABLE IF NOT EXISTS `positions` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `name_2` varchar(40) NOT NULL,
  `name_3` varchar(40) NOT NULL,
  `sokr` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `recommendations`
--

CREATE TABLE IF NOT EXISTS `recommendations` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `id_event` int(5) NOT NULL,
  `recommendation` text NOT NULL,
  `min_value` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`),
  KEY `id_event` (`id_event`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `recom_request`
--

CREATE TABLE IF NOT EXISTS `recom_request` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `id_request` int(11) NOT NULL,
  `id_recom` int(11) NOT NULL,
  `checked` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `id_request` (`id_request`),
  KEY `id_recom` (`id_recom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `requests`
--

CREATE TABLE IF NOT EXISTS `requests` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `id_user_who_add` int(11) NOT NULL DEFAULT '1',
  `id_section` int(11) NOT NULL,
  `name_project` text NOT NULL,
  `place` int(11) NOT NULL DEFAULT '4',
  `is_moderator` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `id_section` (`id_section`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `sections`
--

CREATE TABLE IF NOT EXISTS `sections` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `id_event` int(11) NOT NULL,
  `id_fac` int(11) NOT NULL,
  `id_type_section` int(11) NOT NULL DEFAULT '1',
  `name` text NOT NULL,
  `datetime` datetime NOT NULL,
  `location` text NOT NULL,
  `id_disabled_place` tinyint(1) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `phone` varchar(255) NOT NULL,
  `pass` varchar(40) NOT NULL,
  `secretary_vk_id` int(11) NOT NULL,
  `who` varchar(255) NOT NULL DEFAULT '[]',
  PRIMARY KEY (`ID`),
  KEY `id_fac` (`id_fac`),
  KEY `id_event` (`id_event`),
  KEY `id_type_section` (`id_type_section`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `type_sections`
--

CREATE TABLE IF NOT EXISTS `type_sections` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(40) NOT NULL,
  `type_n` varchar(40) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `id_vk` int(11) NOT NULL,
  `id_role` int(11) NOT NULL DEFAULT '0',
  `first_name` varchar(255) NOT NULL DEFAULT '',
  `photo` varchar(255) NOT NULL,
  `GUID` varchar(255) NOT NULL,
  `pass_hash` varchar(60) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  KEY `id_vk` (`id_vk`),
  KEY `id_role` (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `users_sections`
--

CREATE TABLE IF NOT EXISTS `users_sections` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `id_request` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL DEFAULT '',
  `last_name` varchar(255) NOT NULL DEFAULT '',
  `middle_name` varchar(255) NOT NULL DEFAULT '',
  `id_type_inst` int(3) NOT NULL DEFAULT '1',
  `num_student` varchar(40) NOT NULL DEFAULT '',
  `is_chuvsu` tinyint(1) NOT NULL DEFAULT '0',
  `phone` varchar(255) NOT NULL DEFAULT '',
  `city` varchar(255) NOT NULL DEFAULT 'Чебоксары',
  `name_organization` text NOT NULL,
  `stip` tinyint(1) NOT NULL DEFAULT '0',
  `groupname` varchar(30) NOT NULL DEFAULT '',
  `faculty_id` int(11) NOT NULL DEFAULT '0',
  `course` int(1) NOT NULL DEFAULT '0',
  `level` text NOT NULL,
  `id_user_who_add` varchar(11) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  KEY `id_request` (`id_request`),
  KEY `id_type_inst` (`id_type_inst`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `user_types_inst`
--

CREATE TABLE IF NOT EXISTS `user_types_inst` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `users_sections`
--
ALTER TABLE `users_sections`
  ADD CONSTRAINT `users_sections_ibfk_1` FOREIGN KEY (`id_request`) REFERENCES `requests` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
