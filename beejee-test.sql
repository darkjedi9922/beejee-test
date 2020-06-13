-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июн 13 2020 г., 15:27
-- Версия сервера: 10.1.38-MariaDB
-- Версия PHP: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `beejee-test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `todos`
--

CREATE TABLE `todos` (
  `todo_id` int(10) UNSIGNED NOT NULL,
  `username` varchar(32) COLLATE utf8_bin NOT NULL,
  `email` varchar(32) COLLATE utf8_bin NOT NULL,
  `text` varchar(255) COLLATE utf8_bin NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `admin_edit` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `todos`
--
ALTER TABLE `todos`
  ADD PRIMARY KEY (`todo_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `todos`
--
ALTER TABLE `todos`
  MODIFY `todo_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
