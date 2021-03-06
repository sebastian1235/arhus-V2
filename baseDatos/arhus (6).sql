-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-04-2018 a las 20:06:53
-- Versión del servidor: 10.1.22-MariaDB
-- Versión de PHP: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `arhus`
--

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `add_cot`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `add_cot` (
`id_sol` int(11)
,`nombre_loc` varchar(50)
,`nombre_sec` varchar(50)
,`nombre_tercero` varchar(80)
,`tipo_asignacion` varchar(50)
,`nombre_estado_preventa` varchar(50)
,`poliza_sol` double
,`demanda_sol` decimal(18,0)
,`cedula_sol` double
,`nombre_sol` varchar(255)
,`direccion_pol_sol` varchar(255)
,`direccion_nueva_sol` varchar(255)
,`telefono1_sol` varchar(50)
,`telefono2_sol` varchar(50)
,`celular_sol` varchar(50)
,`email_sol` varchar(80)
,`servicio_sol` varchar(100)
,`obs_sol` varchar(255)
,`fecha_prevista_sol` datetime
,`fecha_visita_comerc_sol` datetime
,`id_cot` int(11)
,`sol_cot` int(11)
,`consecutivo_cot` varchar(20)
,`estrato_cot` int(11)
,`fecha_nac_cot` date
,`forma_pago_cot` int(11)
,`campana_cot` int(11)
,`nombre_campana` varchar(50)
,`tipo_cliente_cot` int(11)
,`fecha_cot` date
,`v_total_cot` decimal(19,0)
,`v_contado_cot` decimal(19,0)
,`estado_cot` int(11)
,`obs_cot` varchar(250)
,`pagare_cot` varchar(11)
,`not_cliente_cot` tinyint(11)
,`fecha_not_cot` date
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ap_asignacion`
--

CREATE TABLE `ap_asignacion` (
  `id_asignacion` int(11) NOT NULL,
  `tipo_asignacion` varchar(50) DEFAULT NULL,
  `comision_obra_asignacion` decimal(18,5) DEFAULT '0.00000',
  `comision_gasod_asignacion` decimal(18,5) DEFAULT '0.00000',
  `comision_fija_asignacion` decimal(19,4) DEFAULT NULL,
  `empresa_asignacion` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ap_asignacion`
--

INSERT INTO `ap_asignacion` (`id_asignacion`, `tipo_asignacion`, `comision_obra_asignacion`, `comision_gasod_asignacion`, `comision_fija_asignacion`, `empresa_asignacion`) VALUES
(1, 'CALL BOGOTA1 31', '14.00000', '0.00000', '0.0000', NULL),
(2, 'CALL TUNJA', '14.00000', '13.00000', '0.0000', NULL),
(3, 'SERVIGAS BOGOTA', '0.00000', '0.00000', '0.0000', NULL),
(4, 'DEMANDA GIV', '0.00000', '0.00000', '0.0000', NULL),
(5, 'SERVIGAS CUNDI', '0.00000', '0.00000', '0.0000', NULL),
(6, 'REPARACIONES TUNJA', '0.00000', '0.00000', NULL, NULL),
(7, 'SERVIGAS', '0.00000', '0.00000', NULL, NULL),
(8, 'prueba', '1.00000', '1.00000', '1.0000', NULL),
(9, 'prueba1', '2.00000', '2.00000', '2.0000', NULL),
(10, 'hola', '1.00000', '1.00000', '1.0000', NULL),
(11, 'claro', '12.00000', '12.00000', '12.0000', NULL),
(12, 'prueba3', '2.00000', '2.00000', '2.0000', NULL),
(13, 'obra', '13.00000', '12.00000', '12.0000', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ap_camp_cliente`
--

CREATE TABLE `ap_camp_cliente` (
  `id_camp_cliente` int(11) NOT NULL,
  `campana_camp_cliente` int(11) DEFAULT NULL,
  `tipo_cliente_camp_cliente` int(11) DEFAULT NULL,
  `empresa_camp_cliente` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ap_cotizacion`
--

CREATE TABLE `ap_cotizacion` (
  `id_cot` int(11) NOT NULL,
  `sol_cot` int(11) NOT NULL,
  `consecutivo_cot` varchar(20) NOT NULL,
  `estrato_cot` int(11) NOT NULL,
  `fecha_nac_cot` date NOT NULL,
  `forma_pago_cot` int(11) NOT NULL,
  `campana_cot` int(11) NOT NULL,
  `tipo_cliente_cot` int(11) NOT NULL,
  `fecha_cot` date NOT NULL,
  `v_total_cot` decimal(19,0) NOT NULL,
  `v_contado_cot` decimal(19,0) NOT NULL,
  `estado_cot` int(11) NOT NULL,
  `obs_cot` varchar(250) NOT NULL,
  `pagare_cot` varchar(11) NOT NULL,
  `not_cliente_cot` tinyint(11) NOT NULL,
  `fecha_not_cot` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ap_cotizacion`
--

INSERT INTO `ap_cotizacion` (`id_cot`, `sol_cot`, `consecutivo_cot`, `estrato_cot`, `fecha_nac_cot`, `forma_pago_cot`, `campana_cot`, `tipo_cliente_cot`, `fecha_cot`, `v_total_cot`, `v_contado_cot`, `estado_cot`, `obs_cot`, `pagare_cot`, `not_cliente_cot`, `fecha_not_cot`) VALUES
(1, 65, '2', 2, '2018-04-07', 1, 6, 1, '2018-04-11', '0', '0', 2, '', '', 0, '0000-00-00'),
(2, 64, '4', 1, '2018-04-28', 3, 6, 1, '2018-04-17', '0', '0', 30, '', '', 0, '0000-00-00'),
(3, 68, '4', 1, '2018-04-07', 4, 6, 1, '2018-04-18', '0', '0', 37, '', '', 0, '0000-00-00'),
(4, 66, '4', 3, '2018-04-17', 2, 6, 1, '2018-04-10', '0', '0', 30, '', '', 0, '0000-00-00'),
(5, 0, '231', 1, '2018-04-12', 0, 0, 0, '2018-04-12', '0', '0', 54, '', '', 0, '0000-00-00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ap_detalle_venta`
--

CREATE TABLE `ap_detalle_venta` (
  `id_det_venta` int(11) NOT NULL,
  `venta_det_venta` int(11) DEFAULT NULL,
  `codigo_det_venta` int(11) DEFAULT NULL,
  `descripcion_det_venta` varchar(255) DEFAULT NULL,
  `precio_det_venta` decimal(19,4) DEFAULT NULL,
  `cantidad_det_venta` decimal(18,5) DEFAULT '0.00000',
  `total_det_venta` decimal(19,4) DEFAULT NULL,
  `tipo_det_venta` int(11) DEFAULT '5',
  `empresa_det_venta` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ap_estado_interno`
--

CREATE TABLE `ap_estado_interno` (
  `nombre_estado_interno` varchar(50) DEFAULT NULL,
  `para_factura_estado_interno` tinyint(1) DEFAULT '0',
  `se_paga_comision_estado_interno` tinyint(1) DEFAULT '0',
  `porcen_comision_estado_interno` decimal(3,2) DEFAULT '0.00',
  `se_paga_bono_estado_interno` tinyint(1) DEFAULT '0',
  `porcen_bono_estado_interno` decimal(3,2) DEFAULT '0.00',
  `obs_estado_interno` longtext,
  `envio_boffice_estado_interno` tinyint(1) DEFAULT '0',
  `empresa_estado_interno` int(11) DEFAULT NULL,
  `id_estado_interno` int(11) NOT NULL,
  `id_criterio` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ap_estado_interno`
--

INSERT INTO `ap_estado_interno` (`nombre_estado_interno`, `para_factura_estado_interno`, `se_paga_comision_estado_interno`, `porcen_comision_estado_interno`, `se_paga_bono_estado_interno`, `porcen_bono_estado_interno`, `obs_estado_interno`, `envio_boffice_estado_interno`, `empresa_estado_interno`, `id_estado_interno`, `id_criterio`) VALUES
(' CIERRE COBRATORIO', 0, 0, '0.00', 0, '0.00', NULL, 0, NULL, 1, 0),
('ASIGNADO', 0, 0, '0.00', 0, '0.00', NULL, 0, NULL, 2, 0),
('ATENCION A FIRMAS', 0, 1, '0.00', 0, '0.00', NULL, 0, NULL, 3, 0),
('AUSENTE', 0, 0, '0.00', 0, '0.00', NULL, 0, NULL, 4, 0),
('COMUNICADO', 0, 1, '0.00', 0, '0.00', NULL, 0, NULL, 5, 0),
('CONSTRUIDO', 0, 1, '1.00', 0, '1.00', 'asesores', 0, NULL, 7, 0),
('COTIZADO', 0, 0, '0.00', 0, '0.00', NULL, 0, NULL, 9, 0),
('DESISTIDO', 0, 0, '0.00', 0, '0.00', NULL, 0, NULL, 10, 0),
('DEVUELTO BACK OFFICE', 0, 1, '0.00', 0, '0.00', NULL, 1, NULL, 11, 0),
('Enviado Back Office', 0, 0, '0.00', 0, '0.00', NULL, 1, NULL, 13, 0),
('ESTADO CM', 0, 1, '0.00', 0, '0.00', NULL, 0, NULL, 14, 0),
('ILOCALIZADO', 0, 0, '0.00', 0, '0.00', NULL, 0, NULL, 18, 0),
('IMPOSIBILIDAD CONSTRUCCION', 0, 0, '0.00', 0, '0.00', NULL, 0, NULL, 19, 0),
('IMPOSIBILIDAD TECNICA CON COBERTURA', 0, 0, '0.00', 0, '0.50', 'tecnicos', 0, NULL, 21, 0),
('IMPOSIBILIDAD TECNICA SIN COBERTURA', 0, 0, '0.00', 0, '1.00', NULL, 0, NULL, 22, 0),
('INNECESARIA', 0, 0, '0.00', 0, '0.00', NULL, 0, NULL, 23, 0),
('MO PAGO A TECNICO', 1, 0, '0.00', 0, '0.00', 'SE GENERA DEVOLUCION DE PAPELERIA AL TECNICO', 0, NULL, 26, 0),
('NEGOCIO ANULADO', 0, 0, '0.00', 0, '0.50', 'asesores', 0, NULL, 27, 0),
('NO EFECTIVO', 0, 0, '0.00', 0, '0.00', NULL, 0, NULL, 28, 0),
('PENDIENTE COMUNICAR', 0, 0, '0.00', 0, '0.00', NULL, 0, NULL, 30, 0),
('PENDIENTE POR PAPELERIA OFICINA', 0, 0, '0.00', 0, '0.00', NULL, 0, NULL, 32, 0),
('PENDIENTE PROGRAMAR', 0, 0, '0.00', 0, '0.00', NULL, 0, NULL, 33, 0),
('PROGRAMADO', 0, 0, '0.00', 0, '0.00', NULL, 0, NULL, 35, 0),
('QUIERE MAS ADELANTE', 0, 0, '0.00', 0, '0.00', NULL, 0, NULL, 36, 0),
('RADICADO EN BACK OFFICE', 0, 1, '0.00', 0, '1.00', 'tecnicos', 0, NULL, 37, 0),
('RADICADO GIV', 0, 1, '0.00', 0, '0.00', NULL, 0, NULL, 38, 0),
('RADICADO SERVICONFORT', 0, 1, '0.00', 0, '0.00', NULL, 0, NULL, 39, 0),
('USUARIO NO DEJA INGRESAR', 0, 0, '0.00', 0, '0.00', NULL, 0, NULL, 40, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ap_estado_preventa`
--

CREATE TABLE `ap_estado_preventa` (
  `id_estado_preventa` int(11) NOT NULL,
  `nombre_estado_preventa` varchar(50) DEFAULT NULL,
  `activo_estado_preventa` tinyint(1) DEFAULT '0',
  `detalle_estado_preventa` varchar(255) DEFAULT NULL,
  `empresa_estado_preventa` int(11) DEFAULT NULL,
  `id_cri` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ap_estado_preventa`
--

INSERT INTO `ap_estado_preventa` (`id_estado_preventa`, `nombre_estado_preventa`, `activo_estado_preventa`, `detalle_estado_preventa`, `empresa_estado_preventa`, `id_cri`) VALUES
(29, 'SERVICIO CONFIRMADO', 0, NULL, NULL, 0),
(30, 'REPROGRAMAR', 0, NULL, NULL, 0),
(31, 'SERVICIO CAIDO', 0, NULL, NULL, 0),
(32, 'IMPOSIBLE CONTACTAR CLIENTE', 0, NULL, NULL, 0),
(34, 'INNECESARIA', 0, NULL, NULL, 0),
(35, 'AUSENTE', 0, NULL, NULL, 0),
(36, 'IMPOSIBILIDAD TECNICA', 0, NULL, NULL, 0),
(37, 'CLIENTE NO INTERESADO', 0, NULL, NULL, 0),
(40, 'Material', 0, NULL, NULL, 0),
(41, 'Ahorro Fondo', 0, NULL, NULL, 0),
(42, 'Seguros terceros', 0, NULL, NULL, 0),
(43, 'Nota Debito', 0, NULL, NULL, 0),
(44, 'Nota Credito', 0, NULL, NULL, 0),
(45, 'ARL', 0, NULL, NULL, 0),
(46, 'AFP', 0, NULL, NULL, 0),
(47, 'Salud', 0, NULL, NULL, 0),
(48, 'Anticipo', 0, NULL, NULL, 0),
(49, 'Otro', 0, NULL, NULL, 0),
(52, 'CLIENTE POR CONFIRMAR', 0, NULL, NULL, 0),
(54, 'SE DEJA COTIZACION', 0, NULL, NULL, 0),
(55, 'SIN COBERTURA', 0, NULL, NULL, 0),
(56, 'ANULADA', 0, NULL, NULL, 0),
(57, 'TECNICO NO ASISTE', 0, NULL, NULL, 0),
(66, 'SERVICIO REALIZADO', 0, NULL, NULL, 0),
(69, 'SERVICIO CAIDO EN CONFIRMACION', 0, NULL, NULL, 0),
(74, 'Reparaciones', 0, NULL, NULL, 0),
(75, 'Mantenimientos', 0, NULL, NULL, 0),
(76, 'Incremento', 0, NULL, NULL, 0),
(1, 'registrado', 0, NULL, NULL, 0),
(2, 'PROGRAMADO', 0, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ap_forma_pago`
--

CREATE TABLE `ap_forma_pago` (
  `Id_forma_ap` int(11) NOT NULL,
  `nombre_forma_ap` varchar(50) DEFAULT NULL,
  `desc_cal_forma_ap` double DEFAULT '0',
  `desc_est_forma_ap` double DEFAULT '0',
  `desc_obra_forma_ap` double DEFAULT '0',
  `tipo_forma_ap` varchar(80) DEFAULT NULL,
  `empresa_forma_ap` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ap_forma_pago`
--

INSERT INTO `ap_forma_pago` (`Id_forma_ap`, `nombre_forma_ap`, `desc_cal_forma_ap`, `desc_est_forma_ap`, `desc_obra_forma_ap`, `tipo_forma_ap`, `empresa_forma_ap`) VALUES
(1, 'CREDITO GAS NATURAL', 0, 0, 0, 'Credito', NULL),
(2, 'CONTADO SE RADICA', 0.05, 0.05, 0.05, 'Contado', NULL),
(3, 'CONTADO NO SE RADICA', 0.11, 0.05, 0.05, 'Contado', NULL),
(4, 'TARJETA SE RADICA', 0, 0, 0, 'Credito', NULL),
(5, 'TARJETA NO SE RADICA', 0, 0, 0, 'Credito', NULL),
(6, 'CREDICONTADO', 0, 0, 0, 'Credito', NULL),
(28, 'SERVIGAS', 0, 0, 0, 'Credito', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ap_grupo_nomina`
--

CREATE TABLE `ap_grupo_nomina` (
  `id_grupo_nomina` int(11) NOT NULL,
  `nombre_grupo_nomina` varchar(50) DEFAULT NULL,
  `activo_grupo_nomina` tinyint(1) DEFAULT '0',
  `empresa_grupo_nomina` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ap_grupo_nomina`
--

INSERT INTO `ap_grupo_nomina` (`id_grupo_nomina`, `nombre_grupo_nomina`, `activo_grupo_nomina`, `empresa_grupo_nomina`) VALUES
(74, 'Reparaciones', 0, NULL),
(75, 'Mantenimientos', 0, NULL),
(76, 'Incremento', 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ap_grupo_usuarios`
--

CREATE TABLE `ap_grupo_usuarios` (
  `id_grupo_gn` int(11) NOT NULL,
  `nombre_grupo_gn` varchar(30) DEFAULT NULL,
  `nivel_grupo_gn` int(11) DEFAULT NULL,
  `detalle_grupo_gn` varchar(255) DEFAULT NULL,
  `grupo_activo_gn` tinyint(1) DEFAULT '0',
  `empresa_grupo_gn` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ap_items_inv`
--

CREATE TABLE `ap_items_inv` (
  `Id_Item` int(11) NOT NULL,
  `codigo_item` varchar(50) DEFAULT NULL,
  `nombre_item` varchar(150) DEFAULT NULL,
  `und_item` int(11) DEFAULT NULL,
  `precio_item` decimal(19,4) DEFAULT '0.0000',
  `costo_item` decimal(19,4) DEFAULT '0.0000',
  `tipo_item` int(11) DEFAULT '6',
  `marca_item` varchar(80) DEFAULT NULL,
  `cod_marca_item` varchar(50) DEFAULT NULL,
  `detalle_item` varchar(80) DEFAULT NULL,
  `saldo_item` double DEFAULT NULL,
  `activo_item` tinyint(1) DEFAULT '1',
  `maneja_serial_item` tinyint(1) DEFAULT '0',
  `asignado_item` tinyint(1) DEFAULT '0',
  `si_no_item` tinyint(1) DEFAULT '0',
  `precio_old_item` decimal(19,4) DEFAULT NULL,
  `costo_old_item` decimal(19,4) DEFAULT NULL,
  `registra_item` varchar(255) DEFAULT NULL,
  `fecha_registro_item` datetime DEFAULT NULL,
  `empresa_item` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ap_items_inv`
--

INSERT INTO `ap_items_inv` (`Id_Item`, `codigo_item`, `nombre_item`, `und_item`, `precio_item`, `costo_item`, `tipo_item`, `marca_item`, `cod_marca_item`, `detalle_item`, `saldo_item`, `activo_item`, `maneja_serial_item`, `asignado_item`, `si_no_item`, `precio_old_item`, `costo_old_item`, `registra_item`, `fecha_registro_item`, `empresa_item`) VALUES
(1, 'REF 001', 'REPARACION FUGA CON UNION ABOCINADA', 1, '41600.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(2, 'REF 003', 'REPARACION FUGA EN GASODOMESTICO', 1, '45000.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(3, 'REF 004', 'REPARACION FUGA UNION ROSCADA', 1, '38000.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(4, 'REF 005', 'REPARACION FUGA UNION SOLDADA', 1, '38000.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(5, 'REF 007', 'REPARACION FUGA O DAÑO VALVULA DE PASO', 1, '63000.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(6, 'REF 008', 'REEMPLAZO CONECTOR FLEXOMETALICO', 1, '70000.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(7, 'REF 009', 'LIMPIEZA Y AJUSTE CALENTADOR', 1, '105000.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(8, 'REF 010', 'TRANSLADO PUNTO DE GAS - METRO LINEAL', 1, '72000.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(9, 'REF 012', 'INSTALACION DUCTO - METRO LINEAL', 1, '73000.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(10, 'REF 013', 'INSTALACION DEFLECTOR - UNIDAD', 1, '73000.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(11, 'REF 014', 'INSTALACION ABRAZADERAS - UNIDAD', 1, '2500.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(12, 'REF 015', 'REAPRITE RECORTES - UNIDAD', 1, '32000.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(13, 'REF 017', 'AISLAMIENTO', 1, '19000.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(14, 'REF 025', 'REEMPLAZO CONECTOR GASODOMESTICOS', 1, '45000.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(15, 'REF 044', 'REGATA Y RESANE EN GRIS METRO LINEAL', 1, '25000.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(16, 'REF 058', 'LIMPIEZA Y AJUSTE ESTUFA AUTOSOPORTADA (Estufa Horno)', 1, '89000.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(17, 'REF 060', 'TRANSLADO PUNTO DE GAS - METRO LINEAL DIFERENTE A COBRE RIGIDO', 1, '47000.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(18, 'REF 061', 'LIMPIEZA Y AJUSTE ESTUFA U HORNO', 1, '89000.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(19, 'REF 062', 'ANULACION PILOTO DE LLAMA ABIERTA', 1, '10000.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(20, 'REF 063', 'BUJIA ESTUFA', 1, '8954.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(21, 'REF 064', 'BUJIA PIEZOELECTRICO', 1, '13776.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(22, 'REF 065', 'BUJIA PILOTO', 1, '13776.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(23, 'REF 066', 'BUJIA QUEMADOR 5 LTS', 1, '11365.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(24, 'REF 067', 'BUJIA QUEMADOR TIRO FORZADO', 1, '24796.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(25, 'REF 068', 'CODO DUCTO O SEMICODO DUCTO TIRO NATURAL O TIRO FORZADO', 1, '46493.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(26, 'REF 069', 'INTERRUPTOR', 1, '8266.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(27, 'REF 070', 'INYECTOR ESTUFA', 1, '5510.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(28, 'REF 071', 'INYECTOR HORNO', 1, '4133.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(29, 'REF 072', 'LIMITADOR DE TEMPERATURA PIEZOELECTRICO', 1, '14212.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(30, 'REF 073', 'LIMITADOR DE TEMPERATURA  ', 1, '7108.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(31, 'REF 074', 'MEMBRANA ', 1, '50000.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(32, 'REF 075', 'PILOTO HORNO', 1, '13776.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(33, 'REF 076', 'PRESOSTATO TIRO FORZADO', 1, '41327.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(34, 'REF 077', 'TEMOPAR O TERMOCUPLA', 1, '35532.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(35, 'REF 078', 'VISITA DE CALIDAD', 1, '43000.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(36, 'REF 079', 'CAMBIO DE PERILLAS', 1, '4133.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(37, 'REF 083', 'LIMPIEZA Y AJUSTE ADICIONAL HORNO O ESTUFA SVG', 1, '45158.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(38, 'REF 084', 'LIMPIEZA Y AJUSTE ADICIONAL CALENTADOR SVG', 1, '57858.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(39, 'REF 090', 'REPUESTOS SERVIGAS', 1, '22438.0000', '0.0000', 8, NULL, NULL, 'SERVIGAS', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(40, 'MTO 001', 'MANTENIMIENTO ESTUFA RESIDENCIAL FINANCIADO', 1, '85000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(41, 'MTO 002', 'MANTENIMIENTO ESTUFA RESIDENCIAL CONTADO', 1, '75000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(42, 'MTO 003', 'MANTENIMIENTO CALENTADOR FIANACIADO', 1, '95000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(43, 'MTO 004', 'MANTEIMIENTO CALENTADOR CONTADO', 1, '85000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(44, 'MTO 005', 'MANTENIMIENTO HORNO RESIDENCIAL  FINANCIADO', 1, '85000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(45, 'MTO 006', 'MANTENIMIENTO HORNO RESIDENCIAL CONTADO', 1, '75000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(46, 'MTO 007', 'MANTENIMIENTO SECADORA FINANCIADO', 1, '85000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(47, 'MTO 008', 'MANTENIMIENTO SECADORA CONTADO', 1, '75000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(48, 'MTO 009', 'MANTENIMIENTO CHIMENEA FINANCIADO', 1, '85000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(49, 'MTO 010', 'MANTENIMIENTO CHIMENEA CONTADO', 1, '75000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(50, 'MTO 011', 'MANTENIMIENTO CALEFACTOR FINANCIADO', 1, '120000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(51, 'MTO 012', 'MANTENIMIENTO CALEFACTOR CONTADO', 1, '110000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(52, 'MTO 013', 'MANTENIMIENTO CALDERA PEQUEÑA HASTA 1000 GALONES FINANCIADO', 1, '350000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(53, 'MTO 014', 'MANTENIMIENTO CALDERA PEQUEÑA HASTA 1000 GALONES CONTADO', 1, '330000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(54, 'MTO 015', 'MANTENIMIENTO CALDERA MEDIANA FINANCIADO', 1, '500000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(55, 'MTO 016', 'MANTENIMIENTO CALDERA MEDIANA CONTADO', 1, '500000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(56, 'MTO 017', 'MANTENIMIENTO CALDERA GRANDE FINANCIADO', 1, '700000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(57, 'MTO 018', 'MANTENIMIENTO CALDERA GRANDE CONTADO', 1, '700000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(58, 'MTO019', 'MANTENIMIENTO ESTUFA INDUSTRIAL 4 PTOS FINANCIADO', 1, '170000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(59, 'MTO 020', 'MANTENIMIENTO ESTUFA INDUSTRIAL 4 PTOS CONTADO', 1, '160000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(60, 'MTO 021', 'MANTENIMIENTO ESTUFA INDUSTRIAL 6 PTOS FINANCIADO', 1, '190000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(61, 'MTO 022', 'MANTENIMIENTO ESTUFA INDUSTRIAL 6 PTOS CONTADO', 1, '180000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(62, 'MTO 023', 'MANTENIMIENTO PLANCHA 2 PTOS FINANCIADO', 1, '60000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(63, 'MTO 024', 'MANTENIMIENTO PLANCHA 2 PTOS CONTADO', 1, '50000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(64, 'MTO 025', 'MANTENIMIENTO LAVADORA - SECADORA FINANCIADO', 1, '190000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(65, 'MTO 026', 'MANTENIMIENTO LAVADORA - SECADORA CONTADO', 1, '180000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(66, 'INC 004', 'REPARACION FUGA UNION SOLDADA', 1, '35000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(67, 'INC 005', 'REPARACION FUGA O DAÑO EN VALVULA DE PASO', 1, '60000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(68, 'INC 006', 'REEMPLAZO DE CONECTOR FLEXOMETALICO', 1, '65000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(69, 'INC 007', 'LIMPIEZA Y AJUSTE CALENTADOR', 1, '95000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(70, 'INC 008', 'TRASLADO PUNTO DE GAS METRO LINEAL', 1, '65000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(71, 'INC 009', 'INSTALACION DUCTO METRO LINEAL', 1, '65000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(72, 'INC 010', 'INSTALACION DEFLECTOR - UNIDAD', 1, '55000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(73, 'INC 011', 'INSTALACION ABRAZADERAS - UNIDAD', 1, '2500.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(74, 'INC 012', 'REAPRIETE RACORES - UNIDAD', 1, '35000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(75, 'INC 013', 'AISLAMIENTO', 1, '15000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(76, 'INC 014', 'REEMPLAZO DE CONECTOR GASODOMESTICOS', 1, '45000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(77, 'INC 015', 'REGATA Y RESANE EN GRIS METRO LINEAL', 1, '25000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(78, 'INC 016', 'LIMPIEZA Y AJUSTE ESTUFA AUTO SOPORTADA  (ESTUFA HORNO)', 1, '85000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(79, 'INC 017', 'TRASLADO PUNTO DE GAS METRO LINEAL DIFRENTE A COBRE RIGIDO', 1, '35000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(80, 'INC 018', 'LIMPIEZA Y AJUSTE ESTUFA U HORNO', 1, '85000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(81, 'INC 019', 'ANULACION PILOTO DE LLAMA ABIERTA', 1, '15000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(82, 'INC 020', 'BUJIA ESTUFA', 1, '12000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(83, 'INC 021', 'BUJIA PIEZO ELECTRICO', 1, '20000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(84, 'INC 022', 'BUJIA PILOTO ', 1, '20000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(85, 'INC 023', 'BUJIA QUEMADOR 05 LTR', 1, '20000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(86, 'INC 024', 'BUJIA QUEMADOR TIRO FORZADO', 1, '30000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(87, 'INC 025', 'CODO DUCTO O SEMICODO DUCTO TIRO NATURAL O TIRO FORZADO', 1, '55000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(88, 'INC 026', 'INTERRUPTOR ', 1, '15000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(89, 'INC 027', 'INYECTOR DE ESTUFA', 1, '8000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(90, 'INC 028', 'INYECTOR DE HORNO', 1, '8000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(91, 'INC 029', 'LIMITADOR DE TEMPERATURA PIEZO ELECTRICO', 1, '20000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(92, 'INC 030', 'LIMITADOR DE TEMPERATURA ', 1, '15000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(93, 'INC 031', 'MEMBRANA ', 1, '15000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(94, 'INC 032', 'PILOTO HORNO', 1, '25000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(95, 'INC 033', 'PRESOSTATO TIRO FORZADO', 1, '55000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(96, 'INC 034', 'TERMOPAR O TERMOCUPLA', 1, '45000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(97, 'INC 035', 'CAMBIO DE PERILLAS', 1, '8000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(98, 'INC 038', 'AJUSTE MENOR', 1, '35000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(99, 'INC 039', 'CAMBIO DE MANGUERA', 1, '60000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(100, 'INC 040', 'VENTILACION 20 X 20 MURO', 1, '65000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(101, 'INC 041', 'VENTILACION 20 X 20 VIDRIO', 1, '55000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(102, 'INC 042', 'DUCTO PERISCOPICO METRO LINEAL', 1, '75000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(103, 'INC 043', 'DUCTO TIRO NATURAL METRO LINEAL', 1, '65000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(104, 'INC 044', 'INSTALACION CALENTADOR TIRO FORZADO - PUNTO CERO', 1, '190000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(105, 'INC 045', 'INSTALACION CALENTADOR TIRO NATURAL - PUNTO CERO (SIN DUCTO ADIC)', 1, '190000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(106, 'INC 046', 'INSTALACION  ESTUFA ', 1, '85000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(107, 'INC 047', 'CORTE DE MESON ', 1, '120000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(108, 'INC 048', 'INSTALACION CUBIERTA EMPOTRAR', 1, '90000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(109, 'INC 049', 'INSTALACION CAMPANA', 1, '50000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(110, 'INC 050', 'INSTALACION HORNO', 1, '90000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(111, 'INC 051', 'INSTALACION TORRE LAVADORA Y SECADORA', 1, '190000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(112, 'INC 052', 'INSTALACION LAVADORA Y SECADORA ', 1, '230000.0000', '0.0000', 6, NULL, NULL, 'OBRA CIVIL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(113, 'INC 053', 'CALENTADOR TF BOSCH 06 LTR', 1, '706000.0000', '0.0000', 5, 'BOSCH', NULL, 'CALENTADOR  BOSCH', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(114, 'INC 054', 'CALENTADOR TF BOSCH 06 LTR SILVER', 1, '730000.0000', '0.0000', 5, 'BOSCH', NULL, 'CALENTADOR  BOSCH', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(115, 'INC 055', 'CALENTADOR TF BOSCH 10 LTR', 1, '1160000.0000', '0.0000', 5, 'BOSCH', NULL, 'CALENTADOR  BOSCH', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(116, 'INC 056', 'CALENTADOR TF BOSCH 12 LTR', 1, '1465000.0000', '0.0000', 5, 'BOSCH', NULL, 'CALENTADOR  BOSCH', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(117, 'INC 057', 'CALENTADOR TF BOSCH 16 LTR', 1, '2480000.0000', '0.0000', 5, 'BOSCH', NULL, 'CALENTADOR  BOSCH', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(118, 'INC 058', 'CALENTADOR TN BOSCH 06 LTR', 1, '670000.0000', '0.0000', 5, 'BOSCH', NULL, 'CALENTADOR  BOSCH', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(119, 'INC 059', 'CALENTADOR TN BOSCH 10 LTR', 1, '1038000.0000', '0.0000', 5, 'BOSCH', NULL, 'CALENTADOR  BOSCH', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(120, 'INC 060', 'CALENTADOR TN BOSCH 13 LTR', 1, '1340000.0000', '0.0000', 5, 'BOSCH', NULL, 'CALENTADOR  BOSCH', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(121, 'INC 061', 'CALENTADOR TF CHALLENGER 06 LTR', 1, '636000.0000', '0.0000', 5, 'CALLENGER', NULL, 'CALENTADOR  CALLENGER', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(122, 'INC 062', 'CALENTADOR TF CHALLENGER 08 LTR SILVER', 1, '765000.0000', '0.0000', 5, 'CALLENGER', NULL, 'CALENTADOR  CALLENGER', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(123, 'INC 063', 'CALENTADOR TF CHALLENGER 10 LTR', 1, '1080000.0000', '0.0000', 5, 'CALLENGER', NULL, 'CALENTADOR  CALLENGER', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(124, 'INC 064', 'CALENTADOR TF CHALLENGER 12 LTR', 1, '1365000.0000', '0.0000', 5, 'CALLENGER', NULL, 'CALENTADOR  CALLENGER', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(125, 'INC 065', 'CALENTADOR TF CHALLENGER 16 LTR', 1, '2380000.0000', '0.0000', 5, 'CALLENGER', NULL, 'CALENTADOR  CALLENGER', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(126, 'INC 066', 'CALENTADOR TN CHALLENGER 06 LTR', 1, '468000.0000', '0.0000', 5, 'CALLENGER', NULL, 'CALENTADOR  CALLENGER', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(127, 'INC 067', 'CALENTADOR TN CHALLENGER 08 LTR SILVER', 1, '624000.0000', '0.0000', 5, 'CALLENGER', NULL, 'CALENTADOR  CALLENGER', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(128, 'INC 068', 'CALENTADOR TN CHALLENGER 10 LTR', 1, '780000.0000', '0.0000', 5, 'CALLENGER', NULL, 'CALENTADOR  CALLENGER', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(129, 'INC 069', 'CALENTADOR TN CHALLENGER 12 LTR', 1, '936000.0000', '0.0000', 5, 'CALLENGER', NULL, 'CALENTADOR  CALLENGER', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(130, 'INC 070', 'CALENTADOR TN CHALLENGER 16 LTR', 1, '1326000.0000', '0.0000', 5, 'CALLENGER', NULL, 'CALENTADOR  CALLENGER', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(131, 'INC 071', 'CALENTADOR TF HACEB 06 LTR', 1, '593000.0000', '0.0000', 5, 'HACEB', NULL, 'CALENTADOR  HACEB', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(132, 'INC 072', 'CALENTADOR TF HACEB 08 LTR SILVER', 1, '638000.0000', '0.0000', 5, 'HACEB', NULL, 'CALENTADOR  HACEB', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(133, 'INC 073', 'CALENTADOR TF HACEB 10 LTR', 1, '880000.0000', '0.0000', 5, 'HACEB', NULL, 'CALENTADOR  HACEB', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(134, 'INC 074', 'CALENTADOR TF HACEB 12 LTR', 1, '1165000.0000', '0.0000', 5, 'HACEB', NULL, 'CALENTADOR  HACEB', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(135, 'INC 075', 'CALENTADOR TF HACEB 16 LTR', 1, '1730000.0000', '0.0000', 5, 'HACEB', NULL, 'CALENTADOR  HACEB', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(136, 'INC 076', 'CALENTADOR TN HACEB 06 LTR', 1, '390000.0000', '0.0000', 5, 'HACEB', NULL, 'CALENTADOR  HACEB', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(137, 'INC 077', 'CALENTADOR TN HACEB 08 LTR SILVER', 1, '546000.0000', '0.0000', 5, 'HACEB', NULL, 'CALENTADOR  HACEB', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(138, 'INC 078', 'CALENTADOR TN HACEB 10 LTR', 1, '702000.0000', '0.0000', 5, 'HACEB', NULL, 'CALENTADOR  HACEB', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(139, 'INC 079', 'CALENTADOR TN HACEB 12 LTR', 1, '858000.0000', '0.0000', 5, 'HACEB', NULL, 'CALENTADOR  HACEB', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(140, 'INC 080', 'CALENTADOR TN HACEB 16 LTR', 1, '1220000.0000', '0.0000', 5, 'HACEB', NULL, 'CALENTADOR  HACEB', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(141, 'INC 081', 'ESTUFA SUPERIOR TITANIUM', 1, '690000.0000', '0.0000', 7, 'SUPERIOR', NULL, 'ESTUFAS  SUPERIOR', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(142, 'INC 082', 'ESTUFA SUPERIOR GOLD T', 1, '606000.0000', '0.0000', 7, 'SUPERIOR', NULL, 'ESTUFAS  SUPERIOR', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(143, 'INC 083', 'ESTUFA SUPERIOR GABINETE S - 8015', 1, '489000.0000', '0.0000', 7, 'SUPERIOR', NULL, 'ESTUFAS  SUPERIOR', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(144, 'INC 084', 'ESTUFA SUPERIOR GABINETE S - 7016', 1, '390000.0000', '0.0000', 7, 'SUPERIOR', NULL, 'ESTUFAS  SUPERIOR', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(145, 'INC 085', 'ESTUFA SUPERIOR GABINETE S - 7015', 1, '405000.0000', '0.0000', 7, 'SUPERIOR', NULL, 'ESTUFAS  SUPERIOR', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(146, 'INC 086', 'CUBIERTA SUP EMPOTRAR EN CRISTAL MED INT 50 X 37 SN -  8142', 1, '606000.0000', '0.0000', 7, 'SUPERIOR', NULL, 'ESTUFAS  SUPERIOR', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(147, 'INC 087', 'CUBIERTA SUP EMPOTRAR EN CRISTAL MED INT 53 X 47 SN - 8144', 1, '618000.0000', '0.0000', 7, 'SUPERIOR', NULL, 'ESTUFAS  SUPERIOR', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(148, 'INC 088', 'CUBIERTA SUP EMPOTRAR EN CRISTAL MED INT 53 X 47 SN - 8144', 1, '396000.0000', '0.0000', 7, 'SUPERIOR', NULL, 'ESTUFAS  SUPERIOR', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(149, 'INC 089', 'CUBIERTA SUP EMPOTRAR EN CRISTAL MED INT 60 X 47 SN - 8147', 1, '750000.0000', '0.0000', 7, 'SUPERIOR', NULL, 'ESTUFAS  SUPERIOR', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(150, 'INC 090', 'CUBIERTA SUP EMPOTRAR EN ACERO INOX MED INT 57 X 48 SI - 8001', 1, '453000.0000', '0.0000', 7, 'SUPERIOR', NULL, 'ESTUFAS  SUPERIOR', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(151, 'INC 091', 'CUBIERTA SUP EMPOTRAR EN ACERO INOX MED INT 49 X 46 SI - 8010', 1, '380000.0000', '0.0000', 7, 'SUPERIOR', NULL, 'ESTUFAS  SUPERIOR', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(152, 'INC 092', 'CUBIERTA SUP EMPOTRAR EN ACERO INOX MED INT 56 X 41 SI - 8021', 1, '425000.0000', '0.0000', 7, 'SUPERIOR', NULL, 'ESTUFAS  SUPERIOR', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(153, 'INC 093', 'CUBIERTA SUP EMPOTRAR EN ACERO INOX MED INT 64 X 51 SI - 8031', 1, '480000.0000', '0.0000', 7, 'SUPERIOR', NULL, 'ESTUFAS  SUPERIOR', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(154, 'INC 094', 'HORNO SUP PARA EMPOTRAR A GAS S - 8030 AN 60 AL 60 PR 57 ', 1, '606000.0000', '0.0000', 7, 'SUPERIOR', NULL, 'ESTUFAS  SUPERIOR', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(155, 'INC 095', 'HORNO SUP PARA EMPOTRAR A MIXTO S - 8040 AN 60 AL 60 PR 57 ', 1, '780000.0000', '0.0000', 7, 'SUPERIOR', NULL, 'ESTUFAS  SUPERIOR', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(156, 'INC 096', 'CAMPANA EXTRACTORA SUP PENINSULA SP - 8070 ', 1, '720000.0000', '0.0000', 7, 'SUPERIOR', NULL, 'ESTUFAS  SUPERIOR', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(157, 'INC 097', 'CAMPANA EXTRACTORA SUP INOX  S - 8070 ', 1, '328000.0000', '0.0000', 7, 'SUPERIOR', NULL, 'ESTUFAS  SUPERIOR', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(158, 'INC 098', 'ESTUFA SUP SOBREMESA S - 7053', 1, '178000.0000', '0.0000', 7, 'SUPERIOR', NULL, 'ESTUFAS  SUPERIOR', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(159, 'INC 099', 'ESTUFA SUP SOBREMESA S - 7054', 1, '267000.0000', '0.0000', 7, 'SUPERIOR', NULL, 'ESTUFAS  SUPERIOR', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(160, 'INC 100', 'CUBIERTA CH EMPOTRAR EN CRISTAL MED INT 50 X 37 ', 1, '686000.0000', '0.0000', 7, 'CHALLENGER', NULL, 'ESTUFAS  CHALLENGER', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(161, 'INC 101', 'CUBIERTA CH EMPOTRAR EN CRISTAL MED INT 53 X 47 ', 1, '698000.0000', '0.0000', 7, 'CHALLENGER', NULL, 'ESTUFAS  CHALLENGER', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(162, 'INC 102', 'CUBIERTA CH EMPOTRAR EN CRISTAL MED INT 53 X 47 ', 1, '476000.0000', '0.0000', 7, 'CHALLENGER', NULL, 'ESTUFAS  CHALLENGER', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(163, 'INC 103', 'CUBIERTA CH EMPOTRAR EN CRISTAL MED INT 60 X 47 ', 1, '830000.0000', '0.0000', 7, 'CHALLENGER', NULL, 'ESTUFAS  CHALLENGER', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(164, 'INC 104', 'CUBIERTA CH EMPOTRAR EN ACERO INOX MED INT 56,5 X 48, 5 ', 1, '405000.0000', '0.0000', 7, 'CHALLENGER', NULL, 'ESTUFAS  CHALLENGER', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(165, 'INC 105', 'CUBIERTA CH EMPOTRAR EN ACERO INOX MED INT 49 X 46 ', 1, '460000.0000', '0.0000', 7, 'CHALLENGER', NULL, 'ESTUFAS  CHALLENGER', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(166, 'INC 106', 'CUBIERTA CH EMPOTRAR EN ACERO INOX MED INT 56 X 41 ', 1, '505000.0000', '0.0000', 7, 'CHALLENGER', NULL, 'ESTUFAS  CHALLENGER', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(167, 'INC 107', 'CUBIERTA CH EMPOTRAR EN ACERO INOX MED INT 64 X 51 ', 1, '560000.0000', '0.0000', 7, 'CHALLENGER', NULL, 'ESTUFAS  CHALLENGER', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(168, 'INC 108', 'HORNO CH PARA EMPOTRAR A GAS  AN 60 AL 60 PR 57 ', 1, '800000.0000', '0.0000', 7, 'CHALLENGER', NULL, 'ESTUFAS  CHALLENGER', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(169, 'INC 109', 'HORNO CH PARA EMPOTRAR COMBI  ', 1, '2200000.0000', '0.0000', 7, 'CHALLENGER', NULL, 'ESTUFAS  CHALLENGER', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(170, 'INC 110', 'CAMPANA EXTRACTORA CH PENINSULA ', 1, '800000.0000', '0.0000', 7, 'CHALLENGER', NULL, 'ESTUFAS  CHALLENGER', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(171, 'INC 111', 'CAMPANA EXTRACTORA CH INOX  ', 1, '408000.0000', '0.0000', 7, 'CHALLENGER', NULL, 'ESTUFAS  CHALLENGER', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(172, 'INC 112', 'SECADORA WHIRPOOL WGD 8 - 7 HEDC', 1, '2660000.0000', '0.0000', 5, 'WHIRPOOL', NULL, 'CALENTADOR  WHIRPOOL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(173, 'INC 113', 'SECADORA WHIRPOOL WGD - 5700 -BC', 1, '2270000.0000', '0.0000', 5, 'WHIRPOOL', NULL, 'CALENTADOR  WHIRPOOL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(174, 'INC 114', 'SECADORA FRIGIDAIRE FAQG - 7077 - KW', 1, '2180000.0000', '0.0000', 5, 'FRIGIDAIRE', NULL, 'CALENTADOR  FRIGIDAIRE', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(175, 'INC 115', 'SECADORA FRIGIDAIRE FAQG - 7074 - LA -1 ', 1, '2600000.0000', '0.0000', 5, 'FRIGIDAIRE', NULL, 'CALENTADOR  FRIGIDAIRE', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(176, 'INC 116', 'TORRE FRIGIDAIRE FFLG - 2022 - MW', 1, '3978000.0000', '0.0000', 5, 'FRIGIDAIRE', NULL, 'CALENTADOR  FRIGIDAIRE', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(177, 'INC 117', 'TORRE WHIRPOOL  WET - 3300 - XQ', 1, '4400000.0000', '0.0000', 5, 'WHIRPOOL', NULL, 'CALENTADOR  WHIRPOOL', 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(178, 'INC 118', 'INSTALACION  ESTUFA cra 13', 1, '85000.0000', '0.0000', 6, NULL, '15000', NULL, 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(179, 'REP 101', 'REPARACION DE TARJETA', 1, '95000.0000', '0.0000', 6, NULL, NULL, NULL, 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(180, 'REP 102', 'CAMBIO CAJA ELECTRONICA WH HACEB 10 LTS', 1, '320000.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(181, 'REP 104', 'CAMBIO DE HIDRAULICA', 1, '105358.0000', '0.0000', 6, NULL, NULL, NULL, 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(182, 'REP 001', 'REPARACION FUGA UNION ABOCINADA', 1, '41600.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(183, 'REP 003', 'REPARACION FUGA EN GASODOMESTICO', 1, '45000.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, '0.0000', NULL, 'Diego', NULL, NULL),
(184, 'REP 004', 'REPARACION EN FUGA UNION ROSCADA', 1, '38000.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(185, 'REP 005', 'REPARACION FUGA EN UNION SOLDADA', 1, '38000.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(186, 'REP 007', 'REPARACION FUGA O DAÑO EN VALVULA DE PASO', 1, '63000.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(187, 'REP 008', 'REEMPLAZO CONECTOR FLEXOMETALICO', 1, '70000.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(188, 'REP 009', 'LIMPIEZA Y AJUSTE CALENTADOR', 1, '105000.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(189, 'REP 010', 'TRNSLADO PUNTO DE GAS - METRO LINEAL', 1, '72000.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(190, 'REP 012', 'INSTALACION DUCTO - METRO LINEAL', 1, '73000.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(191, 'REP 013', 'INSTALACION DEFLECTOR - UNIDAD', 1, '73000.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(192, 'REP 014', 'INSTALACION ABRAZADERAS - UNIDAD', 1, '2500.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(193, 'REP 015', 'REAPRIETE RECORES - UNIDAD', 1, '32000.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, '0.0000', NULL, 'Diego', NULL, NULL),
(194, 'REP 017', 'AISLAMIENTO', 1, '19000.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(195, 'REP 025', 'REEMPLAZO CONECTOR GASODOMESTICOS', 1, '45000.0000', '14112.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(196, 'REP 044', 'REGATA Y RESANE EN GRIS METRO LINEAL', 1, '25000.0000', '6886.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(197, 'REP 058', 'LIMPIEZA Y AJUSTE ESTUFA AUTOSOPORTADA (ESTUFA HORNO)', 1, '89000.0000', '32510.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, '67737.0000', NULL, 'Diego', NULL, NULL),
(198, 'REP 060', 'TRANSLADO PUNTO DE GAS - METRO LINEAL DIFERENTE A COBRE RIGIDO', 1, '47000.0000', '13424.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(199, 'REP 061', 'LIMPIEZA Y AJUSTE ESTUFA U HORNO', 1, '89000.0000', '27094.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(200, 'REP 062', 'ANULACION PILOTO DE LLAMA ABIERTA', 1, '10000.0000', '1653.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(201, 'REP 063', 'BUJIA ESTUFA', 1, '8954.0000', '3582.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(202, 'REP 064', 'BUJIA PIEZOELECTRICO', 1, '13776.0000', '5510.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(203, 'REP 065', 'BUJIA PILOTO', 1, '13776.0000', '5510.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(204, 'REP 066', 'BUJIA QUEMADOR 5 LTS', 1, '11365.0000', '4546.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(205, 'REP 067', 'BUJIA QUEMADOR TIRO FORZADO', 1, '24796.0000', '9918.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(206, 'REP 105', 'CAMBIO DIAFRAGMA', 1, '50000.0000', '20000.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(207, 'REP 106', 'CALIBRACION CALENTADOR FINANCIADO', 1, '95000.0000', '30000.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(208, 'REP 107', 'VISITA TECNICA', 1, '0.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(209, 'REP 108', 'REVISION TECNICA', 1, '0.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(210, 'REP 112', 'REJILLADE VENTILACION', NULL, '0.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(211, 'REP 016', 'MANTENIMIENTO ESTUFA FINANCIADO', 1, '85000.0000', '25000.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(212, 'REP 091', 'OTROS', 1, '35000.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(213, 'REF 085', 'AJUSTE MENOR', 1, '22438.0000', '8975.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, '0.0000', 'Diego', NULL, NULL),
(214, 'REP 024', 'ANCLAJE CALENTADOR TRASLADO', 1, '180000.0000', '22400.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(215, 'RF 062', 'LIMIEZA Y AJUSTE ESTUFA U HORNO 4 PUESTOS O MAS', 1, '67000.0000', '26800.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, '0.0000', '0.0000', 'Diego', NULL, NULL),
(216, 'REP 011', 'ADECUACION APERTURA DE REJILLA', 1, '105000.0000', '17600.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 1, NULL, NULL, NULL, NULL, NULL),
(217, 'REP 111', 'CAMBIO DE MODULO ELECTRONICO', 1, '360000.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, '180000.0000', NULL, 'Master', NULL, NULL),
(218, 'MTO028', 'CAMBIO DE DIAFRAGMA', 1, '50000.0000', '16400.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(219, 'MTO029', 'VISITA TECNICA FINANCIADO', 1, '35000.0000', '10000.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(220, 'MTO030', 'REVISION WH', 1, '45000.0000', '18000.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, '0.0000', '0.0000', 'Diego', NULL, NULL),
(221, 'MTO031', 'CONJUNTO VALVULA GAS - AGUA', 1, '180000.0000', '59040.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, '0.0000', '0.0000', 'Diego', NULL, NULL),
(222, 'MTO032', 'CONJUNTO VALVULA GAS - AGUA GAMA ALTA', 1, '250000.0000', '82000.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(223, 'MTO033', 'EMPAQUETADURA - EMPAQUE MEDIA TEFLON', 1, '30000.0000', '9840.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(224, 'MTO034', 'MICROSWISH', 1, '35000.0000', '11480.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(225, 'MTO035', 'CAJA ELECTRONICA GAMA BAJA', 1, '280000.0000', '91840.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(226, 'MTO036', 'CAJA ELECTRONICA GAMA ALTA', 1, '420000.0000', '137760.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(227, 'MTO037', 'CAMBIO DE SENSOR', 1, '30000.0000', '9840.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(228, 'MTO038', 'ENCENDIDO ELECTRICO WH ACUMULACION', 1, '150000.0000', '49200.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(229, 'MTO039', 'INTERCAMBIADOR WH 6 LTS', 1, '320000.0000', '104960.0000', 2, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(230, 'MTO040', 'INTERCAMBIADOR WH 8 - 10 LTS', 1, '480000.0000', '157440.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(231, 'MTO041', 'INTERCAMBIADOR WH 12 - 16 LTS', 1, '580000.0000', '190240.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(232, 'MTO042', 'INTERCAMBIADOR SOLDADURASOLDADA INTERCAMBIADOR', 1, '170000.0000', '55760.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(233, 'MTO043', 'PRESOSTATO', 1, '70000.0000', '22960.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(234, 'MTO044', 'MOTO VENTILADOR', 1, '220000.0000', '72160.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(235, 'MTO045', 'CAPASITOR', 1, '60000.0000', '19680.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(236, 'MTO046', 'TERMOSTATO', 1, '60000.0000', '19680.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(237, 'MTO047', 'VALVULA TERMOSTATO WH ACUMULACION', 1, '150000.0000', '49200.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(238, 'REP 079', 'CAMBIO DE PERILLAS', 1, '0.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(239, 'INC 119', 'INSTALACION INTERNA', 1, '920000.0000', '100000.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(240, 'INC 120', 'INSTALACION CALENTADOR EASY', 1, '120000.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(241, 'INC 121', 'INSTALACION ESTUFA EASY', 1, '50000.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(242, 'INC 122', 'ASESORIA EASY', 1, '29900.0000', '10000.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(243, 'REP 113', 'METODO II', 1, '120000.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(244, 'REP 114', 'CAMBIO DE MICRO-SWITCH', 1, '85000.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(245, 'MTO 048', 'MANTENIMIENTO LAVADORA', 1, '65000.0000', NULL, 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(246, 'REP 115', 'TAPONAMIENTO DE FOGON', 1, '40000.0000', '16000.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(247, 'INC086', 'ESTUFA HACEB DE PISO', 1, '1240000.0000', '762000.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(248, 'RF001', 'REP FUGA UNION ABOCINADA', 1, '36278.0000', '12996.1999', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(249, 'RF003', 'REP FUGA EN GASODOMESTICO', 1, '38034.0000', '13622.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(250, 'RF004', 'REP FUGA UNION ROSCADA', 1, '26331.0000', '9432.5000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(251, 'RF005', 'REP FUGA UNION SOLDADA', 1, '26916.0000', '9642.5000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(252, 'RF007', 'REP FUGA O DAÑO EN VALV. DE PASO', 1, '48273.0000', '17293.1499', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(253, 'RF008', 'REEMPLAZO CONECTOR FLEXOMETALICO', 1, '48273.0000', '17293.1499', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(254, 'RF009', 'LIMPIEZA Y AJUSTE DEL CALENTADOR', 1, '99959.0000', '30000.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(255, 'RF010', 'TRASLADO PUNTO DE GAS-METRO LINEAL', 1, '59826.0000', '21433.3000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(256, 'RF012', 'Instalacion Ducto- metro Lineal', 1, '64260.0000', '23020.1999', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(257, 'RF013', 'Instalacion Deflector Unidad', 1, '49886.0000', '17904.6000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(258, 'RF014', 'INSTALACION ABRAZADERA-IMPREVISTO', 1, '2048.0000', '733.5999', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(259, 'RF015', 'REAPRIETE RACORES-UNIDAD', 1, '21065.0000', '7545.9999', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(260, 'RF017', 'AISLAMIENTO', 1, '12872.0000', '4611.5999', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(261, 'RF025', 'REEMPLAZO CONECTOR GASODOMESTICO', 1, '36571.0000', '13101.1999', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(262, 'RF044', 'REGATA Y RESANE EN GRIS-METRO LINEAL', 1, '17846.0000', '6043.4500', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(263, 'RF058', 'LIMPIEZA Y AJUSTE ESTUFA AUTOSOPORTADAD(ESTUFA- HORNO)', 1, '84251.0000', '30181.9000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(264, 'RF060', 'Traslado Metro Lineal Diferente a Cobre Rigido', 1, '34789.0000', '12462.4499', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(265, 'RF061', 'Limpieza Estufa u horno', 1, '70216.0000', '20000.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(266, 'RF062', 'Anulación de Piloto Llama Abierta', 1, '4284.0000', '1534.7500', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(267, 'RF063', 'Bujía Estufa', 1, '9282.0000', '3325.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(268, 'RF064', 'Bujía Piezoeléctrico', 1, '14280.0000', '5115.5999', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(269, 'RF065', 'Bujía Piloto', 1, '14280.0000', '5115.5999', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(270, 'RF066', 'Bujía Quemador 5 Lts', 1, '11781.0000', '4220.3000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(271, 'RF067', 'Bujía Quemador Tiro Forzado', 1, '25704.0000', '9208.1500', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(272, 'RF068', 'Codo Ducto o semicodo ducto tiro natural o tiro forzado', 1, '48195.0000', '17265.1499', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(273, 'RF069', 'Interruptor', 1, '8567.0000', '3069.5000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(274, 'RF070', 'INYECTOR ESTUFA UNIDAD ', 1, '5712.0000', '2046.1000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(275, 'RF071', 'Inyector Horno', 1, '4284.0000', '1534.7500', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(276, 'RF072', 'Limitador Temperatura Piezoelectrico', 1, '14732.0000', '5277.6500', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(277, 'RF073', 'Limitador De Temperatura', 1, '7368.0000', '2639.7000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(278, 'RF074', 'MEMBRANA', 1, '14280.0000', '5115.5999', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(279, 'RF075', 'Piloto Horno', 1, '14280.0000', '5115.5999', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(280, 'RF076', 'presostato tiro forzado', 1, '42840.0000', '15346.8000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(281, 'RF077', 'Termopar o Termocupla', 1, '36832.0000', '13194.6500', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(282, 'RF078', 'Visita de Calidad', 1, '23259.0000', '8332.4499', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(283, 'RF079', 'Cambio de Perillas', 1, '4284.0000', '1534.7500', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(284, 'RF083', 'LIMPIEZA Y AJUSTE ESTUFA U HORNO ADICIONAL', 1, '46811.0000', '16769.5500', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(285, 'RF084', 'LIMPIEZA Y AJUSTE DEL CALENTADOR ADICIONAL', 1, '59976.0000', '21485.4499', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(286, 'RF085', 'AJUSTE MENOR', 1, '23259.0000', '8332.4499', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(287, 'RF090', 'REPUESTOS SERVIGAS', 1, '0.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(288, 'INC081', 'CALENTADOR HACEB ACUMULACION 20 GALONES', 1, '0.0000', NULL, 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(290, 'MTO048', 'REVISION WH', 1, '45000.0000', '18000.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(292, 'RF91', 'DESINSTALACION WH', 1, '50000.0000', '16400.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(293, 'RF92', 'SNAPING ESTUFA', 1, '36691.0000', '12037.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(294, 'MTO049', 'HERMETIZACION DE DUCTO', 1, '55000.0000', '18040.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(295, 'MTO050', 'CATENARIA', 1, '60000.0000', '19680.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(296, 'MTO051', 'QUEMADORES', 1, '12241.0000', '4015.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(297, 'CR001', 'ESTUFA FLORENCIA', 1, '910000.0000', '910000.0000', 7, 'INDURAMA', '10', 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(298, 'MTO052', 'VALVULA DE ESTUFA', 1, '25000.0000', '8200.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(299, 'MTO053', 'CUBRIMIENTO TERMICO', 1, '50000.0000', '16400.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(300, 'MTO054', 'BYPASS', 1, '100000.0000', '32800.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(301, 'REP 092', 'CALIBRACION OTROS', NULL, '15000.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(302, 'CR002', 'ESTUFA GALICIA', 1, '527500.0000', '527500.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(303, 'MTO055', 'CAMBIO DE PILAS', 1, '15000.0000', '4920.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(304, 'MTO056', 'RECTIFICACION DE CONJUTO DE AGUA', 1, '65000.0000', '21320.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(305, 'MTO057', 'VERIFICACION DE FUGAS', 1, '17000.0000', '5576.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(306, 'MTO058', 'LUBRICACION VALVULA ESTUFA', 1, '22000.0000', '7216.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(307, 'MTO059', 'LIMPIEZA DE HIDRAULICAS', 1, '0.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(308, 'MTO059 .', 'LIMPIEZA DE HIDRAULICAS .', 1, '1666.6660', '546.6666', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(309, 'MTO060', 'LIMPIEZA DE HIDRAULICAS', 1, '42500.0000', '13940.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(310, 'MTO061', 'CAMBIO DE EMPAQUES', 1, '1667.0000', '547.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(311, 'MTO062', 'CAMBIO DE CONECCIONES', 1, '42500.0000', '13940.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(312, 'MTO063', 'ELECTRO VALVULA', 1, '105000.0000', '34440.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(313, 'MTO064', 'CALIBRACION', 1, '25000.0000', '8200.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(314, 'MTO065', 'INTERCAMBIADOR GAMA BAJA', 1, '255000.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(315, 'MTO066', 'CAMBIO DE PILOTO', 1, '40000.0000', '13120.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(316, 'MTO067', 'TARJETA ELECTRONICA', 1, '150000.0000', '49200.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(317, 'MTO068', 'ORING', 1, '15000.0000', '4920.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(318, 'MTO069', 'ESPIGO CUERPO DE AGUA', 1, '15000.0000', '4920.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(319, 'MTO070', 'ORING', 1, '5000.0000', '1640.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(320, 'MTO071', 'RETRANG DE CUERPO DE GAS', 1, '59000.0000', '19352.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(321, 'MTO072', 'CAMBIO DE IGNITOR', 1, '160000.0000', '52480.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(322, 'MTO073', 'REPARACION', 1, '0.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(323, 'MTO074', 'RECTIFICACION DE TARJETA', 1, '0.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ap_items_inv` (`Id_Item`, `codigo_item`, `nombre_item`, `und_item`, `precio_item`, `costo_item`, `tipo_item`, `marca_item`, `cod_marca_item`, `detalle_item`, `saldo_item`, `activo_item`, `maneja_serial_item`, `asignado_item`, `si_no_item`, `precio_old_item`, `costo_old_item`, `registra_item`, `fecha_registro_item`, `empresa_item`) VALUES
(324, 'MTO075', 'ANCLAJE DE PILAS', 1, '68000.0000', '22304.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(325, 'INC119', 'ESTUFA MESON AR 150 GAS 4 PDS INOX', 1, '390000.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(326, 'INC120', 'HORNO ARF 50 GAS GN NE', 1, '433380.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(327, 'INC', 'TORRE DE SECADO', 1, '2000000.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(328, 'MTO076', 'INYECTOR WH', 1, '40000.0000', '13120.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(329, 'MTO077', 'ENCENDIDO ELECTRONICO', 1, '75000.0000', '24600.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(330, 'MTO078', 'FUENTE', 1, '150000.0000', '49200.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(331, 'MTO079', 'DISPLAY', 1, '50000.0000', '16400.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(332, 'MTO080', 'TAPONAMIENTO DE PUNTO', 1, '60000.0000', '19680.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(333, 'MTO081', 'FREIDORA', NULL, '0.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(334, 'MTO082', 'VISITA CERTEZA', NULL, '0.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(335, 'MTO083', 'VISITA CERTEZA', 1, '50000.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(336, 'INC121', 'ADECUACIONES INTERNAS', NULL, '0.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(337, 'MTO084', 'GREC<', NULL, '0.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(338, 'MTO085', 'GRECA', 1, '0.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(339, 'INC 123', 'ESTUFA HACEB', 1, '882000.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(340, 'MTO 027', 'VENTA ADICIONAL TECNICO', NULL, '10000.0000', '0.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(341, 'INC124', 'WH HACEB ACUM 20 GAL', 1, '1190473.0000', '875348.0000', 5, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(342, 'INC125', 'INSTALACION WH ACUMULACION', 1, '190000.0000', '90000.0000', 6, NULL, NULL, 'Calentadores', 0, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(343, 'INC 126', 'TRANSPORTE GASODOMESTICO CUNDI-BOYACA', 1, '100000.0000', '70000.0000', 6, NULL, NULL, 'Calentadores', NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(344, 'hol1', 'hola', 0, '0.0000', '0.0000', 1, '', '', '', NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(345, '3112', 'HOLA4', 0, '0.0000', '0.0000', 2, '', '', '', NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(346, '12E', 'PRUEBA1', 12, '121.0000', '121.0000', 2, '', '', '', NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(347, '218', 'prueba5', 12, '12.0000', '12.0000', 2, '', '', '', NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(348, '13', 'hola13', 12, '12.0000', '0.0000', 2, '', '', '', NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(349, '123', 'prueba def', 123, '12.0000', '12.0000', 2, 'ac', '121', '12', NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ap_roles_usuarios`
--

CREATE TABLE `ap_roles_usuarios` (
  `Id_Rol` int(11) NOT NULL,
  `grupo_Rol` int(11) DEFAULT NULL,
  `formulario_Rol` longtext NOT NULL,
  `abrir_Rol` tinyint(1) DEFAULT '0',
  `agregar_Rol` tinyint(1) DEFAULT '0',
  `editar_Rol` tinyint(1) DEFAULT '0',
  `eliminar_Rol` tinyint(1) DEFAULT '0',
  `mostrar_Rol` tinyint(1) DEFAULT '0',
  `alias_Rol` varchar(80) DEFAULT NULL,
  `empresa_Rol` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ap_roles_usuarios`
--

INSERT INTO `ap_roles_usuarios` (`Id_Rol`, `grupo_Rol`, `formulario_Rol`, `abrir_Rol`, `agregar_Rol`, `editar_Rol`, `eliminar_Rol`, `mostrar_Rol`, `alias_Rol`, `empresa_Rol`) VALUES
(123, 1, 'FListas##Form FListas', 1, 1, 1, 0, 1, 'fListas', NULL),
(124, 1, 'FRoles##Form FRoles', 1, 1, 1, 1, 1, 'Froles', NULL),
(125, 1, 'FSolicitudes##Form FSolicitudes', 1, 1, 1, 0, 1, 'Fsolicitudes', NULL),
(126, 1, 'FTerceros##Form FTerceros', 1, 1, 1, 0, 1, 'Fterceros', NULL),
(127, 1, 'FTipoCliente##Form FTipoCliente', 1, 1, 1, 0, 1, 'FTipoCliente', NULL),
(128, 1, 'TDBasicosF##Form TDBasicosF', 1, 1, 1, 0, 1, 'tdBasicosF', NULL),
(129, 1, 'FCAMPAÑA##Form FCAMPAÑA', 1, 1, 1, 0, 1, 'FCAMPAÑA', NULL),
(130, 1, 'FSegGrupos##Form FSegGrupos', 1, 1, 1, 0, 1, 'FSegGrupos', NULL),
(131, 1, 'FSegUsuarios##Form FSegUsuarios', 1, 1, 1, 0, 1, 'FSegUsuarios', NULL),
(132, 1, 'FGestion##Form FGestion', 1, 1, 1, 0, 1, 'fgestion', NULL),
(133, 1, 'FAprobacion##Form FAprobacion', 1, 1, 1, 0, 1, 'fAprobacion', NULL),
(134, 1, 'FObras##Form FObras', 1, 1, 1, 0, 1, 'Fobras', NULL),
(135, 1, 'FLqManoO##Form FLqManoO', 1, 1, 1, 1, 1, 'flqManoO', NULL),
(136, 1, 'FInterventoria##Form FInterventoria', 1, 1, 1, 0, 1, 'finterventoria', NULL),
(137, 1, 'FPQR##Form FPQR', 1, 1, 1, 0, 1, 'FPQR', NULL),
(138, 1, 'Facturacion##Form Facturacion', 1, 1, 1, 0, 1, 'Facturacion', NULL),
(139, 1, 'FPedidos##Form FPedidos', 1, 1, 1, 0, 1, 'Fpedidos', NULL),
(141, 1, 'FParametros##Form FParametros', 1, 1, 1, 0, 1, 'Fparametros', NULL),
(142, 1, 'ItemsF##Form ItemsF', 1, 1, 1, 0, 1, 'ItemsF', NULL),
(143, 1, 'DatosTotal##Form DatosTotal', 1, 1, 1, 0, 1, 'DatosTotal', NULL),
(144, 1, 'FGestionM##Form FGestionM', 1, 1, 1, 0, 1, 'FGestionM', NULL),
(145, 1, 'FInterventoria##Form FInterventoria', 1, 1, 1, 0, 1, 'Finterventoria', NULL),
(146, 1, 'FEstadoObra##Form FEstadoObra', 1, 1, 1, 0, 1, 'FEstadoObra', NULL),
(147, 1, 'FinterRechazo##Form FinterRechazo', 1, 1, 1, 0, 1, 'FinterRechazo', NULL),
(148, 1, 'FListaP##Form FListaP', 1, 1, 1, 0, 1, 'flistaP', NULL),
(149, 1, 'FFacturas##Form FFacturas', 1, 1, 1, 0, 1, 'Ffacturas', NULL),
(151, 1, 'FNomAs##Form FNomAs', 1, 1, 1, 0, 1, 'FNomAs', NULL),
(152, 1, 'FLqManoO##Form FLqManoO', 1, 1, 1, 1, 1, 'FLqManoO', NULL),
(153, 1, 'Fnomtec##Form Fnomtec', 1, 1, 1, 0, 1, 'Fnomtec', NULL),
(155, 1, 'FPagosVideos##Form FPagosVideos', 1, 1, 1, 0, 1, 'FPagosVideos', NULL),
(158, 6, 'FSolicitudes##Form FSolicitudes', 1, 1, 1, 0, 1, 'Fsolicitudes', NULL),
(159, 6, 'TDBasicosF##Form TDBasicosF', 1, 1, 0, 0, 1, 'tdBasicosF', NULL),
(160, 2, 'FListas##Form FListas', 1, 1, 0, 0, 1, 'fListas', NULL),
(162, 2, 'FSolicitudes##Form FSolicitudes', 1, 1, 1, 0, 1, 'Fsolicitudes', NULL),
(163, 2, 'FTerceros##Form FTerceros', 1, 1, 1, 0, 1, 'Fterceros', NULL),
(164, 2, 'FTipoCliente##Form FTipoCliente', 1, 1, 0, 0, 1, 'FTipoCliente', NULL),
(165, 2, 'TDBasicosF##Form TDBasicosF', 1, 1, 1, 0, 1, 'tdBasicosF', NULL),
(166, 2, 'FCAMPAÑA##Form FCAMPAÑA', 1, 1, 0, 0, 1, 'FCAMPAÑA', NULL),
(169, 2, 'FGestion##Form FGestion', 1, 1, 1, 0, 1, 'fgestion', NULL),
(170, 2, 'FAprobacion##Form FAprobacion', 1, 1, 0, 0, 1, 'fAprobacion', NULL),
(171, 2, 'FObras##Form FObras', 1, 1, 1, 0, 1, 'Fobras', NULL),
(172, 2, 'FLqManoO##Form FLqManoO', 1, 1, 1, 1, 1, 'flqManoO', NULL),
(173, 2, 'FInterventoria##Form FInterventoria', 1, 1, 0, 0, 1, 'finterventoria', NULL),
(174, 2, 'FPQR##Form FPQR', 1, 1, 1, 0, 1, 'FPQR', NULL),
(179, 2, 'ItemsF##Form ItemsF', 1, 1, 0, 0, 1, 'ItemsF', NULL),
(180, 2, 'DatosTotal##Form DatosTotal', 1, 1, 0, 0, 1, 'DatosTotal', NULL),
(181, 2, 'FGestionM##Form FGestionM', 1, 1, 1, 0, 1, 'FGestionM', NULL),
(183, 2, 'FEstadoObra##Form FEstadoObra', 1, 1, 0, 0, 1, 'FEstadoObra', NULL),
(184, 2, 'FinterRechazo##Form FinterRechazo', 1, 1, 1, 0, 1, 'FinterRechazo', NULL),
(190, 2, 'FPagosVideos##Form FPagosVideos', 1, 1, 1, 0, 1, 'FPagosVideos', NULL),
(191, 3, 'FSolicitudes##Form FSolicitudes', 1, 0, 0, 0, 1, 'Fsolicitudes', NULL),
(192, 3, 'TDBasicosF##Form TDBasicosF', 1, 1, 1, 0, 1, 'tdBasicosF', NULL),
(194, 3, 'FCAMPAÑA##Form FCAMPAÑA', 1, 0, 0, 0, 1, 'FCAMPAÑA', NULL),
(195, 3, 'Facturacion##Form Facturacion', 1, 1, 1, 0, 1, 'Facturacion', NULL),
(196, 3, 'FPedidos##Form FPedidos', 1, 1, 1, 0, 1, 'Fpedidos', NULL),
(197, 3, 'FFacturas##Form FFacturas', 1, 1, 1, 0, 1, 'Ffacturas', NULL),
(198, 3, 'FParametros##Form FParametros', 1, 1, 1, 0, 1, 'Fparametros', NULL),
(203, 3, 'FGestion##Form FGestion', 1, 1, 1, 0, 1, 'fgestion', NULL),
(204, 3, 'FGestionM##Form FGestionM', 1, 1, 1, 0, 1, 'FGestionM', NULL),
(205, 7, 'Entradas##Form Entradas', 1, 1, 1, 0, 1, 'Entradas', NULL),
(206, 1, 'Entradas##Form Entradas', 1, 1, 1, 0, 1, 'Entradas', NULL),
(207, 7, 'SalidasF##Form SalidasF', 1, 1, 1, 0, 1, 'SalidasF', NULL),
(208, 1, 'SalidasF##Form SalidasF', 1, 1, 1, 0, 1, 'SalidasF', NULL),
(209, 7, 'OCompraF##Form OCompraF', 1, 1, 1, 0, 1, 'OCompraF', NULL),
(210, 1, 'OCompraF##Form OCompraF', 1, 1, 1, 0, 1, 'OCompraF', NULL),
(211, 5, 'FNomAs##Form FNomAs', 1, 1, 1, 0, 1, 'FNomAs', NULL),
(212, 5, 'FLqManoO##Form FLqManoO', 1, 1, 1, 1, 1, 'FLqManoO', NULL),
(213, 5, 'Fnomtec##Form Fnomtec', 1, 1, 1, 0, 1, 'Fnomtec', NULL),
(214, 5, 'FGestion##Form FGestion', 1, 1, 0, 0, 1, 'fgestion', NULL),
(215, 5, 'FSolicitudes##Form FSolicitudes', 1, 0, 0, 0, 1, 'Fsolicitudes', NULL),
(216, 5, 'TDBasicosF##Form TDBasicosF', 1, 0, 0, 0, 1, 'tdBasicosF', NULL),
(217, 4, 'FGestion##Form FGestion', 1, 1, 1, 0, 1, 'fgestion', NULL),
(218, 4, 'FSolicitudes##Form FSolicitudes', 1, 1, 1, 0, 1, 'Fsolicitudes', NULL),
(219, 4, 'TDBasicosF##Form TDBasicosF', 1, 1, 1, 0, 1, 'tdBasicosF', NULL),
(220, 4, 'FGestionM##Form FGestionM', 1, 1, 1, 0, 1, 'FGestionM', NULL),
(221, 8, 'FSolicitudes##Form FSolicitudes', 1, 0, 0, 0, 1, 'Fsolicitudes', NULL),
(222, 8, 'TDBasicosF##Form TDBasicosF', 1, 0, 0, 0, 1, 'tdBasicosF', NULL),
(223, 8, 'FCAMPAÑA##Form FCAMPAÑA', 1, 0, 0, 0, 1, 'FCAMPAÑA', NULL),
(224, 8, 'Facturacion##Form Facturacion', 1, 1, 1, 0, 1, 'Facturacion', NULL),
(225, 8, 'FPedidos##Form FPedidos', 1, 1, 1, 0, 1, 'Fpedidos', NULL),
(226, 8, 'FFacturas##Form FFacturas', 1, 1, 1, 0, 1, 'Ffacturas', NULL),
(227, 8, 'FParametros##Form FParametros', 1, 1, 1, 0, 1, 'Fparametros', NULL),
(228, 8, 'FGestion##Form FGestion', 1, 1, 1, 0, 1, 'fgestion', NULL),
(229, 8, 'FGestionM##Form FGestionM', 1, 1, 1, 0, 1, 'FGestionM', NULL),
(230, 8, 'FNomAs##Form FNomAs', 1, 1, 1, 0, 1, 'FNomAs', NULL),
(231, 8, 'FLqManoO##Form FLqManoO', 1, 1, 1, 1, 1, 'FLqManoO', NULL),
(232, 8, 'Fnomtec##Form Fnomtec', 1, 1, 1, 0, 1, 'Fnomtec', NULL),
(233, 1, 'FAlertas##Form FAlertas', 1, 0, 0, 0, 0, 'fAlertas', NULL),
(234, 1, 'FComSeg##Form FComSeg', 1, 1, 1, 0, 1, 'FComSeg', NULL),
(235, 2, 'FComSeg##Form FComSeg', 1, 1, 1, 0, 1, 'FComSeg', NULL),
(236, 8, 'FComSeg##Form FComSeg', 1, 1, 1, 0, 1, 'FComSeg', NULL),
(237, 4, 'FComSeg##Form FComSeg', 1, 1, 1, 0, 1, 'FComSeg', NULL),
(238, 5, 'FComSeg##Form FComSeg', 1, 1, 1, 0, 1, 'FComSeg', NULL),
(239, 6, 'FComSeg##Form FComSeg', 1, 1, 1, 0, 1, 'FComSeg', NULL),
(240, 7, 'FComSeg##Form FComSeg', 1, 1, 1, 0, 1, 'FComSeg', NULL),
(241, 3, 'FComSeg##Form FComSeg', 1, 1, 1, 0, 1, 'FComSeg', NULL),
(242, 2, 'FAlertas##Form FAlertas', 1, 0, 0, 0, 1, 'Falertas', NULL),
(243, 8, 'FAlertas##Form FAlertas', 1, 0, 0, 0, 1, 'Falertas', NULL),
(244, 1, 'FBOffice\r\nFBOffice#http://FBOffice\r\nFBOffice#', 1, 1, 1, 0, 0, 'FBOffice', NULL),
(245, 2, 'FBOffice\r\nFBOffice#http://FBOffice\r\nFBOffice#', 1, 1, 1, 0, 0, 'FBOffice', NULL),
(246, 8, 'FBOffice\r\nFBOffice#http://FBOffice\r\nFBOffice#', 1, 1, 1, 0, 0, 'FBOffice', NULL),
(247, 1, 'Fanticipos##Form Fanticipos', 1, 1, 1, 0, 0, 'Fanticipos', NULL),
(248, 8, 'Fanticipos##Form Fanticipos', 1, 1, 1, 0, 0, 'Fanticipos', NULL),
(249, 3, 'Fanticipos##Form Fanticipos', 1, 1, 1, 0, 0, 'Fanticipos', NULL),
(250, 5, 'Fanticipos##Form Fanticipos', 1, 1, 1, 0, 0, 'Fanticipos', NULL),
(251, 8, 'FVales##Form FVales', 1, 1, 1, 0, 1, 'Fvales', NULL),
(252, 3, 'FVales##Form FVales', 1, 1, 1, 0, 1, 'Fvales', NULL),
(253, 1, 'FManoO##Form FManoO', 1, 1, 1, 0, 1, 'FManoO', NULL),
(254, 8, 'FManoO##Form FManoO', 1, 1, 1, 0, 1, 'FManoO', NULL),
(255, 1, 'FImportar##Form FImportar', 1, 1, 1, 0, 1, 'Fimportar', NULL),
(256, 2, 'FImportar##Form FImportar', 1, 1, 1, 0, 1, 'Fimportar', NULL),
(258, 2, 'FInformes##Form FInformes', 1, 1, 1, 0, 1, 'Finformes', NULL),
(259, 1, 'FAlertasPQ##Form FAlertasPQ', 1, 1, 1, 0, 1, 'FAlertasPQ', NULL),
(260, 2, 'FAlertasPQ##', 1, 1, 1, 0, 1, 'FAlertasPQ', NULL),
(261, 1, 'FRenta##Form FRenta', 1, 1, 1, 0, 1, 'Frenta', NULL),
(262, 4, 'FRenta##Form FRenta', 1, 1, 1, 0, 1, 'Frenta', NULL),
(263, 8, 'FRenta##Form FRenta', 1, 1, 1, 0, 1, 'Frenta', NULL),
(264, 8, 'FMasObra##Form FMasObra', 1, 1, 1, 0, 1, 'FMasObra', NULL),
(265, 8, 'FObras##Form FObras', 1, 1, 1, 0, 1, 'Fobras', NULL),
(266, 8, 'TDBasicosF##Form TDBasicosF', 1, 1, 1, 0, 1, 'tdBasicosF', NULL),
(267, 1, 'FInformes##Form FInformes', 1, 1, 1, 0, 1, 'finformes', NULL),
(269, 3, 'FInformes##Form FInformes', 1, 1, 1, 0, 1, 'finformes', NULL),
(270, 8, 'FInformes##Form FInformes', 1, 1, 1, 0, 1, 'finformes', NULL),
(271, 3, 'FInformes##Form FInformes', 1, 1, 1, 0, 1, 'finformes', NULL),
(272, 4, 'FInformes##Form FInformes', 1, 1, 1, 0, 1, 'finformes', NULL),
(275, 2, 'FArchivo##Form FArchivo', 1, 1, 1, 0, 1, 'Farchivo', NULL),
(276, 6, 'FArchivo##Form FArchivo', 1, 1, 1, 0, 1, 'Farchivo', NULL),
(277, 4, 'FArchivo##Form FArchivo', 1, 1, 1, 0, 1, 'Farchivo', NULL),
(278, 8, 'FArchivo##Form FArchivo', 1, 1, 1, 0, 1, 'Farchivo', NULL),
(279, 1, 'FArchivo##Form FArchivo', 1, 1, 1, 0, 1, 'Farchivo', NULL),
(281, 3, 'FArchivo##Form FArchivo', 1, 1, 1, 0, 1, 'Farchivo', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ap_solicitud`
--

CREATE TABLE `ap_solicitud` (
  `id_sol` int(11) NOT NULL,
  `poliza_sol` double DEFAULT NULL,
  `demanda_sol` decimal(18,0) DEFAULT '0',
  `asesor_sol` int(11) DEFAULT NULL,
  `archivos_sol` int(11) DEFAULT NULL,
  `asignacion_sol` int(11) DEFAULT NULL,
  `comis_gas_sol` decimal(18,6) DEFAULT '0.000000',
  `comis_obra_sol` decimal(18,6) DEFAULT '0.000000',
  `comis_fija_sol` decimal(19,4) DEFAULT NULL,
  `cedula_sol` double DEFAULT NULL,
  `nombre_sol` varchar(255) NOT NULL,
  `direccion_pol_sol` varchar(255) DEFAULT NULL,
  `direccion_nueva_sol` varchar(255) DEFAULT NULL,
  `barrio_sol` int(50) DEFAULT NULL,
  `telefono1_sol` varchar(50) DEFAULT NULL,
  `telefono2_sol` varchar(50) DEFAULT NULL,
  `celular_sol` varchar(50) DEFAULT NULL,
  `email_sol` varchar(80) DEFAULT NULL,
  `servicio_sol` varchar(100) NOT NULL,
  `texto_sol` varchar(80) DEFAULT 'Inscripcion CI',
  `fecha_reg_sol` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `obs_sol` varchar(255) DEFAULT NULL,
  `estado_sol` int(11) DEFAULT NULL,
  `fecha_prevista_sol` datetime DEFAULT NULL,
  `user_preventa_sol` varchar(50) DEFAULT NULL,
  `fecha_visita_comerc_sol` datetime DEFAULT NULL,
  `obs_estado_sol` varchar(255) DEFAULT NULL,
  `tipo_clientegn_sol` int(11) DEFAULT NULL,
  `forma_pagogn_sol` int(11) DEFAULT NULL,
  `localidad_sol` int(11) NOT NULL,
  `eliminar` int(11) NOT NULL,
  `consecutivo_cot` varchar(20) NOT NULL,
  `estrato_cot` int(11) NOT NULL,
  `fecha_nac_cot` date NOT NULL,
  `forma_pago_cot` int(11) NOT NULL,
  `campana_cot` int(11) NOT NULL,
  `tipo_cliente_cot` int(11) NOT NULL,
  `fecha_cot` date NOT NULL,
  `v_total_cot` decimal(10,0) NOT NULL,
  `v_contado_cot` decimal(10,0) NOT NULL,
  `estado_cot` int(11) NOT NULL,
  `obs_cot` varchar(250) NOT NULL,
  `pagare_cot` varchar(20) NOT NULL,
  `not_cliente_cot` tinyint(4) NOT NULL,
  `fecha_not_cot` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ap_solicitud`
--

INSERT INTO `ap_solicitud` (`id_sol`, `poliza_sol`, `demanda_sol`, `asesor_sol`, `archivos_sol`, `asignacion_sol`, `comis_gas_sol`, `comis_obra_sol`, `comis_fija_sol`, `cedula_sol`, `nombre_sol`, `direccion_pol_sol`, `direccion_nueva_sol`, `barrio_sol`, `telefono1_sol`, `telefono2_sol`, `celular_sol`, `email_sol`, `servicio_sol`, `texto_sol`, `fecha_reg_sol`, `obs_sol`, `estado_sol`, `fecha_prevista_sol`, `user_preventa_sol`, `fecha_visita_comerc_sol`, `obs_estado_sol`, `tipo_clientegn_sol`, `forma_pagogn_sol`, `localidad_sol`, `eliminar`, `consecutivo_cot`, `estrato_cot`, `fecha_nac_cot`, `forma_pago_cot`, `campana_cot`, `tipo_cliente_cot`, `fecha_cot`, `v_total_cot`, `v_contado_cot`, `estado_cot`, `obs_cot`, `pagare_cot`, `not_cliente_cot`, `fecha_not_cot`) VALUES
(67, NULL, NULL, 7, NULL, 1, '0.000000', '0.000000', NULL, 12314421, 'JUAN', 'CAsa blanca', 'bosa la nuevaaaaa1212', 127, '12344', '12344', '', 'juan@a', 'instalacion de calentador', 'Inscripcion CI', '2018-03-29 00:10:10', '', 2, '2018-03-28 23:12:00', NULL, '2019-03-30 12:00:00', NULL, 10, NULL, 4, 0, '', 0, '0000-00-00', 0, 0, 0, '0000-00-00', '0', '0', 0, '', '', 0, '0000-00-00'),
(66, NULL, NULL, 11, NULL, 1, '0.000000', '0.000000', NULL, 12, 'carlos', 'calle', 'calle local', 1, '44493762', '1', '3007584458', '1@12', '123CASADAADS', 'Inscripcion CI', '2018-03-28 23:12:58', '', 2, NULL, NULL, '2018-03-28 01:12:00', NULL, 1, NULL, 5, 0, '', 0, '0000-00-00', 0, 0, 0, '0000-00-00', '0', '0', 0, '', '', 0, '0000-00-00'),
(65, 12, NULL, 8, NULL, 2, '0.000000', '0.000000', NULL, 2, 'PRUEBA3', '21', 'calle l', 1, '12', '12', '21', '12@12', '12', 'Inscripcion CI', '2018-03-28 23:12:09', '', 2, NULL, NULL, '2018-03-28 22:12:00', NULL, NULL, NULL, 1, 0, '12', 31, '2018-04-12', 0, 0, 0, '2018-04-14', '0', '0', 0, '', '', 0, '0000-00-00'),
(64, 1, '1', 9, NULL, 3, '0.000000', '0.000000', NULL, 79524654, 'carlos lozano', 'calle 6a #89-47', 'casa tintala', 1, '4493762', '4493762', '3007584458', 'carlos.lozano@gmail.com', 'casa', 'Inscripcion CI', '2018-03-28 22:40:35', '', NULL, '2018-03-29 00:00:00', NULL, '2019-03-29 00:00:00', NULL, NULL, NULL, 1, 0, '', 0, '0000-00-00', 0, 0, 0, '0000-00-00', '0', '0', 0, '', '', 0, '0000-00-00'),
(68, 321, NULL, 10, NULL, 11, '0.000000', '0.000000', NULL, 4324234, 'testingss234234', 'calle 20', 'calle 20', 1, '3424234', '3424234', '423423', 'govar@gmail.com', 'gaz', 'Inscripcion CI', '2018-04-06 01:15:24', 'GG', 2, '2018-04-09 14:11:00', NULL, '2018-04-09 14:11:00', NULL, NULL, NULL, 5, 0, '12', 32, '2018-04-14', 0, 0, 0, '2018-04-13', '0', '0', 0, '', '', 0, '0000-00-00'),
(69, NULL, '0', NULL, NULL, NULL, '0.000000', '0.000000', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 'Inscripcion CI', '2018-04-13 22:21:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '12', 1, '2018-04-27', 0, 0, 0, '2018-04-19', '0', '0', 54, '', '', 0, '0000-00-00'),
(70, NULL, '0', NULL, NULL, NULL, '0.000000', '0.000000', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 'Inscripcion CI', '2018-04-13 22:22:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '3', 3, '2018-04-13', 0, 0, 0, '2018-04-13', '0', '0', 54, '', '', 0, '0000-00-00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ap_terceros`
--

CREATE TABLE `ap_terceros` (
  `Id_tercero` int(11) NOT NULL,
  `nombre_tercero` varchar(80) DEFAULT NULL,
  `nit_tercero` varchar(80) DEFAULT NULL,
  `telefono1_tercero` varchar(50) DEFAULT NULL,
  `telefono2_tercero` varchar(80) DEFAULT NULL,
  `fax_tercero` varchar(50) DEFAULT NULL,
  `direccion_tercero` varchar(255) DEFAULT NULL,
  `e_mail_tercero` text,
  `usuario` varchar(20) DEFAULT NULL,
  `password` text,
  `tipo_tercero` int(11) DEFAULT NULL,
  `gran_contrib_tercero` int(11) DEFAULT NULL,
  `autoretenedor_tercero` int(11) DEFAULT NULL,
  `reg_comun_tercero` int(11) DEFAULT '0',
  `photo` text,
  `intentos` int(11) DEFAULT NULL,
  `Contacto_tercero` varchar(80) DEFAULT NULL,
  `activo_tercero` tinyint(1) DEFAULT NULL,
  `tercero_ registrado_por` varchar(50) DEFAULT NULL,
  `responsable_materiales_tercero` tinyint(1) DEFAULT '0',
  `grupo_nomina_tercero` int(11) DEFAULT NULL,
  `tercero_ lider_Obra` int(11) DEFAULT NULL,
  `tercero_nombre_lider` varchar(255) DEFAULT NULL,
  `empresa_tercero` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ap_terceros`
--

INSERT INTO `ap_terceros` (`Id_tercero`, `nombre_tercero`, `nit_tercero`, `telefono1_tercero`, `telefono2_tercero`, `fax_tercero`, `direccion_tercero`, `e_mail_tercero`, `usuario`, `password`, `tipo_tercero`, `gran_contrib_tercero`, `autoretenedor_tercero`, `reg_comun_tercero`, `photo`, `intentos`, `Contacto_tercero`, `activo_tercero`, `tercero_ registrado_por`, `responsable_materiales_tercero`, `grupo_nomina_tercero`, `tercero_ lider_Obra`, `tercero_nombre_lider`, `empresa_tercero`) VALUES
(7, 'testing', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(8, 'Gio Admin', '1016094120', '3203424581', '3133615158', '011111111111', 'calle 02 a', 'govaw22@gmail.com', 'gio', '$2a$07$asxx54ahjppf45sd87a5auhqpCc/iROa9LyLsEYdiDfgjoMxMuEkG', 1, 1, 1, 1, 'views/images/photo.jpg', 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(9, 'gioAsesor', '1016094120', '3203424581', '3133615158', '012154545478', 'calle 20 a # 96 c 52', 'govaw22@gmail.com', 'gioAsesor', '$2a$07$asxx54ahjppf45sd87a5auhqpCc/iROa9LyLsEYdiDfgjoMxMuEkG', 3, 1, 1, 1, 'views/images/photo.jpg', 2, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(10, 'gioAnalista', '1016094120', '3203424581', '3133615158', '011111111111', 'calle 20 a # 96 c 52', 'govaw22@gmail.com', 'gioAnalista', '$2a$07$asxx54ahjppf45sd87a5auhqpCc/iROa9LyLsEYdiDfgjoMxMuEkG', 2, 1, 1, 1, 'views/images/photo.jpg', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(11, 'gioTecnico', '1016094120', '3203424581', '3133615158', '011111111111', 'calle 20 a # 96 c 52', 'govaw22@gmail.com', 'gioTecnico', '$2a$07$asxx54ahjppf45sd87a5auhqpCc/iROa9LyLsEYdiDfgjoMxMuEkG', 4, 1, 1, 1, 'views/images/photo.jpg', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(12, 'TestV2', '1016094120', '3203424581', '3133615158', '012154545478', 'calle 20 a # 96 c 52', 'govaw22@gmail.com', 'testv2', '$2a$07$asxx54ahjppf45sd87a5auGgNvJdy01E9BfRy2V0JuYAVOuP.p3p.', 4, 1, 1, 1, 'views/images/photo.jpg', 2, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(13, 'TestV3', '1016094120', '3203424581', '3133615158', '012154545478', 'calle 20 a # 96 c 52', 'govaw22@gmail.com', 'Testv3', '$2a$07$asxx54ahjppf45sd87a5audjuNLZpiad8K/u8JtTcWtPBNJt2m/DS', 4, 1, 1, 1, 'views/images/photo.jpg', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(14, 'TestV4', '1016094120', '3203424581', '3133615158', '012154545478', 'calle 20 a # 96 c 52', 'govaw22@gmail.com', 'giotest1', '$2a$07$asxx54ahjppf45sd87a5auhqpCc/iROa9LyLsEYdiDfgjoMxMuEkG', 4, 1, 1, 1, 'views/images/photo.jpg', 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ap_tipo_cliente`
--

CREATE TABLE `ap_tipo_cliente` (
  `id_tipo_cliente` int(11) NOT NULL,
  `nombre_tipo_cliente` varchar(50) DEFAULT NULL,
  `detalle_tipo_cliente` varchar(80) DEFAULT NULL,
  `activo_tipo_cliente` tinyint(1) DEFAULT '0',
  `empresa_tipo_cliente` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ap_tipo_cliente`
--

INSERT INTO `ap_tipo_cliente` (`id_tipo_cliente`, `nombre_tipo_cliente`, `detalle_tipo_cliente`, `activo_tipo_cliente`, `empresa_tipo_cliente`) VALUES
(1, 'INCREMENTO', NULL, 0, NULL),
(2, 'CLIENTE NUEVO RESID', NULL, 0, NULL),
(3, 'COMERCIAL C1', NULL, 0, NULL),
(4, 'COMERCIAL C2', NULL, 0, NULL),
(5, 'COMERCIAL C3', NULL, 0, NULL),
(6, 'SERVIGAS', NULL, 0, NULL),
(7, 'MANT CAMPAÑA', NULL, 0, NULL),
(8, 'VISITA EASY', NULL, 0, NULL),
(9, 'REPARACIONES', NULL, 0, NULL),
(10, 'CERTIFICACIONES', NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ap_tipo_inv`
--

CREATE TABLE `ap_tipo_inv` (
  `id_tipo_inv` int(11) NOT NULL,
  `nombre_tipo_inv` varchar(50) NOT NULL,
  `venta_tipo_inv` tinyint(1) DEFAULT NULL,
  `activo_tipo_inv` tinyint(1) DEFAULT '1',
  `global_tipo_inv` int(11) DEFAULT NULL,
  `grupo_tipo_inv` varchar(80) DEFAULT NULL,
  `empresa_tipo_inv` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ap_tipo_inv`
--

INSERT INTO `ap_tipo_inv` (`id_tipo_inv`, `nombre_tipo_inv`, `venta_tipo_inv`, `activo_tipo_inv`, `global_tipo_inv`, `grupo_tipo_inv`, `empresa_tipo_inv`) VALUES
(1, 'Contadores', 1, 1, 1, 'Instalacion', NULL),
(2, 'Accesorios', 0, 1, 5, 'Instalacion', NULL),
(4, 'Tuberia', 0, 1, 2, 'Instalacion', NULL),
(5, 'Calentadores', 1, 1, 1, 'Gasodomestico', NULL),
(6, 'Obra civil', 1, 1, 5, 'Instalacion', NULL),
(7, 'Estufas', 1, 1, 1, 'Gasodomestico', NULL),
(8, 'Servigas', 0, 1, 5, 'Gasodomestico', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ap_tipo_tercero`
--

CREATE TABLE `ap_tipo_tercero` (
  `id_tipo_tercero` int(11) NOT NULL,
  `nombre_tipo_ter` varchar(50) NOT NULL,
  `descripcion_tipo_ter` longtext,
  `Grupo_tipo_ter` varchar(255) NOT NULL,
  `tipo_activo` tinyint(1) DEFAULT '0',
  `empresa_tipo_ter` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ap_tipo_tercero`
--

INSERT INTO `ap_tipo_tercero` (`id_tipo_tercero`, `nombre_tipo_ter`, `descripcion_tipo_ter`, `Grupo_tipo_ter`, `tipo_activo`, `empresa_tipo_ter`) VALUES
(1, 'Instalador', NULL, 'PERSONA', 0, NULL),
(2, 'Empleado', NULL, 'PERSONA', 0, NULL),
(3, 'Proveedor', NULL, 'empresa', 0, NULL),
(4, 'asesor comercial', NULL, 'PERSONA', 0, NULL),
(5, 'Cont Acometidas', NULL, 'empresa', 0, NULL),
(6, 'Interventor', NULL, 'empresa', 0, NULL),
(7, 'Gestor Tecnico', NULL, 'PERSONA', 0, NULL),
(8, 'Gestor Comercial', NULL, 'PERSONA', 0, NULL);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `cotizacion`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `cotizacion` (
`sol_cot` int(11)
,`consecutivo_cot` varchar(20)
,`estrato_cot` int(11)
,`asignacion_sol` int(11)
,`asesor_sol` int(11)
,`nombre_sol` varchar(255)
,`servicio_sol` varchar(100)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `criterios`
--

CREATE TABLE `criterios` (
  `Id_cri` int(11) NOT NULL,
  `criterio` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `demanda`
--

CREATE TABLE `demanda` (
  `origen_dem` varchar(30) NOT NULL,
  `tipo_cliente_dem` varchar(30) NOT NULL,
  `fecha_llamada` date NOT NULL,
  `cod_dem` int(11) NOT NULL,
  `poliza_dem` int(11) NOT NULL,
  `usuario_captura` varchar(30) NOT NULL,
  `campana_demanda` varchar(40) NOT NULL,
  `chip_natural` varchar(20) NOT NULL,
  `estado_predio` varchar(20) NOT NULL,
  `tipo_predio` varchar(20) NOT NULL,
  `uso` varchar(30) NOT NULL,
  `mecado` varchar(30) NOT NULL,
  `nombre_cliente` varchar(40) NOT NULL,
  `num_doc` varchar(20) NOT NULL,
  `direccion` varchar(30) NOT NULL,
  `municipio` varchar(30) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `cod_trabajo_original` int(11) NOT NULL,
  `fecha_trab_dem` date NOT NULL,
  `cod_ult_visit` int(11) NOT NULL,
  `res_ult_vis` varchar(10) NOT NULL,
  `fecha_ult_visita` date NOT NULL,
  `usu_asig_primer_trab` varchar(30) NOT NULL,
  `fecha_prim_visit` date NOT NULL,
  `respuesta_pv` varchar(30) NOT NULL,
  `fecha_cap_primera_visita` date NOT NULL,
  `cod_contratista` varchar(20) NOT NULL,
  `nom_cont` varchar(30) NOT NULL,
  `distrito` int(11) NOT NULL,
  `malla` int(11) NOT NULL,
  `sector` int(11) NOT NULL,
  `descr_estado_dem` varchar(30) NOT NULL,
  `estrato` int(11) NOT NULL,
  `clase_dem` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `demanda`
--

INSERT INTO `demanda` (`origen_dem`, `tipo_cliente_dem`, `fecha_llamada`, `cod_dem`, `poliza_dem`, `usuario_captura`, `campana_demanda`, `chip_natural`, `estado_predio`, `tipo_predio`, `uso`, `mecado`, `nombre_cliente`, `num_doc`, `direccion`, `municipio`, `telefono`, `cod_trabajo_original`, `fecha_trab_dem`, `cod_ult_visit`, `res_ult_vis`, `fecha_ult_visita`, `usu_asig_primer_trab`, `fecha_prim_visit`, `respuesta_pv`, `fecha_cap_primera_visita`, `cod_contratista`, `nom_cont`, `distrito`, `malla`, `sector`, `descr_estado_dem`, `estrato`, `clase_dem`) VALUES
('CONTACT CENTER', 'NUEVO', '0000-00-00', 763559, 0, 'CT_AROZO', '346CLIENTE NUEVO INTERNA', '', 'POTENCIAL', '', 'DESCONOCIDO', '', 'MIRIAM BELTRAN ', '51864527', 'CL 58 BIS 5', 'BOGOTA', '2155328', 3334088, '0000-00-00', 2, 'B4', '0000-00-00', 'CT_AROZO', '0000-00-00', 'B3', '0000-00-00', 'I00607', 'WILSON TOLEDO SAGANOME', 2, 155, 955, 'EN GESTION CONTACTADA', 4, 'CONSTRUIR INTERNA'),
('CONTACT CENTER', 'NUEVO', '0000-00-00', 763434, 0, 'ML_IRODRIGUEZ', '346CLIENTE NUEVO INTERNA', '', 'POTENCIAL', '', 'DESCONOCIDO', '', 'CAROLINA ROMERO ', '52352190', 'DG  72 1 ESTE 52 EDI  402', 'BOGOTA', '3015382051', 3332956, '0000-00-00', 2, 'B4', '0000-00-00', 'ML_IRODRIGUEZ', '0000-00-00', 'B3', '0000-00-00', 'I00607', 'WILSON TOLEDO SAGANOME', 2, 144, 944, 'EN GESTION CONTACTADA', 6, 'HABILITAR INTERNA'),
('CONTACT CENTER', 'NUEVO', '0000-00-00', 763440, 0, 'ML_IRODRIGUEZ', '346CLIENTE NUEVO INTERNA', '', 'POTENCIAL', '', 'DESCONOCIDO', '', 'JUAN BENDALLO ', '79878362', 'KR 11 61 45', 'BOGOTA', '3102643555', 3332980, '0000-00-00', 2, 'B4', '0000-00-00', 'ML_IRODRIGUEZ', '0000-00-00', 'B3', '0000-00-00', 'I00607', 'WILSON TOLEDO SAGANOME', 2, 155, 955, 'EN GESTION CONTACTADA', 3, 'CONSTRUIR INTERNA'),
('CONTACT CENTER', 'NUEVO', '0000-00-00', 763438, 0, 'CT_AROZO', '346CLIENTE NUEVO INTERNA', '', 'POTENCIAL', '', 'DESCONOCIDO', '', 'JHON GONZALES ', '7545973', 'CL 70 69 16', 'BOGOTA', '3123047128', 3332968, '0000-00-00', 2, 'B4', '0000-00-00', 'CT_AROZO', '0000-00-00', 'B3', '0000-00-00', 'I00607', 'WILSON TOLEDO SAGANOME', 5, 137, 937, 'EN GESTION CONTACTADA', 3, 'CONSTRUIR INTERNA'),
('CONTACT CENTER', 'NUEVO', '0000-00-00', 763410, 0, 'ML_JBAENA', '346CLIENTE NUEVO INTERNA', '', 'POTENCIAL', '', 'DESCONOCIDO', '', 'MARIA ROJAS ', '518711963', 'KR 62 74A 14 1 1', 'BOGOTA', '8127045/3209775822', 3332775, '0000-00-00', 2, 'B4', '0000-00-00', 'ML_JBAENA', '0000-00-00', 'B3', '0000-00-00', 'I00607', 'WILSON TOLEDO SAGANOME', 2, 142, 942, 'EN GESTION CONTACTADA', 3, 'CONSTRUIR INTERNA'),
('CONTACT CENTER', 'NUEVO', '0000-00-00', 763418, 0, 'ML_JBAENA', '346CLIENTE NUEVO INTERNA', '', 'POTENCIAL', '', 'DESCONOCIDO', '', 'JENY ARDILA ', '52958582', 'CL 51 13 44 LOC 1 1', 'BOGOTA', '3046570153', 3332909, '0000-00-00', 2, 'B4', '0000-00-00', 'ML_JBAENA', '0000-00-00', 'B3', '0000-00-00', 'I00607', 'WILSON TOLEDO SAGANOME', 2, 155, 955, 'EN GESTION CONTACTADA', 2, 'CONSTRUIR INTERNA'),
('CONTACT CENTER', 'NUEVO', '0000-00-00', 763452, 0, 'CT_GVALENZUELA', '346CLIENTE NUEVO INTERNA', '', 'POTENCIAL', '', 'DESCONOCIDO', '', 'CLAUDIA RANGEL PERILLA', '63325356', 'KR 74B 64F 96', 'BOGOTA', '3132637242', 3333011, '0000-00-00', 2, 'B4', '0000-00-00', 'CT_GVALENZUELA', '0000-00-00', 'B3', '0000-00-00', 'I00607', 'WILSON TOLEDO SAGANOME', 5, 138, 938, 'EN GESTION CONTACTADA', 3, 'CONSTRUIR INTERNA'),
('CONTACT CENTER', 'NUEVO', '0000-00-00', 763559, 0, 'CT_AROZO', '346CLIENTE NUEVO INTERNA', '', 'POTENCIAL', '', 'DESCONOCIDO', '', 'MIRIAM BELTRAN ', '51864527', 'CL 58 BIS 5', 'BOGOTA', '2155328', 3334088, '0000-00-00', 2, 'B4', '0000-00-00', 'CT_AROZO', '0000-00-00', 'B3', '0000-00-00', 'I00607', 'WILSON TOLEDO SAGANOME', 2, 155, 955, 'EN GESTION CONTACTADA', 4, 'CONSTRUIR INTERNA'),
('CONTACT CENTER', 'NUEVO', '0000-00-00', 763434, 0, 'ML_IRODRIGUEZ', '346CLIENTE NUEVO INTERNA', '', 'POTENCIAL', '', 'DESCONOCIDO', '', 'CAROLINA ROMERO ', '52352190', 'DG  72 1 ESTE 52 EDI  402', 'BOGOTA', '3015382051', 3332956, '0000-00-00', 2, 'B4', '0000-00-00', 'ML_IRODRIGUEZ', '0000-00-00', 'B3', '0000-00-00', 'I00607', 'WILSON TOLEDO SAGANOME', 2, 144, 944, 'EN GESTION CONTACTADA', 6, 'HABILITAR INTERNA'),
('CONTACT CENTER', 'NUEVO', '0000-00-00', 763440, 0, 'ML_IRODRIGUEZ', '346CLIENTE NUEVO INTERNA', '', 'POTENCIAL', '', 'DESCONOCIDO', '', 'JUAN BENDALLO ', '79878362', 'KR 11 61 45', 'BOGOTA', '3102643555', 3332980, '0000-00-00', 2, 'B4', '0000-00-00', 'ML_IRODRIGUEZ', '0000-00-00', 'B3', '0000-00-00', 'I00607', 'WILSON TOLEDO SAGANOME', 2, 155, 955, 'EN GESTION CONTACTADA', 3, 'CONSTRUIR INTERNA'),
('CONTACT CENTER', 'NUEVO', '0000-00-00', 763438, 0, 'CT_AROZO', '346CLIENTE NUEVO INTERNA', '', 'POTENCIAL', '', 'DESCONOCIDO', '', 'JHON GONZALES ', '7545973', 'CL 70 69 16', 'BOGOTA', '3123047128', 3332968, '0000-00-00', 2, 'B4', '0000-00-00', 'CT_AROZO', '0000-00-00', 'B3', '0000-00-00', 'I00607', 'WILSON TOLEDO SAGANOME', 5, 137, 937, 'EN GESTION CONTACTADA', 3, 'CONSTRUIR INTERNA'),
('CONTACT CENTER', 'NUEVO', '0000-00-00', 763410, 0, 'ML_JBAENA', '346CLIENTE NUEVO INTERNA', '', 'POTENCIAL', '', 'DESCONOCIDO', '', 'MARIA ROJAS ', '518711963', 'KR 62 74A 14 1 1', 'BOGOTA', '8127045/3209775822', 3332775, '0000-00-00', 2, 'B4', '0000-00-00', 'ML_JBAENA', '0000-00-00', 'B3', '0000-00-00', 'I00607', 'WILSON TOLEDO SAGANOME', 2, 142, 942, 'EN GESTION CONTACTADA', 3, 'CONSTRUIR INTERNA'),
('CONTACT CENTER', 'NUEVO', '0000-00-00', 763418, 0, 'ML_JBAENA', '346CLIENTE NUEVO INTERNA', '', 'POTENCIAL', '', 'DESCONOCIDO', '', 'JENY ARDILA ', '52958582', 'CL 51 13 44 LOC 1 1', 'BOGOTA', '3046570153', 3332909, '0000-00-00', 2, 'B4', '0000-00-00', 'ML_JBAENA', '0000-00-00', 'B3', '0000-00-00', 'I00607', 'WILSON TOLEDO SAGANOME', 2, 155, 955, 'EN GESTION CONTACTADA', 2, 'CONSTRUIR INTERNA'),
('CONTACT CENTER', 'NUEVO', '0000-00-00', 763452, 0, 'CT_GVALENZUELA', '346CLIENTE NUEVO INTERNA', '', 'POTENCIAL', '', 'DESCONOCIDO', '', 'CLAUDIA RANGEL PERILLA', '63325356', 'KR 74B 64F 96', 'BOGOTA', '3132637242', 3333011, '0000-00-00', 2, 'B4', '0000-00-00', 'CT_GVALENZUELA', '0000-00-00', 'B3', '0000-00-00', 'I00607', 'WILSON TOLEDO SAGANOME', 5, 138, 938, 'EN GESTION CONTACTADA', 3, 'CONSTRUIR INTERNA');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `demanda_sin_sol`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `demanda_sin_sol` (
`origen_dem` varchar(30)
,`observacion` varchar(101)
,`fecha_llamada` date
,`cod_dem` int(11)
,`poliza_dem` int(11)
,`usuario_captura` varchar(30)
,`campana_demanda` varchar(40)
,`chip_natural` varchar(20)
,`estado_predio` varchar(20)
,`tipo_predio` varchar(20)
,`mecado` varchar(30)
,`nombre_cliente` varchar(40)
,`num_doc` varchar(20)
,`direccion` varchar(30)
,`municipio` varchar(30)
,`telefono` varchar(20)
,`cod_trabajo_original` int(11)
,`cod_ult_visit` int(11)
,`res_ult_vis` varchar(10)
,`fecha_ult_visita` date
,`usu_asig_primer_trab` varchar(30)
,`fecha_prim_visit` date
,`respuesta_pv` varchar(30)
,`fecha_cap_primera_visita` date
,`cod_contratista` varchar(20)
,`nom_cont` varchar(30)
,`distrito` int(11)
,`malla` int(11)
,`sector` int(11)
,`descr_estado_dem` varchar(30)
,`estrato` int(11)
,`clase_dem` varchar(30)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `siax_campana`
--

CREATE TABLE `siax_campana` (
  `id_campana` int(11) NOT NULL,
  `nombre_campana` varchar(50) NOT NULL,
  `descuente_campana` decimal(18,6) DEFAULT '0.000000',
  `desc_financ_campana` decimal(18,6) DEFAULT '0.000000',
  `plazo_max_campana` int(11) DEFAULT NULL,
  `detalle_campana` longtext,
  `aplicacion_campana` longtext,
  `desde_campana` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hasta_campana` datetime DEFAULT NULL,
  `vigente_campana` tinyint(1) DEFAULT '1',
  `tasa_campana` decimal(18,6) DEFAULT '0.000000',
  `descuento_fijo_campana` decimal(19,4) DEFAULT '0.0000',
  `manto_max_campana` decimal(19,4) DEFAULT NULL,
  `condiciones_campana` longtext
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `siax_campana`
--

INSERT INTO `siax_campana` (`id_campana`, `nombre_campana`, `descuente_campana`, `desc_financ_campana`, `plazo_max_campana`, `detalle_campana`, `aplicacion_campana`, `desde_campana`, `hasta_campana`, `vigente_campana`, `tasa_campana`, `descuento_fijo_campana`, `manto_max_campana`, `condiciones_campana`) VALUES
(6, 'CONTADO SE RADICA', '0.000000', '0.000000', NULL, NULL, 'CALENTADOR', '2012-01-13 05:00:00', NULL, 1, '0.022100', '0.0000', NULL, NULL),
(7, 'CONTADO NO SE RADICA', '0.000000', '0.000000', NULL, NULL, 'CAL ESTUFA PTO', '2012-01-13 05:00:00', NULL, 1, '0.022100', '0.0000', NULL, NULL),
(13, 'COMERCIAL CONTADO', '0.000000', '0.000000', NULL, NULL, 'MEDIDOR NUEVO', '2012-01-13 05:00:00', NULL, 1, '0.022100', '0.0000', NULL, NULL),
(28, 'CALENTADORES SS', '0.080000', '0.030000', 36, 'PREAPROBADO ESTRATO 1,2,3 $931500                              PREAPROBADO ESTRATO 4,5,6 $1269000', 'TODOS LOS CALENTADORES', '2014-04-02 05:00:00', '2015-02-28 00:00:00', 1, '0.015260', '0.0000', NULL, NULL),
(30, 'CALENTADORES C,S', '0.080000', '0.000000', 48, 'PREAPROBADO 1,2,3 $914,300                                             PERAPROBADO 4,5,6 $1,245,500', 'CALENTADORES', '2014-04-02 05:00:00', '2015-02-28 00:00:00', 1, '0.022100', '0.0000', NULL, NULL),
(33, 'CALEFACTORES S,S', '0.060000', '0.000000', 60, 'PREAPROBADO 1,2,3 $1,415,100                                          PREAPROBADO 4,5,6 $4,250,600', 'CALEFACTORES', '2014-04-02 05:00:00', '2015-02-28 00:00:00', 1, '0.022100', '0.0000', NULL, NULL),
(34, 'CALEFACTORES C,S', '0.040000', '0.000000', 60, 'PREAPROBADO 1,2,3 $1,388,400                                       PREAPROBADO 4,5,6 4 $4,170,400', 'CALEFACTORES', '2014-04-02 05:00:00', '2015-02-28 00:00:00', 1, '0.021800', '0.0000', NULL, NULL),
(35, 'SECADORAS S,S', '0.060000', '0.000000', 60, 'PREAPROBADO TODOS LOS  ESTRATOS $3,116,400', 'SECADORAS', '2014-04-02 05:00:00', '2015-02-28 00:00:00', 1, '0.022100', '0.0000', NULL, NULL),
(36, 'SECADORAS C,S', '0.040000', '0.000000', 60, 'PREAPROBADOS PARA TODOS LOS ESTRATOS $3,057,600', 'SECADORAS', '2014-04-02 05:00:00', '2015-02-28 00:00:00', 1, '0.022100', '0.0000', NULL, NULL),
(37, 'HORNOS Y OTROS S,S', '0.090000', '0.000000', 36, 'PREAPROBADO PARA TODOS LOS ESTRATOS $1,220,800', 'HORNOS Y OTROS', '2014-04-02 05:00:00', '2015-02-28 00:00:00', 1, '0.022100', '0.0000', NULL, NULL),
(40, 'HORNOS Y OTROS C,S', '0.060000', '0.000000', 48, 'PREAPROBADO PARA TODOS LOS ESTRATOS $1,187,200', 'HORNOS Y OTROS', '2014-04-02 05:00:00', '2015-02-28 00:00:00', 1, '0.022100', '0.0000', NULL, NULL),
(41, 'DOS ARTEFACTOS S,S', '0.060000', '0.000000', 36, 'PREAPROBADO PARA TODOS LOS ESTRATOS $2,533,400', 'DOS ARTEFACTOS', '2014-04-02 05:00:00', '2015-02-28 00:00:00', 1, '0.022100', '0.0000', NULL, NULL),
(42, 'DOS ARTEFACTOS C,S', '0.030000', '0.000000', 48, 'PREAPROBADO TODOS LOS ESTRATOS $2,461,700', 'DOS ARTEFACTOS', '2014-04-02 05:00:00', '2015-02-28 00:00:00', 1, '0.022100', '0.0000', NULL, NULL),
(43, 'SUSTITUCION ESTUFAS S,S', '0.110000', '0.000000', 36, 'PREAPROBADOS TODOS LOS ESTRATOS $1,345,300', 'SUSTITUCION ESTUFAS', '2014-04-02 05:00:00', '2015-02-28 00:00:00', 1, '0.022100', '0.0000', NULL, NULL),
(44, 'SUSTITUCION ESTUFAS C,S', '0.070000', '0.000000', 48, 'PREAPROBADO TODOS LOS ESTRATOS $1,296,800', 'SUSTITUCION ESTUFAS', '2014-04-02 05:00:00', '2015-02-28 00:00:00', 1, '0.022100', '0.0000', NULL, NULL),
(45, 'CLIENTE NUEVO CALEFACTOR O CHIMENEA', '0.060000', '0.000000', 60, 'PREAPROBADO  PARA TODOS LOS ESTRATOS', 'RED INTERNA  Y CALEFACTOR O CHIMENEA', '2014-04-23 05:00:00', NULL, 1, '0.000000', '0.0000', NULL, NULL),
(46, 'CLIENTE NUEVO CALENTADOR', '0.060000', '0.000000', 60, 'PREAPROBADO PARA TODOS LOS ESTRATOS', 'RED INTERNA Y CALENTADOR', '2014-04-24 05:00:00', NULL, 1, '0.000000', '0.0000', NULL, NULL),
(47, 'CLIENTE NUEVO INTERNA', '0.160000', '0.000000', 24, 'PREAPROBADO  PARA TODOS LOS ESTRATOS', 'RED INTERNA', '2014-04-24 05:00:00', NULL, 1, '0.000000', '0.0000', NULL, NULL),
(48, 'CLIENTE NUEVO + CALENTADOR + HORNO + SECADORA OTRO', '0.060000', '0.000000', 60, 'PREAPROBADO PARA TODOS LOS ESTRATOS', 'RED INTERNA + 3 GASODOMESTICOS', '2014-04-24 05:00:00', NULL, 1, '0.000000', '0.0000', NULL, NULL),
(49, 'REPARACIONES CUNDI', '0.260000', '0.000000', NULL, NULL, NULL, '2015-04-23 05:00:00', NULL, 1, '0.000000', '0.0000', NULL, NULL),
(50, 'MANT CAMPAÑA', '0.180000', '0.000000', 6, NULL, NULL, '2015-04-24 05:00:00', NULL, 1, '0.000000', '0.0000', '300000.0000', NULL),
(51, 'Servigas', '0.260000', '0.000000', NULL, NULL, NULL, '2015-04-27 05:00:00', NULL, 1, '0.000000', '0.0000', NULL, NULL),
(52, 'REPARACIONES BOGOTA', '0.180000', '0.000000', NULL, NULL, NULL, '2015-06-18 05:00:00', NULL, 1, '0.000000', '0.0000', NULL, NULL),
(54, 'DEMANDA GIV CUNDY', '0.180000', '0.000000', NULL, NULL, NULL, '2015-08-21 05:00:00', NULL, 1, '0.000000', '0.0000', NULL, NULL),
(56, 'CERTIFICACIONES', '0.180000', '0.000000', 6, NULL, NULL, '2015-10-21 05:00:00', NULL, 1, '0.000000', '18.0000', '500000.0000', NULL),
(57, 'CALENTADORES SS MPA CR 13', '0.000000', '0.000000', NULL, NULL, NULL, '2016-01-21 05:00:00', NULL, 1, '0.000000', '0.0000', NULL, NULL),
(58, 'SUSTITUCION ESTUFAS CS MPA', '0.000000', '0.000000', NULL, NULL, NULL, '2016-01-23 05:00:00', NULL, 1, '0.000000', '0.0000', NULL, NULL),
(59, 'MANTENIMIENTO CUNDI', '0.180000', '0.000000', 12, NULL, NULL, '2015-04-24 05:00:00', NULL, 1, '0.000000', '0.0000', '1000000.0000', NULL),
(60, 'CALENTADORES SS CUNDI', '0.080000', '0.030000', 36, 'PREAPROBADO ESTRATO 1,2,3 $931500                              PREAPROBADO ESTRATO 4,5,6 $1269000', 'TODOS LOS CALENTADORES', '2014-04-02 05:00:00', '2015-02-28 00:00:00', 1, '0.015260', '0.0000', NULL, NULL),
(65, 'preuba2', '21.000000', '12.000000', 1, 'prueba2', 'prueba2', '2018-03-20 05:00:00', '2018-03-21 00:00:00', 1, '0.000000', '12.0000', '0.0000', ''),
(66, 'preuba3', '12.000000', '21.000000', 1, 'prureba3', 'preuba4', '2018-12-31 05:00:00', '2018-12-31 00:00:00', 0, '1.000000', '21.0000', '0.0000', ''),
(67, 'hola123412', '123.000000', '1.000000', 1, 'hola', 'hoal1312231', '2018-03-21 05:00:00', '2018-03-21 00:00:00', 1, '0.000000', '12.0000', '0.0000', ''),
(68, '123', '1.000000', '0.000000', 0, 'asd', 'asd', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, '0.000000', '0.0000', '0.0000', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `siax_ciudad`
--

CREATE TABLE `siax_ciudad` (
  `id_ciu` int(11) NOT NULL,
  `nombre_ciu` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `siax_ciudad`
--

INSERT INTO `siax_ciudad` (`id_ciu`, `nombre_ciu`) VALUES
(1, 'Bogota'),
(6, 'bogota'),
(7, 'cali'),
(8, 'medellin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `siax_estado_giv`
--

CREATE TABLE `siax_estado_giv` (
  `nombre_estado_giv` varchar(50) DEFAULT NULL,
  `para_factura_estado_giv` tinyint(1) DEFAULT '0',
  `se_paga_comision_estado_giv` tinyint(1) DEFAULT '0',
  `porcen_comis_estado_giv` decimal(3,2) DEFAULT '0.00',
  `paga_bono_estado_giv` tinyint(1) DEFAULT '0',
  `porcen_bono_estado_giv` decimal(3,2) DEFAULT '0.00',
  `obs_estado_giv` longtext,
  `envio_boffice_estado_giv` tinyint(1) DEFAULT '0',
  `id_estado_giv` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `siax_estado_giv`
--

INSERT INTO `siax_estado_giv` (`nombre_estado_giv`, `para_factura_estado_giv`, `se_paga_comision_estado_giv`, `porcen_comis_estado_giv`, `paga_bono_estado_giv`, `porcen_bono_estado_giv`, `obs_estado_giv`, `envio_boffice_estado_giv`, `id_estado_giv`) VALUES
(' CIERRE COBRATORIO', 0, 0, '0.00', 0, '0.00', NULL, 0, 1),
('ASIGNADO', 0, 0, '0.00', 0, '0.00', NULL, 0, 2),
('ATENCION A FIRMAS', 0, 1, '0.00', 0, '0.00', NULL, 0, 3),
('CONSTRUCCION ACOMETIDA', 0, 1, '0.00', 0, '0.00', NULL, 0, 6),
('CONTABILIDAD', 0, 1, '1.00', 1, '1.00', 'tecnicos', 0, 8),
('DESISTIDO', 0, 0, '0.00', 0, '0.00', NULL, 0, 10),
('EN INTERVENTORIA DE MONOXIDO', 0, 1, '0.00', 0, '0.00', NULL, 0, 12),
('FIN APROBADO', 0, 1, '1.00', 1, '1.00', 'tecnicos', 0, 15),
('FIN CONTADO', 0, 1, '1.00', 1, '1.00', 'tecnicos', 0, 16),
('FIN DESCONTADO', 0, 0, '0.00', 0, '0.00', NULL, 0, 17),
('IMPOSIBILIDAD CONSTRUCCION', 0, 0, '0.00', 0, '0.00', NULL, 0, 19),
('IMPOSIBILIDAD TECNICA  ACOMETIDA', 0, 0, '0.00', 0, '0.00', NULL, 0, 20),
('IMPOSIBILIDAD TECNICA CON COBERTURA', 0, 0, '0.00', 0, '0.50', 'tecnicos', 0, 21),
('IMPOSIBILIDAD TECNICA SIN COBERTURA', 0, 0, '0.00', 0, '1.00', NULL, 0, 22),
('INTERFACE SGC', 0, 0, '1.00', 1, '1.00', 'tecnicos', 0, 24),
('INTERVENTORIA SOLICITADA', 0, 1, '0.00', 0, '0.00', NULL, 0, 25),
('OBRA EN EJECUCION', 0, 1, '0.00', 0, '0.00', NULL, 0, 29),
('PENDIENTE PAGO', 0, 1, '1.00', 0, '1.00', 'tecnicos', 0, 31),
('PERDIDO', 0, 0, '0.00', 0, '0.00', NULL, 0, 34);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `siax_localidad`
--

CREATE TABLE `siax_localidad` (
  `id_loc` int(11) NOT NULL,
  `nombre_loc` varchar(50) NOT NULL,
  `cod_loc` varchar(50) NOT NULL,
  `idciudad_loc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `siax_localidad`
--

INSERT INTO `siax_localidad` (`id_loc`, `nombre_loc`, `cod_loc`, `idciudad_loc`) VALUES
(1, 'kennedy', '123', 1),
(4, 'bosa', '123', 1),
(5, 'patio bonito', '3421', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `siax_medio_pago`
--

CREATE TABLE `siax_medio_pago` (
  `Id_medio_pago` int(11) NOT NULL,
  `nombre_medio_pago` varchar(50) DEFAULT NULL,
  `activo_medio_pago` tinyint(1) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `siax_medio_pago`
--

INSERT INTO `siax_medio_pago` (`Id_medio_pago`, `nombre_medio_pago`, `activo_medio_pago`) VALUES
(1, 'EFECTIVO', 0),
(2, 'CHEQUE', 0),
(3, 'CONSIGNACION', 0),
(4, 'TARJETA', 0),
(5, 'TRANSFERENCIA', 0),
(6, 'hola', NULL),
(7, 'chao', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `siax_sectores`
--

CREATE TABLE `siax_sectores` (
  `cod_sec` int(11) NOT NULL,
  `nombre_sec` varchar(50) NOT NULL,
  `localidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `siax_sectores`
--

INSERT INTO `siax_sectores` (`cod_sec`, `nombre_sec`, `localidad`) VALUES
(1, 'casa blanca', 1),
(127, 'tintal', 4);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_cotizacion`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_cotizacion` (
`id_cot` int(11)
,`sol_cot` int(11)
,`consecutivo_cot` varchar(20)
,`estrato_cot` int(11)
,`fecha_nac_cot` date
,`forma_pago_cot` int(11)
,`campana_cot` int(11)
,`nombre_campana` varchar(50)
,`tipo_cliente_cot` int(11)
,`fecha_cot` date
,`v_total_cot` decimal(19,0)
,`v_contado_cot` decimal(19,0)
,`estado_cot` int(11)
,`obs_cot` varchar(250)
,`pagare_cot` varchar(11)
,`not_cliente_cot` tinyint(11)
,`fecha_not_cot` date
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_solicitud`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_solicitud` (
`id_sol` int(11)
,`nombre_loc` varchar(50)
,`nombre_sec` varchar(50)
,`nombre_tercero` varchar(80)
,`tipo_asignacion` varchar(50)
,`nombre_estado_preventa` varchar(50)
,`poliza_sol` double
,`demanda_sol` decimal(18,0)
,`cedula_sol` double
,`nombre_sol` varchar(255)
,`direccion_pol_sol` varchar(255)
,`direccion_nueva_sol` varchar(255)
,`telefono1_sol` varchar(50)
,`telefono2_sol` varchar(50)
,`celular_sol` varchar(50)
,`email_sol` varchar(80)
,`servicio_sol` varchar(100)
,`obs_sol` varchar(255)
,`fecha_prevista_sol` datetime
,`fecha_visita_comerc_sol` datetime
);

-- --------------------------------------------------------

--
-- Estructura para la vista `add_cot`
--
DROP TABLE IF EXISTS `add_cot`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `add_cot`  AS  select `vista_solicitud`.`id_sol` AS `id_sol`,`vista_solicitud`.`nombre_loc` AS `nombre_loc`,`vista_solicitud`.`nombre_sec` AS `nombre_sec`,`vista_solicitud`.`nombre_tercero` AS `nombre_tercero`,`vista_solicitud`.`tipo_asignacion` AS `tipo_asignacion`,`vista_solicitud`.`nombre_estado_preventa` AS `nombre_estado_preventa`,`vista_solicitud`.`poliza_sol` AS `poliza_sol`,`vista_solicitud`.`demanda_sol` AS `demanda_sol`,`vista_solicitud`.`cedula_sol` AS `cedula_sol`,`vista_solicitud`.`nombre_sol` AS `nombre_sol`,`vista_solicitud`.`direccion_pol_sol` AS `direccion_pol_sol`,`vista_solicitud`.`direccion_nueva_sol` AS `direccion_nueva_sol`,`vista_solicitud`.`telefono1_sol` AS `telefono1_sol`,`vista_solicitud`.`telefono2_sol` AS `telefono2_sol`,`vista_solicitud`.`celular_sol` AS `celular_sol`,`vista_solicitud`.`email_sol` AS `email_sol`,`vista_solicitud`.`servicio_sol` AS `servicio_sol`,`vista_solicitud`.`obs_sol` AS `obs_sol`,`vista_solicitud`.`fecha_prevista_sol` AS `fecha_prevista_sol`,`vista_solicitud`.`fecha_visita_comerc_sol` AS `fecha_visita_comerc_sol`,`vista_cotizacion`.`id_cot` AS `id_cot`,`vista_cotizacion`.`sol_cot` AS `sol_cot`,`vista_cotizacion`.`consecutivo_cot` AS `consecutivo_cot`,`vista_cotizacion`.`estrato_cot` AS `estrato_cot`,`vista_cotizacion`.`fecha_nac_cot` AS `fecha_nac_cot`,`vista_cotizacion`.`forma_pago_cot` AS `forma_pago_cot`,`vista_cotizacion`.`campana_cot` AS `campana_cot`,`vista_cotizacion`.`nombre_campana` AS `nombre_campana`,`vista_cotizacion`.`tipo_cliente_cot` AS `tipo_cliente_cot`,`vista_cotizacion`.`fecha_cot` AS `fecha_cot`,`vista_cotizacion`.`v_total_cot` AS `v_total_cot`,`vista_cotizacion`.`v_contado_cot` AS `v_contado_cot`,`vista_cotizacion`.`estado_cot` AS `estado_cot`,`vista_cotizacion`.`obs_cot` AS `obs_cot`,`vista_cotizacion`.`pagare_cot` AS `pagare_cot`,`vista_cotizacion`.`not_cliente_cot` AS `not_cliente_cot`,`vista_cotizacion`.`fecha_not_cot` AS `fecha_not_cot` from (`vista_solicitud` left join `vista_cotizacion` on((`vista_solicitud`.`id_sol` = `vista_cotizacion`.`sol_cot`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `cotizacion`
--
DROP TABLE IF EXISTS `cotizacion`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `cotizacion`  AS  select `ap_cotizacion`.`sol_cot` AS `sol_cot`,`ap_cotizacion`.`consecutivo_cot` AS `consecutivo_cot`,`ap_cotizacion`.`estrato_cot` AS `estrato_cot`,`ap_solicitud`.`asignacion_sol` AS `asignacion_sol`,`ap_solicitud`.`asesor_sol` AS `asesor_sol`,`ap_solicitud`.`nombre_sol` AS `nombre_sol`,`ap_solicitud`.`servicio_sol` AS `servicio_sol` from (`ap_cotizacion` join `ap_solicitud`) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `demanda_sin_sol`
--
DROP TABLE IF EXISTS `demanda_sin_sol`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `demanda_sin_sol`  AS  select `demanda`.`origen_dem` AS `origen_dem`,concat('TC ',`demanda`.`tipo_cliente_dem`,'- Uso ',`demanda`.`uso`,'-',`demanda`.`fecha_trab_dem`,'- Estrato ',`demanda`.`estrato`) AS `observacion`,`demanda`.`fecha_llamada` AS `fecha_llamada`,`demanda`.`cod_dem` AS `cod_dem`,`demanda`.`poliza_dem` AS `poliza_dem`,`demanda`.`usuario_captura` AS `usuario_captura`,`demanda`.`campana_demanda` AS `campana_demanda`,`demanda`.`chip_natural` AS `chip_natural`,`demanda`.`estado_predio` AS `estado_predio`,`demanda`.`tipo_predio` AS `tipo_predio`,`demanda`.`mecado` AS `mecado`,`demanda`.`nombre_cliente` AS `nombre_cliente`,`demanda`.`num_doc` AS `num_doc`,`demanda`.`direccion` AS `direccion`,`demanda`.`municipio` AS `municipio`,`demanda`.`telefono` AS `telefono`,`demanda`.`cod_trabajo_original` AS `cod_trabajo_original`,`demanda`.`cod_ult_visit` AS `cod_ult_visit`,`demanda`.`res_ult_vis` AS `res_ult_vis`,`demanda`.`fecha_ult_visita` AS `fecha_ult_visita`,`demanda`.`usu_asig_primer_trab` AS `usu_asig_primer_trab`,`demanda`.`fecha_prim_visit` AS `fecha_prim_visit`,`demanda`.`respuesta_pv` AS `respuesta_pv`,`demanda`.`fecha_cap_primera_visita` AS `fecha_cap_primera_visita`,`demanda`.`cod_contratista` AS `cod_contratista`,`demanda`.`nom_cont` AS `nom_cont`,`demanda`.`distrito` AS `distrito`,`demanda`.`malla` AS `malla`,`demanda`.`sector` AS `sector`,`demanda`.`descr_estado_dem` AS `descr_estado_dem`,`demanda`.`estrato` AS `estrato`,`demanda`.`clase_dem` AS `clase_dem` from (`demanda` left join `ap_solicitud` on((`demanda`.`cod_dem` = `ap_solicitud`.`demanda_sol`))) where isnull(`ap_solicitud`.`demanda_sol`) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_cotizacion`
--
DROP TABLE IF EXISTS `vista_cotizacion`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_cotizacion`  AS  select `ap_cotizacion`.`id_cot` AS `id_cot`,`ap_cotizacion`.`sol_cot` AS `sol_cot`,`ap_cotizacion`.`consecutivo_cot` AS `consecutivo_cot`,`ap_cotizacion`.`estrato_cot` AS `estrato_cot`,`ap_cotizacion`.`fecha_nac_cot` AS `fecha_nac_cot`,`ap_cotizacion`.`forma_pago_cot` AS `forma_pago_cot`,`ap_cotizacion`.`campana_cot` AS `campana_cot`,`siax_campana`.`nombre_campana` AS `nombre_campana`,`ap_cotizacion`.`tipo_cliente_cot` AS `tipo_cliente_cot`,`ap_cotizacion`.`fecha_cot` AS `fecha_cot`,`ap_cotizacion`.`v_total_cot` AS `v_total_cot`,`ap_cotizacion`.`v_contado_cot` AS `v_contado_cot`,`ap_cotizacion`.`estado_cot` AS `estado_cot`,`ap_cotizacion`.`obs_cot` AS `obs_cot`,`ap_cotizacion`.`pagare_cot` AS `pagare_cot`,`ap_cotizacion`.`not_cliente_cot` AS `not_cliente_cot`,`ap_cotizacion`.`fecha_not_cot` AS `fecha_not_cot` from (`ap_estado_interno` join (`siax_campana` join (`ap_tipo_cliente` join (`ap_forma_pago` join `ap_cotizacion` on((`ap_forma_pago`.`Id_forma_ap` = `ap_cotizacion`.`forma_pago_cot`))) on((`ap_tipo_cliente`.`id_tipo_cliente` = `ap_cotizacion`.`tipo_cliente_cot`))) on((`siax_campana`.`id_campana` = `ap_cotizacion`.`campana_cot`))) on((`ap_estado_interno`.`id_estado_interno` = `ap_cotizacion`.`estado_cot`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_solicitud`
--
DROP TABLE IF EXISTS `vista_solicitud`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_solicitud`  AS  select `ap_solicitud`.`id_sol` AS `id_sol`,`siax_localidad`.`nombre_loc` AS `nombre_loc`,`siax_sectores`.`nombre_sec` AS `nombre_sec`,`ap_terceros`.`nombre_tercero` AS `nombre_tercero`,`ap_asignacion`.`tipo_asignacion` AS `tipo_asignacion`,`ap_estado_preventa`.`nombre_estado_preventa` AS `nombre_estado_preventa`,`ap_solicitud`.`poliza_sol` AS `poliza_sol`,`ap_solicitud`.`demanda_sol` AS `demanda_sol`,`ap_solicitud`.`cedula_sol` AS `cedula_sol`,`ap_solicitud`.`nombre_sol` AS `nombre_sol`,`ap_solicitud`.`direccion_pol_sol` AS `direccion_pol_sol`,`ap_solicitud`.`direccion_nueva_sol` AS `direccion_nueva_sol`,`ap_solicitud`.`telefono1_sol` AS `telefono1_sol`,`ap_solicitud`.`telefono2_sol` AS `telefono2_sol`,`ap_solicitud`.`celular_sol` AS `celular_sol`,`ap_solicitud`.`email_sol` AS `email_sol`,`ap_solicitud`.`servicio_sol` AS `servicio_sol`,`ap_solicitud`.`obs_sol` AS `obs_sol`,`ap_solicitud`.`fecha_prevista_sol` AS `fecha_prevista_sol`,`ap_solicitud`.`fecha_visita_comerc_sol` AS `fecha_visita_comerc_sol` from (`siax_localidad` join (`siax_sectores` join (`ap_terceros` join (`ap_asignacion` join (`ap_estado_preventa` join `ap_solicitud` on((`ap_estado_preventa`.`id_estado_preventa` = `ap_solicitud`.`estado_sol`))) on((`ap_asignacion`.`id_asignacion` = `ap_solicitud`.`asignacion_sol`))) on((`ap_terceros`.`Id_tercero` = `ap_solicitud`.`asesor_sol`))) on((`siax_sectores`.`cod_sec` = `ap_solicitud`.`barrio_sol`))) on((`siax_localidad`.`id_loc` = `ap_solicitud`.`localidad_sol`))) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ap_asignacion`
--
ALTER TABLE `ap_asignacion`
  ADD PRIMARY KEY (`id_asignacion`),
  ADD KEY `id_asignacion` (`id_asignacion`);

--
-- Indices de la tabla `ap_camp_cliente`
--
ALTER TABLE `ap_camp_cliente`
  ADD PRIMARY KEY (`id_camp_cliente`),
  ADD KEY `id_camp_cliente` (`id_camp_cliente`);

--
-- Indices de la tabla `ap_cotizacion`
--
ALTER TABLE `ap_cotizacion`
  ADD PRIMARY KEY (`id_cot`);

--
-- Indices de la tabla `ap_detalle_venta`
--
ALTER TABLE `ap_detalle_venta`
  ADD PRIMARY KEY (`id_det_venta`),
  ADD KEY `id_det_venta` (`id_det_venta`);

--
-- Indices de la tabla `ap_estado_interno`
--
ALTER TABLE `ap_estado_interno`
  ADD PRIMARY KEY (`id_estado_interno`),
  ADD KEY `id_estado_interno` (`id_estado_interno`);

--
-- Indices de la tabla `ap_estado_preventa`
--
ALTER TABLE `ap_estado_preventa`
  ADD PRIMARY KEY (`id_estado_preventa`),
  ADD KEY `id_estado_preventa` (`id_estado_preventa`);

--
-- Indices de la tabla `ap_forma_pago`
--
ALTER TABLE `ap_forma_pago`
  ADD PRIMARY KEY (`Id_forma_ap`),
  ADD KEY `Id_forma_ap` (`Id_forma_ap`);

--
-- Indices de la tabla `ap_grupo_nomina`
--
ALTER TABLE `ap_grupo_nomina`
  ADD PRIMARY KEY (`id_grupo_nomina`),
  ADD KEY `id_grupo_nomina` (`id_grupo_nomina`);

--
-- Indices de la tabla `ap_grupo_usuarios`
--
ALTER TABLE `ap_grupo_usuarios`
  ADD PRIMARY KEY (`id_grupo_gn`),
  ADD KEY `id_grupo_gn` (`id_grupo_gn`);

--
-- Indices de la tabla `ap_items_inv`
--
ALTER TABLE `ap_items_inv`
  ADD PRIMARY KEY (`Id_Item`),
  ADD UNIQUE KEY `codigo_item` (`codigo_item`),
  ADD KEY `Id_Item` (`Id_Item`);

--
-- Indices de la tabla `ap_roles_usuarios`
--
ALTER TABLE `ap_roles_usuarios`
  ADD PRIMARY KEY (`Id_Rol`),
  ADD KEY `Id_Rol` (`Id_Rol`);

--
-- Indices de la tabla `ap_solicitud`
--
ALTER TABLE `ap_solicitud`
  ADD PRIMARY KEY (`id_sol`),
  ADD KEY `cedula_sol` (`cedula_sol`),
  ADD KEY `id_sol` (`id_sol`),
  ADD KEY `tipo_cliente_sol` (`archivos_sol`);

--
-- Indices de la tabla `ap_terceros`
--
ALTER TABLE `ap_terceros`
  ADD PRIMARY KEY (`Id_tercero`),
  ADD KEY `Id_tercero` (`Id_tercero`),
  ADD KEY `nombre_tercero` (`nombre_tercero`);

--
-- Indices de la tabla `ap_tipo_cliente`
--
ALTER TABLE `ap_tipo_cliente`
  ADD PRIMARY KEY (`id_tipo_cliente`),
  ADD KEY `id_tipo_cliente` (`id_tipo_cliente`);

--
-- Indices de la tabla `ap_tipo_inv`
--
ALTER TABLE `ap_tipo_inv`
  ADD PRIMARY KEY (`id_tipo_inv`),
  ADD UNIQUE KEY `nombre_tipo_inv` (`nombre_tipo_inv`),
  ADD KEY `id_tipo_inv` (`id_tipo_inv`);

--
-- Indices de la tabla `ap_tipo_tercero`
--
ALTER TABLE `ap_tipo_tercero`
  ADD PRIMARY KEY (`id_tipo_tercero`),
  ADD KEY `id_tipo_tercero` (`id_tipo_tercero`);

--
-- Indices de la tabla `criterios`
--
ALTER TABLE `criterios`
  ADD PRIMARY KEY (`Id_cri`);

--
-- Indices de la tabla `siax_campana`
--
ALTER TABLE `siax_campana`
  ADD PRIMARY KEY (`id_campana`),
  ADD KEY `id_campana` (`id_campana`);

--
-- Indices de la tabla `siax_ciudad`
--
ALTER TABLE `siax_ciudad`
  ADD PRIMARY KEY (`id_ciu`),
  ADD KEY `id_ciu` (`id_ciu`);

--
-- Indices de la tabla `siax_estado_giv`
--
ALTER TABLE `siax_estado_giv`
  ADD PRIMARY KEY (`id_estado_giv`),
  ADD KEY `id_estado_giv` (`id_estado_giv`);

--
-- Indices de la tabla `siax_localidad`
--
ALTER TABLE `siax_localidad`
  ADD PRIMARY KEY (`id_loc`),
  ADD KEY `idciudad_loc` (`idciudad_loc`);

--
-- Indices de la tabla `siax_medio_pago`
--
ALTER TABLE `siax_medio_pago`
  ADD PRIMARY KEY (`Id_medio_pago`),
  ADD KEY `Id_medio_pago` (`Id_medio_pago`);

--
-- Indices de la tabla `siax_sectores`
--
ALTER TABLE `siax_sectores`
  ADD PRIMARY KEY (`cod_sec`),
  ADD KEY `localidad` (`localidad`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ap_asignacion`
--
ALTER TABLE `ap_asignacion`
  MODIFY `id_asignacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `ap_cotizacion`
--
ALTER TABLE `ap_cotizacion`
  MODIFY `id_cot` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `ap_detalle_venta`
--
ALTER TABLE `ap_detalle_venta`
  MODIFY `id_det_venta` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `ap_estado_interno`
--
ALTER TABLE `ap_estado_interno`
  MODIFY `id_estado_interno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT de la tabla `ap_grupo_usuarios`
--
ALTER TABLE `ap_grupo_usuarios`
  MODIFY `id_grupo_gn` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `ap_items_inv`
--
ALTER TABLE `ap_items_inv`
  MODIFY `Id_Item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=350;
--
-- AUTO_INCREMENT de la tabla `ap_roles_usuarios`
--
ALTER TABLE `ap_roles_usuarios`
  MODIFY `Id_Rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=282;
--
-- AUTO_INCREMENT de la tabla `ap_solicitud`
--
ALTER TABLE `ap_solicitud`
  MODIFY `id_sol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
--
-- AUTO_INCREMENT de la tabla `ap_terceros`
--
ALTER TABLE `ap_terceros`
  MODIFY `Id_tercero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `ap_tipo_tercero`
--
ALTER TABLE `ap_tipo_tercero`
  MODIFY `id_tipo_tercero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `criterios`
--
ALTER TABLE `criterios`
  MODIFY `Id_cri` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `siax_campana`
--
ALTER TABLE `siax_campana`
  MODIFY `id_campana` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
--
-- AUTO_INCREMENT de la tabla `siax_ciudad`
--
ALTER TABLE `siax_ciudad`
  MODIFY `id_ciu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `siax_estado_giv`
--
ALTER TABLE `siax_estado_giv`
  MODIFY `id_estado_giv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT de la tabla `siax_localidad`
--
ALTER TABLE `siax_localidad`
  MODIFY `id_loc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `siax_medio_pago`
--
ALTER TABLE `siax_medio_pago`
  MODIFY `Id_medio_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `siax_sectores`
--
ALTER TABLE `siax_sectores`
  MODIFY `cod_sec` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `siax_localidad`
--
ALTER TABLE `siax_localidad`
  ADD CONSTRAINT `siax_localidad_ibfk_1` FOREIGN KEY (`idciudad_loc`) REFERENCES `siax_ciudad` (`id_ciu`);

--
-- Filtros para la tabla `siax_sectores`
--
ALTER TABLE `siax_sectores`
  ADD CONSTRAINT `siax_sectores_ibfk_1` FOREIGN KEY (`localidad`) REFERENCES `siax_localidad` (`id_loc`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
