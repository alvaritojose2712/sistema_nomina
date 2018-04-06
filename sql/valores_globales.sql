-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-02-2018 a las 22:58:09
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
(1, '{''DOCENTE'':{''cargo'':{ 0:''AGREGADO'',1:''ASISTENTE'',2:''ASOCIADO'',3:''AUXILIAR DOCENTE I'',4:''AUXILIAR DOCENTE II'',  5:''AUXILIAR DOCENTE III'', 6:''INSTRUCTOR'',  7:''TITULAR'' },''dedicacion'': { 0:''EXCLUSIVA'',1:''MEDIO TIEMPO'', 2:''TIEMPO COMPLETO'',3:''TCV 2 Hrs'',4:''TCV 3 Hrs'',5:''TCV 4 Hrs'',6:''TCV 5 Hrs'',7:''TCV 6 Hrs'',8:''TCV 7 Hrs''}},''ADMINISTRATIVO'':{''cargo'':{0:''APOYO NIVEL 1'',1:''APOYO NIVEL 2'',2:''APOYO NIVEL 3'',3:''APOYO NIVEL 4'',4:''APOYO NIVEL 5'',5:''PROFESIONAL NIVEL 11'', 6:''PROFESIONAL NIVEL 12'', 7:''PROFESIONAL NIVEL 13'', 8:''PROFESIONAL NIVEL 14'', 9:''PROFESIONAL NIVEL 15'', 10:''TÉCNICO NIVEL 10'',11:''TÉCNICO NIVEL 6'',12:''TÉCNICO NIVEL 7'',13:''TÉCNICO NIVEL 8'',14:''TÉCNICO NIVEL 9''},''dedicacion'':{0:''TIEMPO COMPLETO''}},''OBRERO'':{''cargo'':{0:''1/ 2/ 3'',1:''4'',2:''5'',3:''6'',4:''7''},''dedicacion'':{0:''TIEMPO COMPLETO''}}}', '{0:"TSU", 1:"LICENCIADO",2:"ESPECIALISTA",3:"MASTER",4:"DOCTOR"}', '{0:"ACTIVO",1:"JUBILADO",2:"PENSIONADO"}', '{0:"EMPLEADO FIJO",1:"CONTRATADO",2:"ALTO NIVEL"}');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `valores_globales`
--
ALTER TABLE `valores_globales`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `valores_globales`
--
ALTER TABLE `valores_globales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
