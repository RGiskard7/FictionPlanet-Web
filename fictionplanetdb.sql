-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 28-08-2022 a las 23:12:02
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `fictionplanetdb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendar_events`
--

CREATE TABLE `calendar_events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `title` text DEFAULT NULL,
  `color` varchar(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chat_message`
--

CREATE TABLE `chat_message` (
  `id` bigint(20) NOT NULL,
  `sender_user_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_user_id` bigint(20) UNSIGNED NOT NULL,
  `message` text CHARACTER SET utf8mb4 NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `contact_id` bigint(20) UNSIGNED NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `friend_requests`
--

CREATE TABLE `friend_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from_user_id` bigint(20) UNSIGNED NOT NULL,
  `to_user_id` bigint(20) UNSIGNED NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_update_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `accepted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `image_gallery`
--

CREATE TABLE `image_gallery` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `author_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `url` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_update_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `visible` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modules`
--

CREATE TABLE `modules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_esp` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `modules`
--

INSERT INTO `modules` (`id`, `name`, `name_esp`) VALUES
(1, 'users', 'Usuarios'),
(2, 'roles', 'Roles'),
(3, 'posts', 'Publicaciones'),
(4, 'calendar_events', 'Eventos de calendario publico'),
(5, 'publisher_data', 'Datos de publicaciones'),
(6, 'personal_data', 'Datos personales'),
(7, 'chat_services', 'Chat en vivo'),
(8, 'images', 'Imagenes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `subject` text NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `module_id` bigint(20) UNSIGNED NOT NULL,
  `r` int(11) NOT NULL DEFAULT 0,
  `w` int(11) NOT NULL DEFAULT 0,
  `u` int(11) NOT NULL DEFAULT 0,
  `d` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `role_id`, `module_id`, `r`, `w`, `u`, `d`) VALUES
(1, 1, 1, 1, 1, 1, 1),
(2, 1, 3, 1, 1, 1, 1),
(3, 1, 2, 1, 1, 1, 1),
(4, 1, 4, 1, 1, 1, 1),
(5, 1, 7, 1, 1, 1, 1),
(6, 1, 5, 1, 1, 1, 1),
(7, 1, 6, 1, 1, 1, 1),
(8, 4, 3, 0, 0, 0, 0),
(9, 4, 1, 1, 0, 0, 0),
(10, 4, 2, 1, 0, 0, 0),
(11, 4, 7, 0, 0, 0, 0),
(12, 4, 6, 0, 0, 0, 0),
(13, 4, 4, 1, 0, 0, 0),
(14, 2, 1, 0, 0, 0, 0),
(15, 2, 3, 1, 1, 1, 1),
(16, 2, 2, 1, 1, 1, 0),
(17, 2, 4, 1, 1, 0, 0),
(18, 2, 7, 1, 1, 1, 1),
(19, 2, 6, 0, 0, 0, 0),
(21, 2, 5, 0, 0, 0, 0),
(143, 48, 1, 0, 0, 0, 0),
(144, 48, 2, 0, 0, 0, 0),
(145, 48, 3, 0, 0, 0, 0),
(146, 48, 4, 0, 0, 0, 0),
(147, 48, 5, 0, 0, 0, 0),
(148, 48, 6, 0, 0, 0, 0),
(149, 48, 7, 0, 0, 0, 0),
(159, 50, 1, 1, 1, 1, 1),
(160, 50, 2, 0, 0, 0, 0),
(161, 50, 3, 0, 0, 0, 0),
(162, 50, 4, 0, 0, 0, 0),
(163, 50, 5, 0, 0, 0, 0),
(164, 50, 6, 0, 0, 0, 0),
(165, 50, 7, 0, 0, 0, 0),
(167, 4, 5, 0, 0, 0, 0),
(168, 1, 8, 1, 1, 1, 1),
(169, 2, 8, 1, 1, 1, 0),
(170, 4, 8, 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `url` varchar(255) NOT NULL,
  `author_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `introduction` text NOT NULL,
  `content` mediumtext NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_update_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `visible` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `name_esp` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `name_esp`) VALUES
(1, 'Root', NULL, 'Root'),
(2, 'Administrator', NULL, 'Administrador'),
(4, 'Registered user', NULL, 'Usuario registrado'),
(48, 'Prueba rol', '', 'Prueba rol'),
(50, 'Prueba 2', '', 'Prueba 2');

