-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 19-06-2024 a las 20:28:48
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mayo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Alumnos`
--

CREATE TABLE `Alumnos` (
  `NIF` varchar(9) NOT NULL,
  `Nombre` varchar(25) NOT NULL,
  `Apellido1` varchar(25) NOT NULL,
  `Apellido2` varchar(25) NOT NULL,
  `Premios` int(11) NOT NULL,
  `Telefono` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Alumnos`
--

INSERT INTO `Alumnos` (`NIF`, `Nombre`, `Apellido1`, `Apellido2`, `Premios`, `Telefono`) VALUES
('05123456G', 'Mi4rrr', 'Ji', 'Ji', 15, '222222'),
('05456456C', 'rrrMu', 'Cuuuuu', 'Cuuuu', 25, '1111111'),
('05815115P', 'Peaa', 'Meaaa', 'Meaaa', 35, '44444444'),
('11111111A', 'JosefaCol', 'Moreeee', 'Moreee', 45, '666554433'),
('22222222H', 'Teresa', 'Garmendia', 'Lopez', 55, '689010343'),
('55555555P', 'Teresa', 'Zarate', 'Bosque', 17, '262358977'),
('63258741P', 'Pepa', 'Camacho', 'Felipe', 13, '698741523'),
('70193455A', 'Car', 'Rod', 'Jim', 10, '652483110'),
('70851324T', 'Javier', 'Texeido', 'Diaz', 16, '680347166'),
('71469170Z', 'Agustina', 'Borrrr', 'Lopppp', 12, '666491382'),
('72863944L', 'Eriz', 'Zarate', 'Diaz', 14, '692716834'),
('74185296I', 'Paquita', 'Salas', 'Rodriguez', 17, '698523417'),
('88888888Z', 'Teresa', 'Zarate', 'Carvajal', 14, '655901234'),
('95698741L', 'Toni', 'Gonzalo', 'Rivero', 13, '698741523'),
('98741523P', 'Juanita', 'Ruiz', 'Espinosa', 11, '698523741');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Alumnos`
--
ALTER TABLE `Alumnos`
  ADD PRIMARY KEY (`NIF`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
