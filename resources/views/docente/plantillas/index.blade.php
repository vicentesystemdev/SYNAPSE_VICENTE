@extends('layouts.dashboard')

@section('title', 'Plantillas docentes')

@section('sidebar_menu')
    @include('layouts.partials.sidebar_docente')
@endsection

@section('content_header')
    Listado de plantillas
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h1 class="h4">Gestiona tus plantillas</h1>
            <p class="text-muted">Espacio reservado para listar las plantillas disponibles.</p>
        </div>
    </div>
@endsection
