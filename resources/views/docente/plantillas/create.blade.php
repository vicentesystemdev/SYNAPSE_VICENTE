@extends('layouts.dashboard')

@section('title', 'Nueva plantilla')

@section('sidebar_menu')
    @include('layouts.partials.sidebar_docente')
@endsection

@section('content_header')
    Crear plantilla
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h1 class="h4">Formulario pendiente</h1>
            <p class="text-muted">Diseña aquí el formulario para componer nuevas plantillas docentes.</p>
        </div>
    </div>
@endsection
