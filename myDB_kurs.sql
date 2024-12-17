-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 17 2024 г., 09:20
-- Версия сервера: 5.7.39
-- Версия PHP: 7.2.34
CREATE DATABASE IF NOT EXISTS myDB_kurs;

USE myDB_kurs;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `myDB_kurs`
--

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('male','female','unisex') COLLATE utf8mb4_unicode_ci DEFAULT 'unisex',
  `age_group` enum('child','adult') COLLATE utf8mb4_unicode_ci DEFAULT 'adult',
  `gears` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `brand`, `type`, `gender`, `age_group`, `gears`, `price`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Giant Talon 3', 'Giant', 'горный', 'unisex', 'adult', 21, '599.99', 'Горный велосипед для любителей приключений.', '2024-12-15 16:05:50', '2024-12-15 16:05:50'),
(2, 'Trek Marlin 7', 'Trek', 'горный', 'male', 'adult', 27, '899.99', 'Высококлассный горный велосипед для профессионалов.', '2024-12-15 16:05:50', '2024-12-15 16:05:50'),
(3, 'Specialized Riprock 20', 'Specialized', 'горный', 'unisex', 'child', 7, '399.99', 'Детский велосипед с надежной конструкцией и отличным сцеплением.', '2024-12-15 16:05:50', '2024-12-15 16:05:50'),
(4, 'Cannondale Quick 4', 'Cannondale', 'городской', 'female', 'adult', 18, '749.99', 'Городской велосипед с современным дизайном и легкой рамой.', '2024-12-15 16:05:50', '2024-12-15 16:05:50'),
(5, 'Scott Contessa 740', 'Scott', 'горный', 'female', 'adult', 24, '699.99', 'Горный велосипед для женщин, сочетающий комфорт и проходимость.', '2024-12-15 16:05:50', '2024-12-15 16:05:50');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('user','admin') COLLATE utf8mb4_unicode_ci DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`, `email`) VALUES
(1, 'user123', '$2y$10$64oO3YcvpvjrekIPJRxcJeMbm/uyQyHDMJuZbb79XsR0MAr6TcMV2', 'user', '2024-11-12 10:24:50', 'user123@mail.ru'),
(2, 'admin', '$2y$10$64oO3YcvpvjrekIPJRxcJeMbm/uyQyHDMJuZbb79XsR0MAr6TcMV2', 'admin', '2024-11-12 10:25:26', 'admin@mail.ru'),
(3, 'test', '$2y$10$vWz4.mPLCsFZF/bqq95n2uqWnVraqmKLKhlDWnyHzDQGAf.gugQ3e', 'user', '2024-11-12 13:08:35', 'test@mail.ru'),
(4, 'test1', '$2y$10$3neGRaP81psyCeEj0IEKmen2lLJ104Oodq3mo3K49rRjYYHBxSR4m', 'user', '2024-11-12 13:09:38', 'test1@mail.ru');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
