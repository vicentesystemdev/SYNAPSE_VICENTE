@extends('layouts.dashboard')

@section('title', 'Editar Docente')

@section('content_header')
    <h1>Editar Docente</h1>
@stop

@section('sidebar_menu')
    @include('layouts.partials.sidebar_admin')
@stop

@section('content')
    

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Formulario de Edición de Docente</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.docentes.update', $docente->id) }}" method="POST">
                @csrf
                @method('PUT')

                @include('components.forms.user-fields', ['user' => $docente, 'emailPrefix' => 'doc', 'showPassword' => false, 'requiredApp' => false])

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

                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Actualizar Docente</button>
                <a href="{{ route('admin.docentes.index') }}" class="btn btn-secondary"><i class="fas fa-ban"></i> Cancelar</a>
            </form>
        </div>
    </div>
@stop

@section('js')
    @include('components.scripts.email-validation', ['emailPrefix' => 'doc'])
@stop
