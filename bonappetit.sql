-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-05-2015 a las 22:05:57
-- Versión del servidor: 5.5.32
-- Versión de PHP: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `bonappetit`
--
CREATE DATABASE IF NOT EXISTS `bonappetit` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `bonappetit`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja_apertura_cierres`
--

CREATE TABLE IF NOT EXISTS `caja_apertura_cierres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(200) DEFAULT NULL,
  `hora_apertura` datetime DEFAULT NULL,
  `hora_cierre` datetime DEFAULT NULL,
  `saldo_apertura` decimal(20,5) DEFAULT NULL,
  `saldo_cierre` decimal(10,5) DEFAULT NULL,
  `cantidad_horas` varchar(20) DEFAULT NULL,
  `total_ingreso` decimal(10,2) DEFAULT NULL,
  `total_egreso` decimal(10,2) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=146 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja_estados`
--

CREATE TABLE IF NOT EXISTS `caja_estados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(200) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) DEFAULT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `apellido` varchar(45) DEFAULT NULL,
  `direccion` varchar(45) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `dni` varchar(45) DEFAULT NULL,
  `razon_social` varchar(45) DEFAULT NULL,
  `condicion_iva_id` int(11) DEFAULT NULL,
  `mapa` varchar(45) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_clientes_1_idx` (`condicion_iva_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `descripcion`, `nombre`, `apellido`, `direccion`, `telefono`, `email`, `dni`, `razon_social`, `condicion_iva_id`, `mapa`, `empresa_id`, `usuario_id`) VALUES
(1, 'loquito', 'loquitro', 'loquito', 'loquit1', 'loquisad1', 'njasd@ffddsafa.com', '1231234', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `condicion_ivas`
--

CREATE TABLE IF NOT EXISTS `condicion_ivas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE IF NOT EXISTS `empleados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) DEFAULT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `apellido` varchar(45) DEFAULT NULL,
  `dni` varchar(45) DEFAULT NULL,
  `ventas_x_dia` varchar(45) DEFAULT NULL,
  `venta_x_mesa` varchar(45) DEFAULT NULL,
  `tipo_empleado_id` int(11) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_baja` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_empleados_1_idx` (`tipo_empleado_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=70 ;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `descripcion`, `nombre`, `apellido`, `dni`, `ventas_x_dia`, `venta_x_mesa`, `tipo_empleado_id`, `empresa_id`, `usuario_id`, `fecha_alta`, `fecha_baja`) VALUES
(68, 'JAUME, NAHUEL - 34312', 'NAHUEL', 'JAUME', '34312', NULL, NULL, 1, NULL, NULL, '2015-05-13 18:07:23', NULL),
(69, 'DEGANO, ANDRES - 12323123', 'ANDRES', 'DEGANO', '12323123', NULL, NULL, 1, NULL, NULL, '2015-05-13 18:14:50', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE IF NOT EXISTS `estados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_detalles`
--

CREATE TABLE IF NOT EXISTS `factura_detalles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) DEFAULT NULL,
  `factura_maestro_id` int(11) DEFAULT NULL,
  `cantidad` decimal(10,2) DEFAULT NULL,
  `precio_unitario` decimal(10,2) DEFAULT NULL,
  `observacion` text,
  `observaciontiempo` text,
  `empresa_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `fecha_alta` datetime DEFAULT NULL,
  `fecha_cocina` datetime DEFAULT NULL,
  `demora_preparacion` int(10) DEFAULT NULL,
  `fecha_entrega` datetime DEFAULT NULL,
  `id_tipo_plato` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_factura_detalles_1_idx` (`factura_maestro_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=117851 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_maestros`
--

CREATE TABLE IF NOT EXISTS `factura_maestros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) DEFAULT NULL,
  `fecha_y_hora` datetime DEFAULT NULL,
  `fecha_y_hora_fin` datetime DEFAULT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `empleado_id` int(11) DEFAULT NULL,
  `tipo_iva_id` int(11) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `cantidad_comensales` varchar(200) DEFAULT NULL,
  `mesa_nro` int(11) DEFAULT NULL,
  `ubicacion_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_factura_maestros_1_idx` (`tipo_iva_id`),
  KEY `fk_factura_maestros_2_idx` (`cliente_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22819 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_detalles`
--

CREATE TABLE IF NOT EXISTS `pedido_detalles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) DEFAULT NULL,
  `receta_maestro_id` int(11) DEFAULT NULL,
  `pedido_maestro_id` int(11) DEFAULT NULL,
  `cantidad` decimal(10,2) DEFAULT NULL,
  `observaciones` text COMMENT 'Escriba aqui todo lo relacionado a adicionales al pedido',
  `precio_unitario` decimal(10,2) DEFAULT NULL,
  `descuento` int(10) DEFAULT '0',
  `estado_id` int(11) DEFAULT NULL,
  `tiempo` int(1) NOT NULL,
  `observaciontiempo` text,
  `timestamp_alta` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `timestamp_cocina` datetime DEFAULT NULL,
  `timestamp_entrega` datetime DEFAULT NULL,
  `demora_preparacion` int(10) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pedido_detalles_1_idx` (`receta_maestro_id`),
  KEY `fk_pedido_detalles_2_idx` (`pedido_maestro_id`),
  KEY `fk_pedido_detalles_4_idx` (`estado_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=51724 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_maestros`
--

CREATE TABLE IF NOT EXISTS `pedido_maestros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) DEFAULT NULL,
  `empleado_id` int(11) DEFAULT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `mesa_nro` int(11) DEFAULT NULL,
  `cantidad_de_comensales` varchar(200) DEFAULT NULL,
  `ubicacion_id` int(11) DEFAULT NULL,
  `fecha_y_hora` datetime DEFAULT NULL,
  `timestamp_ticket` datetime DEFAULT NULL,
  `timestamp_finalizado` datetime DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `finalizado` varchar(45) DEFAULT '0',
  `factura_maestro_id` int(11) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pedido_maestros_1_idx` (`cliente_id`),
  KEY `fk_pedido_maestros_3_idx` (`empleado_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10480 ;

