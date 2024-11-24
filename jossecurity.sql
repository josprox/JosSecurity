-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-11-2024 a las 04:14:34
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `jossecurity`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `js_table_check_users`
--

CREATE TABLE `js_table_check_users` (
  `id` bigint(21) NOT NULL,
  `id_user` bigint(21) NOT NULL,
  `accion` varchar(60) DEFAULT NULL,
  `url` varchar(16) DEFAULT NULL,
  `expiracion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `js_table_not_pay`
--

CREATE TABLE `js_table_not_pay` (
  `id` bigint(21) NOT NULL,
  `check_pay` varchar(255) DEFAULT NULL,
  `fecha` date NOT NULL,
  `dias` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `js_table_roles`
--

CREATE TABLE `js_table_roles` (
  `id` bigint(21) NOT NULL,
  `rol` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `js_table_roles`
--

INSERT INTO `js_table_roles` (`id`, `rol`) VALUES
(1, 'Administrador'),
(2, 'Editor'),
(3, 'Autor'),
(4, 'Colaborador'),
(5, 'Suscriptor'),
(6, 'Cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `js_table_tareas`
--

CREATE TABLE `js_table_tareas` (
  `id` bigint(21) NOT NULL,
  `funcion` text NOT NULL,
  `sig_fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `js_table_users`
--

CREATE TABLE `js_table_users` (
  `id` bigint(21) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_rol` bigint(21) NOT NULL,
  `phone` varchar(21) DEFAULT NULL,
  `checked_status` varchar(5) DEFAULT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `fa` varchar(1) NOT NULL,
  `type_fa` varchar(15) DEFAULT NULL,
  `two_fa` varchar(32) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `js_table_users`
--

INSERT INTO `js_table_users` (`id`, `name`, `email`, `password`, `id_rol`, `phone`, `checked_status`, `last_ip`, `fa`, `type_fa`, `two_fa`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'joss@int.josprox.com', '$2y$10$cS/2ZbYc.scMD8bJdxGG1ObsLgQxVJy/cHX3hH/NRSWxScfHq.kMO', 1, NULL, 'TRUE', '::1', 'D', 'correo', NULL, '2022-10-04 00:39:35', '2022-10-04 01:08:27');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `js_table_check_users`
--
ALTER TABLE `js_table_check_users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `js_table_not_pay`
--
ALTER TABLE `js_table_not_pay`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `js_table_roles`
--
ALTER TABLE `js_table_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `js_table_tareas`
--
ALTER TABLE `js_table_tareas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `js_table_users`
--
ALTER TABLE `js_table_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `js_table_check_users`
--
ALTER TABLE `js_table_check_users`
  MODIFY `id` bigint(21) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `js_table_not_pay`
--
ALTER TABLE `js_table_not_pay`
  MODIFY `id` bigint(21) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `js_table_roles`
--
ALTER TABLE `js_table_roles`
  MODIFY `id` bigint(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `js_table_tareas`
--
ALTER TABLE `js_table_tareas`
  MODIFY `id` bigint(21) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `js_table_users`
--
ALTER TABLE `js_table_users`
  MODIFY `id` bigint(21) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `js_table_users`
--
ALTER TABLE `js_table_users`
  ADD CONSTRAINT `js_table_users_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `js_table_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
