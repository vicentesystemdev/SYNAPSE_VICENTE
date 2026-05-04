@extends('layouts.dashboard')

@section('title', 'Configuración del sistema')

@section('sidebar_menu')
    @include('layouts.partials.sidebar_admin')
@endsection

@section('content_header')
    Configuración general
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h1 class="h4">Categorías y dificultades</h1>
            <p class="text-muted">Esta pantalla será utilizada para administrar los catálogos principales.</p>
        </div>
    </div>
@endsection
