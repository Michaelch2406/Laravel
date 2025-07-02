@extends('layouts.app')

@section('title', 'Registro de Usuario')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card mt-5"> {{-- Clases simplificadas --}}
                <div class="card-header">
                    <h3 class="text-center fw-normal my-3">Crear Cuenta</h3> {{-- Ajuste de peso y margen --}}
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-floating mb-3">
                            <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Nombre Completo" required autofocus />
                            <label for="name">Nombre Completo</label>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" required />
                            <label for="email">Correo Electrónico</label>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control @error('password') is-invalid @enderror" id="password" type="password" name="password" placeholder="Contraseña" required />
                                    <label for="password">Contraseña</label>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="password_confirmation" type="password" name="password_confirmation" placeholder="Confirmar contraseña" required />
                                    <label for="password_confirmation">Confirmar Contraseña</label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 mb-0">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-block">Crear Cuenta</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center py-3">
                    <div class="small"><a href="{{ route('login') }}">¿Ya tienes una cuenta? Ir al login</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
