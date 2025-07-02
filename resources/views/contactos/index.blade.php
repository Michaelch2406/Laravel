@extends('layouts.app')

@section('title', 'Dashboard - Sistema de Contactos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-0">
            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
        </h1>
        <p class="text-muted mb-0">Gestiona todos tus contactos desde aquí</p>
    </div>
    <a href="{{ route('contactos.create') }}" class="btn btn-success">
        <i class="fas fa-plus me-2"></i>Nuevo Contacto
    </a>
</div>

<!-- Estadísticas -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-users fa-2x text-primary mb-3"></i>
                <h3 class="card-title">{{ $contactos->total() }}</h3>
                <p class="card-text text-muted">Total Contactos</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-calendar-day fa-2x text-success mb-3"></i>
                <h3 class="card-title">{{ \App\Models\Contacto::whereDate('created_at', today())->count() }}</h3>
                <p class="card-text text-muted">Hoy</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-calendar-week fa-2x text-warning mb-3"></i>
                <h3 class="card-title">{{ \App\Models\Contacto::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count() }}</h3>
                <p class="card-text text-muted">Esta Semana</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-calendar-alt fa-2x text-info mb-3"></i>
                <h3 class="card-title">{{ \App\Models\Contacto::whereMonth('created_at', now()->month)->count() }}</h3>
                <p class="card-text text-muted">Este Mes</p>
            </div>
        </div>
    </div>
</div>

<!-- Barra de búsqueda -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('contactos.index') }}" class="row g-3">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" class="form-control" name="buscar" 
                           placeholder="Buscar por nombre, usuario, teléfono o mensaje..." 
                           value="{{ request('buscar') }}">
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search me-1"></i>Buscar
                </button>
            </div>
        </form>
        
        @if(request('buscar'))
            <div class="mt-3">
                <span class="badge bg-info">
                    Resultados para: "{{ request('buscar') }}"
                </span>
                <a href="{{ route('contactos.index') }}" class="btn btn-sm btn-outline-secondary ms-2">
                    <i class="fas fa-times me-1"></i>Limpiar
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Tabla de contactos -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-list me-2"></i>Lista de Contactos
        </h5>
        <span class="badge bg-primary">{{ $contactos->total() }} contactos</span>
    </div>
    <div class="card-body p-0">
        @if($contactos->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="8%">ID</th>
                            <th width="20%">Nombre</th>
                            <th width="15%">Usuario</th>
                            <th width="15%">Teléfono</th>
                            <th width="25%">Mensaje</th>
                            <th width="12%">Fecha</th>
                            <th width="15%">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contactos as $contacto)
                            <tr>
                                <td>
                                    <span class="badge bg-secondary">#{{ $contacto->id }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-2">
                                            {{ strtoupper(substr($contacto->nombre, 0, 1)) }}
                                        </div>
                                        <strong>{{ $contacto->nombre }}</strong>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-primary">{{ $contacto->usuario }}</span>
                                </td>
                                <td>
                                    <i class="fas fa-phone me-1 text-success"></i>
                                    {{ $contacto->telefono }}
                                </td>
                                <td>
                                    <span class="text-truncate d-inline-block" style="max-width: 200px;" 
                                          title="{{ $contacto->mensaje }}">
                                        {{ Str::limit($contacto->mensaje, 50) }}
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $contacto->created_at->format('d/m/Y') }}
                                        <br>
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $contacto->created_at->format('H:i') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('contactos.show', $contacto) }}" 
                                           class="btn btn-sm btn-outline-info" title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('contactos.edit', $contacto) }}" 
                                           class="btn btn-sm btn-warning" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                                onclick="confirmarEliminacion({{ $contacto->id }})" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Formulario oculto para eliminar -->
                                    <form id="delete-form-{{ $contacto->id }}" 
                                          action="{{ route('contactos.destroy', $contacto) }}" 
                                          method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Paginación -->
            @if($contactos->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">
                                Mostrando {{ $contactos->firstItem() }} a {{ $contactos->lastItem() }} 
                                de {{ $contactos->total() }} resultados
                            </small>
                        </div>
                        <div>
                            {{ $contactos->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No hay contactos disponibles</h5>
                <p class="text-muted">
                    @if(request('buscar'))
                        No se encontraron contactos que coincidan con tu búsqueda.
                    @else
                        Comienza agregando tu primer contacto.
                    @endif
                </p>
                <a href="{{ route('contactos.create') }}" class="btn btn-success">
                    <i class="fas fa-plus me-2"></i>Crear Primer Contacto
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@section('styles')
<style>
    .avatar-circle {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 14px;
    }
    
    .btn-group .btn {
        margin: 0 1px;
    }
    
    .table tbody tr:hover .btn-group {
        opacity: 1;
    }
    
    .card-header {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        border-bottom: 1px solid rgba(102, 126, 234, 0.2);
    }
</style>
@endsection

@section('scripts')
<script>
    function confirmarEliminacion(id) {
        if (confirm('¿Estás seguro de que deseas eliminar este contacto? Esta acción no se puede deshacer.')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
    
    // Auto-submit del formulario de búsqueda con delay
    let searchTimeout;
    $('input[name="buscar"]').on('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            // Opcional: auto-submit después de 2 segundos de inactividad
            // $('form').submit();
        }, 2000);
    });
</script>
@endsection

