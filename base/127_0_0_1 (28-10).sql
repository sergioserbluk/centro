-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-10-2025 a las 15:15:23
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
-- Base de datos: `centro_estudiantes`
--
CREATE DATABASE IF NOT EXISTS `centro_estudiantes` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `centro_estudiantes`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre_categoria` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre_categoria`, `descripcion`) VALUES
(1, 'Eventos', 'Actividades y reuniones programadas por el centro de estudiantes'),
(2, 'Comunicados', 'Anuncios importantes para los estudiantes'),
(3, 'En Acción', 'Acciones y campañas realizadas por el centro de estudiantes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes_contacto`
--

CREATE TABLE `mensajes_contacto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mensaje` text NOT NULL,
  `respuesta` text DEFAULT NULL,
  `fecha_envio` datetime DEFAULT current_timestamp(),
  `fecha_respuesta` datetime DEFAULT NULL,
  `id_usuario_respuesta` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mensajes_contacto`
--

INSERT INTO `mensajes_contacto` (`id`, `nombre`, `email`, `mensaje`, `respuesta`, `fecha_envio`, `fecha_respuesta`, `id_usuario_respuesta`) VALUES
(1, 'sergio', 'sergiodserbluk@gmail.com', 'ahfaoisfjaoifjoais', 'ghslfjsfjasfjasfjoias8kjhjo\r\nsafasdf\r\n', '2025-10-21 20:20:35', '2025-10-21 20:21:20', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicaciones`
--

CREATE TABLE `publicaciones` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `contenido` text NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `fecha_publicacion` datetime DEFAULT current_timestamp(),
  `fecha_actividad` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_usuario` int(11) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `publicaciones`
--

INSERT INTO `publicaciones` (`id`, `titulo`, `contenido`, `imagen`, `fecha_publicacion`, `fecha_actividad`, `id_usuario`, `id_categoria`) VALUES
(1, 'Reunión de Delegados', 'El próximo lunes a las 10 hs se realizará una reunión con todos los delegados.', '', '2025-10-21 15:30:20', '2025-10-21 18:34:58', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `correo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre_usuario`, `clave`, `correo`) VALUES
(1, 'admin', '$2y$10$KU5h2at9zvX7zUoGBLsbveSjr3gwmeZ1cOaem03q0hMbisRMeV5Pu', 'admin@colegio.edu.ar');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_categoria` (`nombre_categoria`);

--
-- Indices de la tabla `mensajes_contacto`
--
ALTER TABLE `mensajes_contacto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario_respuesta` (`id_usuario_respuesta`);

--
-- Indices de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `mensajes_contacto`
--
ALTER TABLE `mensajes_contacto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `mensajes_contacto`
--
ALTER TABLE `mensajes_contacto`
  ADD CONSTRAINT `mensajes_contacto_ibfk_1` FOREIGN KEY (`id_usuario_respuesta`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD CONSTRAINT `publicaciones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `publicaciones_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
