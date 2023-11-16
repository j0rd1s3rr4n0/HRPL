-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 16-11-2023 a las 09:35:35
-- Versión del servidor: 10.11.2-MariaDB
-- Versión de PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `GEOLOCATE`
--
CREATE DATABASE IF NOT EXISTS `GEOLOCATE` DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
USE `GEOLOCATE`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `identificadores`
--

DROP TABLE IF EXISTS `identificadores`;
CREATE TABLE IF NOT EXISTS `identificadores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identificador` varchar(255) NOT NULL,
  `texto` text NOT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicaciones`
--

DROP TABLE IF EXISTS `ubicaciones`;
CREATE TABLE IF NOT EXISTS `ubicaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `latitud` double DEFAULT NULL,
  `longitud` double DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  `identificator` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=533 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `timestamp_last_login` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`, `timestamp_last_login`) VALUES
(1, 'PARTHENOUN', 'PARTHENOUN', NULL),
(2, 'MIVE', 'CONTRASEÑASEGURA', NULL),
(3, 'AARON', 'AARON', NULL),
(5, 'DANIIEELGS', 'CONTRASEÑASEGURA', NULL);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `identificadores`
--
ALTER TABLE `identificadores`
  ADD CONSTRAINT `identificadores_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
