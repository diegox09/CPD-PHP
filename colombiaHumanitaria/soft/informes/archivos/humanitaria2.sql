-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 17-11-2011 a las 00:02:13
-- Versión del servidor: 5.5.16
-- Versión de PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `humanitaria2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arrendador`
--

CREATE TABLE IF NOT EXISTS `arrendador` (
  `id_arrendador` double NOT NULL AUTO_INCREMENT,
  `nombre_arrendador` varchar(60) NOT NULL,
  `documento_arrendador` double NOT NULL,
  `direccion_arrendador` varchar(100) NOT NULL,
  `telefono_arrendador` varchar(30) NOT NULL,
  `fecha` datetime NOT NULL,
  `id_usuario` int(2) NOT NULL,
  PRIMARY KEY (`id_arrendador`),
  UNIQUE KEY `documento_arrendador` (`documento_arrendador`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `arrendador`
--

INSERT INTO `arrendador` (`id_arrendador`, `nombre_arrendador`, `documento_arrendador`, `direccion_arrendador`, `telefono_arrendador`, `fecha`, `id_usuario`) VALUES
(1, '', 123456, '', 'Juan Martinez', '2011-11-16 17:52:44', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arriendo_damnificado`
--

CREATE TABLE IF NOT EXISTS `arriendo_damnificado` (
  `id_damnificado` double NOT NULL,
  `id_arrendador` double NOT NULL,
  `fecha_arriendo` date NOT NULL,
  `comprobante` double DEFAULT NULL,
  `id_periodo` int(2) NOT NULL,
  `observaciones` varchar(250) NOT NULL,
  `fecha` datetime NOT NULL,
  `id_usuario` int(2) NOT NULL,
  `id_estado` int(2) NOT NULL,
  PRIMARY KEY (`id_damnificado`,`id_periodo`),
  UNIQUE KEY `numero_comprobante` (`comprobante`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `arriendo_damnificado`
--

INSERT INTO `arriendo_damnificado` (`id_damnificado`, `id_arrendador`, `fecha_arriendo`, `comprobante`, `id_periodo`, `observaciones`, `fecha`, `id_usuario`, `id_estado`) VALUES
(1, 1, '2011-11-11', 12, 3, 'ok', '2011-11-16 17:52:44', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `damnificado`
--

CREATE TABLE IF NOT EXISTS `damnificado` (
  `id_damnificado` double NOT NULL AUTO_INCREMENT,
  `primer_nombre` varchar(30) NOT NULL,
  `segundo_nombre` varchar(30) NOT NULL,
  `primer_apellido` varchar(30) NOT NULL,
  `segundo_apellido` varchar(30) NOT NULL,
  `genero` int(1) NOT NULL,
  `td` int(1) NOT NULL,
  `documento_damnificado` double NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `barrio` varchar(50) NOT NULL,
  `telefono` varchar(30) NOT NULL,
  `observaciones` varchar(250) NOT NULL,
  `fecha` datetime NOT NULL,
  `id_usuario` int(2) NOT NULL,
  PRIMARY KEY (`id_damnificado`),
  UNIQUE KEY `documento_damnificado` (`documento_damnificado`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `damnificado`
--

INSERT INTO `damnificado` (`id_damnificado`, `primer_nombre`, `segundo_nombre`, `primer_apellido`, `segundo_apellido`, `genero`, `td`, `documento_damnificado`, `direccion`, `barrio`, `telefono`, `observaciones`, `fecha`, `id_usuario`) VALUES
(1, 'Diego', 'Fernando', 'Rodriguez', 'Rincon', 1, 1, 1090370821, 'Calle 0 # 0-25', 'CUNDINAMARCA', '5722222', 'se llamo al cliente', '2011-11-16 17:52:44', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entregas_damnificado`
--

CREATE TABLE IF NOT EXISTS `entregas_damnificado` (
  `id_damnificado` double NOT NULL,
  `fecha_kit_aseo` date NOT NULL,
  `fecha_mercado1` date NOT NULL,
  `fecha_mercado2` date NOT NULL,
  `fecha_mercado3` date NOT NULL,
  `fecha_mercado4` date NOT NULL,
  `ficho` double DEFAULT NULL,
  `id_periodo` int(2) NOT NULL,
  `observaciones` varchar(250) NOT NULL,
  `fecha` datetime NOT NULL,
  `id_usuario` int(2) NOT NULL,
  `id_estado` int(1) NOT NULL,
  PRIMARY KEY (`id_damnificado`,`id_periodo`),
  UNIQUE KEY `ficho` (`ficho`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `entregas_damnificado`
--

INSERT INTO `entregas_damnificado` (`id_damnificado`, `fecha_kit_aseo`, `fecha_mercado1`, `fecha_mercado2`, `fecha_mercado3`, `fecha_mercado4`, `ficho`, `id_periodo`, `observaciones`, `fecha`, `id_usuario`, `id_estado`) VALUES
(1, '2011-11-15', '2011-11-10', '2011-11-10', '2011-11-15', '0000-00-00', NULL, 3, 'entregado', '2011-11-16 17:52:44', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id_user` int(2) NOT NULL AUTO_INCREMENT,
  `user` varchar(15) NOT NULL,
  `passwd` varchar(15) NOT NULL,
  `tipo_user` int(1) NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `nombre` (`user`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_user`, `user`, `passwd`, `tipo_user`) VALUES
(1, 'diego', 'diego', 3),
(2, 'damian', 'damian', 3);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
