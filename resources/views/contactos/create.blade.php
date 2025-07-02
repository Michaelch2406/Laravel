@extends('layouts.app')

@section('title', 'Nuevo Contacto - Sistema de Contactos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-0">
            <i class="fas fa-plus-circle me-2"></i>Nuevo Contacto
        </h1>
        <p class="text-muted mb-0">Agrega un nuevo contacto al sistema</p>
    </div>
    <a href="{{ route('contactos.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Volver al Dashboard
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user-plus me-2"></i>Información del Contacto
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('contactos.store') }}" method="POST" id="contactoForm">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" 
                                       class="form-control @error('nombre') is-invalid @enderror" 
                                       id="nombre" 
                                       name="nombre" 
                                       placeholder="Nombre completo"
                                       value="{{ old('nombre') }}"
                                       required>
                                <label for="nombre">
                                    <i class="fas fa-user me-2"></i>Nombre Completo
                                </label>
                                @error('nombre')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" 
                                       class="form-control @error('usuario') is-invalid @enderror" 
                                       id="usuario" 
                                       name="usuario" 
                                       placeholder="Usuario"
                                       value="{{ old('usuario') }}"
                                       required>
                                <label for="usuario">
                                    <i class="fas fa-at me-2"></i>Usuario/Nickname
                                </label>
                                @error('usuario')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-floating mb-3">
                        <input type="tel" 
                               class="form-control @error('telefono') is-invalid @enderror" 
                               id="telefono" 
                               name="telefono" 
                               placeholder="Teléfono"
                               value="{{ old('telefono') }}"
                               required>
                        <label for="telefono">
                            <i class="fas fa-phone me-2"></i>Número de Teléfono
                        </label>
                        @error('telefono')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="form-floating mb-4">
                        <textarea class="form-control @error('mensaje') is-invalid @enderror" 
                                  id="mensaje" 
                                  name="mensaje" 
                                  placeholder="Mensaje"
                                  style="height: 120px"
                                  required>{{ old('mensaje') }}</textarea>
                        <label for="mensaje">
                            <i class="fas fa-comment me-2"></i>Mensaje
                        </label>
                        @error('mensaje')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-text">
                            <span id="charCount">0</span>/1000 caracteres
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('contactos.index') }}" class="btn btn-secondary me-md-2">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i>Guardar Contacto
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Tarjeta de ayuda -->
        <div class="card mt-4">
            <div class="card-body">
                <h6 class="card-title">
                    <i class="fas fa-lightbulb me-2 text-warning"></i>Consejos
                </h6>
                <ul class="mb-0">
                    <li>Asegúrate de que el número de teléfono sea válido</li>
                    <li>El usuario/nickname debe ser único y fácil de recordar</li>
                    <li>El mensaje puede contener información adicional sobre el contacto</li>
                    <li>Todos los campos son obligatorios</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .form-floating .form-control:focus ~ label {
        color: #667eea;
    }
    
    .form-floating .form-control:not(:placeholder-shown) ~ label {
        color: #667eea;
    }
    
    .card-header {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        border-bottom: 1px solid rgba(102, 126, 234, 0.2);
    }
    
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .is-invalid {
        border-color: #dc3545;
    }
    
    .is-invalid:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    
    .invalid-feedback {
        display: block;
    }
    
    #charCount {
        font-weight: bold;
        color: #667eea;
    }
    
    .char-warning {
        color: #ffc107 !important;
    }
    
    .char-danger {
        color: #dc3545 !important;
    }
</style>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Contador de caracteres para el mensaje
        const mensajeTextarea = $('#mensaje');
        const charCount = $('#charCount');
        const maxChars = 1000;
        
        function updateCharCount() {
            const currentLength = mensajeTextarea.val().length;
            charCount.text(currentLength);
            
            // Cambiar color según la cantidad de caracteres
            charCount.removeClass('char-warning char-danger');
            if (currentLength > maxChars * 0.8) {
                charCount.addClass('char-warning');
            }
            if (currentLength > maxChars * 0.95) {
                charCount.addClass('char-danger');
            }
        }
        
        mensajeTextarea.on('input', updateCharCount);
        updateCharCount(); // Inicializar contador
        
        // Validación en tiempo real
        $('#contactoForm').on('submit', function(e) {
            let isValid = true;
            
            // Validar nombre
            const nombre = $('#nombre').val().trim();
            if (nombre.length < 2) {
                isValid = false;
                $('#nombre').addClass('is-invalid');
            } else {
                $('#nombre').removeClass('is-invalid');
            }
            
            // Validar usuario
            const usuario = $('#usuario').val().trim();
            if (usuario.length < 3) {
                isValid = false;
                $('#usuario').addClass('is-invalid');
            } else {
                $('#usuario').removeClass('is-invalid');
            }
            
            // Validar teléfono
            const telefono = $('#telefono').val().trim();
            const telefonoRegex = /^[\d\s\-\+\(\)]+$/;
            if (!telefonoRegex.test(telefono) || telefono.length < 7) {
                isValid = false;
                $('#telefono').addClass('is-invalid');
            } else {
                $('#telefono').removeClass('is-invalid');
            }
            
            // Validar mensaje
            const mensaje = $('#mensaje').val().trim();
            if (mensaje.length < 10 || mensaje.length > maxChars) {
                isValid = false;
                $('#mensaje').addClass('is-invalid');
            } else {
                $('#mensaje').removeClass('is-invalid');
            }
            
            if (!isValid) {
                e.preventDefault();
                alert('Por favor, corrige los errores en el formulario antes de continuar.');
            }
        });
        
        // Formatear teléfono automáticamente
        $('#telefono').on('input', function() {
            let value = $(this).val().replace(/\D/g, ''); // Solo números
            if (value.length > 0) {
                // Formato básico para números de teléfono
                if (value.length <= 3) {
                    value = value;
                } else if (value.length <= 6) {
                    value = value.slice(0, 3) + '-' + value.slice(3);
                } else {
                    value = value.slice(0, 3) + '-' + value.slice(3, 6) + '-' + value.slice(6, 10);
                }
            }
            $(this).val(value);
        });
        
        // Capitalizar primera letra del nombre
        $('#nombre').on('blur', function() {
            const value = $(this).val();
            $(this).val(value.charAt(0).toUpperCase() + value.slice(1));
        });
        
        // Convertir usuario a minúsculas
        $('#usuario').on('input', function() {
            $(this).val($(this).val().toLowerCase());
        });
    });
</script>
@endsection

