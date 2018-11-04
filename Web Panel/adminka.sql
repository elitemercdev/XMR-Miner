-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Хост: 10.0.0.73
-- Время создания: Авг 11 2017 г., 13:45
-- Версия сервера: 5.7.18-16
-- Версия PHP: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `a0149298_adminka`
--

-- --------------------------------------------------------

--
-- Структура таблицы `completed`
--

CREATE TABLE `completed` (
  `id` int(11) NOT NULL,
  `hwid` longtext NOT NULL,
  `taskid` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `completed`
--

INSERT INTO `completed` (`id`, `hwid`, `taskid`) VALUES
(1, 'C64B220E', '2'),
(2, '5E4AA0AF', '2'),
(3, '13371337', '2'),
(4, 'C621E64D', '8'),
(5, '24218D8D', '27'),
(6, '24218D8D', '29'),
(7, '24218D8D', '27'),
(8, '24218D8D', '29'),
(9, '24218D8D', '27'),
(10, '24218D8D', '29'),
(11, '24218D8D', '27'),
(12, '24218D8D', '29'),
(13, '24218D8D', '27'),
(14, '24218D8D', '29'),
(15, '24218D8D', '27'),
(16, '24218D8D', '29'),
(17, '24218D8D', '27'),
(18, '24218D8D', '29'),
(19, '24218D8D', '27'),
(20, '24218D8D', '29'),
(21, '24218D8D', '27'),
(22, '24218D8D', '29'),
(23, '24218D8D', '27'),
(24, '24218D8D', '29'),
(25, '24218D8D', '27'),
(26, '24218D8D', '29'),
(27, '24218D8D', '27'),
(28, '24218D8D', '29'),
(29, '24218D8D', '27'),
(30, '24218D8D', '29'),
(31, '24218D8D', '27'),
(32, '24218D8D', '29'),
(33, '24218D8D', '27'),
(34, '24218D8D', '29'),
(35, '24218D8D', '27'),
(36, '24218D8D', '29'),
(37, '24218D8D', '27'),
(38, '24218D8D', '29'),
(39, '24218D8D', '27'),
(40, '24218D8D', '29'),
(41, '24218D8D', '27'),
(42, '24218D8D', '29'),
(43, '24218D8D', '27'),
(44, '24218D8D', '29'),
(45, '24218D8D', '27'),
(46, '24218D8D', '29'),
(47, '24218D8D', '27'),
(48, '24218D8D', '29');

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `type` varchar(45) NOT NULL,
  `status` varchar(45) NOT NULL,
  `trigger` longtext NOT NULL,
  `name` longtext NOT NULL,
  `url` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`id`, `type`, `status`, `trigger`, `name`, `url`) VALUES
(37, 'Download & Excecute', 'ACTIVE', 'On join', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `userinfo`
--

CREATE TABLE `userinfo` (
  `id` int(11) NOT NULL,
  `login` longtext NOT NULL,
  `password` longtext NOT NULL,
  `navbar` varchar(45) NOT NULL,
  `reconnect` longtext NOT NULL,
  `color` longtext NOT NULL,
  `sound` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `userinfo`
--

INSERT INTO `userinfo` (`id`, `login`, `password`, `navbar`, `reconnect`, `color`, `sound`) VALUES
(1, 'admin', '123', 'inverse', '1', 'Premium', 'on');

-- --------------------------------------------------------

--
-- Структура таблицы `workers`
--

CREATE TABLE `workers` (
  `id` int(11) NOT NULL,
  `ip` varchar(45) NOT NULL,
  `hwid` longtext NOT NULL,
  `seen` varchar(45) NOT NULL,
  `location` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `completed`
--
ALTER TABLE `completed`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `userinfo`
--
ALTER TABLE `userinfo`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `workers`
--
ALTER TABLE `workers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `completed`
--
ALTER TABLE `completed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT для таблицы `userinfo`
--
ALTER TABLE `userinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `workers`
--
ALTER TABLE `workers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
