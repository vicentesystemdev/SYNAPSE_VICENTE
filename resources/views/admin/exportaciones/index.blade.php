@extends('layouts.dashboard')

@section('title', 'Exportaciones')

@section('sidebar_menu')
    @include('layouts.partials.sidebar_admin')
@endsection

@section('content_header')
    Exportaciones CSV / PDF
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h1 class="h4">Opciones de exportación</h1>
            <p class="text-muted">Implementa las herramientas de descarga para los datos del sistema.</p>
        </div>
    </div>
@endsection
