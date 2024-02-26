-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3307
-- Время создания: Ноя 29 2023 г., 16:24
-- Версия сервера: 10.4.28-MariaDB
-- Версия PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `carcenter`
--

-- --------------------------------------------------------

--
-- Структура таблицы `automobil`
--

CREATE TABLE `automobil` (
  `CodAutomobil` int(11) NOT NULL,
  `Model` varchar(40) NOT NULL,
  `Marca` varchar(40) NOT NULL,
  `Pret` int(11) NOT NULL,
  `NrUsi` int(11) NOT NULL,
  `CodProducator` int(11) NOT NULL,
  `PhotoAuto` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `automobil`
--

INSERT INTO `automobil` (`CodAutomobil`, `Model`, `Marca`, `Pret`, `NrUsi`, `CodProducator`, `PhotoAuto`) VALUES
(131, 'Camry', 'Toyota', 25000, 4, 1, 'camry.jpeg'),
(132, 'F-150', 'Ford', 35000, 2, 2, 'FordF-150.jpg'),
(133, 'Golf', 'Volkswagen', 20000, 4, 3, 'golfF.jpg'),
(134, 'Civic', 'Honda', 22000, 2, 4, 'hondacivic.jpg'),
(135, 'X5', 'BMW', 50000, 4, 5, 'bmwx5.jpg'),
(136, 'Silverado', 'Chevrolet', 30000, 2, 6, 'chevrole.jpg'),
(137, 'Altima', 'Nissan', 23000, 4, 7, 'nissan.jpg'),
(138, 'Elantra', 'Hyundai', 18000, 2, 8, 'hyunday.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `producator`
--

CREATE TABLE `producator` (
  `CodProducator` int(11) NOT NULL,
  `Denumire` varchar(40) NOT NULL,
  `Tara` varchar(40) NOT NULL,
  `WebAdresa` varchar(50) NOT NULL,
  `PhotoPr` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `producator`
--

INSERT INTO `producator` (`CodProducator`, `Denumire`, `Tara`, `WebAdresa`, `PhotoPr`) VALUES
(1, 'Toyota', 'Japan', 'https://www.toyota.com', 'Toyota.jpg'),
(2, 'Volkswagen', 'Germany', 'https://www.vw.com', 'Volkswagen.jpg'),
(3, 'Honda', 'Japan', 'https://www.honda.com', 'honda1.jpg'),
(4, 'BMW', 'Germany', 'https://www.bmw.com', 'bmw.jpg'),
(5, 'Chevrolet', 'USA', 'https://www.chevrolet.com', 'chevrolet.jpg'),
(6, 'Nissan', 'Japan', 'https://www.nissanusa.com', 'Nissan.png'),
(7, 'Hyundai', 'South Korea', 'https://www.hyundai.com', 'Hyundai.jpg'),
(8, 'Ford', 'USA', 'https://www.ford.com', 'ford.jpg');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `automobil`
--
ALTER TABLE `automobil`
  ADD PRIMARY KEY (`CodAutomobil`),
  ADD KEY `CodProducător` (`CodProducator`);

--
-- Индексы таблицы `producator`
--
ALTER TABLE `producator`
  ADD PRIMARY KEY (`CodProducator`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `automobil`
--
ALTER TABLE `automobil`
  MODIFY `CodAutomobil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT для таблицы `producator`
--
ALTER TABLE `producator`
  MODIFY `CodProducator` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `automobil`
--
ALTER TABLE `automobil`
  ADD CONSTRAINT `automobil_ibfk_1` FOREIGN KEY (`CodProducator`) REFERENCES `producator` (`CodProducator`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
