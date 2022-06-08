-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hostiteľ: 127.0.0.1
-- Čas generovania: St 08.Jún 2022, 19:36
-- Verzia serveru: 10.4.22-MariaDB
-- Verzia PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáza: `hotel`
--

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `room_id` int(11) NOT NULL,
  `number_of_people` int(11) NOT NULL,
  `from` date NOT NULL,
  `to` date NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Sťahujem dáta pre tabuľku `order`
--

INSERT INTO `order` (`id`, `user_id`, `room_id`, `number_of_people`, `from`, `to`, `price`) VALUES
(2, 1, 3, 3, '2022-06-13', '2022-06-20', '322.00'),
(3, 4, 2, 3, '2022-06-13', '2022-06-27', '630.00'),
(4, 6, 8, 6, '2022-06-02', '2022-06-03', '78.00'),
(5, 3, 6, 5, '2022-06-22', '2022-06-29', '413.00'),
(6, 8, 8, 4, '2022-06-21', '2022-06-28', '546.00'),
(7, 9, 8, 4, '2022-06-18', '2022-06-29', '858.00'),
(9, 2, 5, 4, '2022-06-26', '2022-06-29', '177.00');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `photo`
--

CREATE TABLE `photo` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Sťahujem dáta pre tabuľku `photo`
--

INSERT INTO `photo` (`id`, `room_id`, `path`) VALUES
(1, 1, 'obrazky/ob1.jpg'),
(2, 2, 'obrazky/ob2.jpg'),
(3, 3, 'obrazky/ob3.jpg'),
(4, 4, 'obrazky/ob4.jpg'),
(5, 5, 'obrazky/ob5.jpg'),
(6, 6, 'obrazky/ob6.jpg'),
(7, 7, 'obrazky/ob7.jpg'),
(8, 8, 'obrazky/ob8.jpg'),
(9, 9, 'obrazky/ob9.jpg'),
(11, 1, 'obrazky/ob11.jpg'),
(12, 1, 'obrazky/ob12.jpg'),
(13, 2, 'obrazky/ob13.jpg'),
(14, 2, 'obrazky/ob14.jpg'),
(15, 4, 'obrazky/ob15.jpg'),
(16, 4, 'obrazky/ob16.jpg'),
(17, 4, 'obrazky/ob17.jpg'),
(18, 3, 'obrazky/ob18.jpg'),
(19, 3, 'obrazky/ob19.jpg'),
(20, 3, 'obrazky/ob20.jpg'),
(21, 7, 'obrazky/ob21.jpg'),
(22, 7, 'obrazky/ob22.jpg'),
(23, 7, 'obrazky/ob23.jpg'),
(24, 6, 'obrazky/ob24.jpg'),
(25, 6, 'obrazky/ob25.jpg'),
(26, 6, 'obrazky/ob26.jpg'),
(27, 5, 'obrazky/ob27.jpg'),
(28, 5, 'obrazky/ob28.jpg'),
(29, 5, 'obrazky/ob29.jpg'),
(30, 9, 'obrazky/ob30.jpg'),
(31, 9, 'obrazky/ob31.jpg'),
(32, 9, 'obrazky/ob32.jpg');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `room`
--

CREATE TABLE `room` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `number_of_beds` int(11) NOT NULL,
  `extra_bed` int(11) NOT NULL,
  `balcony` tinyint(1) NOT NULL,
  `wifi` tinyint(1) NOT NULL,
  `bathroom` tinyint(1) NOT NULL,
  `kitchen` tinyint(1) NOT NULL,
  `price_for_night` decimal(20,2) NOT NULL,
  `main_photo_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Sťahujem dáta pre tabuľku `room`
--

INSERT INTO `room` (`id`, `name`, `number_of_beds`, `extra_bed`, `balcony`, `wifi`, `bathroom`, `kitchen`, `price_for_night`, `main_photo_id`) VALUES
(1, 'Apartmán A1', 2, 2, 1, 1, 1, 1, '46.00', 1),
(2, 'Apartmán A2', 2, 2, 0, 1, 1, 0, '45.00', 2),
(3, 'Apartmán B1', 2, 1, 1, 1, 1, 0, '46.00', 3),
(4, 'Apartmán B2', 3, 1, 1, 1, 1, 1, '66.00', 4),
(5, 'Apartmán B3', 3, 2, 0, 1, 1, 0, '59.00', 5),
(6, 'Apartmán C1', 4, 1, 1, 1, 1, 0, '59.00', 6),
(7, 'Apartmán C2', 2, 1, 1, 1, 1, 1, '46.00', 7),
(8, 'Apartmán C3', 4, 2, 1, 1, 1, 1, '78.00', 8),
(9, 'Apartmán D1', 4, 1, 0, 1, 1, 1, '75.00', 9);

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(65) NOT NULL,
  `password` varchar(65) NOT NULL,
  `role` varchar(5) NOT NULL,
  `name` varchar(65) DEFAULT NULL,
  `last_name` varchar(65) DEFAULT NULL,
  `street` varchar(65) DEFAULT NULL,
  `house_number` int(11) DEFAULT NULL,
  `city` varchar(65) DEFAULT NULL,
  `post_code` varchar(5) DEFAULT NULL,
  `mobile` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Sťahujem dáta pre tabuľku `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `role`, `name`, `last_name`, `street`, `house_number`, `city`, `post_code`, `mobile`) VALUES
