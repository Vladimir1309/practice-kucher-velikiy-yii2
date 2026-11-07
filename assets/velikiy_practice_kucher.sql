-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 07 2026 г., 13:19
-- Версия сервера: 8.0.19
-- Версия PHP: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `velikiy_practice_kucher`
--

-- --------------------------------------------------------

--
-- Структура таблицы `genre`
--

CREATE TABLE `genre` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `genre`
--

INSERT INTO `genre` (`id`, `name`) VALUES
(1, 'Комедия'),
(2, 'Драма'),
(3, 'Фантастика'),
(4, 'Триллер');

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1793866145),
('m261105_080704_create_movie_table', 1793866151),
('m261105_081214_create_user_table', 1793866708),
('m261105_081526_create_genre_table', 1793866708),
('m261105_081601_create_user_movie_table', 1793866708),
('m261106_063243_add_genre_id_to_movie', 1793948713),
('m261106_091500_add_notifications_to_user', 1793956571),
('m261107_000000_add_avatar_to_user', 1794039889);

-- --------------------------------------------------------

--
-- Структура таблицы `movie`
--

CREATE TABLE `movie` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `year` int DEFAULT NULL,
  `duration` int DEFAULT NULL,
  `poster_url` varchar(255) DEFAULT NULL,
  `genre_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `movie`
--

INSERT INTO `movie` (`id`, `title`, `description`, `year`, `duration`, `poster_url`, `genre_id`) VALUES
(1, 'Французский вестник', 'История о журналистах и любви в вымышленном французском городе.', 2021, 108, '/uploads/posters/poster_1.jpg', 1),
(2, 'Свет далёких улиц2', 'Драма о поиске себя и старых друзьях.', 2020, 120, '/uploads/posters/poster_2.jpg', 2),
(3, 'Город после полуночи', 'Фантастический триллер о будущем мегаполисе.', 2022, 135, '/uploads/posters/poster_3.jpg', 3),
(4, 'Последний сеанс', 'Мистическая история в старом кинотеатре.', 2019, 95, '/uploads/posters/poster_4.jpg', 4),
(5, 'Дюна: Часть вторая', 'Пол Атрейдес объединяется с фрименами, чтобы отомстить заговорщикам.', 2024, 166, '/uploads/posters/poster_5.jpg', 3),
(6, 'Оппенгеймер', 'История американского ученого Роберта Оппенгеймера и создания атомной бомбы.', 2023, 180, '/uploads/posters/poster_6.jpg', 2),
(7, 'Барби', 'Барби и Кен отправляются в путешествие в реальный мир.', 2023, 114, '/uploads/posters/poster_7.jpg', 1),
(8, 'Бедные-несчастные', 'Фантастическая история о женщине, оживленной ученым.', 2023, 141, '/uploads/posters/poster_8.jpg', 3),
(9, 'Убийцы цветочной луны', 'История убийств в племени индейцев осейджей в 1920-х годах.', 2023, 206, '/uploads/posters/poster_9.jpg', 4),
(10, 'Прошлые жизни', 'Два друга детства встречаются спустя много лет.', 2023, 106, '/uploads/posters/poster_10.jpg', 2),
(11, 'Годзилла и Конг: Новая империя', 'Два титана объединяются против новой угрозы.', 2024, 115, '/uploads/posters/poster_11.jpg', 3),
(12, 'Фуриоса: Безумный Макс', 'Приквел к фильму «Безумный Макс: Дорога ярости».', 2024, 148, '/uploads/posters/poster_12.jpg', 4),
(13, 'Дэдпул и Росомаха', 'Уэйд Уилсон объединяется с Росомахой для спасения мультивселенной.', 2024, 127, '/uploads/posters/poster_13.jpg', 3),
(14, 'Головоломка 2', 'Новые эмоции появляются в голове Райли.', 2024, 96, '/uploads/posters/poster_14.jpg', 1),
(15, 'Тихое место: День первый', 'Начало вторжения инопланетных существ.', 2024, 100, '/uploads/posters/poster_15.jpg', 4),
(16, 'Плохие парни до конца', 'Детективы Майк и Маркус снова в деле.', 2024, 115, '/uploads/posters/poster_16.jpg', 1),
(17, 'Гарфилд', 'Приключения ленивого кота Гарфилда.', 2024, 101, '/uploads/posters/poster_17.jpg', 1),
(18, 'Планета обезьян: Новое царство', 'Новое поколение обезьян пытается найти свое место в мире.', 2024, 145, '/uploads/posters/poster_18.jpg', 3),
(19, 'Каскадер', 'История каскадера, который ищет пропавшую звезду.', 2024, 126, '/uploads/posters/poster_19.jpg', 2),
(20, 'Омен: Первое знамение', 'Приквел к классическому фильму ужасов.', 2024, 120, '/uploads/posters/5kA_cyKJqa18uJiW8g9ys_uvQvkGItZr.jpg', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `role`
--

CREATE TABLE `role` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'user'),
(2, 'admin');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `notify_news` tinyint(1) NOT NULL DEFAULT '0',
  `notify_reminders` tinyint(1) NOT NULL DEFAULT '0',
  `role_id` int NOT NULL DEFAULT '1',
  `avatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `nickname`, `last_name`, `birthdate`, `email`, `password_hash`, `phone`, `created_at`, `notify_news`, `notify_reminders`, `role_id`, `avatar`) VALUES
