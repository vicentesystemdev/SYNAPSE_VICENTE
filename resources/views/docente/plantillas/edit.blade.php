@extends('layouts.dashboard')

@section('title', 'Editar plantilla')

@section('sidebar_menu')
    @include('layouts.partials.sidebar_docente')
@endsection

@section('content_header')
    Editar plantilla
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h1 class="h4">Configuración pendiente</h1>
            <p class="text-muted">Prepara aquí el formulario para ajustar una plantilla existente.</p>
        </div>
    </div>
@endsection
