@extends('layouts.dashboard')

@section('title', 'Ver Estudiante')

@section('content_header')
    <h1>Detalles del Estudiante</h1>
@stop

@section('sidebar_menu')
    @include('layouts.partials.sidebar_docente')
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $estudiante->name }} {{ $estudiante->app_usu }} {{ $estudiante->apm_usu }}</h3>
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $estudiante->id }}</p>
            <p><strong>Nombre Completo:</strong> {{ $estudiante->name }} {{ $estudiante->app_usu }} {{ $estudiante->apm_usu }}</p>
            <p><strong>Email:</strong> {{ $estudiante->email }}</p>
            <p><strong>Rol:</strong> {{ ucfirst($estudiante->getRoleNames()->first()) }}</p>
            <p><strong>Estado:</strong>
                @if($estudiante->activo_usu)
                    <span class="badge bg-success">Activo</span>
                @else
                    <span class="badge bg-danger">Inactivo</span>
                @endif
            </p>
            <p><strong>Miembro desde:</strong> {{ $estudiante->created_at->format('d/m/Y H:i') }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('docente.estudiantes.index') }}" class="btn btn-secondary">Volver a la Lista</a>
            <a href="{{ route('docente.estudiantes.edit', $estudiante->id) }}" class="btn btn-primary">Editar Estudiante</a>
        </div>
    </div>
@stop
