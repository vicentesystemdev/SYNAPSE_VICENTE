@extends('layouts.dashboard')

@section('title', 'Detalle de Estudiante')

@section('content_header')
    <h1>Detalle de Estudiante</h1>
@stop

@section('sidebar_menu')
    @include('layouts.partials.sidebar_admin')
@stop

@section('content')
    <button onclick="window.history.back()" class="btn btn-secondary mb-4"><i class="fas fa-arrow-left"></i> Atrás</button>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Información del Estudiante</h3>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="id">ID:</label>
                <input type="text" class="form-control" value="{{ $estudiante->id }}" readonly>
            </div>

            <div class="form-group">
                <label for="name">Nombre:</label>
                <input type="text" class="form-control" value="{{ $estudiante->name }}" readonly>
            </div>

            <div class="form-group">
                <label for="app_usu">Apellido Paterno:</label>
                <input type="text" class="form-control" value="{{ $estudiante->app_usu }}" readonly>
            </div>

            <div class="form-group">
                <label for="apm_usu">Apellido Materno:</label>
                <input type="text" class="form-control" value="{{ $estudiante->apm_usu }}" readonly>
            </div>

            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" class="form-control" value="{{ $estudiante->email }}" readonly>
            </div>

            <div class="form-group">
                <label>Estado:</label>
                <input type="text" class="form-control" value="{{ $estudiante->activo_usu ? 'Activo' : 'Inactivo' }}" readonly>
            </div>

            <a href="{{ route('admin.estudiantes.edit', $estudiante->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i> Editar</a>
            <a href="{{ route('admin.estudiantes.index') }}" class="btn btn-secondary"><i class="fas fa-list"></i> Volver a la Lista</a>
        </div>
    </div>
@stop
