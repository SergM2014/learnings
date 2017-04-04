-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Апр 04 2017 г., 09:51
-- Версия сервера: 5.7.17-0ubuntu0.16.04.1
-- Версия PHP: 7.0.17-2+deb.sury.org~xenial+1

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
-- Структура таблицы `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role_title` enum('superadmin','admin','user') NOT NULL,
  `upgrading_status` enum('1','2','3') NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `admins`
--

INSERT INTO `admins` (`id`, `avatar`, `login`, `password`, `email`, `role_title`, `upgrading_status`, `token`) VALUES
(1, NULL, 'superadmin', '$2y$10$UDdzNZsrO5czpXYio8tn.O8GUCb15FNe6VXyj8FXbGJrV0ldvVZgu', 'weisse@ukr.net', 'superadmin', '3', 'superuser'),
(2, NULL, 'admin', '$2y$10$p6LCyDLXVOLUGkSF.wiUVuG22rYxzUUAtyb3Xqft8eXdfP6RD6uaW', 'weisse@ukr.net', 'admin', '2', 'admin'),
(3, NULL, 'user', '$2y$10$C2wVmKuWsmqQ8z9i/f5WDe91L.adS6SwBB92dj.R/Fs1opXE/eRNS', 'weisse@ukr.net', 'user', '1', 'user');

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
(2, 'djiu-djitsu'),
(3, 'english'),
(4, 'german'),
(5, 'php'),
(6, 'js'),
(7, 'css'),
(8, 'html');

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
  `comment` text NOT NULL,
  `lesson_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `published` enum('0','1') NOT NULL DEFAULT '0',
  `changed` enum('0','1') NOT NULL DEFAULT '0',
  `added_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `comment`, `lesson_id`, `user_id`, `parent_id`, `published`, `changed`, `added_at`) VALUES
(1, 'Comment 1', 1, 48, 0, '1', '0', '2017-03-07 09:47:49'),
(2, 'Comment 2', 1, 48, 0, '1', '0', '2017-01-14 09:47:49'),
(3, 'comment 3 child of 2', 1, 48, 2, '1', '0', '2016-03-14 09:47:49'),
(4, 'comment 4 child of 2', 1, 48, 2, '1', '0', '2017-02-14 09:47:49'),
(5, 'Comment 5', 1, 1, 0, '1', '0', '2017-03-14 10:02:10'),
(6, 'Comment 6 is child of 5', 1, 48, 5, '1', '0', '2017-03-19 09:00:05'),
(7, '888', 1, 2, 0, '0', '0', '2017-03-31 12:53:06'),
(8, 'qwerty', 1, 2, 0, '0', '0', '2017-04-01 08:48:06'),
(9, 'next commet during rtefactoring', 1, 2, 0, '0', '0', '2017-04-01 08:51:50'),
(10, 'ftyiftgui', 1, 2, 0, '0', '0', '2017-04-01 09:47:18');

-- --------------------------------------------------------

--
-- Структура таблицы `lessons`
--

CREATE TABLE `lessons` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `serie_id` int(10) UNSIGNED DEFAULT NULL,
  `excerpt` text NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `free_status` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `lessons`
--

