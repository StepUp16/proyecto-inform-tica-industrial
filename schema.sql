-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 10-06-2026 a las 20:24:57
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

CREATE DATABASE IF NOT EXISTS warestock;
USE warestock;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `warestock`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `box`
--

CREATE TABLE `box` (
  `id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operation`
--

CREATE TABLE `operation` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `q` float DEFAULT NULL,
  `operation_type_id` int(11) DEFAULT NULL,
  `sell_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `operation`
--

INSERT INTO `operation` (`id`, `product_id`, `q`, `operation_type_id`, `sell_id`, `created_at`) VALUES
(1, 2, 50, 1, NULL, '2026-06-10 11:33:18'),
(2, 3, 500, 1, NULL, '2026-06-10 11:33:18'),
(3, 4, 4, 1, NULL, '2026-06-10 11:33:18'),
(4, 5, 3, 1, NULL, '2026-06-10 11:33:18'),
(5, 6, 2, 1, NULL, '2026-06-10 11:33:18'),
(6, 7, 2, 1, NULL, '2026-06-10 11:33:18'),
(7, 8, 5, 1, NULL, '2026-06-10 11:33:18'),
(8, 9, 3, 1, NULL, '2026-06-10 11:33:18'),
(9, 10, 8, 1, NULL, '2026-06-10 11:33:18'),
(10, 11, 5, 1, NULL, '2026-06-10 11:33:18'),
(11, 12, 3, 1, NULL, '2026-06-10 11:33:18'),
(12, 13, 30, 1, NULL, '2026-06-10 11:33:18'),
(13, 14, 15, 1, NULL, '2026-06-10 11:33:18'),
(14, 15, 10, 1, NULL, '2026-06-10 11:33:18'),
(15, 16, 20, 1, NULL, '2026-06-10 11:33:18'),
(16, 17, 3, 1, NULL, '2026-06-10 11:33:18'),
(17, 18, 2, 1, NULL, '2026-06-10 11:33:18'),
(18, 19, 3, 1, NULL, '2026-06-10 11:33:18'),
(19, 20, 20, 1, NULL, '2026-06-10 11:33:18'),
(20, 21, 5, 1, NULL, '2026-06-10 11:33:18'),
(21, 22, 10, 1, NULL, '2026-06-10 11:33:18'),
(22, 23, 2, 1, NULL, '2026-06-10 11:33:18'),
(23, 24, 200, 1, NULL, '2026-06-10 11:33:18'),
(24, 25, 500, 1, NULL, '2026-06-10 11:33:18'),
(25, 26, 12, 1, NULL, '2026-06-10 11:33:18'),
(26, 27, 2, 1, NULL, '2026-06-10 11:33:18'),
(27, 28, 5, 1, NULL, '2026-06-10 11:33:18'),
(28, 29, 6, 1, NULL, '2026-06-10 11:33:18'),
(29, 30, 8, 1, NULL, '2026-06-10 11:33:18'),
(30, 31, 5, 1, NULL, '2026-06-10 11:33:18'),
(31, 32, 6, 1, NULL, '2026-06-10 11:33:18'),
(32, 33, 10, 1, NULL, '2026-06-10 11:33:18'),
(33, 34, 3, 1, NULL, '2026-06-10 11:33:18'),
(34, 35, 24, 1, NULL, '2026-06-10 11:33:18'),
(35, 36, 0, 1, NULL, '2026-06-10 11:33:18'),
(36, 37, 0, 1, NULL, '2026-06-10 11:33:18'),
(37, 38, 0, 1, NULL, '2026-06-10 11:33:18'),
(38, 39, 0, 1, NULL, '2026-06-10 11:33:18'),
(39, 40, 0, 1, NULL, '2026-06-10 11:33:18'),
(40, 41, 0, 1, NULL, '2026-06-10 11:33:18'),
(41, 42, 0, 1, NULL, '2026-06-10 11:33:18'),
(42, 43, 0, 1, NULL, '2026-06-10 11:33:18'),
(43, 44, 0, 1, NULL, '2026-06-10 11:33:18'),
(44, 45, 0, 1, NULL, '2026-06-10 11:33:18'),
(45, 46, 0, 1, NULL, '2026-06-10 11:33:18'),
(46, 47, 0, 1, NULL, '2026-06-10 11:33:18'),
(47, 48, 0, 1, NULL, '2026-06-10 11:33:18'),
(48, 49, 0, 1, NULL, '2026-06-10 11:33:18'),
(49, 50, 0, 1, NULL, '2026-06-10 11:33:18'),
(50, 51, 0, 1, NULL, '2026-06-10 11:33:18'),
(51, 37, 5, 2, 1, '2026-06-11 09:30:00'),
(52, 36, 10, 2, 1, '2026-06-11 09:30:00'),
(53, 40, 1, 2, 2, '2026-06-11 09:35:00'),
(54, 41, 1, 2, 2, '2026-06-11 09:35:00'),
(55, 38, 3, 2, 2, '2026-06-11 09:35:00'),
(56, 44, 1, 2, 3, '2026-06-11 09:40:00'),
(57, 43, 2, 2, 3, '2026-06-11 09:40:00'),
(58, 46, 10, 2, 3, '2026-06-11 09:40:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operation_type`
--

CREATE TABLE `operation_type` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `operation_type`
--

INSERT INTO `operation_type` (`id`, `name`) VALUES
(1, 'entrada'),
(2, 'salida');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `person`
--

CREATE TABLE `person` (
  `id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `company` varchar(50) DEFAULT NULL,
  `address1` varchar(50) DEFAULT NULL,
  `address2` varchar(50) DEFAULT NULL,
  `phone1` varchar(50) DEFAULT NULL,
  `phone2` varchar(50) DEFAULT NULL,
  `email1` varchar(50) DEFAULT NULL,
  `email2` varchar(50) DEFAULT NULL,
  `kind` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `person`
--

INSERT INTO `person` (`id`, `image`, `name`, `lastname`, `company`, `address1`, `phone1`, `email1`, `kind`, `created_at`) VALUES
(1, NULL, 'Carlos', 'Mendoza', 'Restaurante La Parrilla', 'Av. Principal 123, Centro', '555-0101', 'carlos@laparrilla.com', 1, '2026-06-10 11:33:18'),
(2, NULL, 'María Fernanda', 'López', 'Boutique Eleganza', 'Calle Real 456, Plaza Mayor', '555-0202', 'maria@eleganza.com', 1, '2026-06-10 11:33:18'),
(3, NULL, 'Roberto', 'García', 'TechSolutions S.A.', 'Blvd. Tecnológico 789, Of. 301', '555-0303', 'roberto@techsolutions.com', 1, '2026-06-10 11:33:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `barcode` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `inventary_min` int(11) DEFAULT 10,
  `price_in` float DEFAULT NULL,
  `price_out` float DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `presentation` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `es_materia_prima` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `product`
--

INSERT INTO `product` (`id`, `image`, `barcode`, `name`, `description`, `inventary_min`, `price_in`, `price_out`, `unit`, `presentation`, `user_id`, `category_id`, `created_at`, `is_active`, `es_materia_prima`) VALUES
(1, NULL, 'PROD-001', 'Taza Sublimada (Servicio Completo)', NULL, 5, 3.5, 8, 'Unidad', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 0),
(2, NULL, 'MAT-001', 'Taza Blanca en Blanco 11oz', NULL, 10, 1.5, 2.25, 'Unidad', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 1),
(3, NULL, 'MAT-002', 'Tinta de Sublimacion (Todos los colores)', NULL, 50, 0.25, 0.5, 'ml', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 1),
(4, NULL, 'MAT-003', 'Vinil Adhesivo Blanco', 'Rollo 1.52m x 50m, calibre 70 micras', 2, 450, 630, 'Rollo', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 1),
(5, NULL, 'MAT-004', 'Vinil Adhesivo Negro', 'Rollo 1.52m x 50m, calibre 70 micras', 2, 450, 630, 'Rollo', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 1),
(6, NULL, 'MAT-005', 'Vinil Adhesivo Transparente', 'Rollo 1.52m x 50m, calibre 70 micras', 1, 420, 588, 'Rollo', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 1),
(7, NULL, 'MAT-006', 'Vinil Esmerilado', 'Rollo 1.52m x 50m, efecto esmerilado para vidrios', 1, 550, 770, 'Rollo', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 1),
(8, NULL, 'MAT-007', 'Acrílico 3mm', 'Lámina 1.22m x 2.44m, color blanco, acabado brillante', 3, 350, 525, 'Lámina', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 1),
(9, NULL, 'MAT-008', 'Acrílico 6mm', 'Lámina 1.22m x 2.44m, color blanco, acabado brillante', 2, 520, 780, 'Lámina', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 1),
(10, NULL, 'MAT-009', 'PVC Foam Board 3mm', 'Lámina 1.22m x 2.44m, Forex blanco, superficie lisa', 5, 180, 288, 'Lámina', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 1),
(11, NULL, 'MAT-010', 'PVC Foam Board 5mm', 'Lámina 1.22m x 2.44m, Forex blanco', 3, 280, 448, 'Lámina', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 1),
(12, NULL, 'MAT-011', 'Aluminio Compuesto Dibond 3mm', 'Lámina 1.22m x 2.44m, aluminio compuesto blanco', 2, 420, 630, 'Lámina', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 1),
(13, NULL, 'MAT-012', 'Lona Frontlit 13oz', 'Lona para exterior, impresión directa, ancho 1.60m, por metro lineal', 10, 65, 97.5, 'Metro', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 1),
(14, NULL, 'MAT-013', 'Lona Backlit', 'Lona para iluminación trasera, ancho 1.60m, por metro lineal', 5, 85, 127.5, 'Metro', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 1),
(15, NULL, 'MAT-014', 'Malla Microperforada', 'Malla para vistas desde interior, ancho 1.60m, por metro lineal', 3, 95, 142.5, 'Metro', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 1),
(16, NULL, 'MAT-015', 'Tela Poliéster Sublimación', 'Tela poliéster satinada, ancho 1.50m, por metro lineal', 5, 45, 67.5, 'Metro', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 1),
(17, NULL, 'MAT-016', 'Tinta Solvente CMYK Set', 'Set 4 botellas x 1L (Cian, Magenta, Amarillo, Negro)', 2, 1200, 1620, 'Set', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 1),
(18, NULL, 'MAT-017', 'Tinta UV CMYK Set', 'Set 4 botellas x 1L para impresión UV', 1, 1800, 2430, 'Set', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 1),
(19, NULL, 'MAT-018', 'Papel Transfer Sublimación', 'Rollo 1.10m x 100m, alta transferencia', 2, 380, 532, 'Rollo', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 1),
(20, NULL, 'MAT-019', 'Perfil Aluminio Bandera', 'Perfil de aluminio extrudio 2m para banderas/pendones', 10, 25, 40, 'Unidad', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 1),
(21, NULL, 'MAT-020', 'Base Metálica Roll-up', 'Base metálica con mecanismo retráctil 85x200cm', 3, 120, 180, 'Unidad', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 1),
(22, NULL, 'MAT-021', 'Cinta Doble Cara 3M', 'Rollo 12mm x 50m, adhesivo acrílico alta resistencia', 5, 45, 67.5, 'Rollo', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 1),
(23, NULL, 'MAT-022', 'Imán en Lámina', 'Lámina magnética 1.22m x 10m, 0.5mm espesor', 1, 280, 392, 'Rollo', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 1),
(24, NULL, 'MAT-023', 'Broches para Pendón', 'Broches plásticos transparentes con resorte, pack 100', 50, 2, 4, 'Unidad', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 1),
(25, NULL, 'MAT-024', 'Ojalillos Metálicos 12mm', 'Ojalillos bronce 12mm con maquina colocadora, bolsa 100', 100, 1.5, 3, 'Unidad', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 1),
(26, NULL, 'MAT-025', 'Silicona Industrial', 'Tubo 300ml, silicona neutra para acrílico y metales', 5, 35, 52.5, 'Unidad', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 1),
(27, NULL, 'MAT-026', 'Laca UV Brillante', 'Barniz UV brillante para acabado protector, galón 3.78L', 1, 450, 630, 'Galón', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 1),
(28, NULL, 'MAT-027', 'Cuchillas Plotter 45°', 'Cuchillas de corte 45° para plotter Graphtec/Roland, pack 10', 3, 15, 24, 'Caja', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 1),
(29, NULL, 'MAT-028', 'Spray Limpiador Cabezales', 'Spray 500ml para limpieza de cabezales impresora', 3, 25, 37.5, 'Unidad', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 1),
(30, NULL, 'MAT-029', 'Tubo Aluminio Redondo 1"', 'Tubo aluminio 1" diámetro x 3m, pared 1.5mm', 5, 35, 49, 'Unidad', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 1),
(31, NULL, 'MAT-030', 'LED Strip 5050 RGB', 'Tira LED 5050 RGB 5m, 12V, impermeable IP65', 3, 180, 252, 'Unidad', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 1),
(32, NULL, 'MAT-031', 'Fuente Poder 12V 10A', 'Fuente switching 12V 10A para tiras LED', 3, 35, 52.5, 'Unidad', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 1),
(33, NULL, 'MAT-032', 'Perfil Aluminio LED 2m', 'Perfil aluminio empotrar 2m para tira LED, con difusor', 5, 25, 37.5, 'Unidad', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 1),
(34, NULL, 'MAT-033', 'Policarbonato 2mm', 'Lámina 1.22m x 2.44m, transparente, protección UV', 2, 320, 480, 'Lámina', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 1),
(35, NULL, 'MAT-034', 'Aerosol Pintura Acrílica', 'Aerosol 400ml, colores básicos (blanco/negro/rojo)', 10, 12, 24, 'Unidad', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 1),
(36, NULL, 'PROD-002', 'Lona Publicitaria x m²', 'Lona Frontlit impresa full color, incluye ojalillos y refuerzo bordes', 5, 60, 120, 'm²', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 0),
(37, NULL, 'PROD-003', 'Roll-up 85x200cm', 'Banner retráctil impreso full color, incluye base metálica y estuche', 2, 350, 650, 'Unidad', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 0),
(38, NULL, 'PROD-004', 'Pendón Impreso 1x2m', 'Pendón lona impresa full color 1x2m con bolsillo y perfil aluminio', 3, 150, 350, 'Unidad', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 0),
(39, NULL, 'PROD-005', 'Sticker Impreso x m²', 'Vinil adhesivo impreso full color + laminado brillante/mate', 3, 80, 180, 'm²', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 0),
(40, NULL, 'PROD-006', 'Tarjetas Presentación x100', 'Tarjetas 9x5cm, impresión full color ambas caras, papel 300gr mate', 3, 120, 250, 'Pack', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 0),
(41, NULL, 'PROD-007', 'Volante Flyer x100', 'Volante tamaño carta, impresión full color, papel 150gr brillante', 3, 80, 180, 'Pack', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 0),
(42, NULL, 'PROD-008', 'Brochure Folleto x100', 'Folleto tamaño carta tripliegue, full color ambas caras, papel 200gr mate', 2, 200, 400, 'Pack', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 0),
(43, NULL, 'PROD-009', 'Letrero Acrílico x m²', 'Letrero acrílico 3mm con grabado o serigrafía, incluye soportes', 1, 450, 900, 'm²', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 0),
(44, NULL, 'PROD-010', 'Letrero LED x m²', 'Letrero acrílico con iluminación LED, incluye controlador y montaje', 1, 800, 1500, 'm²', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 0),
(45, NULL, 'PROD-011', 'Taza Sublimada 11oz', 'Taza cerámica 11oz impresa full color por sublimación', 10, 35, 80, 'Unidad', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 0),
(46, NULL, 'PROD-012', 'Camiseta Estampada', 'Camiseta algodón/poliéster impresa full color, todos los talles', 5, 60, 150, 'Unidad', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 0),
(47, NULL, 'PROD-013', 'Gorra Bordada', 'Gorra 6 paneles ajustable, bordado láser a color', 5, 50, 120, 'Unidad', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 0),
(48, NULL, 'PROD-014', 'Placa Acrílica Grabada', 'Placa acrílica 3mm con grabado láser, tamaño 20x30cm', 2, 180, 350, 'Unidad', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 0),
(49, NULL, 'PROD-015', 'Llavero Personalizado', 'Llavero acrílico con grabado láser, incluye argolla', 10, 15, 35, 'Unidad', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 0),
(50, NULL, 'PROD-016', 'Valla Publicitaria x m²', 'Valla de gran formato impresa en lona backlit, incluye instalación', 1, 250, 500, 'm²', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 0),
(51, NULL, 'PROD-017', 'Lettering Vehicular x m²', 'Vinil impreso + laminado instalado sobre vehículo', 1, 150, 300, 'm²', NULL, 1, NULL, '2026-06-10 11:33:18', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_recipe`
--

CREATE TABLE `product_recipe` (
  `id` int(11) NOT NULL,
  `product_parent_id` int(11) DEFAULT NULL,
  `material_id` int(11) DEFAULT NULL,
  `quantity_to_discount` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `product_recipe`
--

INSERT INTO `product_recipe` (`id`, `product_parent_id`, `material_id`, `quantity_to_discount`) VALUES
(1, 1, 2, 1),
(2, 1, 3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sell`
--

CREATE TABLE `sell` (
  `id` int(11) NOT NULL,
  `person_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `operation_type_id` int(11) DEFAULT 2,
  `box_id` int(11) DEFAULT NULL,
  `total` float DEFAULT NULL,
  `cash` float DEFAULT NULL,
  `discount` float DEFAULT NULL,
  `estado_produccion` varchar(50) DEFAULT 'Pendiente',
  `prioridad` varchar(20) DEFAULT 'Media',
  `fecha_entrega` date DEFAULT NULL,
  `diseno_url` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sell`
--

INSERT INTO `sell` (`id`, `person_id`, `user_id`, `operation_type_id`, `total`, `cash`, `discount`, `estado_produccion`, `prioridad`, `fecha_entrega`, `diseno_url`, `created_at`) VALUES
(1, 1, 1, 2, 4450, 4450, 0, 'Pendiente', 'Alta', '2026-06-14', 'https://drive.google.com/drive/folders/1abc-menu-parrilla', '2026-06-11 09:30:00'),
(2, 2, 1, 2, 1480, 1480, 0, 'En Prensa', 'Media', '2026-06-18', 'https://drive.google.com/drive/folders/2def-eleganza-brand', '2026-06-11 09:35:00'),
(3, 3, 1, 2, 4800, 4800, 0, 'Pendiente', 'Baja', '2026-06-25', 'https://drive.google.com/drive/folders/3ghi-techsolutions-logo', '2026-06-11 09:40:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `is_admin` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `name`, `lastname`, `username`, `email`, `password`, `image`, `is_active`, `is_admin`, `created_at`) VALUES
(1, 'Administrador', 'Sistema', 'admin', 'admin@warestock.com', '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', NULL, 1, 1, '2026-06-10 11:33:18');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `box`
--
ALTER TABLE `box`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `operation`
--
ALTER TABLE `operation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `operation_type_id` (`operation_type_id`),
  ADD KEY `sell_id` (`sell_id`);

--
-- Indices de la tabla `operation_type`
--
ALTER TABLE `operation_type`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indices de la tabla `product_recipe`
--
ALTER TABLE `product_recipe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_parent_id` (`product_parent_id`),
  ADD KEY `material_id` (`material_id`);

--
-- Indices de la tabla `sell`
--
ALTER TABLE `sell`
  ADD PRIMARY KEY (`id`),
  ADD KEY `person_id` (`person_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `box_id` (`box_id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `box`
--
ALTER TABLE `box`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `operation`
--
ALTER TABLE `operation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de la tabla `operation_type`
--
ALTER TABLE `operation_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `person`
--
ALTER TABLE `person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `product_recipe`
--
ALTER TABLE `product_recipe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `sell`
--
ALTER TABLE `sell`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `operation`
--
ALTER TABLE `operation`
  ADD CONSTRAINT `operation_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `operation_ibfk_2` FOREIGN KEY (`operation_type_id`) REFERENCES `operation_type` (`id`),
  ADD CONSTRAINT `operation_ibfk_3` FOREIGN KEY (`sell_id`) REFERENCES `sell` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Filtros para la tabla `product_recipe`
--
ALTER TABLE `product_recipe`
  ADD CONSTRAINT `product_recipe_ibfk_1` FOREIGN KEY (`product_parent_id`) REFERENCES `product` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_recipe_ibfk_2` FOREIGN KEY (`material_id`) REFERENCES `product` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sell`
--
ALTER TABLE `sell`
  ADD CONSTRAINT `sell_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`),
  ADD CONSTRAINT `sell_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `sell_ibfk_3` FOREIGN KEY (`box_id`) REFERENCES `box` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
