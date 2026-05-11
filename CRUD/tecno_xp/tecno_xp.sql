-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-05-2026
-- Versión del servidor: 10.1.30-MariaDB
-- Versión de PHP: 7.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tecno_xp`
--

DROP DATABASE IF EXISTS `tecno_xp`;
CREATE DATABASE `tecno_xp` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `tecno_xp`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` varchar(12) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `ape1` varchar(40) NOT NULL,
  `ape2` varchar(40) DEFAULT NULL,
  `grupo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `ape1`, `ape2`, `grupo`) VALUES
('1111A', 'Alberto', 'Ruiz', 'Martinez', '2BAC'),
('2222B', 'Marta', 'Lopez', 'Gil', '1SMR'),
('3333C', 'Luis', 'Martin', 'Gomez', '2SMR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dispositivos`
--

CREATE TABLE `dispositivos` (
  `cod_dispositivo` varchar(20) NOT NULL,
  `nombre_dispositivo` varchar(60) NOT NULL,
  `tipo` varchar(40) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `dispositivos`
--

INSERT INTO `dispositivos` (`cod_dispositivo`, `nombre_dispositivo`, `tipo`, `estado`) VALUES
('PORT-01', 'Portátil Lenovo ThinkPad', 'Portátil', 'disponible'),
('TAB-02', 'Tablet Samsung Galaxy', 'Tablet', 'disponible'),
('CAM-03', 'Cámara Canon EOS', 'Cámara', 'disponible');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `cod_usuario` varchar(12) NOT NULL,
  `cod_dispositivo` varchar(20) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`cod_usuario`, `cod_dispositivo`, `fecha_inicio`, `fecha_fin`) VALUES
('1111A', 'PORT-01', '2026-05-08', '2026-05-15');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `dispositivos`
--
ALTER TABLE `dispositivos`
  ADD PRIMARY KEY (`cod_dispositivo`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`cod_usuario`, `cod_dispositivo`, `fecha_inicio`),
  ADD KEY `idx_reserva_dispositivo` (`cod_dispositivo`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `fk_reserva_dispositivo` FOREIGN KEY (`cod_dispositivo`) REFERENCES `dispositivos` (`cod_dispositivo`),
  ADD CONSTRAINT `fk_reserva_usuario` FOREIGN KEY (`cod_usuario`) REFERENCES `usuarios` (`id_usuario`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
