@extends('layouts.dashboard')

@section('title', 'Editar Estudiante')

@section('content_header')
    <h1>Editar Estudiante</h1>
@stop

@section('sidebar_menu')
    @include('layouts.partials.sidebar_admin')
@stop

@section('content')
    

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Formulario de Edición de Estudiante</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.estudiantes.update', $estudiante->id) }}" method="POST">
                @csrf
                @method('PUT')

                @include('components.forms.user-fields', ['user' => $estudiante, 'emailPrefix' => 'lpze', 'showPassword' => false])

                <div class="form-group">
                    <label for="role">Rol:</label>
                    <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                        <option value="{{ $currentRole }}" selected>{{ ucfirst($currentRole) }} (Actual)</option>
                        @foreach ($allowedRoles as $roleName => $roleLabel)
                            @if ($roleName !== $currentRole)
                                <option value="{{ $roleName }}">
                                    {{ ucfirst($roleName) }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                    @error('role')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                {{-- Campos de contraseña eliminados de la edición directa por seguridad --}}
                {{--
                <div class="form-group">
                    <label for="password">Nueva Contraseña (dejar en blanco para no cambiar):</label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                    @error('password')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                    <div id="password-requirements" class="mt-2">
                        <p class="mb-1" id="length-check"><i class="fas fa-times-circle text-danger"></i> Mínimo 8 caracteres</p>
                        <p class="mb-1" id="uppercase-check"><i class="fas fa-times-circle text-danger"></i> Al menos una mayúscula</p>
                        <p class="mb-1" id="lowercase-check"><i class="fas fa-times-circle text-danger"></i> Al menos una minúscula</p>
                        <p class="mb-1" id="number-check"><i class="fas fa-times-circle text-danger"></i> Al menos un número</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmar Nueva Contraseña:</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                    <span id="password-match-feedback" class="invalid-feedback" role="alert" style="display: none;"><strong>Las contraseñas no coinciden.</strong></span>
                </div>
                --}}

                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Actualizar Estudiante</button>
                <a href="{{ route('admin.estudiantes.index') }}" class="btn btn-secondary"><i class="fas fa-ban"></i> Cancelar</a>
            </form>
        </div>
    </div>
@stop

@section('js')
    @include('components.scripts.email-validation', ['emailPrefix' => 'lpze'])
@stop
