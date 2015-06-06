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
--drop table `asistencia`

CREATE TABLE IF NOT EXISTS `asistencia` (
  `numeroDia` int(11) NOT NULL,
  `letraDia` text NOT NULL,
  `usuarioNombre` text NOT NULL,
  `legajo`  int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `asistencia`
--

INSERT INTO `asistencia` (`numeroDia`, `letraDia`, `usuarioNombre`) VALUES
(2, 'Tuesday','');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comidas`
--

CREATE TABLE IF NOT EXISTS `comidas` (
  `numeroDia` int(11) NOT NULL,
  `letraDia` text NOT NULL,
  `plato` text NOT NULL,
  `guarnicion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `comidas`
--

INSERT INTO `comidas` (`numeroDia`, `letraDia`, `plato`, `guarnicion`) VALUES
(1, 'Lunes', 'Milanesa', 'Ensaladas o Arroz'),
(2, 'Martes', 'Pollo', 'Ensaladas o Arroz'),
(3, 'Miercoles', 'Carne c/papas', 'Ensaladas o Arroz'),
(4, 'Jueves', 'Tartas y Pascualinas', 'Ensaladas o Arroz'),
(5, 'Viernes', 'Pizzas', 'Ensaladas o Arroz'),
(6, 'Sabado', 'Pizzas', 'Ensaladas o Arroz');

/*!40101 SET CHARACTER_SET_CLIEasistenciaasistenciaNT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

CREATE TABLE IF NOT EXISTS `empleados` (
  `UsuarioLargo` text NULL,
  `UsuarioCorto` text NOT NULL

) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `asistencia`
--

INSERT INTO `empleados`(`NOMBRE`, `USUARIOCORTO`, `LEGAJO`) VALUES ('SERGIO','SERGIO',1000);
INSERT INTO `empleados`(`NOMBRE`, `USUARIOCORTO`, `LEGAJO`) VALUES ('CLAUDIO','CLAUDIO',1001);
INSERT INTO `empleados`(`NOMBRE`, `USUARIOCORTO`, `LEGAJO`) VALUES ('MAXI','MAXI',1002);