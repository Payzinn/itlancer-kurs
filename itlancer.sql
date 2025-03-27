-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 26 2025 г., 22:45
-- Версия сервера: 10.8.4-MariaDB
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `itlancer`
--

-- --------------------------------------------------------

--
-- Структура таблицы `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `files`
--

INSERT INTO `files` (`id`, `path`, `order_id`) VALUES
(21, 'uploads/67e431966172b_терминология.docx', 20);

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `response_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `moderation_status`
--

CREATE TABLE `moderation_status` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `moderation_status`
--

INSERT INTO `moderation_status` (`id`, `name`) VALUES
(1, 'На проверке'),
(2, 'Проверено'),
(3, 'Не прошло проверку');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sphere_type_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_id` int(11) NOT NULL DEFAULT 1,
  `moderation_status_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `name`, `description`, `sphere_type_id`, `user_id`, `date`, `price`, `status_id`, `moderation_status_id`) VALUES
(20, 'wryrweyt', 'qwereyrweyyrwe', 15, 6, '2025-03-26 19:55:50', '66', 1, 3),
(53, 'Разработка сайта для бизнеса', 'Нужен сайт для компании с каталогом товаров', 1, 5, '2023-01-15 10:00:00', '25000', 1, 2),
(54, 'Лендинг под ключ', 'Создать лендинг для мероприятия', 1, 6, '2023-02-20 14:30:00', '15000', 2, 2),
(55, 'Сайт для стартапа', 'Разработка минималистичного сайта', 1, 5, '2023-03-10 09:00:00', '20000', 1, 1),
(56, 'API для мобильного приложения', 'Создать REST API для приложения', 2, 6, '2023-04-05 16:00:00', '30000', 1, 2),
(57, 'Серверная логика для игры', 'Разработка бэкенда для онлайн-игры', 2, 5, '2023-05-12 11:00:00', '40000', 3, 3),
(58, 'Интерфейс для веб-приложения', 'Создать современный UI/UX', 3, 6, '2023-06-18 13:00:00', '18000', 1, 1),
(59, 'Редизайн сайта', 'Обновить фронтенд старого сайта', 3, 5, '2023-07-22 15:00:00', '12000', 2, 2),
(60, 'Парсер цен конкурентов', 'Скрипт для парсинга цен с сайтов', 4, 6, '2023-08-30 12:00:00', '8000', 1, 1),
(61, 'Автоматизация задач', 'Написать скрипт для автоматизации', 4, 5, '2023-09-10 17:00:00', '6000', 2, 2),
(62, 'Телеграм-бот для магазина', 'Создать бота для обработки заказов', 5, 6, '2023-10-05 10:00:00', '10000', 1, 2),
(63, 'Парсер новостей', 'Собрать данные с новостных сайтов', 5, 5, '2023-11-15 14:00:00', '7000', 3, 3),
(64, 'Мобильная игра', 'Разработка 2D-игры для Android', 6, 6, '2023-12-20 09:00:00', '50000', 1, 1),
(65, 'Игра для ПК', 'Создать прототип игры на Unity', 6, 5, '2024-01-10 16:00:00', '45000', 2, 2),
(66, 'Интеграция 1C с сайтом', 'Настроить обмен данными', 7, 6, '2024-02-15 11:00:00', '20000', 1, 2),
(67, 'Автоматизация учета', 'Настройка 1C для склада', 7, 5, '2024-03-20 13:00:00', '25000', 2, 2),
(68, 'Приложение для доставки', 'Создать приложение для службы доставки', 8, 6, '2024-04-10 15:00:00', '35000', 1, 1),
(69, 'Фитнес-приложение', 'Разработка приложения для тренировок', 8, 5, '2024-05-05 10:00:00', '30000', 2, 2),
(70, 'iOS приложение для заметок', 'Создать приложение для iPhone', 9, 6, '2024-06-15 12:00:00', '32000', 1, 2),
(71, 'Медитативное приложение', 'Приложение для медитаций на iOS', 9, 5, '2024-07-20 14:00:00', '28000', 3, 3),
(72, 'Программа для учета', 'Десктопное приложение для бухгалтерии', 10, 6, '2024-08-10 09:00:00', '20000', 1, 1),
(73, 'Клиент для чата', 'Создать десктопный чат-клиент', 10, 5, '2024-09-15 16:00:00', '15000', 2, 2),
(74, 'Логотип для кафе', 'Создать логотип в минималистичном стиле', 11, 6, '2024-10-05 11:00:00', '5000', 1, 2),
(75, 'Логотип для бренда одежды', 'Дизайн логотипа для модного бренда', 11, 5, '2024-11-10 13:00:00', '7000', 2, 2),
(76, 'Иллюстрация для книги', 'Нарисовать иллюстрацию для детской книги', 12, 6, '2024-12-15 15:00:00', '8000', 1, 1),
(77, 'Арт для игры', 'Создать концепт-арт персонажа', 12, 5, '2025-01-20 10:00:00', '9000', 2, 2),
(78, 'Иконки для приложения', 'Создать набор иконок для UI', 13, 6, '2025-02-10 12:00:00', '4000', 1, 2),
(79, 'Иконки для сайта', 'Дизайн иконок для интернет-магазина', 13, 5, '2025-03-15 14:00:00', '3500', 2, 2),
(80, 'Векторный логотип', 'Создать векторный логотип для компании', 14, 6, '2025-04-05 09:00:00', '6000', 1, 1),
(81, 'Векторная иллюстрация', 'Нарисовать векторный баннер', 14, 5, '2025-05-10 16:00:00', '5500', 2, 2),
(82, 'Дизайн интерфейса', 'Создать стиль для веб-приложения', 15, 6, '2025-06-15 11:00:00', '12000', 1, 2),
(83, 'Стили для сайта', 'Разработать функциональный дизайн', 15, 5, '2025-07-20 13:00:00', '10000', 2, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `portfolio`
--

CREATE TABLE `portfolio` (
  `id` int(11) NOT NULL,
  `resume_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `hour_salary` int(11) NOT NULL,
  `month_salary` int(11) NOT NULL,
  `experience` int(11) NOT NULL,
  `sphere_type_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `portfolio`
--

INSERT INTO `portfolio` (`id`, `resume_text`, `hour_salary`, `month_salary`, `experience`, `sphere_type_id`, `user_id`) VALUES
(2, 'rtuy4rwturtu', 56856865, 534325475, 77, 8, 5),
(3, 'я исполнитель', 600, 40000, 77, 8, 7),
(4, 'deqrfyeqrtyey', 666, 77777, 5, 4, 10),
(5, 'sreryreyre', 666, 7777, 6, 2, 9);

-- --------------------------------------------------------

--
-- Структура таблицы `prices`
--

CREATE TABLE `prices` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `prices`
--

INSERT INTO `prices` (`id`, `name`) VALUES
(1, 'В час'),
(2, 'За проект');

-- --------------------------------------------------------

--
-- Структура таблицы `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `user_from_id` int(11) NOT NULL,
  `feedback` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating_status_id` int(11) NOT NULL,
  `user_to_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `rating_status`
--

CREATE TABLE `rating_status` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `rating_status`
--

INSERT INTO `rating_status` (`id`, `name`) VALUES
(1, 'Лайк'),
(2, 'Дизлайк');

-- --------------------------------------------------------

--
-- Структура таблицы `responses`
--

CREATE TABLE `responses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `term` int(11) NOT NULL,
  `responser_price` int(11) NOT NULL,
  `status_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `responses`
--

INSERT INTO `responses` (`id`, `user_id`, `order_id`, `description`, `term`, `responser_price`, `status_id`) VALUES
(8, 7, 53, 'укукне', 5, 25000, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `rights`
--

CREATE TABLE `rights` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `rights`
--

INSERT INTO `rights` (`id`, `name`) VALUES
(1, 'Админ'),
(2, 'Пользователь');

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Работодатель'),
(2, 'Фрилансер');

-- --------------------------------------------------------

--
-- Структура таблицы `spheres`
--

CREATE TABLE `spheres` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `spheres`
--

INSERT INTO `spheres` (`id`, `name`) VALUES
(4, 'Разработка'),
(5, 'Дизайн'),
(6, 'Маркетинг');

-- --------------------------------------------------------

--
-- Структура таблицы `sphere_types`
--

CREATE TABLE `sphere_types` (
  `id` int(11) NOT NULL,
  `sphere_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sphere_types`
--

INSERT INTO `sphere_types` (`id`, `sphere_id`, `name`) VALUES
(1, 4, 'Сайты под ключ'),
(2, 4, 'Бэкенд'),
(3, 4, 'Фронтенд'),
(4, 4, 'Скрипты и плагины'),
(5, 4, 'Боты и парсинг данных'),
(6, 4, 'Разработка игр'),
(7, 4, '1С-программирование'),
(8, 4, 'Android'),
(9, 4, 'iOS'),
(10, 4, 'Десктопное ПО'),
(11, 5, 'Логотипы'),
(12, 5, 'Рисунки и иллюстрации'),
(13, 5, 'Иконки'),
(14, 5, 'Баннеры'),
(15, 5, 'Векторная графика'),
(16, 5, 'Фирменный стиль'),
(17, 5, 'Презентации'),
(19, 5, 'Анимация'),
(20, 5, 'Обработка фото'),
(21, 5, 'Лендинги'),
(22, 5, 'Сайты'),
(23, 6, 'SMM'),
(24, 6, 'SEO'),
(25, 6, 'Контекстная реклама'),
(26, 6, 'E-mail маркетинг'),
(27, 6, 'PR-менеджмент'),
(28, 6, 'Исследования рынка и опросы');

-- --------------------------------------------------------

--
-- Структура таблицы `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `status`
--

INSERT INTO `status` (`id`, `name`) VALUES
(1, 'На рассмотрении'),
(2, 'В работе'),
(3, 'Отменено'),
(4, 'Сделано');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL,
  `right_id` int(11) NOT NULL DEFAULT 2,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `email`, `password`, `role_id`, `right_id`, `date`) VALUES
(3, 'darkfantasy', 'payzinn@gmail.com', '1J2`1352356f', 2, 2, '2025-02-04'),
(5, 'rwgturytiuj', 'remizevicaleksandr398@gmail.com', 'sdfgturwtuF1', 1, 2, '2025-02-19'),
(6, 'payzinn', '123@mail.ru', '1JH1254rwge', 1, 2, '2025-03-21'),
(7, 'ertue', '236t23@24yr.com', '1JG235yrert', 2, 2, '2025-03-21'),
(8, 'darkfantasyretert', 'jojowetwetvjojoetweytweryrwe@mail.com', 'wrseyrwt!@1G', 2, 2, '2025-03-24'),
(9, 'wellwellwell', 'natakorsa13@gmail.com', 'well1W$gerthg', 2, 2, '2025-03-26'),
(10, 'eqryerwqywtr', 'crazyeryryerff23124@gmail.com', '1Dfethtr24w', 2, 2, '2025-03-26'),
(11, 'admin', 'admin', 'admin', 2, 1, '2025-03-26'),
(12, 'ertueyery', 'payzerreyreyinn@gmail.com', '1JG235yrerteryry', 2, 2, '2025-03-26');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `response_id` (`response_id`);

--
-- Индексы таблицы `moderation_status`
--
ALTER TABLE `moderation_status`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sphere_type_id` (`sphere_type_id`,`user_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `moderation_status_id` (`moderation_status_id`);

--
-- Индексы таблицы `portfolio`
--
ALTER TABLE `portfolio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sphere_type_id` (`sphere_type_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `prices`
--
ALTER TABLE `prices`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rating_status_id` (`rating_status_id`),
  ADD KEY `user_from_id` (`user_from_id`);

--
-- Индексы таблицы `rating_status`
--
ALTER TABLE `rating_status`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `responses`
--
ALTER TABLE `responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Индексы таблицы `rights`
--
ALTER TABLE `rights`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `spheres`
--
ALTER TABLE `spheres`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Индексы таблицы `sphere_types`
--
ALTER TABLE `sphere_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sphere_id` (`sphere_id`);

--
-- Индексы таблицы `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `right_id` (`right_id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT для таблицы `moderation_status`
--
ALTER TABLE `moderation_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT для таблицы `portfolio`
--
ALTER TABLE `portfolio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `prices`
--
ALTER TABLE `prices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `rating_status`
--
ALTER TABLE `rating_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `responses`
--
ALTER TABLE `responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `rights`
--
ALTER TABLE `rights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `spheres`
--
ALTER TABLE `spheres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `sphere_types`
--
ALTER TABLE `sphere_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT для таблицы `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`response_id`) REFERENCES `responses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`sphere_type_id`) REFERENCES `sphere_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`moderation_status_id`) REFERENCES `moderation_status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `portfolio`
--
ALTER TABLE `portfolio`
  ADD CONSTRAINT `portfolio_ibfk_1` FOREIGN KEY (`sphere_type_id`) REFERENCES `sphere_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `portfolio_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`rating_status_id`) REFERENCES `rating_status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `responses`
--
ALTER TABLE `responses`
  ADD CONSTRAINT `responses_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `responses_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `responses_ibfk_3` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `sphere_types`
--
ALTER TABLE `sphere_types`
  ADD CONSTRAINT `sphere_types_ibfk_1` FOREIGN KEY (`sphere_id`) REFERENCES `spheres` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`right_id`) REFERENCES `rights` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
