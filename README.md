# Sistema de Gestión de Contactos - Laravel

## Descripción del Proyecto

Este es un sistema completo de gestión de contactos desarrollado con Laravel 9.5.2 que permite a los usuarios autenticarse y gestionar una base de datos de contactos con funcionalidades CRUD completas (Crear, Leer, Actualizar, Eliminar).

### Características Principales

- **Sistema de Autenticación**: Login seguro con sesiones PHP
- **Dashboard Interactivo**: Vista principal con estadísticas y tabla de contactos
- **CRUD Completo**: Crear, leer, actualizar y eliminar contactos
- **Búsqueda Avanzada**: Filtrado por nombre, usuario, teléfono o mensaje
- **Interfaz Moderna**: Diseño responsivo con Bootstrap 5 y animaciones CSS
- **Validaciones**: Validación tanto del lado del servidor como del cliente
- **Paginación**: Navegación eficiente para grandes cantidades de datos

### Tecnologías Utilizadas

- **Backend**: PHP 8.0.30, Laravel 9.5.2
- **Base de Datos**: MySQL 8.0.41
- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 5
- **Servidor**: IIS
- **Gestor de Dependencias**: Composer

## Estructura de la Base de Datos

### Tabla: users
```sql
- id (bigint, auto_increment, primary key)
- name (varchar 255)
- email (varchar 255, unique)
- email_verified_at (timestamp, nullable)
- password (varchar 255)
- remember_token (varchar 100, nullable)
- created_at (timestamp)
- updated_at (timestamp)
```

### Tabla: contactos
```sql
- id (bigint, auto_increment, primary key)
- nombre (varchar 100)
- usuario (varchar 50)
- telefono (varchar 20)
- mensaje (text)
- created_at (timestamp)
- updated_at (timestamp)
```

## Credenciales de Acceso

### Usuario Administrador
- **Email**: admin@laravel.com
- **Contraseña**: 123456

### Usuario Demo
- **Email**: demo@laravel.com
- **Contraseña**: demo123

## Estructura del Proyecto

```
laravel_blog/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   └── ContactoController.php
│   │   ├── Middleware/
│   │   │   ├── Authenticate.php
│   │   │   ├── EncryptCookies.php
│   │   │   ├── TrimStrings.php
│   │   │   └── VerifyCsrfToken.php
│   │   └── Kernel.php
│   └── Models/
│       ├── User.php
│       └── Contacto.php
├── config/
│   ├── app.php
│   ├── auth.php
│   ├── database.php
│   └── session.php
├── database/
│   ├── migrations/
│   │   ├── 2014_10_12_000000_create_users_table.php
│   │   └── 2024_01_01_000000_create_contactos_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       └── UserSeeder.php
├── resources/
│   └── views/
│       ├── auth/
│       │   └── login.blade.php
│       ├── contactos/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   └── show.blade.php
│       └── layouts/
│           └── app.blade.php
├── routes/
│   └── web.php
├── .env
├── composer.json
└── README.md
```

## Funcionalidades del Sistema

### 1. Autenticación
- Login seguro con validación de credenciales
- Manejo de sesiones PHP
- Protección CSRF
- Middleware de autenticación para rutas protegidas

### 2. Dashboard
- Estadísticas en tiempo real (total, hoy, esta semana, este mes)
- Tabla de contactos con paginación
- Búsqueda en tiempo real
- Acciones rápidas (ver, editar, eliminar)

### 3. Gestión de Contactos
- **Crear**: Formulario con validaciones en tiempo real
- **Leer**: Vista detallada con información completa
- **Actualizar**: Edición con preservación de datos
- **Eliminar**: Confirmación antes de eliminar

### 4. Características de UX/UI
- Diseño responsivo para móviles y escritorio
- Animaciones y transiciones suaves
- Notificaciones de éxito y error
- Contador de caracteres en formularios
- Formateo automático de números de teléfono

## Rutas del Sistema

```php
// Rutas públicas
GET  /                    -> Redirige al login
GET  /login              -> Mostrar formulario de login
POST /login              -> Procesar login

// Rutas protegidas (requieren autenticación)
GET  /dashboard          -> Dashboard principal
POST /logout             -> Cerrar sesión

// CRUD de contactos
GET  /contactos          -> Listar contactos (dashboard)
GET  /contactos/create   -> Formulario crear contacto
POST /contactos          -> Guardar nuevo contacto
GET  /contactos/{id}     -> Ver detalles del contacto
GET  /contactos/{id}/edit -> Formulario editar contacto
PUT  /contactos/{id}     -> Actualizar contacto
DELETE /contactos/{id}   -> Eliminar contacto
```

## Validaciones Implementadas

### Formulario de Login
- Email: requerido, formato válido
- Contraseña: requerida, mínimo 6 caracteres

### Formulario de Contactos
- Nombre: requerido, máximo 100 caracteres
- Usuario: requerido, máximo 50 caracteres
- Teléfono: requerido, máximo 20 caracteres, formato válido
- Mensaje: requerido, máximo 1000 caracteres

## Seguridad

- Protección CSRF en todos los formularios
- Validación de entrada tanto en cliente como servidor
- Autenticación requerida para acceder al sistema
- Encriptación de contraseñas con Hash
- Sanitización de datos de entrada
- Protección contra inyección SQL mediante Eloquent ORM

## Características Técnicas

### Backend
- Arquitectura MVC (Model-View-Controller)
- Eloquent ORM para interacción con base de datos
- Middleware personalizado para autenticación
- Validaciones robustas con mensajes personalizados
- Manejo de sesiones seguro

### Frontend
- Bootstrap 5 para diseño responsivo
- jQuery para interactividad
- Font Awesome para iconografía
- Google Fonts para tipografía
- CSS personalizado con gradientes y animaciones
- JavaScript para validaciones en tiempo real

### Base de Datos
- Migraciones para control de versiones de esquema
- Seeders para datos iniciales
- Relaciones entre modelos
- Índices para optimización de consultas

