-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Фев 11 2017 г., 09:18
-- Версия сервера: 5.7.17-0ubuntu0.16.04.1
-- Версия PHP: 7.0.15-1+deb.sury.org~xenial+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `learnings`
--

-- --------------------------------------------------------

--
-- Структура таблицы `background`
--

CREATE TABLE `background` (
  `id` int(10) UNSIGNED NOT NULL,
  `plan_description_uk` text NOT NULL,
  `plan_description_en` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `background`
--

INSERT INTO `background` (`id`, `plan_description_uk`, `plan_description_en`) VALUES
(1, 'Опис плану підписки', 'Description plan');

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `title`) VALUES
(1, 'box'),
(7, 'css'),
(2, 'djiu-djitsu'),
(3, 'english'),
(4, 'german'),
(8, 'html'),
(6, 'js'),
(5, 'php');

-- --------------------------------------------------------

--
-- Структура таблицы `categories_lessons`
--

CREATE TABLE `categories_lessons` (
  `category_id` int(11) UNSIGNED NOT NULL,
  `lesson_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `avatar_path` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `lesson_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `published` enum('0','1') NOT NULL,
  `changed` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `lessons`
--

CREATE TABLE `lessons` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `series_id` int(10) UNSIGNED DEFAULT NULL,
  `link` varchar(255) NOT NULL,
  `free_status` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `lessons`
--

INSERT INTO `lessons` (`id`, `title`, `icon`, `category_id`, `series_id`, `link`, `free_status`) VALUES
(1, 'Крок 1 в боксі', 'carrier.gif', 1, 1, '/qwerty', '1'),
(2, 'Крок 2 в боксі', 'ch.gif', 1, 1, '/qwerty', '1'),
(3, 'Японська боротьба', 'daikin.gif', 1, 2, '/qwerty', '0'),
(4, 'Історія англійської', 'fujitsu.gif', 1, 3, '/qwerty', '1'),
(5, 'Німецька в СКСК', 'general_climat.gif', 3, 4, '/qwerty', '1'),
(6, 'php7', 'gree.gif', 4, 5, '/qwerty', '1'),
(7, 'Погляд на jquery', 'mitsubishi.gif', 5, 6, '/qwerty', '1'),
(8, 'Урок css', 'panasonic.gif', 6, 7, '/qwerty', '0'),
(9, 'Html forever', 'toshiba.gif', 7, 8, '/qwerty', '0'),
(10, 'Невідомі боксери', 'toshiba.gif', 1, NULL, '/qwerty', '1'),
(11, 'Бокс на початку 20 століття', 'carrier.gif', 1, NULL, '/qwerty', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `series`
--

CREATE TABLE `series` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `upgrading_skill` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `series`
--

INSERT INTO `series` (`id`, `category_id`, `title`, `icon`, `upgrading_skill`) VALUES
(1, 1, 'Перші кроки в боксі', '1.png', 1),
(2, 1, 'Джіу-джітсу в середині', '2.png', 2),
(3, 1, 'Англійська в америкі', '3.png', 3),
(4, 3, 'німецька в европі', '4.png', 3),
(5, 4, 'php сьогодні', '5.png', 1),
(6, 5, 'Історія js', '6.png', 1),
(7, 6, 'css3', '7.png', 2),
(8, 7, 'html5', '8.png', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `subscribtions`
--

CREATE TABLE `subscribtions` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `plan` enum('mohth','quarter','year') NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(10) UNSIGNED NOT NULL,
  `testimonial` text NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `testimonials`
--

INSERT INTO `testimonials` (`id`, `testimonial`, `user_id`) VALUES
(1, 'Українка Еліна Світоліна виграє свій перший титул в сезоні. Перша "ракетка" України і стала переможницею турніру Taiwan Open.\r\n\r\nУ фінальному поєдинку українка не залишила шансів 71-шій "ракетці" світу китаянці Пен Шуай 6:3, 6:2. Для того, щоб виграти матч, Світоліній знадобилося лише 1 година і 8 хвилин.\r\n\r\nПеремога у фіналі International Taiwan Open принесла українці $43 тисячі призових і 280 рейтингових очок. Це дозволило їй закріпитися на 13 місці світового рейтингу.\r\n\r\nСлід зазначити, що це вже п\'ятий титул, який Світоліна завоювала на турнірах WTA в одиночному розряді.', NULL),
(2, 'Тем, кто самостоятельно не может платить по счетам, в «Киевэнерго» предлагают реструктуризировать долг на пять лет и расплачиваться частями. Больше всего должников в Печерском районе – здесь на каждого человека приходится 2,9 тыс. гривен дол\r\nИсточник: domik.ua\r\n\r\n', 1),
(3, ' Законе Украины "Об исполнительном производстве" говорится, что арестовать единственную недвижимость должника можно только в том случае, если сумма долга превышает размер 20 минимальных зарплат – то есть 64 тыс. гривен (статья 48 закона). При этом срок исковой давности – три года. Если не платил пять лет- в суде имеют право взыскать только сумму за три года.\r\nИсточник: domik.ua', 2),
(4, '"После решение суда будет десять суток на обжалование. Тогда уже заседание будет проходить с приглашением сторон. Всегда можно попросить реструктуризировать долг, начать его поэтапно выплачивать. Риск потерять квартиру есть, скажем так, у самых несознательных граждан", – поясняет Александр Плохотник.\r\nИсточник: domik.ua', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_title` varchar(50) NOT NULL,
  `upgrading_status` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `role_title`, `upgrading_status`) VALUES
(1, 'user', '$2y$10$C2wVmKuWsmqQ8z9i/f5WDe91L.adS6SwBB92dj.R/Fs1opXE/eRNS', 'user', 1),
(2, 'admin', '$2y$10$p6LCyDLXVOLUGkSF.wiUVuG22rYxzUUAtyb3Xqft8eXdfP6RD6uaW', 'admin', 2),
(3, 'superadmin', '$2y$10$UDdzNZsrO5czpXYio8tn.O8GUCb15FNe6VXyj8FXbGJrV0ldvVZgu', 'superadmin', 3);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `background`
--
ALTER TABLE `background`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `title` (`title`);

--
-- Индексы таблицы `categories_lessons`
--
ALTER TABLE `categories_lessons`
  ADD KEY `category_id` (`category_id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lesson_id` (`lesson_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `published` (`published`);
ALTER TABLE `comments` ADD FULLTEXT KEY `comment` (`comment`);

--
-- Индексы таблицы `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `series_id` (`series_id`),
  ADD KEY `category_id` (`category_id`);
ALTER TABLE `lessons` ADD FULLTEXT KEY `title` (`title`);

--
-- Индексы таблицы `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);
ALTER TABLE `series` ADD FULLTEXT KEY `title` (`title`);

--
-- Индексы таблицы `subscribtions`
--
ALTER TABLE `subscribtions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);
ALTER TABLE `testimonials` ADD FULLTEXT KEY `testimonial` (`testimonial`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `background`
--
ALTER TABLE `background`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT для таблицы `series`
--
ALTER TABLE `series`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `subscribtions`
--
ALTER TABLE `subscribtions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `categories_lessons`
--
ALTER TABLE `categories_lessons`
  ADD CONSTRAINT `categories_lessons_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `categories_lessons_ibfk_2` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_ibfk_1` FOREIGN KEY (`series_id`) REFERENCES `series` (`id`),
  ADD CONSTRAINT `lessons_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `series`
--
ALTER TABLE `series`
  ADD CONSTRAINT `series_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Ограничения внешнего ключа таблицы `subscribtions`
--
ALTER TABLE `subscribtions`
  ADD CONSTRAINT `subscribtions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `testimonials`
--
ALTER TABLE `testimonials`
  ADD CONSTRAINT `testimonials_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
