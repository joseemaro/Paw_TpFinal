-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3307
-- Tiempo de generación: 06-12-2021 a las 20:47:11
-- Versión del servidor: 10.4.13-MariaDB
-- Versión de PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `inkmaster_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrator`
--

DROP TABLE IF EXISTS `administrator`;
CREATE TABLE IF NOT EXISTS `administrator` (
  `id_administrator` varchar(100) NOT NULL,
  `id_local` int(11) NOT NULL,
  PRIMARY KEY (`id_administrator`),
  KEY `id_local` (`id_local`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `administrator`
--

INSERT INTO `administrator` (`id_administrator`, `id_local`) VALUES
('Administrador', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `appointment`
--

DROP TABLE IF EXISTS `appointment`;
CREATE TABLE IF NOT EXISTS `appointment` (
  `id_appointment` int(11) NOT NULL AUTO_INCREMENT,
  `id_local` int(11) NOT NULL,
  `id_user` varchar(100) NOT NULL,
  `id_artist` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `hour` time NOT NULL,
  `status` varchar(100) NOT NULL,
  `price` double DEFAULT NULL,
  `link` varchar(200) DEFAULT NULL,
  `id_calendar` varchar(100) DEFAULT NULL,
  `txt` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_appointment`),
  KEY `id_local` (`id_local`),
  KEY `id_user` (`id_user`),
  KEY `id_artist` (`id_artist`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `artist`
--

DROP TABLE IF EXISTS `artist`;
CREATE TABLE IF NOT EXISTS `artist` (
  `id_artist` varchar(100) NOT NULL,
  `id_local` int(11) NOT NULL,
  `txt` varchar(300) NOT NULL,
  PRIMARY KEY (`id_artist`),
  KEY `id_local` (`id_local`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `artist`
--

INSERT INTO `artist` (`id_artist`, `id_local`, `txt`) VALUES
('Artista P', 1, 'soy el artista de prueba');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendar_link`
--

DROP TABLE IF EXISTS `calendar_link`;
CREATE TABLE IF NOT EXISTS `calendar_link` (
  `id_artist` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  PRIMARY KEY (`id_artist`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `calendar_link`
--

INSERT INTO `calendar_link` (`id_artist`, `link`) VALUES
('Artista P', '2kh2fa1hufh640kggiaja7at10@group.calendar.google.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `faq`
--

DROP TABLE IF EXISTS `faq`;
CREATE TABLE IF NOT EXISTS `faq` (
  `id_faq` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(100) NOT NULL,
  `answer` varchar(300) NOT NULL,
  `summary` varchar(300) NOT NULL,
  PRIMARY KEY (`id_faq`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `faq`
--

INSERT INTO `faq` (`id_faq`, `question`, `answer`, `summary`) VALUES
(1, '¿Cuánto tiempo tarda un tatuaje en curarse?', 'El tatuaje es una herida en la piel. El tiempo de cicatrización es diferente en cada caso, siendo lo normal entre dos y cuatro semanas. Los primeros días son fundamentales, por eso te damos un kit de cuidados con los elementos necesarios e instrucciones detalladas.', 'El tiempo que se brindará es aproximada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `local`
--

DROP TABLE IF EXISTS `local`;
CREATE TABLE IF NOT EXISTS `local` (
  `id_local` int(11) NOT NULL AUTO_INCREMENT,
  `direction` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `txt` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id_local`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `local`
--

INSERT INTO `local` (`id_local`, `direction`, `province`, `country`, `phone`, `email`, `txt`) VALUES
(1, 'San Martín 498, Luján', 'Buenos Aires', 'Argentina', '2323433247', 'home@inkmaster.com', 'En INK MASTER desde 2018 nos ocupados de ofrecerles contenido de calidad. Contamos con diseños de todo tipo, incluidos tradicionales, japoneses, retratos, negros y grises, tribales y más.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medical_record`
--

DROP TABLE IF EXISTS `medical_record`;
CREATE TABLE IF NOT EXISTS `medical_record` (
  `id_medical_record` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` varchar(100) NOT NULL,
  `considerations` varchar(100) NOT NULL,
  PRIMARY KEY (`id_medical_record`),
  KEY `id_user` (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id_message` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` varchar(100) NOT NULL,
  `id_artist` varchar(100) NOT NULL,
  `txt` varchar(300) NOT NULL,
  PRIMARY KEY (`id_message`),
  KEY `id_user` (`id_user`),
  KEY `id_artist` (`id_artist`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permission`
--

DROP TABLE IF EXISTS `permission`;
CREATE TABLE IF NOT EXISTS `permission` (
  `id_permission` varchar(20) NOT NULL,
  `txt` varchar(100) NOT NULL,
  PRIMARY KEY (`id_permission`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `permission`
--

INSERT INTO `permission` (`id_permission`, `txt`) VALUES
('appointment.acept', 'Confirmar los turnos correspondientes'),
('appointment.edit', 'Editar los turnos correspondientes'),
('appointment.delete', 'Cancelar los turnos correspondientes'),
('user.new', 'Crear un nuevo usuario'),
('user.list', 'Listar usuarios existentes'),
('user.view', 'Visualizar la información perteneciente a un usuario'),
('user.edit', 'Editar la información pertenenciente a un usuario'),
('user.delete', 'Deshabilitar a un usuario'),
('artist.new', 'Crear un nuevo artista'),
('artist.edit', 'Editar la información de un artista'),
('artist.delete', 'Deshabilitar a un artista'),
('tattoo.new', 'Añadir la imagen de un nuevo tattoo'),
('tattoo.delete', 'Eliminar la imagen de un tattoo'),
('faq.new', 'Crear una nueva pregunta frecuente'),
('faq.edit', 'Editar una pregunta frecuente'),
('faq.delete', 'Eliminar una pregunta frecuente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permission_rol`
--

DROP TABLE IF EXISTS `permission_rol`;
CREATE TABLE IF NOT EXISTS `permission_rol` (
  `id_permission_rol` int(11) NOT NULL AUTO_INCREMENT,
  `id_permission` varchar(20) NOT NULL,
  `id_rol` varchar(20) NOT NULL,
  PRIMARY KEY (`id_permission_rol`),
  KEY `id_permission` (`id_permission`),
  KEY `id_rol` (`id_rol`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `permission_rol`
--

INSERT INTO `permission_rol` (`id_permission_rol`, `id_permission`, `id_rol`) VALUES
(1, 'user.new', 'administrator'),
(2, 'user.list', 'administrator'),
(3, 'user.view', 'administrator'),
(4, 'artist.new', 'administrator'),
(5, 'artist.delete', 'administrator'),
(6, 'faq.new', 'administrator'),
(7, 'faq.edit', 'administrator'),
(8, 'faq.delete', 'administrator'),
(9, 'appointment.acept', 'artist'),
(10, 'appointment.edit', 'artist'),
(11, 'appointment.delete', 'artist'),
(12, 'artist.edit', 'artist'),
(13, 'tattoo.new', 'artist'),
(14, 'tattoo.delete', 'artist'),
(15, 'user.edit', 'user'),
(16, 'user.delete', 'user'),
(17, 'user.view', 'user');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reference_image`
--

DROP TABLE IF EXISTS `reference_image`;
CREATE TABLE IF NOT EXISTS `reference_image` (
  `id_reference_image` int(11) NOT NULL AUTO_INCREMENT,
  `id_appointment` int(11) NOT NULL,
  `image` mediumblob NOT NULL,
  PRIMARY KEY (`id_reference_image`),
  KEY `id_appointment` (`id_appointment`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

DROP TABLE IF EXISTS `rol`;
CREATE TABLE IF NOT EXISTS `rol` (
  `id_rol` varchar(20) NOT NULL,
  `txt` varchar(100) NOT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `txt`) VALUES
('user', 'Rol de usuario'),
('artist', 'Rol de artista'),
('administrator', 'Rol de administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_user`
--

DROP TABLE IF EXISTS `rol_user`;
CREATE TABLE IF NOT EXISTS `rol_user` (
  `id_rol_user` int(11) NOT NULL AUTO_INCREMENT,
  `id_rol` varchar(20) NOT NULL,
  `id_user` varchar(20) NOT NULL,
  PRIMARY KEY (`id_rol_user`),
  KEY `id_rol` (`id_rol`),
  KEY `id_user` (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `rol_user`
--

INSERT INTO `rol_user` (`id_rol_user`, `id_rol`, `id_user`) VALUES
(17, 'artist', 'Artista P'),
(16, 'user', 'Artista P'),
(15, 'administrator', 'Administrador'),
(14, 'user', 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tattoo`
--

DROP TABLE IF EXISTS `tattoo`;
CREATE TABLE IF NOT EXISTS `tattoo` (
  `id_tattoo` int(11) NOT NULL AUTO_INCREMENT,
  `id_artist` varchar(100) NOT NULL,
  `id_appointment` int(11) DEFAULT NULL,
  `sector` varchar(20) NOT NULL,
  `image` mediumblob NOT NULL,
  `txt` varchar(200) NOT NULL,
  PRIMARY KEY (`id_tattoo`),
  KEY `id_artist` (`id_artist`),
  KEY `id_appointment` (`id_appointment`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `born` date NOT NULL,
  `nro_doc` varchar(100) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `direction` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `photo` mediumblob DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id_user`, `password`, `first_name`, `last_name`, `born`, `nro_doc`, `phone`, `direction`, `email`, `photo`, `enabled`) VALUES
('Artista P', '$2y$10$SU2Jp56K3GTWIPAXEYnIietg/uIhxPgHQs21AYdj8sITNH61ICYDS', 'Artista', 'Prueba', '1990-01-01', '40404040', '2323232323', 'Argentina', 'artista@gmail.com', NULL, 1),
('Administrador', '$2y$10$PU82pJ8Ck4N8.aa1lpMs9.7W/Z5o/Mnj5P5avsh1kW9pARSmvqbEm', 'Administrador', 'Administrador', '1990-01-01', '40404040', '2323232323', 'Argentina', 'administrador@gmail.com', NULL, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
