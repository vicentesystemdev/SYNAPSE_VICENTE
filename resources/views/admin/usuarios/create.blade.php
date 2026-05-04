@extends('layouts.dashboard')

@section('title', 'Registrar usuario')

@section('sidebar_menu')
    @include('layouts.partials.sidebar_admin')
@endsection

@section('content_header')
    Crear usuario
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h1 class="h4">Formulario pendiente</h1>
            <p class="text-muted">Utiliza esta plantilla para construir el flujo de alta de usuarios.</p>
        </div>
    </div>
@endsection