--
-- Disparadores `roles`
--
DELIMITER $$
CREATE TRIGGER `delete_role` BEFORE DELETE ON `roles` FOR EACH ROW BEGIN
	DECLARE done INT DEFAULT 0;
	DECLARE id_user BIGINT(20);
	DECLARE C CURSOR FOR SELECT id FROM users WHERE role_id = OLD.id;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	
	OPEN C;
	bucle: LOOP
		FETCH C INTO id_user;
		IF done = 1 THEN
            LEAVE bucle;
        END IF;
		UPDATE users SET role_id = 4 WHERE id = id_user;
	END LOOP bucle;
	CLOSE C;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `new_role_permissions` AFTER INSERT ON `roles` FOR EACH ROW BEGIN
	DECLARE done INT DEFAULT 0;
	DECLARE id_mod BIGINT(20);
	DECLARE C CURSOR FOR SELECT id FROM modules;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
    
	OPEN C;
    
	bucle: LOOP
        FETCH C INTO id_mod;
        IF done = 1 THEN
            LEAVE bucle;
        END IF;
        INSERT INTO permissions (role_id, module_id, r, w, u, d) VALUES (NEW.id, id_mod, 0, 0, 0, 0);
	END LOOP bucle;
	
	CLOSE C;
    
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `phone_number` int(10) UNSIGNED DEFAULT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_update_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `last_access_date` timestamp NULL DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `avatar` varchar(255) DEFAULT NULL,
  `online` tinyint(1) DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL DEFAULT 4
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
-- Contraseña de usuarios: 1234
--

INSERT INTO `users` (`id`, `user_name`, `first_name`, `last_name`, `email`, `password`, `address`, `country`, `phone_number`, `reg_date`, `last_update_date`, `last_access_date`, `active`, `avatar`, `online`, `role_id`) VALUES
(1, 'Asimov', 'Nombre', 'Apellidos', 'correo@correo.com', '$2y$10$wM1YkQkqMxswE8/dGuItt.bnJ9203LWZ/Pd8/PozyPQBtv/6Y8BRi', 'Direccion', 'Pais', 000000000, '2020-12-07 18:40:03', '2022-08-28 20:47:50', '2022-08-28 20:47:50', 1, NULL, NULL, 1),
(2, 'Asimov2', 'Nombre', 'sdasfgafg', 'puchini@gmail.com', '$2y$10$q7Y/SZ21jfWSKwsdOhkmvuYmrDKnT1p2fObaDkd.asoPi4RrdnaWi', 'Direccion', 'Pais', 4294967295, '2020-12-15 23:23:54', '2022-08-28 11:22:11', '2022-08-28 11:22:11', 1, NULL, NULL, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `calendar_events`
--
ALTER TABLE `calendar_events`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `chat_message`
--
ALTER TABLE `chat_message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_sender_user_id` (`sender_user_id`),
  ADD KEY `FK_receiver_user_id` (`receiver_user_id`);

--
-- Indices de la tabla `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id_contacts` (`user_id`),
  ADD KEY `fk_contact_id` (`contact_id`);

--
-- Indices de la tabla `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_from_user_id_friend_rqs` (`from_user_id`),
  ADD KEY `FK_to_user_id_friend_rqs` (`to_user_id`);

--
-- Indices de la tabla `image_gallery`
--
ALTER TABLE `image_gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indices de la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_user_id_notifications` (`user_id`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_role_id_2` (`role_id`),
  ADD KEY `FK_module_id` (`module_id`);

--
-- Indices de la tabla `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`),
  ADD UNIQUE KEY `url` (`url`),
  ADD KEY `FK_author_id` (`author_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userName` (`user_name`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `FK_role_id` (`role_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `calendar_events`
--
ALTER TABLE `calendar_events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT de la tabla `chat_message`
--
ALTER TABLE `chat_message`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT de la tabla `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT de la tabla `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT de la tabla `image_gallery`
--
ALTER TABLE `image_gallery`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT de la tabla `modules`
--
ALTER TABLE `modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT de la tabla `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `chat_message`
--
ALTER TABLE `chat_message`
  ADD CONSTRAINT `FK_receiver_user_id` FOREIGN KEY (`receiver_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_sender_user_id` FOREIGN KEY (`sender_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `fk_user_id_contacts` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_contact_id` FOREIGN KEY (`contact_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD CONSTRAINT `FK_from_user_id_friend_rqs` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_to_user_id_friend_rqs` FOREIGN KEY (`to_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `FK_user_id_notifications` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `FK_module_id` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_role_id_permissions` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `FK_author_id` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
