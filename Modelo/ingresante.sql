SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO"; 
SET time_zone = "+00:00";

-- -------------------------------------------------------- Actividad

CREATE TABLE IF NOT EXISTS `actividad` (
  `id_actividad` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `descripcion_corta` varchar(15) UNIQUE NOT NULL,
  `descripcion_larga` varchar(255) NOT NULL,
  PRIMARY KEY (`id_actividad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------------------- Modulo
CREATE TABLE IF NOT EXISTS `modulo` (
  `id_modulo` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) UNIQUE NOT NULL,
  `tope_inscripcion` int(11) UNSIGNED NOT NULL,
  `costo` int(11) UNSIGNED NOT NULL,
  `fecha_inicio` DATE,
  `fecha_fin` DATE,
  `Hora_inicio` TIME,
  `hora_cierre` TIME,
  `id_actividad` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_modulo`),
  FOREIGN KEY (`id_actividad`) REFERENCES `actividad` (`id_actividad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------------------- Modulo En Linea
CREATE TABLE IF NOT EXISTS `modulo_en_linea` (
  `id_modulo` bigint(20) UNSIGNED NOT NULL,
  `link` varchar(255) NOT NULL,
  `bonificacion` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_modulo`),
  FOREIGN KEY (`id_modulo`) REFERENCES `modulo` (`id_modulo`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------------------- Ingresante
CREATE TABLE IF NOT EXISTS `ingresante` (
  `id_ingresante` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `mail` varchar(255) NOT NULL,
  `legajo` int(11) UNSIGNED NOT NULL,
  `dni` int(11) UNSIGNED UNIQUE NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  PRIMARY KEY (`id_ingresante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- -------------------------------------------------------- Inscripcion
CREATE TABLE IF NOT EXISTS `inscripcion` (
  `id_inscripcion` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fecha_inscripcion` DATE NOT NULL,
  `costo_final` int(11) UNSIGNED NOT NULL,
  `id_ingresante` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_inscripcion`),
  FOREIGN KEY (`id_ingresante`) REFERENCES `ingresante` (`id_ingresante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------------------- Inscripcion-Modulo
CREATE TABLE IF NOT EXISTS `inscripcion-modulo` (
  `id_modulo` bigint(20) UNSIGNED NOT NULL,
  `id_inscripcion` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_modulo`, `id_inscripcion`),
  FOREIGN KEY (`id_modulo`) REFERENCES `modulo` (`id_modulo`),
  FOREIGN KEY (`id_inscripcion`) REFERENCES `inscripcion` (`id_inscripcion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;