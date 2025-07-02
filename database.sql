-- =====================================================
-- Script SQL para Sistema de Gestión de Contactos
-- Laravel 9.5.2 con MySQL 8.0.41
-- =====================================================

-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS `laravel_blog` 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- Usar la base de datos
USE `laravel_blog`;

-- =====================================================
-- Tabla: users
-- Almacena los usuarios del sistema
-- =====================================================
CREATE TABLE `users` (
    `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `email_verified_at` timestamp NULL DEFAULT NULL,
    `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Tabla: contactos
-- Almacena la información de los contactos
-- =====================================================
CREATE TABLE `contactos` (
    `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nombre completo del contacto',
    `usuario` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Usuario o nickname',
    `telefono` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Número de teléfono',
    `mensaje` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Mensaje del contacto',
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_contactos_nombre` (`nombre`),
    KEY `idx_contactos_usuario` (`usuario`),
    KEY `idx_contactos_telefono` (`telefono`),
    KEY `idx_contactos_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Tabla: migrations (Laravel)
-- Control de versiones de migraciones
-- =====================================================
CREATE TABLE `migrations` (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `batch` int(11) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Insertar registros de migraciones
-- =====================================================
INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2024_01_01_000000_create_contactos_table', 1);

-- =====================================================
-- Datos iniciales: Usuarios del sistema
-- =====================================================
INSERT INTO `users` (`name`, `email`, `password`, `created_at`, `updated_at`) VALUES
('Administrador', 'admin@laravel.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('Usuario Demo', 'demo@laravel.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW());

-- Nota: Las contraseñas hasheadas corresponden a:
-- admin@laravel.com -> 123456
-- demo@laravel.com -> demo123

-- =====================================================
-- Datos de ejemplo: Contactos
-- =====================================================
INSERT INTO `contactos` (`nombre`, `usuario`, `telefono`, `mensaje`, `created_at`, `updated_at`) VALUES
('Juan Carlos Pérez', 'juancarlos', '555-0123', 'Contacto de trabajo para proyectos de desarrollo web. Especialista en frontend con React y Vue.js.', NOW(), NOW()),
('María González López', 'mariag', '555-0456', 'Diseñadora gráfica freelance. Interesada en colaboraciones para proyectos de branding y diseño digital.', NOW(), NOW()),
('Roberto Silva Martínez', 'robertosm', '555-0789', 'Gerente de ventas en empresa tecnológica. Busca soluciones de software para automatización de procesos.', NOW(), NOW()),
('Ana Lucía Rodríguez', 'analucia', '555-0321', 'Consultora en marketing digital. Especializada en SEO, SEM y estrategias de contenido para redes sociales.', NOW(), NOW()),
('Carlos Eduardo Morales', 'carlosem', '555-0654', 'Desarrollador backend con experiencia en PHP, Python y Node.js. Disponible para proyectos remotos.', NOW(), NOW());

-- =====================================================
-- Índices adicionales para optimización
-- =====================================================

-- Índice compuesto para búsquedas frecuentes
ALTER TABLE `contactos` ADD INDEX `idx_search` (`nombre`, `usuario`, `telefono`);

-- Índice para ordenamiento por fecha
ALTER TABLE `contactos` ADD INDEX `idx_date_sort` (`created_at` DESC);

-- =====================================================
-- Configuraciones adicionales
-- =====================================================

-- Configurar el auto_increment para empezar en 1
ALTER TABLE `users` AUTO_INCREMENT = 1;
ALTER TABLE `contactos` AUTO_INCREMENT = 1;
ALTER TABLE `migrations` AUTO_INCREMENT = 1;

-- =====================================================
-- Procedimientos almacenados útiles
-- =====================================================

-- Procedimiento para buscar contactos
DELIMITER //
CREATE PROCEDURE BuscarContactos(IN termino_busqueda VARCHAR(255))
BEGIN
    SELECT * FROM contactos 
    WHERE nombre LIKE CONCAT('%', termino_busqueda, '%')
       OR usuario LIKE CONCAT('%', termino_busqueda, '%')
       OR telefono LIKE CONCAT('%', termino_busqueda, '%')
       OR mensaje LIKE CONCAT('%', termino_busqueda, '%')
    ORDER BY created_at DESC;
END //
DELIMITER ;

-- Procedimiento para obtener estadísticas
DELIMITER //
CREATE PROCEDURE ObtenerEstadisticas()
BEGIN
    SELECT 
        COUNT(*) as total_contactos,
        COUNT(CASE WHEN DATE(created_at) = CURDATE() THEN 1 END) as contactos_hoy,
        COUNT(CASE WHEN YEARWEEK(created_at) = YEARWEEK(NOW()) THEN 1 END) as contactos_semana,
        COUNT(CASE WHEN MONTH(created_at) = MONTH(NOW()) AND YEAR(created_at) = YEAR(NOW()) THEN 1 END) as contactos_mes
    FROM contactos;
END //
DELIMITER ;

-- =====================================================
-- Vistas útiles
-- =====================================================

-- Vista para contactos con información resumida
CREATE VIEW vista_contactos_resumen AS
SELECT 
    id,
    nombre,
    usuario,
    telefono,
    LEFT(mensaje, 100) as mensaje_corto,
    created_at,
    DATEDIFF(NOW(), created_at) as dias_desde_creacion
FROM contactos
ORDER BY created_at DESC;

-- =====================================================
-- Triggers para auditoría
-- =====================================================

-- Trigger para registrar cambios en contactos
CREATE TABLE contactos_auditoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contacto_id BIGINT UNSIGNED,
    accion ENUM('INSERT', 'UPDATE', 'DELETE'),
    datos_anteriores JSON,
    datos_nuevos JSON,
    usuario VARCHAR(255),
    fecha_cambio TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DELIMITER //
CREATE TRIGGER contactos_after_update
AFTER UPDATE ON contactos
FOR EACH ROW
BEGIN
    INSERT INTO contactos_auditoria (contacto_id, accion, datos_anteriores, datos_nuevos, usuario)
    VALUES (
        NEW.id,
        'UPDATE',
        JSON_OBJECT('nombre', OLD.nombre, 'usuario', OLD.usuario, 'telefono', OLD.telefono, 'mensaje', OLD.mensaje),
        JSON_OBJECT('nombre', NEW.nombre, 'usuario', NEW.usuario, 'telefono', NEW.telefono, 'mensaje', NEW.mensaje),
        USER()
    );
END //
DELIMITER ;

-- =====================================================
-- Configuraciones de seguridad recomendadas
-- =====================================================

-- Crear usuario específico para la aplicación Laravel
-- CREATE USER 'laravel_user'@'localhost' IDENTIFIED BY 'password_seguro_aqui';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON laravel_blog.* TO 'laravel_user'@'localhost';
-- FLUSH PRIVILEGES;

-- =====================================================
-- Comandos de mantenimiento
-- =====================================================

-- Optimizar tablas
-- OPTIMIZE TABLE users, contactos;

-- Analizar tablas para estadísticas
-- ANALYZE TABLE users, contactos;

-- Verificar integridad de tablas
-- CHECK TABLE users, contactos;

-- =====================================================
-- Consultas útiles para administración
-- =====================================================

-- Ver el tamaño de las tablas
-- SELECT 
--     table_name AS 'Tabla',
--     ROUND(((data_length + index_length) / 1024 / 1024), 2) AS 'Tamaño (MB)'
-- FROM information_schema.TABLES 
-- WHERE table_schema = 'laravel_blog';

-- Ver índices de una tabla
-- SHOW INDEX FROM contactos;

-- Ver el plan de ejecución de una consulta
-- EXPLAIN SELECT * FROM contactos WHERE nombre LIKE '%Juan%';

-- =====================================================
-- Fin del script
-- =====================================================

-- Mostrar mensaje de confirmación
SELECT 'Base de datos laravel_blog creada exitosamente' AS mensaje;

