-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 15-10-2025 a las 14:26:03
-- Versión del servidor: 8.0.30
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `synapse`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_cat` int NOT NULL,
  `codigo_cat` varchar(16) NOT NULL,
  `nombre_cat` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_cat`, `codigo_cat`, `nombre_cat`) VALUES
(1, 'WEB', 'web'),
(2, 'CRYPTO', 'criptografia'),
(3, 'FORENS', 'forense'),
(4, 'STEGO', 'estenografia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dificultad`
--

CREATE TABLE `dificultad` (
  `id_dif` int NOT NULL,
  `nombre_dif` varchar(40) NOT NULL,
  `orden_dif` smallint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `dificultad`
--

INSERT INTO `dificultad` (`id_dif`, `nombre_dif`, `orden_dif`) VALUES
(1, '1_facil', 1),
(2, '2_baja', 2),
(3, '3_media', 3),
(4, '4_alta', 4),
(5, '5_dificil', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `est_habilidad`
--

CREATE TABLE `est_habilidad` (
  `id_est` int NOT NULL,
  `id_usu` int NOT NULL,
  `theta_est` decimal(6,4) NOT NULL DEFAULT '0.0000',
  `theta_se_est` decimal(6,4) DEFAULT NULL,
  `actualizado_en_est` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluacion`
--

CREATE TABLE `evaluacion` (
  `id_eval` int NOT NULL,
  `titulo_eval` varchar(150) NOT NULL,
  `descripcion_eval` text,
  `id_cat` int NOT NULL,
  `id_dif` int NOT NULL,
  `puntaje_base_eval` decimal(10,2) NOT NULL DEFAULT '100.00',
  `fecha_inicio_eval` datetime NOT NULL,
  `fecha_fin_eval` datetime NOT NULL,
  `id_per` int DEFAULT NULL,
  `id_doc_usu` int DEFAULT NULL,
  `flag_hash_eval` char(32) NOT NULL,
  `estado_eval` smallint NOT NULL DEFAULT '2',
  `creado_en_eval` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en_eval` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `evaluacion`
--

INSERT INTO `evaluacion` (`id_eval`, `titulo_eval`, `descripcion_eval`, `id_cat`, `id_dif`, `puntaje_base_eval`, `fecha_inicio_eval`, `fecha_fin_eval`, `id_per`, `id_doc_usu`, `flag_hash_eval`, `estado_eval`, `creado_en_eval`, `actualizado_en_eval`) VALUES
(1, 'Desafío WEB 1', 'SQLi básico', 1, 3, 100.00, '2025-10-14 18:24:15', '2025-10-21 18:24:15', 1, 1, '1a8542a0edb362ea512ec4a1bd099ee0', 2, '2025-10-14 18:24:15', '2025-10-14 18:24:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `intento`
--

CREATE TABLE `intento` (
  `id_int` int NOT NULL,
  `id_eval` int NOT NULL,
  `id_usu` int NOT NULL,
  `respuesta_flag_int` varchar(255) NOT NULL,
  `es_correcto_int` tinyint(1) NOT NULL,
  `nro_intento_int` int NOT NULL DEFAULT '1',
  `tiempo_envio_int` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `latencia_seg_int` int DEFAULT NULL,
  `creado_en_int` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en_int` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `intento`
--

INSERT INTO `intento` (`id_int`, `id_eval`, `id_usu`, `respuesta_flag_int`, `es_correcto_int`, `nro_intento_int`, `tiempo_envio_int`, `latencia_seg_int`, `creado_en_int`, `actualizado_en_int`) VALUES
(1, 1, 2, 'flag{demo}', 1, 1, '2025-10-14 18:24:15', NULL, '2025-10-14 18:24:15', '2025-10-14 18:24:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `irt_param`
--

CREATE TABLE `irt_param` (
  `id_irt` int NOT NULL,
  `id_eval` int NOT NULL,
  `a_discriminacion_irt` decimal(4,2) NOT NULL DEFAULT '1.00',
  `b_dificultad_irt` decimal(4,2) NOT NULL,
  `c_azar_irt` decimal(4,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelo_logit`
--

CREATE TABLE `modelo_logit` (
  `id_mlg` int NOT NULL,
  `id_per` int DEFAULT NULL,
  `scope_mlg` varchar(32) NOT NULL,
  `clase_mlg` varchar(64) NOT NULL,
  `beta_json_mlg` json NOT NULL,
  `n_obs_mlg` int NOT NULL DEFAULT '0',
  `last_fit_mlg` datetime DEFAULT NULL,
  `creado_en_mlg` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en_mlg` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `modelo_logit`
--

INSERT INTO `modelo_logit` (`id_mlg`, `id_per`, `scope_mlg`, `clase_mlg`, `beta_json_mlg`, `n_obs_mlg`, `last_fit_mlg`, `creado_en_mlg`, `actualizado_en_mlg`) VALUES
(1, 1, 'global', 'logit_CTFSolve', '[0, 0, 0, 0, 0, 0]', 0, NULL, '2025-10-14 18:24:15', '2025-10-14 18:24:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodo`
--

CREATE TABLE `periodo` (
  `id_per` int NOT NULL,
  `nombre_per` varchar(60) NOT NULL,
  `gestion_per` varchar(20) NOT NULL,
  `activo_per` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `periodo`
--

INSERT INTO `periodo` (`id_per`, `nombre_per`, `gestion_per`, `activo_per`) VALUES
(1, '2025-2', '2025', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ranking`
--

CREATE TABLE `ranking` (
  `id_ran` int NOT NULL,
  `id_usu` int NOT NULL,
  `id_per` int NOT NULL,
  `puntaje_total_ran` decimal(12,2) NOT NULL DEFAULT '0.00',
  `posicion_ran` int DEFAULT NULL,
  `creado_en_ran` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en_ran` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `ranking`
--

INSERT INTO `ranking` (`id_ran`, `id_usu`, `id_per`, `puntaje_total_ran`, `posicion_ran`, `creado_en_ran`, `actualizado_en_ran`) VALUES
(1, 2, 1, 107.00, 1, '2025-10-14 18:24:15', '2025-10-14 18:24:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rendimiento`
--

CREATE TABLE `rendimiento` (
  `id_ren` int NOT NULL,
  `id_usu` int NOT NULL,
  `id_cat` int NOT NULL,
  `r_actual_ren` decimal(5,4) NOT NULL DEFAULT '0.5000',
  `r_media_movil_ren` decimal(5,4) DEFAULT NULL,
  `r_std_ren` decimal(5,4) DEFAULT NULL,
  `n_intentos_ren` int NOT NULL DEFAULT '0',
  `last_update_ren` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `creado_en_ren` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en_ren` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `rendimiento`
--

INSERT INTO `rendimiento` (`id_ren`, `id_usu`, `id_cat`, `r_actual_ren`, `r_media_movil_ren`, `r_std_ren`, `n_intentos_ren`, `last_update_ren`, `creado_en_ren`, `actualizado_en_ren`) VALUES
(1, 2, 1, 0.7000, NULL, NULL, 1, '2025-10-14 18:24:15', '2025-10-14 18:24:15', '2025-10-14 18:24:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int NOT NULL,
  `nombre_rol` varchar(60) NOT NULL,
  `descripcion_rol` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `nombre_rol`, `descripcion_rol`) VALUES
(1, 'admin', 'Administrador del sistema'),
(2, 'docente', 'Docente/coach'),
(3, 'estudiante', 'Participante'),
(4, 'jurado', 'Observador/Jurado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `score`
--

CREATE TABLE `score` (
  `id_sco` int NOT NULL,
  `id_usu` int NOT NULL,
  `id_eval` int NOT NULL,
  `puntaje_total_sco` decimal(10,2) NOT NULL,
  `feedback_sco` varchar(255) DEFAULT NULL,
  `creado_en_sco` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en_sco` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `score`
--

INSERT INTO `score` (`id_sco`, `id_usu`, `id_eval`, `puntaje_total_sco`, `feedback_sco`, `creado_en_sco`, `actualizado_en_sco`) VALUES
(1, 2, 1, 107.00, NULL, '2025-10-14 18:24:15', '2025-10-14 18:24:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usu` int NOT NULL,
  `nombre_usu` varchar(80) NOT NULL,
  `app_usu` varchar(80) NOT NULL,
  `apm_usu` varchar(80) DEFAULT NULL,
  `email_usu` varchar(120) NOT NULL,
  `pass_hash_usu` varchar(255) NOT NULL,
  `activo_usu` tinyint(1) NOT NULL DEFAULT '1',
  `creado_en_usu` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en_usu` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usu`, `nombre_usu`, `app_usu`, `apm_usu`, `email_usu`, `pass_hash_usu`, `activo_usu`, `creado_en_usu`, `actualizado_en_usu`) VALUES
(1, 'Milton', 'Cayo', 'Blanco', 'milton@unifranz.edu', 'hash_demo', 1, '2025-10-14 18:24:15', '2025-10-14 18:24:15'),
(2, 'Vicente', 'Claros', 'Mamani', 'vicente@unifranz.edu', 'hash_demo', 1, '2025-10-14 18:24:15', '2025-10-14 18:24:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_rol`
--

CREATE TABLE `usuario_rol` (
  `id_usr_rol` int NOT NULL,
  `id_usu` int NOT NULL,
  `id_rol` int NOT NULL,
  `creado_en_usrrol` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuario_rol`
--

INSERT INTO `usuario_rol` (`id_usr_rol`, `id_usu`, `id_rol`, `creado_en_usrrol`) VALUES
(1, 1, 2, '2025-10-14 18:24:15'),
(2, 2, 3, '2025-10-14 18:24:15');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_cat`),
  ADD UNIQUE KEY `uq_categoria_codigo` (`codigo_cat`),
  ADD UNIQUE KEY `uq_categoria_nombre` (`nombre_cat`);

--
-- Indices de la tabla `dificultad`
--
ALTER TABLE `dificultad`
  ADD PRIMARY KEY (`id_dif`),
  ADD UNIQUE KEY `uq_dificultad_nombre` (`nombre_dif`);

--
-- Indices de la tabla `est_habilidad`
--
ALTER TABLE `est_habilidad`
  ADD PRIMARY KEY (`id_est`),
  ADD UNIQUE KEY `uq_est_usuario` (`id_usu`);

--
-- Indices de la tabla `evaluacion`
--
ALTER TABLE `evaluacion`
  ADD PRIMARY KEY (`id_eval`),
  ADD KEY `fk_eval_dif` (`id_dif`),
  ADD KEY `fk_eval_per` (`id_per`),
  ADD KEY `fk_eval_doc` (`id_doc_usu`),
  ADD KEY `idx_eval_cat_dif_estado` (`id_cat`,`id_dif`,`estado_eval`);

--
-- Indices de la tabla `intento`
--
ALTER TABLE `intento`
  ADD PRIMARY KEY (`id_int`),
  ADD KEY `fk_int_eval` (`id_eval`),
  ADD KEY `idx_intento_usuario_eval` (`id_usu`,`id_eval`);

--
-- Indices de la tabla `irt_param`
--
ALTER TABLE `irt_param`
  ADD PRIMARY KEY (`id_irt`),
  ADD UNIQUE KEY `uq_irt_eval` (`id_eval`);

--
-- Indices de la tabla `modelo_logit`
--
ALTER TABLE `modelo_logit`
  ADD PRIMARY KEY (`id_mlg`),
  ADD UNIQUE KEY `uq_modelo_scope` (`id_per`,`scope_mlg`);

--
-- Indices de la tabla `periodo`
--
ALTER TABLE `periodo`
  ADD PRIMARY KEY (`id_per`),
  ADD UNIQUE KEY `uq_periodo_nombre` (`nombre_per`);

--
-- Indices de la tabla `ranking`
--
ALTER TABLE `ranking`
  ADD PRIMARY KEY (`id_ran`),
  ADD UNIQUE KEY `uq_ranking_usuario_periodo` (`id_usu`,`id_per`),
  ADD KEY `fk_ran_per` (`id_per`);

--
-- Indices de la tabla `rendimiento`
--
ALTER TABLE `rendimiento`
  ADD PRIMARY KEY (`id_ren`),
  ADD UNIQUE KEY `uq_rendimiento_usuario_cat` (`id_usu`,`id_cat`),
  ADD KEY `fk_ren_cat` (`id_cat`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`),
  ADD UNIQUE KEY `uq_rol_nombre` (`nombre_rol`);

--
-- Indices de la tabla `score`
--
ALTER TABLE `score`
  ADD PRIMARY KEY (`id_sco`),
  ADD UNIQUE KEY `uq_score_usuario_eval` (`id_usu`,`id_eval`),
  ADD KEY `fk_sco_eval` (`id_eval`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usu`),
  ADD UNIQUE KEY `uq_usuario_email` (`email_usu`);

--
-- Indices de la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  ADD PRIMARY KEY (`id_usr_rol`),
  ADD UNIQUE KEY `uq_usuario_rol` (`id_usu`,`id_rol`),
  ADD KEY `fk_usrrol_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_cat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `dificultad`
--
ALTER TABLE `dificultad`
  MODIFY `id_dif` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `est_habilidad`
--
ALTER TABLE `est_habilidad`
  MODIFY `id_est` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `evaluacion`
--
ALTER TABLE `evaluacion`
  MODIFY `id_eval` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `intento`
--
ALTER TABLE `intento`
  MODIFY `id_int` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `irt_param`
--
ALTER TABLE `irt_param`
  MODIFY `id_irt` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `modelo_logit`
--
ALTER TABLE `modelo_logit`
  MODIFY `id_mlg` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `periodo`
--
ALTER TABLE `periodo`
  MODIFY `id_per` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `ranking`
--
ALTER TABLE `ranking`
  MODIFY `id_ran` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `rendimiento`
--
ALTER TABLE `rendimiento`
  MODIFY `id_ren` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `score`
--
ALTER TABLE `score`
  MODIFY `id_sco` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  MODIFY `id_usr_rol` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `est_habilidad`
--
ALTER TABLE `est_habilidad`
  ADD CONSTRAINT `fk_est_usu` FOREIGN KEY (`id_usu`) REFERENCES `usuario` (`id_usu`);

--
-- Filtros para la tabla `evaluacion`
--
ALTER TABLE `evaluacion`
  ADD CONSTRAINT `fk_eval_cat` FOREIGN KEY (`id_cat`) REFERENCES `categoria` (`id_cat`),
  ADD CONSTRAINT `fk_eval_dif` FOREIGN KEY (`id_dif`) REFERENCES `dificultad` (`id_dif`),
  ADD CONSTRAINT `fk_eval_doc` FOREIGN KEY (`id_doc_usu`) REFERENCES `usuario` (`id_usu`),
  ADD CONSTRAINT `fk_eval_per` FOREIGN KEY (`id_per`) REFERENCES `periodo` (`id_per`);

--
-- Filtros para la tabla `intento`
--
ALTER TABLE `intento`
  ADD CONSTRAINT `fk_int_eval` FOREIGN KEY (`id_eval`) REFERENCES `evaluacion` (`id_eval`),
  ADD CONSTRAINT `fk_int_usu` FOREIGN KEY (`id_usu`) REFERENCES `usuario` (`id_usu`);

--
-- Filtros para la tabla `irt_param`
--
ALTER TABLE `irt_param`
  ADD CONSTRAINT `fk_irt_eval` FOREIGN KEY (`id_eval`) REFERENCES `evaluacion` (`id_eval`);

--
-- Filtros para la tabla `modelo_logit`
--
ALTER TABLE `modelo_logit`
  ADD CONSTRAINT `fk_mlg_per` FOREIGN KEY (`id_per`) REFERENCES `periodo` (`id_per`);

--
-- Filtros para la tabla `ranking`
--
ALTER TABLE `ranking`
  ADD CONSTRAINT `fk_ran_per` FOREIGN KEY (`id_per`) REFERENCES `periodo` (`id_per`),
  ADD CONSTRAINT `fk_ran_usu` FOREIGN KEY (`id_usu`) REFERENCES `usuario` (`id_usu`);

--
-- Filtros para la tabla `rendimiento`
--
ALTER TABLE `rendimiento`
  ADD CONSTRAINT `fk_ren_cat` FOREIGN KEY (`id_cat`) REFERENCES `categoria` (`id_cat`),
  ADD CONSTRAINT `fk_ren_usu` FOREIGN KEY (`id_usu`) REFERENCES `usuario` (`id_usu`);

--
-- Filtros para la tabla `score`
--
ALTER TABLE `score`
  ADD CONSTRAINT `fk_sco_eval` FOREIGN KEY (`id_eval`) REFERENCES `evaluacion` (`id_eval`),
  ADD CONSTRAINT `fk_sco_usu` FOREIGN KEY (`id_usu`) REFERENCES `usuario` (`id_usu`);

--
-- Filtros para la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  ADD CONSTRAINT `fk_usrrol_rol` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`),
  ADD CONSTRAINT `fk_usrrol_usuario` FOREIGN KEY (`id_usu`) REFERENCES `usuario` (`id_usu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
