-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-11-2018 a las 18:25:54
-- Versión del servidor: 5.6.17
-- Versión de PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `tp_final`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `artists`
--

CREATE TABLE IF NOT EXISTS `artists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `artisticName` varchar(30) NOT NULL,
  `picture` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `artists`
--

INSERT INTO `artists` (`id`, `name`, `lastName`, `artisticName`, `picture`) VALUES
(1, 'Shakira Isabel', 'Mebarak Ripoll', 'Shakira', '/tpfinal/images/artists/shakira.jpg'),
(2, 'Luis', 'Miguel', 'Luis Miguel', '/tpfinal/images/artists/luis miguel (2).jpg'),
(3, 'Armin Jozef Jacobus', 'DaniÃ«l van Buuren', 'Armin van buuren', '/tpfinal/images/artists/hp_news_1515582976.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `artistsxcalendars`
--

CREATE TABLE IF NOT EXISTS `artistsxcalendars` (
  `idArtist` int(11) NOT NULL,
  `idCalendar` int(11) NOT NULL,
  PRIMARY KEY (`idArtist`,`idCalendar`),
  KEY `idCalendar` (`idCalendar`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `artistsxcalendars`
--

INSERT INTO `artistsxcalendars` (`idArtist`, `idCalendar`) VALUES
(1, 1),
(1, 2),
(2, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendars`
--

