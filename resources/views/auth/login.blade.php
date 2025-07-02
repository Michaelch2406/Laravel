<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Iniciar Sesión - Sistema de Contactos</title>
    
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
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem; /* Espacio por si el contenido es muy grande en pantallas pequeñas */
        }
        
        .login-container {
            background-color: #ffffff; /* Contenedor blanco */
            border: 1px solid #dee2e6; /* Borde sutil */
            border-radius: 0.25rem; /* Bordes redondeados estándar */
            box-shadow: none; /* Sin sombra */
            padding: 2rem; /* Padding aumentado ligeramente para más espacio */
            width: 100%;
            max-width: 450px;
            /* animation: none; quitamos animación */
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 1.5rem; /* Reducido el margen inferior */
        }
        
        .login-header h1 {
            /* background: none; quitamos gradiente */
            /* -webkit-background-clip: unset; */
            /* -webkit-text-fill-color: unset; */
            /* background-clip: unset; */
            color: #212529; /* Color de texto estándar */
            font-weight: 600; /* Un poco menos de peso */
            font-size: 1.75rem; /* Tamaño reducido */
            margin-bottom: 0.5rem; /* Margen reducido */
        }
        
        .login-header p {
            color: #6c757d; /* Color de Bootstrap para texto silenciado */
            font-size: 1rem; /* Tamaño estándar */
        }
        
        .form-floating {
            margin-bottom: 1rem; /* Margen estándar de Bootstrap */
        }
        
        .form-control { /* Heredado de app.blade.php si es que login extiende de app, o definido aquí si es standalone */
            border-radius: 0.25rem;
            border: 1px solid #ced4da;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            /* transition: none; */
            background-color: #fff; /* Fondo blanco explícito */
        }
        
        .form-control:focus { /* Heredado o definido */
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            background-color: #fff;
        }
        
        .form-floating label {
            color: #6c757d;
            font-weight: 400; /* Peso normal */
        }
        
        .btn-login { /* Usará estilos de .btn .btn-primary de Bootstrap por defecto */
            /* background: none; */
            /* border: none; */
            border-radius: 0.25rem;
            padding: 0.5rem 1rem; /* Padding ajustado */
            font-weight: 500;
            font-size: 1rem;
            width: 100%;
            /* color: white; Ya lo define .btn-primary */
            /* transition: none; */
            margin-top: 0.5rem; /* Margen reducido */
        }
        
        .btn-login:hover {
            /* transform: none; */
            /* box-shadow: none; */
            /* color: white; */
        }
        
        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 1rem; /* Margen estándar */
        }
        
        .form-check-input { /* Estilos de Bootstrap por defecto son adecuados */
            border-radius: 0.25em; /* Bootstrap default */
            border: 1px solid #adb5bd; /* Bootstrap default */
            margin-right: 0.5em; /* Espacio a la derecha */
        }
        
        .form-check-input:checked {
            /* background-color: #0d6efd; Bootstrap default */
            /* border-color: #0d6efd; Bootstrap default */
        }
        
        .alert { /* Heredado o definido */
            border-radius: 0.25rem;
            border-width: 1px;
            border-style: solid;
            padding: 0.75rem 1.25rem;
            margin-bottom: 1rem;
        }
        
        /* .alert-success, .alert-danger heredan de app.blade.php o usan defaults de Bootstrap */
        
        .login-footer {
            text-align: center;
            margin-top: 1.5rem; /* Margen reducido */
            padding-top: 1rem; /* Padding reducido */
            border-top: 1px solid #e9ecef;
        }
        
        .demo-credentials {
            background-color: #e9ecef; /* Fondo gris claro */
            border-radius: 0.25rem;
            padding: 1rem; /* Padding reducido */
            margin-bottom: 1rem; /* Margen estándar */
            border-left: 3px solid #0d6efd; /* Borde izquierdo azul Bootstrap */
        }
        
        .demo-credentials h6 {
            color: #0d6efd; /* Azul Bootstrap */
            font-weight: 500; /* Un poco menos de peso */
            margin-bottom: 0.5rem;
        }
        
        .demo-credentials p {
            margin: 0.25rem 0; /* Margen reducido */
            font-size: 0.9rem;
            color: #495057;
        }
        
        /* Se eliminan .floating-shapes y @keyframes float */
    </style>
</head>
<body>
    <!-- Se elimina div.floating-shapes -->
    
    <div class="login-container">
        <div class="login-header">
            <h1><i class="fas fa-address-book"></i></h1>
            <h1>Bienvenido</h1>
            <p>Inicia sesión en tu cuenta</p>
        </div>
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                @foreach($errors->all() as $error)
                    {{ $error }}
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        <div class="demo-credentials">
            <h6><i class="fas fa-info-circle me-2"></i>Credenciales de Prueba</h6>
            <p><strong>Email:</strong> admin@laravel.com</p>
            <p><strong>Contraseña:</strong> 123456</p>
            <p><strong>O también:</strong> demo@laravel.com / demo123</p>
        </div>
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="form-floating">
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" value="{{ old('email') }}" required>
                <label for="email"><i class="fas fa-envelope me-2"></i>Correo Electrónico</label>
            </div>
            
            <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                <label for="password"><i class="fas fa-lock me-2"></i>Contraseña</label>
            </div>
            
            <div class="remember-me">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">
                    Recordarme
                </label>
            </div>
            
            <button type="submit" class="btn btn-login">
                <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
            </button>
        </form>

        <div class="text-center mt-3">
            <p>¿No tienes una cuenta? <a href="{{ route('register') }}">Regístrate aquí</a></p>
        </div>
        
        <div class="login-footer">
            <p class="text-muted">
                <i class="fas fa-shield-alt me-1"></i>
                Sistema seguro con Laravel {{ app()->version() }}
            </p>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

