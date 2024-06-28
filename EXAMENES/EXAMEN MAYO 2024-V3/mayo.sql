-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 17-05-2024 a las 13:14:09
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
  `Dni` varchar(9) NOT NULL,
  `Nombre` varchar(25) NOT NULL,
  `Apellido1` varchar(25) NOT NULL,
  `Apellido2` varchar(25) NOT NULL,
  `Edad` int(11) NOT NULL,
  `Telefono` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Alumnos`
--

INSERT INTO `Alumnos` (`Dni`, `Nombre`, `Apellido1`, `Apellido2`, `Edad`, `Telefono`) VALUES
('05123456G', 'Mikado', 'Jap', 'Ones', 15, '9133455'),
('05456456C', 'Mar', 'Cador', 'Fernandez', 19, '123456789'),
('05815115P', 'Pedro', 'Mechero', 'Ruiz', 18, '666999888'),
('11111111A', 'Jose', 'Moreno', 'Perez', 13, '666554433'),
('22222222H', 'Teresa', 'Garmendia', 'Lopez', 13, '689010343'),
('55555555P', 'Elena', 'Nitodel', 'Bosque', 17, '262358977'),
('63258741P', 'Pepa', 'Camacho', 'Felipe', 13, '698741523'),
('70193455A', 'Carlos', 'Rodríguez', 'Jiménez', 10, '652483110'),
('70851324T', 'Javier', 'Texeido', 'Diaz', 16, '680347166'),
('71469170Z', 'Agustín', 'Borja', 'Lopez', 12, '666491382'),
('72863944L', 'Eriz', 'Torres', 'García', 14, '692716834'),
('74185296I', 'Paquita', 'Salas', 'Rodriguez', 17, '698523417'),
('88888888Z', 'Pablo', 'Zarate', 'Carvajal', 14, '655901234'),
('95698741L', 'Toni', 'Gonzalo', 'Rivero', 13, '698741523'),
('98741523P', 'Juanita', 'Ruiz', 'Espinosa', 11, '698523741');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Alumnos`
--
ALTER TABLE `Alumnos`
  ADD PRIMARY KEY (`Dni`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
