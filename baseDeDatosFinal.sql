# --------------------------------------------------------
# Host:                         127.0.0.1
# Server version:               5.6.24
# Server OS:                    Win32
# HeidiSQL version:             6.0.0.3700
# Date/time:                    2015-07-07 00:35:02
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
  `HORARIOASISTENCIA` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `InvitaExternos` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# Dumping data for table baseayde.asistencia: ~0 rows (approximately)
/*!40000 ALTER TABLE `asistencia` DISABLE KEYS */;
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
	(4, 'Jueves', 'Tartas', ''),
	(1, 'Lunes', 'Milanesa', 'Ensaladas o Arroz'),
	(2, 'Martes', 'Pastas', 'Ensaladas o Arroz'),
	(3, 'Miercoles', 'Pollo', 'Ensaladas o Arroz'),
	(5, 'Viernes', 'Pizzas', ''),
	(6, 'Sabado', 'Empanadas', '');
/*!40000 ALTER TABLE `comidas` ENABLE KEYS */;


# Dumping structure for table baseayde.empleados
CREATE TABLE IF NOT EXISTS `empleados` (
  `NOMBRE` text,
  `LEGAJO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# Dumping data for table baseayde.empleados: ~7 rows (approximately)
/*!40000 ALTER TABLE `empleados` DISABLE KEYS */;
INSERT INTO `empleados` (`NOMBRE`, `LEGAJO`) VALUES
	('SERGIO', 1000),
	('Gabriel', 1001),
	('Fernando', 1002),
	('Maria Victoria', 1003),
	('Emiliano', 1004),
	('Alejandro', 1005),
	('Maximiliano', 1006);
/*!40000 ALTER TABLE `empleados` ENABLE KEYS */;


# Dumping structure for table baseayde.parametros
CREATE TABLE IF NOT EXISTS `parametros` (
  `horarioalmuerzo` varchar(50) DEFAULT NULL,
  `horaLimite` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# Dumping data for table baseayde.parametros: ~1 rows (approximately)
/*!40000 ALTER TABLE `parametros` DISABLE KEYS */;
INSERT INTO `parametros` (`horarioalmuerzo`, `horaLimite`) VALUES
	('13:00hs', '11:00:00');
/*!40000 ALTER TABLE `parametros` ENABLE KEYS */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
