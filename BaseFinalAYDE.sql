# --------------------------------------------------------
# Host:                         127.0.0.1
# Server version:               5.6.24
# Server OS:                    Win32
# HeidiSQL version:             6.0.0.3700
# Date/time:                    2015-06-11 23:02:33
# --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

# Dumping database structure for baseayde
CREATE DATABASE IF NOT EXISTS `baseayde` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `baseayde`;


# Dumping structure for table baseayde.asistencia
CREATE TABLE IF NOT EXISTS `asistencia` (
  `NUMERODIA` int(11) NOT NULL,
  `LETRADIA` text NOT NULL,
  `USUARIONOMBRE` text NOT NULL,
  `LEGAJO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# Dumping data for table baseayde.asistencia: ~0 rows (approximately)
/*!40000 ALTER TABLE `asistencia` DISABLE KEYS */;
INSERT INTO `asistencia` (`NUMERODIA`, `LETRADIA`, `USUARIONOMBRE`, `LEGAJO`) VALUES
	(2, 'Tuesday', 'Sergio', 1000);
/*!40000 ALTER TABLE `asistencia` ENABLE KEYS */;


# Dumping structure for table baseayde.comidas
CREATE TABLE IF NOT EXISTS `comidas` (
  `NUMERODIA` int(11) NOT NULL,
  `LETRADIA` text NOT NULL,
  `PLATO` text NOT NULL,
  `GUARNICION` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# Dumping data for table baseayde.comidas: ~6 rows (approximately)
/*!40000 ALTER TABLE `comidas` DISABLE KEYS */;
INSERT INTO `comidas` (`NUMERODIA`, `LETRADIA`, `PLATO`, `GUARNICION`) VALUES
	(1, 'Lunes', 'Milanesa', 'Ensaladas o Arroz'),
	(2, 'Martes', 'Pollo', 'Ensaladas o Arroz'),
	(3, 'Miercoles', 'Carne c/papas', 'Ensaladas o Arroz'),
	(4, 'Jueves', 'Tartas y Pascualinas', 'Ensaladas o Arroz'),
	(5, 'Viernes', 'Pizzas', 'Ensaladas o Arroz'),
	(6, 'Sabado', 'Pizzas', 'Ensaladas o Arroz');
/*!40000 ALTER TABLE `comidas` ENABLE KEYS */;


# Dumping structure for table baseayde.empleados
CREATE TABLE IF NOT EXISTS `empleados` (
  `NOMBRE` text,
  `USUARIOCORTO` text NOT NULL,
  `LEGAJO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# Dumping data for table baseayde.empleados: ~0 rows (approximately)
/*!40000 ALTER TABLE `empleados` DISABLE KEYS */;
INSERT INTO `empleados` (`NOMBRE`, `USUARIOCORTO`, `LEGAJO`) VALUES
	('SERGIO', 'SERGIO', 1000);
/*!40000 ALTER TABLE `empleados` ENABLE KEYS */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
