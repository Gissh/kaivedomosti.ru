-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 24 2019 г., 23:58
-- Версия сервера: 5.5.58
-- Версия PHP: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `vedomosti`
--

-- --------------------------------------------------------

--
-- Структура таблицы `dopusk`
--

CREATE TABLE `dopusk` (
  `id` int(11) NOT NULL,
  `nagr` int(10) NOT NULL,
  `student` int(10) NOT NULL,
  `ball` int(10) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `grupp`
--

CREATE TABLE `grupp` (
  `id` int(11) NOT NULL,
  `uch` int(11) DEFAULT NULL,
  `nazv` char(255) DEFAULT NULL,
  `spec` int(11) DEFAULT NULL,
  `act` int(11) DEFAULT NULL,
  `curs` int(11) DEFAULT NULL,
  `god` int(11) DEFAULT NULL
) ENGINE=MyISAM AVG_ROW_LENGTH=790 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

--
-- Дамп данных таблицы `grupp`
--

INSERT INTO `grupp` (`id`, `uch`, `nazv`, `spec`, `act`, `curs`, `god`) VALUES
(1, 3, '31495', 1, 1, 4, 2014),
(9, 3, '31295', 1, 1, 2, 2015);

-- --------------------------------------------------------

--
-- Структура таблицы `kurator`
--

CREATE TABLE `kurator` (
  `id` int(11) NOT NULL,
  `prepod_id` int(50) NOT NULL,
  `grupp_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `kurator`
--

INSERT INTO `kurator` (`id`, `prepod_id`, `grupp_id`) VALUES
(1, 3, 1),
(2, 3, 9);

-- --------------------------------------------------------

--
-- Структура таблицы `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `menu`
--

INSERT INTO `menu` (`id`, `name`, `link`, `admin`) VALUES
(11, 'Навигация', 'http://kaivedomosti.ru/admin/navigation.php', 1),
(13, 'Вход', 'http://kaivedomosti.ru/site/login.php', 0),
(14, 'Ведомости', 'http://kaivedomosti.ru/site/selectNagr.php', 0),
(15, 'Навигация', 'http://kaivedomosti.ru/site/navigation.php', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `nagr`
--

CREATE TABLE `nagr` (
  `id` int(11) NOT NULL,
  `prepod` int(11) DEFAULT NULL,
  `predmet` int(11) DEFAULT NULL,
  `uch` int(11) DEFAULT NULL,
  `chas` int(11) DEFAULT NULL,
  `tip_ekz` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `sem` int(11) DEFAULT NULL,
  `grupp` int(11) DEFAULT NULL,
  `god` int(11) DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `nagr`
--

INSERT INTO `nagr` (`id`, `prepod`, `predmet`, `uch`, `chas`, `tip_ekz`, `date`, `sem`, `grupp`, `god`, `active`) VALUES
(1, 3, 36, 3, 32, 1, '0000-00-00', 1, 1, 2007, 1),
(11, 3, 41, 3, 50, 3, '2019-06-24', 1, 1, 2019, 0),
(12, 2, 36, 3, 50, 3, '2019-06-28', 1, 9, 2019, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `objasn`
--

CREATE TABLE `objasn` (
  `id` int(11) NOT NULL,
  `student_id` int(10) NOT NULL,
  `link` int(10) DEFAULT NULL,
  `text` varchar(1000) NOT NULL,
  `obj_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `objasn`
--

INSERT INTO `objasn` (`id`, `student_id`, `link`, `text`, `obj_date`) VALUES
(1, 1, NULL, 'fesfsdfsdfsdafsdadfasfasdfdsfdsfasdfadsfdsa', '0000-00-00'),
(2, 2, NULL, 'Мне лень вставать в 7 утра', '2019-05-07'),
(3, 3, NULL, 'hjmcxvhjZCVchjkZV ZXaslsavysv liac gvslyivasl ahyflihkavhlisdfa dfassd ffg sdfdf', '2019-06-24');

-- --------------------------------------------------------

--
-- Структура таблицы `predmet`
--

CREATE TABLE `predmet` (
  `id` int(11) NOT NULL,
  `uch` int(11) NOT NULL,
  `nazv` varchar(500) DEFAULT NULL,
  `god` int(11) DEFAULT NULL
) ENGINE=InnoDB AVG_ROW_LENGTH=8192 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `predmet`
--

INSERT INTO `predmet` (`id`, `uch`, `nazv`, `god`) VALUES
(36, 3, 'Физика', 322),
(37, 1, 'Иной язык', 2111),
(39, 3, 'История магии ', 2000),
(41, 3, 'Способ найти фею', 2000);

-- --------------------------------------------------------

--
-- Структура таблицы `prepod`
--

CREATE TABLE `prepod` (
  `id` int(11) NOT NULL,
  `fam` char(255) NOT NULL,
  `name` char(255) NOT NULL,
  `otch` char(255) NOT NULL,
  `login` char(255) DEFAULT NULL,
  `passw` char(255) NOT NULL,
  `tel` char(20) NOT NULL,
  `mail` char(150) NOT NULL,
  `uch` int(11) DEFAULT NULL,
  `act` int(11) DEFAULT '0',
  `kurator` int(1) NOT NULL COMMENT '0 - prepod 1 - admin 2 - kurator'
) ENGINE=InnoDB AVG_ROW_LENGTH=8192 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `prepod`
--

INSERT INTO `prepod` (`id`, `fam`, `name`, `otch`, `login`, `passw`, `tel`, `mail`, `uch`, `act`, `kurator`) VALUES
(2, '322', '322', '322', '322', '322', '322', '322', 3, 0, 1),
(3, 'Я', 'Обожаю', 'ПхП', 'phplover', '12345', '3122132312312', 'test', 3, 0, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `prikaz_stud`
--

CREATE TABLE `prikaz_stud` (
  `id` int(11) NOT NULL,
  `tipe` int(11) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `comment` text,
  `student` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `spec`
--

CREATE TABLE `spec` (
  `id` int(11) NOT NULL,
  `uch` int(11) DEFAULT NULL,
  `nazv` char(255) DEFAULT NULL,
  `nomer` varchar(50) DEFAULT NULL,
  `god` int(11) DEFAULT NULL
) ENGINE=InnoDB AVG_ROW_LENGTH=16384 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `spec`
--

INSERT INTO `spec` (`id`, `uch`, `nazv`, `nomer`, `god`) VALUES
(1, 3, 'Программирование в компьютерных системах', '35.02.25', 2010),
(2, 3, 'Верховая езда на единорогах', '11.22.33', 2003);

-- --------------------------------------------------------

--
-- Структура таблицы `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `fam` char(255) NOT NULL,
  `name` char(255) NOT NULL,
  `otch` char(255) NOT NULL,
  `nzach` char(255) NOT NULL,
  `grupp` int(11) NOT NULL,
  `uch` int(11) NOT NULL
) ENGINE=InnoDB AVG_ROW_LENGTH=5461 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `student`
--

INSERT INTO `student` (`id`, `fam`, `name`, `otch`, `nzach`, `grupp`, `uch`) VALUES
(1, 'Иванов', 'Сидор', 'Сидорович', '35860215', 1, 3),
(2, 'Сидоров', 'Иоанн', 'Гладиолус', '3222323232', 1, 3),
(3, 'Безымянный', 'Аноним', 'Анонимович', '1852105', 9, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `sved_razdel`
--

CREATE TABLE `sved_razdel` (
  `id` int(11) NOT NULL,
  `nazv` char(255) DEFAULT NULL,
  `uch` int(11) NOT NULL
) ENGINE=InnoDB AVG_ROW_LENGTH=16384 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `sved_razdel`
--

INSERT INTO `sved_razdel` (`id`, `nazv`, `uch`) VALUES
(1, 'Документы', 3),
(2, 'Не документы', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `sved_stud`
--

CREATE TABLE `sved_stud` (
  `id` int(11) NOT NULL,
  `student` int(11) NOT NULL,
  `tip_sv` int(11) NOT NULL,
  `val` varchar(500) NOT NULL,
  `razdel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `sved_stud`
--

INSERT INTO `sved_stud` (`id`, `student`, `tip_sv`, `val`, `razdel`) VALUES
(1, 1, 1, '123 456 789012', 1),
(2, 3, 1, '9964655654645', 1),
(3, 1, 2, 'asdbluiabiasdasd', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `sved_tip`
--

CREATE TABLE `sved_tip` (
  `id` int(11) NOT NULL,
  `nazv` char(255) NOT NULL,
  `tip` int(11) DEFAULT NULL COMMENT '1 строка 2 число 3 дата 4 список',
  `poisk` int(11) DEFAULT NULL COMMENT '0 без подстановки 1 с подстановкой',
  `list` text COMMENT 'список значений',
  `razdel` int(11) DEFAULT NULL,
  `uch` int(11) DEFAULT NULL
) ENGINE=InnoDB AVG_ROW_LENGTH=8192 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `sved_tip`
--

INSERT INTO `sved_tip` (`id`, `nazv`, `tip`, `poisk`, `list`, `razdel`, `uch`) VALUES
(1, 'Паспорт', 2, 1, NULL, 1, NULL),
(2, 'снилс', 2, NULL, NULL, 2, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `tip_ekz`
--

CREATE TABLE `tip_ekz` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tip_ekz`
--

INSERT INTO `tip_ekz` (`id`, `name`) VALUES
(1, 'Зачет'),
(2, 'Экзамен'),
(3, 'диф. зачет');

-- --------------------------------------------------------

--
-- Структура таблицы `uch`
--

CREATE TABLE `uch` (
  `id` int(11) NOT NULL,
  `nazv` char(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `uch`
--

INSERT INTO `uch` (`id`, `nazv`) VALUES
(1, 'wqwqwqwq'),
(3, 'Институт благородных девиц');

-- --------------------------------------------------------

--
-- Структура таблицы `uspev`
--

CREATE TABLE `uspev` (
  `id` int(11) NOT NULL,
  `nagr` int(11) DEFAULT NULL,
  `student` int(11) DEFAULT NULL,
  `ball` int(11) DEFAULT NULL,
  `comment` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `uspev`
--

INSERT INTO `uspev` (`id`, `nagr`, `student`, `ball`, `comment`) VALUES
(2, 2, 1, 2, '312231321'),
(3, 1, 1, 2, NULL),
(4, 1, 2, 3, NULL),
(5, 11, 1, 2, NULL),
(6, 11, 2, 3, NULL),
(7, 12, 3, 4, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `dopusk`
--
ALTER TABLE `dopusk`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `grupp`
--
ALTER TABLE `grupp`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `kurator`
--
ALTER TABLE `kurator`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `nagr`
--
ALTER TABLE `nagr`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `objasn`
--
ALTER TABLE `objasn`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `predmet`
--
ALTER TABLE `predmet`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `prepod`
--
ALTER TABLE `prepod`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `prikaz_stud`
--
ALTER TABLE `prikaz_stud`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `spec`
--
ALTER TABLE `spec`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sved_razdel`
--
ALTER TABLE `sved_razdel`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sved_stud`
--
ALTER TABLE `sved_stud`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sved_tip`
--
ALTER TABLE `sved_tip`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tip_ekz`
--
ALTER TABLE `tip_ekz`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `uch`
--
ALTER TABLE `uch`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `uspev`
--
ALTER TABLE `uspev`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `dopusk`
--
ALTER TABLE `dopusk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `grupp`
--
ALTER TABLE `grupp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `kurator`
--
ALTER TABLE `kurator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `nagr`
--
ALTER TABLE `nagr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `objasn`
--
ALTER TABLE `objasn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `predmet`
--
ALTER TABLE `predmet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT для таблицы `prepod`
--
ALTER TABLE `prepod`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `prikaz_stud`
--
ALTER TABLE `prikaz_stud`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `spec`
--
ALTER TABLE `spec`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `sved_razdel`
--
ALTER TABLE `sved_razdel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `sved_stud`
--
ALTER TABLE `sved_stud`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `sved_tip`
--
ALTER TABLE `sved_tip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `tip_ekz`
--
ALTER TABLE `tip_ekz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `uch`
--
ALTER TABLE `uch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `uspev`
--
ALTER TABLE `uspev`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
