-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-03-2025 a las 08:36:14
-- Versión del servidor: 10.1.30-MariaDB
-- Versión de PHP: 5.6.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `biblioteca`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `NIA` varchar(8) NOT NULL,
  `Nombre` varchar(20) NOT NULL,
  `Ape1` varchar(20) NOT NULL,
  `Ape2` varchar(20) NOT NULL,
  `Curso` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`NIA`, `Nombre`, `Ape1`, `Ape2`, `Curso`) VALUES
('1111', 'Alberto', 'Ruiz', 'Martinez', '3ESO'),
('2222', 'Marta', 'Lopez', 'Gil', '2BAC'),
('3333', 'Luis', 'Martin', 'Gomez', '1BAC');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `ISBN` varchar(10) NOT NULL,
  `Titulo` varchar(30) NOT NULL,
  `Autor` varchar(30) NOT NULL,
  `imagen` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`ISBN`, `Titulo`, `Autor`, `imagen`) VALUES
('1234', 'El Quijote', 'Miguel de Cervantes', 'quijote.jpg'),
('5678', 'La Regenta', 'Leopoldo Alas', 'regenta.jpg'),
('8901', 'El Lazarillo de Tormes', 'Anónimo', 'lazarillo.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva`
--

CREATE TABLE `reserva` (
  `cod_alumno` varchar(8) NOT NULL,
  `cod_libro` varchar(10) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `reserva`
--

INSERT INTO `reserva` (`cod_alumno`, `cod_libro`, `fecha`) VALUES
('1111', '1234', '2025-03-19');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`NIA`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`ISBN`);

--
-- Indices de la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD UNIQUE KEY `cod_alumno` (`cod_alumno`),
  ADD KEY `cod_libro` (`cod_libro`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `reserva_ibfk_1` FOREIGN KEY (`cod_alumno`) REFERENCES `alumnos` (`NIA`),
  ADD CONSTRAINT `reserva_ibfk_2` FOREIGN KEY (`cod_libro`) REFERENCES `libros` (`ISBN`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