INSERT INTO `lessons` (`id`, `title`, `icon`, `category_id`, `serie_id`, `excerpt`, `file`, `free_status`) VALUES
(1, 'Крок 1 в боксі', 'carrier.gif', 1, 1, 'АБУ почало кримінальне провадження стосовно голови Солом\'янського суду Людмили Шереметьєвої, яка самоусунулася від своїх обов\'язків у справі Романа Насірова і розпустила суд. Тим самим заблокувавши обрання йому запобіжного заходу.', 'lesson1.mp4', '0'),
(2, 'Крок 2 в боксі', 'ch.gif', 1, 1, 'Про це йдеться у відповіді НАБУ стосовно заяви народних депутатів про кримінальне правопорушення, повідомляє Українська правда.', NULL, '1'),
(3, 'Японська боротьба', 'daikin.gif', 1, 2, 'Заяву прийнято і за результатами її розгляду в Єдиний реєстр досудових рішень внесено відомості про вчинення злочину та розпочато кримінальне провадження.', NULL, '0'),
(4, 'Історія англійської', 'fujitsu.gif', 1, 3, 'Раніше група народних депутатів передала в НАБУ заяву про порушення посадових обов\'язків головою суду Солом\'янського району Києва Шереметьєвою.', NULL, '1'),
(5, 'Німецька в СКСК', 'general_climat.gif', 3, 4, 'У заяві йдеться, що 5 березня Шереметьєва самоусунулася і не виконала свої посадові обов\'язки - не призначила чергового суддю для розгляду клопотання захисту Насірова про відвід судді Олександра Бобровника, який вів засідання про обрання запобіжного заходу відстороненому голові ДФС Насірову.', NULL, '1'),
(6, 'php7', 'gree.gif', 4, 5, 'Відстороненого голову Державної фіскальної служби України Романа Насирова підозрюють у зловживанні службовим становищем і розкраданні державних коштів в сумі понад 2 млрд грн. Слідство вважає, що Насіров, діючи в інтересах депутата Онищенко, в рамках "газової справи" безпідставно надавав деяким підприємствам можливість податкових зобов\'язань в розстрочку. Насіров вийшов з Лук\'янівського СІЗО під заставу в 100 млн грн.', NULL, '1'),
(7, 'Погляд на jquery', 'mitsubishi.gif', 5, 6, 'Колишній боєць батальйону «Донбас» Ярослав Левенець, якого у медіа назвали ймовірним фігурантом справи про вбивство екс-депутата російської Держдуми Дениса Вороненкова, зник після допиту в прокуратурі. Про це журналістам повідомила його дружина Ганна, яка вважає, що чоловік не переховується, а зник. Побратими та люди, які його знали раніше, розповідають про Ярослава як про націоналіста, патріота та привітну людину. А у Генеральній прокуратурі поки не коментують, чи він причетний до справи Вороненкова.', NULL, '1'),
(8, 'Урок css', 'panasonic.gif', 6, 7, 'Ганна, дружина Левенця, повідомила, що за вісім днів до вбивства Дениса Вороненкова, Ярослава затримали на вокзалі, відвезли до поліції, а потім відпустили. А власне у день загибелі екс-депутата Російської Держдуми Левенець поїхав до Києва, адже мав з’явитись у прокуратурі, говорила вона. Об 11-й годині ранку, тобто за півгодини до вбивства, Ганна зв’язалась із чоловіком по телефону.', NULL, '0'),
(9, 'Html forever', 'toshiba.gif', 7, 8, '«Я не знаю, в якій справі його викликали. Чи то у старій, часів Януковича, чи то щодо затримання на вокзалі. Ми коротко поговорили про дітей, він сказав, що любить. Це була звичайна ніжна розмова. Він сказав, що їде додому», – переказує слова Ганни прес-секретар «Правого сектора» Артем Скоропадський у себе на Фейсбуці.', NULL, '0'),
(10, 'Невідомі боксери', 'toshiba.gif', 1, NULL, 'Уже ввечері дня, коли відбулось вбивство, телефон Ярослава не відповідав, зв’язку з ним немає. Приятель чоловіка розповів, що Левенець усе ж був на допиті орієнтовно о 16-17-й годині.', 'lesson2.mp4', '1'),
(11, 'Бокс на початку 20 століття', 'carrier.gif', 1, NULL, 'На кондитерській фабриці «Світоч» встановили нове сучасне обладнання з виробництва вафель відомого європейського виробника. Це вже третя технологічна лінія на фабриці, яку спроектували й виготовили спеціально на замовлення Nestle в Україні.', NULL, '1');

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
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `published` enum('0','1') NOT NULL,
  `changed` enum('0','1') NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `testimonials`
--