(1, 'Давид', '', 'Рябов', NULL, 'david@gmail.com', '$2y$13$jFcvpyU9.ky8Kt7YHJkUfePzJLCe78Hv4N8iGpnW4XMa3hG3/EPtu', '', '2026-11-05 11:37:22', 1, 1, 1, '/uploads/avatars/YMcdJJ7RK15wmx5xsrcGMBGyo8ZV_2QE.jpg'),
(6, 'admin', NULL, NULL, NULL, 'admin@gmail.com', '$2y$13$9CwQauzE4CLWP1f8ov3cye3DHwgQ5ibw0Lukbmh08.MFkAyF6v4ba', NULL, '2026-11-06 13:07:59', 0, 0, 2, NULL),
(7, 'Антон', 'antonnnn', '', NULL, 'anton@mail.ru', '$2y$13$9rlMo8rAiDrRG5.ZLxJq1.D51AsS5jufLSagoiIGJc8vfG.XOYK3i', '', '2026-11-07 12:18:19', 0, 0, 1, '/uploads/avatars/JgZIjWdBQDbKVeMeARXxdw0l222QECzG.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `user_movie`
--

CREATE TABLE `user_movie` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `movie_id` int NOT NULL,
  `rating` int DEFAULT NULL,
  `comment` text,
  `is_favorite` tinyint(1) DEFAULT '0',
  `is_watched` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `user_movie`
--

INSERT INTO `user_movie` (`id`, `user_id`, `movie_id`, `rating`, `comment`, `is_favorite`, `is_watched`, `created_at`) VALUES
(3, 1, 4, 5, '', 1, 1, '2026-11-06 11:23:29'),
(5, 1, 1, 5, '', 0, 0, '2026-11-06 11:51:06'),
(6, 1, 3, NULL, NULL, 1, 0, '2026-11-06 11:51:11'),
(8, 1, 15, 5, '', 0, 0, '2026-11-06 12:23:21'),
(9, 1, 16, 4, '', 0, 0, '2026-11-06 12:23:28'),
(10, 1, 14, 4, '', 0, 0, '2026-11-06 12:23:32'),
(11, 1, 9, NULL, NULL, 0, 1, '2026-11-06 12:23:38'),
(12, 1, 18, 4, '', 0, 0, '2026-11-06 12:29:01'),
(13, 1, 10, 3, '', 0, 0, '2026-11-06 12:58:07'),
(14, 1, 7, 5, '', 0, 0, '2026-11-06 12:58:11'),
(15, 1, 17, 5, '', 0, 0, '2026-11-06 12:58:14'),
(16, 1, 13, NULL, NULL, 1, 1, '2026-11-07 09:13:28'),
(17, 6, 1, NULL, NULL, 0, 0, '2026-11-07 10:13:50'),
(18, 1, 20, NULL, NULL, 0, 0, '2026-11-07 11:15:12'),
(19, 7, 20, NULL, NULL, 1, 1, '2026-11-07 12:18:30'),
(20, 7, 19, NULL, NULL, 1, 0, '2026-11-07 12:18:31'),
(21, 7, 18, 5, 'asd', 0, 0, '2026-11-07 12:18:59'),
(22, 6, 2, 2, '', 0, 0, '2026-11-07 12:21:09');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-movie-genre_id` (`genre_id`);

--
-- Индексы таблицы `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Индексы таблицы `user_movie`
--
ALTER TABLE `user_movie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-user_movie-user_id` (`user_id`),
  ADD KEY `fk-user_movie-movie_id` (`movie_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `movie`
--
ALTER TABLE `movie`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `role`
--
ALTER TABLE `role`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `user_movie`
--
ALTER TABLE `user_movie`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `movie`
--
ALTER TABLE `movie`
  ADD CONSTRAINT `fk-movie-genre_id` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `user_movie`
--
ALTER TABLE `user_movie`
  ADD CONSTRAINT `fk-user_movie-movie_id` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-user_movie-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
