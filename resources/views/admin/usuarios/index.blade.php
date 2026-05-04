@extends('layouts.dashboard')

@section('title', 'Gestión de Usuarios')

@section('sidebar_menu')
    @include('layouts.partials.sidebar_admin')
@endsection

@section('content_header')
    Resumen de usuarios
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h1 class="h4">Panel de gestión de usuarios</h1>
            <p class="text-muted mb-0">Desde aquí podrás acceder a la administración de administradores, docentes y estudiantes.</p>
        </div>
    </div>
@endsection
