-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 07-09-2011 a las 04:34:12
-- Versión del servidor: 5.5.8
-- Versión de PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `factura`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE IF NOT EXISTS `cliente` (
  `idCliente` int(6) NOT NULL AUTO_INCREMENT,
  `nit` varchar(15) NOT NULL,
  `nombres` varchar(150) NOT NULL,
  `telefono` varchar(30) NOT NULL,
  `direccion` varchar(150) NOT NULL,
  PRIMARY KEY (`idCliente`),
  UNIQUE KEY `nit` (`nit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `cliente`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE IF NOT EXISTS `factura` (
  `idFactura` int(7) NOT NULL AUTO_INCREMENT,
  `numeroFactura` int(6) NOT NULL,
  `ciudad` varchar(22) NOT NULL,
  `fecha` date NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  `idCliente` int(6) NOT NULL,
  `nit` varchar(15) NOT NULL,
  `nombres` varchar(150) NOT NULL,
  `telefono` varchar(30) NOT NULL,
  `direccion` varchar(150) NOT NULL,
  `idUser` int(1) NOT NULL,
  `idEstadoFactura` int(1) NOT NULL,
  `descripcion` varchar(1500) NOT NULL,
  `valor` decimal(12,2) NOT NULL,
  `tarifaIva` decimal(3,1) NOT NULL,
  `observaciones` varchar(150) NOT NULL,
  PRIMARY KEY (`idFactura`),
  UNIQUE KEY `FACTURA` (`numeroFactura`),
  KEY `USUARIO` (`idUser`),
  KEY `CLIENTE` (`idCliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `factura`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `item_menu`
--

CREATE TABLE IF NOT EXISTS `item_menu` (
  `idItem` int(1) NOT NULL AUTO_INCREMENT,
  `iniciales` varchar(3) NOT NULL,
  `descripcion` varchar(30) NOT NULL,
  PRIMARY KEY (`idItem`),
  UNIQUE KEY `descripcion` (`descripcion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Volcar la base de datos para la tabla `item_menu`
--

INSERT INTO `item_menu` (`idItem`, `iniciales`, `descripcion`) VALUES
(2, 'sal', 'Salir'),
(3, 'fn', 'Factura Nueva'),
(4, 'bf', 'Buscar Factura'),
(5, 'pro', 'Programas'),
(6, 'pr', 'Porcentajes Retencion'),
(7, 'tr', 'Tarifa Reteica'),
(8, 'usu', 'Usuarios'),
(10, 'cc', 'Cambiar Contraseña'),
(11, 'ter', 'Terceros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `idPerfil` int(1) NOT NULL,
  `idSubmenu` int(1) NOT NULL,
  `idItem` int(1) NOT NULL,
  PRIMARY KEY (`idPerfil`,`idSubmenu`,`idItem`),
  KEY `PERFIL_ITEM` (`idItem`),
  KEY `PERFIL_SUBMENU` (`idSubmenu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `menu`
--

INSERT INTO `menu` (`idPerfil`, `idSubmenu`, `idItem`) VALUES
(1, 1, 2),
(3, 1, 2),
(1, 2, 3),
(3, 2, 3),
(1, 2, 4),
(3, 2, 4),
(3, 3, 8),
(3, 4, 10),
(3, 3, 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE IF NOT EXISTS `perfil` (
  `idPerfil` int(1) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(15) NOT NULL,
  PRIMARY KEY (`idPerfil`),
  UNIQUE KEY `descripcion` (`descripcion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcar la base de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`idPerfil`, `descripcion`) VALUES
(3, 'Administrador'),
(1, 'Usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `submenu`
--

CREATE TABLE IF NOT EXISTS `submenu` (
  `idSubmenu` int(1) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(20) NOT NULL,
  PRIMARY KEY (`idSubmenu`),
  UNIQUE KEY `descripcion` (`descripcion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcar la base de datos para la tabla `submenu`
--

INSERT INTO `submenu` (`idSubmenu`, `descripcion`) VALUES
(3, 'Administrar'),
(1, 'Archivo'),
(2, 'Factura'),
(4, 'Usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `idUser` int(2) NOT NULL AUTO_INCREMENT,
  `user` varchar(15) NOT NULL,
  `passwd` varchar(15) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `idPerfil` int(1) NOT NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `user` (`user`),
  KEY `PERFIL_USUARIO` (`idPerfil`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcar la base de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUser`, `user`, `passwd`, `nombre`, `email`, `idPerfil`) VALUES
(1, 'diego', 'sputnik', 'Diego Fernando Rodriguez Rincon', 'diegox09@gmail.com', 3),
(3, 'angelica', 'angelica', 'Angelica Molano', '', 3);

--
-- Filtros para las tablas descargadas (dump)
--

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `CLIENTE` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`idCliente`),
  ADD CONSTRAINT `USUARIO` FOREIGN KEY (`idUser`) REFERENCES `usuario` (`idUser`);

--
-- Filtros para la tabla `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `PERFIL_ITEM` FOREIGN KEY (`idItem`) REFERENCES `item_menu` (`idItem`),
  ADD CONSTRAINT `PERFIL_MENU` FOREIGN KEY (`idPerfil`) REFERENCES `perfil` (`idPerfil`),
  ADD CONSTRAINT `PERFIL_SUBMENU` FOREIGN KEY (`idSubmenu`) REFERENCES `submenu` (`idSubmenu`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `PERFIL_USUARIO` FOREIGN KEY (`idPerfil`) REFERENCES `perfil` (`idPerfil`);