INSERT INTO `testimonials` (`id`, `testimonial`, `user_id`, `published`, `changed`, `added_at`) VALUES
(1, 'Українка Еліна Світоліна виграє свій перший титул в сезоні. Перша "ракетка" України і стала переможницею турніру Taiwan Open.\r\n\r\nУ фінальному поєдинку українка не залишила шансів 71-шій "ракетці" світу китаянці Пен Шуай 6:3, 6:2. Для того, щоб виграти матч, Світоліній знадобилося лише 1 година і 8 хвилин.\r\n\r\nПеремога у фіналі International Taiwan Open принесла українці $43 тисячі призових і 280 рейтингових очок. Це дозволило їй закріпитися на 13 місці світового рейтингу.\r\n\r\nСлід зазначити, що це вже п\'ятий титул, який Світоліна завоювала на турнірах WTA в одиночному розряді.', 1, '1', '0', '2017-03-26 06:56:19'),
(2, 'Тем, кто самостоятельно не может платить по счетам, в «Киевэнерго» предлагают реструктуризировать долг на пять лет и расплачиваться частями. Больше всего должников в Печерском районе – здесь на каждого человека приходится 2,9 тыс. гривен дол\r\nИсточник: domik.ua\r\n\r\n', 1, '1', '0', '2017-03-26 06:56:19'),
(3, ' Законе Украины "Об исполнительном производстве" говорится, что арестовать единственную недвижимость должника можно только в том случае, если сумма долга превышает размер 20 минимальных зарплат – то есть 64 тыс. гривен (статья 48 закона). При этом срок исковой давности – три года. Если не платил пять лет- в суде имеют право взыскать только сумму за три года.\r\nИсточник: domik.ua', 2, '1', '0', '2017-03-26 06:56:19'),
(4, '"После решение суда будет десять суток на обжалование. Тогда уже заседание будет проходить с приглашением сторон. Всегда можно попросить реструктуризировать долг, начать его поэтапно выплачивать. Риск потерять квартиру есть, скажем так, у самых несознательных граждан", – поясняет Александр Плохотник.\r\nИсточник: domik.ua', 3, '1', '0', '2017-03-26 06:56:19'),
(5, 'That s my test testimonial', 48, '0', '0', '2017-03-28 05:21:32'),
(6, 'bumbum', 2, '0', '0', '2017-03-28 06:58:03'),
(7, 'joip', 2, '0', '0', '2017-04-01 07:12:21');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `start_date` date DEFAULT NULL,
  `subscription_term` enum('NULL','monthly','quarterly','yearly') DEFAULT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `avatar`, `login`, `password`, `email`, `start_date`, `subscription_term`, `token`) VALUES
(1, NULL, 'user', '$2y$10$ijzbdMcVQrsmgtkl.yMh2elYvglRhm3D4e7H06b57JhmTMJPurDT6', 'weise@ukr.net', '2017-05-01', NULL, 'usertoken'),
(2, 'p1010006_1489132783.jpg', 'admin', '$2y$10$dH6AjZ71OXjca.T/WaB9ROo/jpF6zhDEAw6XkBxEUkXb/TOVtg50W', 'weisse@ukr.net', '2017-05-01', 'quarterly', 'admintoken'),
(3, NULL, 'superadmin', '$2y$10$ijzbdMcVQrsmgtkl.yMh2elYvglRhm3D4e7H06b57JhmTMJPurDT6', 'weisse@ukr.net', '2012-05-01', NULL, 'superadmintoken'),
(48, 'p1010006_1489132783.jpg', '111111', '$2y$10$ijzbdMcVQrsmgtkl.yMh2elYvglRhm3D4e7H06b57JhmTMJPurDT6', 'weisse@ukr.net', NULL, NULL, '3ec97e2f6de6886552c50dbb415e57fe'),
(49, NULL, '222222', '$2y$10$rtMylYr9Jrvcl8xPTsi5XemGya9KsZ0Ct9WS2dDHq9qpyAJkWmUOq', 'weisse@ukr.net', NULL, NULL, '84fbac7023d8cb6d0c948d41c2b7ebe7');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `background`
--
ALTER TABLE `background`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `categories` ADD FULLTEXT KEY `title` (`title`);

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
  ADD KEY `series_id` (`serie_id`),
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
-- AUTO_INCREMENT для таблицы `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
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
  ADD CONSTRAINT `lessons_ibfk_1` FOREIGN KEY (`serie_id`) REFERENCES `series` (`id`),
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
