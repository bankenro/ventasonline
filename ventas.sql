-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 20-07-2019 a las 15:08:29
-- Versión del servidor: 8.0.15
-- Versión de PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ventas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `login` varchar(30) NOT NULL,
  `password` varchar(20) NOT NULL,
  `nombres` varchar(40) NOT NULL,
  `apellidos` varchar(40) NOT NULL,
  `direccion` varchar(40) NOT NULL,
  `telefono` varchar(11) NOT NULL,
  `email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`login`, `password`, `nombres`, `apellidos`, `direccion`, `telefono`, `email`) VALUES
('RODO', 'RODO', 'RODO', 'RODO', 'RODO 165', '961266733', 'RODO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle`
--

CREATE TABLE `detalle` (
  `numero_detalle` int(11) NOT NULL,
  `numero_venta` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `codigo` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `detalle`
--

INSERT INTO `detalle` (`numero_detalle`, `numero_venta`, `cantidad`, `codigo`) VALUES
(1, 18, 12, 'HD0001'),
(2, 19, 2, 'TE0001'),
(3, 19, 2, 'TE0002'),
(4, 20, 1, 'HD0001'),
(5, 20, 2, 'PR0001'),
(6, 20, 2, 'PR0002'),
(7, 20, 2, 'MO0002'),
(8, 20, 2, 'MS0002'),
(9, 21, 2, 'HD0001'),
(10, 21, 1, 'PR0001'),
(11, 22, 5, 'HD0001'),
(12, 22, 10, 'MS0002'),
(13, 22, 4, 'TE0001'),
(14, 22, 4, 'MO0001'),
(15, 23, 2, 'MO0002'),
(16, 24, 1, 'PR0001'),
(17, 25, 14, 'HD0001'),
(18, 25, 45, 'PR0002'),
(19, 25, 45, 'MO0002'),
(20, 25, 75, 'MS0002'),
(21, 26, 12, 'HD0001'),
(22, 26, 23, 'PR0002'),
(23, 26, 2, 'MS0002'),
(24, 27, 1, 'HD0001'),
(25, 28, 5, 'MO0002'),
(26, 29, 2, 'PR0001'),
(27, 30, 3, 'PR0002'),
(28, 31, 3, 'MO0001'),
(29, 31, 7, 'MS0002'),
(30, 31, 9, 'MS0001'),
(31, 32, 89, 'PR0002'),
(32, 32, 56, 'MO0001'),
(33, 32, 78, 'MS0002'),
(34, 33, 100, 'PR0001'),
(35, 33, 100, 'HD0002'),
(36, 33, 100, 'TE0002'),
(37, 33, 100, 'MO0001');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `codigo` varchar(10) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `precio` float NOT NULL,
  `cantidad` int(11) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`codigo`, `descripcion`, `precio`, `cantidad`, `stock`) VALUES
('HD0001', 'Disco Duro Maxtor 80GB', 57, 30, 30),
('HD0002', 'Disco Duro 160GB', 90, 20, 20),
('MO0001', 'Monitor LG Flatron', 90, 20, 20),
('MO0002', 'Monitor LG LCD', 280, 20, 20),
('MS0001', 'Mouse PS2 Genius', 4, 50, 50),
('MS0002', 'Mouse Optico Genius', 5, 50, 50),
('PR0001', 'Impresora HP 3650', 55, 15, 15),
('PR0002', 'Impresora HP 3820', 80, 10, 10),
('TE0001', 'Teclado BTC', 6.5, 20, 20),
('TE0002', 'Teclado Multimedia PS2', 8, 10, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `numero_venta` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `total` float NOT NULL,
  `login` varchar(30) NOT NULL,
  `deposito` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`numero_venta`, `fecha`, `total`, `login`, `deposito`) VALUES
(2, '2019-07-17', 0, 'RODO', '1111111111'),
(3, '2019-07-17', 0, 'RODO', '1111111111'),
(4, '2019-07-17', 0, 'RODO', '1111111111'),
(5, '2019-07-17', 0, 'RODO', '1111111111'),
(6, '2019-07-17', 0, 'RODO', '1111111111'),
(7, '2019-07-17', 0, 'RODO', '1111111111'),
(8, '2019-07-17', 0, 'RODO', '1111111111'),
(9, '2019-07-17', 0, 'RODO', '1111111111'),
(10, '2019-07-17', 0, 'RODO', '1111111111'),
(11, '2019-07-17', 0, 'RODO', '1111111111'),
(12, '2019-07-17', 0, 'RODO', '1111111111'),
(13, '2019-07-17', 0, 'RODO', '1111111111'),
(14, '2019-07-17', 0, 'RODO', '1111111111'),
(15, '2019-07-17', 0, 'RODO', '1111111111'),
(16, '2019-07-17', 0, 'RODO', '1111111111'),
(17, '2019-07-17', 0, 'RODO', '1111111111'),
(18, '2019-07-17', 684, 'RODO', '1111111111'),
(19, '2019-07-17', 29, 'RODO', '1111111111'),
(20, '2019-07-17', 897, 'RODO', '1111111111'),
(21, '2019-07-17', 169, 'RODO', '1111111111'),
(22, '2019-07-17', 721, 'RODO', '1111111111'),
(23, '2019-07-17', 560, 'RODO', '1111111111'),
(24, '2019-07-17', 55, 'RODO', '1111111111'),
(25, '2019-07-17', 17373, 'RODO', '1111111111'),
(26, '2019-07-17', 2534, 'RODO', '1111111111'),
(27, '2019-07-17', 57, 'RODO', '1111111111'),
(28, '2019-07-17', 1400, 'RODO', '1111111111'),
(29, '2019-07-17', 110, 'RODO', '1111111111'),
(30, '2019-07-17', 240, 'RODO', '1111111111'),
(31, '2019-07-17', 341, 'RODO', '1111111111'),
(32, '2019-07-17', 12550, 'RODO', '1111111111'),
(33, '2019-07-17', 24300, 'RODO', '1111111111');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`login`);

--
-- Indices de la tabla `detalle`
--
ALTER TABLE `detalle`
  ADD PRIMARY KEY (`numero_detalle`),
  ADD KEY `detallnumvent_ventnumvent` (`numero_venta`),
  ADD KEY `detallcodig_produccodi` (`codigo`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`numero_venta`),
  ADD KEY `ventlogin_clielogin` (`login`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detalle`
--
ALTER TABLE `detalle`
  MODIFY `numero_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `numero_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle`
--
ALTER TABLE `detalle`
  ADD CONSTRAINT `detallcodig_produccodi` FOREIGN KEY (`codigo`) REFERENCES `producto` (`codigo`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `detallnumvent_ventnumvent` FOREIGN KEY (`numero_venta`) REFERENCES `venta` (`numero_venta`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `ventlogin_clielogin` FOREIGN KEY (`login`) REFERENCES `cliente` (`login`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
