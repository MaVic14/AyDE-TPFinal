CREATE DATABASE `baseayde` /*!40100 CHARACTER SET latin1 COLLATE latin1_swedish_ci */;

USE `baseayde`;


-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-05-2015 a las 04:41:41
-- Versión del servidor: 5.6.24
-- Versión de PHP: 5.6.8


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `mibasededatos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--
--drop table `ASISTENCIA`

CREATE TABLE IF NOT EXISTS `ASISTENCIA` (
  `NUMERODIA` int(11) NOT NULL,
  `LETRADIA` text NOT NULL,
  `USUARIONOMBRE` text NOT NULL,
  `LEGAJO`  int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `asistencia`
--

INSERT INTO `ASISTENCIA` (`NUMERODIA`, `LETRADIA`, `USUARIONOMBRE`, `LEGAJO`) VALUES
(2, 'Tuesday', 'Sergio', 1000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `COMIDAS`
--

CREATE TABLE IF NOT EXISTS `COMIDAS` (
  `NUMERODIA` int(11) NOT NULL,
  `LETRADIA` text NOT NULL,
  `PLATO` text NOT NULL,
  `GUARNICION` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `COMIDAS`
--

INSERT INTO `COMIDAS` (`NUMERODIA`, `LETRADIA`, `PLATO`, `GUARNICION`) VALUES
(1, 'Lunes', 'Milanesa', 'Ensaladas o Arroz'),
(2, 'Martes', 'Pollo', 'Ensaladas o Arroz'),
(3, 'Miercoles', 'Carne c/papas', 'Ensaladas o Arroz'),
(4, 'Jueves', 'Tartas y Pascualinas', 'Ensaladas o Arroz'),
(5, 'Viernes', 'Pizzas', 'Ensaladas o Arroz')
(6, 'Sabado', 'Pizzas', 'Ensaladas o Arroz');

/*!40101 SET CHARACTER_SET_CLIEasistenciaasistenciaNT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

CREATE TABLE IF NOT EXISTS `EMPLEADOS` (
  `NOMBRE` text NULL,
  `USUARIOCORTO` text NOT NULL,
  `LEGAJO`  int(11) NOT NULL

) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `EMPLEADOS`
--

INSERT INTO `EMPLEADOS` (`NOMBRE`, `USUARIOCORTO`, `LEGAJO`) VALUES ('SERGIO', 'SERGIO', 1000);