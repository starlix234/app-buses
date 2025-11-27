-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-11-2025 a las 03:31:56
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bus`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaciones_rutas`
--

CREATE TABLE `asignaciones_rutas` (
  `id_asignacion` int(11) NOT NULL,
  `id_ruta` int(11) NOT NULL,
  `id_conductor` int(11) NOT NULL,
  `id_bus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `buses`
--

CREATE TABLE `buses` (
  `id_bus` int(11) NOT NULL,
  `patente` varchar(15) DEFAULT NULL,
  `modelo` varchar(100) DEFAULT NULL,
  `cant_pasajero` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `id_estado` int(11) NOT NULL,
  `estado` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`id_estado`, `estado`) VALUES
(1, 'en mantenimiento'),
(2, 'fuera de servicio'),
(3, 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recargas`
--

CREATE TABLE `recargas` (
  `id_recarga` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_tarjeta` int(11) NOT NULL,
  `monto` int(11) NOT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recargas`
--

INSERT INTO `recargas` (`id_recarga`, `id_usuario`, `id_tarjeta`, `monto`, `estado`, `fecha`) VALUES
(1, 3, 2, 2000, 'pendiente', '2025-11-26 22:21:08'),
(3, 3, 2, 1234, 'pendiente', '2025-11-26 22:45:44'),
(4, 3, 2, 1234, 'pendiente', '2025-11-26 22:47:09'),
(5, 3, 2, 1234, 'pendiente', '2025-11-26 22:49:31'),
(6, 3, 2, 2000, 'pendiente', '2025-11-26 22:52:09'),
(7, 3, 2, 2000, 'pendiente', '2025-11-26 22:52:43'),
(8, 3, 2, 100, 'pendiente', '2025-11-26 23:00:14'),
(9, 3, 2, 100, 'pendiente', '2025-11-26 23:05:16'),
(10, 3, 2, 2000, 'pendiente', '2025-11-26 23:09:16'),
(11, 3, 2, 2000, 'pendiente', '2025-11-26 23:10:25'),
(12, 3, 2, 2000, 'pendiente', '2025-11-26 23:10:45'),
(13, 3, 2, 2000, 'pendiente', '2025-11-26 23:15:36'),
(14, 3, 2, 2000, 'pagado', '2025-11-26 23:21:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `roles` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `roles`) VALUES
(1, 'admin'),
(2, 'pasajeros'),
(3, 'conductores');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutas`
--

CREATE TABLE `rutas` (
  `id_ruta` int(11) NOT NULL,
  `origen` varchar(100) NOT NULL,
  `destino` varchar(100) NOT NULL,
  `duracion` time DEFAULT NULL,
  `distancia_km` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarjetas_tokenizadas`
--

CREATE TABLE `tarjetas_tokenizadas` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `token_tarjeta` varchar(255) NOT NULL,
  `ultimos_4` varchar(4) NOT NULL,
  `tipo_tarjeta` varchar(50) DEFAULT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `creada_en` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tarjetas_tokenizadas`
--

INSERT INTO `tarjetas_tokenizadas` (`id`, `id_usuario`, `token_tarjeta`, `ultimos_4`, `tipo_tarjeta`, `marca`, `creada_en`) VALUES
(1, 1, 'tok_eb1168052dae77e0', '6623', 'credito', 'visa', '2025-11-26 20:57:46'),
(2, 3, 'tok_c2a5997b6bded127', '6623', 'credito', 'visa', '2025-11-26 22:00:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transacciones_webpay`
--

CREATE TABLE `transacciones_webpay` (
  `id_transaccion` int(11) NOT NULL,
  `id_recarga` int(11) NOT NULL,
  `token_ws` varchar(255) DEFAULT NULL,
  `buy_order` varchar(255) DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `response_code` int(11) DEFAULT NULL,
  `authorization_code` varchar(50) DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `installments` int(11) DEFAULT NULL,
  `transaction_date` datetime DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `creado_en` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `transacciones_webpay`
--

INSERT INTO `transacciones_webpay` (`id_transaccion`, `id_recarga`, `token_ws`, `buy_order`, `session_id`, `amount`, `response_code`, `authorization_code`, `payment_type`, `installments`, `transaction_date`, `status`, `creado_en`) VALUES
(1, 14, '01ab1bf19e8fda0e423ca7520bed2c65edc83cf08b1a9ffee50c755fc7e45a5d', 'recarga-1764210099', 'usuario-3-1764210099', 2000, 0, '1213', 'VN', 0, '2025-11-27 02:21:39', 'pagado', '2025-11-26 23:24:35'),
(2, 14, '01ab1bf19e8fda0e423ca7520bed2c65edc83cf08b1a9ffee50c755fc7e45a5d', 'recarga-1764210099', 'usuario-3-1764210099', 2000, 0, '1213', 'VN', 0, '2025-11-27 02:21:39', 'pagado', '2025-11-26 23:25:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `apellido` varchar(40) NOT NULL,
  `fecha_nac` date DEFAULT NULL,
  `clave` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `rut` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellido`, `fecha_nac`, `clave`, `email`, `id_rol`, `telefono`, `rut`) VALUES
(1, 'carlos francisco', 'herrera gutierres', '1999-05-04', '1234', 'carl@gmail.com', 1, '94567890', '20.623.455-2'),
(2, 'Juan', 'Pérez', '1985-06-20', '1234', 'juan.perez@smartbus.cl', 3, '987654321', '12.345.678-9'),
(3, 'María', 'González', '1998-11-12', '1234', 'maria.gonzalez@smartbus.cl', 2, '912345678', '20.345.678-5');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `viajes`
--

CREATE TABLE `viajes` (
  `id_viaje` int(11) NOT NULL,
  `id_asignacion` int(11) NOT NULL,
  `id_pasajero` int(11) NOT NULL,
  `fecha_viaje` datetime NOT NULL,
  `asiento` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignaciones_rutas`
--
ALTER TABLE `asignaciones_rutas`
  ADD PRIMARY KEY (`id_asignacion`),
  ADD KEY `id_conductor` (`id_conductor`),
  ADD KEY `id_bus` (`id_bus`),
  ADD KEY `id_ruta` (`id_ruta`);

--
-- Indices de la tabla `buses`
--
ALTER TABLE `buses`
  ADD PRIMARY KEY (`id_bus`),
  ADD UNIQUE KEY `patente` (`patente`),
  ADD KEY `id_estado` (`id_estado`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `recargas`
--
ALTER TABLE `recargas`
  ADD PRIMARY KEY (`id_recarga`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_tarjeta` (`id_tarjeta`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `rutas`
--
ALTER TABLE `rutas`
  ADD PRIMARY KEY (`id_ruta`);

--
-- Indices de la tabla `tarjetas_tokenizadas`
--
ALTER TABLE `tarjetas_tokenizadas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `transacciones_webpay`
--
ALTER TABLE `transacciones_webpay`
  ADD PRIMARY KEY (`id_transaccion`),
  ADD KEY `id_recarga` (`id_recarga`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `rut` (`rut`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indices de la tabla `viajes`
--
ALTER TABLE `viajes`
  ADD PRIMARY KEY (`id_viaje`),
  ADD KEY `id_asignacion` (`id_asignacion`),
  ADD KEY `id_pasajero` (`id_pasajero`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asignaciones_rutas`
--
ALTER TABLE `asignaciones_rutas`
  MODIFY `id_asignacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `buses`
--
ALTER TABLE `buses`
  MODIFY `id_bus` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `recargas`
--
ALTER TABLE `recargas`
  MODIFY `id_recarga` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `rutas`
--
ALTER TABLE `rutas`
  MODIFY `id_ruta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tarjetas_tokenizadas`
--
ALTER TABLE `tarjetas_tokenizadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `transacciones_webpay`
--
ALTER TABLE `transacciones_webpay`
  MODIFY `id_transaccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `viajes`
--
ALTER TABLE `viajes`
  MODIFY `id_viaje` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignaciones_rutas`
--
ALTER TABLE `asignaciones_rutas`
  ADD CONSTRAINT `asignaciones_rutas_ibfk_1` FOREIGN KEY (`id_conductor`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `asignaciones_rutas_ibfk_2` FOREIGN KEY (`id_bus`) REFERENCES `buses` (`id_bus`),
  ADD CONSTRAINT `asignaciones_rutas_ibfk_3` FOREIGN KEY (`id_ruta`) REFERENCES `rutas` (`id_ruta`);

--
-- Filtros para la tabla `buses`
--
ALTER TABLE `buses`
  ADD CONSTRAINT `buses_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id_estado`);

--
-- Filtros para la tabla `recargas`
--
ALTER TABLE `recargas`
  ADD CONSTRAINT `recargas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `recargas_ibfk_2` FOREIGN KEY (`id_tarjeta`) REFERENCES `tarjetas_tokenizadas` (`id`);

--
-- Filtros para la tabla `tarjetas_tokenizadas`
--
ALTER TABLE `tarjetas_tokenizadas`
  ADD CONSTRAINT `tarjetas_tokenizadas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `transacciones_webpay`
--
ALTER TABLE `transacciones_webpay`
  ADD CONSTRAINT `transacciones_webpay_ibfk_1` FOREIGN KEY (`id_recarga`) REFERENCES `recargas` (`id_recarga`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`);

--
-- Filtros para la tabla `viajes`
--
ALTER TABLE `viajes`
  ADD CONSTRAINT `viajes_ibfk_1` FOREIGN KEY (`id_asignacion`) REFERENCES `asignaciones_rutas` (`id_asignacion`),
  ADD CONSTRAINT `viajes_ibfk_2` FOREIGN KEY (`id_pasajero`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
