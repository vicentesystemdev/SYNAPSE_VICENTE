@extends('layouts.dashboard')

@section('title', 'Detalle de usuario')

@section('sidebar_menu')
    @include('layouts.partials.sidebar_admin')
@endsection

@section('content_header')
    Detalle del usuario
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h1 class="h4">Información del usuario</h1>
            <p class="text-muted">Utiliza esta pantalla para mostrar todos los datos relevantes del registro seleccionado.</p>
        </div>
    </div>
@endsection
