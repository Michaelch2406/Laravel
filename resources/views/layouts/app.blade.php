<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema de Contactos - Laravel')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif; /* Mantengo la fuente por legibilidad */
            background-color: #f8f9fa; /* Un gris muy claro como fondo general */
            color: #212529; /* Color de texto oscuro estándar */
            min-height: 100vh;
        }
        
        .navbar {
            background-color: #ffffff !important; /* Navbar blanca */
            border-bottom: 1px solid #dee2e6; /* Borde sutil */
            box-shadow: none; /* Sin sombra */
        }
        
        .main-content {
            background-color: #ffffff; /* Contenido principal blanco */
            border: 1px solid #dee2e6; /* Borde sutil */
            border-radius: 0.25rem; /* Bordes redondeados estándar de Bootstrap */
            box-shadow: none; /* Sin sombra */
            margin: 20px 0;
            padding: 20px; /* Padding reducido un poco */
        }

        /* Estilos básicos para botones de Bootstrap, no se necesitan gradientes ni sombras */
        .btn {
            border-radius: 0.25rem; /* Bordes redondeados estándar */
            padding: 0.375rem 0.75rem; /* Padding estándar de Bootstrap */
            font-weight: 400;
            /* transition: none; Quitamos transiciones */
        }

        .btn-primary {
            /* Los colores de Bootstrap por defecto para .btn-primary son adecuados */
        }
        
        .btn-primary:hover {
            /* Comportamiento hover por defecto de Bootstrap */
        }
        
        .btn-success {
            /* Colores por defecto de Bootstrap */
        }
        
        .btn-warning {
            color: #000; /* Asegurar contraste en warning si se usa el amarillo de Bootstrap */
        }
        
        .btn-danger {
            /* Colores por defecto de Bootstrap */
        }
        
        .table {
            border-radius: 0; /* Sin bordes redondeados especiales */
            box-shadow: none; /* Sin sombra */
            border: 1px solid #dee2e6; /* Borde estándar para la tabla */
        }
        
        .table thead th {
            background-color: #e9ecef; /* Un gris claro para cabecera de tabla */
            color: #212529; /* Texto oscuro */
            border-bottom: 2px solid #dee2e6; /* Borde inferior más marcado */
            font-weight: 500; /* Un poco menos de peso */
            padding: 0.75rem; /* Padding estándar */
        }
        
        .table tbody tr:hover {
            background-color: #f1f3f5; /* Un hover muy sutil */
            /* transform: none; Quitamos transformaciones */
        }
        
        .form-control {
            border-radius: 0.25rem; /* Bordes estándar */
            border: 1px solid #ced4da; /* Borde estándar de Bootstrap */
            padding: 0.375rem 0.75rem; /* Padding estándar */
            /* transition: none; */
        }
        
        .form-control:focus {
            border-color: #80bdff; /* Color de foco estándar de Bootstrap */
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25); /* Sombra de foco estándar */
        }
        
        .alert {
            border-radius: 0.25rem; /* Bordes estándar */
            border-width: 1px;
            border-style: solid;
            padding: 0.75rem 1.25rem; /* Padding estándar */
            margin-bottom: 1rem; /* Margen estándar */
        }
        
        /* Bootstrap ya define bien .alert-success, .alert-danger, etc. con colores sólidos */
        /* No es necesario sobreescribirlos si queremos un diseño básico */

        .card {
            border: 1px solid #dee2e6; /* Borde estándar */
            border-radius: 0.25rem; /* Bordes estándar */
            box-shadow: none; /* Sin sombra */
            /* transition: none; */
        }
        
        .card:hover {
            /* transform: none; */
            box-shadow: none;
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }
        
        .pagination .page-link {
            border-radius: 0.25rem; /* Bordes estándar */
            margin: 0 2px;
            border: 1px solid #dee2e6; /* Borde estándar */
            color: #007bff; /* Color de enlace estándar de Bootstrap */
            /* transition: none; */
        }
        
        .pagination .page-link:hover {
            background-color: #e9ecef; /* Hover estándar */
            color: #0056b3;
            /* transform: none; */
        }
        
        .pagination .page-item.active .page-link {
            background-color: #007bff; /* Color activo estándar */
            border-color: #007bff; /* Borde activo estándar */
            color: white;
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Navbar -->
    @auth
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
                <i class="fas fa-address-book me-2"></i>
                Sistema de Contactos
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <i class="fas fa-home me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contactos.create') }}">
                            <i class="fas fa-plus me-1"></i>Nuevo Contacto
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-1"></i>Cerrar Sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    @endauth
    
    <!-- Main Content -->
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        <div class="main-content">
            @yield('content')
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    @yield('scripts')
</body>
</html>

