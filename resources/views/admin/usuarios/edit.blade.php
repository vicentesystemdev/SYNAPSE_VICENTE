@extends('layouts.dashboard')

@section('title', 'Editar usuario')

@section('sidebar_menu')
    @include('layouts.partials.sidebar_admin')
@endsection

@section('content_header')
    Editar usuario
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h1 class="h4">Formulario pendiente</h1>
            <p class="text-muted">Configura aquí los campos necesarios para actualizar la información del usuario.</p>
        </div>
    </div>
@endsection