(1, 'liliana@liliana.sk', '$2y$10$j3DDy90bL/WmrMmY9eyp1e/sY9DvwenJ3Jgfb40P.72zbsibbFSy.', 'admin', '', '', '', 0, '', '0', ''),
(2, 'lahuckae@centrum.sk', '$2y$10$zUmcvTKLuPDvq43MBCyr.u0c/pzZagxcFBmXolMwxXLAbFZW0Hz3C', 'user', 'Eva', 'Lahučká', 'Pod lipou', 32, 'Nitra', '94901', '00421904343888'),
(3, 'kukino@gmail.com', '$2y$10$IBu4RAvs7.ZxX.KclAH.w.d5tP9c/9PxnUouXBBBFXYguPxQkTECy', 'user', 'Kuk ino', 'Kuki', 'Narcisova', 10, 'Pod Vahom', '96701', '00421555555555'),
(4, 'figa11@gmail.com', '$2y$10$vZqpDEQuZsEtSFefv39gZepIYNWmhX/EvQUGrtTcZA5iyarmQ1SoW', 'user', 'Figa', 'Figova', 'Pod dubom', 1, 'Figovnik', '56701', '00421999111999'),
(5, 'paprika@azet.sk', '$2y$10$BPnX13Hds60LT1cS.UXt9uJ8HpQueWft2GWSbzFWIAU50742EkVGi', 'user', 'Paprika', 'Paradajkova', 'Tulipanova', 32, 'Narcis', '44444', '00421777000777'),
(6, 'diamant@gmail.com', '$2y$10$Ck6rfO8E4CVMbSMLXiK1o.I.Lk/jL0hfIpAgs2SU77EL2CuTfc.6.', 'user', 'Diamant', 'Zlaty', 'Priesvitna', 8, 'Labyrint', '00000', '00421000000000'),
(7, 'kozicka@azet.sk', '$2y$10$4d8W2fXNtFxDDIoQ4/Z5HuDNQOYYPaMZOwrUDRrYEe92xljIl.rHu', 'user', 'Kozicka', 'Biela', 'Stajna', 9, 'Lehota', '76101', '00421345678901'),
(8, 'andrej.t@gmail.com', '$2y$10$XH3G0cn/OI2M3NwbZp5yvORLktDvirLHfHbDeiZdSz3XNtwsmGpJe', 'user', 'Andrej', 'Tomak', '1. maja', 45, 'Bratislava', '85501', '00421903756484'),
(9, 'monika@centrum.sk', '$2y$10$PLZTGFsv3oDhKtcklyEGg.92l56xxOWm/dfa4SDHeqm.b.xvaxQBi', 'user', 'Monika', 'Vlasata', 'Vrbova', 6, 'Martin', '94011', '00421676767676'),
(10, 'stolicka@stolicka.sk', '$2y$10$mMu971U1/aX6Sz32.c1m0OwdQSznxZ63l.V1Df6pyZUx.f/zwfngm', 'user', 'Stolicka', 'Stol', 'Drevna', 2, 'Kosice', '00000', '00421333333333');

--
-- Kľúče pre exportované tabuľky
--

--
-- Indexy pre tabuľku `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `order_ibfk_2` (`user_id`);

--
-- Indexy pre tabuľku `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `photo_ibfk_1` (`room_id`);

--
-- Indexy pre tabuľku `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id`),
  ADD KEY `main_photo_id` (`main_photo_id`);

--
-- Indexy pre tabuľku `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pre exportované tabuľky
--

--
-- AUTO_INCREMENT pre tabuľku `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pre tabuľku `photo`
--
ALTER TABLE `photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pre tabuľku `room`
--
ALTER TABLE `room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT pre tabuľku `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Obmedzenie pre exportované tabuľky
--

--
-- Obmedzenie pre tabuľku `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `room` (`id`),
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Obmedzenie pre tabuľku `photo`
--
ALTER TABLE `photo`
  ADD CONSTRAINT `photo_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `room` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Obmedzenie pre tabuľku `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `room_ibfk_1` FOREIGN KEY (`main_photo_id`) REFERENCES `photo` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