CREATE TABLE IF NOT EXISTS `calendars` (
  `idCalendar` int(11) NOT NULL AUTO_INCREMENT,
  `dateCalendar` date NOT NULL,
  `idEvent` int(11) NOT NULL,
  `idPlace` int(11) NOT NULL,
  PRIMARY KEY (`idCalendar`),
  UNIQUE KEY `idCalendar` (`idCalendar`),
  KEY `idEvent` (`idEvent`),
  KEY `idPlace` (`idPlace`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `calendars`
--

INSERT INTO `calendars` (`idCalendar`, `dateCalendar`, `idEvent`, `idPlace`) VALUES
(1, '2018-11-25', 1, 1),
(2, '2018-11-27', 1, 2),
(3, '2019-02-07', 2, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `description` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(1, 'pop', 'pop');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `categoryId` int(11) NOT NULL DEFAULT '0',
  `picture` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `categoryId` (`categoryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `events`
--

INSERT INTO `events` (`id`, `name`, `categoryId`, `picture`) VALUES
(1, 'Shakira Tour', 1, '/tpfinal/images/events/Shakira_660X380-fd9d067885.jpg'),
(2, 'Luis Miguel The Hits Tour', 1, '/tpfinal/images/events/luis-miguel-pachuca.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventseats`
--

CREATE TABLE IF NOT EXISTS `eventseats` (
  `idEventSeat` int(11) NOT NULL AUTO_INCREMENT,
  `price` decimal(15,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `remains` int(11) NOT NULL,
  `idCalendar` int(11) NOT NULL,
  `idSeatType` int(11) NOT NULL,
  PRIMARY KEY (`idEventSeat`),
  UNIQUE KEY `idEventSeat` (`idEventSeat`),
  KEY `idCalendar` (`idCalendar`),
  KEY `idSeatType` (`idSeatType`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `eventseats`
--

INSERT INTO `eventseats` (`idEventSeat`, `price`, `quantity`, `remains`, `idCalendar`, `idSeatType`) VALUES
(1, '1000.00', 500, 500, 1, 1),
(2, '500.00', 700, 698, 2, 1),
(3, '550.00', 1000, 999, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `placeevents`
--

CREATE TABLE IF NOT EXISTS `placeevents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `capacity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `placeevents`
--

INSERT INTO `placeevents` (`id`, `name`, `capacity`) VALUES
(1, 'Estadio Velez', 49540),
(2, 'Estadio Rosario Central', 48900),
(3, 'Estadio Hidalgo', 27512);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `purchaserows`
--

CREATE TABLE IF NOT EXISTS `purchaserows` (
  `idPurchaseRow` int(11) NOT NULL AUTO_INCREMENT,
  `idPurchase` int(11) NOT NULL,
  `idEventSeat` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  PRIMARY KEY (`idPurchaseRow`),
  UNIQUE KEY `idPurchaseRow` (`idPurchaseRow`),
  KEY `idPurchase` (`idPurchase`),
  KEY `idEventSeat` (`idEventSeat`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `purchaserows`
--

INSERT INTO `purchaserows` (`idPurchaseRow`, `idPurchase`, `idEventSeat`, `quantity`, `price`) VALUES
(1, 1, 2, 2, '500.00'),
(2, 2, 3, 1, '550.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `purchases`
--

CREATE TABLE IF NOT EXISTS `purchases` (
  `idPurchase` int(11) NOT NULL AUTO_INCREMENT,
  `datePurchase` date NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`idPurchase`),
  UNIQUE KEY `idPurchase` (`idPurchase`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `purchases`
--

INSERT INTO `purchases` (`idPurchase`, `datePurchase`, `idUser`) VALUES
(1, '2018-11-21', 3),
(2, '2018-11-21', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE IF NOT EXISTS `rol` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seattypes`
--

CREATE TABLE IF NOT EXISTS `seattypes` (
  `idSeatType` int(11) NOT NULL AUTO_INCREMENT,
  `typeName` varchar(30) NOT NULL,
  PRIMARY KEY (`idSeatType`),
  UNIQUE KEY `idSeatType` (`idSeatType`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `seattypes`
--

INSERT INTO `seattypes` (`idSeatType`, `typeName`) VALUES
(1, 'poolman');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `rolId` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `rolId` (`rolId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `lastname`, `email`, `password`, `rolId`) VALUES
(1, 'agustin', 'caceres', 'agustincaceres96@hotmail.com', '123', 1),
(2, 'nicolas', 'rimoldi', 'rimoldinicolas@gmail.com', '123', 2),
(3, 'roberto', 'carlos', 'robert@hotmail.com', '123', 2),
(4, 'cliente', 'cliente', 'cliente@hotmail.com', '1', 2);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `artistsxcalendars`
--
ALTER TABLE `artistsxcalendars`
  ADD CONSTRAINT `artistsxcalendars_ibfk_1` FOREIGN KEY (`idArtist`) REFERENCES `artists` (`id`),
  ADD CONSTRAINT `artistsxcalendars_ibfk_2` FOREIGN KEY (`idCalendar`) REFERENCES `calendars` (`idCalendar`) ON DELETE CASCADE;

--
-- Filtros para la tabla `calendars`
--
ALTER TABLE `calendars`
  ADD CONSTRAINT `calendars_ibfk_1` FOREIGN KEY (`idEvent`) REFERENCES `events` (`id`),
  ADD CONSTRAINT `calendars_ibfk_2` FOREIGN KEY (`idPlace`) REFERENCES `placeevents` (`id`);

--
-- Filtros para la tabla `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`id`);

--
-- Filtros para la tabla `eventseats`
--
ALTER TABLE `eventseats`
  ADD CONSTRAINT `eventseats_ibfk_1` FOREIGN KEY (`idCalendar`) REFERENCES `calendars` (`idCalendar`),
  ADD CONSTRAINT `eventseats_ibfk_2` FOREIGN KEY (`idSeatType`) REFERENCES `seattypes` (`idSeatType`);

--
-- Filtros para la tabla `purchaserows`
--
ALTER TABLE `purchaserows`
  ADD CONSTRAINT `purchaserows_ibfk_1` FOREIGN KEY (`idPurchase`) REFERENCES `purchases` (`idPurchase`),
  ADD CONSTRAINT `purchaserows_ibfk_2` FOREIGN KEY (`idEventSeat`) REFERENCES `eventseats` (`idEventSeat`);

--
-- Filtros para la tabla `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`rolId`) REFERENCES `rol` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
