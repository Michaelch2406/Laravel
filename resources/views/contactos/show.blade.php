@extends('layouts.app')

@section('title', 'Ver Contacto - Sistema de Contactos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-0">
            <i class="fas fa-user me-2"></i>{{ $contacto->nombre }}
        </h1>
        <p class="text-muted mb-0">Detalles del contacto #{{ $contacto->id }}</p>
    </div>
    <div>
        <a href="{{ route('contactos.edit', $contacto) }}" class="btn btn-warning me-2">
            <i class="fas fa-edit me-2"></i>Editar
        </a>
        <a href="{{ route('contactos.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver al Dashboard
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <!-- Información principal del contacto -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Información del Contacto
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-item mb-4">
                            <label class="info-label">
                                <i class="fas fa-user me-2 text-primary"></i>Nombre Completo
                            </label>
                            <div class="info-value">{{ $contacto->nombre }}</div>
                        </div>
                        
                        <div class="info-item mb-4">
                            <label class="info-label">
                                <i class="fas fa-at me-2 text-success"></i>Usuario/Nickname
                            </label>
                            <div class="info-value">{{ $contacto->usuario }}</div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="info-item mb-4">
                            <label class="info-label">
                                <i class="fas fa-phone me-2 text-info"></i>Número de Teléfono
                            </label>
                            <div class="info-value">
                                <a href="tel:{{ $contacto->telefono }}" class="text-decoration-none">
                                    {{ $contacto->telefono }}
                                </a>
                                <button class="btn btn-sm btn-outline-secondary ms-2" onclick="copiarTexto('{{ $contacto->telefono }}')">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="info-item mb-4">
                            <label class="info-label">
                                <i class="fas fa-hashtag me-2 text-secondary"></i>ID del Contacto
                            </label>
                            <div class="info-value">
                                <span class="badge bg-secondary">#{{ $contacto->id }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="info-item">
                    <label class="info-label">
                        <i class="fas fa-comment me-2 text-warning"></i>Mensaje
                    </label>
                    <div class="info-value mensaje-content">
                        {{ $contacto->mensaje }}
                        <button class="btn btn-sm btn-outline-secondary ms-2" onclick="copiarTexto('{{ addslashes($contacto->mensaje) }}')">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Acciones rápidas -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-bolt me-2"></i>Acciones Rápidas
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <a href="tel:{{ $contacto->telefono }}" class="btn btn-success w-100">
                            <i class="fas fa-phone me-2"></i>Llamar
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="sms:{{ $contacto->telefono }}" class="btn btn-info w-100">
                            <i class="fas fa-sms me-2"></i>Enviar SMS
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contacto->telefono) }}" 
                           target="_blank" class="btn btn-success w-100">
                            <i class="fab fa-whatsapp me-2"></i>WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- Avatar y estadísticas -->
        <div class="card">
            <div class="card-body text-center">
                <div class="avatar-large mb-3">
                    {{ strtoupper(substr($contacto->nombre, 0, 2)) }}
                </div>
                <h5 class="card-title">{{ $contacto->nombre }}</h5>
                <p class="text-muted">@{{ $contacto->usuario }}</p>
                
                <div class="stats-grid mt-4">
                    <div class="stat-item">
                        <div class="stat-number">{{ $contacto->id }}</div>
                        <div class="stat-label">ID</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">{{ strlen($contacto->mensaje) }}</div>
                        <div class="stat-label">Caracteres</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">{{ $contacto->created_at->diffInDays(now()) }}</div>
                        <div class="stat-label">Días</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Información de fechas -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-calendar me-2"></i>Información de Fechas
                </h6>
            </div>
            <div class="card-body">
                <div class="timeline-item">
                    <div class="timeline-marker bg-success"></div>
                    <div class="timeline-content">
                        <h6 class="timeline-title">Creado</h6>
                        <p class="timeline-date">{{ $contacto->created_at->format('d/m/Y H:i') }}</p>
                        <small class="text-muted">{{ $contacto->created_at->diffForHumans() }}</small>
                    </div>
                </div>
                
                @if($contacto->updated_at != $contacto->created_at)
                <div class="timeline-item">
                    <div class="timeline-marker bg-warning"></div>
                    <div class="timeline-content">
                        <h6 class="timeline-title">Última modificación</h6>
                        <p class="timeline-date">{{ $contacto->updated_at->format('d/m/Y H:i') }}</p>
                        <small class="text-muted">{{ $contacto->updated_at->diffForHumans() }}</small>
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Acciones de gestión -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-cogs me-2"></i>Gestión del Contacto
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('contactos.edit', $contacto) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Editar Contacto
                    </a>
                    <button type="button" class="btn btn-danger" onclick="confirmarEliminacion()">
                        <i class="fas fa-trash me-2"></i>Eliminar Contacto
                    </button>
                </div>
                
                <!-- Formulario oculto para eliminar -->
                <form id="delete-form" action="{{ route('contactos.destroy', $contacto) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .info-item {
        border-bottom: 1px solid #f8f9fa;
        padding-bottom: 15px;
    }
    
    .info-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    
    .info-label {
        font-weight: 600;
        color: #495057;
        font-size: 0.9rem;
        display: block;
        margin-bottom: 8px;
    }
    
    .info-value {
        font-size: 1.1rem;
        color: #212529;
        word-wrap: break-word;
    }
    
    .mensaje-content {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
        border-left: 4px solid #667eea;
        white-space: pre-wrap;
        line-height: 1.6;
    }
    
    .avatar-large {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 24px;
        margin: 0 auto;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }
    
    .stat-item {
        text-align: center;
    }
    
    .stat-number {
        font-size: 1.5rem;
        font-weight: bold;
        color: #667eea;
    }
    
    .stat-label {
        font-size: 0.8rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .timeline-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 20px;
        position: relative;
    }
    
    .timeline-item:last-child {
        margin-bottom: 0;
    }
    
    .timeline-marker {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin-right: 15px;
        margin-top: 4px;
        flex-shrink: 0;
    }
    
    .timeline-content {
        flex: 1;
    }
    
    .timeline-title {
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 5px;
    }
    
    .timeline-date {
        font-size: 0.95rem;
        margin-bottom: 2px;
    }
    
    .card-header {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        border-bottom: 1px solid rgba(102, 126, 234, 0.2);
    }
    
    .btn-outline-secondary {
        border-color: #dee2e6;
    }
    
    .btn-outline-secondary:hover {
        background-color: #6c757d;
        border-color: #6c757d;
    }
</style>
@endsection

@section('scripts')
<script>
    function copiarTexto(texto) {
        navigator.clipboard.writeText(texto).then(function() {
            // Mostrar notificación de éxito
            const toast = document.createElement('div');
            toast.className = 'toast-notification';
            toast.innerHTML = '<i class="fas fa-check me-2"></i>Texto copiado al portapapeles';
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.remove();
            }, 3000);
        }).catch(function(err) {
            console.error('Error al copiar texto: ', err);
            alert('No se pudo copiar el texto');
        });
    }
    
    function confirmarEliminacion() {
        if (confirm('¿Estás seguro de que deseas eliminar este contacto?\n\nEsta acción no se puede deshacer y se perderá toda la información del contacto.')) {
            document.getElementById('delete-form').submit();
        }
    }
    
    // Estilos para la notificación toast
    const style = document.createElement('style');
    style.textContent = `
        .toast-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            z-index: 9999;
            animation: slideIn 0.3s ease-out;
        }
        
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    `;
    document.head.appendChild(style);
</script>
@endsection

