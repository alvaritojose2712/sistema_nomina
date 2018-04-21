-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-04-2018 a las 16:56:18
-- Versión del servidor: 10.1.16-MariaDB
-- Versión de PHP: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema_nomina`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autenticar`
--

CREATE TABLE `autenticar` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) CHARACTER SET latin1 NOT NULL,
  `apellido` varchar(50) CHARACTER SET latin1 NOT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `clave` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `departamento` varchar(30) CHARACTER SET latin1 NOT NULL,
  `permiso` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `imagen` varchar(1000) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `autenticar`
--

INSERT INTO `autenticar` (`id`, `nombre`, `apellido`, `usuario`, `clave`, `departamento`, `permiso`, `fecha`, `imagen`) VALUES
(1, 'Alvaro Jose', 'Ospino', 'alvaritojose2712', '*A4B6157319038724E3560894F7F932C8886EBFCF', 'Recursos humanos', 'administrador', '2018-04-04 17:36:18', NULL),
(2, 'David ', 'Rivero', 'david22', '*A4B6157319038724E3560894F7F932C8886EBFCF', 'Presupuesto', 'administrador', '2018-03-29 21:01:29', NULL),
(3, 'Andres', 'Cuccithini', 'LeoMessi10', '*A4B6157319038724E3560894F7F932C8886EBFCF', 'Presupuesto', 'administrador', '2018-03-30 16:47:06', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formulas`
--

CREATE TABLE `formulas` (
  `id` int(5) NOT NULL,
  `condiciones` varchar(10000) CHARACTER SET latin1 NOT NULL,
  `operaciones` varchar(10000) CHARACTER SET latin1 NOT NULL,
  `tipo_concepto` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tipo_sueldo` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `asignacion_deduccion` varchar(30) CHARACTER SET latin1 NOT NULL,
  `periodo_pago` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(1000) CHARACTER SET latin1 NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `formulas`
--

INSERT INTO `formulas` (`id`, `condiciones`, `operaciones`, `tipo_concepto`, `tipo_sueldo`, `asignacion_deduccion`, `periodo_pago`, `descripcion`, `fecha`) VALUES
(1, '{"estado":{"ACTIVO":"igual","JUBILADO":"igual","PENSIONADO":"igual"},"dedicacion":{"TIEMPO COMPLETO":"igual","EXCLUSIVA":"igual"},"numero_hijos":{"discapacidad":{"si":"="}}}', '{"operacion":"$unidad_tributaria*200*$prima_hijos"}', 'prima salarial', 'sueldo basico', 'asignacion', 'mensual', 'Prima para la atención de Hijas e Hijos con Discapacidad', '2017-09-01'),
(6, '{"estado":{"ACTIVO":"igual","JUBILADO":"igual","PENSIONADO":"igual"},"dedicacion":{"TIEMPO COMPLETO":"igual","EXCLUSIVA":"igual"}}', '{"operacion":"$unidad_tributaria*300"}', 'prima salarial', 'sueldo basico', 'asignacion', 'mensual', 'Prima familiar', '2017-09-01'),
(7, '{"estado":{"ACTIVO":"igual","JUBILADO":"igual","PENSIONADO":"igual"},"dedicacion":{"TIEMPO COMPLETO":"igual","EXCLUSIVA":"igual"},"categoria":{"DOCENTE":"igual"}}', '{"operacion":"$unidad_tributaria*50"}', 'prima salarial', 'sueldo basico', 'asignacion', 'mensual', 'Prima para el Apoyo a Actividad Docente y de Investigación', '2017-09-01'),
(8, '{"estado":{"ACTIVO":"igual","JUBILADO":"igual","PENSIONADO":"igual"},"dedicacion":{"TIEMPO COMPLETO":"igual"},"categoria":{"ADMINISTRATIVO":"igual","OBRERO":"igual"},"grado_instruccion":{"TSU":"igual"}}', '{"operacion":"$sueldo_tabla*0.12"}', 'prima salarial', 'sueldo basico', 'asignacion', 'mensual', 'Prima de Profesionalización-TSU', '2017-09-01'),
(9, '{"estado":{"ACTIVO":"igual","JUBILADO":"igual","PENSIONADO":"igual"},"dedicacion":{"TIEMPO COMPLETO":"igual"},"categoria":{"ADMINISTRATIVO":"igual","OBRERO":"igual"},"grado_instruccion":{"LICENCIADO":"igual"}}', '{"operacion":"$sueldo_tabla*0.14"}', 'prima salarial', 'sueldo basico', 'asignacion', 'mensual', 'Prima de Profesionalización-LICENCIADO', '2017-09-01'),
(10, '{"estado":{"ACTIVO":"igual","JUBILADO":"igual","PENSIONADO":"igual"},"dedicacion":{"TIEMPO COMPLETO":"igual"},"categoria":{"ADMINISTRATIVO":"igual","OBRERO":"igual"},"grado_instruccion":{"ESPECIALISTA":"igual"}}', '{"operacion":"$sueldo_tabla*0.16"}', 'prima salarial', 'sueldo basico', 'asignacion', 'mensual', 'Prima de Profesionalización-ESPECIALISTA\n', '2017-09-01'),
(11, '{"estado":{"ACTIVO":"igual","JUBILADO":"igual","PENSIONADO":"igual"},"dedicacion":{"TIEMPO COMPLETO":"igual"},"categoria":{"ADMINISTRATIVO":"igual","OBRERO":"igual"},"grado_instruccion":{"MASTER":"igual"}}', '{"operacion":"$sueldo_tabla*0.18"}', 'prima salarial', 'sueldo basico', 'asignacion', 'mensual', 'Prima de Profesionalización-MASTER\n', '2017-09-01'),
(12, '{"estado":{"ACTIVO":"igual","JUBILADO":"igual","PENSIONADO":"igual"},"dedicacion":{"TIEMPO COMPLETO":"igual"},"categoria":{"ADMINISTRATIVO":"igual","OBRERO":"igual"},"grado_instruccion":{"DOCTOR":"igual"}}', '{"operacion":"$sueldo_tabla*0.2"}', 'prima salarial', 'sueldo basico', 'asignacion', 'mensual', 'Prima de Profesionalización-DOCTOR\n', '2017-09-01'),
(15, '{"cualquiera":""}', '{"operacion":"$años_antiguedad*0.015*$sueldo_normal"}', 'prima salarial', 'sueldo normal', 'asignacion', 'mensual', 'Prima por antiguedad', '2017-09-01'),
(16, '{"estado":{"ACTIVO":"igual","JUBILADO":"igual","PENSIONADO":"igual"},"categoria":{"OBRERO":"igual"},"cargo":{"7":"igual","6":"igual"}}', '{"operacion":"$unidad_tributaria*50"}', 'prima salarial', 'sueldo basico', 'asignacion', 'mensual', 'Prima para Chóferes y Supervisores', '2017-09-01'),
(17, '{"caja_ahorro":{"si":"igual"}}', '{"operacion":"$sueldo_tabla*0.1"}', 'deduccion salarial', 'sueldo basico', 'deduccion', 'mensual', 'Caja de ahorro', '2017-09-01'),
(18, '{"categoria":{"DOCENTE":"igual"},"grado_instruccion":{"ESPECIALISTA":"igual"}}', '{"operacion":"$sueldo_tabla*0.16"}', 'prima salarial', 'sueldo basico', 'asignacion', 'mensual', 'Prima por Especialización para Docente', '2017-09-01'),
(19, '{"categoria":{"DOCENTE":"igual"},"grado_instruccion":{"MASTER":"igual"}}', '{"operacion":"$sueldo_tabla*0.18"}', 'prima salarial', 'sueldo basico', 'asignacion', 'mensual', 'Prima por Maestría para Docentes', '2017-09-01'),
(20, '{"categoria":{"DOCENTE":"igual"},"grado_instruccion":{"DOCTOR":"igual"}}', '{"operacion":"$sueldo_tabla*0.2"}', 'prima salarial', 'sueldo basico', 'asignacion', 'mensual', 'Prima por Doctorado para Docente', '2017-09-01'),
(21, '{"cualquiera":""}', '{"operacion":"(($sueldo_normal*12)/52)*0.04*$lunes_del_mes"}', 'deduccion salarial', 'sueldo normal', 'deduccion', 'mensual', 'Seguro social', '2017-09-01'),
(22, '{"estado":{"ACTIVO":"igual"},"dedicacion":{"TIEMPO COMPLETO":"igual","EXCLUSIVA":"igual"},"categoria":{"ADMINISTRATIVO":"igual","DOCENTE":"igual"}}', '{"operacion":"$sueldo_tabla*0.06"}', 'deduccion salarial', 'sueldo basico', 'deduccion', 'mensual', 'IPASME', '2017-09-01'),
(23, '{"estado":{"ACTIVO":"igual","JUBILADO":"igual","PENSIONADO":"igual"},"categoria":{"OBRERO":"igual"},"cargo":{"4":"igual"}}', '{"operacion":"((($sueldo_normal/30)/8)*0.3)*$hrs_nocturnas"}', 'bono salarial', 'sueldo basico', 'asignacion', 'mensual', 'Bono nocturno - OBRERO', '2017-09-01'),
(24, '{"cualquiera":""}', '{"operacion":"$sueldo_tabla"}', 'salario', 'salario', 'asignacion', 'mensual', 'Sueldo básico', '2017-09-01'),
(43, '{"estatus":{"ALTO NIVEL":"igual","CONTRATADO":"igual","EMPLEADO FIJO":"igual"}}', '{"operacion":"(($sueldo_normal+($sueldo_tabla*0.1))+((($sueldo_normal+($sueldo_tabla*0.1))/30)*105)/12)/30*120"}', 'bono salarial', 'sueldo normal', 'asignacion', 'anual', 'Bono de fin de año', '2017-09-01'),
(44, '{"estado":{"ACTIVO":"igual"}}', '{"operacion":"(($sueldo_normal*12)/52)*0.005*$lunes_del_mes"}', 'deduccion salarial', 'sueldo normal', 'deduccion', 'mensual', 'PIE', '2017-09-01'),
(45, '{"estatus":{"ALTO NIVEL":"igual","CONTRATADO":"igual","EMPLEADO FIJO":"igual"}}', '{"operacion":"(($sueldo_normal+($sueldo_tabla*0.1))+((($sueldo_normal+($sueldo_tabla*0.1))/30)*120)/12)/30*105"}', 'bono salarial', 'sueldo normal', 'asignacion', 'anual', 'Bono vacacional', '2017-09-01'),
(46, '{"estatus":{"ALTO NIVEL":"igual","CONTRATADO":"igual","EMPLEADO FIJO":"igual"}}', '{"operacion":"$sueldo_normal*0.02"}', 'deduccion salarial', 'sueldo normal', 'deduccion', 'mensual', 'FAOV', '2017-09-01'),
(48, '{"categoria":{"OBRERO":"igual","ADMINISTRATIVO":"igual"}}', '{"operacion":"((($sueldo_normal*12)/52)*0.02)*$lunes_del_mes"}', 'deduccion salarial', 'sueldo normal', 'deduccion', 'mensual', 'FPJ', '2017-09-01'),
(49, '{"cualquiera":""}', '{"operacion":"$unidad_tributaria*30*61"}', 'bono alimentacion', 'sueldo basico', 'asignacion', 'mensual', 'CestaTicket', '2017-09-01'),
(50, '{"cualquiera":""}', '{"aporte_patronal":"(($sueldo_normal*12)/52)*0.09*$lunes_del_mes","deduccion":"(($sueldo_normal*12)/52)*0.09*$lunes_del_mes"}', 'aporte_patronal', 'aporte_patronal', 'aporte_patronal', 'mensual', 'Seguro social', '2017-09-01'),
(51, '{"estado":{"ACTIVO":"igual"},"dedicacion":{"TIEMPO COMPLETO":"igual","EXCLUSIVA":"igual"},"categoria":{"ADMINISTRATIVO":"igual","DOCENTE":"igual"}}', '{"aporte_patronal":"$sueldo_tabla*0.06","deduccion":"$sueldo_tabla*0.06"}', 'aporte_patronal', 'aporte_patronal', 'aporte_patronal', 'mensual', 'IPASME', '2017-09-01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hijos_personal`
--

CREATE TABLE `hijos_personal` (
  `id` int(5) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `cedula_representante` int(8) NOT NULL,
  `edad` int(4) NOT NULL,
  `estudia` varchar(3) COLLATE utf8_spanish_ci NOT NULL,
  `discapacidad` varchar(3) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `hijos_personal`
--

INSERT INTO `hijos_personal` (`id`, `nombre`, `apellido`, `fecha_nacimiento`, `cedula_representante`, `edad`, `estudia`, `discapacidad`) VALUES
(6, 'Tyago', 'Messi', '2012-09-29', 13145920, 0, 'si', 'no'),
(7, 'Danilo', 'Messi', '2016-10-29', 13145920, 0, 'no', 'no'),
(11, 'Junior', 'Peña', '2017-11-30', 25657161, 0, 'no', 'no'),
(12, 'Silfredo David', 'Rivero', '2013-08-22', 13149202, 0, 'no', 'no'),
(13, 'Pedro Junior', 'Carmona', '2010-11-29', 20565644, 0, 'si', 'no'),
(14, 'Alvaro Junior', 'Ospino', '2017-12-30', 26767116, 0, 'no', 'no');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mail`
--

CREATE TABLE `mail` (
  `id` int(3) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `cuenta` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `clave` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `servidor_smtp` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `puerto` int(5) NOT NULL,
  `predeterminado` varchar(10) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `mail`
--

INSERT INTO `mail` (`id`, `nombre`, `cuenta`, `clave`, `servidor_smtp`, `puerto`, `predeterminado`) VALUES
(3, 'Alvaro Ospino', 'alvaroospino79@gmail.com', 'v26767116A', 'smtp.gmail.com', 587, 'checked');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajeria`
--

CREATE TABLE `mensajeria` (
  `id` int(5) NOT NULL,
  `de` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `para` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `msj` longtext COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `mensajeria`
--

INSERT INTO `mensajeria` (`id`, `de`, `para`, `msj`, `fecha`) VALUES
(126, 'david22', 'alvaritojose2712', 'Hola alvaro soy david', '2018-03-30 18:57:50'),
(127, 'david22', 'LeoMessi10', 'Hola messi soy david\n', '2018-03-30 18:58:13'),
(128, 'alvaritojose2712', 'LeoMessi10', 'Hola mssi soy alvaro', '2018-03-30 18:58:31'),
(129, 'alvaritojose2712', 'david22', 'Que paso dav soy aj', '2018-03-30 18:59:03'),
(130, 'alvaritojose2712', 'LeoMessi10', 'Messs\n', '2018-03-30 18:59:18'),
(131, 'david22', 'LeoMessi10', 'Epale messs\n', '2018-03-30 18:59:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parametros_nomina`
--

CREATE TABLE `parametros_nomina` (
  `id` int(5) NOT NULL,
  `denominacion` varchar(1000) CHARACTER SET latin1 NOT NULL,
  `tipo_periodo` varchar(50) CHARACTER SET latin1 NOT NULL,
  `formulas_a_pagar` varchar(10000) CHARACTER SET latin1 NOT NULL,
  `divisiones` varchar(10000) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `engine` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `incl_excl` varchar(4000) COLLATE utf8_spanish_ci NOT NULL,
  `opera_espec` varchar(4000) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `parametros_nomina`
--

INSERT INTO `parametros_nomina` (`id`, `denominacion`, `tipo_periodo`, `formulas_a_pagar`, `divisiones`, `fecha`, `engine`, `incl_excl`, `opera_espec`) VALUES
(2, 'Sueldo Básico', 'mensual', '{"6":"","21":"","24":""}', '{"1era_quincena":{"6":"100","21":"100","24":"100"},"2da_quincena":{"6":"","21":"","24":""}}', '2018-04-04 17:12:15', 'convencional', '{}', '{"9868006":{"0":{"deduccion":{"motivo":"Por faltas a clases","monto":"($sueldo_tabla/30)*5"},"divisiones":{"1era_quincena":"50","2da_quincena":"50"}}}}'),
(3, 'Aporte patronal', 'mensual', '{"61":""}', '{"Mes_de_enero":{"61":"100"}}', '2018-03-18 16:42:59', 'aporte patronal', '', ''),
(4, 'Prueba de nomina ', 'mensual', '{"54":""}', '{"Periodo":{"54":"100"}}', '2018-03-18 15:10:15', 'convencional', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_upt`
--

CREATE TABLE `personal_upt` (
  `id` int(5) NOT NULL,
  `estado` varchar(30) CHARACTER SET latin1 NOT NULL,
  `nombre` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `apellido` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `cedula` int(8) DEFAULT NULL,
  `nacionalidad` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `genero` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `telefono_1` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono_2` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `correo` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `estatus` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `grado_instruccion` varchar(30) CHARACTER SET latin1 NOT NULL,
  `categoria` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `dedicacion` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `caja_ahorro` varchar(3) CHARACTER SET latin1 NOT NULL,
  `cargo` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `cuenta_bancaria` varchar(100) CHARACTER SET latin1 NOT NULL,
  `antiguedad_otros_ieu` int(3) DEFAULT NULL,
  `hrs_nocturnas` int(3) DEFAULT NULL,
  `hrs_feriadas` int(3) DEFAULT NULL,
  `hrs_diurnas` int(3) DEFAULT NULL,
  `hrs_feriadas_nocturnas` int(3) DEFAULT NULL,
  `profesion` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `departamento_adscrito` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `cargo_desempeñado_departamento` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `personal_upt`
--

INSERT INTO `personal_upt` (`id`, `estado`, `nombre`, `apellido`, `cedula`, `nacionalidad`, `genero`, `fecha_nacimiento`, `telefono_1`, `telefono_2`, `correo`, `estatus`, `fecha_ingreso`, `grado_instruccion`, `categoria`, `dedicacion`, `caja_ahorro`, `cargo`, `cuenta_bancaria`, `antiguedad_otros_ieu`, `hrs_nocturnas`, `hrs_feriadas`, `hrs_diurnas`, `hrs_feriadas_nocturnas`, `profesion`, `departamento_adscrito`, `cargo_desempeñado_departamento`) VALUES
(1, 'ACTIVO', 'Alvaro Jose', 'Ospino', 26767116, 'V', 'Masculino', '1998-12-27', '04269422081', '02409940123', 'alvaroospino79@gmail.com', 'EMPLEADO FIJO', '2001-11-23', 'DOCTOR', 'DOCENTE', 'EXCLUSIVA', 'si', 'TITULAR', '123456654123', 0, 0, 0, 0, 0, 'Ing. Informático', 'PNFI', 'Coordinador'),
(2, 'ACTIVO', 'Silfredo', 'Rivero', 9868006, 'V', 'Masculino', '1967-10-18', '202022', '987665', '@david', 'EMPLEADO FIJO', '2002-02-13', 'MASTER', 'DOCENTE', 'EXCLUSIVA', 'si', 'ASOCIADO', '0175009083647', 0, 0, 0, 0, 0, 'Ing. Mecánico', 'Presupuesto', 'Contador'),
(3, 'ACTIVO', 'Pedro', 'Carmona', 20565644, 'V', 'Masculino', '1979-12-27', '426942', '240', 'pedritocarmona@', 'EMPLEADO FIJO', '2001-09-09', 'MASTER', 'OBRERO', 'TIEMPO COMPLETO', 'si', '1/ 2/ 3', '0029292929292', 5, 120, 0, 0, 0, 'Ing agrónomo', 'Vigilancia', 'Jefe'),
(4, 'ACTIVO', 'Yenny Josefina', 'Peñuela Sanchez', 13149202, 'V', 'Femenino', '1977-08-29', '04164737634', '02409940793', 'yenny829@', 'CONTRATADO', '2014-10-02', 'LICENCIADO', 'ADMINISTRATIVO', 'TIEMPO COMPLETO', 'si', 'APOYO NIVEL 1', '0029292929292', 0, 0, 0, 0, 0, 'Lic. Comunicación social', 'Vinculación social', 'Director'),
(5, 'ACTIVO', 'Leo Andres', 'Messi', 13145920, 'E', 'Masculino', '1987-06-28', '04165641236', '02409940326', 'leo@gmail.com', 'ALTO NIVEL', '2015-10-29', 'DOCTOR', 'ADMINISTRATIVO', 'TIEMPO COMPLETO', 'no', 'APOYO NIVEL 1', '0017500902312121', 0, 0, 0, 0, 0, '', '', ''),
(6, 'JUBILADO', 'Jose', 'Peña', 25657161, 'V', 'Masculino', '1981-11-30', '24323232323', '232323232', '@peña', 'CONTRATADO', '2012-11-29', 'TSU', 'DOCENTE', 'EXCLUSIVA', 'no', 'AGREGADO', '343434343', 0, 0, 0, 0, 0, 'Ing. Agrónomo', 'PNF Agroalimentación', 'Maestro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sueldos`
--

CREATE TABLE `sueldos` (
  `id` int(5) NOT NULL,
  `categoria` varchar(40) CHARACTER SET latin1 NOT NULL,
  `cargo` varchar(40) CHARACTER SET latin1 NOT NULL,
  `dedicacion` varchar(40) CHARACTER SET latin1 NOT NULL,
  `salario` double NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `sueldos`
--

INSERT INTO `sueldos` (`id`, `categoria`, `cargo`, `dedicacion`, `salario`, `fecha`) VALUES
(1, 'DOCENTE', 'TITULAR', 'EXCLUSIVA', 717592, '2017-09-01'),
(2, 'DOCENTE', 'TITULAR', 'TIEMPO COMPLETO', 608129, '2017-09-01'),
(3, 'DOCENTE', 'TITULAR', 'MEDIO TIEMPO', 304065, '2017-09-01'),
(4, 'DOCENTE', 'TITULAR', 'TCV 7 Hrs', 212845, '2017-09-01'),
(5, 'DOCENTE', 'TITULAR', 'TCV 6 Hrs', 182439, '2017-09-01'),
(6, 'DOCENTE', 'TITULAR', 'TCV 5 Hrs', 152032, '2017-09-01'),
(7, 'DOCENTE', 'TITULAR', 'TCV 4 Hrs', 121626, '2017-09-01'),
(8, 'DOCENTE', 'TITULAR', 'TCV 3 Hrs', 91219, '2017-09-01'),
(9, 'DOCENTE', 'TITULAR', 'TCV 2 Hrs', 60813, '2017-09-01'),
(10, 'DOCENTE', 'ASOCIADO', 'EXCLUSIVA', 635037, '2017-09-01'),
(11, 'DOCENTE', 'ASOCIADO', 'TIEMPO COMPLETO', 538167, '2017-09-01'),
(12, 'DOCENTE', 'ASOCIADO', 'MEDIO TIEMPO', 269083, '2017-09-01'),
(13, 'DOCENTE', 'ASOCIADO', 'TCV 7 Hrs', 188358, '2017-09-01'),
(14, 'DOCENTE', 'ASOCIADO', 'TCV 6 Hrs', 161450, '2017-09-01'),
(15, 'DOCENTE', 'ASOCIADO', 'TCV 5 Hrs', 134542, '2017-09-01'),
(16, 'DOCENTE', 'ASOCIADO', 'TCV 4 Hrs', 107633, '2017-09-01'),
(17, 'DOCENTE', 'ASOCIADO', 'TCV 3 Hrs', 80725, '2017-09-01'),
(18, 'DOCENTE', 'ASOCIADO', 'TCV 2 Hrs', 53817, '2017-09-01'),
(19, 'DOCENTE', 'AGREGADO', 'EXCLUSIVA', 561980, '2017-09-01'),
(20, 'DOCENTE', 'AGREGADO', 'TIEMPO COMPLETO', 476253, '2017-09-01'),
(21, 'DOCENTE', 'AGREGADO', 'MEDIO TIEMPO', 238127, '2017-09-01'),
(22, 'DOCENTE', 'AGREGADO', 'TCV 7 Hrs', 166689, '2017-09-01'),
(23, 'DOCENTE', 'AGREGADO', 'TCV 6 Hrs', 142876, '2017-09-01'),
(24, 'DOCENTE', 'AGREGADO', 'TCV 5 Hrs', 119063, '2017-09-01'),
(25, 'DOCENTE', 'AGREGADO', 'TCV 4 Hrs', 95251, '2017-09-01'),
(26, 'DOCENTE', 'AGREGADO', 'TCV 3 Hrs', 71438, '2017-09-01'),
(27, 'DOCENTE', 'AGREGADO', 'TCV 2 Hrs', 47625, '2017-09-01'),
(28, 'DOCENTE', 'ASISTENTE', 'EXCLUSIVA', 497328, '2017-09-01'),
(29, 'DOCENTE', 'ASISTENTE', 'TIEMPO COMPLETO', 421463, '2017-09-01'),
(30, 'DOCENTE', 'ASISTENTE', 'MEDIO TIEMPO', 210732, '2017-09-01'),
(31, 'DOCENTE', 'ASISTENTE', 'TCV 7 Hrs', 147512, '2017-09-01'),
(32, 'DOCENTE', 'ASISTENTE', 'TCV 6 Hrs', 126439, '2017-09-01'),
(33, 'DOCENTE', 'ASISTENTE', 'TCV 5 Hrs', 105366, '2017-09-01'),
(34, 'DOCENTE', 'ASISTENTE', 'TCV 4 Hrs', 84293, '2017-09-01'),
(35, 'DOCENTE', 'ASISTENTE', 'TCV 3 Hrs', 63220, '2017-09-01'),
(36, 'DOCENTE', 'ASISTENTE', 'TCV 2 Hrs', 42146, '2017-09-01'),
(37, 'DOCENTE', 'INSTRUCTOR', 'EXCLUSIVA', 440112, '2017-09-01'),
(38, 'DOCENTE', 'INSTRUCTOR', 'TIEMPO COMPLETO', 372977, '2017-09-01'),
(39, 'DOCENTE', 'INSTRUCTOR', 'MEDIO TIEMPO', 186488, '2017-09-01'),
(40, 'DOCENTE', 'INSTRUCTOR', 'TCV 7 Hrs', 130542, '2017-09-01'),
(41, 'DOCENTE', 'INSTRUCTOR', 'TCV 6 Hrs', 111893, '2017-09-01'),
(42, 'DOCENTE', 'INSTRUCTOR', 'TCV 5 Hrs', 93244, '2017-09-01'),
(43, 'DOCENTE', 'INSTRUCTOR', 'TCV 4 Hrs', 74595, '2017-09-01'),
(44, 'DOCENTE', 'INSTRUCTOR', 'TCV 3 Hrs', 55947, '2017-09-01'),
(45, 'DOCENTE', 'INSTRUCTOR', 'TCV 2 Hrs', 37298, '2017-09-01'),
(46, 'DOCENTE', 'AUXILIAR DOCENTE III', 'EXCLUSIVA', 440112, '2017-09-01'),
(47, 'DOCENTE', 'AUXILIAR DOCENTE III', 'TIEMPO COMPLETO', 372977, '2017-09-01'),
(48, 'DOCENTE', 'AUXILIAR DOCENTE III', 'MEDIO TIEMPO', 186480, '2017-09-01'),
(49, 'DOCENTE', 'AUXILIAR DOCENTE III', 'TCV 7 Hrs', 95118, '2017-09-01'),
(50, 'DOCENTE', 'AUXILIAR DOCENTE III', 'TCV 6 Hrs', 81529, '2017-09-01'),
(51, 'DOCENTE', 'AUXILIAR DOCENTE III', 'TCV 5 Hrs', 67941, '2017-09-01'),
(52, 'DOCENTE', 'AUXILIAR DOCENTE III', 'TCV 4 Hrs', 54353, '2017-09-01'),
(53, 'DOCENTE', 'AUXILIAR DOCENTE III', 'TCV 3 Hrs', 40765, '2017-09-01'),
(54, 'DOCENTE', 'AUXILIAR DOCENTE III', 'TCV 2 Hrs', 27176, '2017-09-01'),
(55, 'DOCENTE', 'AUXILIAR DOCENTE II', 'EXCLUSIVA', 378664, '2017-09-01'),
(56, 'DOCENTE', 'AUXILIAR DOCENTE II', 'TIEMPO COMPLETO', 320901, '2017-09-01'),
(57, 'DOCENTE', 'AUXILIAR DOCENTE II', 'MEDIO TIEMPO', 160450, '2017-09-01'),
(58, 'DOCENTE', 'AUXILIAR DOCENTE II', 'TCV 7 Hrs', 112315, '2017-09-01'),
(59, 'DOCENTE', 'AUXILIAR DOCENTE II', 'TCV 6 Hrs', 96270, '2017-09-01'),
(60, 'DOCENTE', 'AUXILIAR DOCENTE II', 'TCV 5 Hrs', 80225, '2017-09-01'),
(61, 'DOCENTE', 'AUXILIAR DOCENTE II', 'TCV 4 Hrs', 64180, '2017-09-01'),
(62, 'DOCENTE', 'AUXILIAR DOCENTE II', 'TCV 3 Hrs', 48135, '2017-09-01'),
(63, 'DOCENTE', 'AUXILIAR DOCENTE II', 'TCV 2 Hrs', 32090, '2017-09-01'),
(64, 'DOCENTE', 'AUXILIAR DOCENTE I', 'EXCLUSIVA', 320683, '2017-09-01'),
(65, 'DOCENTE', 'AUXILIAR DOCENTE I', 'TIEMPO COMPLETO', 271764, '2017-09-01'),
(66, 'DOCENTE', 'AUXILIAR DOCENTE I', 'MEDIO TIEMPO', 135883, '2017-09-01'),
(67, 'DOCENTE', 'AUXILIAR DOCENTE I', 'TCV 7 Hrs', 130542, '2017-09-01'),
(68, 'DOCENTE', 'AUXILIAR DOCENTE I', 'TCV 6 Hrs', 111893, '2017-09-01'),
(69, 'DOCENTE', 'AUXILIAR DOCENTE I', 'TCV 5 Hrs', 93244, '2017-09-01'),
(70, 'DOCENTE', 'AUXILIAR DOCENTE I', 'TCV 4 Hrs', 74595, '2017-09-01'),
(71, 'DOCENTE', 'AUXILIAR DOCENTE I', 'TCV 3 Hrs', 55947, '2017-09-01'),
(72, 'DOCENTE', 'AUXILIAR DOCENTE I', 'TCV 2 Hrs', 37298, '2017-09-01'),
(73, 'ADMINISTRATIVO', 'APOYO NIVEL 1', 'TIEMPO COMPLETO', 234181.45, '2017-09-01'),
(74, 'ADMINISTRATIVO', 'APOYO NIVEL 2', 'TIEMPO COMPLETO', 245749, '2017-09-01'),
(75, 'ADMINISTRATIVO', 'APOYO NIVEL 3', 'TIEMPO COMPLETO', 258749, '2017-09-01'),
(76, 'ADMINISTRATIVO', 'APOYO NIVEL 4', 'TIEMPO COMPLETO', 271764, '2017-09-01'),
(77, 'ADMINISTRATIVO', 'APOYO NIVEL 5', 'TIEMPO COMPLETO', 287662, '2017-09-01'),
(78, 'ADMINISTRATIVO', 'TÉCNICO NIVEL 6', 'TIEMPO COMPLETO', 296321, '2017-09-01'),
(79, 'ADMINISTRATIVO', 'TÉCNICO NIVEL 7', 'TIEMPO COMPLETO', 307878, '2017-09-01'),
(80, 'ADMINISTRATIVO', 'TÉCNICO NIVEL 8', 'TIEMPO COMPLETO', 320901, '2017-09-01'),
(81, 'ADMINISTRATIVO', 'TÉCNICO NIVEL 9', 'TIEMPO COMPLETO', 332486, '2017-09-01'),
(82, 'ADMINISTRATIVO', 'TÉCNICO NIVEL 10', 'TIEMPO COMPLETO', 346948, '2017-09-01'),
(83, 'ADMINISTRATIVO', 'PROFESIONAL NIVEL 11', 'TIEMPO COMPLETO', 355622, '2017-09-01'),
(84, 'ADMINISTRATIVO', 'PROFESIONAL NIVEL 12', 'TIEMPO COMPLETO', 372977, '2017-09-01'),
(85, 'ADMINISTRATIVO', 'PROFESIONAL NIVEL 13', 'TIEMPO COMPLETO', 399085, '2017-09-01'),
(86, 'ADMINISTRATIVO', 'PROFESIONAL NIVEL 14', 'TIEMPO COMPLETO', 427021, '2017-09-01'),
(87, 'ADMINISTRATIVO', 'PROFESIONAL NIVEL 15', 'TIEMPO COMPLETO', 456912, '2017-09-01'),
(88, 'OBRERO', '1/ 2/ 3', 'TIEMPO COMPLETO', 218861, '2017-09-01'),
(89, 'OBRERO', '4', 'TIEMPO COMPLETO', 234181, '2017-09-01'),
(90, 'OBRERO', '5', 'TIEMPO COMPLETO', 250573, '2017-09-01'),
(91, 'OBRERO', '6', 'TIEMPO COMPLETO', 268114, '2017-09-01'),
(92, 'OBRERO', '7', 'TIEMPO COMPLETO', 286881, '2017-09-01'),
(93, 'DOCENTE', 'INSTRUCTOR', 'EXCLUSIVA', 854627, '2018-01-01'),
(94, 'DOCENTE', 'INSTRUCTOR', 'TIEMPO COMPLETO', 724656, '2018-01-01'),
(95, 'DOCENTE', 'INSTRUCTOR', 'MEDIO TIEMPO', 363571, '2018-01-01'),
(96, 'DOCENTE', 'INSTRUCTOR', 'TCV 7 Hrs', 254723, '2018-01-01'),
(97, 'DOCENTE', 'INSTRUCTOR', 'TCV 6 Hrs', 217695, '2018-01-01'),
(98, 'DOCENTE', 'INSTRUCTOR', 'TCV 5 Hrs', 180419, '2018-01-01'),
(99, 'DOCENTE', 'INSTRUCTOR', 'TCV 4 Hrs', 145876, '2018-01-01'),
(100, 'DOCENTE', 'INSTRUCTOR', 'TCV 3 Hrs', 108848, '2018-01-01'),
(101, 'DOCENTE', 'INSTRUCTOR', 'TCV 2 Hrs', 71571, '2018-01-01'),
(102, 'DOCENTE', 'ASISTENTE', 'EXCLUSIVA', 966209, '2018-01-01'),
(103, 'DOCENTE', 'ASISTENTE', 'TIEMPO COMPLETO', 820084, '2018-01-01'),
(104, 'DOCENTE', 'ASISTENTE', 'MEDIO TIEMPO', 408800, '2018-01-01'),
(105, 'DOCENTE', 'ASISTENTE', 'TCV 7 Hrs', 286533, '2018-01-01'),
(106, 'DOCENTE', 'ASISTENTE', 'TCV 6 Hrs', 246771, '2018-01-01'),
(107, 'DOCENTE', 'ASISTENTE', 'TCV 5 Hrs', 204276, '2018-01-01'),
(108, 'DOCENTE', 'ASISTENTE', 'TCV 4 Hrs', 164514, '2018-01-01'),
(109, 'DOCENTE', 'ASISTENTE', 'TCV 3 Hrs', 122019, '2018-01-01'),
(110, 'DOCENTE', 'ASISTENTE', 'TCV 2 Hrs', 82257, '2018-01-01'),
(111, 'DOCENTE', 'AGREGADO', 'EXCLUSIVA', 1093446, '2018-01-01'),
(112, 'DOCENTE', 'AGREGADO', 'TIEMPO COMPLETO', 926198, '2018-01-01'),
(113, 'DOCENTE', 'AGREGADO', 'MEDIO TIEMPO', 461732, '2018-01-01'),
(114, 'DOCENTE', 'AGREGADO', 'TCV 7 Hrs', 323809, '2018-01-01'),
(115, 'DOCENTE', 'AGREGADO', 'TCV 6 Hrs', 278580, '2018-01-01'),
(116, 'DOCENTE', 'AGREGADO', 'TCV 5 Hrs', 230866, '2018-01-01'),
(117, 'DOCENTE', 'AGREGADO', 'TCV 4 Hrs', 185886, '2018-01-01'),
(118, 'DOCENTE', 'AGREGADO', 'TCV 3 Hrs', 137923, '2018-01-01'),
(119, 'DOCENTE', 'AGREGADO', 'TCV 2 Hrs', 92943, '2018-01-01'),
(120, 'DOCENTE', 'ASOCIADO', 'EXCLUSIVA', 1234103, '2018-01-01'),
(121, 'DOCENTE', 'ASOCIADO', 'TIEMPO COMPLETO', 1045732, '2018-01-01'),
(122, 'DOCENTE', 'ASOCIADO', 'MEDIO TIEMPO', 522866, '2018-01-01'),
(123, 'DOCENTE', 'ASOCIADO', 'TCV 7 Hrs', 366304, '2018-01-01'),
(124, 'DOCENTE', 'ASOCIADO', 'TCV 6 Hrs', 313123, '2018-01-01'),
(125, 'DOCENTE', 'ASOCIADO', 'TCV 5 Hrs', 262676, '2018-01-01'),
(126, 'DOCENTE', 'ASOCIADO', 'TCV 4 Hrs', 209743, '2018-01-01'),
(127, 'DOCENTE', 'ASOCIADO', 'TCV 3 Hrs', 156562, '2018-01-01'),
(128, 'DOCENTE', 'ASOCIADO', 'TCV 2 Hrs', 103629, '2018-01-01'),
(129, 'DOCENTE', 'TITULAR', 'EXCLUSIVA', 1396132, '2018-01-01'),
(130, 'DOCENTE', 'TITULAR', 'TIEMPO COMPLETO', 1181170, '2018-01-01'),
(131, 'DOCENTE', 'TITULAR', 'MEDIO TIEMPO', 591952, '2018-01-01'),
(132, 'DOCENTE', 'TITULAR', 'TCV 7 Hrs', 414018, '2018-01-01'),
(133, 'DOCENTE', 'TITULAR', 'TCV 6 Hrs', 355618, '2018-01-01'),
(134, 'DOCENTE', 'TITULAR', 'TCV 5 Hrs', 294733, '2018-01-01'),
(135, 'DOCENTE', 'TITULAR', 'TCV 4 Hrs', 236333, '2018-01-01'),
(136, 'DOCENTE', 'TITULAR', 'TCV 3 Hrs', 177933, '2018-01-01'),
(137, 'DOCENTE', 'TITULAR', 'TCV 2 Hrs', 119534, '2018-01-01'),
(138, 'DOCENTE', 'AUXILIAR DOCENTE I', 'EXCLUSIVA', 623761, '2018-01-01'),
(139, 'DOCENTE', 'AUXILIAR DOCENTE I', 'TIEMPO COMPLETO', 528085, '2018-01-01'),
(140, 'DOCENTE', 'AUXILIAR DOCENTE I', 'MEDIO TIEMPO', 265409, '2018-01-01'),
(141, 'DOCENTE', 'AUXILIAR DOCENTE I', 'TCV 7 Hrs', 185886, '2018-01-01'),
(142, 'DOCENTE', 'AUXILIAR DOCENTE I', 'TCV 6 Hrs', 159295, '2018-01-01'),
(143, 'DOCENTE', 'AUXILIAR DOCENTE I', 'TCV 5 Hrs', 132705, '2018-01-01'),
(144, 'DOCENTE', 'AUXILIAR DOCENTE I', 'TCV 4 Hrs', 106114, '2018-01-01'),
(145, 'DOCENTE', 'AUXILIAR DOCENTE I', 'TCV 3 Hrs', 79523, '2018-01-01'),
(146, 'DOCENTE', 'AUXILIAR DOCENTE I', 'TCV 2 Hrs', 53181, '2018-01-01'),
(147, 'DOCENTE', 'AUXILIAR DOCENTE II', 'EXCLUSIVA', 735094, '2018-01-01'),
(148, 'DOCENTE', 'AUXILIAR DOCENTE II', 'TIEMPO COMPLETO', 623761, '2018-01-01'),
(149, 'DOCENTE', 'AUXILIAR DOCENTE II', 'MEDIO TIEMPO', 313123, '2018-01-01'),
(150, 'DOCENTE', 'AUXILIAR DOCENTE II', 'TCV 7 Hrs', 217695, '2018-01-01'),
(151, 'DOCENTE', 'AUXILIAR DOCENTE II', 'TCV 6 Hrs', 188371, '2018-01-01'),
(152, 'DOCENTE', 'AUXILIAR DOCENTE II', 'TCV 5 Hrs', 156562, '2018-01-01'),
(153, 'DOCENTE', 'AUXILIAR DOCENTE II', 'TCV 4 Hrs', 124752, '2018-01-01'),
(154, 'DOCENTE', 'AUXILIAR DOCENTE II', 'TCV 3 Hrs', 92943, '2018-01-01'),
(155, 'DOCENTE', 'AUXILIAR DOCENTE II', 'TCV 2 Hrs', 63619, '2018-01-01'),
(156, 'DOCENTE', 'AUXILIAR DOCENTE III', 'EXCLUSIVA', 854627, '2018-01-01'),
(157, 'DOCENTE', 'AUXILIAR DOCENTE III', 'TIEMPO COMPLETO', 724656, '2018-01-01'),
(158, 'DOCENTE', 'AUXILIAR DOCENTE III', 'MEDIO TIEMPO', 363571, '2018-01-01'),
(159, 'DOCENTE', 'AUXILIAR DOCENTE III', 'TCV 7 Hrs', 254723, '2018-01-01'),
(160, 'DOCENTE', 'AUXILIAR DOCENTE III', 'TCV 6 Hrs', 217695, '2018-01-01'),
(161, 'DOCENTE', 'AUXILIAR DOCENTE III', 'TCV 5 Hrs', 180419, '2018-01-01'),
(162, 'DOCENTE', 'AUXILIAR DOCENTE III', 'TCV 4 Hrs', 145876, '2018-01-01'),
(163, 'DOCENTE', 'AUXILIAR DOCENTE III', 'TCV 3 Hrs', 108848, '2018-01-01'),
(164, 'DOCENTE', 'AUXILIAR DOCENTE III', 'TCV 2 Hrs', 71571, '2018-01-01'),
(165, 'ADMINISTRATIVO', 'APOYO NIVEL 1', 'TIEMPO COMPLETO', 456514.23, '2018-01-01'),
(166, 'ADMINISTRATIVO', 'APOYO NIVEL 2', 'TIEMPO COMPLETO', 477637, '2018-01-01'),
(167, 'ADMINISTRATIVO', 'APOYO NIVEL 3', 'TIEMPO COMPLETO', 501743, '2018-01-01'),
(168, 'ADMINISTRATIVO', 'APOYO NIVEL 4', 'TIEMPO COMPLETO', 528085, '2018-01-01'),
(169, 'ADMINISTRATIVO', 'APOYO NIVEL 5', 'TIEMPO COMPLETO', 560142, '2018-01-01'),
(170, 'ADMINISTRATIVO', 'TÉCNICO NIVEL 6', 'TIEMPO COMPLETO', 576047, '2018-01-01'),
(171, 'ADMINISTRATIVO', 'TÉCNICO NIVEL 7', 'TIEMPO COMPLETO', 597171, '2018-01-01'),
(172, 'ADMINISTRATIVO', 'TÉCNICO NIVEL 8', 'TIEMPO COMPLETO', 623761, '2018-01-01'),
(173, 'ADMINISTRATIVO', 'TÉCNICO NIVEL 9', 'TIEMPO COMPLETO', 647618, '2018-01-01'),
(174, 'ADMINISTRATIVO', 'TÉCNICO NIVEL 10', 'TIEMPO COMPLETO', 674209, '2018-01-01'),
(175, 'ADMINISTRATIVO', 'PROFESIONAL NIVEL 11', 'TIEMPO COMPLETO', 690113, '2018-01-01'),
(176, 'ADMINISTRATIVO', 'PROFESIONAL NIVEL 12', 'TIEMPO COMPLETO', 724656, '2018-01-01'),
(177, 'ADMINISTRATIVO', 'PROFESIONAL NIVEL 13', 'TIEMPO COMPLETO', 775104, '2018-01-01'),
(178, 'ADMINISTRATIVO', 'PROFESIONAL NIVEL 14', 'TIEMPO COMPLETO', 830770, '2018-01-01'),
(179, 'ADMINISTRATIVO', 'PROFESIONAL NIVEL 15', 'TIEMPO COMPLETO', 889170, '2018-01-01'),
(180, 'OBRERO', '1/ 2/ 3', 'TIEMPO COMPLETO', 426692, '2018-01-01'),
(181, 'OBRERO', '4', 'TIEMPO COMPLETO', 456514, '2018-01-01'),
(182, 'OBRERO', '5', 'TIEMPO COMPLETO', 488571, '2018-01-01'),
(183, 'OBRERO', '6', 'TIEMPO COMPLETO', 522866, '2018-01-01'),
(184, 'OBRERO', '7', 'TIEMPO COMPLETO', 559397, '2018-01-01'),
(185, 'DOCENTE', 'INSTRUCTOR', 'EXCLUSIVA', 572146, '2017-11-01'),
(186, 'DOCENTE', 'INSTRUCTOR', 'TIEMPO COMPLETO', 484870, '2017-11-01'),
(187, 'DOCENTE', 'INSTRUCTOR', 'MEDIO TIEMPO', 242434, '2017-11-01'),
(188, 'DOCENTE', 'INSTRUCTOR', 'TCV 7 Hrs', 169705, '2017-11-01'),
(189, 'DOCENTE', 'INSTRUCTOR', 'TCV 6 Hrs', 145461, '2017-11-01'),
(190, 'DOCENTE', 'INSTRUCTOR', 'TCV 5 Hrs', 121217, '2017-11-01'),
(191, 'DOCENTE', 'INSTRUCTOR', 'TCV 4 Hrs', 96974, '2017-11-01'),
(192, 'DOCENTE', 'INSTRUCTOR', 'TCV 3 Hrs', 72731, '2017-11-01'),
(193, 'DOCENTE', 'INSTRUCTOR', 'TCV 2 Hrs', 48487, '2017-11-01'),
(194, 'DOCENTE', 'ASISTENTE', 'EXCLUSIVA', 646526, '2017-11-01'),
(195, 'DOCENTE', 'ASISTENTE', 'TIEMPO COMPLETO', 547902, '2017-11-01'),
(196, 'DOCENTE', 'ASISTENTE', 'MEDIO TIEMPO', 273952, '2017-11-01'),
(197, 'DOCENTE', 'ASISTENTE', 'TCV 7 Hrs', 191766, '2017-11-01'),
(198, 'DOCENTE', 'ASISTENTE', 'TCV 6 Hrs', 164371, '2017-11-01'),
(199, 'DOCENTE', 'ASISTENTE', 'TCV 5 Hrs', 136976, '2017-11-01'),
(200, 'DOCENTE', 'ASISTENTE', 'TCV 4 Hrs', 109581, '2017-11-01'),
(201, 'DOCENTE', 'ASISTENTE', 'TCV 3 Hrs', 82186, '2017-11-01'),
(202, 'DOCENTE', 'ASISTENTE', 'TCV 2 Hrs', 54790, '2017-11-01'),
(203, 'DOCENTE', 'AGREGADO', 'EXCLUSIVA', 730574, '2017-11-01'),
(204, 'DOCENTE', 'AGREGADO', 'TIEMPO COMPLETO', 619129, '2017-11-01'),
(205, 'DOCENTE', 'AGREGADO', 'MEDIO TIEMPO', 309565, '2017-11-01'),
(206, 'DOCENTE', 'AGREGADO', 'TCV 7 Hrs', 216696, '2017-11-01'),
(207, 'DOCENTE', 'AGREGADO', 'TCV 6 Hrs', 185739, '2017-11-01'),
(208, 'DOCENTE', 'AGREGADO', 'TCV 5 Hrs', 154782, '2017-11-01'),
(209, 'DOCENTE', 'AGREGADO', 'TCV 4 Hrs', 123826, '2017-11-01'),
(210, 'DOCENTE', 'AGREGADO', 'TCV 3 Hrs', 92869, '2017-11-01'),
(211, 'DOCENTE', 'AGREGADO', 'TCV 2 Hrs', 61913, '2017-11-01'),
(212, 'DOCENTE', 'ASOCIADO', 'EXCLUSIVA', 825548, '2017-11-01'),
(213, 'DOCENTE', 'ASOCIADO', 'TIEMPO COMPLETO', 699617, '2017-11-01'),
(214, 'DOCENTE', 'ASOCIADO', 'MEDIO TIEMPO', 349808, '2017-11-01'),
(215, 'DOCENTE', 'ASOCIADO', 'TCV 7 Hrs', 244865, '2017-11-01'),
(216, 'DOCENTE', 'ASOCIADO', 'TCV 6 Hrs', 209885, '2017-11-01'),
(217, 'DOCENTE', 'ASOCIADO', 'TCV 5 Hrs', 174905, '2017-11-01'),
(218, 'DOCENTE', 'ASOCIADO', 'TCV 4 Hrs', 139923, '2017-11-01'),
(219, 'DOCENTE', 'ASOCIADO', 'TCV 3 Hrs', 104943, '2017-11-01'),
(220, 'DOCENTE', 'ASOCIADO', 'TCV 2 Hrs', 69962, '2017-11-01'),
(221, 'DOCENTE', 'TITULAR', 'EXCLUSIVA', 932870, '2017-11-01'),
(222, 'DOCENTE', 'TITULAR', 'TIEMPO COMPLETO', 790568, '2017-11-01'),
(223, 'DOCENTE', 'TITULAR', 'MEDIO TIEMPO', 395285, '2017-11-01'),
(224, 'DOCENTE', 'TITULAR', 'TCV 7 Hrs', 276699, '2017-11-01'),
(225, 'DOCENTE', 'TITULAR', 'TCV 6 Hrs', 237171, '2017-11-01'),
(226, 'DOCENTE', 'TITULAR', 'TCV 5 Hrs', 197642, '2017-11-01'),
(227, 'DOCENTE', 'TITULAR', 'TCV 4 Hrs', 158114, '2017-11-01'),
(228, 'DOCENTE', 'TITULAR', 'TCV 3 Hrs', 118585, '2017-11-01'),
(229, 'DOCENTE', 'TITULAR', 'TCV 2 Hrs', 79057, '2017-11-01'),
(230, 'DOCENTE', 'AUXILIAR DOCENTE I', 'EXCLUSIVA', 416888, '2017-11-01'),
(231, 'DOCENTE', 'AUXILIAR DOCENTE I', 'TIEMPO COMPLETO', 353293, '2017-11-01'),
(232, 'DOCENTE', 'AUXILIAR DOCENTE I', 'MEDIO TIEMPO', 176648, '2017-11-01'),
(233, 'DOCENTE', 'AUXILIAR DOCENTE I', 'TCV 7 Hrs', 123653, '2017-11-01'),
(234, 'DOCENTE', 'AUXILIAR DOCENTE I', 'TCV 6 Hrs', 105988, '2017-11-01'),
(235, 'DOCENTE', 'AUXILIAR DOCENTE I', 'TCV 5 Hrs', 88323, '2017-11-01'),
(236, 'DOCENTE', 'AUXILIAR DOCENTE I', 'TCV 4 Hrs', 70659, '2017-11-01'),
(237, 'DOCENTE', 'AUXILIAR DOCENTE I', 'TCV 3 Hrs', 52995, '2017-11-01'),
(238, 'DOCENTE', 'AUXILIAR DOCENTE I', 'TCV 2 Hrs', 35329, '2017-11-01'),
(239, 'DOCENTE', 'AUXILIAR DOCENTE II', 'EXCLUSIVA', 492263, '2017-11-01'),
(240, 'DOCENTE', 'AUXILIAR DOCENTE II', 'TIEMPO COMPLETO', 417171, '2017-11-01'),
(241, 'DOCENTE', 'AUXILIAR DOCENTE II', 'MEDIO TIEMPO', 208585, '2017-11-01'),
(242, 'DOCENTE', 'AUXILIAR DOCENTE II', 'TCV 7 Hrs', 146010, '2017-11-01'),
(243, 'DOCENTE', 'AUXILIAR DOCENTE II', 'TCV 6 Hrs', 125151, '2017-11-01'),
(244, 'DOCENTE', 'AUXILIAR DOCENTE II', 'TCV 5 Hrs', 104293, '2017-11-01'),
(245, 'DOCENTE', 'AUXILIAR DOCENTE II', 'TCV 4 Hrs', 83434, '2017-11-01'),
(246, 'DOCENTE', 'AUXILIAR DOCENTE II', 'TCV 3 Hrs', 62576, '2017-11-01'),
(247, 'DOCENTE', 'AUXILIAR DOCENTE II', 'TCV 2 Hrs', 41717, '2017-11-01'),
(248, 'DOCENTE', 'AUXILIAR DOCENTE III', 'EXCLUSIVA', 572146, '2017-11-01'),
(249, 'DOCENTE', 'AUXILIAR DOCENTE III', 'TIEMPO COMPLETO', 484870, '2017-11-01'),
(250, 'DOCENTE', 'AUXILIAR DOCENTE III', 'MEDIO TIEMPO', 242424, '2017-11-01'),
(251, 'DOCENTE', 'AUXILIAR DOCENTE III', 'TCV 7 Hrs', 169705, '2017-11-01'),
(252, 'DOCENTE', 'AUXILIAR DOCENTE III', 'TCV 6 Hrs', 145461, '2017-11-01'),
(253, 'DOCENTE', 'AUXILIAR DOCENTE III', 'TCV 5 Hrs', 121217, '2017-11-01'),
(254, 'DOCENTE', 'AUXILIAR DOCENTE III', 'TCV 4 Hrs', 96974, '2017-11-01'),
(255, 'DOCENTE', 'AUXILIAR DOCENTE III', 'TCV 3 Hrs', 72731, '2017-11-01'),
(256, 'DOCENTE', 'AUXILIAR DOCENTE III', 'TCV 2 Hrs', 48487, '2017-11-01'),
(257, 'ADMINISTRATIVO', 'APOYO NIVEL 1', 'TIEMPO COMPLETO', 304435.33, '2017-11-01'),
(258, 'ADMINISTRATIVO', 'APOYO NIVEL 2', 'TIEMPO COMPLETO', 319474, '2017-11-01'),
(259, 'ADMINISTRATIVO', 'APOYO NIVEL 3', 'TIEMPO COMPLETO', 336374, '2017-11-01'),
(260, 'ADMINISTRATIVO', 'APOYO NIVEL 4', 'TIEMPO COMPLETO', 353293, '2017-11-01'),
(261, 'ADMINISTRATIVO', 'APOYO NIVEL 5', 'TIEMPO COMPLETO', 373961, '2017-11-01'),
(262, 'ADMINISTRATIVO', 'TÉCNICO NIVEL 6', 'TIEMPO COMPLETO', 385217, '2017-11-01'),
(263, 'ADMINISTRATIVO', 'TÉCNICO NIVEL 7', 'TIEMPO COMPLETO', 400241, '2017-11-01'),
(264, 'ADMINISTRATIVO', 'TÉCNICO NIVEL 8', 'TIEMPO COMPLETO', 417171, '2017-11-01'),
(265, 'ADMINISTRATIVO', 'TÉCNICO NIVEL 9', 'TIEMPO COMPLETO', 432232, '2017-11-01'),
(266, 'ADMINISTRATIVO', 'TÉCNICO NIVEL 10', 'TIEMPO COMPLETO', 451032, '2017-11-01'),
(267, 'ADMINISTRATIVO', 'PROFESIONAL NIVEL 11', 'TIEMPO COMPLETO', 462309, '2017-11-01'),
(268, 'ADMINISTRATIVO', 'PROFESIONAL NIVEL 12', 'TIEMPO COMPLETO', 484870, '2017-11-01'),
(269, 'ADMINISTRATIVO', 'PROFESIONAL NIVEL 13', 'TIEMPO COMPLETO', 518811, '2017-11-01'),
(270, 'ADMINISTRATIVO', 'PROFESIONAL NIVEL 14', 'TIEMPO COMPLETO', 555127, '2017-11-01'),
(271, 'ADMINISTRATIVO', 'PROFESIONAL NIVEL 15', 'TIEMPO COMPLETO', 593986, '2017-11-01'),
(272, 'OBRERO', '1/ 2/ 3', 'TIEMPO COMPLETO', 284519, '2017-11-01'),
(273, 'OBRERO', '4', 'TIEMPO COMPLETO', 304435, '2017-11-01'),
(274, 'OBRERO', '5', 'TIEMPO COMPLETO', 325745, '2017-11-01'),
(275, 'OBRERO', '6', 'TIEMPO COMPLETO', 348548, '2017-11-01'),
(276, 'OBRERO', '7', 'TIEMPO COMPLETO', 372945, '2017-11-01'),
(369, 'ADMINISTRATIVO', 'APOYO NIVEL 1', 'TIEMPO COMPLETO', 721292, '2018-02-15'),
(370, 'ADMINISTRATIVO', 'APOYO NIVEL 2', 'TIEMPO COMPLETO', 754666, '2018-02-15'),
(371, 'ADMINISTRATIVO', 'APOYO NIVEL 3', 'TIEMPO COMPLETO', 792753, '2018-02-15'),
(372, 'ADMINISTRATIVO', 'APOYO NIVEL 4', 'TIEMPO COMPLETO', 834374, '2018-02-15'),
(373, 'ADMINISTRATIVO', 'APOYO NIVEL 5', 'TIEMPO COMPLETO', 885025, '2018-02-15'),
(374, 'ADMINISTRATIVO', 'PROFESIONAL NIVEL 11', 'TIEMPO COMPLETO', 1090379, '2018-02-15'),
(375, 'ADMINISTRATIVO', 'PROFESIONAL NIVEL 12', 'TIEMPO COMPLETO', 1144957, '2018-02-15'),
(376, 'ADMINISTRATIVO', 'PROFESIONAL NIVEL 13', 'TIEMPO COMPLETO', 1224664, '2018-02-15'),
(377, 'ADMINISTRATIVO', 'PROFESIONAL NIVEL 14', 'TIEMPO COMPLETO', 1312617, '2018-02-15'),
(378, 'ADMINISTRATIVO', 'PROFESIONAL NIVEL 15', 'TIEMPO COMPLETO', 1404889, '2018-02-15'),
(379, 'ADMINISTRATIVO', 'TÉCNICO NIVEL 10', 'TIEMPO COMPLETO', 1065250, '2018-02-15'),
(380, 'ADMINISTRATIVO', 'TÉCNICO NIVEL 6', 'TIEMPO COMPLETO', 910154, '2018-02-15'),
(381, 'ADMINISTRATIVO', 'TÉCNICO NIVEL 7', 'TIEMPO COMPLETO', 943529, '2018-02-15'),
(382, 'ADMINISTRATIVO', 'TÉCNICO NIVEL 8', 'TIEMPO COMPLETO', 985543, '2018-02-15'),
(383, 'ADMINISTRATIVO', 'TÉCNICO NIVEL 9', 'TIEMPO COMPLETO', 1023237, '2018-02-15'),
(384, 'DOCENTE', 'AGREGADO', 'EXCLUSIVA', 1727644, '2018-02-15'),
(385, 'DOCENTE', 'AGREGADO', 'MEDIO TIEMPO', 729537, '2018-02-15'),
(386, 'DOCENTE', 'AGREGADO', 'TCV 2 Hrs', 146339, '2018-02-15'),
(387, 'DOCENTE', 'AGREGADO', 'TCV 3 Hrs', 219509, '2018-02-15'),
(388, 'DOCENTE', 'AGREGADO', 'TCV 4 Hrs', 292679, '2018-02-15'),
(389, 'DOCENTE', 'AGREGADO', 'TCV 5 Hrs', 365848, '2018-02-15'),
(390, 'DOCENTE', 'AGREGADO', 'TCV 6 Hrs', 439018, '2018-02-15'),
(391, 'DOCENTE', 'AGREGADO', 'TCV 7 Hrs', 512188, '2018-02-15'),
(392, 'DOCENTE', 'AGREGADO', 'TIEMPO COMPLETO', 1463393, '2018-02-15'),
(393, 'DOCENTE', 'ASISTENTE', 'EXCLUSIVA', 1526609, '2018-02-15'),
(394, 'DOCENTE', 'ASISTENTE', 'MEDIO TIEMPO', 645903, '2018-02-15'),
(395, 'DOCENTE', 'ASISTENTE', 'TCV 2 Hrs', 129573, '2018-02-15'),
(396, 'DOCENTE', 'ASISTENTE', 'TCV 3 Hrs', 194360, '2018-02-15'),
(397, 'DOCENTE', 'ASISTENTE', 'TCV 4 Hrs', 259147, '2018-02-15'),
(398, 'DOCENTE', 'ASISTENTE', 'TCV 5 Hrs', 323933, '2018-02-15'),
(399, 'DOCENTE', 'ASISTENTE', 'TCV 6 Hrs', 388720, '2018-02-15'),
(400, 'DOCENTE', 'ASISTENTE', 'TCV 7 Hrs', 453507, '2018-02-15'),
(401, 'DOCENTE', 'ASISTENTE', 'TIEMPO COMPLETO', 1295733, '2018-02-15'),
(402, 'DOCENTE', 'ASOCIADO', 'EXCLUSIVA', 1949882, '2018-02-15'),
(403, 'DOCENTE', 'ASOCIADO', 'MEDIO TIEMPO', 826128, '2018-02-15'),
(404, 'DOCENTE', 'ASOCIADO', 'TCV 2 Hrs', 165226, '2018-02-15'),
(405, 'DOCENTE', 'ASOCIADO', 'TCV 3 Hrs', 247838, '2018-02-15'),
(406, 'DOCENTE', 'ASOCIADO', 'TCV 4 Hrs', 330451, '2018-02-15'),
(407, 'DOCENTE', 'ASOCIADO', 'TCV 5 Hrs', 413064, '2018-02-15'),
(408, 'DOCENTE', 'ASOCIADO', 'TCV 6 Hrs', 495677, '2018-02-15'),
(409, 'DOCENTE', 'ASOCIADO', 'TCV 7 Hrs', 578290, '2018-02-15'),
(410, 'DOCENTE', 'ASOCIADO', 'TIEMPO COMPLETO', 1652256, '2018-02-15'),
(411, 'DOCENTE', 'AUXILIAR DOCENTE I', 'EXCLUSIVA', 985543, '2018-02-15'),
(412, 'DOCENTE', 'AUXILIAR DOCENTE I', 'MEDIO TIEMPO', 419346, '2018-02-15'),
(413, 'DOCENTE', 'AUXILIAR DOCENTE I', 'TCV 2 Hrs', 83437, '2018-02-15'),
(414, 'DOCENTE', 'AUXILIAR DOCENTE I', 'TCV 3 Hrs', 125156, '2018-02-15'),
(415, 'DOCENTE', 'AUXILIAR DOCENTE I', 'TCV 4 Hrs', 166875, '2018-02-15'),
(416, 'DOCENTE', 'AUXILIAR DOCENTE I', 'TCV 5 Hrs', 208594, '2018-02-15'),
(417, 'DOCENTE', 'AUXILIAR DOCENTE I', 'TCV 6 Hrs', 250312, '2018-02-15'),
(418, 'DOCENTE', 'AUXILIAR DOCENTE I', 'TCV 7 Hrs', 292031, '2018-02-15'),
(419, 'DOCENTE', 'AUXILIAR DOCENTE I', 'TIEMPO COMPLETO', 834374, '2018-02-15'),
(420, 'DOCENTE', 'AUXILIAR DOCENTE II', 'EXCLUSIVA', 1161448, '2018-02-15'),
(421, 'DOCENTE', 'AUXILIAR DOCENTE II', 'MEDIO TIEMPO', 494735, '2018-02-15'),
(422, 'DOCENTE', 'AUXILIAR DOCENTE II', 'TCV 2 Hrs', 98554, '2018-02-15'),
(423, 'DOCENTE', 'AUXILIAR DOCENTE II', 'TCV 3 Hrs', 147831, '2018-02-15'),
(424, 'DOCENTE', 'AUXILIAR DOCENTE II', 'TCV 4 Hrs', 197109, '2018-02-15'),
(425, 'DOCENTE', 'AUXILIAR DOCENTE II', 'TCV 5 Hrs', 246386, '2018-02-15'),
(426, 'DOCENTE', 'AUXILIAR DOCENTE II', 'TCV 6 Hrs', 295663, '2018-02-15'),
(427, 'DOCENTE', 'AUXILIAR DOCENTE II', 'TCV 7 Hrs', 344940, '2018-02-15'),
(428, 'DOCENTE', 'AUXILIAR DOCENTE II', 'TIEMPO COMPLETO', 985543, '2018-02-15'),
(429, 'DOCENTE', 'AUXILIAR DOCENTE III', 'EXCLUSIVA', 1350311, '2018-02-15'),
(430, 'DOCENTE', 'AUXILIAR DOCENTE III', 'MEDIO TIEMPO', 574442, '2018-02-15'),
(431, 'DOCENTE', 'AUXILIAR DOCENTE III', 'TCV 2 Hrs', 114496, '2018-02-15'),
(432, 'DOCENTE', 'AUXILIAR DOCENTE III', 'TCV 3 Hrs', 171744, '2018-02-15'),
(433, 'DOCENTE', 'AUXILIAR DOCENTE III', 'TCV 4 Hrs', 228991, '2018-02-15'),
(434, 'DOCENTE', 'AUXILIAR DOCENTE III', 'TCV 5 Hrs', 286239, '2018-02-15'),
(435, 'DOCENTE', 'AUXILIAR DOCENTE III', 'TCV 6 Hrs', 343487, '2018-02-15'),
(436, 'DOCENTE', 'AUXILIAR DOCENTE III', 'TCV 7 Hrs', 400735, '2018-02-15'),
(437, 'DOCENTE', 'AUXILIAR DOCENTE III', 'TIEMPO COMPLETO', 1144957, '2018-02-15'),
(438, 'DOCENTE', 'INSTRUCTOR', 'EXCLUSIVA', 1350311, '2018-02-15'),
(439, 'DOCENTE', 'INSTRUCTOR', 'MEDIO TIEMPO', 574049, '2018-02-15'),
(440, 'DOCENTE', 'INSTRUCTOR', 'TCV 2 Hrs', 114496, '2018-02-15'),
(441, 'DOCENTE', 'INSTRUCTOR', 'TCV 3 Hrs', 171744, '2018-02-15'),
(442, 'DOCENTE', 'INSTRUCTOR', 'TCV 4 Hrs', 228991, '2018-02-15'),
(443, 'DOCENTE', 'INSTRUCTOR', 'TCV 5 Hrs', 286239, '2018-02-15'),
(444, 'DOCENTE', 'INSTRUCTOR', 'TCV 6 Hrs', 343487, '2018-02-15'),
(445, 'DOCENTE', 'INSTRUCTOR', 'TCV 7 Hrs', 400735, '2018-02-15'),
(446, 'DOCENTE', 'INSTRUCTOR', 'TIEMPO COMPLETO', 1144957, '2018-02-15'),
(447, 'DOCENTE', 'TITULAR', 'EXCLUSIVA', 2205888, '2018-02-15'),
(448, 'DOCENTE', 'TITULAR', 'MEDIO TIEMPO', 935284, '2018-02-15'),
(449, 'DOCENTE', 'TITULAR', 'TCV 2 Hrs', 186625, '2018-02-15'),
(450, 'DOCENTE', 'TITULAR', 'TCV 3 Hrs', 279937, '2018-02-15'),
(451, 'DOCENTE', 'TITULAR', 'TCV 4 Hrs', 373250, '2018-02-15'),
(452, 'DOCENTE', 'TITULAR', 'TCV 5 Hrs', 466562, '2018-02-15'),
(453, 'DOCENTE', 'TITULAR', 'TCV 6 Hrs', 559875, '2018-02-15'),
(454, 'DOCENTE', 'TITULAR', 'TCV 7 Hrs', 653187, '2018-02-15'),
(455, 'DOCENTE', 'TITULAR', 'TIEMPO COMPLETO', 1866249, '2018-02-15'),
(456, 'OBRERO', '1/ 2/ 3', 'TIEMPO COMPLETO', 674174, '2018-02-15'),
(457, 'OBRERO', '4', 'TIEMPO COMPLETO', 721292, '2018-02-15'),
(458, 'OBRERO', '5', 'TIEMPO COMPLETO', 771943, '2018-02-15'),
(459, 'OBRERO', '6', 'TIEMPO COMPLETO', 826128, '2018-02-15'),
(460, 'OBRERO', '7', 'TIEMPO COMPLETO', 883847, '2018-02-15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad_tributaria`
--

CREATE TABLE `unidad_tributaria` (
  `id` int(5) NOT NULL,
  `fecha_inicio_vigencia` date NOT NULL,
  `fecha_decreto` date NOT NULL,
  `gaceta_oficial` varchar(20) CHARACTER SET latin1 NOT NULL,
  `valor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `unidad_tributaria`
--

INSERT INTO `unidad_tributaria` (`id`, `fecha_inicio_vigencia`, `fecha_decreto`, `gaceta_oficial`, `valor`) VALUES
(2, '2017-06-20', '2017-06-20', '3306', 300);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valores_globales`
--

CREATE TABLE `valores_globales` (
  `id` int(11) NOT NULL,
  `cat_car_dedic` varchar(4000) COLLATE utf8_spanish_ci NOT NULL,
  `grado_instruccion` varchar(4000) COLLATE utf8_spanish_ci NOT NULL,
  `estado` varchar(4000) COLLATE utf8_spanish_ci NOT NULL,
  `estatus` varchar(4000) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `valores_globales`
--

INSERT INTO `valores_globales` (`id`, `cat_car_dedic`, `grado_instruccion`, `estado`, `estatus`) VALUES
(1, '{"ADMINISTRATIVO":{"cargo":{"0":"APOYO NIVEL 1","1":"APOYO NIVEL 2","2":"APOYO NIVEL 3","3":"APOYO NIVEL 4","4":"APOYO NIVEL 5","5":"PROFESIONAL NIVEL 11","6":"PROFESIONAL NIVEL 12","7":"PROFESIONAL NIVEL 13","8":"PROFESIONAL NIVEL 14","9":"PROFESIONAL NIVEL 15","10":"TÉCNICO NIVEL 10","11":"TÉCNICO NIVEL 6","12":"TÉCNICO NIVEL 7","13":"TÉCNICO NIVEL 8","14":"TÉCNICO NIVEL 9"},"dedicacion":{"0":"TIEMPO COMPLETO"}},"OBRERO":{"cargo":{"0":"1/ 2/ 3","1":"4","2":"5","3":"6","4":"7"},"dedicacion":{"0":"TIEMPO COMPLETO"}},"DOCENTE":{"cargo":{"0":"AGREGADO","1":"ASISTENTE","2":"ASOCIADO","3":"AUXILIAR DOCENTE I","4":"AUXILIAR DOCENTE II","5":"AUXILIAR DOCENTE III","6":"INSTRUCTOR","7":"TITULAR"},"dedicacion":{"0":"EXCLUSIVA","1":"MEDIO TIEMPO","2":"TIEMPO COMPLETO","3":"TCV 2 Hrs","4":"TCV 3 Hrs","5":"TCV 4 Hrs","6":"TCV 5 Hrs","7":"TCV 6 Hrs","8":"TCV 7 Hrs"}}}', '{"0":"TSU","1":"LICENCIADO","2":"ESPECIALISTA","3":"MASTER","4":"DOCTOR","5":"Otro"}', '{"0":"ACTIVO","1":"JUBILADO","2":"PENSIONADO","3":"INACTIVO"}', '{"0":"EMPLEADO FIJO","1":"CONTRATADO","2":"ALTO NIVEL"}');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `autenticar`
--
ALTER TABLE `autenticar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indices de la tabla `formulas`
--
ALTER TABLE `formulas`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `hijos_personal`
--
ALTER TABLE `hijos_personal`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `mail`
--
ALTER TABLE `mail`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cuenta` (`cuenta`);

--
-- Indices de la tabla `mensajeria`
--
ALTER TABLE `mensajeria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `parametros_nomina`
--
ALTER TABLE `parametros_nomina`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `personal_upt`
--
ALTER TABLE `personal_upt`
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `cedula` (`cedula`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `sueldos`
--
ALTER TABLE `sueldos`
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `categoria` (`categoria`,`cargo`,`dedicacion`,`fecha`);

--
-- Indices de la tabla `unidad_tributaria`
--
ALTER TABLE `unidad_tributaria`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `valores_globales`
--
ALTER TABLE `valores_globales`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `autenticar`
--
ALTER TABLE `autenticar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `formulas`
--
ALTER TABLE `formulas`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT de la tabla `hijos_personal`
--
ALTER TABLE `hijos_personal`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `mail`
--
ALTER TABLE `mail`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `mensajeria`
--
ALTER TABLE `mensajeria`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;
--
-- AUTO_INCREMENT de la tabla `parametros_nomina`
--
ALTER TABLE `parametros_nomina`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `personal_upt`
--
ALTER TABLE `personal_upt`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `sueldos`
--
ALTER TABLE `sueldos`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=461;
--
-- AUTO_INCREMENT de la tabla `unidad_tributaria`
--
ALTER TABLE `unidad_tributaria`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `valores_globales`
--
ALTER TABLE `valores_globales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