--
-- Volcado de datos para la tabla `pedido_maestros`
--

INSERT INTO `pedido_maestros` (`id`, `descripcion`, `empleado_id`, `cliente_id`, `mesa_nro`, `cantidad_de_comensales`, `ubicacion_id`, `fecha_y_hora`, `timestamp_ticket`, `timestamp_finalizado`, `total`, `finalizado`, `factura_maestro_id`, `empresa_id`, `usuario_id`) VALUES
(10479, '', 69, 1, 1, '5', 1, '2015-05-13 15:32:04', NULL, NULL, '0.00', '0', NULL, 1, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `receta_maestros`
--

CREATE TABLE IF NOT EXISTS `receta_maestros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(11) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `descripcion_larga` text,
  `precio` decimal(10,2) DEFAULT NULL,
  `tipo_receta_id` int(11) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_receta_maestros_1_idx` (`tipo_receta_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=404 ;

--
-- Volcado de datos para la tabla `receta_maestros`
--

INSERT INTO `receta_maestros` (`id`, `codigo`, `descripcion`, `descripcion_larga`, `precio`, `tipo_receta_id`, `empresa_id`, `usuario_id`) VALUES
(403, '403', 'PAPAS FRITAS', NULL, '70.00', 32, NULL, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_empleados`
--

CREATE TABLE IF NOT EXISTS `tipo_empleados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) DEFAULT NULL,
  `costo_x_hora` decimal(10,2) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `tipo_empleados`
--

INSERT INTO `tipo_empleados` (`id`, `descripcion`, `costo_x_hora`, `empresa_id`, `usuario_id`) VALUES
(1, 'Admin', '100.00', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_ivas`
--

CREATE TABLE IF NOT EXISTS `tipo_ivas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_recetas`
--

CREATE TABLE IF NOT EXISTS `tipo_recetas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) DEFAULT NULL,
  `tiempo_preparacion` int(10) DEFAULT NULL,
  `pasa_cocina` int(1) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Volcado de datos para la tabla `tipo_recetas`
--

INSERT INTO `tipo_recetas` (`id`, `descripcion`, `tiempo_preparacion`, `pasa_cocina`, `empresa_id`, `usuario_id`) VALUES
(32, 'FRITOS', 30, 1, NULL, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicacion`
--

CREATE TABLE IF NOT EXISTS `ubicacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `ubicacion`
--

INSERT INTO `ubicacion` (`id`, `descripcion`, `empresa_id`, `usuario_id`) VALUES
(1, 'afuera', 1, 1),
(2, 'adentro', 1, 68);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) DEFAULT NULL,
  `apellido` varchar(150) DEFAULT NULL,
  `identificacion` varchar(50) DEFAULT NULL,
  `clave` text,
  `permiso` varchar(45) DEFAULT NULL,
  `usuario_alta` int(11) DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario_baja` int(11) DEFAULT NULL,
  `fecha_baja` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `empleado_id` int(11) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `identificacion`, `clave`, `permiso`, `usuario_alta`, `fecha_alta`, `usuario_baja`, `fecha_baja`, `empleado_id`, `empresa_id`) VALUES
(1, 'Nahuel', 'Jaume', 'njaume', '123123', '1', 1, '2015-05-13 17:46:35', NULL, '0000-00-00 00:00:00', 1, NULL),
(7, 'NAHUEL', 'JAUME', 'admin', '4297f44b13955235245b2497399d7a93', '1', 1, '2015-05-13 18:07:54', NULL, '0000-00-00 00:00:00', 68, NULL),
(8, 'ANDRES', 'DEGANO', 'adegano', '4297f44b13955235245b2497399d7a93', '2', 7, '2015-05-13 18:15:19', NULL, '0000-00-00 00:00:00', 69, NULL);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `fk_clientes_1` FOREIGN KEY (`condicion_iva_id`) REFERENCES `condicion_ivas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `fk_empleados_1` FOREIGN KEY (`tipo_empleado_id`) REFERENCES `tipo_empleados` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `factura_detalles`
--
ALTER TABLE `factura_detalles`
  ADD CONSTRAINT `fk_factura_detalles_1` FOREIGN KEY (`factura_maestro_id`) REFERENCES `factura_maestros` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `factura_maestros`
--
ALTER TABLE `factura_maestros`
  ADD CONSTRAINT `fk_factura_maestros_1` FOREIGN KEY (`tipo_iva_id`) REFERENCES `tipo_ivas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_factura_maestros_2` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pedido_detalles`
--
ALTER TABLE `pedido_detalles`
  ADD CONSTRAINT `fk_pedido_detalles_1` FOREIGN KEY (`receta_maestro_id`) REFERENCES `receta_maestros` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pedido_detalles_2` FOREIGN KEY (`pedido_maestro_id`) REFERENCES `pedido_maestros` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pedido_detalles_4` FOREIGN KEY (`estado_id`) REFERENCES `estados` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pedido_maestros`
--
ALTER TABLE `pedido_maestros`
  ADD CONSTRAINT `fk_pedido_maestros_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pedido_maestros_3` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `receta_maestros`
--
ALTER TABLE `receta_maestros`
  ADD CONSTRAINT `fk_receta_maestros_1` FOREIGN KEY (`tipo_receta_id`) REFERENCES `tipo_recetas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
